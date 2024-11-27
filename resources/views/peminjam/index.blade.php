@extends('layouts.peminjam')

@section('title', 'Daftar Peminjaman')

@section('breadcrumb', 'Daftar Peminjaman')
@section('page-title', 'Daftar Peminjaman')

@section('content')
<div class="nav-right d-flex align-items-center gap-4">
    <div class="profile-dropdown">
        <a href="javascript:;" class="nav-link text-white p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="ni ni-single-02 cursor-pointer"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
            <li class="mb-2">
                <a class="dropdown-item border-radius-md" href="{{ route('peminjam.dashboard') }}" style="color: #344767 !important;">
                    <div class="d-flex py-1">
                        <div class="d-flex flex-column justify-content-center">
                            <h6 class="text-sm font-weight-normal mb-1" style="color: #344767 !important;">
                                <i class="ni ni-shop me-1"></i>
                                Home
                            </h6>
                        </div>
                    </div>
                </a>
            </li>
            <li>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="dropdown-item border-radius-md" style="color: #ea0606 !important;">
                        <div class="d-flex py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class="text-sm font-weight-normal mb-1" style="color: #ea0606 !important;">
                                    <i class="ni ni-button-power me-1"></i>
                                    Logout
                                </h6>
                            </div>
                        </div>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Daftar Buku yang Dipinjam</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Buku</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal Pinjam</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal Kembali</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                <th class="text-secondary opacity-7"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($peminjaman as $pinjam)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            <img src="{{ asset($pinjam->buku->image) }}" class="avatar avatar-sm me-3" alt="{{ $pinjam->buku->judul }}" style="width: 32px; height: 48px; object-fit: cover; border-radius: 0.25rem;">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $pinjam->buku->judul }}</h6>
                                            <p class="text-xs text-secondary mb-0">{{ $pinjam->buku->pengarang }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex px-2">
                                        <span class="text-secondary text-xs font-weight-bold">
                                            {{ date('d/m/Y', strtotime($pinjam->tanggal_pinjam)) }}
                                        </span>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex px-2">
                                        <span class="text-secondary text-xs font-weight-bold">
                                            {{ $pinjam->tanggal_kembali ? date('d/m/Y', strtotime($pinjam->tanggal_kembali)) : '-' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex justify-content-center">
                                        @if($pinjam->Status == 'Dipinjam')
                                        <span class="badge bg-warning">Dipinjam</span>
                                        @elseif($pinjam->Status == 'Dikembalikan')
                                        <span class="badge bg-success" style="color: #ffffff !important;">Dikembalikan</span>
                                        @endif
                                    </div>
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