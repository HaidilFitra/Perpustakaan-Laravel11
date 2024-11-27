<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ulasanbuku extends Model
{
    protected $table = 'ulasanbuku';
    protected $fillable = [
        'user_id',
        'buku_id',
        'ulasan',
        'rating'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}
