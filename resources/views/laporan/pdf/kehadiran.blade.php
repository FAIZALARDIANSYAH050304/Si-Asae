<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
<title>Laporan Kehadiran - SI-ASAE</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
        .header { text-align: center; margin-bottom: 20px; }
        .info { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Kehadiran Warga Binaan</h1>
        <h2>SI-ASAE</h2>
    </div>
    <div class="info">
        <p><strong>Periode:</strong> {{ \Carbon\Carbon::parse($tanggal_awal)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($tanggal_akhir)->format('d/m/Y') }}</p>
        <p><strong>Tanggal Cetak:</strong> {{ now()->format('d/m/Y') }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Warga</th>
                <th>NIK</th>
                <th>Jam Masuk</th>
                <th>Status</th>
                <th>Petugas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $absen)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($absen->tanggal)->format('d/m/Y') }}</td>
                <td>{{ $absen->wargaBinaan->nama }}</td>
                <td>{{ $absen->wargaBinaan->nik }}</td>
                <td>{{ $absen->jam_masuk }}</td>
                <td>{{ $absen->status_kehadiran }}</td>
                <td>{{ $absen->petugas->name ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
