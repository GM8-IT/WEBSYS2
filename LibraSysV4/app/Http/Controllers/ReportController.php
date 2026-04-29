<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\BorrowingsExport;
use App\Exports\MembersExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        $borrowedBooks = Borrowing::with('user', 'bookCopy.book')
            ->where('status', 'active')
            ->latest()
            ->get();

        $overdueBooks = Borrowing::with('user', 'bookCopy.book')
            ->where('status', 'active')
            ->whereDate('due_at', '<', now())
            ->latest()
            ->get();

        $availableBooks = BookCopy::with('book')
            ->where('status', 'available')
            ->get();

        $members = User::with('profile')
            ->where('role', 'member')
            ->latest()
            ->get();

        return view('admin.reports.index', compact(
            'borrowedBooks',
            'overdueBooks',
            'availableBooks',
            'members'
        ));
    }

    public function exportBorrowings()
    {
        return Excel::download(new BorrowingsExport, 'borrowings-report.xlsx');
    }

    public function exportMembers()
    {
        return Excel::download(new MembersExport, 'members-report.xlsx');
    }
}
