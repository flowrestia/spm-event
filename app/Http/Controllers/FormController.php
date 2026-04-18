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
        try {
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

            // Store payment proof to Cloudinary
            try {
                // Get CLOUDINARY_URL - coba dari env dulu, jika tidak ada coba dari .env
                $cloudinaryUrl = env('CLOUDINARY_URL');
                
                // Jika masih kosong (production mode), coba load dari .env file langsung
                if (!$cloudinaryUrl && file_exists(base_path('.env'))) {
                    $envContent = file_get_contents(base_path('.env'));
                    if (preg_match('/^CLOUDINARY_URL=(.+)$/m', $envContent, $envMatches)) {
                        $cloudinaryUrl = trim($envMatches[1]);
                    }
                }
                
                if (!$cloudinaryUrl) {
                    \Log::error('CLOUDINARY_URL not found in env');
                    throw new \Exception('CLOUDINARY_URL tidak ditemukan');
                }

                // Parse format: cloudinary://api_key:api_secret@cloud_name
                if (!preg_match('/cloudinary:\/\/(\d+):([^@]+)@(.+)/', $cloudinaryUrl, $matches)) {
                    \Log::error('Invalid CLOUDINARY_URL format: ' . $cloudinaryUrl);
                    throw new \Exception('Format CLOUDINARY_URL tidak valid');
                }
                
                $apiKey = $matches[1];
                $apiSecret = $matches[2];
                $cloudName = $matches[3];
                
                \Log::info('Cloudinary config loaded', ['cloud_name' => $cloudName]);

                $cloudinary = new Cloudinary([
                    'cloud' => [
                        'cloud_name' => $cloudName,
                        'api_key'    => $apiKey,
                        'api_secret' => $apiSecret,
                    ]
                ]);
                
                $uploaded = $cloudinary->uploadApi()->upload(
                    $request->file('payment_proof')->getRealPath()
                );
                \Log::info('File uploaded to Cloudinary: ' . $uploaded['public_id']);
                $proofPath = $uploaded['secure_url'];
            } catch (\Exception $e) {
                \Log::error('Cloudinary upload failed: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengunggah file bukti pembayaran. Coba lagi atau hubungi admin.',
                ], 500);
            }

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
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            \Log::error('Form submission error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server. Coba lagi nanti atau hubungi admin.',
            ], 500);
        }
    }
}
