<?php

namespace App\Http\Controllers;

use App\Models\Kegiatans;
use App\Models\WargaBinaan;
use App\Models\ProgramAsimilasi;
use App\Models\DokumentasiKegiatans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\View\View;

class KegiatansController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $tanggal = $request->get('tanggal');
        
        $kegiatans = Kegiatans::with(['wargaBinaan', 'programAsimilasi', 'petugas'])
            ->when($search, function($query) use ($search) {
                $query->where('jenis_kegatan', 'like', "%{$search}%")
                    ->orWhereHas('wargaBinaan', function($wb) use ($search) {
                        $wb->where('nama', 'like', "%{$search}%");
                    });
            })
            ->when($tanggal, function($query) use ($tanggal) {
                $query->where('tanggal', $tanggal);
            })
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('kegiatans.index', [
            'kegiatans' => $kegiatans,
            'filters' => [
                'search' => $search,
                'tanggal' => $tanggal,
            ],
        ]);
    }

    public function create()
    {
        return view('kegiatans.create', [
            'wargaBinaan' => WargaBinaan::where('status_asimilasi', 'Aktif')->get(),
            'programAsimilasi' => ProgramAsimilasi::all(),
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
        
        Kegiatans::create($validated);

        return redirect()->route('kegiatans.index')
            ->with('success', 'Data kegiatan berhasil ditambahkan');
    }

    public function show(Kegiatans $kegiatans)
    {
        $kegiatans->load(['wargaBinaan', 'programAsimilasi', 'petugas', 'dokumentasiKegiatans']);
        
        return view('kegiatans.show', [
            'kegiatans' => $kegiatans,
        ]);
    }

    public function edit(Kegiatans $kegiatans)
    {
        return view('kegiatans.edit', [
            'kegiatans' => $kegiatans,
            'wargaBinaan' => WargaBinaan::where('status_asimilasi', 'Aktif')->get(),
            'programAsimilasi' => ProgramAsimilasi::all(),
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
            ->with('success', 'Data kegiatan berhasil diubah');
    }

    public function destroy(Kegiatans $kegiatans)
    {
        $kegiatans->delete();

        return redirect()->route('kegiatans.index')
            ->with('success', 'Data kegiatan berhasil dihapus');
    }

    public function dokumentasi(Request $request, Kegiatans $kegiatans)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'caption' => 'nullable|string|max:500',
        ]);

        $foto = $request->file('foto')->store('dokumentasi', 'public');

        DokumentasiKegiatans::create([
            'kegiatans_id' => $kegiatans->id,
            'foto' => $foto,
            'caption' => $request->caption,
        ]);

        return back()->with('success', 'Dokumentasi berhasil ditambahkan');
    }

    public function exportPdf(Request $request)
    {
        $tanggal = $request->get('tanggal', now()->format('Y-m-d'));
        
        $kegiatans = Kegiatans::with(['wargaBinaan', 'programAsimilasi'])
            ->where('tanggal', $tanggal)
            ->get();

        $pdf = Pdf::loadView('pdf.kegiatans', [
            'kegiatans' => $kegiatans,
            'tanggal' => $tanggal,
        ]);

        return $pdf->download('kegiatans-' . $tanggal . '.pdf');
    }
}
