@extends('layouts.admin')

@section('title', 'Edit Kategori')

@section('breadcrumb', 'Edit Kategori')
@section('page-title', 'Edit Kategori')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Edit Kategori</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <form action="{{ route('admin.CRUD.Kategori.update', $Kategori->id) }}" method="POST" class="p-4">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="NamaKategori" class="form-control-label">Nama Kategori</label>
                        <input class="form-control" type="text" id="NamaKategori" name="NamaKategori" value="{{ $Kategori->NamaKategori }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
