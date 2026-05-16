@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-xl-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">Total Warga Binaan</h6>
                            <h2 class="mb-0">{{ $stats['totalWarga'] }}</h2>
                        </div>
                        <div class="fs-1 opacity-75">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">Warga Aktif</h6>
                            <h2 class="mb-0">{{ $stats['wargaAktif'] }}</h2>
                        </div>
                        <div class="fs-1 opacity-75">
                            <i class="bi bi-person-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">Program Aktif</h6>
                            <h2 class="mb-0">{{ $stats['totalProgram'] }}</h2>
                        </div>
                        <div class="fs-1 opacity-75">
                            <i class="bi bi-book"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">Pelanggaran Bulan Ini</h6>
                            <h2 class="mb-0">{{ $stats['totalPelanggaran'] }}</h2>
                        </div>
                        <div class="fs-1 opacity-75">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row Stats -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-start border-success border-4">
                <div class="card-body">
                    <h6 class="text-muted">Hadir Hari Ini</h6>
                    <h3 class="text-success">{{ $stats['absensiHadir'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-start border-warning border-4">
                <div class="card-body">
                    <h6 class="text-muted">Izin Hari Ini</h6>
                    <h3 class="text-warning">{{ $stats['absensiIzin'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-start border-danger border-4">
                <div class="card-body">
                    <h6 class="text-muted">Alpha Hari Ini</h6>
                    <h3 class="text-danger">{{ $stats['absensiAlpha'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Statistik Absensi 7 Hari Terakhir</h5>
                </div>
                <div class="card-body">
                    <canvas id="absensiChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Statistik Penilaian</h5>
                </div>
                <div class="card-body">
                    <canvas id="penilaianChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tables Row -->
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"> Kegiatan Terbaru</h5>
                    <a href="{{ route('kegiatans.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Warga</th>
                                    <th>Program</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kegiatansTerbaru as $kegiatans)
                                <tr>
                                    <td>{{ $kegiatans->wargaBinaan->nama ?? '-' }}</td>
                                    <td>{{ $kegiatans->programAsimilasi->nama_program ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($kegiatans->tanggal)->format('d/m/Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Belum ada kegiatan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Warga Paling Aktif</h5>
                    <a href="{{ route('warga-binaan.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>No. Register</th>
                                    <th>Total Kegiatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($wargaPalingAktif as $warga)
                                <tr>
                                    <td>{{ $warga->nama }}</td>
                                    <td>{{ $warga->nomor_register }}</td>
                                    <td><span class="badge bg-primary">{{ $warga->kegiatans_count }}</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Belum ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Absensi Chart
    const absensiData = @json($chartAbsensi);
    const absensiCtx = document.getElementById('absensiChart').getContext('2d');
    new Chart(absensiCtx, {
        type: 'line',
        data: {
            labels: absensiData.map(d => d.tanggal),
            datasets: [
                {
                    label: 'Hadir',
                    data: absensiData.map(d => d.hadir),
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    fill: true,
                },
                {
                    label: 'Izin',
                    data: absensiData.map(d => d.izin),
                    borderColor: '#ffc107',
                    backgroundColor: 'rgba(255, 193, 7, 0.1)',
                    fill: true,
                },
                {
                    label: 'Alpha',
                    data: absensiData.map(d => d.alpha),
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                    fill: true,
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // Penilaian Chart
    const penilaianData = @json($chartPenilaian);
    const penilaianCtx = document.getElementById('penilaianChart').getContext('2d');
    new Chart(penilaianCtx, {
        type: 'doughnut',
        data: {
            labels: ['Sangat Baik', 'Baik', 'Cukup', 'Kurang'],
            datasets: [{
                data: [
                    penilaianData.sangatBaik,
                    penilaianData.baik,
                    penilaianData.cukup,
                    penilaianData.kurang
                ],
                backgroundColor: ['#28a745', '#17a2b8', '#ffc107', '#dc3545']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
@endpush
@endsection
