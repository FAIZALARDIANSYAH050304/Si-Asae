@extends('layouts.app')

@section('title', 'Edit Penilaian')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Form Edit Penilaian</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('penilaian.update', $penilaian->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="warga_binaan_id" class="form-label">Warga Binaan <span class="text-danger">*</span></label>
                                    <select class="form-select @error('warga_binaan_id') is-invalid @enderror" id="warga_binaan_id" name="warga_binaan_id" required>
                                        @foreach($wargaBinaans as $warga)
                                            <option value="{{ $warga->id }}" {{ old('warga_binaan_id', $penilaian->warga_binaan_id) == $warga->id ? 'selected' : '' }}>{{ $warga->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="program_asimilasi_id" class="form-label">Program Asimilasi <span class="text-danger">*</span></label>
                                    <select class="form-select" id="program_asimilasi_id" name="program_asimilasi_id" required>
                                        @foreach($programs as $program)
                                            <option value="{{ $program->id }}" {{ old('program_asimilasi_id', $penilaian->program_asimilasi_id) == $program->id ? 'selected' : '' }}>{{ $program->nama_program }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tanggal_penilaian" class="form-label">Tanggal Penilaian <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="tanggal_penilaian" name="tanggal_penilaian" value="{{ old('tanggal_penilaian', $penilaian->tanggal_penilaian) }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="keterampilan" class="form-label">Keterampilan (1-100)</label>
                                    <input type="number" class="form-control" id="keterampilan" name="keterampilan" min="1" max="100" value="{{ old('keterampilan', $penilaian->keterampilan) }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="kedisiplinan" class="form-label">Kedisiplinan (1-100)</label>
                                    <input type="number" class="form-control" id="kedisiplinan" name="kedisiplinan" min="1" max="100" value="{{ old('kedisiplinan', $penilaian->kedisiplinan) }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="sikap" class="form-label">Sikap (1-100)</label>
                                    <input type="number" class="form-control" id="sikap" name="sikap" min="1" max="100" value="{{ old('sikap', $penilaian->sikap) }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea class="form-control" id="catatan" name="catatan" rows="3">{{ old('catatan', $penilaian->catatan) }}</textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('penilaian.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
