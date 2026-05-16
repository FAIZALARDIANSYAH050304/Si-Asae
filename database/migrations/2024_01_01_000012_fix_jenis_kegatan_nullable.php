<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Fix: The database column is 'jenis_kegatan', make it nullable
        DB::statement('ALTER TABLE kegiatans MODIFY COLUMN jenis_kegatan VARCHAR(255) NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE kegiatans MODIFY COLUMN jenis_kegatan VARCHAR(255) NOT NULL');
    }
};
