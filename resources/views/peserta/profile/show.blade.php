@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4"><i class="fas fa-user"></i> Profil Saya</h2>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-3">Nama</dt>
                        <dd class="col-sm-9">{{ auth()->user()->name }}</dd>

                        <dt class="col-sm-3">Email</dt>
                        <dd class="col-sm-9">{{ auth()->user()->email }}</dd>

                        <dt class="col-sm-3">Umur</dt>
                        <dd class="col-sm-9">{{ auth()->user()->age }} tahun</dd>

                        <dt class="col-sm-3">Jenis Kelamin</dt>
                        <dd class="col-sm-9">{{ auth()->user()->gender }}</dd>

                        <dt class="col-sm-3">Sekolah</dt>
                        <dd class="col-sm-9">{{ auth()->user()->school ?? '-' }}</dd>

                        <dt class="col-sm-3">Nomor HP</dt>
                        <dd class="col-sm-9">{{ auth()->user()->phone ?? '-' }}</dd>

                        <dt class="col-sm-3">Nama Wali</dt>
                        <dd class="col-sm-9">{{ auth()->user()->guardian_name ?? '-' }}</dd>

                        <dt class="col-sm-3">HP Wali</dt>
                        <dd class="col-sm-9">{{ auth()->user()->guardian_phone ?? '-' }}</dd>

                        <dt class="col-sm-3">Bergabung</dt>
                        <dd class="col-sm-9">{{ auth()->user()->created_at->format('d-m-Y') }}</dd>
                    </dl>

                    <div class="mt-4">
                        <a href="{{ route('peserta.profile.edit') }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-light">
                <div class="card-body">
                    <h5><i class="fas fa-award"></i> Statistik</h5>
                    <hr>
                    <p class="small">
                        <strong>Total Kehadiran:</strong> 
                        <span class="badge bg-primary">{{ auth()->user()->attendance()->count() }}</span>
                    </p>
                    <p class="small">
                        <strong>Badge Diterima:</strong>
                        <span class="badge bg-warning">{{ auth()->user()->badges()->count() }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
