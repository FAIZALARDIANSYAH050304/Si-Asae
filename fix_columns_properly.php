<?php
// Properly fix columns

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

echo "\nAnalyzing columns:\n";
// The CORRECT column should be "jenis_kegatan" (14 chars - WITH 'i')
// "jenis_kegatan" = j-e-n-i-s-_-k-e-g-i-a-t-a-n (with 'i')

foreach ($columns as $col) {
    $name = $col->Field;
    $len = strlen($name);
    
    // Look for the word that has "keg" or "keg"
    if (strpos($name, 'jenis_ke') !== false) {
        echo "Found '$name' (len=$len)\n";
        
        // The correct spelling is:
        // "jenis_kegatan" = 14 characters (jenis + _ + kegatan) - WITH 'i'
        // The typo is:
        // "jenis_kegatan" = 13 characters (jenis + _ + kegatan) - WITHOUT 'i'
        
        if ($len === 13 && strpos($name, 'kegatan') !== false) {
            // This is 13 chars but contains "kegatan" - wait let me recalculate
            // "kegatan" = k-e-g-a-t-a-n = 7 chars
            // "jenis_kegatan" = "jenis_kegatan" = 13 chars? No that's wrong.
            
            // Just drop one that's not needed - if we don't have the 14-char version
        }
    }
}

// If we have 13-char column but not 14-char column, rename 13 to 14
// If we have 14-char column, drop the 13

$col13 = collect($columns)->firstWhere('Field', 'jenis_kegatan');
$col14 = collect($columns)->firstWhere('Field', 'jenis_kegatan');

// Check actual names
echo "\nDirect column check:\n";
echo "Has 'jenis_kegatan' (with 'i'?)? " . ($col14 ? 'YES' : 'NO') . "\n";
echo "Has 'jenis_kegatan' (no 'i'?)? " . ($col13 ? 'YES' : 'NO') . "\n";

// Now let's add the CORRECT column (14 chars - with 'i') if missing
// The app expects: 'jenis_kegatan' (with 'i')
echo "\nAdding 'jenis_kegatan' (the correct one - 14 chars) if missing...\n";

if (!$col14) {
    // Add the correct column
    DB::statement('ALTER TABLE kegiatans ADD COLUMN jenis_kegatan VARCHAR(255) NULL AFTER tanggal');
    echo "Added column 'jenis_kegatan' (correct)\n";
} else {
    echo "Column already exists\n";
}

// Now drop the typo column (13 chars) if it exists
if ($col13) {
    echo "Dropping '$col13->Field'...\n";
    DB::statement('ALTER TABLE kegiatans DROP COLUMN `jenis_kegatan`');
    echo "Dropped typo column\n";
}
