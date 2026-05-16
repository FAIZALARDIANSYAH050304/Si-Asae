<?php
// Verify columns - debug script

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Check columns
$columns = DB::select('DESCRIBE kegiatans');
echo "Current columns in kegiatans table:\n";
foreach ($columns as $col) {
    echo "- Field: '" . $col->Field . "' (length: " . strlen($col->Field) . ")\n";
}

// Get column names as array for inspection
$columnNames = array_map(function($col) {
    return $col->Field;
}, $columns);

// Show all column names in different formats for clarity
echo "\nSearching for specific strings...\n";

// Check each column
foreach ($columnNames as $name) {
    echo "- '$name' (len=" . strlen($name) . ")\n";
    
    // Check different possible spellings - using raw bytes
    if (strpos($name, 'kegatan') !== false) {
        echo "  -> Contains 'kegatan' (without i)\n";
    }
    if (strpos($name, 'kegatan') !== false) {
        echo "  -> Contains 'kegatan' (with i)\n";
    }
    if (strpos($name, 'kegiatn') !== false) {
        echo "  -> Contains 'kegiatn' (with i)"; 
    }
}
