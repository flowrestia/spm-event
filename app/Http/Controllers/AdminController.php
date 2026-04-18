<?php
// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use App\Mail\TicketMail;
use App\Models\Attendance;
use App\Models\EventSetting;
use App\Models\Participant;
use App\Services\PDFService;
use App\Services\QRCodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function __construct(
        private QRCodeService $qrService,
        private PDFService    $pdfService
    ) {}

    // ─── AUTH ─────────────────────────────────────────────────────────────────

    public function loginForm()
    {
        if (Auth::check()) return redirect()->route('admin.dashboard');
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    // ─── DASHBOARD ────────────────────────────────────────────────────────────

    public function dashboard()
    {
        $setting      = EventSetting::current();
        $total        = Participant::count();
        $pending      = Participant::where('status', 'pending')->count();
        $accepted     = Participant::where('status', 'accepted')->count();
        $rejected     = Participant::where('status', 'rejected')->count();
        $hadir        = Attendance::where('status', 'hadir')->count();
        $belumHadir   = Attendance::where('status', 'belum_hadir')
                            ->whereHas('participant', fn($q) => $q->where('status', 'accepted'))
                            ->count();

        // Age range stats
        $ageStats = Participant::where('status', 'accepted')
            ->selectRaw('age_range, COUNT(*) as count')
            ->groupBy('age_range')
            ->pluck('count', 'age_range');

        // Info source stats
        $sourceStats = Participant::where('status', 'accepted')
            ->selectRaw('info_source, COUNT(*) as count')
            ->groupBy('info_source')
            ->pluck('count', 'info_source');

        return view('admin.dashboard', compact(
            'setting', 'total', 'pending', 'accepted', 'rejected',
            'hadir', 'belumHadir', 'ageStats', 'sourceStats'
        ));
    }

    // ─── PARTICIPANTS ─────────────────────────────────────────────────────────

    public function participants(Request $request)
    {
        $query = Participant::with('attendance')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('ticket_code', 'like', '%' . $request->search . '%');
            });
        }

        $participants = $query->paginate(15)->withQueryString();
        return view('admin.participants', compact('participants'));
    }

    public function accept(Participant $participant)
    {
        if ($participant->status !== 'pending') {
            return back()->with('error', 'Peserta ini sudah diproses.');
        }

        try {
            // 1. Generate QR Code
            $qrPath = $this->qrService->generate($participant->ticket_code);

            // 2. Update participant with QR code
            $participant->update([
                'status'       => 'accepted',
                'qr_code_path' => $qrPath,
            ]);

            // 3. Refresh data
            $participant = $participant->fresh();

            // 4. Generate PDF
            $pdfPath = $this->pdfService->generate($participant);
            $participant->update(['pdf_path' => $pdfPath]);

            // 5. Redirect ke email confirmation page (bukan langsung kirim)
            return redirect()->route('admin.participants.email-confirmation', $participant);

        } catch (\Exception $e) {
            // Log error
            \Log::error('Error saat approve peserta:', [
                'participant_id' => $participant->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function reject(Participant $participant)
    {
        $participant->update(['status' => 'rejected']);
        return back()->with('success', "Peserta {$participant->name} telah ditolak.");
    }

    public function showProof(Participant $participant)
    {
        $path = Storage::disk('public')->path($participant->payment_proof);
        $mime = mime_content_type($path);
        return response()->file($path, ['Content-Type' => $mime]);
    }

    public function emailConfirmation(Participant $participant)
    {
        if ($participant->status !== 'accepted' || !$participant->pdf_path) {
            return redirect()->route('admin.participants')
                ->with('error', 'Peserta belum di-approve atau PDF belum di-generate.');
        }

        return view('admin.email-confirmation', compact('participant'));
    }

    public function confirmEmailSent(Participant $participant)
    {
        $participant->update(['ticket_sent' => true]);
        
        return redirect()->route('admin.participants')
            ->with('success', "✅ Email tiket untuk {$participant->name} berhasil dikonfirmasi terkirim.");
    }

    public function downloadPdf(Participant $participant)
    {
        if (!$participant->pdf_path) {
            return redirect()->back()->with('error', 'PDF tiket belum tersedia.');
        }

        $path = $this->pdfService->path($participant->pdf_path);
        
        if (!file_exists($path)) {
            return redirect()->back()->with('error', 'File PDF tidak ditemukan.');
        }

        return response()->download($path, $participant->ticket_code . '-Tiket.pdf');
    }

    // ─── ATTENDANCE ───────────────────────────────────────────────────────────

    public function attendance()
    {
        $attendances = Attendance::with('participant')
            ->whereHas('participant', fn($q) => $q->where('status', 'accepted'))
            ->latest('scanned_at')
            ->paginate(20);

        return view('admin.attendance', compact('attendances'));
    }

    public function scanPage()
    {
        return view('admin.scan');
    }

    // ─── SETTINGS ─────────────────────────────────────────────────────────────

    public function toggleForm()
    {
        $setting = EventSetting::current();
        $setting->update(['form_open' => !$setting->form_open]);
        $status = $setting->form_open ? 'dibuka' : 'ditutup';
        return back()->with('success', "Formulir pendaftaran telah {$status}.");
    }

    public function uploadHeader(Request $request)
    {
        $request->validate(['header_image' => 'required|image|max:2048']);
        $setting = EventSetting::current();

        if ($setting->header_image) {
            Storage::disk('public')->delete($setting->header_image);
        }

        $path = $request->file('header_image')->store('headers', 'public');
        $setting->update(['header_image' => $path]);

        return back()->with('success', 'Header berhasil diperbarui.');
    }
}
