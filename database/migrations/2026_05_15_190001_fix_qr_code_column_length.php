<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Using raw SQL statement because column type change from varchar to text
        // requires MySQL schema modification
        DB::statement('ALTER TABLE warga_binaan MODIFY qr_code TEXT');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE warga_binaan MODIFY qr_code VARCHAR(255)');
    }
};
