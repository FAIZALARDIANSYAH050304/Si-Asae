@extends('layouts.app')

@section('title', 'Detail User')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail User</h5>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="200">Nama</th>
                            <td>: {{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>: {{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>NIP</th>
                            <td>: {{ $user->nip ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Jabatan</th>
                            <td>: {{ $user->jabatan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td>: 
                                @foreach($user->roles as $role)
                                    <span class="badge bg-primary">{{ $role->name }}</span>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>Permissions</th>
                            <td>: 
                                @foreach($user->permissions as $permission)
                                    <span class="badge bg-info">{{ $permission->name }}</span>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <th>Terdaftar</th>
                            <td>: {{ $user->created_at->format('d/m/Y') }}</td>
                        </tr>
                    </table>
                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">Edit</a>
                        <form method="POST" action="{{ route('users.destroy', $user) }}" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
