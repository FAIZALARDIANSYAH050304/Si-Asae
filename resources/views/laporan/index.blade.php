@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<div class="container-fluid py-4">
    <div class="row g-4">
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('laporan.kehadiran') }}" class="text-decoration-none">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <i class="bi bi-calendar-check fs-1 text-primary"></i>
                        <h5 class="mt-3">Laporan Kehadiran</h5>
                        <p class="text-muted mb-0">Laporan absensi warga binaan</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('laporan.kegiatans') }}" class="text-decoration-none">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <i class="bi bi-calendar-event fs-1 text-success"></i>
                        <h5 class="mt-3">Laporan Kegiatan</h5>
                        <p class="text-muted mb-0">Laporan kegiatan harian</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('laporan.penilaian') }}" class="text-decoration-none">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <i class="bi bi-star fs-1 text-info"></i>
                        <h5 class="mt-3">Laporan Penilaian</h5>
                        <p class="text-muted mb-0">Laporan evaluasi warga</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('laporan.pelanggaran') }}" class="text-decoration-none">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <i class="bi bi-exclamation-triangle fs-1 text-danger"></i>
                        <h5 class="mt-3">Laporan Pelanggaran</h5>
                        <p class="text-muted mb-0">Laporan pelanggaran</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-4">
            <a href="{{ route('laporan.statistik-program') }}" class="text-decoration-none">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <i class="bi bi-pie-chart fs-1 text-warning"></i>
                        <h5 class="mt-3">Statistik Program</h5>
                        <p class="text-muted mb-0">Rekap per program</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
