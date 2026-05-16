<?php
// Verify the fix is working

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== FINAL VERIFICATION ===\n\n";

// 1. Check columns in database
echo "1. Database columns in 'kegiatans' table:\n";
$columns = DB::select('DESCRIBE kegiatans');
foreach ($columns as $col) {
    echo "   - " . $col->Field . "\n";
}

// 2. Test SELECT with the column
echo "\n2. Testing SELECT query...\n";
try {
    $result = DB::table('kegiatans')->first();
    echo "   SUCCESS: SELECT works!\n";
} catch (\Exception $e) {
    echo "   ERROR: " . $e->getMessage() . "\n";
}

// 3. Test INSERT
echo "\n3. Testing INSERT query...\n";
try {
    $id = DB::table('kegiatans')->insertGetId([
        'warga_binaan_id' => 1,
        'program_asimilasi_id' => 1,
        'tanggal' => '2025-01-01',
        'jenis_kegatan' => 'Test Activity',
        'deskripsi' => 'Test description',
        'petugas_id' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    echo "   SUCCESS: INSERT works! New ID: $id\n";
    
    // Clean up test data
    DB::table('kegiatans')->where('id', $id)->delete();
    echo "   Test record cleaned up.\n";
} catch (\Exception $e) {
    echo "   ERROR: " . $e->getMessage() . "\n";
}

// 4. Check model fillable
echo "\n4. Model fillable:\n";
$kegiatans = new \App\Models\Kegiatans();
echo "   Fillable: " . implode(', ', $kegiatans->getFillable()) . "\n";

echo "\n=== DONE ===\n";
