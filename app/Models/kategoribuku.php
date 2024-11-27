<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class kategoribuku extends Model
{
    use HasFactory;
    protected $table = 'kategoribuku';
    protected $guarded = [];

    public function buku()
    {
        return $this->hasMany(Buku::class, 'kategori_id');
    }
}
