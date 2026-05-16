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

echo "=== BREAKDOWN ===\n";
echo "Database column: '$dbColumn'\n";
echo "  Byte length: " . strlen($dbColumn) . "\n";
echo "  Letters: " . strlen(str_replace('_', '', $dbColumn)) . "\n";
echo "  Contains 'kegatan': " . (strpos($dbColumn, 'kegatan') !== false ? 'YES' : 'NO') . "\n";
echo "  Contains 'kegatan': " . (strpos($dbColumn, 'kegatan') !== false ? 'YES' : 'NO') . "\n\n";

echo "Model fillable: '$fillable'\n";
echo "  Byte length: " . strlen($fillable) . "\n";
echo "  Letters: " . strlen(str_replace('_', '', $fillable)) . "\n";
echo "  Contains 'kegatan': " . (strpos($fillable, 'kegatan') !== false ? 'YES' : 'NO') . "\n";
echo "  Contains 'kegatan': " . (strpos($fillable, 'kegatan') !== false ? 'YES' : 'NO') . "\n\n";

echo "Comparison:\n";
echo "  Direct match: " . ($dbColumn === $fillable ? 'YES' : 'NO') . "\n";
echo "  Hex dump database: " . bin2hex($dbColumn) . "\n";
echo "  Hex dump model:    " . bin2hex($fillable) . "\n";
