<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pengembalian extends Model
{
    protected $table = 'pengembalian';
    
    protected $fillable = [
        'peminjaman_id',
        'TanggalPengembalian',
        'Denda',
        'Status'
    ];

    const STATUS_TEPAT_WAKTU = 'Tepat Waktu';
    const STATUS_TERLAMBAT = 'Terlambat';

    public function peminjaman()
    {
        return $this->belongsTo(peminjaman::class, 'peminjaman_id');
    }
}
