<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SupirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $supirs = Supir::latest()->paginate(10);
        return view('admin.supir.index', compact('supirs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.supir.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_hp' => 'required|string|max:255',
            'status_ketersediaan' => 'required|in:Standby,On Duty',
            'keterangan' => 'nullable|string',
            'foto_profil' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto_profil')) {
            $validated['foto_profil'] = $request->file('foto_profil')->store('supir', 'public');
        }

        Supir::create($validated);

        return redirect()->route('admin.supir.index')
            ->with('success', 'Supir berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Supir $supir)
    {
        return view('admin.supir.show', compact('supir'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supir $supir)
    {
        return view('admin.supir.edit', compact('supir'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supir $supir)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_hp' => 'required|string|max:255',
            'status_ketersediaan' => 'required|in:Standby,On Duty',
            'keterangan' => 'nullable|string',
            'foto_profil' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto_profil')) {
            // Delete old photo
            if ($supir->foto_profil) {
                Storage::disk('public')->delete($supir->foto_profil);
            }
            $validated['foto_profil'] = $request->file('foto_profil')->store('supir', 'public');
        }

        $supir->update($validated);

        return redirect()->route('admin.supir.index')
            ->with('success', 'Supir berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supir $supir)
    {
        // Delete photo
        if ($supir->foto_profil) {
            Storage::disk('public')->delete($supir->foto_profil);
        }

        $supir->delete();

        return redirect()->route('admin.supir.index')
            ->with('success', 'Supir berhasil dihapus.');
    }
}
