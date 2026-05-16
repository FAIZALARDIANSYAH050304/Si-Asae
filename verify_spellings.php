<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Get database column
$columns = DB::getSchemaBuilder()->getColumnListing('kegiatans');
$dbColumn = $columns[4]; // jenis_kegatan is at index 4

// Get model fillable
$model = new \App\Models\Kegiatans();
$modelFillable = $model->getFillable();
$fillable = $modelFillable[3]; // jenis_kegatan is at index 3

echo "Database column: '$dbColumn' (length: " . strlen($dbColumn) . ")\n";
echo "Model fillable: '$fillable' (length: " . strlen($fillable) . ")\n";
echo "\n";

if ($dbColumn === $fillable) {
    echo "✓ MATCH - No issue\n";
} else {
    echo "✗ MISMATCH - This is the bug!\n";
    echo "Database: $dbColumn\n";
    echo "Model:    $fillable\n";
}
