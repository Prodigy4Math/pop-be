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

    .register-wrapper {
        min-height: calc(100vh - 70px);
        display: flex;
        align-items: center;
        justify-content: center;
        background:
            radial-gradient(1200px 600px at 12% -10%, rgba(14, 165, 233, 0.16), transparent 60%),
            radial-gradient(900px 500px at 88% 0%, rgba(249, 115, 22, 0.1), transparent 55%),
            linear-gradient(180deg, #f8fafc 0%, #eef2f7 100%);
        padding: 48px 20px;
        font-family: 'Plus Jakarta Sans', 'Segoe UI', system-ui, sans-serif;
    }

    .auth-shell {
        display: grid;
        grid-template-columns: 1.05fr 1.6fr;
        gap: 0;
        background: var(--surface);
        border-radius: 20px;
        box-shadow: 0 30px 80px rgba(15, 23, 42, 0.18);
        overflow: hidden;
        max-width: 1080px;
        width: 100%;
    }

    .brand-panel {
        padding: 46px 40px;
        background:
            linear-gradient(145deg, rgba(2, 132, 199, 0.95), rgba(14, 116, 144, 0.92));
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

    .logo-strip {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
        margin-bottom: 18px;
    }

    .logo-strip img {
        max-height: 28px;
        background: #ffffff;
        border-radius: 999px;
        padding: 5px 8px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 6px 12px rgba(15, 23, 42, 0.08);
    }

    .brand-title {
        font-size: 28px;
        font-weight: 800;
        margin: 22px 0 12px;
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
        margin-bottom: 18px;
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

    .info-box {
        background: #fff7ed;
        border-left: 4px solid var(--accent);
        padding: 12px;
        border-radius: 10px;
        font-size: 12px;
        margin-bottom: 18px;
        color: #7c2d12;
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

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .btn-register {
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

    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(14, 165, 233, 0.25);
    }

    .login-link {
        text-align: center;
        padding-top: 18px;
        border-top: 1px solid #f1f5f9;
        font-size: 14px;
    }

    .login-link a {
        color: var(--brand-dark);
        text-decoration: none;
        font-weight: 700;
    }

    .login-link a:hover {
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

        .form-row {
            grid-template-columns: 1fr;
        }

        .brand-title {
            font-size: 24px;
        }
    }
</style>

<div class="register-wrapper">
    <div class="auth-shell">
        <div class="brand-panel">
            <div class="brand-logo">
                <span class="brand-badge"><i class="fas fa-medal"></i></span>
                <span>POP-BE</span>
            </div>
            <div class="brand-title">Daftar untuk mulai beraksi</div>
            <div class="brand-subtitle">Akses modul kebugaran, psikososial, dan kesiapsiagaan dengan panduan terstruktur.</div>
            <ul class="brand-list">
                <li><i class="fas fa-check-circle"></i>Program latihan & edukasi terintegrasi</li>
                <li><i class="fas fa-check-circle"></i>Tracking progress yang transparan</li>
                <li><i class="fas fa-check-circle"></i>Kolaborasi peserta, pelatih, dan admin</li>
            </ul>
        </div>

        <div class="form-panel">
            <div class="logo-strip">
                <img src="{{ asset('images/logos/IACBE-Member-with-Accredited-Programs-New-Logo-2024.png') }}" alt="IACBE">
                <img src="{{ asset('images/logos/logo-bima-21.09.2022.11.56.32.png') }}" alt="BiMA">
                <img src="{{ asset('images/logos/diktisaintek-berdampak.a30b8719.png') }}" alt="Diktisaintek Berdampak">
                <img src="{{ asset('images/logos/unimal.png') }}" alt="Universitas Malikussaleh">
                <img src="{{ asset('images/logos/Logo%20BLU%20Speed.png') }}" alt="BLU">
                <img src="{{ asset('images/logos/tut-wuri-handayani-logo-with-white-text-png-b461.png') }}" alt="Kemendikbud">
            </div>
            <div class="form-header">
                <h1>Daftar Akun</h1>
                <span>POP-BE</span>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="info-box">
                <strong>Informasi:</strong> Daftar sebagai peserta untuk mengakses program latihan, edukasi psikososial, dan kesiapsiagaan bencana.
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input 
                            type="text" 
                            name="name" 
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Nama Anda"
                            value="{{ old('name') }}"
                            required
                        >
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Usia</label>
                        <input 
                            type="number" 
                            name="age" 
                            class="form-control @error('age') is-invalid @enderror"
                            placeholder="Usia Anda"
                            value="{{ old('age') }}"
                            min="5"
                            max="30"
                            required
                        >
                        @error('age')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Email Anda"
                        value="{{ old('email') }}"
                        required
                    >
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-control @error('gender') is-invalid @enderror" required>
                            <option value="">Pilih Gender</option>
                            <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Sekolah/Institusi</label>
                        <input 
                            type="text" 
                            name="school" 
                            class="form-control @error('school') is-invalid @enderror"
                            placeholder="Nama sekolah"
                            value="{{ old('school') }}"
                            required
                        >
                        @error('school')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Olahraga Diminati</label>
                    <select name="sport_interest_id" class="form-control @error('sport_interest_id') is-invalid @enderror" required>
                        <option value="">Pilih Olahraga</option>
                        @foreach($sports as $sport)
                            <option value="{{ $sport->id }}" {{ old('sport_interest_id') == $sport->id ? 'selected' : '' }}>
                                {{ $sport->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('sport_interest_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Nomor HP</label>
                        <input
                            type="text"
                            name="phone"
                            class="form-control @error('phone') is-invalid @enderror"
                            placeholder="08xxxxxxxxxx"
                            value="{{ old('phone') }}"
                            required
                        >
                        @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Wali/Orangtua</label>
                        <input
                            type="text"
                            name="guardian_name"
                            class="form-control @error('guardian_name') is-invalid @enderror"
                            placeholder="Nama wali"
                            value="{{ old('guardian_name') }}"
                            required
                        >
                        @error('guardian_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Nomor HP Wali/Orangtua</label>
                    <input
                        type="text"
                        name="guardian_phone"
                        class="form-control @error('guardian_phone') is-invalid @enderror"
                        placeholder="08xxxxxxxxxx"
                        value="{{ old('guardian_phone') }}"
                        required
                    >
                    @error('guardian_phone')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                        <input 
                            type="password" 
                            name="password" 
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Buat password (minimal 8 karakter)"
                            required
                        >
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Konfirmasi Password</label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        class="form-control"
                        placeholder="Ketik ulang password"
                        required
                    >
                </div>

                <button type="submit" class="btn-register">
                    <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                </button>
            </form>

            <div class="login-link">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </div>
        </div>
    </div>
</div>
@endsection
