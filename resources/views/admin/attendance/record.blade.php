@extends('layouts.admin')

@section('page-title', 'Catat Absensi')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4"><i class="fas fa-clipboard-check"></i> Catat Absensi</h2>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.attendance.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Peserta</label>
                        <select name="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                            <option value="">Pilih Peserta</option>
                            @foreach ($peserta as $p)
                                <option value="{{ $p->id }}" @selected(old('user_id') == $p->id)>{{ $p->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jadwal Kebugaran</label>
                        <select name="fitness_schedule_id" class="form-select @error('fitness_schedule_id') is-invalid @enderror" required>
                            <option value="">Pilih Jadwal</option>
                            @foreach ($schedules as $schedule)
                                <option value="{{ $schedule->id }}" @selected(old('fitness_schedule_id') == $schedule->id)>
                                    {{ $schedule->sport->name }} - {{ $schedule->schedule_date }} 
                                    ({{ $schedule->start_time }}-{{ $schedule->end_time }})
                                </option>
                            @endforeach
                        </select>
                        @error('fitness_schedule_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="">Pilih Status</option>
                            <option value="present" @selected(old('status') === 'present')>Hadir</option>
                            <option value="late" @selected(old('status') === 'late')>Terlambat</option>
                            <option value="absent" @selected(old('status') === 'absent')>Tidak Hadir</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Catatan (Opsional)</label>
                    <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Absensi
                    </button>
                    <a href="{{ route('admin.attendance.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="mb-3"><i class="fas fa-qrcode me-2"></i>Scan QR untuk Absensi</h5>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Jadwal Kebugaran</label>
                    <select id="scanSchedule" class="form-select">
                        <option value="">Pilih Jadwal</option>
                        @foreach ($schedules as $schedule)
                            <option value="{{ $schedule->id }}">
                                {{ $schedule->sport->name }} - {{ $schedule->schedule_date }}
                                ({{ $schedule->start_time }}-{{ $schedule->end_time }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Status</label>
                    <select id="scanStatus" class="form-select">
                        <option value="present">Hadir</option>
                        <option value="late">Terlambat</option>
                        <option value="absent">Tidak Hadir</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Kamera</label>
                    <select id="scanCamera" class="form-select">
                        <option value="">Memuat kamera...</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Scan Manual (Scanner USB)</label>
                    <input type="text" id="scanInput" class="form-control" placeholder="Scan atau tempel QR di sini">
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 mb-3">
                    <div id="qr-reader" style="width: 100%;"></div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="alert alert-info" id="scanResult">
                        Siapkan kamera atau gunakan scanner untuk memulai.
                    </div>
                    <button type="button" class="btn btn-outline-primary" id="startScanBtn">
                        <i class="fas fa-play me-2"></i>Mulai Kamera
                    </button>
                    <button type="button" class="btn btn-outline-secondary" id="stopScanBtn" disabled>
                        <i class="fas fa-stop me-2"></i>Stop Kamera
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode@2.3.8/minified/html5-qrcode.min.js"></script>
<script>
    const scanSchedule = document.getElementById('scanSchedule');
    const scanStatus = document.getElementById('scanStatus');
    const scanResult = document.getElementById('scanResult');
    const scanCamera = document.getElementById('scanCamera');
    const scanInput = document.getElementById('scanInput');
    const startScanBtn = document.getElementById('startScanBtn');
    const stopScanBtn = document.getElementById('stopScanBtn');

    let qrScanner = null;
    let lastScan = '';
    let lastScanTime = 0;

    function setResult(message, type = 'info') {
        scanResult.className = 'alert alert-' + type;
        scanResult.textContent = message;
    }

    function canSubmitScan(payload) {
        const now = Date.now();
        if (payload === lastScan && now - lastScanTime < 3000) {
            return false;
        }
        lastScan = payload;
        lastScanTime = now;
        return true;
    }

    async function submitScan(payload) {
        if (!scanSchedule.value) {
            setResult('Pilih jadwal terlebih dahulu.', 'warning');
            return;
        }

        if (!canSubmitScan(payload)) {
            return;
        }

        setResult('Memproses scan...', 'info');

        const response = await fetch("{{ route('admin.attendance.scan') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                payload: payload,
                fitness_schedule_id: scanSchedule.value,
                status: scanStatus.value
            })
        });

        const data = await response.json();

        if (!response.ok) {
            setResult(data.message || 'Gagal memproses QR.', 'danger');
            return;
        }

        setResult('Absensi tercatat: ' + data.participant.name, 'success');
    }

    async function loadCameras() {
        try {
            const devices = await Html5Qrcode.getCameras();
            scanCamera.innerHTML = '';
            if (!devices || devices.length === 0) {
                scanCamera.innerHTML = '<option value="">Tidak ada kamera</option>';
                setResult('Kamera tidak ditemukan. Coba gunakan scanner USB.', 'warning');
                return;
            }
            devices.forEach(device => {
                const option = document.createElement('option');
                option.value = device.id;
                option.textContent = device.label || `Kamera ${scanCamera.length + 1}`;
                scanCamera.appendChild(option);
            });
        } catch (error) {
            scanCamera.innerHTML = '<option value="">Kamera tidak tersedia</option>';
            setResult('Tidak dapat memuat daftar kamera. Pastikan izin kamera diaktifkan.', 'danger');
        }
    }

    function ensureSecureContext() {
        if (window.isSecureContext) {
            return true;
        }
        setResult('Browser memblokir kamera di HTTP. Gunakan HTTPS atau localhost.', 'warning');
        return false;
    }

    async function startScanner() {
        if (qrScanner) {
            return;
        }

        if (!ensureSecureContext()) {
            return;
        }

        qrScanner = new Html5Qrcode("qr-reader");
        startScanBtn.disabled = true;
        stopScanBtn.disabled = false;

        try {
            if (!scanCamera.value) {
                await loadCameras();
            }
            const cameraId = scanCamera.value || { facingMode: "environment" };
            await qrScanner.start(
                cameraId,
                { fps: 10, qrbox: 220 },
                (decodedText) => submitScan(decodedText),
                () => {}
            );
        } catch (error) {
            setResult('Tidak dapat mengakses kamera. Pastikan izin kamera diberikan.', 'danger');
            startScanBtn.disabled = false;
            stopScanBtn.disabled = true;
            qrScanner = null;
        }
    }

    async function stopScanner() {
        if (!qrScanner) {
            return;
        }

        await qrScanner.stop();
        await qrScanner.clear();
        qrScanner = null;
        startScanBtn.disabled = false;
        stopScanBtn.disabled = true;
        setResult('Scanner dihentikan.', 'secondary');
    }

    startScanBtn.addEventListener('click', startScanner);
    stopScanBtn.addEventListener('click', stopScanner);

    document.addEventListener('DOMContentLoaded', () => {
        if (!ensureSecureContext()) {
            startScanBtn.disabled = true;
            return;
        }
        loadCameras();
    });

    scanInput.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            event.preventDefault();
            const payload = scanInput.value.trim();
            if (payload) {
                submitScan(payload);
                scanInput.value = '';
            }
        }
    });
</script>
@endpush
