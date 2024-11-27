@extends('layouts.admin')

@section('title', 'Daftar Kategori')

@section('breadcrumb', 'Kategori')
@section('page-title', 'Daftar Kategori')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>Daftar Kategori</h6>
                <a href="{{ route('admin.CRUD.Kategori.create') }}" class="btn btn-primary btn-sm">Tambah Kategori</a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">NAMA KATEGORI</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($Kategori as $item)
                            <tr>
                                <td class="ps-3">
                                    <p class="text-xs font-weight-bold mb-0">{{ $item->NamaKategori }}</p>
                                </td>
                                <td class="text-end pe-3">
                                    <a href="{{ route('admin.CRUD.Kategori.edit', $item->id) }}" class="text-secondary font-weight-bold text-xs me-2 border border-secondary rounded px-2 py-1" data-toggle="tooltip" data-original-title="Edit kategori">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.CRUD.Kategori.destroy', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-secondary font-weight-bold text-xs border border-secondary rounded px-2 py-1" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
