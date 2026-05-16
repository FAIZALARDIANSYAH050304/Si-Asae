@extends('layouts.app')

@section('title', 'Tambah Permission')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Tambah Permission Baru</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('users.permissions.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Permission</label>
                            <input type="text" name="name" class="form-control" placeholder="contoh: user_create" required>
                            <small class="text-muted">Gunakan format: namatable_aksi</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Group</label>
                            <select name="group" class="form-select" required>
                                <option value="">Pilih Group</option>
                                <option value="User">User</option>
                                <option value="WargaBinaan">Warga Binaan</option>
                                <option value="ProgramAsimilasi">Program Asimilasi</option>
                                <option value="Absensi">Absensi</option>
                                <option value="Penilaian">Penilaian</option>
                                <option value="Pelanggaran">Pelanggaran</option>
                                <option value="Laporan">Laporan</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('users.permissions') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
