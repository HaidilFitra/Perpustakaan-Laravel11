@extends('layouts.admin')

@section('title', 'Daftar Pengembalian')
@section('breadcrumb', 'Pengembalian')
@section('page-title', 'Daftar Pengembalian')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h6>Daftar Pengembalian</h6>
                    <a href="{{ route('admin.CRUD.Pengembalian.create') }}" class="btn btn-primary btn-sm">Tambah Pengembalian</a>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NO</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PEMINJAM</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">BUKU</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">TANGGAL KEMBALI</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">DENDA</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">STATUS</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengembalians as $item)
                                @if($item->peminjaman && $item->peminjaman->user && $item->peminjaman->buku)
                                <tr>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $loop->iteration }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $item->peminjaman->user->nama_lengkap }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $item->peminjaman->user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $item->peminjaman->buku->judul }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($item->TanggalPengembalian)->format('d/m/Y') }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">Rp {{ number_format($item->Denda, 0, ',', '.') }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $item->Status }}</p>
                                    </td>
                                    <td class="align-middle">
                                        <a href="{{ route('admin.CRUD.Pengembalian.show', $item->id) }}" class="text-secondary font-weight-bold text-xs me-3 border border-secondary rounded px-2 py-1">
                                            Detail
                                        </a>
                                        <form action="{{ route('admin.CRUD.Pengembalian.destroy', $item->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-secondary font-weight-bold text-xs border border-secondary rounded px-2 py-1" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data pengembalian</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
