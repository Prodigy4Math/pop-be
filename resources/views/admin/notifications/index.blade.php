@extends('layouts.admin')

@section('page-title', 'Notifikasi Admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-1 fw-bold">Notifikasi</h4>
                        <p class="text-muted mb-0">Pantau aktivitas terbaru dan tindak lanjut dengan cepat.</p>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        @if($unreadCount > 0)
                            <span class="badge bg-danger">{{ $unreadCount }} belum dibaca</span>
                        @endif
                        <form action="{{ route('admin.notifications.readAll') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary">
                                <i class="fas fa-check-double me-1"></i>Tandai Semua
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    @forelse($notifications as $note)
                        @php
                            $link = null;
                            if ($note->category === 'kartu-request' && $note->related_id) {
                                $link = route('admin.peserta.show', $note->related_id);
                            } elseif ($note->category === 'achievement-submission' && $note->related_id) {
                                $link = route('admin.achievements.show', $note->related_id);
                            } elseif ($note->category === 'loan-request' && $note->related_id) {
                                $link = route('admin.loans.show', $note->related_id);
                            }
                        @endphp
                        <div class="p-3 border-bottom {{ $note->is_read ? '' : 'bg-light' }}">
                            <div class="d-flex justify-content-between align-items-start gap-3">
                                <div>
                                    <div class="fw-semibold mb-1">{{ $note->title }}</div>
                                    <div class="text-muted">{{ $note->message }}</div>
                                    <small class="text-muted">{{ $note->created_at->diffForHumans() }}</small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-{{ $note->type === 'error' ? 'danger' : $note->type }}">{{ strtoupper($note->type) }}</span>
                                </div>
                            </div>
                            <div class="mt-2 d-flex align-items-center gap-2">
                                @if($link)
                                    <a href="{{ $link }}" class="btn btn-sm btn-outline-primary">Buka Detail</a>
                                @endif
                                @if(!$note->is_read)
                                    <form action="{{ route('admin.notifications.read', $note) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-secondary">Tandai Dibaca</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-5 text-center text-muted">
                            <i class="fas fa-inbox fs-2 mb-2"></i>
                            <p class="mb-0">Belum ada notifikasi.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="mt-3">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
