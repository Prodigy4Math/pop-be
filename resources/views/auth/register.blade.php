@extends('layouts.app')

@section('content')
<style>
    .register-wrapper {
        min-height: calc(100vh - 70px);
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
        padding: 40px 20px;
    }

    .register-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        max-width: 500px;
        width: 100%;
    }

    .register-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px 30px;
        text-align: center;
    }

    .register-header h1 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .register-header p {
        font-size: 14px;
        opacity: 0.9;
        margin: 0;
    }

    .register-body {
        padding: 40px 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .form-control {
        border: 1.5px solid #e0e0e0;
        border-radius: 8px;
        padding: 12px 15px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .btn-register {
        width: 100%;
        padding: 12px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 10px;
    }

    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    }

    .login-link {
        text-align: center;
        padding-top: 20px;
        border-top: 1px solid #f0f0f0;
        font-size: 14px;
    }

    .login-link a {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
    }

    .login-link a:hover {
        text-decoration: underline;
    }

    .alert-danger {
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .info-box {
        background: #f0f7ff;
        border-left: 4px solid #667eea;
        padding: 12px;
        border-radius: 4px;
        font-size: 12px;
        margin-bottom: 20px;
        color: #555;
    }

    @media (max-width: 576px) {
        .register-header {
            padding: 30px 20px;
        }

        .register-header h1 {
            font-size: 24px;
        }

        .register-body {
            padding: 30px 20px;
        }

        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="register-wrapper">
    <div class="register-container">
        <div class="register-header">
            <h1><i class="fas fa-user-plus me-2"></i>Daftar Akun</h1>
            <p>Bergabunglah dengan program penguatan kami</p>
        </div>

        <div class="register-body">
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
                        >
                        @error('school')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Buat password (minimal 6 karakter)"
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
