<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Get exact via INFORMATION_SCHEMA
$results = DB::select("
    SELECT COLUMN_NAME 
    FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = 'si-lapas' 
    AND TABLE_NAME = 'kegiatans' 
    AND COLUMN_NAME LIKE 'jenis%'
");

echo "=== Columns with 'jenis%' ===\n";
foreach ($results as $row) {
    echo $row->COLUMN_NAME . " (len:" . strlen($row->COLUMN_NAME) . ")\n";
    
    // Print each character
    echo "  Chars: ";
    for ($i = 0; $i < strlen($row->COLUMN_NAME); $i++) {
        echo ord($row->COLUMN_NAME[$i]) . "-";
    }
    echo "\n";
}
