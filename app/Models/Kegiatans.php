<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kegiatans extends Model
{
    use HasFactory;

    protected $fillable = [
        'warga_binaan_id',
        'program_asimilasi_id',
        'tanggal',
        'jenis_kegatan',
        'deskripsi',
        'petugas_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function wargaBinaan(): BelongsTo
    {
        return $this->belongsTo(WargaBinaan::class);
    }

    public function programAsimilasi(): BelongsTo
    {
        return $this->belongsTo(ProgramAsimilasi::class);
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function absensis(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }

    public function dokumentasiKegiatans(): HasMany
    {
        return $this->hasMany(DokumentasiKegiatans::class, 'kegiatans_id');
    }
}
