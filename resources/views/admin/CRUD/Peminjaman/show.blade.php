@extends('layouts.admin')

@section('title', 'Detail Peminjaman')
@section('breadcrumb', 'Detail Peminjaman')
@section('page-title', 'Detail Data Peminjaman')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h6>Detail Peminjaman</h6>
                    <a href="{{ route('admin.CRUD.Peminjaman.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="mb-4">Data Peminjam</h6>
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <p class="form-control">{{ $peminjaman->user->nama_lengkap }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <p class="form-control">{{ $peminjaman->user->email }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <p class="form-control">{{ $peminjaman->user->alamat }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="mb-4">Data Peminjaman</h6>
                        <div class="mb-3">
                            <label class="form-label">Judul Buku</label>
                            <p class="form-control">{{ $peminjaman->buku->judul }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Peminjaman</label>
                            <p class="form-control">{{ $peminjaman->TanggalPeminjaman }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <p>
                                <span class="badge {{ $peminjaman->Status == 'Dipinjam' ? 'bg-warning' : 'bg-success' }}">
                                    {{ $peminjaman->Status }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 