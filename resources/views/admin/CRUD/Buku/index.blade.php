@extends('layouts.admin')

@section('title', 'Daftar Buku')

@section('breadcrumb', 'Buku')
@section('page-title', 'Daftar Buku')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Daftar Buku</h6>
                <a href="{{ route('admin.CRUD.Buku.create') }}" class="btn btn-primary btn-sm float-end">Tambah Buku</a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Buku</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Pengarang</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Penerbit</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tahun Terbit</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kategori</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 13%">AKSI</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($buku as $item)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            <img src="{{ asset($item->image) }}" class="avatar avatar-sm me-3" alt="{{ $item->judul }}">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $item->judul }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $item->pengarang }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-xs font-weight-bold mb-0">{{ $item->penerbit }}</p>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-bold">{{ $item->tahunTerbit }}</span>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-bold">
                                        {{ $item->kategoris->pluck('NamaKategori')->implode(', ') }}
                                    </span>
                                </td>
                                <td class="align-middle">
                                    <a href="{{ route('admin.CRUD.Buku.show', $item->id) }}" class="text-secondary font-weight-bold text-xs me-3 border border-secondary rounded px-2 py-1" data-toggle="tooltip" data-original-title="Detail">
                                        Detail
                                    </a>
                                    <a href="{{ route('admin.CRUD.Buku.edit', $item->id) }}" class="text-secondary font-weight-bold text-xs me-3 border border-secondary rounded px-2 py-1" data-toggle="tooltip" data-original-title="Edit">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.CRUD.Buku.destroy', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-secondary font-weight-bold text-xs border border-secondary rounded px-2 py-1" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
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