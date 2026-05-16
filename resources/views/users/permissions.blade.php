@extends('layouts.app')

@section('title', 'Kelola Permissions')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Kelola Permissions</h5>
                    <a href="{{ route('users.permissions.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle"></i> Tambah Permission
                    </a>
                </div>
                <div class="card-body">
                    @forelse($permissions as $group => $perms)
                    <div class="mb-4">
                        <h6 class="text-uppercase text-muted mb-3">{{ $group }}</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Nama Permission</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($perms as $permission)
                                    <tr>
                                        <td>{{ $permission->name }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('users.permissions.destroy', $permission) }}" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus permission ini?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted text-center">Tidak ada permission</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
