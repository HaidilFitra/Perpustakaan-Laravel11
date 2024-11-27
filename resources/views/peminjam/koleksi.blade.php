@extends('layouts.peminjam')

@section('title', 'Koleksi Pribadi')

@section('breadcrumb', 'Koleksi')
@section('page-title', 'Koleksi Pribadi')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <h6>Daftar Koleksi Buku</h6>
      </div>
      <div class="card-body px-0 pt-0 pb-2">
        @if(session('success'))
        <div class="alert alert-success mx-4">
          {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger mx-4">
          {{ session('error') }}
        </div>
        @endif

        @if($koleksi->count() > 0)
        <div class="table-responsive p-0">
          <table class="table align-items-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Buku</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Penerbit</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tahun Terbit</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Ditambahkan</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($koleksi as $item)
              <tr>
                <td>
                  <div class="d-flex px-2 py-1">
                    <div>
                      <img src="{{ asset($item->buku->image) }}"
                        class="avatar avatar-sm me-3"
                        alt="{{ $item->buku->judul }}"
                        style="width: 32px; height: 48px; object-fit: cover; border-radius: 0.25rem;">
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                      <h6 class="mb-0 text-sm">{{ $item->buku->judul }}</h6>
                      <p class="text-xs text-secondary mb-0">{{ $item->buku->pengarang }}</p>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">{{ $item->buku->penerbit }}</p>
                </td>
                <td>
                  <p class="text-xs font-weight-bold mb-0">
                    {{ \Carbon\Carbon::parse($item->buku->tahunTerbit)->format('Y') }}
                  </p>
                </td>
                <td>
                  <p class="text-xs text-secondary mb-0">
                    {{ \Carbon\Carbon::parse($item->created_at)->locale('id')->diffForHumans() }}
                  </p>
                </td>
                <td class="align-middle text-center">
                  <div class="d-flex justify-content-center gap-2">
                    <a href="{{ route('buku.show', $item->buku->id) }}"
                      class="btn btn-sm btn-info"
                      title="Detail">
                      <i class="ri-eye-line"></i>
                    </a>
                    <form action="{{ route('peminjam.koleksi.destroy', $item->id) }}"
                      method="POST"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini dari koleksi?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit"
                        class="btn btn-sm btn-danger"
                        title="Hapus dari Koleksi">
                        <i class="ri-delete-bin-line"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @else
        <div class="text-center py-4">
          <p class="text-muted mb-0">Belum ada buku dalam koleksi Anda.</p>
          <a href="{{ route('home') }}" class="btn btn-primary mt-3">
            <i class="ri-book-line me-2"></i>Cari Buku
          </a>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<style>
  .btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
  }

  .btn i {
    font-size: 1rem;
  }

  .avatar-sm {
    width: 32px;
    height: 48px;
    object-fit: cover;
    border-radius: 0.25rem;
  }
</style>
@endpush