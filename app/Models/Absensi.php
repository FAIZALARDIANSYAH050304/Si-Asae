<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;

class Absensi extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'warga_binaan_id',
        'kegiatans_id',
        'tanggal',
        'jam_masuk',
        'status_kehadiran',
        'petugas_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime:H:i',
    ];

    public function wargaBinaan(): BelongsTo
    {
        return $this->belongsTo(WargaBinaan::class);
    }

    public function kegiatans(): BelongsTo
    {
        return $this->belongsTo(Kegiatans::class, 'kegiatans_id');
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function getActivitylogOptions(): \Spatie\Activitylog\LogOptions
    {
        return \Spatie\Activitylog\LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }
}
