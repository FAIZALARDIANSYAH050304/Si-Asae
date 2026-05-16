<?php
// Add the needed column

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$columns = DB::select('DESCRIBE kegiatans');
echo "Current columns in kegiatans table:\n";
foreach ($columns as $col) {
    echo "- " . $col->Field . " (len=" . strlen($col->Field) . ")\n";
}

// Verify what we need
// App uses: 'jenis_kegatan' (in field list for INSERT)
// Count chars: j-e-n-i-s-_-k-e-g-a-t-a-n = 13 characters
// Wait, that's WITHOUT i! Let me re-count:
// j-e-n-i-s = "jenis" = 5 letters
// _ = 1
// k-e-g-i-a-t-a-n = "kegatan" = 7 letters
// Total = 5+1+7 = 13 = WITHOUT 'i' in "kegatan"

// The CORRECT WORD should be "kegatan" (from original migration):
// "jenis_kegatan" = 13 characters total (without 'i')
// So the column name should be:
// "jenis_kegatan" <- This is what the model expects

// Add the needed column
$exists = collect($columns)->firstWhere('Field', 'jenis_kegatan');

if (!$exists) {
    echo "\nAdding 'jenis_kegatan' column...\n";
    DB::statement('ALTER TABLE kegiatans ADD COLUMN jenis_kegatan VARCHAR(255) NULL AFTER tanggal');
    echo "ADDED!\n";
} else {
    echo "\nColumn already exists\n";
}

// Show final state
echo "\nFinal columns:\n";
$cols = DB::select('DESCRIBE kegiatans');
foreach ($cols as $col) {
    echo "- " . $col->Field . "\n";
}
