<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;

class DokumentasiKegiatans extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'kegiatans_id',
        'foto',
        'caption',
    ];

    public function kegiatan(): BelongsTo
    {
        return $this->belongsTo(Kegiatans::class, 'kegiatans_id');
    }

    public function getActivitylogOptions(): \Spatie\Activitylog\LogOptions
    {
        return \Spatie\Activitylog\LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }
}
