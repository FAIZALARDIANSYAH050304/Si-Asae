<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Check if column exists
        $columns = DB::select('DESCRIBE kegiatans');
        $columnNames = array_map(fn($col) => $col->Field, $columns);
        
        if (!in_array('jenis_kegatan', $columnNames)) {
            Schema::table('kegiatans', function (Blueprint $table) {
                $table->string('jenis_kegatan')->nullable()->after('tanggal');
            });
        }
    }

    public function down(): void
    {
        Schema::table('kegiatans', function (Blueprint $table) {
            $table->dropColumn('jenis_kegatan');
        });
    }
};
