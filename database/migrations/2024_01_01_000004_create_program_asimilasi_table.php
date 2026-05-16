<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_asimilasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_program');
            $table->enum('kategori', ['Pertanian', 'Peternakan', 'Kerajinan', 'Perikanan', 'Kebersihan', 'Workshop']);
            $table->text('deskripsi')->nullable();
            $table->string('penanggung_jawab')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_asimilasi');
    }
};
