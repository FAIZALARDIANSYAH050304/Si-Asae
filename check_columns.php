<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$columns = DB::getSchemaBuilder()->getColumnListing('kegiatans');

echo "Columns in kegiatans table:\n";
print_r($columns);
