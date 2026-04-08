@extends('layouts.app')

@section('title','Register')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
  <div>
    <h2 class="text-xl font-semibold mb-4">Create your account</h2>
    <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
      @csrf
      <div>
        <label class="block text-sm font-medium">Student ID</label>
        <input name="student_id" value="{{ old('student_id') }}" class="mt-1 block w-full border rounded px-3 py-2" required>
      </div>
      <div>
        <label class="block text-sm font-medium">First name</label>
        <input name="first_name" value="{{ old('first_name') }}" class="mt-1 block w-full border rounded px-3 py-2" required>
      </div>
      <div>
        <label class="block text-sm font-medium">Middle name</label>
        <input name="middle_name" value="{{ old('middle_name') }}" class="mt-1 block w-full border rounded px-3 py-2">
      </div>
      <div>
        <label class="block text-sm font-medium">Last name</label>
        <input name="last_name" value="{{ old('last_name') }}" class="mt-1 block w-full border rounded px-3 py-2" required>
      </div>
      <div>
        <label class="block text-sm font-medium">Date of birth</label>
        <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="mt-1 block w-full border rounded px-3 py-2">
      </div>
      <div>
        <label class="block text-sm font-medium">Gender</label>
        <select name="gender" class="mt-1 block w-full border rounded px-3 py-2">
          <option value="">Select</option>
          <option value="male">Male</option>
          <option value="female">Female</option>
          <option value="other">Other</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="mt-1 block w-full border rounded px-3 py-2" required>
      </div>
      <div>
        <label class="block text-sm font-medium">Phone</label>
        <input name="phone" value="{{ old('phone') }}" class="mt-1 block w-full border rounded px-3 py-2">
      </div>
      <div>
        <label class="block text-sm font-medium">Address</label>
        <input name="address" value="{{ old('address') }}" class="mt-1 block w-full border rounded px-3 py-2">
      </div>
      <div>
        <label class="block text-sm font-medium">City</label>
        <input name="city" value="{{ old('city') }}" class="mt-1 block w-full border rounded px-3 py-2">
      </div>
      <div>
        <label class="block text-sm font-medium">Province</label>
        <input name="state" value="{{ old('state') }}" class="mt-1 block w-full border rounded px-3 py-2">
      </div>
      <div>
        <label class="block text-sm font-medium">Postal Code</label>
        <input name="postal_code" value="{{ old('postal_code') }}" class="mt-1 block w-full border rounded px-3 py-2">
      </div>
      <div>
        <label class="block text-sm font-medium">Program</label>
        <input name="program" value="{{ old('program') }}" class="mt-1 block w-full border rounded px-3 py-2">
      </div>

      <div>
        <label class="block text-sm font-medium">Password</label>
        <input type="password" name="password" class="mt-1 block w-full border rounded px-3 py-2" required>
      </div>
      <div>
        <label class="block text-sm font-medium">Confirm Password</label>
        <input type="password" name="password_confirmation" class="mt-1 block w-full border rounded px-3 py-2" required>
      </div>

      <div>
        <button class="w-full py-2 bg-blue-600 text-white rounded">Register</button>
      </div>
    </form>
  </div>

  <div class="bg-gray-50 p-4 rounded">
    <h3 class="font-semibold">Why create an account?</h3>
    <ul class="list-disc pl-5 mt-2 text-sm text-gray-700">
      <li>Manage your enrollment details</li>
      <li>Update your profile and contact info</li>
      <li>Secure access to student services</li>
    </ul>
    <div class="mt-6">
      <a href="{{ route('login') }}" class="text-blue-600">Already have an account? Sign in</a>
    </div>
  </div>
</div>
@endsection