<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use Notifiable;

    protected $table = 'students';

    protected $fillable = [
        'student_id','first_name','middle_name','last_name','date_of_birth','gender',
        'email','phone','address','city','state','postal_code','program','password'
    ];

    protected $hidden = [
        'password','remember_token'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];
}