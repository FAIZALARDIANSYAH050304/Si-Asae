<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenilaianSeeder extends Seeder
{
    public function run(): void
    {
        $wargaBinaans = DB::table('warga_binaan')->get();
        $programs = DB::table('program_asimilasi')->get();
        $petugas = DB::table('users')->first();

        if ($wargaBinaans->isEmpty() || $programs->isEmpty() || !$petugas) {
            $this->command->warn('Seeding penilaians dilewati: data master belum lengkap.');
            return;
        }

        $petugasId = $petugas->id;

        $penilaians = [
            // Warga Binaan 1
            [
                'warga_binaan_id' => 1,
                'program_asimilasi_id' => 1,
                'tanggal_penilaian' => '2024-03-15',
                'keterampilan' => 85,
                'kedisiplinan' => 90,
                'sikap' => 88,
                'catatan' => 'Berkinerja sangat baik dalam program pertanian organik',
                'rata_rata' => 87.67,
                'predikat' => 'Sangat Baik',
                'petugas_id' => $petugasId,
            ],
            [
                'warga_binaan_id' => 1,
                'program_asimilasi_id' => 3,
                'tanggal_penilaian' => '2024-06-20',
                'keterampilan' => 75,
                'kedisiplinan' => 80,
                'sikap' => 82,
                'catatan' => 'Perlu peningkatan dalam keterampilan anyaman',
                'rata_rata' => 79.00,
                'predikat' => 'Baik',
                'petugas_id' => $petugasId,
            ],
            // Warga Binaan 2
            [
                'warga_binaan_id' => 2,
                'program_asimilasi_id' => 2,
                'tanggal_penilaian' => '2024-04-01',
                'keterampilan' => 88,
                'kedisiplinan' => 85,
                'sikap' => 90,
                'catatan' => 'Sangat berprestasi dalam beternak ayam',
                'rata_rata' => 87.67,
                'predikat' => 'Sangat Baik',
                'petugas_id' => $petugasId,
            ],
            [
                'warga_binaan_id' => 2,
                'program_asimilasi_id' => 4,
                'tanggal_penilaian' => '2024-07-10',
                'keterampilan' => 70,
                'kedisiplinan' => 75,
                'sikap' => 78,
                'catatan' => 'Masih tahap pembelajaran perikanan',
                'rata_rata' => 74.33,
                'predikat' => 'Cukup',
                'petugas_id' => $petugasId,
            ],
            // Warga Binaan 3
            [
                'warga_binaan_id' => 3,
                'program_asimilasi_id' => 3,
                'tanggal_penilaian' => '2024-04-15',
                'keterampilan' => 90,
                'kedisiplinan' => 88,
                'sikap' => 92,
                'catatan' => 'Sangat berbakat dalam kerajinan anyaman',
                'rata_rata' => 90.00,
                'predikat' => 'Sangat Baik',
                'petugas_id' => $petugasId,
            ],
[
                'warga_binaan_id' => 3,
                'program_asimilasi_id' => 5,
                'tanggal_penilaian' => '2024-05-20',
                'keterampilan' => 78,
                'kedisiplinan' => 85,
                'sikap' => 80,
                'catatan' => 'aktif dalam kegiatan kebersihan',
                'rata_rata' => 81.00,
                'predikat' => 'Baik',
                'petugas_id' => $petugasId,
            ],
            // Warga Binaan 4
            [
                'warga_binaan_id' => 4,
                'program_asimilasi_id' => 1,
                'tanggal_penilaian' => '2024-05-01',
                'keterampilan' => 80,
                'kedisiplinan' => 82,
                'sikap' => 85,
                'catatan' => ' baik dalam pertanian',
                'rata_rata' => 82.33,
                'predikat' => 'Baik',
                'petugas_id' => $petugasId,
            ],
            [
                'warga_binaan_id' => 4,
                'program_asimilasi_id' => 6,
                'tanggal_penilaian' => '2024-08-15',
                'keterampilan' => 72,
                'kedisiplinan' => 78,
                'sikap' => 80,
                'catatan' => 'Antusias dalam workshop',
                'rata_rata' => 76.67,
                'predikat' => 'Cukup',
                'petugas_id' => $petugasId,
            ],
            // Warga Binaan 5
            [
                'warga_binaan_id' => 5,
                'program_asimilasi_id' => 2,
                'tanggal_penilaian' => '2024-04-10',
                'keterampilan' => 92,
                'kedisiplinan' => 95,
                'sikap' => 90,
                'catatan' => 'Sangat optimal dalam peternakan',
                'rata_rata' => 92.33,
                'predikat' => 'Sangat Baik',
                'petugas_id' => $petugasId,
            ],
        ];

        foreach ($penilaians as $penilaian) {
            $exists = DB::table('penilaians')
                ->where('warga_binaan_id', $penilaian['warga_binaan_id'])
                ->where('program_asimilasi_id', $penilaian['program_asimilasi_id'])
                ->where('tanggal_penilaian', $penilaian['tanggal_penilaian'])
                ->first();

            if (!$exists) {
                DB::table('penilaians')->insert(array_merge($penilaian, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }
    }
}
