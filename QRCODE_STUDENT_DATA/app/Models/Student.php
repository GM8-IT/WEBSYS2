<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'student_id',
        'first_name',
        'last_name',
        'course',
        'year_level',
        'section',
        'email',
        'contact_number',
        'address',
    ];
}
