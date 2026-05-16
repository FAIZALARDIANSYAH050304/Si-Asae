@extends('layouts.app')

@section('title', 'Edit Pelanggaran')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Form Edit Pelanggaran</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('pelanggaran.update', $pelanggaran->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="warga_binaan_id" class="form-label">Warga Binaan</label>
                            <select class="form-select" name="warga_binaan_id" required>
                                @foreach($wargaBinaans as $warga)
                                    <option value="{{ $warga->id }}" {{ old('warga_binaan_id', $pelanggaran->warga_binaan_id) == $warga->id ? 'selected' : '' }}>{{ $warga->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" value="{{ old('tanggal', $pelanggaran->tanggal) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_pelanggaran" class="form-label">Jenis Pelanggaran</label>
                            <input type="text" class="form-control" name="jenis_pelanggaran" value="{{ old('jenis_pelanggaran', $pelanggaran->jenis_pelanggaran) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" rows="3">{{ old('deskripsi', $pelanggaran->deskripsi) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="sanksi" class="form-label">Sanksi</label>
                            <input type="text" class="form-control" name="sanksi" value="{{ old('sanksi', $pelanggaran->sanksi) }}">
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('pelanggaran.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
