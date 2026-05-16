<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$cols = Illuminate\Support\Facades\DB::getSchemaBuilder()->getColumnListing('kegiatans');

foreach ($cols as $col) {
    if (strpos($col, 'jenis') !== false) {
        echo "FOUND: [" . $col . "]\n";
        echo "LENGTH: " . strlen($col) . " chars\n";
    }
}
