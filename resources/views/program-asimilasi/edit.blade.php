@extends('layouts.app')

@section('title', 'Edit Program Asimilasi')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Form Edit Program Asimilasi</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('program-asimilasi.update', $program->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="nama_program" class="form-label">Nama Program <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_program') is-invalid @enderror" id="nama_program" name="nama_program" value="{{ old('nama_program', $program->nama_program) }}" required>
                            @error('nama_program')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select @error('kategori') is-invalid @enderror" id="kategori" name="kategori" required>
                                <option value="Pertanian" {{ old('kategori', $program->kategori) == 'Pertanian' ? 'selected' : '' }}>Pertanian</option>
                                <option value="Peternakan" {{ old('kategori', $program->kategori) == 'Peternakan' ? 'selected' : '' }}>Peternakan</option>
                                <option value="Kerajinan" {{ old('kategori', $program->kategori) == 'Kerajinan' ? 'selected' : '' }}>Kerajinan</option>
                                <option value="Perikanan" {{ old('kategori', $program->kategori) == 'Perikanan' ? 'selected' : '' }}>Perikanan</option>
                                <option value="Kebersihan" {{ old('kategori', $program->kategori) == 'Kebersihan' ? 'selected' : '' }}>Kebersihan</option>
                                <option value="Workshop" {{ old('kategori', $program->kategori) == 'Workshop' ? 'selected' : '' }}>Workshop</option>
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="penanggung_jawab" class="form-label">Penanggung Jawab</label>
                            <input type="text" class="form-control" id="penanggung_jawab" name="penanggung_jawab" value="{{ old('penanggung_jawab', $program->penanggung_jawab) }}">
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $program->deskripsi) }}</textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('program-asimilasi.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
