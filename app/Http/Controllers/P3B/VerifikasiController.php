<?php

namespace App\Http\Controllers\P3B;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Kendaraan;
use App\Models\Supir;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function index()
    {
        $peminjamanMenunggu = Peminjaman::where('status', 'Proses')
            ->with(['user', 'kendaraan'])
            ->latest()
            ->get();

        $kendaraans = Kendaraan::where('status_kondisi', '!=', 'Rusak')->get();
        $supirs = Supir::where('status_ketersediaan', 'Standby')->get();

        return view('p3b.verifikasi.index', compact('peminjamanMenunggu', 'kendaraans', 'supirs'));
    }

    public function verify(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'Proses') {
            return back()->with('error', 'Peminjaman sudah diproses sebelumnya.');
        }

        $validated = $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'supir_id' => 'required|exists:supirs,id',
            'catatan_verifikator' => 'nullable|string',
        ]);

        // Check vehicle availability
        $kendaraan = Kendaraan::find($validated['kendaraan_id']);
        if (!$kendaraan->isAvailable($peminjaman->tanggal_mulai, $peminjaman->tanggal_selesai, $peminjaman->id)) {
            return back()->with('error', 'Kendaraan yang dipilih tidak tersedia pada tanggal tersebut.');
        }

        // Check driver availability
        $supir = Supir::find($validated['supir_id']);
        if (!$supir->isAvailable($peminjaman->tanggal_mulai, $peminjaman->tanggal_selesai, $peminjaman->id)) {
            return back()->with('error', 'Supir yang dipilih tidak tersedia pada tanggal tersebut.');
        }

        $peminjaman->update([
            'kendaraan_id' => $validated['kendaraan_id'],
            'supir_id' => $validated['supir_id'],
            'catatan_verifikator' => $validated['catatan_verifikator'],
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'status' => 'Diverifikasi',
        ]);

        return redirect()->route('p3b.verifikasi.index')
            ->with('success', 'Peminjaman berhasil diverifikasi dan kendaraan/supir telah ditugaskan.');
    }

    public function reject(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'Proses') {
            return back()->with('error', 'Peminjaman sudah diproses sebelumnya.');
        }

        $validated = $request->validate([
            'alasan_penolakan' => 'required|string',
        ]);

        $peminjaman->update([
            'alasan_penolakan' => $validated['alasan_penolakan'],
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'status' => 'Ditolak',
        ]);

        return redirect()->route('p3b.verifikasi.index')
            ->with('success', 'Peminjaman telah ditolak.');
    }
}
