<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warga_binaan_id')->constrained('warga_binaan')->onDelete('cascade');
            $table->foreignId('program_asimilasi_id')->constrained('program_asimilasi')->onDelete('cascade');
            $table->date('tanggal');
            $table->string('jenis_kegiatan');
            $table->text('deskripsi')->nullable();
            $table->foreignId('petugas_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kegiatans');
    }
};
