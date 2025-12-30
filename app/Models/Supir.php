<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supir extends Model
{
    protected $fillable = [
        'nama',
        'foto_profil',
        'nomor_hp',
        'status_ketersediaan',
        'keterangan',
    ];

    public function peminjamans(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function isAvailable($startDate, $endDate, $excludePeminjamanId = null)
    {
        $query = $this->peminjamans()
            ->whereIn('status', ['Proses', 'Diverifikasi', 'Disetujui'])
            ->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('tanggal_mulai', [$startDate, $endDate])
                  ->orWhereBetween('tanggal_selesai', [$startDate, $endDate])
                  ->orWhere(function ($q2) use ($startDate, $endDate) {
                      $q2->where('tanggal_mulai', '<=', $startDate)
                         ->where('tanggal_selesai', '>=', $endDate);
                  });
            });

        if ($excludePeminjamanId) {
            $query->where('id', '!=', $excludePeminjamanId);
        }

        return $query->count() === 0 && $this->status_ketersediaan === 'Standby';
    }
}
