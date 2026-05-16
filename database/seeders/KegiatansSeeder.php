<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KegiatansSeeder extends Seeder
{
    public function run(): void
    {
        $wargaBinaans = DB::table('warga_binaan')->get();
        $programs = DB::table('program_asimilasi')->get();
        $petugas = DB::table('users')->first();

        if ($wargaBinaans->isEmpty() || $programs->isEmpty() || !$petugas) {
            $this->command->warn('Seeding kegiatans dilewati: data master belum lengkap.');
            return;
        }

        $petugasId = $petugas->id;

        $kegiatans = [
            // Kegiatan untuk Warga Binaan 1 - Pertanian Organik
            [
                'warga_binaan_id' => 1,
                'program_asimilasi_id' => 1,
                'tanggal' => '2024-01-16',
                'jenis_kegiatan' => 'Pertanian',
                'deskripsi' => 'Mengolah tanah dan menanam sayuran organik',
                'petugas_id' => $petugasId,
            ],
            [
                'warga_binaan_id' => 1,
                'program_asimilasi_id' => 1,
                'tanggal' => '2024-01-17',
                'jenis_kegiatan' => 'Pertanian',
                'deskripsi' => 'Penyiraman dan perawatan tanaman',
                'petugas_id' => $petugasId,
            ],
            [
                'warga_binaan_id' => 1,
                'program_asimilasi_id' => 1,
                'tanggal' => '2024-01-18',
                'jenis_kegiatan' => 'Pertanian',
                'deskripsi' => 'Pemupukan organik tanaman sayuran',
                'petugas_id' => $petugasId,
            ],
            // Kegiatan untuk Warga Binaan 2 - Peternakan Ayam
            [
                'warga_binaan_id' => 2,
                'program_asimilasi_id' => 2,
                'tanggal' => '2024-02-02',
                'jenis_kegiatan' => 'Peternakan',
                'deskripsi' => 'Perawatan dan pembersihan kandangan ayam',
                'petugas_id' => $petugasId,
            ],
            [
                'warga_binaan_id' => 2,
                'program_asimilasi_id' => 2,
                'tanggal' => '2024-02-03',
                'jenis_kegiatan' => 'Peternakan',
                'deskripsi' => 'Pemberian makan dan vitamin ayam',
                'petugas_id' => $petugasId,
            ],
            // Kegiatan untuk Warga Binaan 3 - Kerajinan Anyaman
            [
                'warga_binaan_id' => 3,
                'program_asimilasi_id' => 3,
                'tanggal' => '2024-02-16',
                'jenis_kegiatan' => 'Kerajinan',
                'deskripsi' => 'Membuat anyaman rotan sederhana',
                'petugas_id' => $petugasId,
            ],
[
                'warga_binaan_id' => 3,
                'program_asimilasi_id' => 3,
                'tanggal' => '2024-02-17',
                'jenis_kegiatan' => 'Kerajinan',
                'deskripsi' => 'Melanjutkan anyaman rotan',
                'petugas_id' => $petugasId,
            ],
            // Kegiatan untuk Warga Binaan 4 - Perikanan Lele
            [
                'warga_binaan_id' => 4,
                'program_asimilasi_id' => 4,
                'tanggal' => '2024-03-02',
                'jenis_kegiatan' => 'Perikanan',
                'deskripsi' => 'Pemeliharaan kolam ikan lele',
                'petugas_id' => $petugasId,
            ],
            // Kegiatan untuk Warga Binaan 5 - Kebersihan
            [
                'warga_binaan_id' => 5,
                'program_asimilasi_id' => 5,
                'tanggal' => '2024-01-11',
                'jenis_kegiatan' => 'Kebersihan',
                'deskripsi' => 'Membersihan area blok inmate',
                'petugas_id' => $petugasId,
            ],
            [
                'warga_binaan_id' => 5,
                'program_asimilasi_id' => 5,
                'tanggal' => '2024-01-12',
                'jenis_kegiatan' => 'Kebersihan',
                'deskripsi' => 'Membersihan halaman lapas',
                'petugas_id' => $petugasId,
            ],
            // Beberapa kegiatan terbaru
            [
                'warga_binaan_id' => 1,
                'program_asimilasi_id' => 3,
                'tanggal' => '2024-06-20',
                'jenis_kegiatan' => 'Kerajinan',
                'deskripsi' => 'Workshop anyaman rotan lanjutan',
                'petugas_id' => $petugasId,
            ],
            [
                'warga_binaan_id' => 2,
                'program_asimilasi_id' => 4,
                'tanggal' => '2024-07-10',
                'jenis_kegiatan' => 'Perikanan',
                'deskripsi' => 'Pembersihan kolam ikan',
                'petugas_id' => $petugasId,
            ],
            [
                'warga_binaan_id' => 3,
                'program_asimilasi_id' => 5,
                'tanggal' => '2024-05-20',
                'jenis_kegiatan' => 'Kebersihan',
                'deskripsi' => 'Gotong royong kebersihan lingkungan',
                'petugas_id' => $petugasId,
            ],
            [
                'warga_binaan_id' => 4,
                'program_asimilasi_id' => 6,
                'tanggal' => '2024-08-10',
                'jenis_kegiatan' => 'Workshop',
                'deskripsi' => 'Workshop kewirausahaan dasar',
                'petugas_id' => $petugasId,
            ],
        ];

        foreach ($kegiatans as $kegiatann) {
            $exists = DB::table('kegiatans')
                ->where('warga_binaan_id', $kegiatann['warga_binaan_id'])
                ->where('program_asimilasi_id', $kegiatann['program_asimilasi_id'])
                ->where('tanggal', $kegiatann['tanggal'])
                ->first();

            if (!$exists) {
                DB::table('kegiatans')->insert(array_merge($kegiatann, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }
    }
}
