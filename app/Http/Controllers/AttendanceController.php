<?php
// app/Http/Controllers/AttendanceController.php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Called by the admin QR scanner.
     * POST /admin/scan/process  { ticket_code: "SPM-2026-0001" }
     */
    public function scan(Request $request)
    {
        $request->validate(['ticket_code' => 'required|string']);

        $participant = Participant::where('ticket_code', $request->ticket_code)->first();

        if (!$participant) {
            return response()->json([
                'success' => false,
                'message' => 'Kode tiket tidak ditemukan.',
            ], 404);
        }

        if ($participant->status !== 'accepted') {
            return response()->json([
                'success' => false,
                'message' => 'Peserta belum diverifikasi oleh admin.',
            ], 403);
        }

        $attendance = $participant->attendance;

        if ($attendance->status === 'hadir') {
            return response()->json([
                'success'   => false,
                'already'   => true,
                'message'   => "⚠️ {$participant->name} sudah tercatat hadir pada " .
                               $attendance->scanned_at->format('d M Y H:i'),
                'name'      => $participant->name,
                'ticket_code' => $participant->ticket_code,
            ]);
        }

        $attendance->update([
            'status'     => 'hadir',
            'scanned_at' => now(),
            'scanned_by' => Auth::user()->name ?? Auth::user()->email,
        ]);

        return response()->json([
            'success'      => true,
            'message'      => "✅ Kehadiran {$participant->name} berhasil dicatat!",
            'name'         => $participant->name,
            'ticket_code'  => $participant->ticket_code,
            'institution'  => $participant->institution,
            'scanned_at'   => now()->format('d M Y H:i:s'),
        ]);
    }
}
