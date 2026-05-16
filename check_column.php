<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$columns = Illuminate\Support\Facades\DB::getSchemaBuilder()->getColumnListing('kegiatans');
echo "Columns in kegiatans table:\n";
print_r($columns);
