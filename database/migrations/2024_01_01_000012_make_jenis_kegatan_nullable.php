<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // First try using direct SQL to modify the column
        DB::statement('ALTER TABLE kegiatans MODIFY jenis_kegatan VARCHAR(255) NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE kegiatans MODIFY jenis_kegatan VARCHAR(255) NOT NULL');
    }
};
