@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-3xl font-bold">Borrowings</h1>
            <p class="mt-1 text-gray-400">Track borrowed and returned books.</p>
        </div>

        <a href="{{ route('admin.borrowings.create') }}"
            class="rounded-xl bg-white px-5 py-3 font-semibold text-black hover:bg-gray-200">
            New Borrowing
        </a>
    </div>

    @if(session('success'))
    <div class="rounded-xl border border-green-500/30 bg-green-500/10 p-4 text-green-300">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="rounded-xl border border-red-500/30 bg-red-500/10 p-4 text-red-300">
        {{ session('error') }}
    </div>
    @endif

    <form method="GET" class="grid gap-4 rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur-xl md:grid-cols-4">
        <input type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search member or book..."
            class="rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-white outline-none focus:border-white/40 md:col-span-2">

        <select name="status"
            class="rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-white outline-none focus:border-white/40">
            <option value="">All Status</option>
            <option value="active" @selected(request('status')==='active' )>Active</option>
            <option value="returned" @selected(request('status')==='returned' )>Returned</option>
            <option value="overdue" @selected(request('status')==='overdue' )>Overdue</option>
        </select>

        <button class="rounded-xl bg-white px-4 py-3 font-semibold text-black hover:bg-gray-200">
            Filter
        </button>
    </form>

    <div class="overflow-hidden rounded-2xl border border-white/10 bg-white/10 backdrop-blur-xl">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-white/10 text-gray-400">
                <tr>
                    <th class="px-4 py-3">Member</th>
                    <th class="px-4 py-3">Book</th>
                    <th class="px-4 py-3">Borrowed</th>
                    <th class="px-4 py-3">Due</th>
                    <th class="px-4 py-3">Returned</th>
                    <th class="px-4 py-3">Fine</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($borrowings as $borrowing)
                @php
                $isOverdue = $borrowing->status === 'active' && $borrowing->due_at->isPast();
                @endphp

                <tr class="border-b border-white/10">
                    <td class="px-4 py-4">
                        <div class="font-semibold text-white">{{ $borrowing->user->name }}</div>
                        <div class="text-gray-400">{{ $borrowing->user->email }}</div>
                    </td>

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
                        <div>Fine: ₱{{ number_format($borrowing->fine_amount, 2) }}</div>
                        <div class="text-xs text-gray-500">
                            Paid: ₱{{ number_format($borrowing->paid_amount, 2) }}
                        </div>
                        <div class="text-xs text-gray-500">
                            Balance: ₱{{ number_format($borrowing->fine_balance, 2) }}
                        </div>
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

                    <td class="px-4 py-4 text-right">
                        <div class="space-y-2">
                            @if($borrowing->status !== 'returned')
                            <form method="POST" action="{{ route('admin.borrowings.return', $borrowing) }}">
                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                    onclick="return confirm('Mark this book as returned?')"
                                    class="rounded-lg border border-green-500/30 px-3 py-2 text-green-300 hover:bg-green-500/10">
                                    Return
                                </button>
                            </form>
                            @else
                            <span class="text-gray-500">Returned</span>
                            @endif

                            @if($borrowing->fine_amount > 0 && $borrowing->fine_balance > 0)
                            <form method="POST"
                                action="{{ route('admin.borrowings.payments.store', $borrowing) }}"
                                class="flex justify-end gap-2">
                                @csrf

                                <input type="number"
                                    name="amount_paid"
                                    min="1"
                                    max="{{ $borrowing->fine_balance }}"
                                    step="0.01"
                                    placeholder="₱{{ number_format($borrowing->fine_balance, 2) }}"
                                    class="w-28 rounded-lg border border-white/10 bg-black/40 px-3 py-2 text-white">

                                <input type="hidden" name="payment_method" value="Cash">

                                <button class="rounded-lg border border-white/10 px-3 py-2 text-gray-300 hover:bg-white/10">
                                    Pay
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-4 py-8 text-center text-gray-400">
                        No borrowing records found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $borrowings->links() }}
</div>
@endsection