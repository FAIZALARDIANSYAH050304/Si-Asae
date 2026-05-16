@extends('layouts.app')

@section('title', 'Edit Kegiatan')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header"><h5 class="mb-0">Form Edit Kegiatan</h5></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('kegiatans.update', $kegiatans->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Warga Binaan</label>
                            <select class="form-select" name="warga_binaan_id" required>
                                @foreach($wargaBinaan as $warga)
                                    <option value="{{ $warga->id }}" {{ old('warga_binaan_id', $kegiatans->warga_binaan_id) == $warga->id ? 'selected' : '' }}>{{ $warga->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Program Asimilasi</label>
                            <select class="form-select" name="program_asimilasi_id" required>
                                @foreach($programAsimilasi as $program)
                                    <option value="{{ $program->id }}" {{ old('program_asimilasi_id', $kegiatans->program_asimilasi_id) == $program->id ? 'selected' : '' }}>{{ $program->nama_program }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" value="{{ old('tanggal', $kegiatans->tanggal) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Kegiatan</label>
<input type="text" class="form-control" name="jenis_kegatan" value="{{ old('jenis_kegatan', $kegiatans->jenis_kegatan) }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" rows="3">{{ old('deskripsi', $kegiatans->deskripsi) }}</textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('kegiatans.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
