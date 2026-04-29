<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'status',
        'reserved_at',
        'notified_at',
    ];

    protected $casts = [
        'reserved_at' => 'datetime',
        'notified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function book()
    {
        return $this->belongsTo(\App\Models\Book::class);
    }
}
