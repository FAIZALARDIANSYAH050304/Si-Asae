<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
<title>Laporan Penilaian - SI-ASAE</title>
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
        <h1>Laporan Penilaian Warga Binaan</h1>
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
                <th>Program</th>
                <th>Keterampilan</th>
                <th>Kedisiplinan</th>
                <th>Sikap</th>
                <th>Rata-rata</th>
                <th>Predikat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $pen)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($pen->tanggal_penilaian)->format('d/m/Y') }}</td>
                <td>{{ $pen->wargaBinaan->nama }}</td>
                <td>{{ $pen->programAsimilasi->nama_program }}</td>
                <td>{{ $pen->keterampilan }}</td>
                <td>{{ $pen->kedisiplinan }}</td>
                <td>{{ $pen->sikap }}</td>
                <td>{{ $pen->rata_rata }}</td>
                <td>{{ $pen->predikat }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
