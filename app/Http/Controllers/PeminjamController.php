<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Models\Buku;

class PeminjamController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with('buku')
            ->where('user_id', auth()->id())
            ->orderBy('TanggalPeminjaman')
            ->get();

        return view('peminjam.index', compact('peminjaman'));
    }
}
