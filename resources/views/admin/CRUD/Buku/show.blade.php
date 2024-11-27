@extends('layouts.admin')

@section('title', 'Detail Buku')

@section('breadcrumb', 'Detail Buku')
@section('page-title', 'Detail Data Buku')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h6>Detail Buku</h6>
                    <a href="{{ route('admin.CRUD.Buku.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-4">
                    <div class="mb-4">
                        <img src="{{ asset($buku->image) }}" alt="Cover {{ $buku->judul }}" class="img-fluid rounded" style="max-width: 200px;">
                    </div>
                    <table class="table">
                        <tr>
                            <th width="200">Judul</th>
                            <td>{{ $buku->judul }}</td>
                        </tr>
                        <tr>
                            <th>Pengarang</th>
                            <td>{{ $buku->pengarang }}</td>
                        </tr>
                        <tr>
                            <th>Penerbit</th>
                            <td>{{ $buku->penerbit }}</td>
                        </tr>
                        <tr>
                            <th>Tahun Terbit</th>
                            <td>{{ \Carbon\Carbon::parse($buku->tahunTerbit)->format('Y') }}</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>
                                @foreach($buku->kategoris as $kategori)
                                    {{ $kategori->NamaKategori }}
                                @endforeach
                            </td>
                        </tr>
                    </table>
                    <div class="mt-4">
                        <a href="{{ route('admin.CRUD.Buku.edit', $buku->id) }}" class="btn btn-info">Edit</a>
                        <form action="{{ route('admin.CRUD.Buku.destroy', $buku->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection