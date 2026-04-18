{{-- resources/views/admin/dashboard.blade.php --}}
@extends('admin.layout')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="stat-grid">
    <div class="stat-card blue">
        <div class="stat-label">Total Pendaftar</div>
        <div class="stat-value">{{ $total }}</div>
        <div class="stat-sub">Semua form masuk</div>
    </div>
    <div class="stat-card gold">
        <div class="stat-label">Menunggu Verifikasi</div>
        <div class="stat-value">{{ $pending }}</div>
        <div class="stat-sub">Perlu dicek pembayaran</div>
    </div>
    <div class="stat-card green">
        <div class="stat-label">Diterima</div>
        <div class="stat-value">{{ $accepted }}</div>
        <div class="stat-sub">Tiket sudah dikirim</div>
    </div>
    <div class="stat-card teal">
        <div class="stat-label">Hadir</div>
        <div class="stat-value">{{ $hadir }}</div>
        <div class="stat-sub">Scan QR berhasil</div>
    </div>
    <div class="stat-card red">
        <div class="stat-label">Belum Hadir</div>
        <div class="stat-value">{{ $belumHadir }}</div>
        <div class="stat-sub">Dari peserta diterima</div>
    </div>
</div>

<!-- Charts -->
<div class="chart-grid">
    <!-- Participant Status Chart -->
    <div class="chart-card">
        <div class="chart-title">📊 Status Peserta</div>
        <canvas id="statusChart" height="220"></canvas>
    </div>
    <!-- Attendance Chart -->
    <div class="chart-card">
        <div class="chart-title">✅ Kehadiran Peserta</div>
        <canvas id="attendanceChart" height="220"></canvas>
    </div>
    <!-- Age Range Chart -->
    <div class="chart-card">
        <div class="chart-title">🎂 Distribusi Umur</div>
        <canvas id="ageChart" height="220"></canvas>
    </div>
    <!-- Info Source Chart -->
    <div class="chart-card">
        <div class="chart-title">📣 Sumber Informasi</div>
        <canvas id="sourceChart" height="220"></canvas>
    </div>
</div>

<!-- Quick Actions & Settings -->
<div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap:1.5rem;" id="settings">
    <!-- Form Control -->
    <div class="chart-card">
        <div class="chart-title">⚙️ Kontrol Form Pendaftaran</div>
        <p style="color:rgba(255,255,255,.5); font-size:.88rem; margin-bottom:1.25rem;">
            Status saat ini:
            <strong style="{{ $setting->form_open ? 'color:#4ade80' : 'color:#f87171' }}">
                {{ $setting->form_open ? 'TERBUKA' : 'DITUTUP' }}
            </strong>
        </p>
        <form method="POST" action="{{ route('admin.settings.toggle-form') }}">
            @csrf
            <button type="submit" class="btn {{ $setting->form_open ? 'btn-red' : 'btn-green' }}"
                style="padding:.65rem 1.5rem; font-size:.9rem;"
                onclick="return confirm('{{ $setting->form_open ? 'Tutup form pendaftaran?' : 'Buka form pendaftaran?' }}')">
                {{ $setting->form_open ? '🔒 Tutup Form Pendaftaran' : '🔓 Buka Form Pendaftaran' }}
            </button>
        </form>
    </div>

    <!-- Header Image Upload -->
    <div class="chart-card">
        <div class="chart-title">🖼️ Upload Foto Header Form</div>
        @if($setting->header_image)
        <img src="{{ Storage::url($setting->header_image) }}" alt="Header"
             style="width:100%; height:100px; object-fit:cover; border-radius:10px; margin-bottom:1rem;">
        @endif
        <form method="POST" action="{{ route('admin.settings.upload-header') }}" enctype="multipart/form-data">
            @csrf
            <div style="display:flex; gap:.75rem; align-items:center; flex-wrap:wrap;">
                <input type="file" name="header_image" accept="image/*" class="input-sm" required style="flex:1; min-width:160px;">
                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
            <div style="font-size:.75rem; color:rgba(255,255,255,.35); margin-top:.5rem;">PNG, JPG · Maks 2MB</div>
        </form>
    </div>

    <!-- Quick Links -->
    <div class="chart-card">
        <div class="chart-title">🚀 Aksi Cepat</div>
        <div style="display:flex; flex-direction:column; gap:.75rem;">
            <a href="{{ route('admin.participants') }}?status=pending" class="btn btn-gold" style="justify-content:center; padding:.65rem;">
                👁️ Cek Pembayaran Pending ({{ $pending }})
            </a>
            <a href="{{ route('admin.scan') }}" class="btn btn-primary" style="justify-content:center; padding:.65rem;">
                📷 Buka Scanner QR
            </a>
            <a href="{{ route('admin.attendance') }}" class="btn btn-blue" style="justify-content:center; padding:.65rem;">
                📋 Lihat Data Kehadiran
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const chartDefaults = {
    plugins: { legend: { labels: { color: 'rgba(255,255,255,.65)', font: { family: 'DM Sans' } } } },
    scales: { x: { ticks: { color: 'rgba(255,255,255,.5)' }, grid: { color: 'rgba(255,255,255,.06)' } },
              y: { ticks: { color: 'rgba(255,255,255,.5)' }, grid: { color: 'rgba(255,255,255,.06)' } } }
};

// Status Chart
new Chart(document.getElementById('statusChart'), {
    type: 'bar',
    data: {
        labels: ['Pending', 'Diterima', 'Ditolak'],
        datasets: [{
            label: 'Jumlah',
            data: [{{ $pending }}, {{ $accepted }}, {{ $rejected }}],
            backgroundColor: ['rgba(251,191,36,.6)', 'rgba(34,197,94,.6)', 'rgba(239,68,68,.6)'],
            borderColor: ['#fbbf24','#22c55e','#ef4444'],
            borderWidth: 1, borderRadius: 8,
        }]
    },
    options: { ...chartDefaults, plugins: { ...chartDefaults.plugins, legend: { display: false } } }
});

// Attendance Chart
new Chart(document.getElementById('attendanceChart'), {
    type: 'doughnut',
    data: {
        labels: ['Hadir', 'Belum Hadir'],
        datasets: [{
            data: [{{ $hadir }}, {{ $belumHadir }}],
            backgroundColor: ['rgba(20,184,166,.7)', 'rgba(255,255,255,.1)'],
            borderColor: ['#14b8a6','rgba(255,255,255,.15)'],
            borderWidth: 2,
        }]
    },
    options: { plugins: chartDefaults.plugins, cutout: '65%' }
});

// Age Chart
const ageLabels = @json($ageStats->keys());
const ageData   = @json($ageStats->values());
new Chart(document.getElementById('ageChart'), {
    type: 'bar',
    data: {
        labels: ageLabels.map(l => l + ' thn'),
        datasets: [{
            label: 'Peserta',
            data: ageData,
            backgroundColor: ['rgba(198,163,78,.6)', 'rgba(15,107,79,.6)', 'rgba(59,130,246,.6)'],
            borderRadius: 8,
        }]
    },
    options: { ...chartDefaults, plugins: { ...chartDefaults.plugins, legend: { display: false } } }
});

// Source Chart
const srcLabels = @json($sourceStats->keys());
const srcData   = @json($sourceStats->values());
new Chart(document.getElementById('sourceChart'), {
    type: 'pie',
    data: {
        labels: srcLabels,
        datasets: [{
            data: srcData,
            backgroundColor: ['rgba(198,163,78,.7)','rgba(15,107,79,.7)','rgba(59,130,246,.7)','rgba(168,85,247,.7)'],
            borderColor: ['#C6A34E','#0F6B4F','#3b82f6','#a855f7'],
            borderWidth: 2,
        }]
    },
    options: { plugins: chartDefaults.plugins }
});
</script>
@endpush
