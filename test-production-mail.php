<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;
use App\Models\Participant;
use App\Mail\TicketMail;
use App\Services\PDFService;

try {
    echo "🔄 Testing Production Gmail SMTP...\n\n";
    
    // Cari participant yang status accepted
    $participant = Participant::where('status', 'accepted')->first();
    
    if (!$participant) {
        echo "⚠️  Tidak ada participant dengan status 'accepted'\n";
        echo "    Silakan approve peserta dulu dari admin panel\n";
        exit(1);
    }
    
    echo "📧 Sending test email to: {$participant->email}\n";
    echo "   Participant: {$participant->name}\n";
    echo "   Ticket Code: {$participant->ticket_code}\n\n";
    
    // Test send email
    if ($participant->pdf_path) {
        $pdfPath = app(PDFService::class)->path($participant->pdf_path);
        Mail::to($participant->email)->send(
            new TicketMail($participant, $pdfPath)
        );
    } else {
        // Send simple test email
        Mail::raw("Test email dari SPM Financial Glow Up", function (Message $msg) use ($participant) {
            $msg->to($participant->email)
                ->subject("📧 Test Email - SPM Financial Glow Up");
        });
    }
    
    echo "✅ Email berhasil dikirim!\n";
    echo "   Silakan cek inbox peserta di: {$participant->email}\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n\n";
    exit(1);
}
