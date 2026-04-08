<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\EventLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|string|unique:students,student_id|max:50',
            'first_name' => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'last_name'  => 'required|string|max:100',
            'date_of_birth' => 'nullable|date',
            'gender' => ['nullable', Rule::in(['male','female','other'])],
            'email' => 'required|email|unique:students,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'program' => 'nullable|string|max:150',
            'password' => 'required|string|min:8|confirmed'
        ]);

        $data['password'] = Hash::make($data['password']);
        $student = Student::create($data);

        EventLog::create([
            'user_id' => $student->id,
            'event_type' => 'registration',
            'description' => "New student registered: {$student->student_id} ({$student->email})",
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'path' => $request->path(),
            'method' => $request->method(),
        ]);

        Auth::login($student);

        return redirect()->route('profile')->with('success', 'Registration successful. Welcome!');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $creds = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if (Auth::attempt($creds, $request->boolean('remember'))) {
            $request->session()->regenerate();

            EventLog::create([
                'user_id' => Auth::id(),
                'event_type' => 'login',
                'description' => 'User logged in',
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'path' => $request->path(),
                'method' => $request->method(),
            ]);

            return redirect()->intended(route('profile'));
        }

        EventLog::create([
            'user_id' => null,
            'event_type' => 'login_failed',
            'description' => "Failed login attempt for {$request->input('email')}",
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'path' => $request->path(),
            'method' => $request->method(),
        ]);

        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        $userId = Auth::id();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        EventLog::create([
            'user_id' => $userId,
            'event_type' => 'logout',
            'description' => 'User logged out',
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'path' => $request->path(),
            'method' => $request->method(),
        ]);

        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }

    public function profile()
    {
        $student = Auth::user();
        return view('profile', compact('student'));
    }

    public function updateProfile(Request $request)
    {
        /** @var \App\Models\Student $student */
        $student = Auth::user();

        $data = $request->validate([
            'first_name' => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'last_name'  => 'required|string|max:100',
            'date_of_birth' => 'nullable|date',
            'gender' => ['nullable', Rule::in(['male','female','other'])],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'program' => 'nullable|string|max:150',
            'password' => 'nullable|string|min:8|confirmed'
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $student->update($data);

        EventLog::create([
            'user_id' => $student->id,
            'event_type' => 'profile_update',
            'description' => 'Profile updated',
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'path' => $request->path(),
            'method' => $request->method(),
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }
}