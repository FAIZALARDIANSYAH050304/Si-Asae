@extends('layouts.app')

@section('title', 'Statistik Program')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Statistik Program Asimilasi</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Program</th>
                                    <th>Kategori</th>
                                    <th>Total Warga</th>
                                    <th>Total Kegiatan</th>
                                    <th>Rata-rata Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $index => $program)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $program['nama_program'] }}</td>
                                    <td>{{ $program['kategori'] }}</td>
                                    <td>{{ $program['total_warga'] }}</td>
                                    <td>{{ $program['total_kegiatans'] }}</td>
                                    <td>{{ number_format($program['rata_nilai'], 2) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data</td>
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
