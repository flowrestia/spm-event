{{-- resources/views/admin/login.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — SPM 2026</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root { --navy:#0B1F3B; --green:#0F6B4F; --gold:#C6A34E; --white:#FFFFFF; }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--navy);
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 1.5rem;
            background-image: radial-gradient(ellipse 70% 60% at 10% 0%, rgba(15,107,79,.3) 0%, transparent 55%),
                              radial-gradient(ellipse 50% 40% at 90% 100%, rgba(198,163,78,.2) 0%, transparent 55%);
        }
        .login-card {
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(198,163,78,.25);
            border-radius: 24px;
            padding: 2.5rem 2rem;
            width: 100%; max-width: 400px;
            position: relative; overflow: hidden;
        }
        .login-card::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, var(--green), var(--gold));
        }
        .login-brand { text-align: center; margin-bottom: 2rem; }
        .login-brand .org { font-size: .75rem; color: var(--gold); letter-spacing: .1em; text-transform: uppercase; font-weight: 600; }
        .login-brand h1 { font-family: 'Playfair Display', serif; font-size: 1.4rem; color: var(--white); margin: .5rem 0 .25rem; }
        .login-brand p { color: rgba(255,255,255,.45); font-size: .82rem; }

        .form-group { margin-bottom: 1.25rem; }
        .form-label { display: block; font-size: .78rem; font-weight: 600; text-transform: uppercase; letter-spacing: .07em; color: rgba(255,255,255,.5); margin-bottom: .5rem; }
        .form-control {
            width: 100%; padding: .85rem 1rem;
            background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.12);
            border-radius: 12px; color: var(--white);
            font-family: 'DM Sans', sans-serif; font-size: .95rem;
            outline: none; transition: all .2s;
        }
        .form-control:focus { border-color: var(--gold); background: rgba(198,163,78,.08); box-shadow: 0 0 0 3px rgba(198,163,78,.15); }
        .form-control::placeholder { color: rgba(255,255,255,.3); }

        .btn-login {
            width: 100%; padding: .9rem;
            background: linear-gradient(135deg, var(--green), #14875f);
            border: none; border-radius: 12px;
            color: var(--white); font-family: 'DM Sans', sans-serif;
            font-size: 1rem; font-weight: 700; cursor: pointer;
            transition: all .25s;
        }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(15,107,79,.4); }

        .back-link { display: block; text-align: center; margin-top: 1.25rem; color: rgba(255,255,255,.4); font-size: .85rem; text-decoration: none; }
        .back-link:hover { color: var(--gold); }

        .alert-error {
            background: rgba(239,68,68,.1); border: 1px solid rgba(239,68,68,.35);
            border-radius: 10px; padding: .75rem 1rem;
            color: #f87171; font-size: .85rem; margin-bottom: 1.25rem;
        }

        @keyframes fadeUp { from { opacity:0;transform:translateY(20px); } to { opacity:1;transform:translateY(0); } }
        .login-card { animation: fadeUp .5s ease both; }
    </style>
</head>
<body>
<div class="login-card">
    <div class="login-brand">
        <div class="org">🔐 Admin Panel</div>
        <h1>Financial Glow Up 2026</h1>
        <p>Sekolah Pasar Modal — GI-BEI POLINEMA KEDIRI</p>
    </div>

    @if ($errors->any())
    <div class="alert-error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('admin.login.post') }}">
        @csrf
        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="admin@example.com" required autofocus>
        </div>
        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>
        <div style="display:flex;align-items:center;gap:.5rem;margin-bottom:1.25rem;">
            <input type="checkbox" name="remember" id="remember" style="accent-color:var(--gold);">
            <label for="remember" style="font-size:.85rem;color:rgba(255,255,255,.5);">Ingat saya</label>
        </div>
        <button type="submit" class="btn-login">Masuk ke Dashboard →</button>
    </form>
    <a href="{{ route('form.index') }}" class="back-link">← Kembali ke halaman pendaftaran</a>
</div>
</body>
</html>
