<?php
// app/Models/Participant.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_code', 'name', 'age_range', 'phone',
        'institution', 'info_source', 'payment_proof',
        'email', 'status', 'qr_code_path', 'pdf_path', 'ticket_sent',
    ];

    protected $casts = [
        'ticket_sent' => 'boolean',
    ];

    public function attendance()
    {
        return $this->hasOne(Attendance::class);
    }

    public static function generateTicketCode(): string
    {
        $count = self::count() + 1;
        return 'SPM-2026-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'accepted' => '<span class="badge-accepted">Diterima</span>',
            'rejected'  => '<span class="badge-rejected">Ditolak</span>',
            default     => '<span class="badge-pending">Menunggu</span>',
        };
    }
}
