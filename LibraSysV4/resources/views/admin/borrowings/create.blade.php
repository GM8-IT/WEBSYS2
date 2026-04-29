@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-3xl">
    <div class="mb-8">
        <h1 class="text-3xl font-bold">New Borrowing</h1>
        <p class="mt-1 text-gray-400">Record a book borrowing transaction.</p>
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
          action="{{ route('admin.borrowings.store') }}"
          class="space-y-5 rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-xl">
        @csrf

        <div>
            <label class="mb-2 block text-sm text-gray-300">Member</label>
            <select name="user_id"
                    required
                    class="w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-white outline-none focus:border-white/40">
                <option value="">Select Member</option>
                @foreach($members as $member)
                    <option value="{{ $member->id }}" @selected(old('user_id') == $member->id)>
                        {{ $member->name }} — {{ $member->email }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-2 block text-sm text-gray-300">Available Book Copy</label>
            <select name="book_copy_id"
                    required
                    class="w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-white outline-none focus:border-white/40">
                <option value="">Select Book Copy</option>
                @foreach($availableCopies as $copy)
                    <option value="{{ $copy->id }}" @selected(old('book_copy_id') == $copy->id)>
                        {{ $copy->book->title }} — {{ $copy->accession_number }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-2 block text-sm text-gray-300">Due Date</label>
            <input type="date"
                   name="due_at"
                   value="{{ old('due_at', now()->addDays(7)->toDateString()) }}"
                   required
                   class="w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-white outline-none focus:border-white/40">
        </div>

        <div class="rounded-2xl border border-white/10 bg-black/30 p-4 text-sm text-gray-400">
            Default borrowing period is 7 days. Fine will be calculated when the book is returned.
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.borrowings.index') }}"
               class="rounded-xl border border-white/10 px-5 py-3 text-gray-300 hover:bg-white/10">
                Cancel
            </a>

            <button class="rounded-xl bg-white px-5 py-3 font-semibold text-black hover:bg-gray-200">
                Save Borrowing
            </button>
        </div>
    </form>
</div>
@endsection