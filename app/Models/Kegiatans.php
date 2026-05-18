<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;

class Kegiatans extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'kegiatans';

    protected $fillable = [
        'warga_binaan_id',
        'petugas_id',
        'nama_kegiatans',
        'jenis_kegatan',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'lokasi',
        'keterangan',
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
        return $this->belongsTo(ProgramAsimilasi::class, 'program_asimilasi_id');
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function dokumentasiKegiatans(): HasMany
    {
        return $this->hasMany(DokumentasiKegiatans::class);
    }

    public function getActivitylogOptions(): \Spatie\Activitylog\LogOptions
    {
        return \Spatie\Activitylog\LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }
}
