<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;

class WargaBinaan extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'warga_binaan';

    protected $fillable = [
        'uuid',
        'nama',
        'nik',
        'nomor_register',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'foto',
        'qr_code',
        'status_asimilasi',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($wargaBinaan) {
            if (empty($wargaBinaan->uuid)) {
                $wargaBinaan->uuid = (string) Str::uuid();
            }
        });
    }

    public function programs(): BelongsToMany
    {
        return $this->belongsToMany(ProgramAsimilasi::class, 'program_warga_binaan')
            ->withPivot('tanggal_mulai', 'tanggal_selesai', 'status')
            ->withTimestamps();
    }

    public function kegiatans(): HasMany
    {
        return $this->hasMany(Kegiatans::class);
    }

    public function absensis(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }

    public function penilaians(): HasMany
    {
        return $this->hasMany(Penilaian::class);
    }

    public function pelanggarans(): HasMany
    {
        return $this->hasMany(Pelanggaran::class);
    }

public function getRouteKeyName(): string
    {
        return 'id';
    }

    public function getActivitylogOptions(): \Spatie\Activitylog\LogOptions
    {
        return \Spatie\Activitylog\LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }
}
