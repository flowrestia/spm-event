{{-- resources/views/admin/email-confirmation.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Email Tiket - {{ $participant->name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f3f4f6;
            padding: 2rem;
            color: #374151;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0,0,0,0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #0B1F3B 0%, #0F6B4F 100%);
            padding: 2rem;
            color: white;
        }
        
        .header h1 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }
        
        .header p {
            opacity: 0.9;
            font-size: 0.95rem;
        }
        
        .content {
            padding: 2rem;
        }
        
        .info-card {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .info-row {
            display: flex;
            gap: 1rem;
            margin-bottom: 0.8rem;
            font-size: 0.95rem;
        }
        
        .info-row:last-child {
            margin-bottom: 0;
        }
        
        .info-label {
            font-weight: 600;
            color: #6b7280;
            min-width: 120px;
        }
        
        .info-value {
            color: #111827;
            word-break: break-all;
        }
        
        .email-preview {
            background: #f0f4f8;
            border: 2px dashed #d1d5db;
            border-radius: 10px;
            padding: 1.5rem;
            margin: 1.5rem 0;
            font-family: 'Monaco', 'Courier New', monospace;
            font-size: 0.85rem;
            line-height: 1.6;
            color: #374151;
            max-height: 400px;
            overflow-y: auto;
        }
        
        .email-header {
            border-bottom: 1px solid #d1d5db;
            padding-bottom: 1rem;
            margin-bottom: 1rem;
        }
        
        .email-field {
            margin-bottom: 0.8rem;
        }
        
        .email-field-label {
            color: #6b7280;
            font-weight: 600;
            display: block;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .email-field-value {
            color: #111827;
            margin-top: 0.2rem;
            word-break: break-word;
        }
        
        .action-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid #e5e7eb;
        }
        
        .button {
            padding: 1rem 1.5rem;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
            border: none;
        }
        
        .button-primary {
            background: linear-gradient(135deg, #0F6B4F 0%, #0B1F3B 100%);
            color: white;
        }
        
        .button-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(15, 107, 79, 0.3);
        }
        
        .button-secondary {
            background: #e5e7eb;
            color: #111827;
        }
        
        .button-secondary:hover {
            background: #d1d5db;
        }
        
        .button-success {
            background: #10b981;
            color: white;
        }
        
        .button-success:hover {
            background: #059669;
            transform: translateY(-2px);
        }
        
        .note {
            background: #fffbeb;
            border-left: 4px solid #f59e0b;
            padding: 1rem;
            border-radius: 5px;
            margin: 1.5rem 0;
            font-size: 0.9rem;
        }
        
        .note strong {
            color: #d97706;
        }
        
        .instructions {
            background: #e0f2fe;
            border-left: 4px solid #0284c7;
            padding: 1rem;
            border-radius: 5px;
            margin: 1.5rem 0;
            font-size: 0.9rem;
            line-height: 1.8;
        }
        
        .instructions strong {
            color: #0369a1;
            display: block;
            margin-bottom: 0.5rem;
        }
        
        .instructions ol {
            margin-left: 1.5rem;
        }
        
        .instructions li {
            margin-bottom: 0.5rem;
        }
        
        .back-link {
            display: inline-block;
            margin-top: 1rem;
            color: #0369a1;
            text-decoration: none;
            font-size: 0.9rem;
        }
        
        .back-link:hover {
            text-decoration: underline;
        }
        
        .pdf-section {
            background: #f3f4f6;
            padding: 1.5rem;
            border-radius: 10px;
            margin: 1.5rem 0;
            text-align: center;
        }
        
        .pdf-icon {
            font-size: 3rem;
            margin-bottom: 0.5rem;
        }
        
        .pdf-filename {
            font-weight: 600;
            color: #111827;
            margin-bottom: 1rem;
        }
        
        @media (max-width: 768px) {
            .action-section {
                grid-template-columns: 1fr;
            }
            
            .header h1 {
                font-size: 1.4rem;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>📧 Konfirmasi Pengiriman Tiket</h1>
        <p>Peserta: <strong>{{ $participant->name }}</strong></p>
    </div>
    
    <div class="content">
        <!-- Info Peserta -->
        <div class="info-card">
            <div class="info-row">
                <span class="info-label">Nama Peserta:</span>
                <span class="info-value">{{ $participant->name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Email Tujuan:</span>
                <span class="info-value">{{ $participant->email }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Kode Tiket:</span>
                <span class="info-value"><strong>{{ $participant->ticket_code }}</strong></span>
            </div>
        </div>
        
        <!-- Preview Email -->
        <h3 style="margin: 1.5rem 0 1rem; color: #111827;">📋 Preview Email</h3>
        <div class="email-preview">
            <div class="email-header">
                <div class="email-field">
                    <span class="email-field-label">From:</span>
                    <span class="email-field-value">{{ config('mail.from.name') }} <{{ config('mail.from.address') }}></span>
                </div>
                <div class="email-field">
                    <span class="email-field-label">To:</span>
                    <span class="email-field-value">{{ $participant->email }}</span>
                </div>
                <div class="email-field">
                    <span class="email-field-label">Subject:</span>
                    <span class="email-field-value">🎟️ Tiket Anda - Sekolah Pasar Modal Financial Glow Up 2026</span>
                </div>
            </div>
            
            <div style="white-space: pre-wrap;">
Halo, {{ $participant->name }}! 👋

Selamat! Pendaftaran Anda telah diverifikasi dan diterima.
Berikut adalah detail tiket Anda.

════════════════════════════════════════
KODE TIKET: {{ $participant->ticket_code }}
════════════════════════════════════════

Nama       : {{ $participant->name }}
Email      : {{ $participant->email }}
Nomor HP   : {{ $participant->phone }}
Umur       : {{ $participant->age_range }} tahun
Institusi  : {{ $participant->institution }}
Penyelenggara: GI-BEI PSDKU POLINEMA KEDIRI

====================================================
📎 TIKET PDF TERLAMPIR
====================================================

Silakan unduh dan simpan tiket PDF Anda. 
Tunjukkan QR Code pada tiket kepada panitia saat hari acara 
untuk proses absensi.

---
GI-BEI PSDKU POLINEMA KEDIRI
PSDKU Politeknik Negeri Malang Kota Kediri
Sekolah Pasar Modal – Financial Glow Up 2026
            </div>
        </div>
        
        <!-- PDF Section -->
        <div class="pdf-section">
            <div class="pdf-icon">📄</div>
            <div class="pdf-filename">{{ $participant->ticket_code }}-Tiket.pdf</div>
            <a href="{{ route('admin.participants.download-pdf', $participant) }}" 
               class="button button-secondary" 
               style="display: inline-block;">
                ⬇️ Download PDF Tiket
            </a>
        </div>
        
        <!-- Instructions -->
        <div class="instructions">
            <strong>📍 Langkah-Langkah Mengirim Email:</strong>
            <ol>
                <li><strong>Copy Subject:</strong> Klik tombol "Copy Subject" di bawah</li>
                <li><strong>Buka Gmail:</strong> Klik tombol "Buka Gmail" untuk membuka compose</li>
                <li><strong>Paste Subject:</strong> Paste subject yang sudah di-copy</li>
                <li><strong>Copy Body:</strong> Klik tombol "Copy Body" dan paste ke email body</li>
                <li><strong>Attach PDF:</strong> Download PDF di atas, lalu attach ke email</li>
                <li><strong>Send:</strong> Klik tombol "Send" di Gmail</li>
                <li><strong>Confirm Sent:</strong> Kembali ke halaman ini, klik "✅ Confirm Email Sent"</li>
            </ol>
        </div>
        
        <div class="note">
            <strong>💡 Tips:</strong> Setelah klik "Buka Gmail", email subject dan recipient sudah ter-fill otomatis. 
            Anda hanya perlu copy-paste body dari halaman ini, attach PDF, dan send!
        </div>
        
        <!-- Action Section -->
        <div class="action-section">
            <div>
                <button type="button" 
                        onclick="copyToClipboard('Klik tombol Copy Subject dulu!'); alert('Subject: 🎟️ Tiket Anda - Sekolah Pasar Modal Financial Glow Up 2026'); copyToClipboard('🎟️ Tiket Anda - Sekolah Pasar Modal Financial Glow Up 2026');"
                        class="button button-secondary"
                        style="width: 100%; margin-bottom: 0.5rem;">
                    📋 Copy Subject
                </button>
                <button type="button" 
                        onclick="copyToClipboard(document.querySelector('.email-preview').innerText);"
                        class="button button-secondary"
                        style="width: 100%;">
                    📋 Copy Body
                </button>
            </div>
            <div>
                <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ urlencode($participant->email) }}&su={{ urlencode('🎟️ Tiket Anda - Sekolah Pasar Modal Financial Glow Up 2026') }}" 
                   class="button button-primary"
                   target="_blank"
                   style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                    🔗 Buka Gmail
                </a>
            </div>
        </div>
        
        <!-- Confirm Sent Section -->
        <div style="margin-top: 2rem; padding-top: 2rem; border-top: 2px solid #e5e7eb;">
            <h3 style="margin-bottom: 1rem; color: #111827;">✅ Sudah Terkirim?</h3>
            <p style="margin-bottom: 1rem; color: #6b7280;">Setelah email berhasil dikirim dari Gmail, klik tombol di bawah untuk mengonfirmasi:</p>
            
            <form action="{{ route('admin.participants.confirm-email-sent', $participant) }}" method="POST" style="margin-bottom: 1rem;">
                @csrf
                <button type="submit" class="button button-success" style="width: 100%;">
                    ✅ Konfirmasi Email Sudah Dikirim
                </button>
            </form>
            
            <a href="{{ route('admin.participants') }}" class="back-link">
                ← Kembali ke Daftar Peserta
            </a>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        // Feedback
        const btn = event.target;
        const originalText = btn.textContent;
        btn.textContent = '✅ Sudah di-copy!';
        setTimeout(() => {
            btn.textContent = originalText;
        }, 2000);
    }).catch(() => {
        alert('Gagal copy. Silakan copy manual dari preview di atas.');
    });
}
</script>
</body>
</html>
