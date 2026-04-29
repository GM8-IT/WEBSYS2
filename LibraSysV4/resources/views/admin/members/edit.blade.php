@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-3xl">
    <div class="mb-8">
        <h1 class="text-3xl font-bold">Edit Member</h1>
        <p class="mt-1 text-gray-400">Update member profile and account details.</p>
    </div>

    @if($errors->any())
        <div class="mb-6 rounded-xl border border-red-500/30 bg-red-500/10 p-4 text-red-300">
            <ul class="list-inside list-disc">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ route('admin.members.update', $member) }}"
          class="space-y-5 rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-xl">
        @csrf
        @method('PUT')

        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm text-gray-300">Full Name</label>
                <input type="text"
                       name="name"
                       value="{{ old('name', $member->name) }}"
                       required
                       class="w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-white outline-none focus:border-white/40">
            </div>

            <div>
                <label class="mb-2 block text-sm text-gray-300">Email</label>
                <input type="email"
                       name="email"
                       value="{{ old('email', $member->email) }}"
                       required
                       class="w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-white outline-none focus:border-white/40">
            </div>
        </div>

        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm text-gray-300">New Password</label>
                <input type="password"
                       name="password"
                       placeholder="Leave blank to keep current password"
                       class="w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-white outline-none focus:border-white/40">
            </div>

            <div>
                <label class="mb-2 block text-sm text-gray-300">Student ID</label>
                <input type="text"
                       name="student_id"
                       value="{{ old('student_id', $member->profile->student_id ?? '') }}"
                       required
                       class="w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-white outline-none focus:border-white/40">
            </div>
        </div>

        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label class="mb-2 block text-sm text-gray-300">Course</label>
                <input type="text"
                       name="course"
                       value="{{ old('course', $member->profile->course ?? '') }}"
                       class="w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-white outline-none focus:border-white/40">
            </div>

            <div>
                <label class="mb-2 block text-sm text-gray-300">Year Level</label>
                <input type="text"
                       name="year_level"
                       value="{{ old('year_level', $member->profile->year_level ?? '') }}"
                       class="w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-white outline-none focus:border-white/40">
            </div>
        </div>

        <div>
            <label class="mb-2 block text-sm text-gray-300">Phone</label>
            <input type="text"
                   name="phone"
                   value="{{ old('phone', $member->profile->phone ?? '') }}"
                   class="w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-white outline-none focus:border-white/40">
        </div>

        <div>
            <label class="mb-2 block text-sm text-gray-300">Address</label>
            <textarea name="address"
                      rows="3"
                      class="w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-white outline-none focus:border-white/40">{{ old('address', $member->profile->address ?? '') }}</textarea>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.members.index') }}"
               class="rounded-xl border border-white/10 px-5 py-3 text-gray-300 hover:bg-white/10">
                Cancel
            </a>

            <button class="rounded-xl bg-white px-5 py-3 font-semibold text-black hover:bg-gray-200">
                Update Member
            </button>
        </div>
    </form>
</div>
@endsection