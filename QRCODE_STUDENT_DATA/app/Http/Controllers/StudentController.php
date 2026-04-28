<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $students = Student::query()
            ->when($search, function ($query, $search) {
                $query->where('student_id', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('course', 'like', "%{$search}%")
                    ->orWhere('section', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->get()
            ->map(function ($student) {
                $student->qr = QrCode::size(100)->generate($this->studentQrData($student));
                return $student;
            });

        return view('students.index', compact('students', 'search'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|unique:students,student_id',
            'first_name' => 'required',
            'last_name' => 'required',
            'course' => 'required',
            'year_level' => 'required|integer',
            'section' => 'required',
            'email' => 'nullable|email|unique:students,email',
            'contact_number' => 'nullable',
            'address' => 'nullable',
        ]);

        Student::create($validated);

        return redirect()
            ->route('students.index')
            ->with('success', 'Student created successfully.');
    }

    public function show(Student $student)
    {
        $qr = QrCode::size(220)->generate($this->studentQrData($student));

        return view('students.show', compact('student', 'qr'));
    }

    public function edit(Student $student)
    {
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'student_id' => [
                'required',
                Rule::unique('students', 'student_id')->ignore($student->id),
            ],
            'first_name' => 'required',
            'last_name' => 'required',
            'course' => 'required',
            'year_level' => 'required|integer',
            'section' => 'required',
            'email' => [
                'nullable',
                'email',
                Rule::unique('students', 'email')->ignore($student->id),
            ],
            'contact_number' => 'nullable',
            'address' => 'nullable',
        ]);

        $student->update($validated);

        return redirect()
            ->route('students.index')
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()
            ->route('students.index')
            ->with('success', 'Student deleted successfully.');
    }

    private function studentQrData(Student $student)
    {
        return json_encode([
            'id' => $student->id,
            'student_id' => $student->student_id,
            'first_name' => $student->first_name,
            'last_name' => $student->last_name,
            'course' => $student->course,
            'year_level' => $student->year_level,
            'section' => $student->section,
            'email' => $student->email,
            'contact_number' => $student->contact_number,
            'address' => $student->address,
        ], JSON_PRETTY_PRINT);
    }
}