<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Borrowing;
use App\Models\Reservation;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $monthlyBorrowings = Borrowing::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $months = [];
        $borrowingTotals = [];

        for ($i = 1; $i <= 12; $i++) {
            $months[] = date('M', mktime(0, 0, 0, $i, 1));
            $borrowingTotals[] = $monthlyBorrowings[$i] ?? 0;
        }

        return view('admin.dashboard', [
            'totalBooks' => Book::count(),
            'totalCopies' => BookCopy::count(),
            'availableCopies' => BookCopy::where('status', 'available')->count(),
            'borrowedCopies' => BookCopy::where('status', 'borrowed')->count(),
            'overdueBooks' => Borrowing::where('status', 'overdue')->count(),
            'totalMembers' => User::where('role', 'member')->count(),
            'pendingReservations' => Reservation::where('status', 'pending')->count(),
            'totalFines' => Borrowing::sum('fine_amount'),
            'months' => $months,
            'borrowingTotals' => $borrowingTotals,
        ]);
    }
}
