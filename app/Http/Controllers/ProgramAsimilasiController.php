<?php

namespace App\Http\Controllers;

use App\Models\ProgramAsimilasi;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProgramAsimilasiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $kategori = $request->get('kategori');
        
        $programs = ProgramAsimilasi::with('wargaBinaans')
            ->when($search, function($query) use ($search) {
                $query->where('nama_program', 'like', "%{$search}%")
                    ->orWhere('penanggung_jawab', 'like', "%{$search}%");
            })
            ->when($kategori, function($query) use ($kategori) {
                $query->where('kategori', $kategori);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('program-asimilasi.index', [
            'programs' => $programs,
            'filters' => ['search' => $search, 'kategori' => $kategori]
        ]);
    }

    public function create(): View
    {
        return view('program-asimilasi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_program' => 'required|string|max:255',
            'kategori' => 'required|in:Pertanian,Peternakan,Kerajinan,Perikanan,Kebersihan,Workshop',
            'deskripsi' => 'nullable|string',
            'penanggung_jawab' => 'nullable|string|max:255',
        ]);

        ProgramAsimilasi::create($validated);

        return redirect()->route('program-asimilasi.index')
            ->with('success', 'Program asimilasi berhasil ditambahkan');
    }

    public function show(ProgramAsimilasi $programAsimilasi)
    {
        $programAsimilasi->load(['wargaBinaans', 'kegiatans', 'penilaians']);
        
        return view('program-asimilasi.show', [
            'program' => $programAsimilasi
        ]);
    }

    public function edit(ProgramAsimilasi $programAsimilasi): View
    {
        return view('program-asimilasi.edit', [
            'program' => $programAsimilasi
        ]);
    }

    public function update(Request $request, ProgramAsimilasi $programAsimilasi)
    {
        $validated = $request->validate([
            'nama_program' => 'required|string|max:255',
            'kategori' => 'required|in:Pertanian,Peternakan,Kerajinan,Perikanan,Kebersihan,Workshop',
            'deskripsi' => 'nullable|string',
            'penanggung_jawab' => 'nullable|string|max:255',
        ]);

        $programAsimilasi->update($validated);

        return redirect()->route('program-asimilasi.index')
            ->with('success', 'Program asimilasi berhasil diperbarui');
    }

    public function destroy(ProgramAsimilasi $programAsimilasi)
    {
        $programAsimilasi->delete();

        return redirect()->route('program-asimilasi.index')
            ->with('success', 'Program asimilasi berhasil dihapus');
    }

    public function enroll(Request $request, ProgramAsimilasi $programAsimilasi)
    {
        $validated = $request->validate([
            'warga_binaan_id' => 'required|exists:warga_binaan,id',
            'tanggal_mulai' => 'required|date',
        ]);

        $programAsimilasi->wargaBinaans()->attach($validated['warga_binaan_id'], [
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'status' => 'Aktif'
        ]);

        return back()->with('success', 'Warga binaans berhasil didaftarkan');
    }
}
