@extends('layouts.admin')

@section('page-title', 'Tambah Peserta')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <h2 class="fw-bold text-dark">
                <i class="fas fa-user-plus me-2 text-primary"></i>Tambah Peserta Baru
            </h2>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.peserta.store') }}" method="POST">
                        @csrf

                        <!-- Nama -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password</label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                   id="password_confirmation" name="password_confirmation" required>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <!-- Sport Interest -->
                        <div class="mb-3">
                            <label for="sport_interest_id" class="form-label fw-bold">Olahraga yang Diminati</label>
                            <select class="form-select @error('sport_interest_id') is-invalid @enderror"
                                    id="sport_interest_id" name="sport_interest_id" required>
                                <option value="">Pilih Olahraga</option>
                                @foreach($sports as $sport)
                                    <option value="{{ $sport->id }}" {{ old('sport_interest_id') == $sport->id ? 'selected' : '' }}>
                                        {{ $sport->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('sport_interest_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Age -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="age" class="form-label fw-bold">Umur</label>
                                <input type="number" class="form-control @error('age') is-invalid @enderror" 
                                       id="age" name="age" value="{{ old('age') }}" min="5" max="30" required>
                                @error('age')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Gender -->
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label fw-bold">Jenis Kelamin</label>
                                <select class="form-select @error('gender') is-invalid @enderror" 
                                        id="gender" name="gender" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- School -->
                        <div class="mb-3">
                            <label for="school" class="form-label fw-bold">Asal Sekolah</label>
                            <input type="text" class="form-control @error('school') is-invalid @enderror" 
                                   id="school" name="school" value="{{ old('school') }}" required>
                            @error('school')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label for="phone" class="form-label fw-bold">Nomor Telepon</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">
                        <h5 class="fw-bold mb-3">Data Wali/Orang Tua</h5>

                        <!-- Guardian Name -->
                        <div class="mb-3">
                            <label for="guardian_name" class="form-label fw-bold">Nama Wali</label>
                            <input type="text" class="form-control @error('guardian_name') is-invalid @enderror" 
                                   id="guardian_name" name="guardian_name" value="{{ old('guardian_name') }}" required>
                            @error('guardian_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Guardian Phone -->
                        <div class="mb-3">
                            <label for="guardian_phone" class="form-label fw-bold">Nomor Telepon Wali</label>
                            <input type="tel" class="form-control @error('guardian_phone') is-invalid @enderror" 
                                   id="guardian_phone" name="guardian_phone" value="{{ old('guardian_phone') }}" required>
                            @error('guardian_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Bio -->
                        <div class="mb-3">
                            <label for="bio" class="form-label fw-bold">Biodata Singkat</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror" 
                                      id="bio" name="bio" rows="3">{{ old('bio') }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan
                            </button>
                            <a href="{{ route('admin.peserta.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Box -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-info-circle me-2 text-info"></i>Informasi
                    </h5>
                    <div class="alert alert-info" role="alert">
                        <small>
                            <p><strong>Peserta:</strong> Anak-remaja yang mengikuti program POP-BE dan ketahanan psikososial</p>
                            <p><strong>Email:</strong> Harus unik dan valid</p>
                            <p><strong>Password:</strong> Minimal 8 karakter</p>
                            <p><strong>Olahraga:</strong> Diambil dari daftar modul fitness</p>
                            <p><strong>Umur:</strong> Rentang 5-30 tahun</p>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
