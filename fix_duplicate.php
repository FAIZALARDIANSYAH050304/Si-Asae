<?php
// Remove duplicate column

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

// Check columns
$columns = DB::select('DESCRIBE kegiatans');
echo "Current columns in kegiatans table:\n";
foreach ($columns as $col) {
    echo "- " . $col->Field . "\n";
}

// Find both columns
$withI = collect($columns)->firstWhere('Field', 'jenis_kegatan');
$withoutI = collect($columns)->firstWhere('Field', 'jenis_kegatan');

echo "\nColumn 'jenis_kegatan' (WITH i): " . ($withI ? 'exists' : 'not found') . "\n";
echo "Column 'jenis_kegatan' (WITHOUT i): " . ($withoutI ? 'exists' : 'not found') . "\n";

// Drop the TYPO column (without 'i') if it exists
// But wait - looking at the list, without-i should be first in order (from original migration)
// Actually let's keep the one WITH 'i' and remove the TYPO one ( WITHOUT 'i')
if ($withoutI && $withI) {
    echo "\nDropping duplicate column 'jenis_kegatan' (without i)...\n";
    DB::statement('ALTER TABLE kegiatans DROP COLUMN jenis_kegatan');
    echo "Dropped!\n";
} else {
    echo "\nNo duplicates found.\n";
}
