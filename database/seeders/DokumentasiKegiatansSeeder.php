<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DokumentasiKegiatansSeeder extends Seeder
{
    public function run(): void
    {
        $kegiatans = DB::table('kegiatans')->get();

        if ($kegiatans->isEmpty()) {
            $this->command->warn('Seeding dokumentasi_kegiatans dilewati: kegiatans belum ada.');
            return;
        }

        $dokumentasis = [
            // Dokumentasi untuk kegiatan 1 - WB 1 Pertanian
            [
                'kegiatans_id' => 1,
                'foto' => 'kegiatans/pertanian_001.jpg',
                'caption' => 'Mengolah tanah untuk penanaman sayuran organik',
            ],
            [
                'kegiatans_id' => 2,
                'foto' => 'kegiatans/pertanian_002.jpg',
                'caption' => 'Penyiraman tanaman pagi hari',
            ],
            [
                'kegiatans_id' => 3,
                'foto' => 'kegiatans/pertanian_003.jpg',
                'caption' => 'Pemupukan tanaman organik',
            ],
            // Dokumentasi untuk kegiatan 4-5 - WB 2 Peternakan
            [
                'kegiatans_id' => 4,
                'foto' => 'kegiatans/peternakan_001.jpg',
                'caption' => 'Pembersihan kandangan ayam',
            ],
            [
                'kegiatans_id' => 5,
                'foto' => 'kegiatans/peternakan_002.jpg',
                'caption' => 'Pemberian makan ayam',
            ],
            // Dokumentasi untuk kegiatan 6-7 - WB 3 Kerajinan
            [
                'kegiatans_id' => 6,
                'foto' => 'kegiatans/kerajinan_001.jpg',
                'caption' => 'Membuat anyaman rotan pertama',
            ],
            [
                'kegiatans_id' => 7,
                'foto' => 'kegiatans/kerajinan_002.jpg',
                'caption' => 'Anyaman rotan lanjutan',
            ],
            // Dokumentasi untuk kegiatan 8 - WB 4 Perkins
            [
                'kegiatans_id' => 8,
                'foto' => 'kegiatans/perikanan_001.jpg',
                'caption' => 'Pemeliharaan kolam ikan lele',
            ],
            // Dokumentasi untuk kegiatan 9-10 - WB 5 Kebersihan
            [
                'kegiatans_id' => 9,
                'foto' => 'kegiatans/kebersihan_001.jpg',
                'caption' => 'Membersihkan area blok',
            ],
            [
                'kegiatans_id' => 10,
                'foto' => 'kegiatans/kebersihan_002.jpg',
                'caption' => 'Membersihkan halaman lapas',
            ],
        ];

        foreach ($dokumentasis as $dokumentasi) {
            $exists = DB::table('dokumentasi_kegiatans')
                ->where('kegiatans_id', $dokumentasi['kegiatans_id'])
                ->where('foto', $dokumentasi['foto'])
                ->first();

            if (!$exists) {
                DB::table('dokumentasi_kegiatans')->insert(array_merge($dokumentasi, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }
    }
}
