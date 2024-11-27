@extends('layouts.admin')

@section('title', 'Edit Peminjaman')
@section('breadcrumb', 'Edit Peminjaman')
@section('page-title', 'Edit Data Peminjaman')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h6>Edit Peminjaman</h6>
                    <a href="{{ route('admin.CRUD.Peminjaman.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.CRUD.Peminjaman.update', $peminjaman->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="user_id" class="form-control-label">Peminjam</label>
                                <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id">
                                    <option value="">Pilih Peminjam</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id', $peminjaman->user_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->nama_lengkap }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="buku_id" class="form-control-label">Buku</label>
                                <select class="form-select @error('buku_id') is-invalid @enderror" id="buku_id" name="buku_id">
                                    <option value="">Pilih Buku</option>
                                    @foreach($buku as $item)
                                        <option value="{{ $item->id }}" {{ old('buku_id', $peminjaman->buku_id) == $item->id ? 'selected' : '' }}>
                                            {{ $item->judul }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('buku_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="TanggalPeminjaman" class="form-control-label">Tanggal Peminjaman</label>
                                    <input class="form-control @error('TanggalPeminjaman') is-invalid @enderror" type="date" 
                                        id="TanggalPeminjaman" name="TanggalPeminjaman" 
                                        value="{{ old('TanggalPeminjaman', $peminjaman->TanggalPeminjaman) }}">
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
                                        value="{{ old('TanggalPengembalian', $peminjaman->TanggalPengembalian) }}">
                                    @error('TanggalPengembalian')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#user_id').select2({
            placeholder: "Pilih Peminjam",
            allowClear: true
        });
        
        $('#buku_id').select2({
            placeholder: "Pilih Buku",
            allowClear: true
        });
    });
</script>
@endpush 