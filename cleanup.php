<?php
// Clean up duplicate columns

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$columns = DB::select('DESCRIBE kegiatans');
echo "Current columns:\n";
foreach ($columns as $col) {
    echo "- " . $col->Field . " (len=" . strlen($col->Field) . ")\n";
}

// Find columns containing 'jenis_keg' in various forms
foreach ($columns as $col) {
    $name = $col->Field;
    if (strpos($name, 'jenis_keg') !== false) {
        echo "\nFound: '$name' (len=" . strlen($name) . ")\n";
        
        // The CORRECT column should be "jenis_kegatan" (13 chars with 'i')
        // The TYPO column would be "jenis_kegatan" - without 'i', but same length
        // The original migration creates "jenis_kegatan" 
        
        // Check if it's 14 chars - that's wrong
        if (strlen($name) === 14) {
            echo "Dropping column '$name' (length 14 - incorrect length)\n";
            DB::statement("ALTER TABLE kegiatans DROP COLUMN `$name`");
            echo "Dropped!\n";
        } elseif (strlen($name) === 13) {
            // Check if it's "jenis_kegatan" (correct) or "jenis_kegatan" (typo)
            if ($name === 'jenis_kegatan') {
                echo "Column 'jenis_kegatan' is correct - keeping\n";
            } else {
                echo "Found different column - checking: $name\n";
            }
        }
    }
}
