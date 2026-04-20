<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — LibraSys</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,500&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
            font-family: 'DM Sans', sans-serif;
            background: #f4f4f6;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            min-height: 100vh;
        }

        /* ===== CARD WRAPPER ===== */
        .login-card {
            display: flex;
            width: 100%;
            max-width: 860px;
            min-height: 540px;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 24px 60px rgba(0,0,0,.12), 0 4px 16px rgba(0,0,0,.06);
        }

        /* ===== LEFT PANEL ===== */
        .left-panel {
            width: 42%;
            background: #1a1a2e;
            padding: 44px 38px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
        }

        /* glow blobs */
        .left-panel::before {
            content: '';
            position: absolute;
            top: -80px; left: -80px;
            width: 280px; height: 280px;
            border-radius: 50%;
            background: rgba(99, 102, 241, .15);
            pointer-events: none;
        }

        .left-panel::after {
            content: '';
            position: absolute;
            bottom: -60px; right: -60px;
            width: 200px; height: 200px;
            border-radius: 50%;
            background: rgba(231, 76, 60, .14);
            pointer-events: none;
        }

        /* dot-grid texture */
        .dot-grid {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle, rgba(255,255,255,.06) 1px, transparent 1px);
            background-size: 22px 22px;
            pointer-events: none;
            z-index: 1;
        }

        .left-content { position: relative; z-index: 2; }

        /* Brand */
        .brand-logo {
            display: inline-flex;
            align-items: center;
            gap: 11px;
            margin-bottom: 38px;
        }

        .logo-icon {
            width: 40px; height: 40px;
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.15);
            border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            font-size: 19px;
        }

        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 21px; font-weight: 700;
            color: #fff;
        }

        .brand-tagline {
            font-size: 10px;
            color: rgba(255,255,255,.38);
            font-weight: 500;
            letter-spacing: .5px;
            text-transform: uppercase;
            margin-top: 1px;
        }

        .left-headline {
            font-family: 'Playfair Display', serif;
            font-size: 28px; font-weight: 700;
            color: #fff; line-height: 1.3;
            margin-bottom: 12px;
        }

        .left-headline em { font-style: italic; color: #ffb3ae; }

        .left-sub {
            font-size: 13px;
            color: rgba(255,255,255,.48);
            line-height: 1.7;
            margin-bottom: 30px;
        }

        /* Decorative book spines */
        .book-spines {
            display: flex;
            align-items: flex-end;
            gap: 4px;
            margin-bottom: 28px;
        }

        .spine {
            border-radius: 3px 3px 0 0;
            flex-shrink: 0;
        }

        /* Feature list */
        .features { position: relative; z-index: 2; }

        .feat-item {
            display: flex; align-items: center;
            gap: 10px;
            margin-bottom: 11px;
            font-size: 12px;
            color: rgba(255,255,255,.6);
        }

        .feat-dot {
            width: 20px; height: 20px;
            border-radius: 50%;
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.14);
            display: flex; align-items: center; justify-content: center;
            font-size: 9px;
            flex-shrink: 0;
            color: #34d399;
        }

        /* ===== RIGHT PANEL ===== */
        .right-panel {
            flex: 1;
            background: #fff;
            padding: 50px 44px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-eyebrow {
            font-size: 11px; font-weight: 600;
            letter-spacing: .7px; text-transform: uppercase;
            color: #999;
            margin-bottom: 8px;
        }

        .form-title {
            font-family: 'Playfair Display', serif;
            font-size: 28px; font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 6px;
        }

        .form-desc {
            font-size: 13px; color: #888;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        /* Alert */
        .alert-error {
            display: flex; align-items: flex-start; gap: 10px;
            background: #fff5f5;
            border: 1px solid #fed7d7;
            border-radius: 10px;
            padding: 11px 14px;
            font-size: 13px; color: #c53030;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .alert-icon { font-size: 15px; flex-shrink: 0; margin-top: 1px; }

        /* Fields */
        .field { margin-bottom: 18px; }

        .field label {
            display: block;
            font-size: 12px; font-weight: 600;
            color: #555;
            margin-bottom: 7px;
            letter-spacing: .2px;
        }

        .field-wrap { position: relative; }

        .field-wrap .f-icon {
            position: absolute;
            left: 13px; top: 50%;
            transform: translateY(-50%);
            font-size: 15px; color: #bbb;
            pointer-events: none;
        }

        .field-wrap input {
            width: 100%;
            padding: 11px 14px 11px 40px;
            border: 1px solid #e4e4e7;
            border-radius: 10px;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            color: #1a1a2e;
            background: #fff;
            transition: border-color .2s, box-shadow .2s;
        }

        .field-wrap input::placeholder { color: #bbb; }

        .field-wrap input:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,.1);
        }

        .field-wrap input.is-invalid {
            border-color: #fc8181;
        }

        /* Password toggle */
        .toggle-pw {
            position: absolute;
            right: 13px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            cursor: pointer;
            font-size: 12px; font-weight: 600;
            color: #6366f1;
            font-family: 'DM Sans', sans-serif;
            padding: 4px 6px;
            border-radius: 5px;
            transition: background .15s;
        }

        .toggle-pw:hover { background: #f0f0ff; }

        /* Row helpers */
        .row-between {
            display: flex;
            justify-content: flex-end;
            margin-top: -8px;
            margin-bottom: 22px;
        }

        .link-sm {
            font-size: 12px; font-weight: 500;
            color: #6366f1; text-decoration: none;
        }

        .link-sm:hover { text-decoration: underline; }

        /* Submit button */
        .btn-login {
            width: 100%;
            padding: 13px;
            background: #1a1a2e;
            color: #fff;
            border: none;
            border-radius: 11px;
            font-size: 14px; font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            letter-spacing: .25px;
            transition: opacity .18s, transform .12s;
            position: relative;
        }

        .btn-login:hover   { opacity: .88; }
        .btn-login:active  { transform: scale(.98); }

        /* Divider */
        .divider {
            display: flex; align-items: center;
            gap: 12px;
            margin: 22px 0 16px;
        }

        .div-line  { flex: 1; height: 1px; background: #f0f0f0; }

        .div-text  {
            font-size: 11px; color: #bbb;
            white-space: nowrap; font-weight: 500;
        }

        .footer-note {
            text-align: center;
            font-size: 12px; color: #bbb;
        }

        .footer-note a { color: #6366f1; text-decoration: none; }
        .footer-note a:hover { text-decoration: underline; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 720px) {
            body { padding: 16px; align-items: flex-start; }

            .login-card {
                flex-direction: column;
                max-width: 440px;
                margin: 0 auto;
                min-height: auto;
            }

            .left-panel {
                width: 100%;
                padding: 32px 28px 28px;
                min-height: auto;
            }

            .book-spines { margin-bottom: 20px; }

            .left-headline { font-size: 22px; }

            .right-panel { padding: 32px 28px 36px; }
        }

        @media (max-width: 400px) {
            .right-panel { padding: 28px 20px 32px; }
        }
    </style>
</head>
<body>

<div class="login-card">

    {{-- ===== LEFT PANEL ===== --}}
    <div class="left-panel">
        <div class="dot-grid"></div>

        <div class="left-content">
            <div class="brand-logo">
                <div>
                    <div class="brand-name">LibraSys</div>
                    <div class="brand-tagline">Perpustakaan Digital</div>
                </div>
            </div>

            <div class="left-headline">
                Selamat datang<br>di <em>LibraSys</em>
            </div>

            <p class="left-sub">
                Kelola, temukan, dan nikmati ribuan koleksi buku digital dalam satu platform yang mudah digunakan.
            </p>

            <div class="book-spines" aria-hidden="true">
                <div class="spine" style="height:80px;width:18px;background:#a78bfa;"></div>
                <div class="spine" style="height:108px;width:16px;background:#fb923c;"></div>
                <div class="spine" style="height:68px;width:20px;background:#34d399;"></div>
                <div class="spine" style="height:124px;width:14px;background:#60a5fa;"></div>
                <div class="spine" style="height:90px;width:18px;background:#f472b6;"></div>
                <div class="spine" style="height:74px;width:16px;background:#fbbf24;"></div>
                <div class="spine" style="height:112px;width:14px;background:#a78bfa;opacity:.55;"></div>
                <div class="spine" style="height:60px;width:18px;background:#34d399;opacity:.45;"></div>
            </div>
        </div>

        <div class="features">
            <div class="feat-item">
                <div class="feat-dot">✓</div>
                Ribuan koleksi buku digital
            </div>
            <div class="feat-item">
                <div class="feat-dot">✓</div>
                Manajemen peminjaman mudah
            </div>
            <div class="feat-item">
                <div class="feat-dot">✓</div>
                Akses kapan saja &amp; di mana saja
            </div>
        </div>
    </div>

    {{-- ===== RIGHT PANEL ===== --}}
    <div class="right-panel">

        <div class="form-eyebrow">Masuk ke akun</div>
        <div class="form-title">Login</div>
        <p class="form-desc">Gunakan email dan password yang sudah terdaftar.</p>

        {{-- Error alert --}}
        @if(session('error'))
        <div class="alert-error">
            <span class="alert-icon">⚠</span>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        <form method="POST" action="{{ route('login.process') }}">
            @csrf

            {{-- Email --}}
            <div class="field">
                <label for="email">Email</label>
                <div class="field-wrap">
                    <span class="f-icon">✉</span>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="nama@email.com"
                        autocomplete="email"
                        required
                        class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                    >
                </div>
                @error('email')
                    <small style="color:#c53030;font-size:11px;margin-top:5px;display:block;">{{ $message }}</small>
                @enderror
            </div>

            {{-- Password --}}
            <div class="field">
                <label for="password">Password</label>
                <div class="field-wrap">
                    <span class="f-icon">🔒</span>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan password"
                        autocomplete="current-password"
                        required
                        class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                    >
                    <button type="button" class="toggle-pw" id="togglePw">Lihat</button>
                </div>
                @error('password')
                    <small style="color:#c53030;font-size:11px;margin-top:5px;display:block;">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn-login">
                Masuk ke LibraSys
            </button>
        </form>

        <div class="divider">
            <div class="div-line"></div>
            <span class="div-text">Sistem Perpustakaan Digital</span>
            <div class="div-line"></div>
        </div>

        <p class="footer-note">
            Butuh akun? Hubungi <a href="#">administrator</a> perpustakaan.
        </p>
    </div>

</div>

<script>
    const toggleBtn = document.getElementById('togglePw');
    const pwInput   = document.getElementById('password');
    if (toggleBtn && pwInput) {
        toggleBtn.addEventListener('click', function () {
            const isHidden = pwInput.type === 'password';
            pwInput.type       = isHidden ? 'text' : 'password';
            this.textContent   = isHidden ? 'Sembunyikan' : 'Lihat';
        });
    }
</script>

</body>
</html>