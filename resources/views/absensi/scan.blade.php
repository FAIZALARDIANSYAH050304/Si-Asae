@extends('layouts.app')

@section('title', 'Scan QR Code Absensi')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header text-center">
                    <h5 class="mb-0">Scan QR Code Absensi</h5>
                </div>
                <div class="card-body">
                    <!-- Camera Scanner Section -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <div id="reader" style="width: 100%;"></div>
                                    <div class="mt-3">
                                        <button type="button" id="startScanner" class="btn btn-success">
                                            <i class="bi bi-camera"></i> Buka Kamera
                                        </button>
                                        <button type="button" id="stopScanner" class="btn btn-danger d-none">
                                            <i class="bi bi-stop-circle"></i> Tutup Kamera
                                        </button>
                                    </div>
                                    <div id="scannerStatus" class="mt-2 text-muted small">
                                        Klik "Buka Kamera" untuk memulai scan
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="alert alert-info">
                                <h6><i class="bi bi-info-circle"></i> Cara Penggunaan:</h6>
                                <ol class="mb-0">
                                    <li>Klik tombol <strong>"Buka Kamera"</strong></li>
                                    <li>Izinkan akses kamera perangkat Anda</li>
                                    <li>Arahkan kamera ke QR Code warga binaan</li>
                                    <li>UUID akan terisi otomatis setelah terdeteksi</li>
                                    <li>Klik <strong>"Proses Absensi"</strong> untuk menyimpan</li>
                                </ol>
                            </div>
                            <div class="alert alert-warning">
                                <h6><i class="bi bi-exclamation-triangle"></i> Catatan:</h6>
                                <ul class="mb-0">
                                    <li>Pastikan pencahangan cukup terang</li>
<li>Hold QR Code dalam bingkai kamera</li>
                                    <li>Setelah scan berhasil, UUID akan terisi otomatis</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Form Section -->
                    <form method="POST" action="{{ route('absensi.process-scan') }}">
                        @csrf
<div class="row">
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label for="uuid" class="form-label">UUID Warga Binaan</label>
                                    <input type="text" class="form-control form-control-lg" id="uuid" name="uuid" placeholder="Scan QR Code atau ketik UUID..." required autofocus>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status Kehadiran</label>
                                    <select name="status" id="status" class="form-select form-select-lg" required>
                                        <option value="semua">Semua Status</option>
                                        <option value="hadir" selected>Hadir</option>
                                        <option value="izin">Izin</option>
                                        <option value="alpha">Alpha</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control form-control-lg" name="tanggal" value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-circle"></i> Proses Absensi
                            </button>
                            <a href="{{ route('absensi.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Html5-Qrcode Library -->
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

<script>
    let html5QrcodeScanner = null;
    let isScanning = false;

    document.getElementById('startScanner').addEventListener('click', function() {
        startScanner();
    });

    document.getElementById('stopScanner').addEventListener('click', function() {
        stopScanner();
    });

    async function startScanner() {
        if (isScanning) return;

        const statusEl = document.getElementById('scannerStatus');
        statusEl.innerHTML = '<span class="text-info">Menghubungkan ke kamera...</span>';

        try {
            // First, request camera permission to populate device labels
            await navigator.mediaDevices.getUserMedia({ video: true });
            
            // Then get camera list
            const cameras = await Html5Qrcode.getCameras();
            
            if (!cameras || cameras.length === 0) {
                statusEl.innerHTML = '<span class="text-danger">Kamera tidak ditemukan</span>';
                return;
            }

            // Use first available camera
            const cameraId = cameras[0].id;

            // Clear reader area
            const readerEl = document.getElementById('reader');
            readerEl.innerHTML = '';

            // Create scanner
            html5QrcodeScanner = new Html5Qrcode("reader");

            // Config - using 5 FPS for better detection
            const config = {
                fps: 5,
                qrbox: { width: 250, height: 250 },
                aspectRatio: 1.0
            };

            // Start scanning
            await html5QrcodeScanner.start(
                cameraId,
                config,
                (decodedText) => {
                    onScanSuccess(decodedText);
                },
                (error) => {
                    // Silent - fires continuously
                }
            );

            isScanning = true;
            updateUI(true);

        } catch (err) {
            console.error('Error:', err);
            statusEl.innerHTML = '<span class="text-danger">Error: ' + err.message + '</span>';
        }
    }

    async function stopScanner() {
        if (html5QrcodeScanner) {
            try {
                await html5QrcodeScanner.stop();
            } catch (e) {}
        }
        isScanning = false;
        updateUI(false);
    }

    function onScanSuccess(decodedText) {
        if (!decodedText || !decodedText.trim()) return;
        
        console.log('Scanned:', decodedText);
        
        document.getElementById('uuid').value = decodedText.trim();
        
        document.getElementById('scannerStatus').innerHTML = 
            '<span class="text-success">QR Code terbaca: ' + decodedText + '</span>';
        
        // Stop scanner
        stopScanner();
    }

    function updateUI(scanning) {
        const startBtn = document.getElementById('startScanner');
        const stopBtn = document.getElementById('stopScanner');
        const statusEl = document.getElementById('scannerStatus');

        if (scanning) {
            startBtn.classList.add('d-none');
            stopBtn.classList.remove('d-none');
            statusEl.innerHTML = '<span class="text-success">Kamera aktif - arahkan QR code ke kamera</span>';
        } else {
            startBtn.classList.remove('d-none');
            stopBtn.classList.add('d-none');
            statusEl.innerHTML = 'Klik "Buka Kamera" untuk mulai scan';
        }
    }
</script>
@endsection
