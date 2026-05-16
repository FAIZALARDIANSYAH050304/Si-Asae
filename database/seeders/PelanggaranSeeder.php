<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PelanggaranSeeder extends Seeder
{
    public function run(): void
    {
        $wargaBinaans = DB::table('warga_binaan')->get();
        $petugas = DB::table('users')->first();

if ($wargaBinaans->isEmpty() || !$petugas) {
            $this->command->warn('Seeding pelanggarans dilewati: data master belum lengkap.');
            return;
        }

        $petugasId = $petugas->id;

        $pelanggarns = [
            [
                'warga_binaan_id' => 1,
                'tanggal' => '2024-01-20',
                'jenis_pelanggaran' => 'Terlambat Masuk',
                'deskripsi' => 'Terlambat 15 menit memasuki area kerja',
                'sanksi' => 'Perwalian',
                'petugas_id' => $petugasId,
            ],
            [
                'warga_binaan_id' => 2,
                'tanggal' => '2024-02-10',
                'jenis_pelanggaran' => 'Tidak Mengikuti Kegiatan',
                'deskripsi' => 'Tidak mengikuti kegiatan pagi tanpa izin',
                'sanksi' => 'Tugas Extra',
                'petugas_id' => $petugasId,
            ],
            [
                'warga_binaan_id' => 3,
                'tanggal' => '2024-02-25',
                'jenis_pelanggaran' => 'Membuat Keributan',
                'deskripsi' => 'Membuat keributan dengan warga lainnya',
                'sanksi' => 'Isolasi 1 Hari',
                'petugas_id' => $petugasId,
            ],
            [
                'warga_binaan_id' => 4,
                'tanggal' => '2024-03-15',
                'jenis_pelanggaran' => 'Tidak MembersihkanÁrea',
                'deskripsi' => 'Tidak membersihkan area kerja setelah selesai',
                'sanksi' => 'Perwalian',
                'petugas_id' => $petugasId,
            ],
            [
                'warga_binaan_id' => 5,
                'tanggal' => '2024-01-25',
                'jenis_pelanggaran' => 'Pelanggaran Pakaian',
                'deskripsi' => 'Tidak memakai seragam dengan rapi',
                'sanksi' => 'Perwalian',
                'petugas_id' => $petugasId,
            ],
            [
                'warga_binaan_id' => 1,
                'tanggal' => '2024-04-10',
                'jenis_pelanggaran' => 'Berbicara Tidak Sopan',
                'deskripsi' => 'Berbicara tidak sopan kepada petugas',
                'sanksi' => 'Isolasi 3 Hari',
                'petugas_id' => $petugasId,
            ],
            [
                'warga_binaan_id' => 2,
                'tanggal' => '2024-05-20',
                'jenis_pelanggaran' => 'Membawa Barang Terlarang',
                'deskripsi' => 'Membawa barang yang tidak seharusnya',
                'sanksi' => 'Penahanan Barang',
                'petugas_id' => $petugasId,
            ],
            [
                'warga_binaan_id' => 3,
                'tanggal' => '2024-06-05',
                'jenis_pelanggaran' => 'Tidak Hadir Apel Malam',
                'deskripsi' => 'Tidak hadir dalam apel malam hari',
                'sanksi' => 'Tugas Extra',
                'petugas_id' => $petugasId,
            ],
        ];

foreach ($pelanggarns as $pelanggaran) {
            $exists = DB::table('pelanggarans')
                ->where('warga_binaan_id', $pelanggaran['warga_binaan_id'])
                ->where('tanggal', $pelanggaran['tanggal'])
                ->where('jenis_pelanggaran', $pelanggaran['jenis_pelanggaran'])
                ->first();

            if (!$exists) {
                DB::table('pelanggarans')->insert(array_merge($pelanggaran, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }
    }
}
