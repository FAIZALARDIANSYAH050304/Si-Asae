@extends('layouts.app')

@section('title', 'Laporan Penilaian')

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
            <div class="card bg-success text-white"><div class="card-body text-center"><h3>{{ $stats['sangatBaik'] }}</h3><p class="mb-0">Sangat Baik</p></div></div>
        </div>
        <div class="col-md-3">
            <div class="card bg-primary text-white"><div class="card-body text-center"><h3>{{ $stats['baik'] }}</h3><p class="mb-0">Baik</p></div></div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white"><div class="card-body text-center"><h3>{{ $stats['cukup'] }}</h3><p class="mb-0">Cukup</p></div></div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white"><div class="card-body text-center"><h3>{{ $stats['kurang'] }}</h3><p class="mb-0">Kurang</p></div></div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header"><h5 class="mb-0">Data Penilaian</h5></div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead><tr><th>Warga</th><th>Program</th><th>Tanggal</th><th>Rata-rata</th><th>Predikat</th></tr></thead>
                        <tbody>
                            @forelse($data as $nilai)
                            <tr>
                                <td>{{ $nilai->wargaBinaan->nama ?? '-' }}</td>
                                <td>{{ $nilai->programAsimilasi->nama_program ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($nilai->tanggal_penilaian)->format('d/m/Y') }}</td>
                                <td>{{ $nilai->rata_rata }}</td>
                                <td><span class="badge bg-{{ $nilai->predikat == 'Sangat Baik' ? 'success' : ($nilai->predikat == 'Baik' ? 'primary' : ($nilai->predikat == 'Cukup' ? 'warning' : 'danger')) }}">{{ $nilai->predikat }}</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted">Tidak ada data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
