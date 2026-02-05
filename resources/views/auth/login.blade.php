@extends('layouts.app')

@section('content')
<style>
    .login-wrapper {
        min-height: calc(100vh - 70px);
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
        padding: 40px 20px;
    }

    .login-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        max-width: 450px;
        width: 100%;
    }

    .login-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px 30px;
        text-align: center;
    }

    .login-header h1 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .login-header p {
        font-size: 14px;
        opacity: 0.9;
        margin: 0;
    }

    .login-body {
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

    .btn-login {
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

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    }

    .form-check {
        margin-bottom: 15px;
    }

    .form-check-input {
        width: 18px;
        height: 18px;
        border: 1.5px solid #e0e0e0;
        border-radius: 4px;
        cursor: pointer;
    }

    .form-check-input:checked {
        background-color: #667eea;
        border-color: #667eea;
    }

    .form-check-label {
        font-size: 14px;
        color: #666;
        cursor: pointer;
        margin-left: 8px;
    }

    .divider {
        text-align: center;
        margin: 25px 0;
        font-size: 13px;
        color: #999;
    }

    .register-link {
        text-align: center;
        padding-top: 20px;
        border-top: 1px solid #f0f0f0;
        font-size: 14px;
    }

    .register-link a {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
    }

    .register-link a:hover {
        text-decoration: underline;
    }

    .demo-info {
        background: #f0f7ff;
        border-left: 4px solid #667eea;
        padding: 12px;
        border-radius: 4px;
        font-size: 12px;
        margin-bottom: 20px;
        color: #555;
    }

    .demo-info strong {
        color: #333;
        display: block;
        margin-bottom: 5px;
    }

    .alert-danger {
        border-radius: 8px;
        margin-bottom: 20px;
    }

    @media (max-width: 576px) {
        .login-header {
            padding: 30px 20px;
        }

        .login-header h1 {
            font-size: 24px;
        }

        .login-body {
            padding: 30px 20px;
        }
    }
</style>

<div class="login-wrapper">
    <div class="login-container">
        <div class="login-header">
            <h1><i class="fas fa-sign-in-alt me-2"></i>Masuk</h1>
            <p>Akses dashboard Anda sekarang</p>
        </div>

        <div class="login-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="demo-info">
                <strong>Demo Akun:</strong>
                Admin: admin@example.com<br>
                Password: password
            </div>

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
