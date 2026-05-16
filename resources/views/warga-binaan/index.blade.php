@extends('layouts.app')

@section('title', 'Warga Binaan')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Data Warga Binaan</h5>
                    <a href="{{ route('warga-binaan.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Tambah Warga Binaan
                    </a>
                </div>
                <div class="card-body">
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('warga-binaan.index') }}" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="Cari nama, NIK, atau nomor register..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>Nama</th>
                                    <th>NIK</th>
                                    <th>No. Register</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($wargaBinaans as $index => $warga)
                                <tr>
                                    <td>{{ $wargaBinaans->firstItem() + $index }}</td>
                                    <td>
                                        @if($warga->foto)
                                            <img src="{{ asset('storage/' . $warga->foto) }}" alt="Foto" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $warga->nama }}</td>
                                    <td>{{ $warga->nik }}</td>
                                    <td>{{ $warga->nomor_register }}</td>
                                    <td>{{ $warga->jenis_kelamin }}</td>
                                    <td>
                                        @php
                                            $badgeClass = match($warga->status_asimilasi) {
                                                'Aktif' => 'bg-success',
                                                'Selesai' => 'bg-info',
                                                'Pelanggaran' => 'bg-danger',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $warga->status_asimilasi }}</span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('warga-binaan.show', $warga->id) }}" class="btn btn-sm btn-info" title="Lihat">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('warga-binaan.edit', $warga->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="{{ route('warga-binaan.qr', $warga->id) }}" class="btn btn-sm btn-dark" title="QR Code">
                                                <i class="bi bi-qr-code"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" title="Hapus" onclick="confirmDelete('{{ route('warga-binaan.destroy', $warga->id) }}')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">Tidak ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $wargaBinaans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
