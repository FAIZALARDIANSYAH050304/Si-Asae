@extends('layouts.app')

@section('title', 'QR Code - ' . $wargaBinaan->nama)

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h5 class="mb-0">QR Code Warga Binaan</h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-4">
                        @if($wargaBinaan->foto)
                            <img src="{{ asset('storage/' . $wargaBinaan->foto) }}" alt="Foto" class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                            <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 100px; height: 100px;">
                                <i class="bi bi-person fs-1"></i>
                            </div>
                        @endif
                        <h4>{{ $wargaBinaan->nama }}</h4>
                        <p class="text-muted">{{ $wargaBinaan->nomor_register }}</p>
                    </div>
                    
<div class="border p-4 d-inline-block bg-white">
{!! app(\App\Services\QrCodeService::class)->generateHtml($wargaBinaan->uuid, 200) !!}
                    </div>
                    
                    <p class="mt-3 text-muted">UUID: {{ $wargaBinaan->uuid }}</p>
                </div>
                <div class="card-footer text-center">
                    <button onclick="window.print()" class="btn btn-primary">
                        <i class="bi bi-printer"></i> Cetak
                    </button>
                    <a href="{{ route('warga-binaan.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .sidebar, .topbar, .btn-secondary { display: none !important; }
    .card { border: none !important; }
    body { background: white !important; }
}
</style>
@endsection
