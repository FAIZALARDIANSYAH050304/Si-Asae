@extends('layouts.app')

@section('title', 'Absensi')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Data Absensi</h5>
                    <div>
                        <a href="{{ route('absensi.scan') }}" class="btn btn-success me-2">
                            <i class="bi bi-qr-code-scan"></i> Scan QR
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Stats -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h6 class="text-white-50">Hadir</h6>
                                    <h3 class="mb-0">{{ $stats['hadir'] }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h6 class="text-white-50">Izin</h6>
                                    <h3 class="mb-0">{{ $stats['izin'] }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger text-white">
                                <div class="card-body">
                                    <h6 class="text-white-50">Alpha</h6>
                                    <h3 class="mb-0">{{ $stats['alpha'] }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h6 class="text-white-50">Total</h6>
                                    <h3 class="mb-0">{{ $stats['total'] }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('absensi.index') }}" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <input type="text" name="search" class="form-control" placeholder="Cari nama..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal', date('Y-m-d')) }}">
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="Hadir" {{ request('status') == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                                    <option value="Izin" {{ request('status') == 'Izin' ? 'selected' : '' }}>Izin</option>
                                    <option value="Alpha" {{ request('status') == 'Alpha' ? 'selected' : '' }}>Alpha</option>
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
                                    <th>Tanggal</th>
                                    <th>Jam Masuk</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($absensis as $index => $absen)
                                <tr>
                                    <td>{{ $absensis->firstItem() + $index }}</td>
                                    <td>{{ $absen->wargaBinaan->nama ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($absen->tanggal)->format('d/m/Y') }}</td>
                                    <td>{{ $absen->jam_masuk }}</td>
                                    <td>
                                        @php
                                            $badgeClass = match($absen->status_kehadiran) {
                                                'Hadir' => 'bg-success',
                                                'Izin' => 'bg-warning',
                                                'Alpha' => 'bg-danger',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $absen->status_kehadiran }}</span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger" title="Hapus" onclick="confirmDelete('{{ route('absensi.destroy', $absen->id) }}')">
                                            <i class="bi bi-trash"></i>
                                        </button>
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
                        {{ $absensis->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
