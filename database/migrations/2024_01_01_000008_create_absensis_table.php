<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warga_binaan_id')->constrained('warga_binaan')->onDelete('cascade');
            $table->foreignId('kegiatans_id')->nullable()->constrained('kegiatans')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('jam_masuk');
            $table->enum('status_kehadiran', ['Hadir', 'Izin', 'Alpha'])->default('Hadir');
            $table->foreignId('petugas_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['warga_binaan_id', 'tanggal'], 'unique_absensi_per_hari');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
