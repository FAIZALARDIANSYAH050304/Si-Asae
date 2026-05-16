@extends('layouts.app')

@section('title', 'Tambah Kegiatan')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header"><h5 class="mb-0">Form Tambah Kegiatan</h5></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('kegiatans.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Warga Binaan <span class="text-danger">*</span></label>
                            <select class="form-select" name="warga_binaan_id" required>
                                <option value="">Pilih Warga</option>
                                @foreach($wargaBinaan as $warga)
                                    <option value="{{ $warga->id }}">{{ $warga->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Program Asimilasi <span class="text-danger">*</span></label>
                            <select class="form-select" name="program_asimilasi_id" required>
                                <option value="">Pilih Program</option>
                                @foreach($programAsimilasi as $program)
                                    <option value="{{ $program->id }}">{{ $program->nama_program }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="tanggal" required>
                        </div>
<div class="mb-3">
                            <label class="form-label">Jenis Kegiatan <span class="text-danger">*</span></label>
<input type="text" class="form-control" name="jenis_kegatan" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" rows="3"></textarea>
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
