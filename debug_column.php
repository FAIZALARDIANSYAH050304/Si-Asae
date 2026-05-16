<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$columns = DB::getSchemaBuilder()->getColumnListing('kegiatans');

echo "Exact columns in kegiatans table:\n";
foreach ($columns as $index => $col) {
    echo "[$index] => $col (length: " . strlen($col) . ")\n";
}

// Check what the user model's fillable says
echo "\nModel Kegiatans fillable:\n";
$model = new \App\Models\Kegiatans();
print_r($model->getFillable());
