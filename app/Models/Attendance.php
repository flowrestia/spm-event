<?php
// app/Models/Attendance.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = ['participant_id', 'status', 'scanned_at', 'scanned_by'];

    protected $casts = [
        'scanned_at' => 'datetime',
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}
