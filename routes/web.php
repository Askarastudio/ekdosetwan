<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\KendaraanController;
use App\Http\Controllers\Admin\SupirController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\User\PeminjamanController;
use App\Http\Controllers\P3B\VerifikasiController;
use App\Http\Controllers\PengurusBarang\ApprovalController;
use App\Http\Controllers\PengurusBarang\SuratTugasController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Main Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Routes
    Route::middleware(['role:Admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('kendaraan', KendaraanController::class);
        Route::resource('supir', SupirController::class);
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
        Route::get('audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
    });

    // P3B Routes
    Route::middleware(['role:P3B|Admin'])->prefix('p3b')->name('p3b.')->group(function () {
        Route::get('verifikasi', [VerifikasiController::class, 'index'])->name('verifikasi.index');
        Route::post('verifikasi/{peminjaman}', [VerifikasiController::class, 'verify'])->name('verifikasi.verify');
        Route::post('tolak/{peminjaman}', [VerifikasiController::class, 'reject'])->name('verifikasi.reject');
    });

    // Pengurus Barang Routes
    Route::middleware(['role:Pengurus Barang|Admin'])->prefix('pengurus-barang')->name('pengurus-barang.')->group(function () {
        Route::get('approval', [ApprovalController::class, 'index'])->name('approval.index');
        Route::post('approve/{peminjaman}', [ApprovalController::class, 'approve'])->name('approval.approve');
        Route::post('reject/{peminjaman}', [ApprovalController::class, 'reject'])->name('approval.reject');
        Route::get('surat-tugas', [SuratTugasController::class, 'index'])->name('surat-tugas.index');
        Route::get('surat-tugas/generate/{peminjaman}', [SuratTugasController::class, 'generate'])->name('surat-tugas.generate');
        Route::get('surat-tugas/download/{suratTugas}', [SuratTugasController::class, 'download'])->name('surat-tugas.download');
    });

    // User Routes
    Route::prefix('peminjaman')->name('peminjaman.')->group(function () {
        Route::get('/', [PeminjamanController::class, 'index'])->name('index');
        Route::get('/create', [PeminjamanController::class, 'create'])->name('create');
        Route::post('/', [PeminjamanController::class, 'store'])->name('store');
        Route::get('/{peminjaman}', [PeminjamanController::class, 'show'])->name('show');
        Route::get('/calendar/data', [PeminjamanController::class, 'calendarData'])->name('calendar.data');
        Route::get('/check-availability', [PeminjamanController::class, 'checkAvailability'])->name('check-availability');
    });
});

require __DIR__.'/auth.php';
