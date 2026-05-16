<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warga_binaan_id')->constrained('warga_binaan')->onDelete('cascade');
            $table->foreignId('program_asimilasi_id')->constrained('program_asimilasi')->onDelete('cascade');
            $table->date('tanggal_penilaian');
            $table->integer('keterampilan')->unsigned();
            $table->integer('kedisiplinan')->unsigned();
            $table->integer('sikap')->unsigned();
            $table->text('catatan')->nullable();
            $table->decimal('rata_rata', 5, 2)->unsigned();
            $table->enum('predikat', ['Sangat Baik', 'Baik', 'Cukup', 'Kurang']);
            $table->foreignId('petugas_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};
