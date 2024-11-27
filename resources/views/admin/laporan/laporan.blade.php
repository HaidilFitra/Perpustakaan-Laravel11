@extends('layouts.admin')

@section('title', 'Laporan Peminjaman')
@section('breadcrumb', 'Laporan')
@section('page-title', 'Laporan Peminjaman')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h6>Laporan Peminjaman</h6>
                    <div class="d-flex gap-2">
                        <form action="{{ route('admin.CRUD.Laporan.index') }}" method="GET" class="d-flex gap-2">
                            <select name="period" class="form-select form-select-sm" style="width: 150px;" onchange="this.form.submit()">
                                <option value="daily" {{ request('period') == 'daily' ? 'selected' : '' }}>Harian</option>
                                <option value="weekly" {{ request('period') == 'weekly' ? 'selected' : '' }}>Mingguan</option>
                                <option value="monthly" {{ request('period') == 'monthly' ? 'selected' : '' }}>Bulanan</option>
                            </select>
                            <a href="{{ route('admin.CRUD.Laporan.cetak.pdf') }}?period={{ request('period', 'daily') }}" 
                               class="btn btn-primary btn-sm">Cetak PDF</a>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 5%">NO</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 25%">PEMINJAM</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 20%">BUKU</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 12%">TANGGAL PINJAM</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 12%">TANGGAL KEMBALI</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 13%">STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($peminjaman as $item)
                            <tr>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-bold">{{ $loop->iteration }}</span>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $item->user->nama_lengkap }}</h6>
                                            <p class="text-xs text-secondary mb-0">{{ $item->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $item->buku->judul }}</p>
                                </td>
                                <td class="align-middle text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($item->TanggalPeminjaman)->format('d/m/Y') }}</p>
                                </td>
                                <td class="align-middle text-center">
                                    <p class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($item->TanggalPengembalian)->format('d/m/Y') }}</p>
                                </td>
                                <td class="align-middle text-center">
                                    @php
                                        $today = \Carbon\Carbon::now();
                                        $tanggalKembali = \Carbon\Carbon::parse($item->TanggalPengembalian);
                                        $isLate = $today->gt($tanggalKembali) && $item->Status == 'Dipinjam';
                                    @endphp
                                    <span class="text-xs font-weight-bold {{ $isLate ? 'text-danger' : '' }}">
                                        {{ $item->Status }}
                                        @if($isLate)
                                            <br>(Terlambat {{ $today->diffInDays($tanggalKembali) }} hari)
                                        @endif
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data peminjaman</td>
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
