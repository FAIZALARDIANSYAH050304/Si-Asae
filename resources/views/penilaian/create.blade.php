@extends('layouts.app')

@section('title', 'Tambah Penilaian')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Form Tambah Penilaian</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('penilaian.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="warga_binaan_id" class="form-label">Warga Binaan <span class="text-danger">*</span></label>
                                    <select class="form-select @error('warga_binaan_id') is-invalid @enderror" id="warga_binaan_id" name="warga_binaan_id" required>
                                        <option value="">Pilih Warga Binaan</option>
                                        @foreach($wargaBinaans as $warga)
                                            <option value="{{ $warga->id }}">{{ $warga->nama }} - {{ $warga->nomor_register }}</option>
                                        @endforeach
                                    </select>
                                    @error('warga_binaan_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="program_asimilasi_id" class="form-label">Program Asimilasi <span class="text-danger">*</span></label>
                                    <select class="form-select @error('program_asimilasi_id') is-invalid @enderror" id="program_asimilasi_id" name="program_asimilasi_id" required>
                                        <option value="">Pilih Program</option>
                                        @foreach($programs as $program)
                                            <option value="{{ $program->id }}">{{ $program->nama_program }}</option>
                                        @endforeach
                                    </select>
                                    @error('program_asimilasi_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tanggal_penilaian" class="form-label">Tanggal Penilaian <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('tanggal_penilaian') is-invalid @enderror" id="tanggal_penilaian" name="tanggal_penilaian" value="{{ old('tanggal_penilaian') }}" required>
                                    @error('tanggal_penilaian')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="keterampilan" class="form-label">Keterampilan (1-100) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('keterampilan') is-invalid @enderror" id="keterampilan" name="keterampilan" min="1" max="100" value="{{ old('keterampilan') }}" required>
                                    @error('keterampilan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="kedisiplinan" class="form-label">Kedisiplinan (1-100) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('kedisiplinan') is-invalid @enderror" id="kedisiplinan" name="kedisiplinan" min="1" max="100" value="{{ old('kedisiplinan') }}" required>
                                    @error('kedisiplinan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="sikap" class="form-label">Sikap (1-100) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('sikap') is-invalid @enderror" id="sikap" name="sikap" min="1" max="100" value="{{ old('sikap') }}" required>
                                    @error('sikap')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea class="form-control" id="catatan" name="catatan" rows="3">{{ old('catatan') }}</textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('penilaian.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
