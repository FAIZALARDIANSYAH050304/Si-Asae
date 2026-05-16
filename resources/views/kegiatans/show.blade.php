@extends('layouts.app')

@section('title', 'Detail Kegiatan')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header"><h5 class="mb-0">Detail Kegiatan</h5></div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr><td width="40%">Warga</td><td>{{ $kegiatans->wargaBinaan->nama ?? '-' }}</td></tr>
                        <tr><td>Program</td><td>{{ $kegiatans->programAsimilasi->nama_program ?? '-' }}</td></tr>
<tr><td>Jenis</td><td>{{ $kegiatans->jenis_kegatan }}</td></tr>
                        <tr><td>Tanggal</td><td>{{ \Carbon\Carbon::parse($kegiatans->tanggal)->format('d/m/Y') }}</td></tr>
                        <tr><td>Deskripsi</td><td>{{ $kegiatans->deskripsi ?? '-' }}</td></tr>
                    </table>
                    <div class="d-flex gap-2 mt-4">
                        <a href="{{ route('kegiatans.edit', $kegiatans->id) }}" class="btn btn-warning">Edit</a>
                        <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ route('kegiatans.destroy', $kegiatans->id) }}')">Hapus</button>
                        <a href="{{ route('kegiatans.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
