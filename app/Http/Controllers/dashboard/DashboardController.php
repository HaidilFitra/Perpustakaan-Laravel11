<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\buku;
use App\Models\kategoribuku;
use App\Models\peminjaman;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $total_kategori = kategoribuku::count();
        $total_buku = buku::count();
        $total_peminjaman = peminjaman::count();
        $total_user = User::count();
        return view('admin.dashboard', compact('total_kategori', 'total_buku', 'total_peminjaman', 'total_user'));
    }
}
