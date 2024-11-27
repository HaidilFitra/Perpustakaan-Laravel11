@extends('layouts.admin')

@section('title', 'Tambah Peminjaman')

@section('breadcrumb', 'Tambah Peminjaman')
@section('page-title', 'Tambah Data Peminjaman')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h6>Tambah Peminjaman</h6>
                    <a href="{{ route('admin.CRUD.Peminjaman.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.CRUD.Peminjaman.store') }}" method="POST">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label text-secondary">Peminjam</label>
                                <select class="form-control @error('user_id') is-invalid @enderror" name="user_id">
                                    <option value="">Pilih Peminjam</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->nama_lengkap }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label text-secondary">Buku</label>
                                <select class="form-control @error('buku_id') is-invalid @enderror" name="buku_id">
                                    <option value="">Pilih Buku</option>
                                    @foreach($buku as $book)
                                    <option value="{{ $book->id }}" {{ old('buku_id') == $book->id ? 'selected' : '' }}>
                                        {{ $book->judul }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('buku_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="TanggalPeminjaman" class="form-control-label">Tanggal Peminjaman</label>
                                <input class="form-control @error('TanggalPeminjaman') is-invalid @enderror" type="date"
                                    id="TanggalPeminjaman" name="TanggalPeminjaman"
                                    value="{{ old('TanggalPeminjaman', date('Y-m-d')) }}"
                                    min="{{ date('Y-m-d') }}"
                                    onchange="setMinReturnDate()">
                                @error('TanggalPeminjaman')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="TanggalPengembalian" class="form-control-label">Tanggal Pengembalian</label>
                                <input class="form-control @error('TanggalPengembalian') is-invalid @enderror" type="date"
                                    id="TanggalPengembalian" name="TanggalPengembalian"
                                    value="{{ old('TanggalPengembalian') }}">
                                @error('TanggalPengembalian')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">*Maksimal peminjaman 7 hari</small>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function setMinReturnDate() {
        // Ambil tanggal peminjaman
        const pinjamDate = document.getElementById('TanggalPeminjaman').value;
        const returnInput = document.getElementById('TanggalPengembalian');

        if (pinjamDate) {
            // Set minimal tanggal pengembalian = tanggal pinjam
            returnInput.min = pinjamDate;

            // Set maksimal tanggal pengembalian = tanggal pinjam + 7 hari
            const maxDate = new Date(pinjamDate);
            maxDate.setDate(maxDate.getDate() + 7);
            returnInput.max = maxDate.toISOString().split('T')[0];

            // Reset value jika diluar range
            if (returnInput.value) {
                const returnDate = new Date(returnInput.value);
                if (returnDate < new Date(pinjamDate) || returnDate > maxDate) {
                    returnInput.value = '';
                }
            }
        }
    }

    // Jalankan saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        setMinReturnDate();
    });
</script>
@endpush