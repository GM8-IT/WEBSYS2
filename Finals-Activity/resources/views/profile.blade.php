@extends('layouts.app')

@section('title','Profile')

@section('content')
<div class="max-w-3xl mx-auto">
  <h2 class="text-xl font-semibold mb-4">Profile</h2>

  <form action="{{ route('profile.update') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
    @csrf

    <div>
      <label class="block text-sm font-medium">Student ID</label>
      <input value="{{ $student->student_id }}" disabled class="mt-1 block w-full border rounded px-3 py-2 bg-gray-100">
    </div>

    <div>
      <label class="block text-sm font-medium">Email</label>
      <input value="{{ $student->email }}" disabled class="mt-1 block w-full border rounded px-3 py-2 bg-gray-100">
    </div>

    <div>
      <label class="block text-sm font-medium">First name</label>
      <input name="first_name" value="{{ old('first_name', $student->first_name) }}" class="mt-1 block w-full border rounded px-3 py-2" required>
    </div>
    <div>
      <label class="block text-sm font-medium">Middle name</label>
      <input name="middle_name" value="{{ old('middle_name', $student->middle_name) }}" class="mt-1 block w-full border rounded px-3 py-2">
    </div>
    <div>
      <label class="block text-sm font-medium">Last name</label>
      <input name="last_name" value="{{ old('last_name', $student->last_name) }}" class="mt-1 block w-full border rounded px-3 py-2" required>
    </div>
    <div>
      <label class="block text-sm font-medium">Date of birth</label>
      <input type="date" name="date_of_birth" value="{{ old('date_of_birth', optional($student->date_of_birth)->format('Y-m-d')) }}" class="mt-1 block w-full border rounded px-3 py-2">
    </div>

    <div>
      <label class="block text-sm font-medium">Gender</label>
      <select name="gender" class="mt-1 block w-full border rounded px-3 py-2">
        <option value="">Select</option>
        <option value="male" @if($student->gender==='male') selected @endif>Male</option>
        <option value="female" @if($student->gender==='female') selected @endif>Female</option>
        <option value="other" @if($student->gender==='other') selected @endif>Other</option>
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium">Phone</label>
      <input name="phone" value="{{ old('phone', $student->phone) }}" class="mt-1 block w-full border rounded px-3 py-2">
    </div>
    <div>
      <label class="block text-sm font-medium">Address</label>
      <input name="address" value="{{ old('address', $student->address) }}" class="mt-1 block w-full border rounded px-3 py-2">
    </div>

    <div>
      <label class="block text-sm font-medium">City</label>
      <input name="city" value="{{ old('city', $student->city) }}" class="mt-1 block w-full border rounded px-3 py-2">
    </div>
    <div>
      <label class="block text-sm font-medium">State</label>
      <input name="state" value="{{ old('state', $student->state) }}" class="mt-1 block w-full border rounded px-3 py-2">
    </div>

    <div>
      <label class="block text-sm font-medium">Postal Code</label>
      <input name="postal_code" value="{{ old('postal_code', $student->postal_code) }}" class="mt-1 block w-full border rounded px-3 py-2">
    </div>

    <div>
      <label class="block text-sm font-medium">Program</label>
      <input name="program" value="{{ old('program', $student->program) }}" class="mt-1 block w-full border rounded px-3 py-2">
    </div>

    <div class="md:col-span-2">
      <h3 class="font-semibold mt-4">Change password (optional)</h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
        <input type="password" name="password" placeholder="New password" class="block w-full border rounded px-3 py-2">
        <input type="password" name="password_confirmation" placeholder="Confirm new password" class="block w-full border rounded px-3 py-2">
      </div>
    </div>

    <div class="md:col-span-2">
      <button class="mt-4 px-4 py-2 bg-green-600 text-white rounded">Save changes</button>
    </div>
  </form>
</div>
@endsection