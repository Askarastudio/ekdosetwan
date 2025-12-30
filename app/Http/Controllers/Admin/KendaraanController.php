<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KendaraanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kendaraans = Kendaraan::latest()->paginate(10);
        return view('admin.kendaraan.index', compact('kendaraans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kendaraan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'merk' => 'required|string|max:255',
            'tipe' => 'required|string|max:255',
            'nomor_polisi' => 'required|string|max:255|unique:kendaraans',
            'status_kondisi' => 'required|in:Sangat Baik,Perbaikan,Rusak',
            'keterangan' => 'nullable|string',
            'galeri_foto.*' => 'nullable|image|max:2048',
        ]);

        $photos = [];
        if ($request->hasFile('galeri_foto')) {
            foreach ($request->file('galeri_foto') as $photo) {
                $path = $photo->store('kendaraan', 'public');
                $photos[] = $path;
            }
        }

        $validated['galeri_foto'] = $photos;

        Kendaraan::create($validated);

        return redirect()->route('admin.kendaraan.index')
            ->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kendaraan $kendaraan)
    {
        return view('admin.kendaraan.show', compact('kendaraan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kendaraan $kendaraan)
    {
        return view('admin.kendaraan.edit', compact('kendaraan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kendaraan $kendaraan)
    {
        $validated = $request->validate([
            'merk' => 'required|string|max:255',
            'tipe' => 'required|string|max:255',
            'nomor_polisi' => 'required|string|max:255|unique:kendaraans,nomor_polisi,' . $kendaraan->id,
            'status_kondisi' => 'required|in:Sangat Baik,Perbaikan,Rusak',
            'keterangan' => 'nullable|string',
            'galeri_foto.*' => 'nullable|image|max:2048',
        ]);

        $photos = $kendaraan->galeri_foto ?? [];
        
        if ($request->hasFile('galeri_foto')) {
            foreach ($request->file('galeri_foto') as $photo) {
                $path = $photo->store('kendaraan', 'public');
                $photos[] = $path;
            }
        }

        $validated['galeri_foto'] = $photos;

        $kendaraan->update($validated);

        return redirect()->route('admin.kendaraan.index')
            ->with('success', 'Kendaraan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kendaraan $kendaraan)
    {
        // Delete photos
        if ($kendaraan->galeri_foto) {
            foreach ($kendaraan->galeri_foto as $photo) {
                Storage::disk('public')->delete($photo);
            }
        }

        $kendaraan->delete();

        return redirect()->route('admin.kendaraan.index')
            ->with('success', 'Kendaraan berhasil dihapus.');
    }
}
