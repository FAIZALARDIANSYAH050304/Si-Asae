<?php
// Fix column issue - ensure 'jenis_kegatan' column exists

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Check columns in kegiatans table
$columns = DB::select('DESCRIBE kegiatans');
echo "Current columns in kegiatans table:\n";
foreach ($columns as $col) {
    echo "- " . $col->Field . "\n";
}

// Check for the CORRECT column (with 'i'): 'jenis_kegatan'
$hasCorrectColumn = collect($columns)->contains(function($col) {
    return $col->Field === 'jenis_kegatan';
});

// Check for the TYPO column (without 'i'): 'jenis_kegatan'
$hasTypoColumn = collect($columns)->contains(function($col) {
    return $col->Field === 'jenis_kegatan';
});

echo "\nHas 'jenis_kegatan' (WITH i - correct)? " . ($hasCorrectColumn ? 'YES' : 'NO') . "\n";
echo "Has 'jenis_kegatan' (WITHOUT i - typo)? " . ($hasTypoColumn ? 'YES' : 'NO') . "\n";

if ($hasCorrectColumn) {
    echo "\nColumn 'jenis_kegatan' already exists - nothing to fix!\n";
} elseif ($hasTypoColumn) {
    echo "\nColumn exists as typo - renaming...\n";
    DB::statement('ALTER TABLE kegiatans CHANGE COLUMN jenis_kegatan jenis_kegatan VARCHAR(255) NULL');
    echo "Renamed!\n";
} else {
    echo "\nAdding missing column 'jenis_kegatan'...\n";
    DB::statement('ALTER TABLE kegiatans ADD COLUMN jenis_kegatan VARCHAR(255) NULL AFTER tanggal');
    echo "Added!\n";
}
