<?php

namespace App\Http\Controllers\PengurusBarang;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\SuratTugas;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratTugasController extends Controller
{
    public function index()
    {
        $peminjamanDisetujui = Peminjaman::where('status', 'Disetujui')
            ->whereDoesntHave('suratTugas')
            ->with(['user', 'kendaraan', 'supir'])
            ->latest()
            ->get();

        $suratTugasTerbaru = SuratTugas::with(['peminjaman.user', 'peminjaman.kendaraan'])
            ->latest()
            ->take(10)
            ->get();

        return view('pengurus-barang.surat-tugas.index', compact('peminjamanDisetujui', 'suratTugasTerbaru'));
    }

    public function generate(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'Disetujui') {
            return back()->with('error', 'Peminjaman belum disetujui.');
        }

        if ($peminjaman->suratTugas) {
            return back()->with('error', 'Surat Tugas sudah pernah diterbitkan.');
        }

        // Generate nomor surat
        $year = date('Y');
        $month = date('m');
        $lastSurat = SuratTugas::whereYear('tanggal_surat', $year)
            ->whereMonth('tanggal_surat', $month)
            ->latest('id')
            ->first();

        $sequence = $lastSurat ? (int)substr($lastSurat->nomor_surat, 0, 3) + 1 : 1;
        $nomorSurat = sprintf('%03d/ST-KDO/%s/%s', $sequence, $month, $year);

        // Create Surat Tugas
        $suratTugas = SuratTugas::create([
            'peminjaman_id' => $peminjaman->id,
            'nomor_surat' => $nomorSurat,
            'tanggal_surat' => now(),
            'created_by' => auth()->id(),
        ]);

        // Generate PDF
        $pdf = Pdf::loadView('pengurus-barang.surat-tugas.pdf', [
            'suratTugas' => $suratTugas->load(['peminjaman.user', 'peminjaman.kendaraan', 'peminjaman.supir']),
        ]);

        $filename = 'surat-tugas-' . $suratTugas->id . '.pdf';
        $path = 'surat-tugas/' . $filename;
        
        \Storage::disk('public')->put($path, $pdf->output());

        $suratTugas->update(['file_path' => $path]);

        return redirect()->route('pengurus-barang.surat-tugas.index')
            ->with('success', 'Surat Tugas berhasil diterbitkan.');
    }

    public function download(SuratTugas $suratTugas)
    {
        if (!$suratTugas->file_path || !\Storage::disk('public')->exists($suratTugas->file_path)) {
            // Regenerate PDF
            $pdf = Pdf::loadView('pengurus-barang.surat-tugas.pdf', [
                'suratTugas' => $suratTugas->load(['peminjaman.user', 'peminjaman.kendaraan', 'peminjaman.supir']),
            ]);

            return $pdf->download('surat-tugas-' . $suratTugas->nomor_surat . '.pdf');
        }

        return \Storage::disk('public')->download($suratTugas->file_path);
    }
}
