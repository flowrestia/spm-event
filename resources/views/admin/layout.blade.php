{{-- resources/views/admin/layout.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — SPM 2026</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root { --navy:#0B1F3B; --navy-light:#132d54; --green:#0F6B4F; --gold:#C6A34E; --gold-light:#d4b46a; --white:#FFFFFF; --sidebar-w:260px; }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DM Sans', sans-serif; background: #0a1828; color: var(--white); display: flex; min-height: 100vh; }

        /* SIDEBAR */
        .sidebar {
            width: var(--sidebar-w); min-height: 100vh;
            background: linear-gradient(180deg, var(--navy) 0%, #0a1a30 100%);
            border-right: 1px solid rgba(198,163,78,.15);
            display: flex; flex-direction: column;
            position: fixed; top: 0; left: 0; z-index: 100;
            transition: transform .3s;
        }
        .sidebar-brand {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(198,163,78,.15);
        }
        .sidebar-brand .org { font-size: .68rem; color: var(--gold); letter-spacing: .1em; text-transform: uppercase; font-weight: 600; }
        .sidebar-brand h2 { font-family: 'Playfair Display', serif; font-size: 1rem; line-height: 1.3; margin-top: .3rem; }

        .sidebar-nav { flex: 1; padding: 1rem 0; }
        .nav-label { font-size: .65rem; color: rgba(255,255,255,.35); text-transform: uppercase; letter-spacing: .1em; font-weight: 600; padding: .75rem 1.25rem .25rem; }
        .nav-item {
            display: flex; align-items: center; gap: .75rem;
            padding: .7rem 1.25rem;
            color: rgba(255,255,255,.55);
            text-decoration: none; font-size: .9rem; font-weight: 500;
            transition: all .2s; position: relative;
        }
        .nav-item:hover { color: var(--white); background: rgba(255,255,255,.05); }
        .nav-item.active {
            color: var(--gold);
            background: rgba(198,163,78,.1);
        }
        .nav-item.active::before {
            content: '';
            position: absolute; left: 0; top: 0; bottom: 0; width: 3px;
            background: var(--gold); border-radius: 0 3px 3px 0;
        }
        .nav-icon { width: 18px; text-align: center; flex-shrink: 0; }

        .sidebar-footer { padding: 1rem 1.25rem; border-top: 1px solid rgba(198,163,78,.15); }
        .user-info { font-size: .82rem; color: rgba(255,255,255,.5); margin-bottom: .75rem; }
        .user-info strong { color: var(--white); display: block; }
        .btn-logout {
            width: 100%; padding: .6rem;
            background: rgba(239,68,68,.1); border: 1px solid rgba(239,68,68,.3);
            border-radius: 8px; color: #f87171; font-family: 'DM Sans', sans-serif;
            font-size: .82rem; cursor: pointer; transition: all .2s;
        }
        .btn-logout:hover { background: rgba(239,68,68,.2); }

        /* MAIN */
        .main-wrap { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; }
        .topbar {
            background: rgba(11,31,59,.95); border-bottom: 1px solid rgba(198,163,78,.15);
            padding: 1rem 2rem; display: flex; align-items: center; gap: 1rem;
            position: sticky; top: 0; z-index: 50; backdrop-filter: blur(10px);
        }
        .btn-menu { display: none; background: none; border: none; color: var(--white); font-size: 1.4rem; cursor: pointer; padding: .25rem; }
        .page-title { font-family: 'Playfair Display', serif; font-size: 1.2rem; }
        .topbar-right { margin-left: auto; display: flex; gap: .75rem; align-items: center; }

        .content { padding: 2rem; flex: 1; }

        /* CARDS */
        .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); gap: 1rem; margin-bottom: 2rem; }
        .stat-card {
            background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.08);
            border-radius: 16px; padding: 1.25rem 1.5rem;
            position: relative; overflow: hidden;
        }
        .stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px; }
        .stat-card.blue::before { background: linear-gradient(90deg, #3b82f6, #60a5fa); }
        .stat-card.green::before { background: linear-gradient(90deg, var(--green), #14875f); }
        .stat-card.gold::before { background: linear-gradient(90deg, var(--gold), var(--gold-light)); }
        .stat-card.red::before { background: linear-gradient(90deg, #ef4444, #f87171); }
        .stat-card.teal::before { background: linear-gradient(90deg, #14b8a6, #2dd4bf); }
        .stat-label { font-size: .75rem; text-transform: uppercase; letter-spacing: .07em; color: rgba(255,255,255,.45); font-weight: 600; margin-bottom: .4rem; }
        .stat-value { font-size: 2.2rem; font-weight: 700; line-height: 1; }
        .stat-sub { font-size: .75rem; color: rgba(255,255,255,.35); margin-top: .3rem; }

        /* TABLES */
        .table-card { background: rgba(255,255,255,.03); border: 1px solid rgba(255,255,255,.08); border-radius: 16px; overflow: hidden; }
        .table-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid rgba(255,255,255,.08); display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap; }
        .table-title { font-size: 1rem; font-weight: 600; }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        th { padding: .75rem 1rem; font-size: .75rem; text-transform: uppercase; letter-spacing: .07em; color: rgba(255,255,255,.45); text-align: left; border-bottom: 1px solid rgba(255,255,255,.08); font-weight: 600; }
        td { padding: .9rem 1rem; font-size: .88rem; border-bottom: 1px solid rgba(255,255,255,.05); }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: rgba(255,255,255,.02); }

        /* BADGES */
        .badge { display: inline-block; padding: .25rem .75rem; border-radius: 50px; font-size: .75rem; font-weight: 600; }
        .badge-pending { background: rgba(251,191,36,.1); color: #fbbf24; border: 1px solid rgba(251,191,36,.3); }
        .badge-accepted { background: rgba(34,197,94,.1); color: #4ade80; border: 1px solid rgba(34,197,94,.3); }
        .badge-rejected { background: rgba(239,68,68,.1); color: #f87171; border: 1px solid rgba(239,68,68,.3); }
        .badge-hadir { background: rgba(20,184,166,.1); color: #2dd4bf; border: 1px solid rgba(20,184,166,.3); }
        .badge-belum { background: rgba(255,255,255,.05); color: rgba(255,255,255,.4); border: 1px solid rgba(255,255,255,.1); }

        /* BUTTONS */
        .btn { display: inline-flex; align-items: center; gap: .4rem; padding: .45rem .9rem; border-radius: 8px; font-family: 'DM Sans', sans-serif; font-size: .82rem; font-weight: 600; cursor: pointer; border: none; transition: all .2s; text-decoration: none; }
        .btn-green { background: rgba(15,107,79,.2); color: #4ade80; border: 1px solid rgba(15,107,79,.4); }
        .btn-green:hover { background: rgba(15,107,79,.4); }
        .btn-red { background: rgba(239,68,68,.1); color: #f87171; border: 1px solid rgba(239,68,68,.3); }
        .btn-red:hover { background: rgba(239,68,68,.2); }
        .btn-gold { background: rgba(198,163,78,.15); color: var(--gold); border: 1px solid rgba(198,163,78,.35); }
        .btn-gold:hover { background: rgba(198,163,78,.3); }
        .btn-blue { background: rgba(59,130,246,.1); color: #93c5fd; border: 1px solid rgba(59,130,246,.3); }
        .btn-blue:hover { background: rgba(59,130,246,.2); }
        .btn-primary { background: linear-gradient(135deg, var(--green), #14875f); color: white; }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(15,107,79,.35); }

        /* FORM ELEMENTS */
        .input-sm {
            padding: .5rem .85rem; background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.12);
            border-radius: 8px; color: var(--white); font-family: 'DM Sans', sans-serif; font-size: .85rem;
            outline: none; transition: all .2s;
        }
        .input-sm:focus { border-color: var(--gold); }
        .input-sm::placeholder { color: rgba(255,255,255,.3); }
        select.input-sm option { background: #1a2f50; }

        /* ALERTS */
        .alert { padding: .75rem 1rem; border-radius: 10px; margin-bottom: 1.25rem; font-size: .88rem; }
        .alert-success { background: rgba(34,197,94,.1); border: 1px solid rgba(34,197,94,.3); color: #4ade80; }
        .alert-error-msg { background: rgba(239,68,68,.1); border: 1px solid rgba(239,68,68,.3); color: #f87171; }

        /* CHART */
        .chart-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
        .chart-card { background: rgba(255,255,255,.03); border: 1px solid rgba(255,255,255,.08); border-radius: 16px; padding: 1.5rem; }
        .chart-title { font-size: .9rem; font-weight: 600; margin-bottom: 1.25rem; color: rgba(255,255,255,.7); }

        /* PAGINATION */
        .pagination-wrap { padding: 1rem 1.5rem; border-top: 1px solid rgba(255,255,255,.08); }
        .pagination-wrap .pagination { display: flex; gap: .5rem; flex-wrap: wrap; }
        .page-link { padding: .4rem .75rem; background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.1); border-radius: 8px; color: rgba(255,255,255,.6); text-decoration: none; font-size: .85rem; transition: all .2s; }
        .page-link:hover, .page-item.active .page-link { background: rgba(198,163,78,.2); border-color: var(--gold); color: var(--gold); }
        .page-item.disabled .page-link { opacity: .4; cursor: not-allowed; }

        /* MOBILE */
        .mobile-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.5); z-index: 90; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-wrap { margin-left: 0; }
            .btn-menu { display: block; }
            .mobile-overlay.show { display: block; }
            .content { padding: 1rem; }
            .stat-grid { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>
<div class="mobile-overlay" id="overlay" onclick="closeSidebar()"></div>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="org">⚡ Admin Panel</div>
        <h2>Financial Glow Up 2026</h2>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-label">Menu Utama</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="nav-icon">📊</span> Dashboard
        </a>
        <a href="{{ route('admin.participants') }}" class="nav-item {{ request()->routeIs('admin.participants*') ? 'active' : '' }}">
            <span class="nav-icon">👥</span> Data Peserta
        </a>
        <a href="{{ route('admin.attendance') }}" class="nav-item {{ request()->routeIs('admin.attendance') ? 'active' : '' }}">
            <span class="nav-icon">✅</span> Kehadiran
        </a>
        <a href="{{ route('admin.scan') }}" class="nav-item {{ request()->routeIs('admin.scan') ? 'active' : '' }}">
            <span class="nav-icon">📷</span> Scan QR
        </a>
        <div class="nav-label">Pengaturan</div>
        <a href="{{ route('admin.dashboard') }}#settings" class="nav-item">
            <span class="nav-icon">⚙️</span> Pengaturan Event
        </a>
        <a href="{{ route('form.index') }}" target="_blank" class="nav-item">
            <span class="nav-icon">🔗</span> Lihat Form
        </a>
    </nav>
    <div class="sidebar-footer">
        <div class="user-info">
            <strong>{{ Auth::user()->name }}</strong>
            {{ Auth::user()->email }}
        </div>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="btn-logout">🚪 Keluar</button>
        </form>
    </div>
</aside>

<div class="main-wrap">
    <div class="topbar">
        <button class="btn-menu" onclick="toggleSidebar()">☰</button>
        <span class="page-title">@yield('page-title', 'Dashboard')</span>
        <div class="topbar-right">
            @php $setting = \App\Models\EventSetting::current(); @endphp
            <span style="font-size:.8rem; padding:.3rem .75rem; border-radius:50px; {{ $setting->form_open ? 'background:rgba(34,197,94,.1);color:#4ade80;border:1px solid rgba(34,197,94,.3)' : 'background:rgba(239,68,68,.1);color:#f87171;border:1px solid rgba(239,68,68,.3)' }}">
                {{ $setting->form_open ? '🟢 Form Terbuka' : '🔴 Form Ditutup' }}
            </span>
        </div>
    </div>

    <div class="content">
        @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert alert-error-msg">❌ {{ session('error') }}</div>
        @endif

        @yield('content')
    </div>
</div>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
    document.getElementById('overlay').classList.toggle('show');
}
function closeSidebar() {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('overlay').classList.remove('show');
}
</script>
@stack('scripts')
</body>
</html>
