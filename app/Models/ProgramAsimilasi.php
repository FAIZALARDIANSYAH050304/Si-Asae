<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramAsimilasi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'program_asimilasi';

    protected $fillable = [
        'nama_program',
        'kategori',
        'deskripsi',
        'penanggung_jawab',
    ];

    public function wargaBinaans(): BelongsToMany
    {
        return $this->belongsToMany(WargaBinaan::class, 'program_warga_binaan')
            ->withPivot('tanggal_mulai', 'tanggal_selesai', 'status')
            ->withTimestamps();
    }

    public function kegiatans(): HasMany
    {
        return $this->hasMany(Kegiatans::class);
    }

    public function penilaians(): HasMany
    {
        return $this->hasMany(Penilaian::class);
    }
}
