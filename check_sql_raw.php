<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Direct Query ==\n";
$results = DB::select('SHOW COLUMNS FROM kegiatans');
foreach ($results as $row) {
    echo $row->Field . "\n";
}
