<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Debug: Check what's in model fillable vs database
$model = new \App\Models\Kegiatans();

echo "=== Model \$fillable ===\n";
print_r($model->getFillable());

echo "\n=== Database columns ===\n";
$cols = DB::getSchemaBuilder()->getColumnListing('kegiatans');
print_r($cols);

echo "\n=== Key comparison ===\n";
$fillable = $model->getFillable();

// Check each fillable field
foreach ($fillable as $f) {
    $found = in_array($f, $cols);
    echo "$f => " . ($found ? "EXISTS in DB" : "MISSING in DB") . "\n";
}
