@extends('layouts.app')

@section('title', 'Monitoring Kegiatan')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Data Kegiatan</h5>
                    <a href="{{ route('kegiatans.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Tambah Kegiatan
                    </a>
                </div>
                <div class="card-body">
                    <form method="GET" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control" placeholder="Cari..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Cari</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Warga</th>
                                    <th>Program</th>
                                    <th>Jenis</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kegiatans as $index => $keg)
                                <tr>
                                    <td>{{ $kegiatans->firstItem() + $index }}</td>
                                    <td>{{ $keg->wargaBinaan->nama ?? '-' }}</td>
                                    <td>{{ $keg->programAsimilasi->nama_program ?? '-' }}</td>
<td>{{ $keg->jenis_kegatan }}</td>
                                    <td>{{ \Carbon\Carbon::parse($keg->tanggal)->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('kegiatans.show', $keg->id) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                                            <a href="{{ route('kegiatans.edit', $keg->id) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('{{ route('kegiatans.destroy', $keg->id) }}')"><i class="bi bi-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="6" class="text-center text-muted">Tidak ada data</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">{{ $kegiatans->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
