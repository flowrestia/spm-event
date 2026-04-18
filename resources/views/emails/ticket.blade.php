{{-- resources/views/emails/ticket.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket – Sekolah Pasar Modal 2026</title>
    <style>
        body { margin:0; padding:0; background:#f0f4f8; font-family:'Segoe UI', Arial, sans-serif; }
        .wrap { max-width:600px; margin:2rem auto; background:#fff; border-radius:16px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,.1); }
        .header { background:linear-gradient(135deg, #0B1F3B 0%, #0F6B4F 100%); padding:2.5rem 2rem; text-align:center; }
        .header .org { color:rgba(198,163,78,.85); font-size:.78rem; letter-spacing:.12em; text-transform:uppercase; font-weight:700; }
        .header h1 { color:#fff; font-size:1.6rem; margin:.5rem 0 .25rem; line-height:1.2; }
        .header .sub { color:rgba(255,255,255,.65); font-size:.9rem; }
        .gold-bar { height:4px; background:linear-gradient(90deg, #0F6B4F, #C6A34E, #0F6B4F); }
        .body { padding:2rem; }
        .greeting { font-size:1rem; color:#374151; margin-bottom:1.25rem; }
        .info-box { background:#f9fafb; border:1px solid #e5e7eb; border-left:4px solid #C6A34E; border-radius:10px; padding:1.25rem 1.5rem; margin:1.5rem 0; }
        .info-row { display:flex; align-items:flex-start; gap:.75rem; padding:.4rem 0; border-bottom:1px solid #f0f0f0; font-size:.9rem; }
        .info-row:last-child { border-bottom:none; }
        .info-label { width:130px; flex-shrink:0; color:#9ca3af; font-weight:600; font-size:.8rem; text-transform:uppercase; letter-spacing:.05em; padding-top:.1rem; }
        .info-value { color:#111827; font-weight:500; }
        .ticket-code { display:inline-block; font-family:monospace; font-size:1.25rem; font-weight:700; color:#0B1F3B; background:rgba(198,163,78,.15); border:2px dashed #C6A34E; padding:.5rem 1.5rem; border-radius:10px; letter-spacing:.1em; }
        .note { background:#fffbeb; border:1px solid #fde68a; border-radius:10px; padding:1rem 1.25rem; margin-top:1.5rem; font-size:.85rem; color:#92400e; }
        .note strong { color:#78350f; }
        .footer { background:#0B1F3B; padding:1.5rem 2rem; text-align:center; }
        .footer p { color:rgba(255,255,255,.45); font-size:.78rem; margin:.25rem 0; }
        .footer .org-name { color:#C6A34E; font-weight:600; font-size:.85rem; }
    </style>
</head>
<body>
<div class="wrap">
    <div class="header">
        <div class="org">✦ GI-BEI PSDKU POLINEMA KEDIRI ✦</div>
        <h1>Sekolah Pasar Modal<br>Financial Glow Up 2026</h1>
        <div class="sub">Simple Investment For a More Secure Future</div>
    </div>
    <div class="gold-bar"></div>

    <div class="body">
        <p class="greeting">
            Halo, <strong>{{ $participant->name }}</strong>! 👋<br>
            Selamat! Pendaftaran Anda telah <strong style="color:#0F6B4F;">diverifikasi dan diterima</strong>.
            Berikut adalah detail tiket Anda.
        </p>

        <div style="text-align:center; margin:1.5rem 0;">
            <div style="font-size:.8rem; color:#9ca3af; text-transform:uppercase; letter-spacing:.07em; margin-bottom:.5rem;">Kode Tiket Anda</div>
            <div class="ticket-code">{{ $participant->ticket_code }}</div>
        </div>

        <div class="info-box">
            <div class="info-row">
                <span class="info-label">Nama</span>
                <span class="info-value">{{ $participant->name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Email</span>
                <span class="info-value">{{ $participant->email }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">No. HP</span>
                <span class="info-value">{{ $participant->phone }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Umur</span>
                <span class="info-value">{{ $participant->age_range }} tahun</span>
            </div>
            <div class="info-row">
                <span class="info-label">Instansi</span>
                <span class="info-value">{{ $participant->institution }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Penyelenggara</span>
                <span class="info-value">GI-BEI PSDKU POLINEMA KEDIRI</span>
            </div>
            <div class="info-row">
                <span class="info-label">Kampus</span>
                <span class="info-value">PSDKU Politeknik Negeri Malang Kota Kediri</span>
            </div>
        </div>

        <div class="note">
            <strong>📎 Tiket PDF terlampir di email ini.</strong><br>
            Silakan unduh dan simpan tiket PDF Anda. Tunjukkan <strong>QR Code</strong> pada tiket kepada panitia saat hari acara untuk proses absensi.
        </div>
    </div>

    <div class="footer">
        <p class="org-name">GI-BEI PSDKU POLINEMA KEDIRI</p>
        <p>PSDKU Politeknik Negeri Malang Kota Kediri</p>
        <p style="margin-top:.75rem;">Sekolah Pasar Modal – Financial Glow Up 2026</p>
    </div>
</div>
</body>
</html>
