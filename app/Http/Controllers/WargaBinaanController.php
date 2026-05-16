<?php

namespace App\Http\Controllers;

use App\Models\WargaBinaan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class WargaBinaanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $wargaBinaans = WargaBinaan::when($search, function($query) use ($search) {
            $query->where('nama', 'like', "%{$search}%")
                ->orWhere('nik', 'like', "%{$search}%")
                ->orWhere('nomor_register', 'like', "%{$search}%");
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('warga-binaan.index', [
            'wargaBinaans' => $wargaBinaans,
            'filters' => ['search' => $search]
        ]);
    }

    public function create(): View
    {
        return view('warga-binaan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|unique:warga_binaan,nik|max:16',
            'nomor_register' => 'required|string|unique:warga_binaan,nomor_register|max:50',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $uuid = Str::uuid();
        
        // Handle foto upload
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('warga-binaan/foto', 'public');
        }

        // Generate QR Code
        $qrCodeData = $this->generateQrCode($uuid);

        $wargaBinaan = WargaBinaan::create([
            'uuid' => $uuid,
            'nama' => $validated['nama'],
            'nik' => $validated['nik'],
            'nomor_register' => $validated['nomor_register'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'alamat' => $validated['alamat'],
            'foto' => $fotoPath,
            'qr_code' => $qrCodeData,
            'status_asimilasi' => 'Aktif',
        ]);

        return redirect()->route('warga-binaan.index')
            ->with('success', 'Data warga binaan berhasil ditambahkan');
    }

    public function show(WargaBinaan $wargaBinaan)
    {
        $wargaBinaan->load(['programs', 'kegiatans', 'absensis', 'penilaians', 'pelanggarans']);
        
        return view('warga-binaan.show', [
            'wargaBinaan' => $wargaBinaan
        ]);
    }

    public function edit(WargaBinaan $wargaBinaan): View
    {
        return view('warga-binaan.edit', [
            'wargaBinaan' => $wargaBinaan
        ]);
    }

    public function update(Request $request, WargaBinaan $wargaBinaan)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|unique:warga_binaan,nik,' . $wargaBinaan->id . '|max:16',
            'nomor_register' => 'required|string|unique:warga_binaan,nomor_register,' . $wargaBinaan->id . '|max:50',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'foto' => 'nullable|image|max:2048',
            'status_asimilasi' => 'required|in:Aktif,Selesai,Pelanggaran,Tidak Aktif',
        ]);

        if ($request->hasFile('foto')) {
            // Delete old foto
            if ($wargaBinaan->foto) {
                Storage::disk('public')->delete($wargaBinaan->foto);
            }
            $fotoPath = $request->file('foto')->store('warga-binaan/foto', 'public');
            $validated['foto'] = $fotoPath;
        }

        $wargaBinaan->update($validated);

        return redirect()->route('warga-binaan.index')
            ->with('success', 'Data warga binaan berhasil diperbarui');
    }

    public function destroy(WargaBinaan $wargaBinaan)
    {
        // Delete foto
        if ($wargaBinaan->foto) {
            Storage::disk('public')->delete($wargaBinaan->foto);
        }
        
        $wargaBinaan->delete();

        return redirect()->route('warga-binaan.index')
            ->with('success', 'Data warga binaan berhasil dihapus');
    }

    public function printQr(WargaBinaan $wargaBinaan): View
    {
        return view('warga-binaan.qrcode', [
            'wargaBinaan' => $wargaBinaan
        ]);
    }

private function generateQrCode(string $uuid): string
    {
        $qrCode = new QrCode(
            data: $uuid,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::Low,
            size: 300,
            margin: 10,
            foregroundColor: new Color(0, 0, 0),
            backgroundColor: new Color(255, 255, 255)
        );

        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        return 'data:image/png;base64,' . base64_encode($result->getString());
    }
}
