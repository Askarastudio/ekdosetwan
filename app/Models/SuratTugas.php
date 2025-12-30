<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuratTugas extends Model
{
    protected $fillable = [
        'peminjaman_id',
        'nomor_surat',
        'tanggal_surat',
        'file_path',
        'keterangan',
        'created_by',
    ];

    protected $casts = [
        'tanggal_surat' => 'date',
    ];

    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(Peminjaman::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
