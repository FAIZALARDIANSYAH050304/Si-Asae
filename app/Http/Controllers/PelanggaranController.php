<?php

namespace App\Http\Controllers;

use App\Models\Pelanggaran;
use App\Models\WargaBinaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PelanggaranController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $warga_id = $request->get('warga_id');
        $tanggal_awal = $request->get('tanggal_awal');
        $tanggal_akhir = $request->get('tanggal_akhir');
        
        $pelanggarans = Pelanggaran::with(['wargaBinaan', 'petugas'])
            ->when($search, function($query) use ($search) {
                $query->whereHas('wargaBinaan', function($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                });
            })
            ->when($warga_id, function($query) use ($warga_id) {
                $query->where('warga_binaan_id', $warga_id);
            })
            ->when($tanggal_awal, function($query) use ($tanggal_awal) {
                $query->whereDate('tanggal', '>=', $tanggal_awal);
            })
            ->when($tanggal_akhir, function($query) use ($tanggal_akhir) {
                $query->whereDate('tanggal', '<=', $tanggal_akhir);
            })
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        $wargaBinaans = WargaBinaan::all();

        return view('pelanggaran.index', [
            'pelanggarans' => $pelanggarans,
            'wargaBinaans' => $wargaBinaans,
            'filters' => [
                'search' => $search,
                'warga_id' => $warga_id,
                'tanggal_awal' => $tanggal_awal,
                'tanggal_akhir' => $tanggal_akhir
            ]
        ]);
    }

    public function create()
    {
        $wargaBinaans = WargaBinaan::all();
        
        return view('pelanggaran.create', [
            'wargaBinaans' => $wargaBinaans
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'warga_binaan_id' => 'required|exists:warga_binaan,id',
            'tanggal' => 'required|date',
            'jenis_pelanggaran' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'sanksi' => 'nullable|string|max:255',
        ]);

        $validated['petugas_id'] = Auth::id();
        
        Pelanggaran::create($validated);

        return redirect()->route('pelanggaran.index')
            ->with('success', 'Pelanggaran berhasil ditambahkan');
    }

    public function show(Pelanggaran $pelanggaran)
    {
        $pelanggaran->load(['wargaBinaan', 'petugas']);
        
        return view('pelanggaran.show', [
            'pelanggaran' => $pelanggaran
        ]);
    }

    public function edit(Pelanggaran $pelanggaran)
    {
        $wargaBinaans = WargaBinaan::all();
        
        return view('pelanggaran.edit', [
            'pelanggaran' => $pelanggaran,
            'wargaBinaans' => $wargaBinaans
        ]);
    }

    public function update(Request $request, Pelanggaran $pelanggaran)
    {
        $validated = $request->validate([
            'warga_binaan_id' => 'required|exists:warga_binaan,id',
            'tanggal' => 'required|date',
            'jenis_pelanggaran' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'sanksi' => 'nullable|string|max:255',
        ]);

        $pelanggaran->update($validated);

        return redirect()->route('pelanggaran.index')
            ->with('success', 'Pelanggaran berhasil diperbarui');
    }

    public function destroy(Pelanggaran $pelanggaran)
    {
        $pelanggaran->delete();

        return redirect()->route('pelanggaran.index')
            ->with('success', 'Pelanggaran berhasil dihapus');
    }

    public function statistik(Request $request)
    {
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));
        
        $stats = Pelanggaran::select(
            DB::raw('MONTH(tanggal) as bulan'),
            DB::raw('COUNT(*) as total'),
            'jenis_pelanggaran'
        )
        ->whereMonth('tanggal', $bulan)
        ->whereYear('tanggal', $tahun)
        ->groupBy('bulan', 'jenis_pelanggaran')
        ->get();

        $totalPelanggaran = Pelanggaran::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->count();

        return response()->json([
            'stats' => $stats,
            'total' => $totalPelanggaran
        ]);
    }
}
