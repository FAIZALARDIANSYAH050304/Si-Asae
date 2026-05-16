@extends('layouts.app')

@section('title', 'Detail Penilaian')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Detail Penilaian</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td width="40%" class="text-muted">Warga Binaan</td>
                            <td>{{ $penilaian->wargaBinaan->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Program</td>
                            <td>{{ $penilaian->programAsimilasi->nama_program ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Tanggal</td>
                            <td>{{ \Carbon\Carbon::parse($penilaian->tanggal_penilaian)->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Keterampilan</td>
                            <td>{{ $penilaian->keterampilan }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Kedisiplinan</td>
                            <td>{{ $penilaian->kedisiplinan }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Sikap</td>
                            <td>{{ $penilaian->sikap }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Rata-rata</td>
                            <td><strong>{{ $penilaian->rata_rata }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Predikat</td>
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
                        </tr>
                        <tr>
                            <td class="text-muted">Catatan</td>
                            <td>{{ $penilaian->catatan ?? '-' }}</td>
                        </tr>
                    </table>
                    <div class="d-flex gap-2 mt-4">
                        <a href="{{ route('penilaian.edit', $penilaian->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ route('penilaian.destroy', $penilaian->id) }}')">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                        <a href="{{ route('penilaian.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
