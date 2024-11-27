<?php

namespace App\Http\Controllers\crud;

use App\Http\Controllers\Controller;
use App\Models\ulasanbuku;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        // Validasi user harus login
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Validasi input
        try {
            $request->validate([
                'buku_id' => 'required|exists:buku,id',
                'rating' => 'required|integer|min:1|max:5',
                'ulasan' => 'required|string|min:5'
            ], [
                'rating.required' => 'Rating harus diisi',
                'rating.integer' => 'Rating harus berupa angka',
                'rating.min' => 'Rating minimal 1',
                'rating.max' => 'Rating maksimal 5',
                'ulasan.required' => 'Ulasan harus diisi',
                'ulasan.min' => 'Ulasan minimal 5 karakter'
            ]);

            $existingReview = ulasanbuku::where('user_id', auth()->id())
                                      ->where('buku_id', $request->buku_id)
                                      ->first();

            if ($existingReview) {
                return redirect()->back()
                    ->with('error', 'Anda sudah memberikan ulasan untuk buku ini')
                    ->withInput();
            }

            ulasanbuku::create([
                'user_id' => auth()->id(),
                'buku_id' => $request->buku_id,
                'rating' => $request->rating,
                'ulasan' => $request->ulasan
            ]);

            return redirect()->back()->with('success', 'Ulasan berhasil ditambahkan');

        } catch (\Exception $e) {
            \Log::error('Error saat menambahkan ulasan: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menambahkan ulasan');
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
            $ulasan = ulasanbuku::findOrFail($id);
            
            if ($ulasan->user_id !== auth()->id()) {
                return redirect()->back()
                    ->with('error', 'Anda tidak memiliki izin untuk menghapus ulasan ini');
            }

            $ulasan->delete();
            return redirect()->back()->with('success', 'Ulasan berhasil dihapus');

        } catch (\Exception $e) {
            \Log::error('Error saat menghapus ulasan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus ulasan');
        }
    }
}
