@extends('layouts.app')

@section('title', 'Program Asimilasi')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Data Program Asimilasi</h5>
                    <a href="{{ route('program-asimilasi.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Tambah Program
                    </a>
                </div>
                <div class="card-body">
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('program-asimilasi.index') }}" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="Cari program atau penanggung jawab..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="kategori" class="form-select">
                                    <option value="">Semua Kategori</option>
                                    <option value="Pertanian" {{ request('kategori') == 'Pertanian' ? 'selected' : '' }}>Pertanian</option>
                                    <option value="Peternakan" {{ request('kategori') == 'Peternakan' ? 'selected' : '' }}>Peternakan</option>
                                    <option value="Kerajinan" {{ request('kategori') == 'Kerajinan' ? 'selected' : '' }}>Kerajinan</option>
                                    <option value="Perikanan" {{ request('kategori') == 'Perikanan' ? 'selected' : '' }}>Perikanan</option>
                                    <option value="Kebersihan" {{ request('kategori') == 'Kebersihan' ? 'selected' : '' }}>Kebersihan</option>
                                    <option value="Workshop" {{ request('kategori') == 'Workshop' ? 'selected' : '' }}>Workshop</option>
                                </select>
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
                                    <th>Nama Program</th>
                                    <th>Kategori</th>
                                    <th>Penanggung Jawab</th>
                                    <th>Jumlah Warga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($programs as $index => $program)
                                <tr>
                                    <td>{{ $programs->firstItem() + $index }}</td>
                                    <td>{{ $program->nama_program }}</td>
                                    <td><span class="badge bg-info">{{ $program->kategori }}</span></td>
                                    <td>{{ $program->penanggung_jawab ?? '-' }}</td>
                                    <td>{{ $program->wargaBinaans->count() }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('program-asimilasi.show', $program->id) }}" class="btn btn-sm btn-info" title="Lihat">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('program-asimilasi.edit', $program->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" title="Hapus" onclick="confirmDelete('{{ route('program-asimilasi.destroy', $program->id) }}')">
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

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $programs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
