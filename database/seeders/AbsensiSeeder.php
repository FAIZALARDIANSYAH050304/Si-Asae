<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AbsensiSeeder extends Seeder
{
    public function run(): void
    {
        $wargaBinaans = DB::table('warga_binaan')->get();
        $kegiatans = DB::table('kegiatans')->get();
        $petugas = DB::table('users')->first();

        if ($wargaBinaans->isEmpty() || !$petugas) {
            $this->command->warn('Seeding absensis dilewati: data master belum lengkap.');
            return;
        }

        $petugasId = $petugas->id;

        // Generate absensi untuk beberapa hari terakhir
        $tanggalAbsensi = [
            '2024-01-15',
            '2024-01-16',
            '2024-01-17',
            '2024-01-18',
            '2024-01-19',
            '2024-01-20',
            '2024-01-21',
            '2024-01-22',
            '2024-01-23',
            '2024-01-24',
            '2024-01-25',
            '2024-01-26',
            '2024-01-27',
            '2024-01-28',
            '2024-01-29',
            '2024-01-30',
            '2024-01-31',
            '2024-02-01',
            '2024-02-02',
            '2024-02-03',
        ];

        $statuses = ['Hadir', 'Hadir', 'Hadir', 'Hadir', 'Hadir', 'Izin', 'Alpha'];

        $absensis = [];
        $id = 1;

foreach ($wargaBinaans as $warga) {
            foreach ($tanggalAbsensi as $tanggal) {
                $status = $statuses[array_rand($statuses)];
                
                // Beberapa warga tidak masuk di hari weekend (5 = Saturday, 6 = Sunday)
                $dayOfWeek = date('N', strtotime($tanggal));
                if ($dayOfWeek >= 6) {
                    $status = 'Izin';
                }

                // Set jam_masuk based on status (tidak bisa null)
                $jamMasuk = '07:00:00';
                if ($status === 'Izin') {
                    $jamMasuk = '08:00:00';
                } elseif ($status === 'Alpha') {
                    $jamMasuk = '00:00:00';
                }

                $absensis[] = [
                    'warga_binaan_id' => $warga->id,
                    'kegiatans_id' => null,
                    'tanggal' => $tanggal,
                    'jam_masuk' => $jamMasuk,
                    'status_kehadiran' => $status,
                    'petugas_id' => $petugasId,
                ];
            }
        }

        foreach ($absensis as $absensi) {
            $exists = DB::table('absensis')
                ->where('warga_binaan_id', $absensi['warga_binaan_id'])
                ->where('tanggal', $absensi['tanggal'])
                ->first();

            if (!$exists) {
                DB::table('absensis')->insert(array_merge($absensi, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }
    }
}
