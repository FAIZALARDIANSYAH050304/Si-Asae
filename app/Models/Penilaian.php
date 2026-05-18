<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;

class Penilaian extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'warga_binaan_id',
        'program_asimilasi_id',
        'tanggal_penilaian',
        'keterampilan',
        'kedisiplinan',
        'sikap',
        'catatan',
        'rata_rata',
        'predikat',
        'petugas_id',
    ];

    protected $casts = [
        'tanggal_penilaian' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($penilaian) {
            $rataRata = ($penilaian->keterampilan + $penilaian->kedisiplinan + $penilaian->sikap) / 3;
            $penilaian->rata_rata = round($rataRata, 2);
            $penilaian->predikat = self::getPredikat($rataRata);
        });
    }

    public static function getPredikat(float $rataRata): string
    {
        if ($rataRata >= 90) {
            return 'Sangat Baik';
        } elseif ($rataRata >= 75) {
            return 'Baik';
        } elseif ($rataRata >= 60) {
            return 'Cukup';
        } else {
            return 'Kurang';
        }
    }

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

    public function getActivitylogOptions(): \Spatie\Activitylog\LogOptions
    {
        return \Spatie\Activitylog\LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }
}
