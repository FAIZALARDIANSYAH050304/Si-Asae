@extends('layouts.app')

@section('title', 'Detail Warga Binaan')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    @if($wargaBinaan->foto)
                        <img src="{{ asset('storage/' . $wargaBinaan->foto) }}" alt="Foto" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 150px; height: 150px;">
                            <i class="bi bi-person fs-1"></i>
                        </div>
                    @endif
                    <h4>{{ $wargaBinaan->nama }}</h4>
                    <p class="text-muted">{{ $wargaBinaan->nomor_register }}</p>
                    @php
                        $badgeClass = match($wargaBinaan->status_asimilasi) {
                            'Aktif' => 'bg-success',
                            'Selesai' => 'bg-info',
                            'Pelanggaran' => 'bg-danger',
                            default => 'bg-secondary'
                        };
                    @endphp
                    <span class="badge {{ $badgeClass }} fs-6">{{ $wargaBinaan->status_asimilasi }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Data Pribadi</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td width="30%" class="text-muted">NIK</td>
                            <td>{{ $wargaBinaan->nik }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Jenis Kelamin</td>
                            <td>{{ $wargaBinaan->jenis_kelamin }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Tanggal Lahir</td>
                            <td>{{ \Carbon\Carbon::parse($wargaBinaan->tanggal_lahir)->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Alamat</td>
                            <td>{{ $wargaBinaan->alamat }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="d-flex gap-2 mb-4">
                <a href="{{ route('warga-binaan.edit', $wargaBinaan->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="{{ route('warga-binaan.qr', $wargaBinaan->id) }}" class="btn btn-dark">
                    <i class="bi bi-qr-code"></i> QR Code
                </a>
                <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ route('warga-binaan.destroy', $wargaBinaan->id) }}')">
                    <i class="bi bi-trash"></i> Hapus
                </button>
                <a href="{{ route('warga-binaan.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>

    <!-- Programs -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Program Asimilasi</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Program</th>
                                    <th>Kategori</th>
                                    <th>Penanggung Jawab</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($wargaBinaan->programs as $program)
                                <tr>
                                    <td>{{ $program->nama_program }}</td>
                                    <td>{{ $program->kategori }}</td>
                                    <td>{{ $program->penanggung_jawab ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Belum ada program</td>
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
@endsection
