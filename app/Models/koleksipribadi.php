<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class koleksipribadi extends Model
{
    protected $table = 'koleksipribadi';
    
    protected $fillable = [
        'user_id',
        'buku_id'
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
