<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DokumentasiKegiatans extends Model
{
    use HasFactory;

    protected $fillable = [
        'kegiatans_id',
        'foto',
        'caption',
    ];

    public function kegiatan(): BelongsTo
    {
        return $this->belongsTo(Kegiatans::class, 'kegiatans_id');
    }
}
