@extends('layouts.app')

@section('title', 'Laporan Pelanggaran')

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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header"><h5 class="mb-0">Data Pelanggaran</h5></div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead><tr><th>Tanggal</th><th>Warga</th><th>Jenis</th><th>Deskripsi</th></tr></thead>
                        <tbody>
                            @forelse($data as $pel)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($pel->tanggal)->format('d/m/Y') }}</td>
                                <td>{{ $pel->wargaBinaan->nama ?? '-' }}</td>
                                <td><span class="badge bg-danger">{{ $pel->jenis_pelanggaran }}</span></td>
                                <td>{{ $pel->deskripsi }}</td>
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
@endsection
