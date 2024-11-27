<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class peminjaman extends Model
{
    protected $table = 'peminjaman';
    
    protected $fillable = [
        'user_id',
        'buku_id',
        'TanggalPeminjaman',
        'TanggalPengembalian',
        'Status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function buku()
    {
        return $this->belongsTo(buku::class, 'buku_id');
    }

    public function pengembalian()
    {
        return $this->hasOne(pengembalian::class);
    }

    public function getTanggalPinjamAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['TanggalPeminjaman']);
    }

    public function getTanggalKembaliAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['TanggalPengembalian']);
    }
}
