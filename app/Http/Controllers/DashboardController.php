<?php

namespace App\Http\Controllers;

use App\Models\WargaBinaan;
use App\Models\ProgramAsimilasi;
use App\Models\Absensi;
use App\Models\Kegiatans;
use App\Models\Penilaian;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Jumlah warga binaan
        $totalWarga = WargaBinaan::count();
        $wargaAktif = WargaBinaan::where('status_asimilasi', 'Aktif')->count();
        $wargaSelesai = WargaBinaan::where('status_asimilasi', 'Selesai')->count();
        $wargaPelanggaran = WargaBinaan::where('status_asimilasi', 'Pelanggaran')->count();
        
        // Jumlah program
        $totalProgram = ProgramAsimilasi::count();
        
        // Statistik absensi hari ini
        $today = date('Y-m-d');
        $absensiHadir = Absensi::whereDate('tanggal', $today)->where('status_kehadiran', 'Hadir')->count();
        $absensiIzin = Absensi::whereDate('tanggal', $today)->where('status_kehadiran', 'Izin')->count();
        $absensiAlpha = Absensi::whereDate('tanggal', $today)->where('status_kehadiran', 'Alpha')->count();
        
        // Activities terbaru
        $kegiatansTerbaru = Kegiatans::with(['wargaBinaan', 'programAsimilasi'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Warga binaan paling aktif
        $wargaPalingAktif = WargaBinaan::withCount('kegiatans')
            ->orderBy('kegiatans_count', 'desc')
            ->limit(5)
            ->get();
        
        // Jumlah pelanggaran bulan ini
        $bulanIni = date('m');
        $tahunIni = date('Y');
        $totalPelanggaran = Pelanggaran::whereMonth('tanggal', $bulanIni)
            ->whereYear('tanggal', $tahunIni)
            ->count();
        
        // Data untuk chart absensi (7 hari terakhir)
        $chartAbsensi = $this->getChartAbsensi();
        
        // Data untuk chart penilaian
        $chartPenilaian = $this->getChartPenilaian();
        
        return view('dashboard', [
            'stats' => [
                'totalWarga' => $totalWarga,
                'wargaAktif' => $wargaAktif,
                'wargaSelesai' => $wargaSelesai,
                'wargaPelanggaran' => $wargaPelanggaran,
                'totalProgram' => $totalProgram,
                'absensiHadir' => $absensiHadir,
                'absensiIzin' => $absensiIzin,
                'absensiAlpha' => $absensiAlpha,
                'totalPelanggaran' => $totalPelanggaran,
            ],
            'kegiatansTerbaru' => $kegiatansTerbaru,
            'wargaPalingAktif' => $wargaPalingAktif,
            'chartAbsensi' => $chartAbsensi,
            'chartPenilaian' => $chartPenilaian,
            'user' => $user,
        ]);
    }

    private function getChartAbsensi()
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = date('Y-m-d', strtotime("-{$i} days"));
            $hadir = Absensi::whereDate('tanggal', $tanggal)->where('status_kehadiran', 'Hadir')->count();
            $izin = Absensi::whereDate('tanggal', $tanggal)->where('status_kehadiran', 'Izin')->count();
            $alpha = Absensi::whereDate('tanggal', $tanggal)->where('status_kehadiran', 'Alpha')->count();
            
            $data[] = [
                'tanggal' => $tanggal,
                'hadir' => $hadir,
                'izin' => $izin,
                'alpha' => $alpha,
            ];
        }
        
        return $data;
    }

    private function getChartPenilaian()
    {
        $stats = Penilaian::select(
            DB::raw('predikat'),
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('predikat')
        ->get()
        ->keyBy('predikat')
        ->map(fn($item) => $item->total);
        
        return [
            'sangatBaik' => $stats['Sangat Baik'] ?? 0,
            'baik' => $stats['Baik'] ?? 0,
            'cukup' => $stats['Cukup'] ?? 0,
            'kurang' => $stats['Kurang'] ?? 0,
        ];
    }

    public function getStats(Request $request)
    {
        $type = $request->get('type', 'daily');
        
        if ($type === 'weekly') {
            $startDate = date('Y-m-d', strtotime('-7 days'));
        } elseif ($type === 'monthly') {
            $startDate = date('Y-m-d', strtotime('-30 days'));
        } else {
            $startDate = date('Y-m-d');
        }
        
        $absensi = Absensi::whereDate('tanggal', '>=', $startDate)
            ->select(
                DB::raw('DATE(tanggal) as tanggal'),
                DB::raw("SUM(CASE WHEN status_kehadiran = 'Hadir' THEN 1 ELSE 0 END) as hadir"),
                DB::raw("SUM(CASE WHEN status_kehadiran = 'Izin' THEN 1 ELSE 0 END) as izin"),
                DB::raw("SUM(CASE WHEN status_kehadiran = 'Alpha' THEN 1 ELSE 0 END) as alpha")
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();
            
        return response()->json($absensi);
    }
}
