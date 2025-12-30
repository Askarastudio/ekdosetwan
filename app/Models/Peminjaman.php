<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Peminjaman extends Model
{
    protected $table = 'peminjamans';

    protected $fillable = [
        'user_id',
        'kendaraan_id',
        'supir_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'tujuan',
        'kebutuhan',
        'nomor_hp_pic',
        'status',
        'verified_by',
        'verified_at',
        'approved_by',
        'approved_at',
        'catatan_verifikator',
        'catatan_pengurus_barang',
        'alasan_penolakan',
        'completed_at',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'verified_at' => 'datetime',
        'approved_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kendaraan(): BelongsTo
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function supir(): BelongsTo
    {
        return $this->belongsTo(Supir::class);
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function suratTugas(): HasOne
    {
        return $this->hasOne(SuratTugas::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($peminjaman) {
            AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'created',
                'model_type' => 'Peminjaman',
                'model_id' => $peminjaman->id,
                'description' => 'Peminjaman dibuat',
                'new_values' => $peminjaman->toArray(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        });

        static::updated(function ($peminjaman) {
            AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'updated',
                'model_type' => 'Peminjaman',
                'model_id' => $peminjaman->id,
                'description' => 'Peminjaman diperbarui',
                'old_values' => $peminjaman->getOriginal(),
                'new_values' => $peminjaman->getChanges(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        });
    }
}
