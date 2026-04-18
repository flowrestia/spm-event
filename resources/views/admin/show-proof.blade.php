{{-- resources/views/admin/show-proof.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pembayaran - {{ $participant->name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #0B1F3B 0%, #132d54 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            color: white;
        }
        
        .container {
            max-width: 900px;
            width: 100%;
            background: rgba(11, 31, 59, 0.8);
            border: 1px solid rgba(198, 163, 78, 0.25);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
        }
        
        .header {
            background: linear-gradient(135deg, rgba(15, 107, 79, 0.3) 0%, rgba(198, 163, 78, 0.1) 100%);
            padding: 2rem;
            border-bottom: 1px solid rgba(198, 163, 78, 0.25);
        }
        
        .header h1 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
            color: #C6A34E;
        }
        
        .header p {
            opacity: 0.8;
            font-size: 0.95rem;
            color: rgba(198, 163, 78, 0.9);
        }
        
        .content {
            padding: 2rem;
        }
        
        .info-card {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(198, 163, 78, 0.15);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.8rem;
            font-size: 0.95rem;
        }
        
        .info-row:last-child {
            margin-bottom: 0;
        }
        
        .info-label {
            font-weight: 600;
            color: #C6A34E;
            min-width: 120px;
        }
        
        .info-value {
            color: rgba(198, 163, 78, 0.9);
            word-break: break-all;
            text-align: right;
            flex: 1;
            padding-left: 1rem;
        }
        
        .proof-section {
            margin-bottom: 2rem;
        }
        
        .proof-title {
            font-size: 1.2rem;
            color: #C6A34E;
            margin-bottom: 1rem;
            font-weight: 600;
        }
        
        .proof-container {
            background: rgba(0, 0, 0, 0.3);
            border: 2px solid rgba(198, 163, 78, 0.25);
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
            min-height: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: auto;
            max-height: 600px;
        }
        
        .proof-image {
            max-width: 100%;
            max-height: 100%;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }
        
        .proof-pdf {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            color: rgba(198, 163, 78, 0.8);
        }
        
        .pdf-icon {
            font-size: 4rem;
        }
        
        .pdf-text {
            font-size: 0.95rem;
        }
        
        .action-section {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(198, 163, 78, 0.25);
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 0.8rem 1.5rem;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s;
            border: 1px solid rgba(198, 163, 78, 0.3);
            background: transparent;
            color: #C6A34E;
        }
        
        .btn:hover {
            background: rgba(198, 163, 78, 0.1);
            border-color: rgba(198, 163, 78, 0.5);
            transform: translateY(-2px);
        }
        
        .btn-back {
            flex: 1;
            justify-content: center;
        }
        
        .btn-download {
            flex: 1;
            justify-content: center;
            background: rgba(15, 107, 79, 0.2);
            border-color: rgba(15, 107, 79, 0.4);
            color: #10b981;
        }
        
        .btn-download:hover {
            background: rgba(15, 107, 79, 0.3);
            border-color: rgba(15, 107, 79, 0.6);
        }
        
        .note {
            background: rgba(245, 158, 11, 0.1);
            border-left: 4px solid #f59e0b;
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: rgba(245, 158, 11, 0.9);
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>🧾 Bukti Pembayaran</h1>
        <p>Peserta: <strong>{{ $participant->name }}</strong></p>
    </div>
    
    <div class="content">
        <!-- Info Peserta -->
        <div class="info-card">
            <div class="info-row">
                <span class="info-label">Nama:</span>
                <span class="info-value">{{ $participant->name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Email:</span>
                <span class="info-value">{{ $participant->email }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Kode Tiket:</span>
                <span class="info-value"><strong>{{ $participant->ticket_code }}</strong></span>
            </div>
            <div class="info-row">
                <span class="info-label">Status:</span>
                <span class="info-value">
                    @if($participant->status === 'accepted')
                        <span style="color: #10b981;">✅ Diterima</span>
                    @elseif($participant->status === 'rejected')
                        <span style="color: #ef4444;">❌ Ditolak</span>
                    @else
                        <span style="color: #f59e0b;">⏳ Pending</span>
                    @endif
                </span>
            </div>
        </div>
        
        <!-- Proof Display -->
        <div class="proof-section">
            <div class="proof-title">📷 File Bukti Pembayaran</div>
            <div class="proof-container">
                @if(str_ends_with(strtolower($proofUrl), '.pdf'))
                    <div class="proof-pdf">
                        <div class="pdf-icon">📄</div>
                        <div class="pdf-text">Bukti pembayaran dalam format PDF</div>
                        <a href="{{ $proofUrl }}" target="_blank" class="btn btn-download">
                            ⬇️ Buka/Download PDF
                        </a>
                    </div>
                @else
                    <img src="{{ $proofUrl }}" alt="Bukti Pembayaran" class="proof-image" onerror="this.parentElement.innerHTML='<div class=&quot;proof-pdf&quot;><div class=&quot;pdf-icon&quot;>❌</div><div class=&quot;pdf-text&quot;>Gagal memuat gambar</div></div>'">
                @endif
            </div>
        </div>
        
        <!-- Note -->
        <div class="note">
            💡 URL bukti pembayaran ini didapatkan dari Cloudinary (cloud storage). Klik untuk melihat/download file asli.
        </div>
        
        <!-- Actions -->
        <div class="action-section">
            <a href="{{ route('admin.participants') }}" class="btn btn-back">← Kembali ke Daftar Peserta</a>
            <a href="{{ $proofUrl }}" target="_blank" class="btn btn-download">⬇️ Download File</a>
        </div>
    </div>
</div>

<script>
// Helper function untuk detect MIME dari URL
function match_mime(url) {
    if (url.match(/\.pdf$/i)) return 'application/pdf';
    if (url.match(/\.(jpg|jpeg)$/i)) return 'image/jpeg';
    if (url.match(/\.png$/i)) return 'image/png';
    if (url.match(/\.gif$/i)) return 'image/gif';
    return 'image/jpeg';
}
</script>
</body>
</html>
