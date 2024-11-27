<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class buku extends Model
{
    use HasFactory;
    protected $table = 'buku';
    protected $fillable = [
        'judul',
        'pengarang',
        'penerbit',
        'tahunTerbit',
        'image',
        'jumlah_halaman',
        'deskripsi',
    ];

    public function kategoris()
    {
        return $this->belongsToMany(kategoribuku::class, 'kategoribuku_relasi', 'buku_id', 'kategori_id');
    }

    public function ulasanbuku()
    {
        return $this->hasMany(ulasanbuku::class, 'buku_id');
    }

}
