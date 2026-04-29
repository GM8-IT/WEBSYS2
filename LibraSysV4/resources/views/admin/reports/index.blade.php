@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-bold">Reports</h1>
        <p class="mt-1 text-gray-400">View library activity reports.</p>
    </div>
    <div class="flex flex-wrap gap-3">
        <a href="{{ route('admin.reports.borrowings.export') }}"
            class="rounded-xl bg-white px-5 py-3 font-semibold text-black hover:bg-gray-200">
            Export Borrowings Excel
        </a>

        <a href="{{ route('admin.reports.members.export') }}"
            class="rounded-xl border border-white/10 px-5 py-3 text-gray-300 hover:bg-white/10">
            Export Members Excel
        </a>
    </div>

    <div class="grid gap-6 md:grid-cols-4">
        <div class="rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-xl">
            <p class="text-sm text-gray-400">Borrowed Books</p>
            <h2 class="mt-3 text-3xl font-bold">{{ $borrowedBooks->count() }}</h2>
        </div>

        <div class="rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-xl">
            <p class="text-sm text-gray-400">Overdue Books</p>
            <h2 class="mt-3 text-3xl font-bold text-red-300">{{ $overdueBooks->count() }}</h2>
        </div>

        <div class="rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-xl">
            <p class="text-sm text-gray-400">Available Copies</p>
            <h2 class="mt-3 text-3xl font-bold text-green-300">{{ $availableBooks->count() }}</h2>
        </div>

        <div class="rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-xl">
            <p class="text-sm text-gray-400">Members</p>
            <h2 class="mt-3 text-3xl font-bold">{{ $members->count() }}</h2>
        </div>
    </div>

    <section class="rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-xl">
        <h2 class="mb-5 text-xl font-bold">Borrowed Books</h2>

        <div class="overflow-hidden rounded-2xl border border-white/10">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-white/10 text-gray-400">
                    <tr>
                        <th class="px-4 py-3">Book</th>
                        <th class="px-4 py-3">Member</th>
                        <th class="px-4 py-3">Borrowed</th>
                        <th class="px-4 py-3">Due</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($borrowedBooks as $borrowing)
                    <tr class="border-b border-white/10">
                        <td class="px-4 py-4">
                            {{ $borrowing->bookCopy->book->title }}
                        </td>
                        <td class="px-4 py-4 text-gray-300">
                            {{ $borrowing->user->name }}
                        </td>
                        <td class="px-4 py-4 text-gray-400">
                            {{ $borrowing->borrowed_at->format('M d, Y') }}
                        </td>
                        <td class="px-4 py-4 text-gray-400">
                            {{ $borrowing->due_at->format('M d, Y') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-gray-400">
                            No borrowed books.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-xl">
        <h2 class="mb-5 text-xl font-bold">Overdue Books</h2>

        <div class="overflow-hidden rounded-2xl border border-white/10">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-white/10 text-gray-400">
                    <tr>
                        <th class="px-4 py-3">Book</th>
                        <th class="px-4 py-3">Member</th>
                        <th class="px-4 py-3">Due Date</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($overdueBooks as $borrowing)
                    <tr class="border-b border-white/10">
                        <td class="px-4 py-4">
                            {{ $borrowing->bookCopy->book->title }}
                        </td>
                        <td class="px-4 py-4 text-gray-300">
                            {{ $borrowing->user->name }}
                        </td>
                        <td class="px-4 py-4 text-red-300">
                            {{ $borrowing->due_at->format('M d, Y') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-4 py-8 text-center text-gray-400">
                            No overdue books.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur-xl">
        <h2 class="mb-5 text-xl font-bold">Available Books</h2>

        <div class="overflow-hidden rounded-2xl border border-white/10">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-white/10 text-gray-400">
                    <tr>
                        <th class="px-4 py-3">Book</th>
                        <th class="px-4 py-3">Accession Number</th>
                        <th class="px-4 py-3">Barcode</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($availableBooks as $copy)
                    <tr class="border-b border-white/10">
                        <td class="px-4 py-4">
                            {{ $copy->book->title }}
                        </td>
                        <td class="px-4 py-4 text-gray-300">
                            {{ $copy->accession_number }}
                        </td>
                        <td class="px-4 py-4 text-gray-400">
                            {{ $copy->barcode }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-4 py-8 text-center text-gray-400">
                            No available books.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection