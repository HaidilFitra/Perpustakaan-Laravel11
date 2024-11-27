@extends('layouts.admin')

@section('title', 'Edit Pengembalian')
@section('breadcrumb', 'Edit Pengembalian')
@section('page-title', 'Edit Data Pengembalian')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h6>Edit Pengembalian</h6>
                    <a href="{{ route('admin.CRUD.Pengembalian.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.CRUD.Pengembalian.update', $pengembalian->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="peminjaman_id" class="form-label text-secondary">Peminjaman</label>
                                <select class="form-control @error('peminjaman_id') is-invalid @enderror" id="peminjaman_id" name="peminjaman_id">
                                    <option selected disabled>Pilih Peminjaman</option>
                                    @foreach($peminjamans as $peminjaman)
                                        <option value="{{ $peminjaman->id }}" {{ (old('peminjaman_id', $pengembalian->peminjaman_id) == $peminjaman->id) ? 'selected' : '' }}>
                                            {{ $peminjaman->anggota->nama }} - {{ $peminjaman->buku->judul }}
                                            (Deadline: {{ date('Y-m-d\TH:i', strtotime($peminjaman->TanggalKembali)) }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('peminjaman_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="TanggalPengembalian" class="form-label text-secondary">Tanggal Pengembalian</label>
                                <input type="datetime-local" class="form-control @error('TanggalPengembalian') is-invalid @enderror" 
                                    id="TanggalPengembalian" name="TanggalPengembalian" 
                                    value="{{ old('TanggalPengembalian', date('Y-m-d\TH:i', strtotime($pengembalian->TanggalPengembalian))) }}">
                                @error('TanggalPengembalian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Status" class="form-label text-secondary">Status</label>
                                <select class="form-control @error('Status') is-invalid @enderror" id="Status" name="Status">
                                    <option value="Dikembalikan" {{ (old('Status', $pengembalian->Status) == 'Dikembalikan') ? 'selected' : '' }}>
                                        Dikembalikan
                                    </option>
                                    <option value="Terlambat" {{ (old('Status', $pengembalian->Status) == 'Terlambat') ? 'selected' : '' }}>
                                        Terlambat
                                    </option>
                                </select>
                                @error('Status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Denda" class="form-label text-secondary">Denda</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control @error('Denda') is-invalid @enderror" 
                                        id="Denda" name="Denda" value="{{ old('Denda', $pengembalian->Denda) }}"
                                        placeholder="Masukkan jumlah denda">
                                </div>
                                @error('Denda')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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

@section('scripts')
<script>
    document.getElementById('TanggalPengembalian').addEventListener('change', function() {
        const returnDate = new Date(this.value);
        const deadlineText = document.querySelector('#peminjaman_id option:checked').textContent.match(/Deadline: (.*)\)/)[1];
        const deadlineDate = new Date(deadlineText.replace('T', ' '));
        
        if (returnDate > deadlineDate) {
            const diffTime = Math.abs(returnDate - deadlineDate);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            document.getElementById('Denda').value = diffDays * 1000;
            document.getElementById('Status').value = 'Terlambat';
        } else {
            document.getElementById('Denda').value = 0;
            document.getElementById('Status').value = 'Dikembalikan';
        }
    });
</script>
@endsection
