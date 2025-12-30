<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Kendaraan;
use App\Models\Setting;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // P3B dan Pengurus Barang dapat melihat semua peminjaman
        if ($user->hasAnyRole(['P3B', 'Pengurus Barang'])) {
            $peminjamans = Peminjaman::with(['kendaraan', 'supir', 'user'])
                ->latest()
                ->paginate(10);
        } else {
            // User normal hanya melihat peminjaman mereka sendiri
            $peminjamans = Peminjaman::where('user_id', auth()->id())
                ->with(['kendaraan', 'supir'])
                ->latest()
                ->paginate(10);
        }

        return view('peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $user = auth()->user();
        
        // Check if user has active peminjaman (exclude rejected)
        $activePeminjaman = $user->peminjamans()
            ->whereIn('status', ['Proses', 'Diverifikasi', 'Disetujui'])
            ->first();
        
        if ($activePeminjaman) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda masih memiliki peminjaman aktif (Nomor: #' . str_pad($activePeminjaman->id, 5, '0', STR_PAD_LEFT) . '). Harap selesaikan peminjaman tersebut terlebih dahulu.');
        }
        
        // Check cooldown (only for completed peminjaman)
        if (!$user->canBorrow()) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda masih dalam periode cooldown. Dapat meminjam kembali pada ' . $user->nextBorrowDate()->format('d F Y'));
        }

        $kendaraans = Kendaraan::where('status_kondisi', '!=', 'Rusak')->get();
        $maxDays = Setting::get('batas_maksimal_pinjam', 3);

        return view('peminjaman.create', compact('kendaraans', 'maxDays'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        
        // Check if user has active peminjaman (exclude rejected)
        $activePeminjaman = $user->peminjamans()
            ->whereIn('status', ['Proses', 'Diverifikasi', 'Disetujui'])
            ->first();
        
        if ($activePeminjaman) {
            return back()->with('error', 'Anda masih memiliki peminjaman aktif. Harap selesaikan peminjaman tersebut terlebih dahulu.');
        }
        
        // Check cooldown (only for completed peminjaman)
        if (!$user->canBorrow()) {
            return back()->with('error', 'Anda masih dalam periode cooldown. Dapat meminjam kembali pada ' . $user->nextBorrowDate()->format('d F Y'));
        }

        $maxDays = Setting::get('batas_maksimal_pinjam', 3);

        $validated = $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'tujuan' => 'required|string|max:255',
            'kebutuhan' => 'required|string',
            'nomor_hp_pic' => 'required|string|max:255',
        ]);

        // Validate duration
        $start = Carbon::parse($validated['tanggal_mulai']);
        $end = Carbon::parse($validated['tanggal_selesai']);
        $duration = $start->diffInDays($end) + 1;

        if ($duration > $maxDays) {
            return back()->withInput()->with('error', "Durasi peminjaman tidak boleh lebih dari {$maxDays} hari.");
        }

        // Check vehicle availability
        $kendaraan = Kendaraan::find($validated['kendaraan_id']);
        if (!$kendaraan->isAvailable($validated['tanggal_mulai'], $validated['tanggal_selesai'])) {
            return back()->withInput()->with('error', 'Kendaraan tidak tersedia pada tanggal yang dipilih.');
        }

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'Proses';

        Peminjaman::create($validated);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Pengajuan peminjaman berhasil disubmit. Menunggu verifikasi dari P3B.');
    }

    public function show(Peminjaman $peminjaman)
    {
        // Check if user owns this peminjaman or is admin/p3b/pengurus
        if ($peminjaman->user_id !== auth()->id() && !auth()->user()->hasAnyRole(['Admin', 'P3B', 'Pengurus Barang'])) {
            abort(403);
        }

        $peminjaman->load(['kendaraan', 'supir', 'verifiedBy', 'approvedBy', 'suratTugas']);

        return view('peminjaman.show', compact('peminjaman'));
    }

    public function calendarData(Request $request)
    {
        $kendaraanId = $request->get('kendaraan_id');
        
        if (!$kendaraanId) {
            return response()->json([]);
        }

        $peminjamans = Peminjaman::where('kendaraan_id', $kendaraanId)
            ->whereIn('status', ['Proses', 'Diverifikasi', 'Disetujui'])
            ->with('user')
            ->get();

        $events = $peminjamans->map(function ($peminjaman) {
            return [
                'id' => $peminjaman->id,
                'title' => $peminjaman->user->name,
                'start' => $peminjaman->tanggal_mulai->format('Y-m-d'),
                'end' => $peminjaman->tanggal_selesai->addDay()->format('Y-m-d'), // FullCalendar end is exclusive
                'color' => $this->getColorByStatus($peminjaman->status),
                'extendedProps' => [
                    'user' => $peminjaman->user->name,
                    'tujuan' => $peminjaman->tujuan,
                    'kebutuhan' => $peminjaman->kebutuhan,
                    'status' => $peminjaman->status,
                ],
            ];
        });

        return response()->json($events);
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $kendaraan = Kendaraan::find($request->kendaraan_id);
        $available = $kendaraan->isAvailable($request->tanggal_mulai, $request->tanggal_selesai);

        return response()->json(['available' => $available]);
    }

    private function getColorByStatus($status)
    {
        return match($status) {
            'Proses' => '#FFA500',
            'Diverifikasi' => '#3B82F6',
            'Disetujui' => '#10B981',
            default => '#6B7280',
        };
    }

    public function getBookings($kendaraanId)
    {
        $peminjamans = Peminjaman::where('kendaraan_id', $kendaraanId)
            ->whereIn('status', ['Proses', 'Diverifikasi', 'Disetujui'])
            ->with('user')
            ->get();

        $bookings = $peminjamans->map(function ($peminjaman) {
            return [
                'id' => $peminjaman->id,
                'user' => $peminjaman->user->name,
                'start' => $peminjaman->tanggal_mulai->format('Y-m-d'),
                'end' => $peminjaman->tanggal_selesai->format('Y-m-d'),
                'status' => $peminjaman->status,
                'tujuan' => $peminjaman->tujuan,
            ];
        });

        return response()->json(['bookings' => $bookings]);
    }
}
