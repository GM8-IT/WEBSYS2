@extends('layouts.app')

@section('content')
@php
$activeBorrowings = \App\Models\Borrowing::with('bookCopy.book')
->where('user_id', auth()->id())
->where('status', 'active')
->latest()
->get();

$returnedBorrowings = \App\Models\Borrowing::where('user_id', auth()->id())
->where('status', 'returned')
->count();

$overdueBorrowings = $activeBorrowings->filter(fn ($borrowing) => $borrowing->due_at->isPast());
@endphp


<div>
    <h1 class="text-3xl font-bold">Member Dashboard</h1>
    <p class="mt-1 text-gray-400">Welcome back, {{ auth()->user()->name }}.</p>
</div>

<div class="grid gap-6 md:grid-cols-3">
    <div class="rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-xl">
        <p class="text-sm text-gray-400">Active Borrowings</p>
        <h2 class="mt-3 text-3xl font-bold">{{ $activeBorrowings->count() }}</h2>
    </div>

    <div class="rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-xl">
        <p class="text-sm text-gray-400">Returned Books</p>
        <h2 class="mt-3 text-3xl font-bold text-green-300">{{ $returnedBorrowings }}</h2>
    </div>

    <div class="rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-xl">
        <p class="text-sm text-gray-400">Overdue Books</p>
        <h2 class="mt-3 text-3xl font-bold text-red-300">{{ $overdueBorrowings->count() }}</h2>
    </div>
</div>

<div style="margin:15px 0px;">
<div class="rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-xl">
    <h2 class="mb-5 text-xl font-bold">Notifications</h2>

    <div class="space-y-3">
        @forelse(auth()->user()->notifications()->latest()->take(5)->get() as $notification)
        <div class="rounded-2xl border border-white/10 bg-black/30 p-4">
            <p class="font-semibold">
                {{ $notification->data['title'] ?? 'Notification' }}
            </p>

            <p class="mt-1 text-sm text-gray-400">
                {{ $notification->data['message'] ?? '' }}
            </p>

            <p class="mt-2 text-xs text-gray-500">
                {{ $notification->created_at->diffForHumans() }}
            </p>
        </div>
        @empty
        <p class="text-gray-400">No notifications yet.</p>
        @endforelse
    </div>
</div>
</div>
<div class="rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-xl">
    <div class="mb-5 flex items-center justify-between">
        <h2 class="text-xl font-bold">Current Borrowings</h2>

        <a href="{{ route('member.history') }}"
            class="text-sm text-gray-300 hover:text-white">
            View History
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-white/10">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-white/10 text-gray-400">
                <tr>
                    <th class="px-4 py-3">Book</th>
                    <th class="px-4 py-3">Borrowed</th>
                    <th class="px-4 py-3">Due</th>
                    <th class="px-4 py-3">Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse($activeBorrowings as $borrowing)
                @php
                $isOverdue = $borrowing->due_at->isPast();
                @endphp

                <tr class="border-b border-white/10">
                    <td class="px-4 py-4">
                        <div class="font-semibold text-white">
                            {{ $borrowing->bookCopy->book->title }}
                        </div>
                        <div class="text-gray-400">
                            {{ $borrowing->bookCopy->accession_number }}
                        </div>
                    </td>

                    <td class="px-4 py-4 text-gray-300">
                        {{ $borrowing->borrowed_at->format('M d, Y') }}
                    </td>

                    <td class="px-4 py-4 {{ $isOverdue ? 'text-red-300' : 'text-gray-300' }}">
                        {{ $borrowing->due_at->format('M d, Y') }}
                    </td>

                    <td class="px-4 py-4">
                        <span class="rounded-full border border-white/10 px-3 py-1 text-xs {{ $isOverdue ? 'text-red-300' : 'text-yellow-300' }}">
                            {{ $isOverdue ? 'Overdue' : 'Active' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-8 text-center text-gray-400">
                        You have no active borrowings.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection