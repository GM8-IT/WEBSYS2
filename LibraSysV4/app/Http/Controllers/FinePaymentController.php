<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\FinePayment;
use Illuminate\Http\Request;

class FinePaymentController extends Controller
{
    public function store(Request $request, Borrowing $borrowing)
    {
        $paidAmount = $borrowing->finePayments()->sum('amount_paid');
        $balance = max(0, $borrowing->fine_amount - $paidAmount);

        $validated = $request->validate([
            'amount_paid' => ['required', 'numeric', 'min:1', 'max:' . $balance],
            'payment_method' => ['nullable', 'string', 'max:255'],
        ]);

        if ($balance <= 0) {
            return back()->with('error', 'This fine is already fully paid.');
        }

        FinePayment::create([
            'borrowing_id' => $borrowing->id,
            'amount_paid' => $validated['amount_paid'],
            'payment_method' => $validated['payment_method'] ?? 'Cash',
            'paid_at' => now(),
        ]);

        return back()->with('success', 'Fine payment recorded successfully.');
    }
}