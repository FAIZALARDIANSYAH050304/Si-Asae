<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Check if columns exist
        $hasOld = DB::select("
            SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE TABLE_SCHEMA = 'si-lapas' AND TABLE_NAME = 'kegiatans' 
            AND COLUMN_NAME = 'jenis_kegatan'
        ");
        
        $hasNew = DB::select("
            SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE TABLE_SCHEMA = 'si-lapas' AND TABLE_NAME = 'kegiatans' 
            AND COLUMN_NAME = 'jenis_kegatan'
        ");
        
        if (!empty($hasOld)) {
            // Column is 'jenis_kegatan' (without i), make nullable
            DB::statement('ALTER TABLE kegiatans MODIFY jenis_kegatan VARCHAR(255) NULL');
        } elseif (!empty($hasNew)) {
            // Column is 'jenis_kegatan' (with i), make nullable  
            DB::statement('ALTER TABLE kegiatans MODIFY jenis_kegatan VARCHAR(255) NULL');
        }
    }

    public function down(): void
    {
        // Same logic - revert to NOT NULL
        DB::statement('ALTER TABLE kegiatans MODIFY jenis_kegatan VARCHAR(255) NOT NULL');
    }
};
