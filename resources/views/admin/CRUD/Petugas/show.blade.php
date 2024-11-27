@extends('layouts.admin')

@section('title', 'Detail Petugas')

@section('breadcrumb', 'Detail Petugas')
@section('page-title', 'Detail Petugas')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Detail Petugas</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Username:</strong> {{ $petugas->username }}</p>
                        <p><strong>Email:</strong> {{ $petugas->email }}</p>
                        <p><strong>Nama Lengkap:</strong> {{ $petugas->nama_lengkap }}</p>
                        <p><strong>Alamat:</strong> {{ $petugas->alamat }}</p>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('admin.CRUD.Petugas.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
