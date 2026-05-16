<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$results = DB::select("
    SELECT COLUMN_NAME 
    FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = 'si-lapas' 
    AND TABLE_NAME = 'kegiatans' 
    AND COLUMN_NAME LIKE 'jenis%'
");

$dbCol = $results[0]->COLUMN_NAME;

// Expected strings
$exp1 = 'jenis_kegatan';  // with 'i' 
$exp2 = 'jenis_kegatan';  // without 'i'

echo "DB column: '$dbCol'\n";
echo "Expected1: '$exp1'\n";
echo "Expected2: '$exp2'\n\n";

$match1 = ($dbCol === $exp1);
$match2 = ($dbCol === $exp2);

echo "Matches 'jenis_kegatan'? " . ($match1 ? "YES" : "NO") . "\n";
echo "Matches 'jenis_kegatan'? " . ($match2 ? "YES" : "NO") . "\n";
