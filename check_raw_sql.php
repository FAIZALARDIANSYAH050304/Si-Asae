<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$results = DB::select('DESCRIBE kegiatans');

echo "=== Raw MySQL DESCRIBE kegiatans ===\n";
echo str_repeat("=", 60) . "\n";

foreach ($results as $row) {
    $field = $row->Field;
    $type = $row->Type;
    $null = $row->Null;
    $key = $row->Key;
    $default = $row->Default;
    
    echo "Field: '$field'\n";
    echo "  Type: $type\n";
    echo "  Null: $null\n";
    echo "  Key: $key\n";
    echo "  Default: " . ($default === null ? 'NULL' : $default) . "\n";
    echo "\n";
}
