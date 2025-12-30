<?php

namespace App\Http\Controllers\PengurusBarang;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index()
    {
        $peminjamanMenunggu = Peminjaman::where('status', 'Diverifikasi')
            ->with(['user', 'kendaraan', 'supir'])
            ->latest()
            ->get();

        return view('pengurus-barang.approval.index', compact('peminjamanMenunggu'));
    }

    public function approve(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'Diverifikasi') {
            return back()->with('error', 'Peminjaman tidak dapat disetujui.');
        }

        $validated = $request->validate([
            'catatan_pengurus_barang' => 'nullable|string',
        ]);

        $peminjaman->update([
            'catatan_pengurus_barang' => $validated['catatan_pengurus_barang'],
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'status' => 'Disetujui',
        ]);

        return redirect()->route('pengurus-barang.approval.index')
            ->with('success', 'Peminjaman berhasil disetujui. Silakan terbitkan Surat Tugas.');
    }

    public function reject(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'Diverifikasi') {
            return back()->with('error', 'Peminjaman sudah diproses sebelumnya.');
        }

        $validated = $request->validate([
            'alasan_penolakan' => 'required|string',
        ]);

        $peminjaman->update([
            'alasan_penolakan' => $validated['alasan_penolakan'],
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'status' => 'Ditolak',
        ]);

        return redirect()->route('pengurus-barang.approval.index')
            ->with('success', 'Peminjaman telah ditolak.');
    }
}
