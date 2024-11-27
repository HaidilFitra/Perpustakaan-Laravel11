<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\peminjaman;
use App\Models\pengembalian;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class PengembalianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengembalians = pengembalian::with(['peminjaman.user', 'peminjaman.buku'])->latest()->get();
        return view('admin.CRUD.Pengembalian.index', compact('pengembalians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $peminjamans = peminjaman::where('Status', 'Dipinjam')
            ->with(['user', 'buku'])
            ->get();

        return view('admin.CRUD.Pengembalian.create', compact('peminjamans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $peminjaman = peminjaman::findOrFail($request->peminjaman_id);
        
        $validated = Validator::make($request->all(), [
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'TanggalPengembalian' => 'required|date|after_or_equal:' . $peminjaman->TanggalPeminjaman
        ], [
            'TanggalPengembalian.after_or_equal' => 'Tanggal pengembalian tidak boleh kurang dari tanggal peminjaman'
        ]);

        if($validated->fails()){
            return redirect()->back()->withErrors($validated)->withInput();
        }

        $tanggalHarusKembali = Carbon::parse($peminjaman->TanggalPengembalian);
        $tanggalKembaliAktual = Carbon::parse($request->TanggalPengembalian);
        
        $terlambat = $tanggalKembaliAktual->gt($tanggalHarusKembali);
        $selisihHari = $terlambat ? $tanggalKembaliAktual->diffInDays($tanggalHarusKembali) : 0;
        
        $denda = $terlambat ? ($selisihHari * 1000) : 0;

        pengembalian::create([
            'peminjaman_id' => $peminjaman->id,
            'TanggalPengembalian' => $tanggalKembaliAktual,
            'Denda' => $denda,
            'Status' => $terlambat ? pengembalian::STATUS_TERLAMBAT : pengembalian::STATUS_TEPAT_WAKTU
        ]);

        $peminjaman->update(['Status' => 'Selesai']);

        $message = 'Buku berhasil dikembalikan';
        if ($terlambat) {
            $message .= sprintf(
                ' (Terlambat %d hari, Denda: Rp %s)',
                $selisihHari,
                number_format($denda, 0, ',', '.')
            );
        }

        return redirect()->route('admin.CRUD.Pengembalian.index')
            ->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pengembalian = pengembalian::with(['peminjaman.anggota', 'peminjaman.buku'])
            ->findOrFail($id);
        return view('admin.CRUD.Pengembalian.show', compact('pengembalian'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return redirect()->route('admin.CRUD.Pengembalian.index')
            ->with('error', 'Pengembalian tidak dapat diedit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return redirect()->route('admin.CRUD.Pengembalian.index')
            ->with('error', 'Pengembalian tidak dapat diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $pengembalian = pengembalian::findOrFail($id);
            
            $peminjaman = $pengembalian->peminjaman;
            $peminjaman->update(['Status' => 'Dipinjam']);
            
            $pengembalian->delete();

            return redirect()->route('admin.CRUD.Pengembalian.index')
                ->with('success', 'Data pengembalian berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('admin.CRUD.Pengembalian.index')
                ->with('error', 'Gagal menghapus data pengembalian');
        }
    }
}
