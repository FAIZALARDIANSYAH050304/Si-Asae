@extends('layouts.app')

@section('title', 'Laporan Kehadiran')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <form method="GET" class="card p-3">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Awal</label>
                        <input type="date" name="tanggal_awal" class="form-control" value="{{ request('tanggal_awal', date('Y-m-01')) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Akhir</label>
                        <input type="date" name="tanggal_akhir" class="form-control" value="{{ request('tanggal_akhir', date('Y-m-d')) }}">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h3>{{ $stats['hadir'] }}</h3>
                    <p class="mb-0">Hadir</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <h3>{{ $stats['izin'] }}</h3>
                    <p class="mb-0">Izin</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body text-center">
                    <h3>{{ $stats['alpha'] }}</h3>
                    <p class="mb-0">Alpha</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h3>{{ $stats['total'] }}</h3>
                    <p class="mb-0">Total</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="mb-0">Data Kehadiran</h5>
                    <a href="{{ route('laporan.export', 'kehadiran') . '?tanggal_awal=' . request('tanggal_awal') . '&tanggal_akhir=' . request('tanggal_akhir') }}" class="btn btn-sm btn-success">
                        <i class="bi bi-download"></i> Export PDF
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Warga</th>
                                    <th>Status</th>
                                    <th>Jam</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $absen)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($absen->tanggal)->format('d/m/Y') }}</td>
                                    <td>{{ $absen->wargaBinaan->nama ?? '-' }}</td>
<td><span class="badge bg-{{ $absen->status_kehadiran == 'Hadir' ? 'success' : ($absen->status_kehadiran == 'Izin' ? 'warning' : 'danger') }}">{{ $absen->status_kehadiran }}</span></td>
                                    <td>{{ $absen->jam_masuk }}</td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center text-muted">Tidak ada data</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
