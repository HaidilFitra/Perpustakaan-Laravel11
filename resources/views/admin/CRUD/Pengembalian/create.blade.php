@extends('layouts.admin')

@section('title', 'Tambah Pengembalian')
@section('breadcrumb', 'Tambah Pengembalian')
@section('page-title', 'Tambah Data Pengembalian')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <h6>Tambah Pengembalian</h6>
                    <a href="{{ route('admin.CRUD.Pengembalian.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.CRUD.Pengembalian.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="peminjaman_id" class="form-control-label">Peminjaman</label>
                                <select class="form-select @error('peminjaman_id') is-invalid @enderror" id="peminjaman_id" name="peminjaman_id">
                                    <option value="">Pilih Peminjaman</option>
                                    @foreach($peminjamans as $peminjaman)
                                        <option value="{{ $peminjaman->id }}" 
                                            data-tanggal="{{ \Carbon\Carbon::parse($peminjaman->TanggalPeminjaman)->format('Y-m-d') }}"
                                            {{ old('peminjaman_id') == $peminjaman->id ? 'selected' : '' }}>
                                            {{ $peminjaman->user->nama_lengkap }} - {{ $peminjaman->buku->judul }} 
                                            (Dipinjam: {{ \Carbon\Carbon::parse($peminjaman->TanggalPeminjaman)->format('d/m/Y') }},
                                            Deadline: {{ \Carbon\Carbon::parse($peminjaman->TanggalKembali)->format('d/m/Y') }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('peminjaman_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="TanggalPengembalian" class="form-control-label">Tanggal Pengembalian</label>
                                <input class="form-control @error('TanggalPengembalian') is-invalid @enderror" type="date" 
                                    id="TanggalPengembalian" name="TanggalPengembalian" 
                                    value="{{ old('TanggalPengembalian', date('Y-m-d')) }}">
                                @error('TanggalPengembalian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div id="dendaInfo" class="alert alert-info d-none">
                                <!-- Info denda akan ditampilkan di sini -->
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
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
    $(document).ready(function() {
        $('#peminjaman_id').select2({
            placeholder: "Pilih Peminjaman",
            allowClear: true
        });

        function updateTanggalMinimum() {
            const peminjaman = $('#peminjaman_id option:selected');
            const tanggalPinjam = peminjaman.data('tanggal');
            if (tanggalPinjam) {
                $('#TanggalPengembalian').attr('min', tanggalPinjam);
            }
        }

        function hitungDenda() {
            const peminjaman = $('#peminjaman_id option:selected');
            const tanggalPinjam = peminjaman.data('tanggal');
            const tanggalKembali = $('#TanggalPengembalian').val();

            if (tanggalPinjam && tanggalKembali) {
                const pinjam = new Date(tanggalPinjam);
                const kembali = new Date(tanggalKembali);
                const selisih = Math.floor((kembali - pinjam) / (1000 * 60 * 60 * 24));
                const denda = selisih > 0 ? selisih * 1000 : 0;

                if (denda > 0) {
                    $('#dendaInfo').removeClass('d-none').html(
                        `Keterlambatan: ${selisih} hari<br>` +
                        `Denda: Rp ${denda.toLocaleString('id-ID')}`
                    );
                } else {
                    $('#dendaInfo').addClass('d-none');
                }
            }
        }

        $('#peminjaman_id').change(function() {
            updateTanggalMinimum();
            hitungDenda();
        });
        
        $('#TanggalPengembalian').change(hitungDenda);
        
        // Set initial minimum date when page loads
        updateTanggalMinimum();
    });
</script>
@endpush
