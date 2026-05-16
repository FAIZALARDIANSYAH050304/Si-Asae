@extends('layouts.app')

@section('title', 'Detail Pelanggaran')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Detail Pelanggaran</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td width="40%">Warga</td>
                            <td>{{ $pelanggaran->wargaBinaan->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td>{{ \Carbon\Carbon::parse($pelanggaran->tanggal)->format('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <td>Jenis</td>
                            <td><span class="badge bg-danger">{{ $pelanggaran->jenis_pelanggaran }}</span></td>
                        </tr>
                        <tr>
                            <td>Deskripsi</td>
                            <td>{{ $pelanggaran->deskripsi ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>Sanksi</td>
                            <td>{{ $pelanggaran->sanksi ?? '-' }}</td>
                        </tr>
                    </table>
                    <div class="d-flex gap-2 mt-4">
                        <a href="{{ route('pelanggaran.edit', $pelanggaran->id) }}" class="btn btn-warning">Edit</a>
                        <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ route('pelanggaran.destroy', $pelanggaran->id) }}')">Hapus</button>
                        <a href="{{ route('pelanggaran.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
