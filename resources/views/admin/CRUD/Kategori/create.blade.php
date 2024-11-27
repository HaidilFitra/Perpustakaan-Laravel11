@extends('layouts.admin')

@section('title', 'Tambah Kategori')

@section('breadcrumb', 'Tambah Kategori')
@section('page-title', 'Tambah Kategori Baru')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Tambah Kategori Baru</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <form action="{{ route('admin.CRUD.Kategori.store') }}" method="POST" class="p-4">
                    @csrf
                    <div class="form-group">
                        <label for="NamaKategori" class="form-control-label">Nama Kategori</label>
                        <input class="form-control" type="text" id="NamaKategori" name="NamaKategori" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection