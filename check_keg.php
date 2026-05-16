<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Use backtick to prevent case sensitivity issues
$results = DB::select("
    SELECT `COLUMN_NAME` as col, `IS_NULLABLE`, COLLATION_NAME
    FROM `INFORMATION_SCHEMA`.`COLUMNS` 
    WHERE `TABLE_SCHEMA` = 'si-lapas' AND `TABLE_NAME` = 'kegiatans' 
    AND `COLUMN_NAME` LIKE '%keg%'
");

echo "=== Columns with 'keg' ===\n";
print_r($results);

// Let's also try direct SHOW COLUMNS to see what's really going on
echo "\n=== Via SHOW COLUMNS ===\n";
$show = DB::select('SHOW COLUMNS FROM kegiatans');
foreach ($show as $s) {
    if (strpos($s->Field, 'keg') !== false) {
        echo "Found: $s->Field\n";
    }
}
