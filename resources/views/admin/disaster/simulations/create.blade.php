@extends('layouts.admin')

@section('page-title', 'Tambah Simulasi Bencana')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4"><i class="fas fa-plus"></i> Buat Simulasi Bencana</h2>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.disaster.simulations.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Judul Simulasi</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                                value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tipe Bencana</label>
                            <select name="disaster_type" class="form-select @error('disaster_type') is-invalid @enderror" required>
                                <option value="">Pilih Tipe</option>
                                <option value="Gempa Bumi">Gempa Bumi</option>
                                <option value="Banjir">Banjir</option>
                                <option value="Longsor">Longsor</option>
                                <option value="Tsunami">Tsunami</option>
                                <option value="Angin Puting Beliung">Angin Puting Beliung</option>
                                <option value="Kebakaran">Kebakaran</option>
                            </select>
                            @error('disaster_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Lokasi</label>
                            <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" 
                                value="{{ old('location') }}" required>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Simulasi</label>
                            <input type="date" name="simulation_date" class="form-control @error('simulation_date') is-invalid @enderror" 
                                value="{{ old('simulation_date') }}" required>
                            @error('simulation_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jam Mulai</label>
                                <input type="time" name="start_time" class="form-control @error('start_time') is-invalid @enderror" 
                                    value="{{ old('start_time') }}" required>
                                @error('start_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jam Selesai</label>
                                <input type="time" name="end_time" class="form-control @error('end_time') is-invalid @enderror" 
                                    value="{{ old('end_time') }}" required>
                                @error('end_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                rows="4" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" checked>
                            <label class="form-check-label" for="is_active">
                                Aktif
                            </label>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <a href="{{ route('admin.disaster.simulations.index') }}" class="btn btn-secondary">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-light">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-info-circle"></i> Panduan</h5>
                    <p class="small text-muted">
                        Simulasi bencana adalah latihan yang dirancang untuk meningkatkan kesiapan dan kemampuan respons terhadap bencana.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
