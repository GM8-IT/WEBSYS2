<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with('user', 'book')
            ->latest()
            ->paginate(10);

        return view('admin.reservations.index', compact('reservations'));
    }

    public function store(Book $book)
    {
        if (Auth::user()->role !== 'member') {
            abort(403);
        }

        $availableCopies = $book->copies()
            ->where('status', 'available')
            ->count();

        if ($availableCopies > 0) {
            return back()->with('error', 'This book is currently available. No reservation needed.');
        }

        $existing = Reservation::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->whereIn('status', ['pending', 'available'])
            ->first();

        if ($existing) {
            return back()->with('error', 'You already have an active reservation for this book.');
        }

        Reservation::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'status' => 'pending',
            'reserved_at' => now(),
        ]);

        return back()->with('success', 'Book reserved successfully.');
    }

    public function markClaimed(Reservation $reservation)
    {
        $reservation->update([
            'status' => 'claimed',
        ]);

        return back()->with('success', 'Reservation marked as claimed.');
    }

    public function cancel(Reservation $reservation)
    {
        if (Auth::user()->role === 'member' && $reservation->user_id !== Auth::id()) {
            abort(403);
        }

        $reservation->update([
            'status' => 'cancelled',
        ]);

        return back()->with('success', 'Reservation cancelled.');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return back()->with('success', 'Reservation deleted.');
    }
}