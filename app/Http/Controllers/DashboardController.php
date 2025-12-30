<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Kendaraan;
use App\Models\Supir;
use App\Models\AuditLog;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Admin Dashboard
        if ($user->hasRole('Admin')) {
            return $this->adminDashboard();
        }
        
        // P3B Dashboard
        if ($user->hasRole('P3B')) {
            return $this->p3bDashboard();
        }
        
        // Pengurus Barang Dashboard
        if ($user->hasRole('Pengurus Barang')) {
            return $this->pengurusBarangDashboard();
        }
        
        // User (Anggota Dewan) Dashboard
        return $this->userDashboard();
    }

    private function adminDashboard()
    {
        $totalKendaraan = Kendaraan::count();
        $totalSupir = Supir::count();
        $totalPeminjaman = Peminjaman::count();
        $peminjamanProses = Peminjaman::where('status', 'Proses')->count();
        $peminjamanDiverifikasi = Peminjaman::where('status', 'Diverifikasi')->count();
        $peminjamanBerlangsung = Peminjaman::where('status', 'Disetujui')
            ->where('tanggal_mulai', '<=', now())
            ->where('tanggal_selesai', '>=', now())
            ->count();

        $recentAuditLogs = AuditLog::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard.admin', compact(
            'totalKendaraan',
            'totalSupir',
            'totalPeminjaman',
            'peminjamanProses',
            'peminjamanDiverifikasi',
            'peminjamanBerlangsung',
            'recentAuditLogs'
        ));
    }

    private function p3bDashboard()
    {
        $peminjamanMenunggu = Peminjaman::where('status', 'Proses')
            ->with(['user', 'kendaraan'])
            ->latest()
            ->get();

        $peminjamanHariIni = Peminjaman::whereIn('status', ['Diverifikasi', 'Disetujui'])
            ->where('tanggal_mulai', '<=', now())
            ->where('tanggal_selesai', '>=', now())
            ->with(['user', 'kendaraan', 'supir'])
            ->get();

        return view('dashboard.p3b', compact('peminjamanMenunggu', 'peminjamanHariIni'));
    }

    private function pengurusBarangDashboard()
    {
        $peminjamanMenunggu = Peminjaman::where('status', 'Diverifikasi')
            ->with(['user', 'kendaraan', 'supir'])
            ->latest()
            ->get();

        $peminjamanDisetujui = Peminjaman::where('status', 'Disetujui')
            ->whereDoesntHave('suratTugas')
            ->with(['user', 'kendaraan', 'supir'])
            ->latest()
            ->get();

        return view('dashboard.pengurus-barang', compact('peminjamanMenunggu', 'peminjamanDisetujui'));
    }

    private function userDashboard()
    {
        $user = auth()->user();
        
        $canBorrow = $user->canBorrow();
        $nextBorrowDate = $user->nextBorrowDate();
        
        $myPeminjaman = Peminjaman::where('user_id', $user->id)
            ->with(['kendaraan', 'supir'])
            ->latest()
            ->take(10)
            ->get();

        $activePeminjaman = Peminjaman::where('user_id', $user->id)
            ->whereIn('status', ['Proses', 'Diverifikasi', 'Disetujui'])
            ->with(['kendaraan', 'supir'])
            ->get();

        return view('dashboard.user', compact('canBorrow', 'nextBorrowDate', 'myPeminjaman', 'activePeminjaman'));
    }
}
