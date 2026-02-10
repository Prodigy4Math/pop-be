@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-book"></i> {{ $material->title }}</h2>
            <p class="text-muted">
                <i class="fas fa-tag"></i> {{ $material->category }}
            </p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('peserta.disaster.materials') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Deskripsi</h5>
            <p>{{ $material->description }}</p>

            <hr>

            <h5 class="card-title">Konten Materi</h5>
            <div class="alert alert-info">
                {!! nl2br(e($material->content_text ?? 'Materi tersedia dalam bentuk file/tautan.')) !!}
            </div>

            @if ($material->content_url)
                <hr>
                <a href="{{ $material->content_url }}" target="_blank" class="btn btn-primary">
                    <i class="fas fa-download"></i> Download Materi
                </a>
            @endif
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('peserta.disaster.quiz') }}" class="btn btn-success btn-lg">
            <i class="fas fa-pencil"></i> Ikuti Kuis Bencana
        </a>
    </div>
</div>
@endsection
