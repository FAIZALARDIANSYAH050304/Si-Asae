<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

$warga = DB::table('warga_binaan')->select('id', 'uuid', 'nama')->get();
echo "Warga Binaan Data:\n";
foreach ($warga as $w) {
    echo "ID: {$w->id}, UUID: {$w->uuid}, Nama: {$w->nama}\n";
}
