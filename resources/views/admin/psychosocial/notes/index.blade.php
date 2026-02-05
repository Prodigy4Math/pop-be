@extends('layouts.admin')

@section('page-title', 'Catatan Psikososial')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h2 class="fw-bold text-dark mb-2">
                        <i class="fas fa-sticky-note me-2 text-info"></i>Catatan Psikososial Peserta
                    </h2>
                    <p class="text-muted mb-0">Kelola catatan perkembangan mental dan emosional peserta</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.psychosocial.activities.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-heartbeat me-2"></i>Kegiatan
                    </a>
                    <a href="{{ route('admin.psychosocial.notes.create') }}" class="btn btn-info btn-lg shadow-sm">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Catatan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-sticky-note text-info fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-0">Total Catatan</h6>
                            <h3 class="mb-0 fw-bold">{{ $notes->total() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-smile text-success fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-0">Rata-rata Skor</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($notes->avg('resilience_score') ?? 0, 1) }}/10</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-users text-primary fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-0">Peserta Terlibat</h6>
                            <h3 class="mb-0 fw-bold">{{ $notes->pluck('user_id')->unique()->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-calendar text-warning fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-0">Bulan Ini</h6>
                            <h3 class="mb-0 fw-bold">{{ $notes->where('created_at', '>=', now()->startOfMonth())->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notes Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3">
            <h5 class="mb-0 fw-bold">
                <i class="fas fa-list me-2 text-info"></i>Daftar Catatan
            </h5>
        </div>
        <div class="card-body p-0">
            @if($notes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Peserta</th>
                                <th>Kegiatan</th>
                                <th>Skor Resiliensi</th>
                                <th>Mood</th>
                                <th>Catatan</th>
                                <th>Tanggal</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notes as $note)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-0 fw-bold">{{ $note->user->name }}</h6>
                                            <small class="text-muted">{{ $note->user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($note->activity)
                                        <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                                            <i class="fas fa-heart me-1"></i>{{ Str::limit($note->activity->name, 30) }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 me-2" style="height: 25px; min-width: 100px;">
                                            <div class="progress-bar 
                                                {{ $note->resilience_score >= 7 ? 'bg-success' : ($note->resilience_score >= 5 ? 'bg-warning' : 'bg-danger') }}" 
                                                role="progressbar" 
                                                style="width: {{ $note->resilience_score * 10 }}%"
                                                aria-valuenow="{{ $note->resilience_score }}" 
                                                aria-valuemin="0" 
                                                aria-valuemax="10">
                                                <strong class="text-white">{{ $note->resilience_score }}/10</strong>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge rounded-pill px-3 py-2
                                        @if($note->mood === 'Sangat Baik') bg-success
                                        @elseif($note->mood === 'Baik') bg-info
                                        @elseif($note->mood === 'Normal') bg-secondary
                                        @elseif($note->mood === 'Sedih') bg-warning
                                        @else bg-danger @endif">
                                        <i class="fas 
                                            @if($note->mood === 'Sangat Baik') fa-smile
                                            @elseif($note->mood === 'Baik') fa-smile-beam
                                            @elseif($note->mood === 'Normal') fa-meh
                                            @elseif($note->mood === 'Sedih') fa-frown
                                            @else fa-sad-tear @endif me-1"></i>
                                        {{ $note->mood }}
                                    </span>
                                </td>
                                <td>
                                    <p class="mb-0 text-muted" style="max-width: 250px;">
                                        {{ Str::limit($note->notes, 60) }}
                                    </p>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold">{{ $note->created_at->format('d-m-Y') }}</span>
                                        <small class="text-muted">{{ $note->created_at->format('H:i') }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.psychosocial.notes.edit', $note) }}" 
                                           class="btn btn-sm btn-outline-warning" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.psychosocial.notes.destroy', $note) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan ini? Tindakan ini tidak dapat dibatalkan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-inbox" style="font-size: 4rem; color: #dee2e6;"></i>
                    </div>
                    <h5 class="text-muted mb-2">Belum ada catatan psikososial</h5>
                    <p class="text-muted mb-4">Mulai dengan menambahkan catatan pertama untuk peserta</p>
                    <a href="{{ route('admin.psychosocial.notes.create') }}" class="btn btn-info">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Catatan Pertama
                    </a>
                </div>
            @endif
        </div>
        @if($notes->hasPages())
        <div class="card-footer bg-white border-top py-3">
            <div class="d-flex justify-content-center">
                {{ $notes->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
