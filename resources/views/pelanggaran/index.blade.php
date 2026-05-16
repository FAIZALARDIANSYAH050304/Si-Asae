@extends('layouts.app')

@section('title', 'Pelanggaran')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Data Pelanggaran</h5>
                    <a href="{{ route('pelanggaran.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Tambah Pelanggaran
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Warga</th>
                                    <th>Jenis Pelanggaran</th>
                                    <th>Tanggal</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pelanggarans as $index => $pelanggaran)
                                <tr>
                                    <td>{{ $pelanggarans->firstItem() + $index }}</td>
                                    <td>{{ $pelanggaran->wargaBinaan->nama ?? '-' }}</td>
                                    <td><span class="badge bg-danger">{{ $pelanggaran->jenis_pelanggaran }}</span></td>
                                    <td>{{ \Carbon\Carbon::parse($pelanggaran->tanggal)->format('d/m/Y') }}</td>
<td>{{ \Illuminate\Support\Str::limit($pelanggaran->deskripsi, 50) }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('pelanggaran.show', $pelanggaran->id) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('pelanggaran.edit', $pelanggaran->id) }}" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('{{ route('pelanggaran.destroy', $pelanggaran->id) }}')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Tidak ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $pelanggarans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
