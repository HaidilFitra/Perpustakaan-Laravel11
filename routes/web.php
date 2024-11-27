<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\crud\BukuController;
use App\Http\Controllers\crud\KategoriController;
use App\Http\Controllers\CRUD\PeminjamanController;
use App\Http\Controllers\CRUD\PengembalianController;
use App\Http\Controllers\crud\PetugasController;
use App\Http\Controllers\dashboard\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeminjamController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\crud\UlasanController;
use App\Http\Controllers\crud\KoleksiController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// detail buku
Route::get('/buku/{id}', [HomeController::class, 'show'])->name('buku.show');

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'formLogin')->name('formLogin');
    Route::post('/login', 'login')->name('login');
    Route::get('/register', 'formRegister')->name('register');
    Route::post('/register', 'register')->name('register.submit');
    Route::post('/logout', 'logout')->name('logout');
});

Route::post('/check-timeout', [AuthController::class, 'checkTimeout'])->name('check.timeout');

Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // buku
    Route::prefix('buku')->name('CRUD.Buku.')->group(function () {
        Route::get('/', [BukuController::class, 'index'])->name('index');
        Route::get('/create', [BukuController::class, 'create'])->name('create');
        Route::post('/', [BukuController::class, 'store'])->name('store');
        Route::get('/{id}', [BukuController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [BukuController::class, 'edit'])->name('edit');
        Route::put('/{id}', [BukuController::class, 'update'])->name('update');
        Route::delete('/{id}', [BukuController::class, 'destroy'])->name('destroy');
    });

    // peminjaman
    Route::prefix('peminjaman')->name('CRUD.Peminjaman.')->group(function () {
        Route::get('/', [PeminjamanController::class, 'index'])->name('index');
        Route::get('/create', [PeminjamanController::class, 'create'])->name('create');
        Route::post('/store', [PeminjamanController::class, 'store'])->name('store');
        Route::get('/{id}', [PeminjamanController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [PeminjamanController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [PeminjamanController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [PeminjamanController::class, 'destroy'])->name('destroy');
    });

    // laporan
    Route::prefix('laporan')->name('CRUD.Laporan.')->group(function () {
        Route::get('/', [PeminjamanController::class, 'laporan'])->name('index');
        Route::get('/cetak-pdf', [PeminjamanController::class, 'cetak_pdf'])->name('cetak.pdf');
        Route::get('/preview-pdf', [PeminjamanController::class, 'preview_pdf'])->name('preview.pdf');
    });

    // hanya untuk admin
    Route::middleware('admin')->group(function () {
        // kategori
        Route::prefix('kategori')->name('CRUD.Kategori.')->group(function () {
            Route::get('/', [KategoriController::class, 'index'])->name('index');
            Route::get('/create', [KategoriController::class, 'create'])->name('create');
            Route::post('/', [KategoriController::class, 'store'])->name('store');
            Route::get('/{id}', [KategoriController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [KategoriController::class, 'edit'])->name('edit');
            Route::put('/{id}', [KategoriController::class, 'update'])->name('update');
            Route::delete('/{id}', [KategoriController::class, 'destroy'])->name('destroy');
        });

        // Pengembalian
        Route::prefix('pengembalian')->name('CRUD.Pengembalian.')->group(function () {
            Route::get('/', [PengembalianController::class, 'index'])->name('index');
            Route::get('/create', [PengembalianController::class, 'create'])->name('create');
            Route::post('/store', [PengembalianController::class, 'store'])->name('store');
            Route::get('/{id}', [PengembalianController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [PengembalianController::class, 'edit'])->name('edit');
            Route::put('/{id}/update', [PengembalianController::class, 'update'])->name('update');
            Route::delete('/{id}/delete', [PengembalianController::class, 'destroy'])->name('destroy');
        });

        // manajemen petugas
        Route::prefix('petugas')->name('CRUD.Petugas.')->group(function () {
            Route::get('/', [PetugasController::class, 'index'])->name('index');
            Route::get('/create', [PetugasController::class, 'create'])->name('create');
            Route::post('/store', [PetugasController::class, 'store'])->name('store');
            Route::get('/{id}', [PetugasController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [PetugasController::class, 'edit'])->name('edit');
            Route::put('/{id}/update', [PetugasController::class, 'update'])->name('update');
            Route::delete('/{id}/delete', [PetugasController::class, 'destroy'])->name('destroy');
        });
    });
});

// Route untuk petugas
Route::prefix('petugas')->name('petugas.')->middleware('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('petugas.dashboard');
    })->name('dashboard');
    
    // buku
    Route::prefix('buku')->name('CRUD.Buku.')->group(function () {
        Route::get('/', [BukuController::class, 'index'])->name('index');
        Route::get('/create', [BukuController::class, 'create'])->name('create');
        Route::post('/', [BukuController::class, 'store'])->name('store');
        Route::get('/{id}', [BukuController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [BukuController::class, 'edit'])->name('edit');
        Route::put('/{id}', [BukuController::class, 'update'])->name('update');
        Route::delete('/{id}', [BukuController::class, 'destroy'])->name('destroy');
    });

    // peminjaman
    Route::prefix('peminjaman')->name('CRUD.Peminjaman.')->group(function () {
        Route::get('/', [PeminjamanController::class, 'index'])->name('index');
        Route::get('/create', [PeminjamanController::class, 'create'])->name('create');
        Route::post('/store', [PeminjamanController::class, 'store'])->name('store');
        Route::get('/{id}', [PeminjamanController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [PeminjamanController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [PeminjamanController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [PeminjamanController::class, 'destroy'])->name('destroy');
    });

    // pengembalian
    Route::prefix('pengembalian')->name('CRUD.Pengembalian.')->group(function () {
        Route::get('/', [PengembalianController::class, 'index'])->name('index');
        Route::get('/create', [PengembalianController::class, 'create'])->name('create');
        Route::post('/store', [PengembalianController::class, 'store'])->name('store');
        Route::get('/{id}', [PengembalianController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [PengembalianController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [PengembalianController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [PengembalianController::class, 'destroy'])->name('destroy');
    });

    // laporan
    Route::prefix('laporan')->name('CRUD.Laporan.')->group(function () {
        Route::get('/', [PeminjamanController::class, 'laporan'])->name('index');
        Route::get('/cetak-pdf', [PeminjamanController::class, 'cetak_pdf'])->name('cetak.pdf');
        Route::get('/preview-pdf', [PeminjamanController::class, 'preview_pdf'])->name('preview.pdf');
    });
});

//  Route untuk peminjam
Route::prefix('peminjam')->name('peminjam.')->middleware('peminjam')->group(function () {
    Route::get('/dashboard', [PeminjamController::class, 'index'])->name('dashboard');
    Route::post('/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');
    Route::delete('/ulasan/{id}', [UlasanController::class, 'destroy'])->name('ulasan.destroy');
    Route::post('/koleksi', [KoleksiController::class, 'store'])->name('koleksi.store');
    Route::delete('/koleksi/{id}', [KoleksiController::class, 'destroy'])->name('koleksi.destroy');
    Route::get('/koleksi', [KoleksiController::class, 'index'])->name('koleksi.index');
});



