{{-- resources/views/admin/scan.blade.php --}}
@extends('admin.layout')

@section('title', 'Scan QR')
@section('page-title', 'Scanner QR Kehadiran')

@section('content')
<div style="max-width:560px; margin:0 auto;">

    <!-- Scanner Card -->
    <div class="chart-card" style="text-align:center; margin-bottom:1.5rem;">
        <div class="chart-title" style="text-align:left;">📷 Kamera QR Scanner</div>

        <div id="scannerWrap" style="position:relative; width:100%; max-width:420px; margin:0 auto 1.25rem;">
            <div id="cameraPreview" style="
                background:#000; border-radius:16px; overflow:hidden;
                position:relative; width:100%; aspect-ratio:1;
                border:2px solid rgba(198,163,78,.3);
            ">
                <video id="video" style="width:100%; height:100%; object-fit:cover; display:none;" playsinline></video>
                <canvas id="canvas" style="display:none;"></canvas>

                <!-- Idle state -->
                <div id="idleState" style="
                    position:absolute; inset:0; display:flex; flex-direction:column;
                    align-items:center; justify-content:center; gap:.75rem;
                    background:rgba(11,31,59,.9);
                ">
                    <div style="font-size:3.5rem;">📷</div>
                    <p style="color:rgba(255,255,255,.55); font-size:.9rem;">Kamera belum aktif</p>
                </div>

                <!-- Scan Overlay -->
                <div id="scanOverlay" style="display:none; position:absolute; inset:0; pointer-events:none;">
                    <div style="
                        position:absolute; top:50%; left:50%; transform:translate(-50%,-50%);
                        width:200px; height:200px;
                    ">
                        <div style="position:absolute; top:0; left:0; width:30px; height:30px; border-top:3px solid var(--gold); border-left:3px solid var(--gold); border-radius:3px 0 0 0;"></div>
                        <div style="position:absolute; top:0; right:0; width:30px; height:30px; border-top:3px solid var(--gold); border-right:3px solid var(--gold); border-radius:0 3px 0 0;"></div>
                        <div style="position:absolute; bottom:0; left:0; width:30px; height:30px; border-bottom:3px solid var(--gold); border-left:3px solid var(--gold); border-radius:0 0 0 3px;"></div>
                        <div style="position:absolute; bottom:0; right:0; width:30px; height:30px; border-bottom:3px solid var(--gold); border-right:3px solid var(--gold); border-radius:0 0 3px 0;"></div>
                        <div id="scanLine" style="
                            position:absolute; left:8px; right:8px; top:0;
                            height:2px; background:linear-gradient(90deg, transparent, var(--gold), transparent);
                            animation: scanAnim 2s linear infinite;
                        "></div>
                    </div>
                </div>
            </div>
        </div>

        <div style="display:flex; gap:.75rem; justify-content:center; flex-wrap:wrap;">
            <button id="btnStart" class="btn btn-primary" onclick="startCamera()" style="padding:.65rem 1.5rem;">
                📷 Aktifkan Kamera
            </button>
            <button id="btnStop" class="btn btn-red" onclick="stopCamera()" style="display:none; padding:.65rem 1.5rem;">
                ⏹ Stop Kamera
            </button>
        </div>

        <p style="font-size:.78rem; color:rgba(255,255,255,.35); margin-top:.75rem;">
            Arahkan kamera ke QR code pada tiket peserta
        </p>
    </div>

    <!-- Manual Input -->
    <div class="chart-card" style="margin-bottom:1.5rem;">
        <div class="chart-title">⌨️ Input Manual Kode Tiket</div>
        <div style="display:flex; gap:.75rem;">
            <input type="text" id="manualCode" class="input-sm" placeholder="Contoh: SPM-2026-0001"
                   style="flex:1; text-transform:uppercase; font-family:monospace; font-size:.95rem;"
                   oninput="this.value = this.value.toUpperCase()">
            <button class="btn btn-gold" onclick="processManual()" style="padding:.65rem 1.25rem; font-size:.9rem;">
                Verifikasi
            </button>
        </div>
    </div>

    <!-- Result Card -->
    <div id="resultCard" style="display:none;" class="chart-card">
        <div id="resultIcon" style="font-size:3rem; text-align:center; margin-bottom:.75rem;"></div>
        <div id="resultMessage" style="text-align:center; font-size:1rem; font-weight:600; margin-bottom:1rem;"></div>
        <div id="resultDetails" style="background:rgba(255,255,255,.04); border-radius:12px; padding:1rem; font-size:.88rem; line-height:2;"></div>
        <button onclick="resetScanner()" class="btn btn-gold" style="margin-top:1rem; width:100%; justify-content:center; padding:.65rem;">
            🔄 Scan Berikutnya
        </button>
    </div>

    <!-- Recent Scans -->
    <div class="chart-card">
        <div class="chart-title">📝 Scan Terbaru (sesi ini)</div>
        <div id="recentScans">
            <p style="color:rgba(255,255,255,.3); font-size:.85rem; text-align:center; padding:1rem 0;">
                Belum ada scan dalam sesi ini
            </p>
        </div>
    </div>
</div>

<style>
@keyframes scanAnim {
    0%   { top: 8px; }
    50%  { top: calc(100% - 10px); }
    100% { top: 8px; }
}
.scan-entry {
    display:flex; align-items:center; gap:.75rem;
    padding:.6rem .75rem;
    border-radius:10px;
    margin-bottom:.5rem;
    font-size:.85rem;
}
.scan-entry.ok   { background:rgba(20,184,166,.1); border:1px solid rgba(20,184,166,.2); }
.scan-entry.warn { background:rgba(251,191,36,.08); border:1px solid rgba(251,191,36,.2); }
.scan-entry.err  { background:rgba(239,68,68,.08); border:1px solid rgba(239,68,68,.2); }
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
<script>
let stream = null;
let scanning = false;
let lastCode = '';
let lastTime = 0;
const COOLDOWN = 3000;
const recentScans = [];

const video   = document.getElementById('video');
const canvas  = document.getElementById('canvas');
const ctx     = canvas.getContext('2d');

async function startCamera() {
    try {
        stream = await navigator.mediaDevices.getUserMedia({
            video: { facingMode: 'environment', width: { ideal: 640 }, height: { ideal: 640 } }
        });
        video.srcObject = stream;
        await video.play();
        video.style.display = 'block';
        document.getElementById('idleState').style.display = 'none';
        document.getElementById('scanOverlay').style.display = 'block';
        document.getElementById('btnStart').style.display = 'none';
        document.getElementById('btnStop').style.display = 'inline-flex';
        scanning = true;
        requestAnimationFrame(tick);
    } catch(e) {
        alert('Tidak bisa mengakses kamera: ' + e.message + '\nPastikan izin kamera sudah diberikan.');
    }
}

function stopCamera() {
    scanning = false;
    if (stream) stream.getTracks().forEach(t => t.stop());
    video.style.display = 'none';
    document.getElementById('idleState').style.display = 'flex';
    document.getElementById('scanOverlay').style.display = 'none';
    document.getElementById('btnStart').style.display = 'inline-flex';
    document.getElementById('btnStop').style.display = 'none';
}

function tick() {
    if (!scanning) return;
    if (video.readyState === video.HAVE_ENOUGH_DATA) {
        canvas.width  = video.videoWidth;
        canvas.height = video.videoHeight;
        ctx.drawImage(video, 0, 0);
        const img  = ctx.getImageData(0, 0, canvas.width, canvas.height);
        const code = jsQR(img.data, img.width, img.height, { inversionAttempts: 'dontInvert' });
        if (code && code.data) {
            const now = Date.now();
            if (code.data !== lastCode || (now - lastTime) > COOLDOWN) {
                lastCode = code.data;
                lastTime = now;
                processCode(code.data);
            }
        }
    }
    requestAnimationFrame(tick);
}

function processManual() {
    const code = document.getElementById('manualCode').value.trim();
    if (!code) { alert('Masukkan kode tiket terlebih dahulu.'); return; }
    processCode(code);
    document.getElementById('manualCode').value = '';
}

async function processCode(ticketCode) {
    try {
        const res  = await fetch('{{ route("admin.scan.process") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ ticket_code: ticketCode }),
        });
        const data = await res.json();
        showResult(data, res.status);
        addRecentScan(data, res.status);
    } catch(e) {
        showResult({ success: false, message: 'Koneksi gagal.' }, 500);
    }
}

function showResult(data, status) {
    const card = document.getElementById('resultCard');
    const icon = document.getElementById('resultIcon');
    const msg  = document.getElementById('resultMessage');
    const det  = document.getElementById('resultDetails');
    card.style.display = 'block';
    card.scrollIntoView({ behavior: 'smooth', block: 'center' });

    if (data.success) {
        card.style.border = '1px solid rgba(20,184,166,.4)';
        icon.textContent = '✅';
        msg.style.color  = '#2dd4bf';
        msg.textContent  = data.message;
        det.innerHTML = `
            <div><strong style="color:rgba(255,255,255,.5)">Nama</strong> &nbsp; ${data.name}</div>
            <div><strong style="color:rgba(255,255,255,.5)">Tiket</strong> &nbsp; <span style="font-family:monospace;color:var(--gold)">${data.ticket_code}</span></div>
            <div><strong style="color:rgba(255,255,255,.5)">Instansi</strong> &nbsp; ${data.institution}</div>
            <div><strong style="color:rgba(255,255,255,.5)">Waktu</strong> &nbsp; ${data.scanned_at}</div>
        `;
    } else if (data.already) {
        card.style.border = '1px solid rgba(251,191,36,.35)';
        icon.textContent = '⚠️';
        msg.style.color  = '#fbbf24';
        msg.textContent  = data.message;
        det.innerHTML = `<div>Peserta: <strong>${data.name}</strong> (${data.ticket_code})</div>`;
    } else {
        card.style.border = '1px solid rgba(239,68,68,.35)';
        icon.textContent = '❌';
        msg.style.color  = '#f87171';
        msg.textContent  = data.message;
        det.innerHTML    = '';
    }
}

function resetScanner() {
    document.getElementById('resultCard').style.display = 'none';
}

function addRecentScan(data, status) {
    const wrap = document.getElementById('recentScans');
    if (wrap.querySelector('p')) wrap.innerHTML = '';

    const now  = new Date().toLocaleTimeString('id-ID');
    const cls  = data.success ? 'ok' : (data.already ? 'warn' : 'err');
    const ico  = data.success ? '✅' : (data.already ? '⚠️' : '❌');
    const div  = document.createElement('div');
    div.className = 'scan-entry ' + cls;
    div.innerHTML = `
        <span>${ico}</span>
        <span style="flex:1; font-weight:500;">${data.name || 'Tidak ditemukan'}</span>
        <span style="color:rgba(255,255,255,.4); font-size:.78rem;">${now}</span>
    `;
    wrap.prepend(div);
    recentScans.unshift(data);
}
</script>
@endpush
