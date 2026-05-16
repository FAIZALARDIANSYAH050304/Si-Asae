<?php

namespace App\Http\Controllers;

use App\Models\Kegiatans;
use App\Models\WargaBinaan;
use App\Models\ProgramAsimilasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KegiatanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $tanggal = $request->get('tanggal');
        $warga_id = $request->get('warga_id');
        $program_id = $request->get('program_id');
        
        $kegiatans = Kegiatans::with(['wargaBinaan', 'programAsimilasi', 'petugas'])
            ->when($search, function($query) use ($search) {
                $query->whereHas('wargaBinaan', function($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                });
            })
            ->when($tanggal, function($query) use ($tanggal) {
                $query->whereDate('tanggal', $tanggal);
            })
            ->when($warga_id, function($query) use ($warga_id) {
                $query->where('warga_binaan_id', $warga_id);
            })
            ->when($program_id, function($query) use ($program_id) {
                $query->where('program_asimilasi_id', $program_id);
            })
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        $wargaBinaans = WargaBinaan::where('status_asimilasi', 'Aktif')->get();
        $programs = ProgramAsimilasi::all();

        return inertia('Kegiatans/Index', [
            'kegiatans' => $kegiatans,
            'wargaBinaans' => $wargaBinaans,
            'programs' => $programs,
            'filters' => [
                'search' => $search,
                'tanggal' => $tanggal,
                'warga_id' => $warga_id,
                'program_id' => $program_id
            ]
        ]);
    }

    public function create()
    {
        $wargaBinaans = WargaBinaan::where('status_asimilasi', 'Aktif')->get();
        $programs = ProgramAsimilasi::all();
        
        return inertia('Kegiatans/Create', [
            'wargaBinaans' => $wargaBinaans,
            'programs' => $programs
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'warga_binaan_id' => 'required|exists:warga_binaan,id',
            'program_asimilasi_id' => 'required|exists:program_asimilasi,id',
            'tanggal' => 'required|date',
            'jenis_kegatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $validated['petugas_id'] = auth()->id();
        
        $kegiatans = Kegiatans::create($validated);

        return redirect()->route('kegiatans.index')
            ->with('success', 'Data kegiatan berhasil ditambahkan');
    }

    public function show(Kegiatans $kegiatans)
    {
        $kegiatans->load(['wargaBinaan', 'programAsimilasi', 'petugas', 'dokumentasiKegiatans']);
        
        return inertia('Kegiatans/Show', [
            'kegiatans' => $kegiatans
        ]);
    }

    public function edit(Kegiatans $kegiatans)
    {
        $wargaBinaans = WargaBinaan::where('status_asimilasi', 'Aktif')->get();
        $programs = ProgramAsimilasi::all();
        
        return inertia('Kegiatans/Edit', [
            'kegiatans' => $kegiatans,
            'wargaBinaans' => $wargaBinaans,
            'programs' => $programs
        ]);
    }

    public function update(Request $request, Kegiatans $kegiatans)
    {
        $validated = $request->validate([
            'warga_binaan_id' => 'required|exists:warga_binaan,id',
            'program_asimilasi_id' => 'required|exists:program_asimilasi,id',
            'tanggal' => 'required|date',
            'jenis_kegatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $kegiatans->update($validated);

        return redirect()->route('kegiatans.index')
            ->with('success', 'Data kegiatan berhasil diperbarui');
    }

    public function destroy(Kegiatans $kegiatans)
    {
        $kegiatans->delete();

        return redirect()->route('kegiatans.index')
            ->with('success', 'Data kegiatan berhasil dihapus');
    }

    public function dokumentasi(Request $request, Kegiatans $kegiatans)
    {
        $validated = $request->validate([
            'foto' => 'required|image|max:2048',
            'caption' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('kegiatans/dokumentasi', 'public');
        }

        $kegiatans->dokumentasiKegiatans()->create($validated);

        return back()->with('success', 'Dokumentasi berhasil ditambahkan');
    }

    public function exportPdf(Request $request)
    {
        $tanggal = $request->get('tanggal');
        $warga_id = $request->get('warga_id');
        
        $kegiatans = Kegiatans::with(['wargaBinaan', 'programAsimilasi', 'petugas'])
            ->when($tanggal, function($query) use ($tanggal) {
                $query->whereDate('tanggal', $tanggal);
            })
            ->when($warga_id, function($query) use ($warga_id) {
                $query->where('warga_binaan_id', $warga_id);
            })
            ->orderBy('tanggal', 'desc')
            ->get();

        $pdf = \PDF::loadView('kegiatans.pdf', [
            'kegiatans' => $kegiatans,
            'tanggal' => $tanggal,
            'warga' => $warga_id ? WargaBinaan::find($warga_id)->nama : 'Semua Warga'
        ]);

        return $pdf->download('laporan-kegiatans.pdf');
    }
}
