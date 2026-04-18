{{-- resources/views/pdf/ticket.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tiket — {{ $participant->ticket_code }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            background: #f8f9fa;
            color: #111827;
            font-size: 12px;
        }

        .ticket {
            width: 100%;
            min-height: 100vh;
            background: white;
            position: relative;
            overflow: hidden;
        }

        /* Header */
        .ticket-header {
            background: #0B1F3B;
            padding: 24px 28px;
            position: relative;
            overflow: hidden;
        }
        .ticket-header::before {
            content: '';
            position: absolute;
            top: -30px; right: -30px;
            width: 120px; height: 120px;
            background: rgba(15,107,79,.4);
            border-radius: 50%;
        }
        .ticket-header::after {
            content: '';
            position: absolute;
            bottom: -40px; left: 30%;
            width: 180px; height: 180px;
            background: rgba(198,163,78,.08);
            border-radius: 50%;
        }
        .org-label {
            color: #C6A34E;
            font-size: 7.5px;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 6px;
        }
        .event-title {
            color: #FFFFFF;
            font-size: 20px;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 3px;
        }
        .event-sub {
            color: rgba(255,255,255,.6);
            font-size: 9px;
        }

        /* Gold Divider */
        .gold-strip {
            height: 4px;
            background: linear-gradient(90deg, #0F6B4F, #C6A34E, #0F6B4F);
        }

        /* Body */
        .ticket-body {
            padding: 22px 28px;
        }

        /* QR Section */
        .qr-section {
            display: flex;
            align-items: center;
            gap: 20px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-left: 4px solid #C6A34E;
            border-radius: 10px;
            padding: 16px 20px;
            margin-bottom: 20px;
        }
        .qr-img {
            width: 110px;
            height: 110px;
            flex-shrink: 0;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 4px;
            background: white;
        }
        .qr-info { flex: 1; }
        .ticket-code-label {
            font-size: 8px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        .ticket-code-value {
            font-size: 16px;
            font-weight: 700;
            color: #0B1F3B;
            letter-spacing: 1px;
            background: rgba(198,163,78,.12);
            border: 1.5px dashed #C6A34E;
            padding: 5px 12px;
            border-radius: 7px;
            display: inline-block;
            margin-bottom: 8px;
        }
        .qr-hint {
            font-size: 8px;
            color: #9ca3af;
            line-height: 1.5;
        }

        /* Info Table */
        .info-section { margin-bottom: 18px; }
        .section-title {
            font-size: 8px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #9ca3af;
            margin-bottom: 8px;
            padding-bottom: 5px;
            border-bottom: 1px solid #f3f4f6;
        }
        .info-grid {
            display: table;
            width: 100%;
        }
        .info-row {
            display: table-row;
        }
        .info-label {
            display: table-cell;
            width: 110px;
            font-size: 9.5px;
            color: #6b7280;
            padding: 4px 0;
            font-weight: 600;
            vertical-align: top;
        }
        .info-sep {
            display: table-cell;
            width: 16px;
            color: #d1d5db;
            padding: 4px 0;
        }
        .info-value {
            display: table-cell;
            font-size: 9.5px;
            color: #111827;
            padding: 4px 0;
            font-weight: 500;
        }

        /* Divider */
        .perforated {
            border: none;
            border-top: 2px dashed #e5e7eb;
            margin: 16px 0;
            position: relative;
        }

        /* Footer */
        .ticket-footer {
            background: #0B1F3B;
            padding: 14px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .footer-org {
            color: #C6A34E;
            font-size: 8.5px;
            font-weight: 700;
        }
        .footer-campus {
            color: rgba(255,255,255,.4);
            font-size: 7.5px;
            margin-top: 2px;
        }
        .footer-status {
            background: rgba(15,107,79,.25);
            border: 1px solid rgba(15,107,79,.6);
            padding: 4px 12px;
            border-radius: 50px;
            color: #4ade80;
            font-size: 8px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        /* Watermark */
        .watermark {
            position: fixed;
            bottom: 60px;
            right: 20px;
            font-size: 60px;
            color: rgba(198,163,78,.06);
            font-weight: 900;
            transform: rotate(-30deg);
            pointer-events: none;
        }
    </style>
</head>
<body>
<div class="ticket">

    <!-- Header -->
    <div class="ticket-header">
        <div class="org-label">✦ GI-BEI PSDKU POLINEMA KEDIRI ✦</div>
        <div class="event-title">Sekolah Pasar Modal<br>Financial Glow Up 2026</div>
        <div class="event-sub">Simple Investment For a More Secure Future</div>
    </div>
    <div class="gold-strip"></div>

    <!-- Body -->
    <div class="ticket-body">

        <!-- QR + Code -->
        <div class="qr-section">
            <img src="{{ $qrPath }}" class="qr-img" alt="QR Code">
            <div class="qr-info">
                <div class="ticket-code-label">Kode Tiket</div>
                <div class="ticket-code-value">{{ $participant->ticket_code }}</div>
                <div class="qr-hint">
                    Tunjukkan QR Code ini kepada panitia<br>
                    saat tiba di lokasi acara untuk absensi.
                </div>
            </div>
        </div>

        <!-- Data Peserta -->
        <div class="info-section">
            <div class="section-title">Data Peserta</div>
            <div class="info-grid">
                <div class="info-row">
                    <span class="info-label">Nama Lengkap</span>
                    <span class="info-sep">:</span>
                    <span class="info-value">{{ $participant->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-sep">:</span>
                    <span class="info-value">{{ $participant->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">No. HP</span>
                    <span class="info-sep">:</span>
                    <span class="info-value">{{ $participant->phone }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Range Umur</span>
                    <span class="info-sep">:</span>
                    <span class="info-value">{{ $participant->age_range }} tahun</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Asal Instansi</span>
                    <span class="info-sep">:</span>
                    <span class="info-value">{{ $participant->institution }}</span>
                </div>
            </div>
        </div>

        <hr class="perforated">

        <!-- Info Event -->
        <div class="info-section">
            <div class="section-title">Informasi Event</div>
            <div class="info-grid">
                <div class="info-row">
                    <span class="info-label">Event</span>
                    <span class="info-sep">:</span>
                    <span class="info-value">Sekolah Pasar Modal – Financial Glow Up 2026</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Penyelenggara</span>
                    <span class="info-sep">:</span>
                    <span class="info-value">GI-BEI PSDKU POLINEMA KEDIRI</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Kampus</span>
                    <span class="info-sep">:</span>
                    <span class="info-value">PSDKU Politeknik Negeri Malang Kota Kediri</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status</span>
                    <span class="info-sep">:</span>
                    <span class="info-value" style="color:#0F6B4F; font-weight:700;">✅ DITERIMA</span>
                </div>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <div class="ticket-footer">
        <div>
            <div class="footer-org">GI-BEI PSDKU POLINEMA KEDIRI</div>
            <div class="footer-campus">PSDKU Politeknik Negeri Malang Kota Kediri</div>
        </div>
        <div class="footer-status">VALID ✓</div>
    </div>

    <div class="watermark">SPM</div>
</div>
</body>
</html>
