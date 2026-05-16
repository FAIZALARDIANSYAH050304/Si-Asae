<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WargaBinaanController;
use App\Http\Controllers\ProgramAsimilasiController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\DocumentationController;
use Illuminate\Support\Facades\Route;
use App\Models\WargaBinaan;
use Illuminate\Support\Str;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Warga Binaan Routes
    Route::resource('warga-binaan', WargaBinaanController::class);
    Route::get('/warga-binaan/{wargaBinaan}/qr', [WargaBinaanController::class, 'printQr'])->name('warga-binaan.qr');
    
    // Program Asimilasi Routes
    Route::resource('program-asimilasi', ProgramAsimilasiController::class);
    Route::post('/program-asimilasi/{programAsimilasi}/enroll', [ProgramAsimilasiController::class, 'enroll'])->name('program-asimilasi.enroll');

    // Absensi Routes
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::get('/absensi/scan', [AbsensiController::class, 'scan'])->name('absensi.scan');
    Route::post('/absensi/process-scan', [AbsensiController::class, 'processScan'])->name('absensi.process-scan');
    Route::post('/absensi/manual', [AbsensiController::class, 'manual'])->name('absensi.manual');
    Route::get('/absensi/statistik', [AbsensiController::class, 'statistik'])->name('absensi.statistik');
    Route::delete('/absensi/{absensi}', [AbsensiController::class, 'destroy'])->name('absensi.destroy');

    // Penilaian Routes
    Route::resource('penilaian', PenilaianController::class);
    Route::get('/penilaian/{warga_id}/grafik', [PenilaianController::class, 'grafikPerkembangan'])->name('penilaian.grafik');
    Route::get('/penilaian/statistik', [PenilaianController::class, 'statistikNilai'])->name('penilaian.statistik');

    // Pelanggaran Routes
    Route::resource('pelanggaran', PelanggaranController::class);
    Route::get('/pelanggaran/statistik', [PelanggaranController::class, 'statistik'])->name('pelanggaran.statistik');

// Kegiatan Routes
    Route::resource('kegiatans', \App\Http\Controllers\KegiatansController::class)->parameters(['kegiatans' => 'kegiatans']);
    Route::post('/kegiatans/{kegiatans}/dokumentasi', [\App\Http\Controllers\KegiatansController::class, 'dokumentasi'])->name('kegiatans.dokumentasi');
    Route::get('/kegiatans/export/pdf', [\App\Http\Controllers\KegiatansController::class, 'exportPdf'])->name('kegiatans.export-pdf');

    // Laporan Routes
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/kehadiran', [LaporanController::class, 'kehadiran'])->name('laporan.kehadiran');
    Route::get('/laporan/kegiatans', [LaporanController::class, 'kegiatans'])->name('laporan.kegiatans');
    Route::get('/laporan/penilaian', [LaporanController::class, 'penilaian'])->name('laporan.penilaian');
    Route::get('/laporan/pelanggaran', [LaporanController::class, 'pelanggaran'])->name('laporan.pelanggaran');
    Route::get('/laporan/statistik-program', [LaporanController::class, 'statistikProgram'])->name('laporan.statistik-program');
    Route::get('/laporan/export/{jenis}', [LaporanController::class, 'exportPdf'])->name('laporan.export');

    // User Management Routes
    Route::resource('users', UserController::class);
    Route::get('/users/roles', [UserController::class, 'roles'])->name('users.roles');
    Route::get('/users/roles/create', [UserController::class, 'createRole'])->name('users.roles.create');
    Route::post('/users/roles', [UserController::class, 'storeRole'])->name('users.roles.store');
    Route::get('/users/roles/{role}/edit', [UserController::class, 'editRole'])->name('users.roles.edit');
    Route::put('/users/roles/{role}', [UserController::class, 'updateRole'])->name('users.roles.update');
    Route::delete('/users/roles/{role}', [UserController::class, 'destroyRole'])->name('users.roles.destroy');
    Route::get('/users/permissions', [UserController::class, 'permissions'])->name('users.permissions');
    Route::get('/users/permissions/create', [UserController::class, 'createPermission'])->name('users.permissions.create');
    Route::post('/users/permissions', [UserController::class, 'storePermission'])->name('users.permissions.store');
    Route::delete('/users/permissions/{permission}', [UserController::class, 'destroyPermission'])->name('users.permissions.destroy');

    // Activity Log Routes
    Route::get('/activity-log', [ActivityLogController::class, 'index'])->name('activity-log.index');

    // API Routes for QR Scanner
    Route::post('/api/scan-qr', [AbsensiController::class, 'processScan'])->name('api.scan-qr');
});

require __DIR__.'/auth.php';
