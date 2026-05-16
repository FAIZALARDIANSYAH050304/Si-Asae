<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Get the column info
$results = DB::select("
    SELECT COLUMN_NAME, IS_NULLABLE, COLUMN_DEFAULT, COLLATION_NAME
    FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = 'si-lapas' AND TABLE_NAME = 'kegiatans' 
    AND COLUMN_NAME = 'jenis_kegatan'
");

echo "=== After migration ===\n";
print_r($results);
