{{-- resources/views/form/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sekolah Pasar Modal – Financial Glow Up 2026</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy:  #0B1F3B;
            --green: #0F6B4F;
            --gold:  #C6A34E;
            --white: #FFFFFF;
            --navy-light: #132d54;
            --green-light: #14875f;
            --gold-light: #d4b46a;
            --surface: rgba(255,255,255,0.04);
            --border:  rgba(198,163,78,0.25);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--navy);
            color: var(--white);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ── BACKGROUND ── */
        .bg-pattern {
            position: fixed; inset: 0; z-index: 0; pointer-events: none;
            background: radial-gradient(ellipse 80% 60% at 20% -10%, rgba(15,107,79,.35) 0%, transparent 60%),
                        radial-gradient(ellipse 60% 50% at 90% 100%, rgba(198,163,78,.15) 0%, transparent 60%),
                        var(--navy);
        }
        .bg-pattern::before {
            content: '';
            position: absolute; inset: 0;
            background-image: repeating-linear-gradient(
                90deg, rgba(198,163,78,.04) 0px, rgba(198,163,78,.04) 1px, transparent 1px, transparent 80px
            ), repeating-linear-gradient(
                0deg, rgba(198,163,78,.04) 0px, rgba(198,163,78,.04) 1px, transparent 1px, transparent 80px
            );
        }

        /* ── LAYOUT ── */
        .page-wrap { position: relative; z-index: 1; }

        /* ── TOP BAR ── */
        .topbar {
            display: flex; justify-content: flex-end; align-items: center;
            padding: 1rem 2rem;
        }
        .btn-admin {
            display: flex; align-items: center; gap: .5rem;
            padding: .55rem 1.25rem;
            background: rgba(198,163,78,.1);
            border: 1px solid var(--gold);
            color: var(--gold);
            border-radius: 50px;
            font-family: 'DM Sans', sans-serif;
            font-size: .82rem;
            font-weight: 600;
            letter-spacing: .05em;
            text-transform: uppercase;
            text-decoration: none;
            transition: all .25s;
            cursor: pointer;
        }
        .btn-admin:hover { background: var(--gold); color: var(--navy); }
        .btn-admin svg { width: 16px; height: 16px; }

        /* ── HERO ── */
        .hero {
            text-align: center;
            padding: 2rem 1.5rem 3rem;
        }
        .hero-header-img {
            width: 100%; max-height: 280px; object-fit: cover;
            border-radius: 20px;
            margin-bottom: 2.5rem;
            box-shadow: 0 20px 60px rgba(0,0,0,.5);
            display: block;
        }
        .hero-header-placeholder {
            width: 100%; height: 240px;
            background: linear-gradient(135deg, var(--navy-light) 0%, var(--green) 100%);
            border-radius: 20px;
            margin-bottom: 2.5rem;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            border: 1px solid var(--border);
            position: relative; overflow: hidden;
        }
        .hero-header-placeholder::before {
            content: '';
            position: absolute; inset: 0;
            background: repeating-linear-gradient(45deg, transparent 0px, transparent 10px, rgba(198,163,78,.05) 10px, rgba(198,163,78,.05) 11px);
        }
        .placeholder-logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            color: var(--gold);
            letter-spacing: .15em;
            text-transform: uppercase;
            position: relative;
        }

        .badge-org {
            display: inline-block;
            padding: .3rem 1rem;
            background: rgba(198,163,78,.15);
            border: 1px solid rgba(198,163,78,.4);
            border-radius: 50px;
            font-size: .78rem;
            color: var(--gold);
            letter-spacing: .08em;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 1.2rem;
        }
        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 900;
            line-height: 1.1;
            background: linear-gradient(135deg, var(--white) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: .75rem;
        }
        .hero h1 em {
            font-style: italic;
            -webkit-text-fill-color: transparent;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            background-clip: text;
        }
        .hero .subtitle {
            font-size: clamp(.95rem, 2vw, 1.15rem);
            color: rgba(255,255,255,.65);
            font-weight: 300;
            letter-spacing: .02em;
            margin-bottom: .5rem;
        }
        .hero .campus-tag {
            font-size: .88rem;
            color: rgba(255,255,255,.45);
        }

        /* ── FORM CARD ── */
        .form-container {
            max-width: 640px;
            margin: 0 auto;
            padding: 0 1.25rem 4rem;
        }
        .form-card {
            background: rgba(255,255,255,.04);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 2.5rem 2rem;
            position: relative;
            overflow: hidden;
        }
        .form-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, var(--green), var(--gold));
        }

        .form-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            color: var(--gold);
            margin-bottom: 1.75rem;
            display: flex; align-items: center; gap: .75rem;
        }
        .form-title::before {
            content: '';
            width: 4px; height: 28px;
            background: linear-gradient(to bottom, var(--green), var(--gold));
            border-radius: 4px;
            flex-shrink: 0;
        }

        /* ── FORM ELEMENTS ── */
        .form-group { margin-bottom: 1.5rem; }
        .form-label {
            display: block;
            font-size: .82rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: rgba(255,255,255,.55);
            margin-bottom: .6rem;
        }
        .form-label span { color: #ef4444; margin-left: 2px; }

        .form-control {
            width: 100%;
            padding: .85rem 1.1rem;
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 12px;
            color: var(--white);
            font-family: 'DM Sans', sans-serif;
            font-size: .95rem;
            transition: all .2s;
            outline: none;
            -webkit-appearance: none;
        }
        .form-control:focus {
            border-color: var(--gold);
            background: rgba(198,163,78,.08);
            box-shadow: 0 0 0 3px rgba(198,163,78,.15);
        }
        .form-control::placeholder { color: rgba(255,255,255,.3); }
        .form-control option { background: #1a2f50; color: var(--white); }

        /* ── SELECT CUSTOM ── */
        .select-wrap { position: relative; }
        .select-wrap::after {
            content: '▾';
            position: absolute; right: 1rem; top: 50%; transform: translateY(-50%);
            color: var(--gold); pointer-events: none; font-size: 1rem;
        }

        /* ── RADIO GROUP ── */
        .radio-group { display: grid; gap: .6rem; }
        .radio-option {
            display: flex; align-items: center; gap: .75rem;
            padding: .75rem 1rem;
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: 12px;
            cursor: pointer;
            transition: all .2s;
        }
        .radio-option:hover { border-color: rgba(198,163,78,.4); background: rgba(198,163,78,.06); }
        .radio-option input[type="radio"] {
            accent-color: var(--gold);
            width: 18px; height: 18px; flex-shrink: 0;
        }
        .radio-option input[type="radio"]:checked + span { color: var(--gold); }
        .radio-option.selected { border-color: var(--gold); background: rgba(198,163,78,.1); }
        .radio-option span { font-size: .92rem; }

        /* ── FILE UPLOAD ── */
        .file-drop {
            border: 2px dashed rgba(198,163,78,.35);
            border-radius: 14px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all .2s;
            position: relative;
        }
        .file-drop:hover, .file-drop.drag-over {
            border-color: var(--gold);
            background: rgba(198,163,78,.07);
        }
        .file-drop input[type="file"] {
            position: absolute; inset: 0; opacity: 0; cursor: pointer;
        }
        .file-drop-icon { font-size: 2.5rem; margin-bottom: .75rem; }
        .file-drop-text { font-size: .9rem; color: rgba(255,255,255,.6); }
        .file-drop-text strong { color: var(--gold); }
        .file-name { margin-top: .75rem; font-size: .85rem; color: var(--green-light); font-weight: 500; }

        /* ── SUBMIT ── */
        .btn-submit {
            width: 100%; padding: 1rem;
            background: linear-gradient(135deg, var(--green) 0%, var(--green-light) 100%);
            border: none; border-radius: 12px;
            color: var(--white);
            font-family: 'DM Sans', sans-serif;
            font-size: 1rem; font-weight: 700;
            letter-spacing: .05em;
            cursor: pointer;
            transition: all .25s;
            display: flex; align-items: center; justify-content: center; gap: .6rem;
            position: relative; overflow: hidden;
        }
        .btn-submit::after {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(135deg, transparent 0%, rgba(255,255,255,.08) 100%);
        }
        .btn-submit:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 12px 30px rgba(15,107,79,.45); }
        .btn-submit:disabled { opacity: .6; cursor: not-allowed; transform: none; }

        /* ── SUCCESS MODAL ── */
        .modal-overlay {
            position: fixed; inset: 0; z-index: 999;
            background: rgba(0,0,0,.75);
            backdrop-filter: blur(8px);
            display: flex; align-items: center; justify-content: center;
            padding: 1.5rem;
            opacity: 0; pointer-events: none;
            transition: opacity .3s;
        }
        .modal-overlay.active { opacity: 1; pointer-events: all; }
        .modal-box {
            background: linear-gradient(145deg, #112038 0%, #0d3028 100%);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 2.5rem 2rem;
            max-width: 440px; width: 100%;
            text-align: center;
            transform: translateY(20px); transition: transform .3s;
        }
        .modal-overlay.active .modal-box { transform: translateY(0); }
        .modal-icon { font-size: 3.5rem; margin-bottom: 1rem; }
        .modal-title { font-family: 'Playfair Display', serif; font-size: 1.6rem; color: var(--gold); margin-bottom: .75rem; }
        .modal-text { color: rgba(255,255,255,.7); font-size: .95rem; line-height: 1.7; margin-bottom: 1.5rem; }
        .modal-email { color: var(--green-light); font-weight: 600; }
        .btn-modal {
            display: inline-block; padding: .75rem 2rem;
            background: var(--gold); color: var(--navy);
            border-radius: 50px; font-weight: 700; font-size: .9rem;
            cursor: pointer; border: none; font-family: 'DM Sans', sans-serif;
            text-decoration: none; transition: all .2s;
        }
        .btn-modal:hover { background: var(--gold-light); }

        /* ── CLOSED BANNER ── */
        .closed-banner {
            background: linear-gradient(135deg, rgba(239,68,68,.15), rgba(239,68,68,.05));
            border: 1px solid rgba(239,68,68,.35);
            border-radius: 16px;
            padding: 2rem; text-align: center; margin-bottom: 1.5rem;
        }
        .closed-banner h3 { color: #f87171; font-size: 1.1rem; margin-bottom: .5rem; }
        .closed-banner p { color: rgba(255,255,255,.55); font-size: .88rem; }

        /* ── DIVIDER ── */
        .form-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--border), transparent);
            margin: 2rem 0;
        }

        /* ── ERROR ── */
        .form-error { color: #f87171; font-size: .8rem; margin-top: .4rem; }
        .form-control.is-invalid { border-color: #ef4444; }

        /* ── SPINNER ── */
        .spinner {
            width: 20px; height: 20px;
            border: 2px solid rgba(255,255,255,.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin .6s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ── ANIMATIONS ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .hero    { animation: fadeUp .7s ease both; }
        .form-card { animation: fadeUp .8s .15s ease both; }

        /* ── RESPONSIVE ── */
        @media (max-width: 480px) {
            .topbar { padding: .75rem 1rem; }
            .hero { padding: 1.5rem 1rem 2.5rem; }
            .form-card { padding: 1.75rem 1.25rem; }
            .radio-group { grid-template-columns: 1fr; }
        }
        @media (min-width: 600px) {
            .hero { padding: 2.5rem 2rem 3.5rem; }
        }
    </style>
</head>
<body>
<div class="bg-pattern"></div>
<div class="page-wrap">

    <!-- Topbar Admin Login -->
    <div class="topbar">
        <a href="{{ route('admin.login') }}" class="btn-admin">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A10 10 0 1119.07 7.072M15 11l-3 3m0 0l-3-3m3 3V3"/>
            </svg>
            Admin Login
        </a>
    </div>

    <!-- Hero Section -->
    <section class="hero" style="max-width:700px; margin:0 auto;">
        @if($setting->header_image)
            <img src="{{ Storage::url($setting->header_image) }}" alt="Header" class="hero-header-img">
        @else
            <div class="hero-header-placeholder">
                <div class="placeholder-logo">GI-BEI PSDKU POLINEMA KEDIRI</div>
                <div style="color:rgba(255,255,255,.4); font-size:.8rem; margin-top:.5rem;">Tambahkan foto header melalui admin panel</div>
            </div>
        @endif

        <div class="badge-org">✦ GI-BEI PSDKU POLINEMA KEDIRI ✦</div>
        <h1>Sekolah Pasar Modal<br><em>Financial Glow Up 2026</em></h1>
        <p class="subtitle">Simple Investment For a More Secure Future</p>
        <p class="campus-tag">PSDKU Politeknik Negeri Malang Kota Kediri</p>
    </section>

    <!-- Form Section -->
    <div class="form-container">
        <div class="form-card">
            <h2 class="form-title">Formulir Pendaftaran</h2>

            @if(!$setting->form_open)
            <div class="closed-banner">
                <h3>🔒 Pendaftaran Ditutup</h3>
                <p>Mohon maaf, pendaftaran sudah ditutup. Pantau informasi lebih lanjut melalui media sosial kami.</p>
            </div>
            @endif

            <form id="registrationForm" enctype="multipart/form-data" @if(!$setting->form_open) style="pointer-events:none;opacity:.5;" @endif>
                @csrf

                <!-- Nama -->
                <div class="form-group">
                    <label class="form-label" for="name">Nama Lengkap <span>*</span></label>
                    <input type="text" id="name" name="name" class="form-control"
                           placeholder="Masukkan nama lengkap Anda" autocomplete="name">
                    <div class="form-error" id="error-name"></div>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label class="form-label" for="email">Email Aktif <span>*</span></label>
                    <input type="email" id="email" name="email" class="form-control"
                           placeholder="contoh@email.com" autocomplete="email">
                    <div class="form-error" id="error-email"></div>
                    <div style="font-size:.78rem;color:rgba(255,255,255,.4);margin-top:.4rem;">
                        📧 Tiket akan dikirimkan ke email ini
                    </div>
                </div>

                <!-- Range Umur -->
                <div class="form-group">
                    <label class="form-label">Range Umur <span>*</span></label>
                    <div class="radio-group" id="age_range_group">
                        @foreach(['17-20','21-25','>25'] as $age)
                        <label class="radio-option">
                            <input type="radio" name="age_range" value="{{ $age }}">
                            <span>{{ $age }} tahun</span>
                        </label>
                        @endforeach
                    </div>
                    <div class="form-error" id="error-age_range"></div>
                </div>

                <!-- No. HP -->
                <div class="form-group">
                    <label class="form-label" for="phone">Nomor HP / WhatsApp <span>*</span></label>
                    <input type="tel" id="phone" name="phone" class="form-control"
                           placeholder="08xxxxxxxxxx" autocomplete="tel">
                    <div class="form-error" id="error-phone"></div>
                </div>

                <!-- Asal Instansi -->
                <div class="form-group">
                    <label class="form-label" for="institution">Asal Instansi / Kampus <span>*</span></label>
                    <input type="text" id="institution" name="institution" class="form-control"
                           placeholder="Nama kampus atau instansi Anda">
                    <div class="form-error" id="error-institution"></div>
                </div>

                <div class="form-divider"></div>

                <!-- Dapat Info Darimana -->
                <div class="form-group">
                    <label class="form-label">Dapat Info Darimana? <span>*</span></label>
                    <div class="radio-group" id="info_source_group">
                        @foreach(['Sosial Media','Teman / Referral','Kampus / Komunitas','Online (Web/Email)'] as $src)
                        <label class="radio-option">
                            <input type="radio" name="info_source" value="{{ $src }}">
                            <span>
                                @if($src === 'Sosial Media') 📱 @elseif($src === 'Teman / Referral') 🤝 @elseif($src === 'Kampus / Komunitas') 🏫 @else 🌐 @endif
                                {{ $src }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                    <div class="form-error" id="error-info_source"></div>
                </div>

                <div class="form-divider"></div>

                <!-- Bukti Pembayaran -->
                <div class="form-group">
                    <label class="form-label">Bukti Pembayaran <span>*</span></label>
                    <div class="file-drop" id="fileDrop">
                        <input type="file" id="payment_proof" name="payment_proof" accept=".jpg,.jpeg,.png,.pdf">
                        <div class="file-drop-icon">📎</div>
                        <div class="file-drop-text">
                            <strong>Klik atau seret file ke sini</strong><br>
                            JPG, PNG, atau PDF · Maks. 5MB
                        </div>
                        <div class="file-name" id="fileName" style="display:none"></div>
                    </div>
                    <div class="form-error" id="error-payment_proof"></div>
                </div>

                <button type="submit" class="btn-submit" id="submitBtn">
                    <span id="submitText">Daftar Sekarang</span>
                    <span id="submitIcon">✦</span>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal-overlay" id="successModal">
    <div class="modal-box">
        <div class="modal-icon">🎉</div>
        <h3 class="modal-title">Pendaftaran Berhasil!</h3>
        <p class="modal-text">
            Terima kasih, <strong id="modalName"></strong>!<br>
            Formulir Anda telah kami terima. Setelah admin memverifikasi bukti pembayaran,
            tiket akan dikirimkan ke:<br>
            <span class="modal-email" id="modalEmail"></span>
        </p>
        <a href="https://mail.google.com" target="_blank" class="btn-modal">Buka Gmail →</a>
        <div style="margin-top:1rem">
            <button class="btn-modal" style="background:rgba(255,255,255,.1);color:white;" onclick="closeModal()">Tutup</button>
        </div>
    </div>
</div>

<!-- Error Modal - Contact Admin -->
<div class="modal-overlay" id="errorModal">
    <div class="modal-box">
        <div class="modal-icon">⚠️</div>
        <h3 class="modal-title">Terjadi Kendala</h3>
        <p class="modal-text" id="errorMessage">
            Gagal mengirimkan formulir. Silakan coba lagi atau hubungi admin melalui WhatsApp.
        </p>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 1.5rem;">
            <button class="btn-modal" style="background:rgba(255,255,255,.1);color:white; width: 100%; padding: 0.75rem 1rem;" onclick="closeErrorModal()">Coba Lagi</button>
            <a id="whatsappLink" href="#" target="_blank" class="btn-modal" style="width: 100%; padding: 0.75rem 1rem; background: linear-gradient(135deg, #25d366, #20ba5c); text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                💬 Chat Admin
            </a>
        </div>
    </div>
</div>

<script>
// Radio group highlight
document.querySelectorAll('.radio-option input[type="radio"]').forEach(radio => {
    radio.addEventListener('change', () => {
        const group = radio.closest('.radio-group');
        group.querySelectorAll('.radio-option').forEach(o => o.classList.remove('selected'));
        radio.closest('.radio-option').classList.add('selected');
    });
});

// File drop
const fileDrop = document.getElementById('fileDrop');
const fileInput = document.getElementById('payment_proof');
const fileName  = document.getElementById('fileName');

fileInput.addEventListener('change', () => {
    if (fileInput.files[0]) {
        fileName.textContent = '✅ ' + fileInput.files[0].name;
        fileName.style.display = 'block';
    }
});
['dragover','dragenter'].forEach(e => fileDrop.addEventListener(e, ev => {
    ev.preventDefault(); fileDrop.classList.add('drag-over');
}));
['dragleave','drop'].forEach(e => fileDrop.addEventListener(e, () => fileDrop.classList.remove('drag-over')));
fileDrop.addEventListener('drop', ev => {
    ev.preventDefault();
    if (ev.dataTransfer.files[0]) {
        fileInput.files = ev.dataTransfer.files;
        fileName.textContent = '✅ ' + ev.dataTransfer.files[0].name;
        fileName.style.display = 'block';
    }
});

// Form submit
document.getElementById('registrationForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    clearErrors();

    const btn      = document.getElementById('submitBtn');
    const btnText  = document.getElementById('submitText');
    const btnIcon  = document.getElementById('submitIcon');

    btn.disabled = true;
    btnText.textContent = 'Mengirim...';
    btnIcon.innerHTML   = '<div class="spinner"></div>';

    const formData = new FormData(this);

    try {
        const res  = await fetch('{{ route("form.store") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: formData,
            timeout: 30000,
        });

        let data;
        try {
            data = await res.json();
        } catch (e) {
            console.error('Invalid JSON response:', res);
            showErrorModal('Server bermasalah. Silakan coba lagi atau hubungi admin.');
            throw e;
        }

        if (res.ok && data.success) {
            document.getElementById('modalName').textContent  = data.name;
            document.getElementById('modalEmail').textContent = data.email;
            document.getElementById('successModal').classList.add('active');
            this.reset();
            document.querySelectorAll('.radio-option').forEach(o => o.classList.remove('selected'));
            document.getElementById('fileName').style.display = 'none';
        } else if (res.status === 422) {
            const errors = data.errors || {};
            Object.entries(errors).forEach(([key, msgs]) => {
                const el = document.getElementById('error-' + key.replace('.', '_'));
                const ctrl = document.querySelector(`[name="${key}"]`);
                if (el) el.textContent = msgs[0];
                if (ctrl) ctrl.classList.add('is-invalid');
            });
        } else if (res.status >= 500) {
            showErrorModal(data.message || 'Server error. Coba lagi nanti.');
        } else {
            showErrorModal(data.message || 'Gagal mengirim formulir. Coba lagi.');
        }
    } catch (error) {
        console.error('Form submission error:', error);
        showErrorModal('Koneksi gagal. Periksa koneksi internet Anda. Ukuran file harus maksimal 5MB.');
    } finally {
        btn.disabled = false;
        btnText.textContent = 'Daftar Sekarang';
        btnIcon.textContent = '✦';
    }
});

function showErrorModal(message) {
    document.getElementById('errorMessage').textContent = message;
    
    // Generate WhatsApp link with pre-filled message
    const adminPhone = '6285731932717'; // Format: 62857... (no + or 0)
    const whatsappMessage = encodeURIComponent(
        `Halo Admin,\n\n` +
        `Saya ingin melaporkan kendala saat register ke formulir Sekolah Pasar Modal Financial Glow Up 2026.\n\n` +
        `Kendala: ${message}\n\n` +
        `Mohon bantuan. Terima kasih.`
    );
    
    const whatsappLink = `https://wa.me/${adminPhone}?text=${whatsappMessage}`;
    document.getElementById('whatsappLink').href = whatsappLink;
    document.getElementById('errorModal').classList.add('active');
}

function closeErrorModal() {
    document.getElementById('errorModal').classList.remove('active');
}

function clearErrors() {
    document.querySelectorAll('.form-error').forEach(e => e.textContent = '');
    document.querySelectorAll('.is-invalid').forEach(e => e.classList.remove('is-invalid'));
}

function closeModal() {
    document.getElementById('successModal').classList.remove('active');
}

// Close modals on outside click
document.getElementById('successModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});

document.getElementById('errorModal').addEventListener('click', function(e) {
    if (e.target === this) closeErrorModal();
});
</script>
</body>
</html>
