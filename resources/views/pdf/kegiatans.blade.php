<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Kegiatan Harian - SI-LAPAS</title>
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
        <h1>Laporan Kegiatan Harian</h1>
        <h2>SI-LAPAS</h2>
    </div>
    <div class="info">
        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($tanggal)->format('d/m/Y') }}</p>
        <p><strong>Tanggal Cetak:</strong> {{ now()->format('d/m/Y') }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Warga</th>
                <th>Program</th>
                <th>Jenis Kegiatan</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kegiatans as $index => $keg)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $keg->wargaBinaan->nama }}</td>
                <td>{{ $keg->programAsimilasi->nama_program }}</td>
<td>{{ $keg->jenis_kegatan }}</td>
                <td>{{ $keg->deskripsi }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
