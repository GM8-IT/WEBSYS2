<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventLog extends Model
{
    protected $fillable = [
        'user_id','event_type','description','ip','user_agent','path','method','status_code'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\Student::class, 'user_id');
    }
}