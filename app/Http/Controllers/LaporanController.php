<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kegiatans;
use App\Models\Penilaian;
use App\Models\Pelanggaran;
use App\Models\WargaBinaan;
use App\Models\ProgramAsimilasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tanggal_awal = $request->get('tanggal_awal', date('Y-m-01'));
        $tanggal_akhir = $request->get('tanggal_akhir', date('Y-m-d'));
        $jenis_laporan = $request->get('jenis_laporan', 'kehadiran');

        return view('laporan.index', [
            'filters' => [
                'tanggal_awal' => $tanggal_awal,
                'tanggal_akhir' => $tanggal_akhir,
                'jenis_laporan' => $jenis_laporan
            ]
        ]);
    }

    public function kehadiran(Request $request)
    {
        $tanggal_awal = $request->get('tanggal_awal', date('Y-m-01'));
        $tanggal_akhir = $request->get('tanggal_akhir', date('Y-m-d'));

        $data = Absensi::with(['wargaBinaan', 'petugas'])
            ->whereDate('tanggal', '>=', $tanggal_awal)
            ->whereDate('tanggal', '<=', $tanggal_akhir)
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam_masuk', 'desc')
            ->get();

        $stats = [
            'hadir' => $data->where('status_kehadiran', 'Hadir')->count(),
            'izin' => $data->where('status_kehadiran', 'Izin')->count(),
            'alpha' => $data->where('status_kehadiran', 'Alpha')->count(),
            'total' => $data->count(),
        ];

        return view('laporan.kehadiran', [
            'data' => $data,
            'stats' => $stats,
            'filters' => [
                'tanggal_awal' => $tanggal_awal,
                'tanggal_akhir' => $tanggal_akhir
            ]
        ]);
    }

    public function kegiatans(Request $request)
    {
        $tanggal_awal = $request->get('tanggal_awal', date('Y-m-01'));
        $tanggal_akhir = $request->get('tanggal_akhir', date('Y-m-d'));

        $data = Kegiatans::with(['wargaBinaan', 'programAsimilasi', 'petugas'])
            ->whereDate('tanggal', '>=', $tanggal_awal)
            ->whereDate('tanggal', '<=', $tanggal_akhir)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('laporan.kegiatans', [
            'data' => $data,
            'filters' => [
                'tanggal_awal' => $tanggal_awal,
                'tanggal_akhir' => $tanggal_akhir
            ]
        ]);
    }

    public function penilaian(Request $request)
    {
        $tanggal_awal = $request->get('tanggal_awal', date('Y-m-01'));
        $tanggal_akhir = $request->get('tanggal_akhir', date('Y-m-d'));

        $data = Penilaian::with(['wargaBinaan', 'programAsimilasi', 'petugas'])
            ->whereDate('tanggal_penilaian', '>=', $tanggal_awal)
            ->whereDate('tanggal_penilaian', '<=', $tanggal_akhir)
            ->orderBy('tanggal_penilaian', 'desc')
            ->get();

        $stats = [
            'sangatBaik' => $data->where('predikat', 'Sangat Baik')->count(),
            'baik' => $data->where('predikat', 'Baik')->count(),
            'cukup' => $data->where('predikat', 'Cukup')->count(),
            'kurang' => $data->where('predikat', 'Kurang')->count(),
            'rataRata' => $data->avg('rata_rata') ?? 0,
        ];

        return view('laporan.penilaian', [
            'data' => $data,
            'stats' => $stats,
            'filters' => [
                'tanggal_awal' => $tanggal_awal,
                'tanggal_akhir' => $tanggal_akhir
            ]
        ]);
    }

    public function pelanggaran(Request $request)
    {
        $tanggal_awal = $request->get('tanggal_awal', date('Y-m-01'));
        $tanggal_akhir = $request->get('tanggal_akhir', date('Y-m-d'));

        $data = Pelanggaran::with(['wargaBinaan', 'petugas'])
            ->whereDate('tanggal', '>=', $tanggal_awal)
            ->whereDate('tanggal', '<=', $tanggal_akhir)
            ->orderBy('tanggal', 'desc')
            ->get();

        $stats = [
            'total' => $data->count(),
        ];

        return view('laporan.pelanggaran', [
            'data' => $data,
            'stats' => $stats,
            'filters' => [
                'tanggal_awal' => $tanggal_awal,
                'tanggal_akhir' => $tanggal_akhir
            ]
        ]);
    }

    public function statistikProgram(Request $request)
    {
        $program_id = $request->get('program_id');

        $query = ProgramAsimilasi::with(['wargaBinaans', 'kegiatans', 'penilaians']);

        if ($program_id) {
            $query->where('id', $program_id);
        }

        $data = $query->get()->map(function ($program) {
            return [
                'nama_program' => $program->nama_program,
                'kategori' => $program->kategori,
                'total_warga' => $program->wargaBinaans->count(),
                'total_kegiatans' => $program->kegiatans->count(),
                'rata_nilai' => $program->penilaians->avg('rata_rata') ?? 0,
            ];
        });

        return view('laporan.statistik', [
            'data' => $data,
            'programs' => ProgramAsimilasi::all()
        ]);
    }

    public function exportPdf(Request $request, $jenis)
    {
        $tanggal_awal = $request->get('tanggal_awal', date('Y-m-01'));
        $tanggal_akhir = $request->get('tanggal_akhir', date('Y-m-d'));

        $data = [];
        $title = '';

        switch ($jenis) {
            case 'kehadiran':
                $title = 'Laporan Kehadiran';
                $data = Absensi::with(['wargaBinaan', 'petugas'])
                    ->whereDate('tanggal', '>=', $tanggal_awal)
                    ->whereDate('tanggal', '<=', $tanggal_akhir)
                    ->orderBy('tanggal', 'desc')
                    ->get();
                break;
            case 'kegiatans':
                $title = 'Laporan Kegiatan';
                $data = Kegiatans::with(['wargaBinaan', 'programAsimilasi', 'petugas'])
                    ->whereDate('tanggal', '>=', $tanggal_awal)
                    ->whereDate('tanggal', '<=', $tanggal_akhir)
                    ->orderBy('tanggal', 'desc')
                    ->get();
                break;
            case 'penilaian':
                $title = 'Laporan Penilaian';
                $data = Penilaian::with(['wargaBinaan', 'programAsimilasi', 'petugas'])
                    ->whereDate('tanggal_penilaian', '>=', $tanggal_awal)
                    ->whereDate('tanggal_penilaian', '<=', $tanggal_akhir)
                    ->orderBy('tanggal_penilaian', 'desc')
                    ->get();
                break;
            case 'pelanggaran':
                $title = 'Laporan Pelanggaran';
                $data = Pelanggaran::with(['wargaBinaan', 'petugas'])
                    ->whereDate('tanggal', '>=', $tanggal_awal)
                    ->whereDate('tanggal', '<=', $tanggal_akhir)
                    ->orderBy('tanggal', 'desc')
                    ->get();
                break;
        }

        $pdf = PDF::loadView("laporan.pdf.{$jenis}", [
            'data' => $data,
            'title' => $title,
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir
        ]);

        return $pdf->download("laporan-{$jenis}.pdf");
    }
}
