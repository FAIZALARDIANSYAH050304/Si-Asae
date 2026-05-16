<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$kegiatans = DB::table('kegiatans')->orderBy('id', 'desc')->limit(5)->get();

echo "Recent kegiatans records:\n";
echo str_repeat("=", 80) . "\n";

foreach ($kegiatans as $k) {
    echo "ID: $k->id\n";
    echo "  warga_binaan_id: $k->warga_binaan_id\n";
    echo "  program_asimilasi_id: $k->program_asimilasi_id\n";
    echo "  tanggal: $k->tanggal\n";
    echo "  jenis_kegatan: " . ($k->jenis_kegatan ?? 'NULL') . "\n";
    echo "  deskripsi: " . ($k->deskripsi ?? 'NULL') . "\n";
    echo "  petugas_id: $k->petugas_id\n";
    echo str_repeat("-", 40) . "\n";
}
