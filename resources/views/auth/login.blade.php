@extends('layouts.app')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    :root {
        --ink: #0f172a;
        --muted: #64748b;
        --brand: #0ea5e9;
        --brand-dark: #0284c7;
        --accent: #f97316;
        --surface: #ffffff;
        --border: #e2e8f0;
        --ring: rgba(14, 165, 233, 0.2);
    }

    .login-wrapper {
        min-height: calc(100vh - 70px);
        display: flex;
        align-items: center;
        justify-content: center;
        background:
            radial-gradient(1200px 600px at 10% -10%, rgba(14, 165, 233, 0.18), transparent 60%),
            radial-gradient(900px 500px at 90% 0%, rgba(249, 115, 22, 0.12), transparent 55%),
            linear-gradient(180deg, #f8fafc 0%, #eef2f7 100%);
        padding: 48px 20px;
        font-family: 'Plus Jakarta Sans', 'Segoe UI', system-ui, sans-serif;
    }

    .auth-shell {
        display: grid;
        grid-template-columns: 1.05fr 1.4fr;
        gap: 0;
        background: var(--surface);
        border-radius: 20px;
        box-shadow: 0 30px 80px rgba(15, 23, 42, 0.18);
        overflow: hidden;
        max-width: 980px;
        width: 100%;
    }

    .brand-panel {
        padding: 46px 40px;
        background:
            linear-gradient(140deg, rgba(14, 165, 233, 0.92), rgba(2, 132, 199, 0.92)),
            url('data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="140" height="140" viewBox="0 0 140 140"%3E%3Cg fill="none" stroke="rgba(255,255,255,0.12)" stroke-width="2"%3E%3Ccircle cx="70" cy="70" r="24"/%3E%3Ccircle cx="70" cy="70" r="48"/%3E%3Ccircle cx="70" cy="70" r="68"/%3E%3C/g%3E%3C/svg%3E');
        color: white;
        position: relative;
    }

    .brand-logo {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 8px 14px;
        border-radius: 999px;
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    .brand-badge {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.2);
        font-size: 20px;
    }

    .logo-strip {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: center;
        margin-top: 22px;
    }

    .logo-strip img {
        max-height: 36px;
        background: rgba(255, 255, 255, 0.92);
        border-radius: 999px;
        padding: 6px 10px;
        border: 1px solid rgba(255, 255, 255, 0.4);
    }

    .brand-title {
        font-size: 30px;
        font-weight: 800;
        margin: 24px 0 12px;
    }

    .brand-subtitle {
        color: rgba(255, 255, 255, 0.85);
        line-height: 1.6;
        margin-bottom: 24px;
        font-size: 15px;
    }

    .brand-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: grid;
        gap: 12px;
    }

    .brand-list li {
        display: flex;
        gap: 10px;
        align-items: flex-start;
        font-size: 14px;
        color: rgba(255, 255, 255, 0.9);
    }

    .brand-list i {
        color: #fff;
        margin-top: 2px;
    }

    .form-panel {
        padding: 46px 42px;
    }

    .form-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
    }

    .form-logo-strip {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
        margin-bottom: 18px;
    }

    .form-logo-strip img {
        max-height: 28px;
        background: #ffffff;
        border-radius: 999px;
        padding: 5px 8px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 6px 12px rgba(15, 23, 42, 0.08);
    }

    .form-header h1 {
        font-size: 26px;
        font-weight: 800;
        color: var(--ink);
        margin: 0;
    }

    .form-header span {
        font-size: 13px;
        color: var(--muted);
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-label {
        font-weight: 600;
        color: var(--ink);
        margin-bottom: 8px;
        font-size: 13px;
    }

    .form-control {
        border: 1.5px solid var(--border);
        border-radius: 10px;
        padding: 12px 14px;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: var(--brand);
        box-shadow: 0 0 0 4px var(--ring);
        outline: none;
    }

    .btn-login {
        width: 100%;
        padding: 12px 14px;
        background: linear-gradient(135deg, var(--brand), var(--brand-dark));
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        margin-top: 6px;
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(14, 165, 233, 0.25);
    }

    .form-check-input:checked {
        background-color: var(--brand);
        border-color: var(--brand);
    }

    .register-link {
        text-align: center;
        padding-top: 18px;
        border-top: 1px solid #f1f5f9;
        font-size: 14px;
    }

    .register-link a {
        color: var(--brand-dark);
        text-decoration: none;
        font-weight: 700;
    }

    .register-link a:hover {
        text-decoration: underline;
    }

    .alert-danger {
        border-radius: 10px;
        margin-bottom: 18px;
    }

    @media (max-width: 992px) {
        .auth-shell {
            grid-template-columns: 1fr;
        }

        .brand-panel {
            padding: 36px 30px;
        }
    }

    @media (max-width: 576px) {
        .form-panel {
            padding: 32px 24px;
        }

        .brand-title {
            font-size: 24px;
        }
    }
</style>

<div class="login-wrapper">
    <div class="auth-shell">
        <div class="brand-panel">
            <div class="brand-logo">
                <span class="brand-badge"><i class="fas fa-medal"></i></span>
                <span>POP-BE</span>
            </div>
            <div class="brand-title">Masuk dan kelola program dengan rapi</div>
            <div class="brand-subtitle">Dashboard terpusat untuk administrasi, progress peserta, dan pelaporan yang lebih cepat.</div>
            <ul class="brand-list">
                <li><i class="fas fa-check-circle"></i>Monitoring aktivitas & laporan realtime</li>
                <li><i class="fas fa-check-circle"></i>Notifikasi instan untuk setiap pengajuan</li>
                <li><i class="fas fa-check-circle"></i>Workflow admin yang ringkas & jelas</li>
            </ul>
        </div>

        <div class="form-panel">
            <div class="form-logo-strip">
                <img src="{{ asset('images/logos/IACBE-Member-with-Accredited-Programs-New-Logo-2024.png') }}" alt="IACBE">
                <img src="{{ asset('images/logos/logo-bima-21.09.2022.11.56.32.png') }}" alt="BiMA">
                <img src="{{ asset('images/logos/diktisaintek-berdampak.a30b8719.png') }}" alt="Diktisaintek Berdampak">
                <img src="{{ asset('images/logos/unimal.png') }}" alt="Universitas Malikussaleh">
                <img src="{{ asset('images/logos/Logo%20BLU%20Speed.png') }}" alt="BLU">
                <img src="{{ asset('images/logos/tut-wuri-handayani-logo-with-white-text-png-b461.png') }}" alt="Kemendikbud">
            </div>
            <div class="form-header">
                <h1>Masuk</h1>
                <span>POP-BE</span>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Masukkan email Anda"
                        value="{{ old('email') }}"
                        required
                    >
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Masukkan password Anda"
                        required
                    >
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-check">
                    <input 
                        type="checkbox" 
                        id="remember" 
                        name="remember" 
                        class="form-check-input"
                        {{ old('remember') ? 'checked' : '' }}
                    >
                    <label class="form-check-label" for="remember">
                        Ingat saya
                    </label>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>Masuk Sekarang
                </button>
            </form>

            <div class="register-link">
                Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
            </div>
        </div>
    </div>
</div>
@endsection
