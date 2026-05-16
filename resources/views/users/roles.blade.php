@extends('layouts.app')

@section('title', 'Kelola Roles')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Kelola Roles</h5>
                    <div>
                        <a href="{{ route('users.permissions') }}" class="btn btn-outline-secondary btn-sm me-2">Kelola Permissions</a>
                        <a href="{{ route('users.roles.create') }}" class="btn btn-primary btn-sm">Tambah Role</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama Role</th>
                                    <th>Permissions</th>
                                    <th>Jumlah User</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roles as $role)
                                <tr>
                                    <td><strong>{{ $role->name }}</strong></td>
                                    <td>
                                        @foreach($role->permissions as $permission)
                                            <span class="badge bg-info">{{ $permission->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>{{ $role->users_count ?? $role->users->count() }}</td>
                                    <td>
                                        <a href="{{ route('users.roles.edit', $role) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form method="POST" action="{{ route('users.roles.destroy', $role) }}" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus role?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Tidak ada role</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
