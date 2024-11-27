<?php

namespace App\Http\Controllers\crud;

use App\Http\Controllers\Controller;
use App\Models\buku;
use App\Models\kategoribuku;
use App\Models\kategoribukuRelasi;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buku = Buku::with('kategoris')->latest()->paginate(10);
        return view('admin.CRUD.Buku.index',compact('buku'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = kategoribuku::all();
        return view('admin.CRUD.Buku.create', compact('kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahunTerbit' => 'required|date',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'jumlah_halaman' => 'required|integer',
            'deskripsi' => 'required|string',
            'kategori_id' => 'required|exists:kategoribuku,id',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $imagePath = 'images/' . $imageName;
        }

        $buku = Buku::create([
            'judul' => $validated['judul'],
            'pengarang' => $validated['pengarang'],
            'penerbit' => $validated['penerbit'],
            'tahunTerbit' => $validated['tahunTerbit'],
            'image' => $imagePath,
            'jumlah_halaman' => $validated['jumlah_halaman'],
            'deskripsi' => $validated['deskripsi'],
        ]);

        kategoribukuRelasi::create([
            'buku_id' => $buku->id,
            'kategori_id' => $validated['kategori_id'],
        ]);

        return redirect()->route('admin.CRUD.Buku.index')->with('success','Buku Berhasil Di Tambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $buku = Buku::find($id);
        return view('admin.CRUD.Buku.show', compact('buku'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $buku = Buku::find($id);
        $kategori = kategoribuku::all();
        return view('admin.CRUD.Buku.edit', compact('buku', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $buku = Buku::findOrFail($id);

            $validatedData = $request->validate([
                'judul' => 'required|string|max:255',
                'pengarang' => 'required|string|max:255',
                'penerbit' => 'required|string|max:255',
                'tahunTerbit' => 'required|date',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'kategori_id' => 'required|exists:kategoribuku,id',
                'jumlah_halaman' => 'required|integer',
                'deskripsi' => 'required|string',
            ]);

            if ($request->hasFile('image')) {
                if ($buku->image && file_exists(public_path($buku->image))) {
                    unlink(public_path($buku->image));
                }

                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);
                $validatedData['image'] = 'images/' . $imageName;
            }

            $buku->update($validatedData);
            $buku->kategoris()->sync([$validatedData['kategori_id']]);

            return redirect()->route('admin.CRUD.Buku.index')->with('success','Buku Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $buku = Buku::findOrFail($id);
            
            $buku->kategoris()->detach();
            
            if ($buku->image && file_exists(public_path($buku->image))) {
                unlink(public_path($buku->image));
            }
            
            $buku->delete();
            return redirect()->route('admin.CRUD.Buku.index')->with('success', 'Buku berhasil dihapus');
    }
}
