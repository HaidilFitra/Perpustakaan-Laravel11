@extends('layouts.admin')

@section('title', 'Detail Pengembalian')
@section('breadcrumb', 'Detail Pengembalian')
@section('page-title', 'Detail Data Pengembalian')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h6>Detail Pengembalian</h6>
                    <a href="{{ route('admin.CRUD.Pengembalian.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Peminjam</label>
                            <p class="form-control-static mb-3">{{ $pengembalian->peminjaman->anggota->nama }}</p>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Buku</label>
                            <p class="form-control-static mb-3">{{ $pengembalian->peminjaman->buku->judul }}</p>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Tanggal Pinjam</label>
                            <p class="form-control-static mb-3">{{ $pengembalian->peminjaman->TanggalPinjam }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Tanggal Harus Kembali</label>
                            <p class="form-control-static mb-3">{{ $pengembalian->peminjaman->TanggalKembali }}</p>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Tanggal Peminjaman</label>
                            <p class="form-control-static mb-3">{{ \Carbon\Carbon::parse($pengembalian->peminjaman->TanggalPeminjaman)->format('d/m/Y') }}</p>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Tanggal Pengembalian</label>
                            <p class="form-control-static mb-3">{{ \Carbon\Carbon::parse($pengembalian->TanggalPengembalian)->format('d/m/Y') }}</p>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Status</label>
                            <p class="form-control-static mb-3">
                                <span class="badge badge-sm bg-gradient-{{ $pengembalian->Status == 'Terlambat' ? 'danger' : 'success' }}">
                                    {{ $pengembalian->Status }}
                                </span>
                            </p>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Denda</label>
                            <p class="form-control-static mb-3">Rp {{ number_format($pengembalian->Denda, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
