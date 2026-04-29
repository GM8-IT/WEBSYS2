@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold">Borrowing History</h1>
        <p class="mt-1 text-gray-400">View your borrowed and returned books.</p>
    </div>

    <div class="overflow-hidden rounded-2xl border border-white/10 bg-white/10 backdrop-blur-xl">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-white/10 text-gray-400">
                <tr>
                    <th class="px-4 py-3">Book</th>
                    <th class="px-4 py-3">Borrowed</th>
                    <th class="px-4 py-3">Due</th>
                    <th class="px-4 py-3">Returned</th>
                    <th class="px-4 py-3">Fine</th>
                    <th class="px-4 py-3">Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse($borrowings as $borrowing)
                    @php
                        $isOverdue = $borrowing->status === 'active' && $borrowing->due_at->isPast();
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

                        <td class="px-4 py-4 text-gray-300">
                            {{ $borrowing->returned_at ? $borrowing->returned_at->format('M d, Y') : 'Not returned' }}
                        </td>

                        <td class="px-4 py-4 text-gray-300">
                            ₱{{ number_format($borrowing->fine_amount, 2) }}
                        </td>

                        <td class="px-4 py-4">
                            <span class="rounded-full border border-white/10 px-3 py-1 text-xs capitalize
                                @if($borrowing->status === 'returned') text-green-300
                                @elseif($isOverdue) text-red-300
                                @else text-yellow-300
                                @endif">
                                {{ $isOverdue ? 'overdue' : $borrowing->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-400">
                            No borrowing history found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $borrowings->links() }}
</div>
@endsection