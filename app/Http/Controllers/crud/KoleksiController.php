<?php

namespace App\Http\Controllers\crud;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\koleksipribadi;

class KoleksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $koleksi = koleksipribadi::with('buku')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('peminjam.koleksi', compact('koleksi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validasi user harus login
            if (!auth()->check()) {
                return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
            }

            // Cek apakah buku sudah ada di koleksi
            $existingKoleksi = koleksipribadi::where('user_id', auth()->id())
                                            ->where('buku_id', $request->buku_id)
                                            ->first();

            if ($existingKoleksi) {
                return redirect()->back()->with('error', 'Buku sudah ada dalam koleksi Anda');
            }

            // Tambah ke koleksi
            koleksipribadi::create([
                'user_id' => auth()->id(),
                'buku_id' => $request->buku_id
            ]);

            return redirect()->back()->with('success', 'Buku berhasil ditambahkan ke koleksi');

        } catch (\Exception $e) {
            \Log::error('Error saat menambah koleksi: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambah koleksi');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $koleksi = koleksipribadi::findOrFail($id);
            
            // Cek apakah koleksi milik user yang sedang login
            if ($koleksi->user_id !== auth()->id()) {
                return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus koleksi ini');
            }

            $koleksi->delete();
            return redirect()->back()->with('success', 'Buku berhasil dihapus dari koleksi');

        } catch (\Exception $e) {
            \Log::error('Error saat menghapus koleksi: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus koleksi');
        }
    }
}
