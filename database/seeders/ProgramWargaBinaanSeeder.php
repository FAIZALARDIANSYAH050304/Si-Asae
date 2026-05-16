<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramWargaBinaanSeeder extends Seeder
{
    public function run(): void
    {
        $wargaBinaans = DB::table('warga_binaan')->get();
        $programs = DB::table('program_asimilasi')->get();

        if ($wargaBinaans->isEmpty() || $programs->isEmpty()) {
            $this->command->warn('Seeding program_warga_binaan dilewati: warga_binaan atau program_asimilasi belum ada.');
            return;
        }

        $programWargaBinaans = [
            [
                'warga_binaan_id' => 1,
                'program_asimilasi_id' => 1,
                'tanggal_mulai' => '2024-01-15',
                'tanggal_selesai' => '2024-06-15',
                'status' => 'Selesai',
            ],
            [
                'warga_binaan_id' => 1,
                'program_asimilasi_id' => 3,
                'tanggal_mulai' => '2024-06-16',
                'tanggal_selesai' => null,
                'status' => 'Aktif',
            ],
            [
                'warga_binaan_id' => 2,
                'program_asimilasi_id' => 2,
                'tanggal_mulai' => '2024-02-01',
                'tanggal_selesai' => '2024-07-01',
                'status' => 'Selesai',
            ],
            [
                'warga_binaan_id' => 2,
                'program_asimilasi_id' => 4,
                'tanggal_mulai' => '2024-07-02',
                'tanggal_selesai' => null,
                'status' => 'Aktif',
            ],
            [
                'warga_binaan_id' => 3,
                'program_asimilasi_id' => 3,
                'tanggal_mulai' => '2024-02-15',
                'tanggal_selesai' => '2024-05-15',
                'status' => 'Selesai',
            ],
            [
                'warga_binaan_id' => 3,
                'program_asimilasi_id' => 5,
                'tanggal_mulai' => '2024-05-16',
                'tanggal_selesai' => null,
                'status' => 'Aktif',
            ],
            [
                'warga_binaan_id' => 4,
                'program_asimilasi_id' => 1,
                'tanggal_mulai' => '2024-03-01',
                'tanggal_selesai' => '2024-08-01',
                'status' => 'Selesai',
            ],
            [
                'warga_binaan_id' => 4,
                'program_asimilasi_id' => 6,
                'tanggal_mulai' => '2024-08-02',
                'tanggal_selesai' => null,
                'status' => 'Aktif',
            ],
            [
                'warga_binaan_id' => 5,
                'program_asimilasi_id' => 2,
                'tanggal_mulai' => '2024-01-10',
                'tanggal_selesai' => '2024-06-10',
                'status' => 'Selesai',
            ],
        ];

        foreach ($programWargaBinaans as $data) {
            $exists = DB::table('program_warga_binaan')
                ->where('warga_binaan_id', $data['warga_binaan_id'])
                ->where('program_asimilasi_id', $data['program_asimilasi_id'])
                ->where('tanggal_mulai', $data['tanggal_mulai'])
                ->first();

            if (!$exists) {
                DB::table('program_warga_binaan')->insert(array_merge($data, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }
    }
}
