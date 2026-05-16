@extends('layouts.app')

@section('title', 'Tambah Pelanggaran')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Form Tambah Pelanggaran</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('pelanggaran.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="warga_binaan_id" class="form-label">Warga Binaan <span class="text-danger">*</span></label>
                            <select class="form-select @error('warga_binaan_id') is-invalid @enderror" name="warga_binaan_id" required>
                                <option value="">Pilih Warga</option>
                                @foreach($wargaBinaans as $warga)
                                    <option value="{{ $warga->id }}">{{ $warga->nama }} - {{ $warga->nomor_register }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="tanggal" value="{{ old('tanggal') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_pelanggaran" class="form-label">Jenis Pelanggaran <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="jenis_pelanggaran" value="{{ old('jenis_pelanggaran') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="sanksi" class="form-label">Sanksi</label>
                            <input type="text" class="form-control" name="sanksi" value="{{ old('sanksi') }}">
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
