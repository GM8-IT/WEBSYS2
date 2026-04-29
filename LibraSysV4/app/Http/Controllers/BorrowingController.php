<?php

namespace App\Http\Controllers;

use App\Models\BookCopy;
use App\Models\Borrowing;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ReservationAvailableNotification;

class BorrowingController extends Controller
{
    public function index(Request $request)
    {
        $borrowings = Borrowing::with('user', 'bookCopy.book')
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->search, function ($query) use ($request) {
                $query->whereHas('user', function ($userQuery) use ($request) {
                    $userQuery->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%');
                })
                    ->orWhereHas('bookCopy.book', function ($bookQuery) use ($request) {
                        $bookQuery->where('title', 'like', '%' . $request->search . '%')
                            ->orWhere('author', 'like', '%' . $request->search . '%');
                    });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.borrowings.index', compact('borrowings'));
    }

    public function create()
    {
        $members = User::where('role', 'member')
            ->orderBy('name')
            ->get();

        $availableCopies = BookCopy::with('book')
            ->where('status', 'available')
            ->orderBy('accession_number')
            ->get();

        return view('admin.borrowings.create', compact('members', 'availableCopies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'book_copy_id' => ['required', 'exists:book_copies,id'],
            'due_at' => ['required', 'date', 'after_or_equal:today'],
        ]);

        $copy = BookCopy::where('id', $validated['book_copy_id'])
            ->where('status', 'available')
            ->firstOrFail();

        Borrowing::create([
            'user_id' => $validated['user_id'],
            'book_copy_id' => $copy->id,
            'borrowed_at' => now()->toDateString(),
            'due_at' => $validated['due_at'],
            'status' => 'active',
            'fine_amount' => 0,
        ]);

        $copy->update([
            'status' => 'borrowed',
        ]);

        return redirect()
            ->route('admin.borrowings.index')
            ->with('success', 'Book borrowed successfully.');
    }

    public function show(Borrowing $borrowing)
    {
        $borrowing->load('user.profile', 'bookCopy.book');

        return view('admin.borrowings.show', compact('borrowing'));
    }

    public function returnBook(Borrowing $borrowing)
    {
        if ($borrowing->status === 'returned') {
            return back()->with('error', 'This book has already been returned.');
        }

        $finePerDay = 10;

        $daysLate = now()->greaterThan($borrowing->due_at)
            ? $borrowing->due_at->diffInDays(now())
            : 0;

        $fineAmount = $daysLate * $finePerDay;

        $borrowing->update([
            'returned_at' => now()->toDateString(),
            'fine_amount' => $fineAmount,
            'status' => 'returned',
        ]);

        $borrowing->bookCopy->update([
            'status' => 'available',
        ]);

        $bookId = $borrowing->bookCopy->book_id;

        $reservation = Reservation::where('book_id', $bookId)
            ->where('status', 'pending')
            ->oldest()
            ->first();

        if ($reservation) {
            $reservation->update([
                'status' => 'available',
                'notified_at' => now(),
            ]);

            $borrowing->bookCopy->update([
                'status' => 'reserved',
            ]);

            $reservation->user->notify(new ReservationAvailableNotification($reservation));
        }

        return redirect()
            ->route('admin.borrowings.index')
            ->with('success', 'Book returned successfully. Fine: ₱' . number_format($fineAmount, 2));
    }

    public function memberHistory()
    {
        $borrowings = Borrowing::with('bookCopy.book')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('member.history', compact('borrowings'));
    }
}
