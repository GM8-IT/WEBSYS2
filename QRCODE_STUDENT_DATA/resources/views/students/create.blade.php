@extends('layouts.app')

@section('content')
<div class="page-header text-center">
    <div class="eyebrow">Create Record</div>
    <h1 class="page-title">Add Student</h1>
    <p class="page-description mx-auto">
        Enter student information. After saving, the system will generate a QR code for the student data.
    </p>
</div>

<div class="glass-panel form-card">
    <form action="{{ route('students.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6 field-group">
                <label class="modern-label">Student ID</label>
                <input type="text" name="student_id" class="modern-input" value="{{ old('student_id') }}" required>
                @error('student_id') <div class="error-text">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 field-group">
                <label class="modern-label">Course</label>
                <input type="text" name="course" class="modern-input" value="{{ old('course') }}" required>
                @error('course') <div class="error-text">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 field-group">
                <label class="modern-label">First Name</label>
                <input type="text" name="first_name" class="modern-input" value="{{ old('first_name') }}" required>
                @error('first_name') <div class="error-text">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 field-group">
                <label class="modern-label">Last Name</label>
                <input type="text" name="last_name" class="modern-input" value="{{ old('last_name') }}" required>
                @error('last_name') <div class="error-text">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 field-group">
                <label class="modern-label">Year Level</label>
                <input type="number" name="year_level" class="modern-input" value="{{ old('year_level') }}" required>
                @error('year_level') <div class="error-text">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 field-group">
                <label class="modern-label">Section</label>
                <input type="text" name="section" class="modern-input" value="{{ old('section') }}" required>
                @error('section') <div class="error-text">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 field-group">
                <label class="modern-label">Email</label>
                <input type="email" name="email" class="modern-input" value="{{ old('email') }}">
                @error('email') <div class="error-text">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 field-group">
                <label class="modern-label">Contact Number</label>
                <input type="text" name="contact_number" class="modern-input" value="{{ old('contact_number') }}">
                @error('contact_number') <div class="error-text">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="field-group">
            <label class="modern-label">Address</label>
            <textarea name="address" class="modern-textarea" rows="4">{{ old('address') }}</textarea>
            @error('address') <div class="error-text">{{ $message }}</div> @enderror
        </div>

        <div class="d-flex gap-2 justify-content-end flex-wrap mt-4">
            <a href="{{ route('students.index') }}" class="modern-btn">
                Back
            </a>

            <button type="submit" class="modern-btn primary">
                Save Student
            </button>
        </div>
    </form>
</div>
@endsection