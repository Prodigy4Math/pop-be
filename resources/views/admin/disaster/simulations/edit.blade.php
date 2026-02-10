@extends('layouts.admin')

@section('page-title', 'Edit Simulasi Bencana')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4"><i class="fas fa-edit"></i> Edit Simulasi Bencana</h2>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.disaster.simulations.update', $simulation) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">Judul Simulasi</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                                value="{{ old('title', $simulation->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tipe Bencana</label>
                            <select name="disaster_type" class="form-select @error('disaster_type') is-invalid @enderror" required>
                                <option value="Gempa Bumi" @selected(old('disaster_type', $simulation->disaster_type) === 'Gempa Bumi')>Gempa Bumi</option>
                                <option value="Banjir" @selected(old('disaster_type', $simulation->disaster_type) === 'Banjir')>Banjir</option>
                                <option value="Longsor" @selected(old('disaster_type', $simulation->disaster_type) === 'Longsor')>Longsor</option>
                                <option value="Tsunami" @selected(old('disaster_type', $simulation->disaster_type) === 'Tsunami')>Tsunami</option>
                                <option value="Angin Puting Beliung" @selected(old('disaster_type', $simulation->disaster_type) === 'Angin Puting Beliung')>Angin Puting Beliung</option>
                                <option value="Kebakaran" @selected(old('disaster_type', $simulation->disaster_type) === 'Kebakaran')>Kebakaran</option>
                            </select>
                            @error('disaster_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Lokasi</label>
                            <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" 
                                value="{{ old('location', $simulation->location) }}" required>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Simulasi</label>
                            <input type="date" name="simulation_date" class="form-control @error('simulation_date') is-invalid @enderror" 
                                value="{{ old('simulation_date', $simulation->simulation_date->format('Y-m-d')) }}" required>
                            @error('simulation_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jam Mulai</label>
                                <input type="time" name="start_time" class="form-control @error('start_time') is-invalid @enderror" 
                                    value="{{ old('start_time', $simulation->start_time) }}" required>
                                @error('start_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jam Selesai</label>
                                <input type="time" name="end_time" class="form-control @error('end_time') is-invalid @enderror" 
                                    value="{{ old('end_time', $simulation->end_time) }}" required>
                                @error('end_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                rows="4" required>{{ old('description', $simulation->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" 
                                @checked(old('is_active', $simulation->is_active))>
                            <label class="form-check-label" for="is_active">
                                Aktif
                            </label>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Update
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
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Informasi</h5>
                    <dl class="row small">
                        <dt class="col-sm-5">Dibuat:</dt>
                        <dd class="col-sm-7">{{ $simulation->created_at->format('d-m-Y') }}</dd>
                        <dt class="col-sm-5">Diperbarui:</dt>
                        <dd class="col-sm-7">{{ $simulation->updated_at->format('d-m-Y') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
