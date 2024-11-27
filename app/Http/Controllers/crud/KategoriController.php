<?php

namespace App\Http\Controllers\crud;

use App\Http\Controllers\Controller;
use App\Models\kategoribuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Kategori = kategoribuku::all();
        return view('admin.CRUD.Kategori.index',compact('Kategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.CRUD.Kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'NamaKategori'
        ]);

        kategoribuku::create($request->all());
        return redirect()->route('admin.CRUD.Kategori.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $findK = kategoribuku::findOrFail($id);
        return view('');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $findK = kategoribuku::findOrFail($id);
        return view('');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $findK = kategoribuku::findOrFail($id);
        $request->only(['NamaKategori']);
        $findK->update();
        return response()->json(['data berhasil di update']);
        // return view('');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $findK = kategoribuku::findOrFail($id);
        $findK->delete();
        return view('');
    }
}
