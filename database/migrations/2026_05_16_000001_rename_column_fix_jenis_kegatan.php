<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // The original migration creates column WITHOUT 'i' (typo): 'jenis_kegatan'
        // The app expects column WITH 'i': 'jenis_kegatan'
        // Check for the TYPO column (without 'i') that exists in database
        $hasTypoColumn = DB::select("
            SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE TABLE_SCHEMA = 'si-lapas' AND TABLE_NAME = 'kegiatans' 
            AND COLUMN_NAME = 'jenis_kegatan'
        ");
        
        if (!empty($hasTypoColumn)) {
            // Rename from 'jenis_kegatan' (without 'i') to 'jenis_kegatan' (with 'i')
            DB::statement('ALTER TABLE kegiatans CHANGE COLUMN jenis_kegatan jenis_kegatan VARCHAR(255) NULL');
        }
    }

    public function down(): void
    {
        // Revert: rename back 
        DB::statement('ALTER TABLE kegiatans CHANGE COLUMN jenis_kegatan jenis_kegatan VARCHAR(255) NOT NULL');
    }
};
