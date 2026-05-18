<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;

class Pelanggaran extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'warga_binaan_id',
        'tanggal',
        'jenis_pelanggaran',
        'deskripsi',
        'sanksi',
        'petugas_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function wargaBinaan(): BelongsTo
    {
        return $this->belongsTo(WargaBinaan::class);
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
