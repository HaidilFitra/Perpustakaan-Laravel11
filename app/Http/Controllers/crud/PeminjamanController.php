<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use App\Models\buku;
use App\Models\peminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use PDF;


class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $peminjaman = peminjaman::with(['user', 'buku'])->get();
        return view('admin.CRUD.Peminjaman.index', compact('peminjaman'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role', 'peminjam')->get();
        $buku = buku::all();
        return view('admin.CRUD.Peminjaman.create', compact('users', 'buku'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'user_id' => 'required|exists:user,id',
            'buku_id' => 'required|exists:buku,id',
            'TanggalPeminjaman' => 'required|date|after_or_equal:today',
            'TanggalPengembalian' => [
                'required',
                'date',
                'after_or_equal:TanggalPeminjaman',
                function ($attribute, $value, $fail) use ($request) {
                    $start = Carbon::parse($request->TanggalPeminjaman);
                    $end = Carbon::parse($value);
                    $diff = $start->diffInDays($end);

                    if ($diff > 7) {
                        $fail('Maksimal peminjaman adalah 7 hari.');
                    }
                },
            ],
        ], [
            'TanggalPengembalian.after_or_equal' => 'Tanggal pengembalian harus setelah tanggal peminjaman.',
            'TanggalPeminjaman.after_or_equal' => 'Tanggal peminjaman tidak boleh kurang dari hari ini.',
        ]);

        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        }

        $data = $request->all();
        $data['Status'] = 'Dipinjam';

        peminjaman::create($data);

        return redirect()->route('admin.CRUD.Peminjaman.index')
            ->with('success', 'Peminjaman berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $peminjaman = peminjaman::with(['user', 'buku'])->findOrFail($id);
        return view('admin.CRUD.Peminjaman.show', compact('peminjaman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $peminjaman = peminjaman::findOrFail($id);
        $users = User::where('role', 'peminjam')->get();
        $buku = buku::all();
        return view('admin.CRUD.Peminjaman.edit', compact('peminjaman', 'users', 'buku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $peminjaman = peminjaman::findOrFail($id);

        $validated = Validator::make($request->all(), [
            'user_id' => 'required|exists:user,id',
            'buku_id' => 'required|exists:buku,id',
            'TanggalPeminjaman' => 'required|date',
            'TanggalPengembalian' => 'required|date|after:TanggalPeminjaman',
        ]);

        if ($validated->fails()) {
            return redirect()->back()->withErrors($validated)->withInput();
        }

        $peminjaman->update($request->all());

        return redirect()->route('admin.CRUD.Peminjaman.index')
            ->with('success', 'Peminjaman berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $peminjaman = peminjaman::findOrFail($id);
        $peminjaman->delete();

        return redirect()->route('admin.CRUD.Peminjaman.index')
            ->with('success', 'Peminjaman berhasil dihapus');
    }

    public function laporan(Request $request)
    {
        $period = $request->period ?? 'daily';
        $today = Carbon::now();

        $query = Peminjaman::query()->with(['user', 'buku', 'pengembalian']);

        switch($period) {
            case 'daily':
                $query->whereDate('TanggalPeminjaman', $today);
                break;
            case 'weekly':
                $startWeek = $today->startOfWeek();
                $endWeek = $today->copy()->endOfWeek();
                $query->whereBetween('TanggalPeminjaman', [$startWeek, $endWeek]);
                break;
            case 'monthly':
                $query->whereMonth('TanggalPeminjaman', $today->month)
                     ->whereYear('TanggalPeminjaman', $today->year);
                break;
        }

        $peminjaman = $query->get();
        
        return view('admin.laporan.laporan', compact('peminjaman'));
    }

    public function cetak_pdf(Request $request)
    {
        $period = $request->period ?? 'daily';
        $today = Carbon::now();

        $query = Peminjaman::query()->with(['user', 'buku', 'pengembalian']);

        switch($period) {
            case 'daily':
                $query->whereDate('TanggalPeminjaman', $today);
                break;
            case 'weekly':
                $startWeek = $today->startOfWeek();
                $endWeek = $today->copy()->endOfWeek();
                $query->whereBetween('TanggalPeminjaman', [$startWeek, $endWeek]);
                break;
            case 'monthly':
                $query->whereMonth('TanggalPeminjaman', $today->month)
                     ->whereYear('TanggalPeminjaman', $today->year);
                break;
        }

        $peminjaman = $query->get();
        
        $pdf = PDF::loadView('admin.laporan.peminjaman_pdf', [
            'peminjaman' => $peminjaman,
            'date' => $today,
            'period' => $period
        ]);
        
        return $pdf->stream('laporan-peminjaman.pdf');
    }

}
