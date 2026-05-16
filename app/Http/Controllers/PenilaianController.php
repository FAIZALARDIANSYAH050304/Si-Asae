<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\WargaBinaan;
use App\Models\ProgramAsimilasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PenilaianController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $warga_id = $request->get('warga_id');
        $program_id = $request->get('program_id');
        
        $penilaians = Penilaian::with(['wargaBinaan', 'programAsimilasi', 'petugas'])
            ->when($search, function($query) use ($search) {
                $query->whereHas('wargaBinaan', function($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                });
            })
            ->when($warga_id, function($query) use ($warga_id) {
                $query->where('warga_binaan_id', $warga_id);
            })
            ->when($program_id, function($query) use ($program_id) {
                $query->where('program_asimilasi_id', $program_id);
            })
            ->orderBy('tanggal_penilaian', 'desc')
            ->paginate(10);

        $wargaBinaans = WargaBinaan::where('status_asimilasi', 'Aktif')->get();
        $programs = ProgramAsimilasi::all();

        return view('penilaian.index', [
            'penilaians' => $penilaians,
            'wargaBinaans' => $wargaBinaans,
            'programs' => $programs,
            'filters' => [
                'search' => $search,
                'warga_id' => $warga_id,
                'program_id' => $program_id
            ]
        ]);
    }

    public function create()
    {
        $wargaBinaans = WargaBinaan::where('status_asimilasi', 'Aktif')->get();
        $programs = ProgramAsimilasi::all();
        
        return view('penilaian.create', [
            'wargaBinaans' => $wargaBinaans,
            'programs' => $programs
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'warga_binaan_id' => 'required|exists:warga_binaan,id',
            'program_asimilasi_id' => 'required|exists:program_asimilasi,id',
            'tanggal_penilaian' => 'required|date',
            'keterampilan' => 'required|integer|min:1|max:100',
            'kedisiplinan' => 'required|integer|min:1|max:100',
            'sikap' => 'required|integer|min:1|max:100',
            'catatan' => 'nullable|string',
        ]);

        $validated['petugas_id'] = Auth::id();
        
        $rataRata = ($validated['keterampilan'] + $validated['kedisiplinan'] + $validated['sikap']) / 3;
        $validated['rata_rata'] = round($rataRata, 2);
        $validated['predikat'] = $this->getPredikat($rataRata);

        Penilaian::create($validated);

        return redirect()->route('penilaian.index')
            ->with('success', 'Penilaian berhasil ditambahkan');
    }

    public function show(Penilaian $penilaian)
    {
        $penilaian->load(['wargaBinaan', 'programAsimilasi', 'petugas']);
        
        return view('penilaian.show', [
            'penilaian' => $penilaian
        ]);
    }

    public function edit(Penilaian $penilaian)
    {
        $wargaBinaans = WargaBinaan::where('status_asimilasi', 'Aktif')->get();
        $programs = ProgramAsimilasi::all();
        
        return view('penilaian.edit', [
            'penilaian' => $penilaian,
            'wargaBinaans' => $wargaBinaans,
            'programs' => $programs
        ]);
    }

    public function update(Request $request, Penilaian $penilaian)
    {
        $validated = $request->validate([
            'warga_binaan_id' => 'required|exists:warga_binaan,id',
            'program_asimilasi_id' => 'required|exists:program_asimilasi,id',
            'tanggal_penilaian' => 'required|date',
            'keterampilan' => 'required|integer|min:1|max:100',
            'kedisiplinan' => 'required|integer|min:1|max:100',
            'sikap' => 'required|integer|min:1|max:100',
            'catatan' => 'nullable|string',
        ]);

        $rataRata = ($validated['keterampilan'] + $validated['kedisiplinan'] + $validated['sikap']) / 3;
        $validated['rata_rata'] = round($rataRata, 2);
        $validated['predikat'] = $this->getPredikat($rataRata);

        $penilaian->update($validated);

        return redirect()->route('penilaian.index')
            ->with('success', 'Penilaian berhasil diperbarui');
    }

    public function destroy(Penilaian $penilaian)
    {
        $penilaian->delete();

        return redirect()->route('penilaian.index')
            ->with('success', 'Penilaian berhasil dihapus');
    }

    public function grafikPerkembangan(Request $request, $warga_id)
    {
        $penilaians = Penilaian::where('warga_binaan_id', $warga_id)
            ->orderBy('tanggal_penilaian')
            ->get(['tanggal_penilaian', 'keterampilan', 'kedisiplinan', 'sikap', 'rata_rata']);

        return response()->json($penilaians);
    }

    public function statistikNilai(Request $request)
    {
        $program_id = $request->get('program_id');
        
        $stats = Penilaian::select(
            DB::raw('AVG(rata_rata) as rata_rata'),
            DB::raw('COUNT(*) as total'),
            'predikat',
            'program_asimilasi_id'
        )
        ->when($program_id, function($query) use ($program_id) {
            $query->where('program_asimilasi_id', $program_id);
        })
        ->groupBy('predikat', 'program_asimilasi_id')
        ->get();

        return response()->json($stats);
    }

    private function getPredikat(float $rataRata): string
    {
        if ($rataRata >= 90) {
            return 'Sangat Baik';
        } elseif ($rataRata >= 75) {
            return 'Baik';
        } elseif ($rataRata >= 60) {
            return 'Cukup';
        } else {
            return 'Kurang';
        }
    }
}
