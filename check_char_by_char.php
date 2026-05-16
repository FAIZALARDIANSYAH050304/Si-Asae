<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Get both
$cols = DB::getSchemaBuilder()->getColumnListing('kegiatans');
$dbCol = null;
foreach ($cols as $c) {
    if (strpos($c, 'jenis') !== false) {
        $dbCol = $c;
        break;
    }
}

$model = new \App\Models\Kegiatans();
$fillableArr = $model->getFillable();
$modelCol = null;
foreach ($fillableArr as $f) {
    if (strpos($f, 'jenis') !== false) {
        $modelCol = $f;
        break;
    }
}

echo "=== Direct character comparison ===\n";
echo "DB column: '$dbCol'\n";
echo "Model fillable: '$modelCol'\n\n";

// Byte by byte
echo "=== Byte by byte analysis ===\n";
$dbBytes = unpack('C*', $dbCol);
$modelBytes = unpack('C*', $modelCol);

echo "Lengths - DB: " . count($dbBytes) . ", Model: " . count($modelBytes) . "\n\n";

for ($i = 1; $i <= max(count($dbBytes), count($modelBytes)); $i++) {
    $dbByte = $dbBytes[$i] ?? 0;
    $modelByte = $modelBytes[$i] ?? 0;
    if ($dbByte != $modelByte) {
        echo "Position $i: DB=0x" . sprintf('%02x', $dbByte) . " (" . ($dbByte > 32 ? chr($dbByte) : '?') . ") vs Model=0x" . sprintf('%02x', $modelByte) . " (" . ($modelByte > 32 ? chr($modelByte) : '?') . ") <<< MISMATCH!\n";
    }
}
