@extends('layouts.app')

@section('content')
<div>
    <div class="mb-8">
        <h1 class="text-3xl font-bold">Admin Dashboard</h1>
        <p class="mt-1 text-gray-400">Manage books, members, borrowings, and reports.</p>
    </div>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @php
            $cards = [
                ['label' => 'Total Books', 'value' => $totalBooks],
                ['label' => 'Total Copies', 'value' => $totalCopies],
                ['label' => 'Available Copies', 'value' => $availableCopies],
                ['label' => 'Borrowed Copies', 'value' => $borrowedCopies],
                ['label' => 'Overdue Books', 'value' => $overdueBooks],
                ['label' => 'Total Members', 'value' => $totalMembers],
                ['label' => 'Reservations', 'value' => $pendingReservations],
                ['label' => 'Total Fines', 'value' => '₱' . number_format($totalFines, 2)],
            ];
        @endphp

        @foreach($cards as $card)
            <div class="rounded-3xl border border-white/10 bg-white/10 p-6 shadow-xl backdrop-blur-xl">
                <p class="text-sm text-gray-400">{{ $card['label'] }}</p>
                <h2 class="mt-3 text-3xl font-bold">{{ $card['value'] }}</h2>
            </div>
        @endforeach
    </div>
</div>
@endsection