@extends('layouts.admin')

@section('page-title', 'Edit Peserta')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <h2 class="fw-bold text-dark">
                <i class="fas fa-user-edit me-2 text-primary"></i>Edit Peserta: {{ $peserta->name }}
            </h2>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.peserta.update', ['peserta' => $peserta->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Nama -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $peserta->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email (Read Only) -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control" id="email" value="{{ $peserta->email }}" disabled>
                            <small class="text-muted">Email tidak dapat diubah</small>
                        </div>

                        <hr class="my-4">

                        <!-- Sport Interest -->
                        <div class="mb-3">
                            <label for="sport_interest_id" class="form-label fw-bold">Olahraga yang Diminati</label>
                            <select class="form-select @error('sport_interest_id') is-invalid @enderror"
                                    id="sport_interest_id" name="sport_interest_id" required>
                                <option value="">Pilih Olahraga</option>
                                @foreach($sports as $sport)
                                    <option value="{{ $sport->id }}" {{ old('sport_interest_id', $peserta->sport_interest_id) == $sport->id ? 'selected' : '' }}>
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
                                       id="age" name="age" value="{{ old('age', $peserta->age) }}" min="5" max="30" required>
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
                                    <option value="Laki-laki" {{ old('gender', $peserta->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('gender', $peserta->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
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
                                   id="school" name="school" value="{{ old('school', $peserta->school) }}" required>
                            @error('school')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label for="phone" class="form-label fw-bold">Nomor Telepon</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone', $peserta->phone) }}" required>
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
                                   id="guardian_name" name="guardian_name" value="{{ old('guardian_name', $peserta->guardian_name) }}" required>
                            @error('guardian_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Guardian Phone -->
                        <div class="mb-3">
                            <label for="guardian_phone" class="form-label fw-bold">Nomor Telepon Wali</label>
                            <input type="tel" class="form-control @error('guardian_phone') is-invalid @enderror" 
                                   id="guardian_phone" name="guardian_phone" value="{{ old('guardian_phone', $peserta->guardian_phone) }}" required>
                            @error('guardian_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Bio -->
                        <div class="mb-3">
                            <label for="bio" class="form-label fw-bold">Biodata Singkat</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror" 
                                      id="bio" name="bio" rows="3">{{ old('bio', $peserta->bio) }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status Aktif -->
                        <div class="mb-3">
                            <label for="is_active" class="form-label fw-bold">Status</label>
                            <select class="form-select @error('is_active') is-invalid @enderror" 
                                    id="is_active" name="is_active">
                                <option value="1" {{ old('is_active', $peserta->is_active) ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ !old('is_active', $peserta->is_active) ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('is_active')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
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
                            <p><strong>Terakhir Diubah:</strong> {{ $peserta->updated_at->format('d-m-Y H:i') }}</p>
                            <p><strong>Dibuat:</strong> {{ $peserta->created_at->format('d-m-Y H:i') }}</p>
                            <p><strong>Role:</strong> {{ ucfirst($peserta->role) }}</p>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
