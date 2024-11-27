<?php

namespace App\Http\Controllers;

use App\Models\buku;
use App\Models\kategoribuku;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $buku = buku::with('kategoris')->get();
        $services = [
            [
                'title' => 'Akses Digital Tanpa Batas',
                'description' => 'Jelajahi ribuan judul buku dari berbagai genre, kapan saja dan di mana saja.'
            ],
            [
                'title' => 'Rekomendasi Pintar',
                'description' => 'Temukan buku-buku yang sesuai minat Anda melalui sistem rekomendasi cerdas kami.'
            ],
            [
                'title' => 'Komunitas Literasi',
                'description' => 'Bergabunglah dalam komunitas pembaca aktif.'
            ],
        ];
        return view('home', compact('buku', 'services'));
    }

    public function show($id)
    {
        $buku = Buku::with('kategoris')->findOrFail($id);
        return view('buku.show', compact('buku'));
    }
}
