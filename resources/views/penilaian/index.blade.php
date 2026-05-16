@extends('layouts.app')

@section('title', 'Penilaian')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Data Penilaian</h5>
                    <a href="{{ route('penilaian.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Tambah Penilaian
                    </a>
                </div>
                <div class="card-body">
                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('penilaian.index') }}" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control" placeholder="Cari nama..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="warga_id" class="form-select">
                                    <option value="">Semua Warga</option>
                                    @foreach($wargaBinaans as $warga)
                                        <option value="{{ $warga->id }}" {{ request('warga_id') == $warga->id ? 'selected' : '' }}>{{ $warga->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="program_id" class="form-select">
                                    <option value="">Semua Program</option>
                                    @foreach($programs as $program)
                                        <option value="{{ $program->id }}" {{ request('program_id') == $program->id ? 'selected' : '' }}>{{ $program->nama_program }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Cari</button>
                            </div>
                        </div>
                    </form>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Warga</th>
                                    <th>Program</th>
                                    <th>Tanggal</th>
                                    <th>Keterampilan</th>
                                    <th>Kedisiplinan</th>
                                    <th>Sikap</th>
                                    <th>Rata-rata</th>
                                    <th>Predikat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($penilaians as $index => $penilaian)
                                <tr>
                                    <td>{{ $penilaians->firstItem() + $index }}</td>
                                    <td>{{ $penilaian->wargaBinaan->nama ?? '-' }}</td>
                                    <td>{{ $penilaian->programAsimilasi->nama_program ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($penilaian->tanggal_penilaian)->format('d/m/Y') }}</td>
                                    <td>{{ $penilaian->keterampilan }}</td>
                                    <td>{{ $penilaian->kedisiplinan }}</td>
                                    <td>{{ $penilaian->sikap }}</td>
                                    <td><strong>{{ $penilaian->rata_rata }}</strong></td>
                                    <td>
                                        @php
                                            $badgeClass = match($penilaian->predikat) {
                                                'Sangat Baik' => 'bg-success',
                                                'Baik' => 'bg-info',
                                                'Cukup' => 'bg-warning',
                                                'Kurang' => 'bg-danger',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $penilaian->predikat }}</span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('penilaian.show', $penilaian->id) }}" class="btn btn-sm btn-info" title="Lihat">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('penilaian.edit', $penilaian->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" title="Hapus" onclick="confirmDelete('{{ route('penilaian.destroy', $penilaian->id) }}')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted">Tidak ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $penilaians->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
