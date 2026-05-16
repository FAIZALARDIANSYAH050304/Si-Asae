<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Permissions
        $this->createPermissions();

        // Create Roles
        $this->createRoles();

        // Create Admin User
        $this->createAdminUser();

        // Create Petugas User
        $this->createPetugasUser();

        // Create Warga Binaan
        $this->createWargaBinaan();

        // Create Program Asimilasi
        $this->createProgramAsimilasi();

        // Create Program Warga Binaan
        $this->call(ProgramWargaBinaanSeeder::class);

        // Create Kegiatans
        $this->call(KegiatansSeeder::class);

        // Create Absensi
        $this->call(AbsensiSeeder::class);

        // Create Penilaian
        $this->call(PenilaianSeeder::class);

        // Create Pelanggaran
        $this->call(PelanggaranSeeder::class);

        // Create Dokumentasi Kegiatans
        $this->call(DokumentasiKegiatansSeeder::class);
    }

    private function createPermissions(): void
    {
        $permissions = [
            'warga-binaan.view',
            'warga-binaan.create',
            'warga-binaan.edit',
            'warga-binaan.delete',
            'program.view',
            'program.create',
            'program.edit',
            'program.delete',
            'absensi.view',
            'absensi.scan',
            'absensi.create',
            'penilaian.view',
            'penilaian.create',
            'penilaian.edit',
            'pelanggaran.view',
            'pelanggaran.create',
            'pelanggaran.edit',
            'kegiatans.view',
            'kegiatans.create',
            'kegiatans.edit',
            'kegiatans.delete',
            'laporan.view',
            'laporan.export',
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            'activity-log.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }

    private function createRoles(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $petugasRole = Role::firstOrCreate(['name' => 'petugas']);
        $petugasRole->givePermissionTo([
            'warga-binaan.view',
            'program.view',
            'absensi.view',
            'absensi.scan',
            'absensi.create',
            'penilaian.view',
            'penilaian.create',
            'pelanggaran.view',
            'pelanggaran.create',
            'kegiatans.view',
            'kegiatans.create',
            'kegiatans.edit',
            'laporan.view',
            'activity-log.view',
        ]);
    }

    private function createAdminUser(): void
    {
        $existing = DB::table('users')->where('email', 'admin@silapas.go.id')->first();
        if (!$existing) {
            $userId = DB::table('users')->insertGetId([
                'name' => 'Administrator',
                'email' => 'admin@silapas.go.id',
                'password' => Hash::make('password'),
                'nip' => '1234567890',
                'jabatan' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            $user = User::find($userId);
            $user->assignRole('admin');
        }
    }

    private function createPetugasUser(): void
    {
        $existing = DB::table('users')->where('email', 'petugas@silapas.go.id')->first();
        if (!$existing) {
            $userId = DB::table('users')->insertGetId([
                'name' => 'Petugas Lapas',
                'email' => 'petugas@silapas.go.id',
                'password' => Hash::make('password'),
                'nip' => '0987654321',
                'jabatan' => 'Petugas',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            $user = User::find($userId);
            $user->assignRole('petugas');
        }
    }

    private function createWargaBinaan(): void
    {
        $wargaData = [
            [
                'nama' => 'Ahmad Rizki',
                'nik' => '1234567890123456',
                'nomor_register' => 'WB/001/2024',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '1990-05-15',
                'alamat' => 'Jl. Merdeka No. 123, Jakarta',
                'status_asimilasi' => 'Aktif',
            ],
            [
                'nama' => 'Budi Santoso',
                'nik' => '1234567890123457',
                'nomor_register' => 'WB/002/2024',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '1985-08-20',
                'alamat' => 'Jl. Sudirman No. 45, Bandung',
                'status_asimilasi' => 'Aktif',
            ],
            [
                'nama' => 'Citra Dewi',
                'nik' => '1234567890123458',
                'nomor_register' => 'WB/003/2024',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '1992-03-10',
                'alamat' => 'Jl. Asia Afrika No. 78, Surabaya',
                'status_asimilasi' => 'Aktif',
            ],
            [
                'nama' => 'Dedi Kurniawan',
                'nik' => '1234567890123459',
                'nomor_register' => 'WB/004/2024',
                'jenis_kelamin' => 'Laki-laki',
                'tanggal_lahir' => '1988-11-25',
                'alamat' => 'Jl. Gatot Subroto No. 90, Jakarta',
                'status_asimilasi' => 'Aktif',
            ],
            [
                'nama' => 'Euis Fatimah',
                'nik' => '1234567890123460',
                'nomor_register' => 'WB/005/2024',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '1995-07-08',
                'alamat' => 'Jl. Dago No. 12, Bandung',
                'status_asimilasi' => 'Selesai',
            ],
        ];

        foreach ($wargaData as $data) {
            $existing = DB::table('warga_binaan')->where('nomor_register', $data['nomor_register'])->first();
            if (!$existing) {
                DB::table('warga_binaan')->insert([
                    'uuid' => \Illuminate\Support\Str::uuid()->toString(),
                    'nama' => $data['nama'],
                    'nik' => $data['nik'],
                    'nomor_register' => $data['nomor_register'],
                    'jenis_kelamin' => $data['jenis_kelamin'],
                    'tanggal_lahir' => $data['tanggal_lahir'],
                    'alamat' => $data['alamat'],
                    'status_asimilasi' => $data['status_asimilasi'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function createProgramAsimilasi(): void
    {
        $programs = [
            [
                'nama_program' => 'Pertanian Organik',
                'kategori' => 'Pertanian',
                'deskripsi' => 'Program pertanian organik untuk warga binaan',
                'penanggung_jawab' => 'Pak Hadi',
            ],
            [
                'nama_program' => 'Peternakan Ayam',
                'kategori' => 'Peternakan',
                'deskripsi' => 'Program ternak ayam untuk keterampilan',
                'penanggung_jawab' => 'Bu Siti',
            ],
            [
                'nama_program' => 'Kerajinan Anyaman',
                'kategori' => 'Kerajinan',
                'deskripsi' => 'Program anyaman ROTAN',
                'penanggung_jawab' => 'Pak Budi',
            ],
            [
                'nama_program' => 'Perikanan Lele',
                'kategori' => 'Perikanan',
                'deskripsi' => 'Program ternak ikan lele',
                'penanggung_jawab' => 'Bu Dewi',
            ],
            [
                'nama_program' => 'Kebersihan Lingkungan',
                'kategori' => 'Kebersihan',
                'deskripsi' => 'Program menjaga kebersihan lapas',
                'penanggung_jawab' => 'Pak Ahmad',
            ],
            [
                'nama_program' => 'Workshop Kewirausahaan',
                'kategori' => 'Workshop',
                'deskripsi' => 'Workshop kewirausahaan untuk warga',
                'penanggung_jawab' => 'Bu Linda',
            ],
        ];

        foreach ($programs as $program) {
            $existing = DB::table('program_asimilasi')->where('nama_program', $program['nama_program'])->first();
            if (!$existing) {
                DB::table('program_asimilasi')->insert(array_merge($program, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]));
            }
        }
    }
}
