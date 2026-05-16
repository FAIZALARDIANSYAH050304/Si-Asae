<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\WargaBinaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $tanggal = $request->get('tanggal') ?? date('Y-m-d');
        $status = $request->get('status');
        
        $absensis = Absensi::with(['wargaBinaan', 'kegiatans', 'petugas'])
            ->when($search, function($query) use ($search) {
                $query->whereHas('wargaBinaan', function($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                });
            })
            ->when($tanggal, function($query) use ($tanggal) {
                $query->whereDate('tanggal', $tanggal);
            })
            ->when($status, function($query) use ($status) {
                $query->where('status_kehadiran', $status);
            })
            ->orderBy('jam_masuk', 'desc')
            ->paginate(10);

        // Statistik
        $stats = [
            'hadir' => Absensi::whereDate('tanggal', $tanggal)->where('status_kehadiran', 'Hadir')->count(),
            'izin' => Absensi::whereDate('tanggal', $tanggal)->where('status_kehadiran', 'Izin')->count(),
            'alpha' => Absensi::whereDate('tanggal', $tanggal)->where('status_kehadiran', 'Alpha')->count(),
            'total' => Absensi::whereDate('tanggal', $tanggal)->count(),
        ];

        return view('absensi.index', [
            'absensis' => $absensis,
            'stats' => $stats,
            'filters' => [
                'search' => $search,
                'tanggal' => $tanggal,
                'status' => $status
            ]
        ]);
    }

    public function scan(): View
    {
        return view('absensi.scan');
    }

    public function processScan(Request $request)
    {
        $uuid = $request->get('uuid');
        $tanggal = $request->get('tanggal') ?? date('Y-m-d');
        
        $wargaBinaan = WargaBinaan::where('uuid', $uuid)->first();
        
        if (!$wargaBinaan) {
            return back()->with('error', 'QR Code tidak valid');
        }
        
        // Check if already scanned today
        $existingAbsensi = Absensi::where('warga_binaan_id', $wargaBinaan->id)
            ->whereDate('tanggal', $tanggal)
            ->first();
            
        if ($existingAbsensi) {
            return back()->with('error', 'Warga binaans sudah melakukan absensi hari ini pada jam ' . $existingAbsensi->jam_masuk);
        }
        
        // Create new absensi
        $absensi = Absensi::create([
            'warga_binaan_id' => $wargaBinaan->id,
            'tanggal' => $tanggal,
            'jam_masuk' => now()->format('H:i:s'),
            'status_kehadiran' => 'Hadir',
            'petugas_id' => Auth::id(),
        ]);

        return back()->with('success', 'Absensi berhasil untuk ' . $wargaBinaan->nama);
    }

    public function manual(Request $request)
    {
        $validated = $request->validate([
            'warga_binaan_id' => 'required|exists:warga_binaan,id',
            'tanggal' => 'required|date',
            'status_kehadiran' => 'required|in:Hadir,Izin,Alpha',
        ]);

        $validated['jam_masuk'] = now()->format('H:i:s');
        $validated['petugas_id'] = Auth::id();

        Absensi::create($validated);

        return back()->with('success', 'Absensi berhasil ditambahkan');
    }

    public function destroy(Absensi $absensi)
    {
        $absensi->delete();

        return back()->with('success', 'Absensi berhasil dihapus');
    }

    public function statistik(Request $request)
    {
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));
        
        $stats = Absensi::select(
            DB::raw('DATE(tanggal) as tanggal'),
            DB::raw('COUNT(*) as total'),
            DB::raw("SUM(CASE WHEN status_kehadiran = 'Hadir' THEN 1 ELSE 0 END) as hadir"),
            DB::raw("SUM(CASE WHEN status_kehadiran = 'Izin' THEN 1 ELSE 0 END) as izin"),
            DB::raw("SUM(CASE WHEN status_kehadiran = 'Alpha' THEN 1 ELSE 0 END) as alpha")
        )
        ->whereMonth('tanggal', $bulan)
        ->whereYear('tanggal', $tahun)
        ->groupBy('tanggal')
        ->orderBy('tanggal')
        ->get();

        return response()->json($stats);
    }
}
