<?php

namespace App\Http\Controllers;

use App\Models\BookCopy;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function index()
    {
        return view('admin.scan.index');
    }

    public function lookup(Request $request)
    {
        $validated = $request->validate([
            'barcode' => ['required', 'string'],
        ]);

        $copy = BookCopy::with('book')
            ->where('barcode', $validated['barcode'])
            ->orWhere('accession_number', $validated['barcode'])
            ->first();

        if (!$copy) {
            return back()->with('error', 'No book copy found for this barcode.');
        }

        $activeBorrowing = Borrowing::with('user', 'bookCopy.book')
            ->where('book_copy_id', $copy->id)
            ->where('status', 'active')
            ->first();

        return view('admin.scan.result', compact('copy', 'activeBorrowing'));
    }
}