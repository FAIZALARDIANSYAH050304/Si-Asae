@extends('layouts.app')

@section('title', 'Detail Program Asimilasi')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h4>{{ $program->nama_program }}</h4>
                    <span class="badge bg-info mb-3">{{ $program->kategori }}</span>
                    <p class="text-muted">{{ $program->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                    <hr>
                    <p><strong>Penanggung Jawab:</strong> {{ $program->penanggung_jawab ?? '-' }}</p>
                    <p><strong>Jumlah Warga:</strong> {{ $program->wargaBinaans->count() }}</p>
                    <div class="d-flex gap-2 mt-4">
                        <a href="{{ route('program-asimilasi.edit', $program->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ route('program-asimilasi.destroy', $program->id) }}')">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                        <a href="{{ route('program-asimilasi.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Warga Binaan Terdaftar</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>No. Register</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($program->wargaBinaans as $warga)
                                <tr>
                                    <td>{{ $warga->nama }}</td>
                                    <td>{{ $warga->nomor_register }}</td>
                                    <td>
                                        @php
                                            $badgeClass = match($warga->pivot->status ?? $warga->status_asimilasi) {
                                                'Aktif' => 'bg-success',
                                                'Selesai' => 'bg-info',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $warga->pivot->status ?? $warga->status_asimilasi }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Belum ada warga terdaftar</td>
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
