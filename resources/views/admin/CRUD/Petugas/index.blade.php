@extends('layouts.admin')

@section('title', 'Daftar Petugas')

@section('breadcrumb', 'Petugas')
@section('page-title', 'Daftar Petugas')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <div class="d-flex justify-content-between align-items-center">
          <h6>Daftar Petugas</h6>
          <a href="{{ route('admin.CRUD.Petugas.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Petugas
          </a>
        </div>
      </div>
      <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Lengkap</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Username</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Alamat</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 13%">AKSI</th>
                <th class="text-secondary opacity-7"></th>
              </tr>
            </thead>
            <tbody>
              @foreach($petugas as $p)
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm">{{ $p->nama_lengkap }}</h6>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">{{ $p->username }}</p>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">{{ $p->email }}</p>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">{{ $p->alamat }}</p>
                </td>
                <td class="align-middle">
                  <a href="{{ route('admin.CRUD.Petugas.show', $p->id) }}" class="text-secondary font-weight-bold text-xs me-3" data-toggle="tooltip" data-original-title="Detail">
                    Detail
                  </a>
                  <a href="{{ route('admin.CRUD.Petugas.edit', $p->id) }}" class="text-secondary font-weight-bold text-xs me-3" data-toggle="tooltip" data-original-title="Edit">
                    Edit
                  </a>
                  <form action="{{ route('admin.CRUD.Petugas.destroy', $p->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-secondary font-weight-bold text-xs border-0 bg-transparent" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
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