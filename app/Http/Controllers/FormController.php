<?php
// app/Http/Controllers/FormController.php

namespace App\Http\Controllers;

use App\Mail\TicketMail;
use App\Models\Attendance;
use App\Models\EventSetting;
use App\Models\Participant;
use App\Services\PDFService;
use App\Services\QRCodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Cloudinary\Cloudinary;

class FormController extends Controller
{
    public function __construct(
        private QRCodeService $qrService,
        private PDFService    $pdfService
    ) {}

    public function index()
    {
        $setting = EventSetting::current();
        return view('form.index', compact('setting'));
    }

    public function store(Request $request)
    {
        $setting = EventSetting::current();

        if (!$setting->form_open) {
            return response()->json(['message' => 'Pendaftaran sudah ditutup.'], 403);
        }

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'age_range'     => 'required|in:17-20,21-25,>25',
            'phone'         => 'required|string|max:20',
            'institution'   => 'required|string|max:255',
            'info_source'   => 'required|in:Sosial Media,Teman / Referral,Kampus / Komunitas,Online (Web/Email)',
            'email'         => 'required|email|max:255',
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        // Store payment proof
        $cloudinary = new Cloudinary();
        $uploaded = $cloudinary->uploadApi()->upload(
            $request->file('payment_proof')->getRealPath()
        );

        $proofPath = $uploaded['secure_url'];

        // Create participant
        $participant = Participant::create([
            'ticket_code'   => Participant::generateTicketCode(),
            'name'          => $validated['name'],
            'age_range'     => $validated['age_range'],
            'phone'         => $validated['phone'],
            'institution'   => $validated['institution'],
            'info_source'   => $validated['info_source'],
            'email'         => $validated['email'],
            'payment_proof' => $proofPath,
            'status'        => 'pending',
        ]);

        // Create attendance record (default belum_hadir)
        Attendance::create([
            'participant_id' => $participant->id,
            'status'         => 'belum_hadir',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil! Silakan cek email setelah admin verifikasi pembayaran Anda.',
            'name'    => $participant->name,
            'email'   => $participant->email,
        ]);
    }
}
