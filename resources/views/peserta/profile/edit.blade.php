@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4"><i class="fas fa-edit"></i> Edit Profil</h2>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('peserta.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                value="{{ old('name', auth()->user()->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                value="{{ old('email', auth()->user()->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Umur</label>
                            <input type="number" name="age" class="form-control @error('age') is-invalid @enderror" 
                                value="{{ old('age', auth()->user()->age) }}" min="5" max="100" required>
                            @error('age')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                                <option value="Laki-laki" @selected(old('gender', auth()->user()->gender) === 'Laki-laki')>Laki-laki</option>
                                <option value="Perempuan" @selected(old('gender', auth()->user()->gender) === 'Perempuan')>Perempuan</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sekolah</label>
                            <input type="text" name="school" class="form-control" 
                                value="{{ old('school', auth()->user()->school) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nomor HP</label>
                            <input type="text" name="phone" class="form-control" 
                                value="{{ old('phone', auth()->user()->phone) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Wali</label>
                            <input type="text" name="guardian_name" class="form-control" 
                                value="{{ old('guardian_name', auth()->user()->guardian_name) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">HP Wali</label>
                            <input type="text" name="guardian_phone" class="form-control" 
                                value="{{ old('guardian_phone', auth()->user()->guardian_phone) }}">
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <a href="{{ route('peserta.profile.show') }}" class="btn btn-secondary">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
