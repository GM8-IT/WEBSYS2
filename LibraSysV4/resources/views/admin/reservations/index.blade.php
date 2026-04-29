@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold">Reservations</h1>
        <p class="mt-1 text-gray-400">Manage member book reservations.</p>
    </div>

    @if(session('success'))
        <div class="rounded-xl border border-green-500/30 bg-green-500/10 p-4 text-green-300">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-2xl border border-white/10 bg-white/10 backdrop-blur-xl">
        <table class="w-full text-left text-sm">
            <thead class="border-b border-white/10 text-gray-400">
                <tr>
                    <th class="px-4 py-3">Member</th>
                    <th class="px-4 py-3">Book</th>
                    <th class="px-4 py-3">Reserved At</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($reservations as $reservation)
                    <tr class="border-b border-white/10">
                        <td class="px-4 py-4">
                            <div class="font-semibold">{{ $reservation->user->name }}</div>
                            <div class="text-gray-400">{{ $reservation->user->email }}</div>
                        </td>

                        <td class="px-4 py-4">
                            <div class="font-semibold">{{ $reservation->book->title }}</div>
                            <div class="text-gray-400">{{ $reservation->book->author }}</div>
                        </td>

                        <td class="px-4 py-4 text-gray-300">
                            {{ $reservation->reserved_at?->format('M d, Y h:i A') ?? 'N/A' }}
                        </td>

                        <td class="px-4 py-4">
                            <span class="rounded-full border border-white/10 px-3 py-1 text-xs capitalize
                                @if($reservation->status === 'pending') text-yellow-300
                                @elseif($reservation->status === 'available') text-blue-300
                                @elseif($reservation->status === 'claimed') text-green-300
                                @else text-red-300
                                @endif">
                                {{ $reservation->status }}
                            </span>
                        </td>

                        <td class="px-4 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                @if($reservation->status === 'available')
                                    <form method="POST" action="{{ route('admin.reservations.claimed', $reservation) }}">
                                        @csrf
                                        @method('PATCH')

                                        <button class="rounded-lg border border-green-500/30 px-3 py-2 text-green-300 hover:bg-green-500/10">
                                            Mark Claimed
                                        </button>
                                    </form>
                                @endif

                                <form method="POST" action="{{ route('admin.reservations.destroy', $reservation) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Delete this reservation?')"
                                            class="rounded-lg border border-red-500/30 px-3 py-2 text-red-300 hover:bg-red-500/10">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-400">
                            No reservations found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $reservations->links() }}
</div>
@endsection