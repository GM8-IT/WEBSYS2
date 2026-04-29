<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    protected $fillable = [
        'user_id',
        'book_copy_id',
        'borrowed_at',
        'due_at',
        'returned_at',
        'fine_amount',
        'status',
    ];

    protected $casts = [
        'borrowed_at' => 'date',
        'due_at' => 'date',
        'returned_at' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookCopy()
    {
        return $this->belongsTo(BookCopy::class);
    }

    public function finePayments()
    {
        return $this->hasMany(\App\Models\FinePayment::class);
    }

    public function getPaidAmountAttribute()
    {
        return $this->finePayments()->sum('amount_paid');
    }

    public function getFineBalanceAttribute()
    {
        return max(0, $this->fine_amount - $this->paid_amount);
    }
}
