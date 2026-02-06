@extends('layouts.admin')

@section('page-title', 'Edit Klasemen')

@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.landing.standings.update', $standing) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label fw-semibold">Cabang Olahraga</label>
                    <select name="sport_id" class="form-select @error('sport_id') is-invalid @enderror" required>
                        @foreach($sports as $sport)
                            <option value="{{ $sport->id }}" {{ old('sport_id', $standing->sport_id) == $sport->id ? 'selected' : '' }}>{{ $sport->name }}</option>
                        @endforeach
                    </select>
                    @error('sport_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">Posisi</label>
                        <input type="number" name="position" class="form-control @error('position') is-invalid @enderror" value="{{ old('position', $standing->position) }}" min="1" required>
                        @error('position')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-9 mb-3">
                        <label class="form-label fw-semibold">Nama Tim</label>
                        <input type="text" name="team_name" class="form-control @error('team_name') is-invalid @enderror" value="{{ old('team_name', $standing->team_name) }}" required>
                        @error('team_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">Main</label>
                        <input type="number" name="played" class="form-control @error('played') is-invalid @enderror" value="{{ old('played', $standing->played) }}" min="0" required>
                        @error('played')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">Menang</label>
                        <input type="number" name="wins" class="form-control @error('wins') is-invalid @enderror" value="{{ old('wins', $standing->wins) }}" min="0" required>
                        @error('wins')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">Seri</label>
                        <input type="number" name="draws" class="form-control @error('draws') is-invalid @enderror" value="{{ old('draws', $standing->draws) }}" min="0" required>
                        @error('draws')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">Kalah</label>
                        <input type="number" name="losses" class="form-control @error('losses') is-invalid @enderror" value="{{ old('losses', $standing->losses) }}" min="0" required>
                        @error('losses')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Gol (For)</label>
                        <input type="number" name="goals_for" class="form-control @error('goals_for') is-invalid @enderror" value="{{ old('goals_for', $standing->goals_for) }}" min="0" required>
                        @error('goals_for')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Gol (Against)</label>
                        <input type="number" name="goals_against" class="form-control @error('goals_against') is-invalid @enderror" value="{{ old('goals_against', $standing->goals_against) }}" min="0" required>
                        @error('goals_against')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Poin</label>
                        <input type="number" name="points" class="form-control @error('points') is-invalid @enderror" value="{{ old('points', $standing->points) }}" min="0" required>
                        @error('points')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('admin.landing.standings.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
