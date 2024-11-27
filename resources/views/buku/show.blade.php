@extends('layouts.app')

@section('title', $buku->judul)

@section('content')
<div class="container" style="margin-top: 100px;">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-4 mb-4 mb-md-0">
            <div class="position-relative mb-4">
                <img src="{{ asset($buku->image) }}" alt="{{ $buku->judul }}"
                    class="img-fluid rounded-3 shadow w-100"
                    style="object-fit: cover; height: 400px;">
            </div>
        </div>

        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h2 class="mb-2">{{ $buku->judul }}</h2>
                    <h5 class="text-muted">{{ $buku->pengarang }}</h5>
                </div>
                <div>
                    @foreach($buku->kategoris as $kategori)
                    <span class="badge bg-primary rounded-pill me-1">{{ $kategori->NamaKategori }}</span>
                    @endforeach
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-sm-4">
                    <div class="p-3 border rounded-3 h-100">
                        <small class="text-muted d-block mb-1">Penerbit</small>
                        <span class="fw-medium">{{ $buku->penerbit }}</span>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="p-3 border rounded-3 h-100">
                        <small class="text-muted d-block mb-1">Tahun Terbit</small>
                        <span class="fw-medium">{{ date('Y', strtotime($buku->tahunTerbit)) }}</span>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="p-3 border rounded-3 h-100">
                        <small class="text-muted d-block mb-1">Jumlah Halaman</small>
                        <span class="fw-medium">{{ $buku->jumlah_halaman }} halaman</span>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h5 class="mb-3">Deskripsi</h5>
                <p class="text-muted">{{ $buku->deskripsi }}</p>
            </div>

            <div class="d-flex gap-2">
                @auth
                    @if(auth()->user()->role == 'peminjam')
                        @php
                            $existingKoleksi = \App\Models\koleksipribadi::where('user_id', auth()->id())
                                ->where('buku_id', $buku->id)
                                ->first();
                        @endphp

                        @if($existingKoleksi)
                            <form action="{{ route('peminjam.koleksi.destroy', $existingKoleksi->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger d-flex align-items-center gap-2">
                                    <i class="ri-bookmark-fill"></i>
                                    <span>Hapus dari Koleksi</span>
                                </button>
                            </form>
                        @else
                            <form action="{{ route('peminjam.koleksi.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="buku_id" value="{{ $buku->id }}">
                                <button type="submit" class="btn btn-outline-primary d-flex align-items-center gap-2">
                                    <i class="ri-bookmark-line"></i>
                                    <span>Tambah ke Koleksi</span>
                                </button>
                            </form>
                        @endif
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary d-flex align-items-center gap-2">
                        <i class="ri-login-box-line"></i>
                        <span>Login</span>
                    </a>
                @endauth
                <a href="{{ url()->previous() }}" class="btn d-flex align-items-center gap-2" style="background-color: #F8F9FA; color: #000;">
                    <i class="ri-arrow-left-line"></i>
                    <span>Kembali</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-5">
        <div class="col-md-5 me-4">
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="card-title mb-4">Review</h5>
                    @auth
                    <form action="{{ route('peminjam.ulasan.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="buku_id" value="{{ $buku->id }}">
                        <input type="hidden" name="rating" id="ratingInput" value="">

                        <div class="rating-stars mb-3">
                            <div class="d-flex gap-3 justify-content-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="ri-star-line fs-2 text-muted"
                                    role="button"
                                    data-rating="{{ $i }}"
                                    onclick="setRating({{ $i }})"></i>
                                    @endfor
                            </div>
                        </div>

                        <div class="mb-3">
                            <textarea class="form-control @error('ulasan') is-invalid @enderror"
                                name="ulasan"
                                rows="6"
                                placeholder="Tulis ulasan Anda...">{{ old('ulasan') }}</textarea>
                            @error('ulasan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Submit</button>
                    </form>
                    @else
                    <p class="text-center">
                        <a href="{{ route('formLogin') }}" class="text-primary">Login</a> untuk memberikan ulasan
                    </p>
                    @endauth
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-body p-4">
                    <h5 class="card-title mb-4">Ulasan</h5>
                    <div class="review-list">
                        @forelse($buku->ulasanbuku ?? [] as $ulasan)
                        <div class="review-item mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">{{ $ulasan->user->username }}</h6>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="ri-star-{{ $i <= $ulasan->rating ? 'fill' : 'line' }} text-warning"></i>
                                            @endfor
                                    </div>
                                </div>
                            </div>
                            <p class="text-muted mb-0">{{ $ulasan->ulasan }}</p>
                            @unless($loop->last)
                            <hr class="my-3">
                            @endunless
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <i class="ri-chat-3-line fs-1 text-muted mb-2"></i>
                            <p class="text-muted mb-0">Belum ada ulasan</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        min-height: 500px;
    }

    .review-list {
        max-height: 400px;
        overflow-y: auto;
    }

    .rating-stars i {
        cursor: pointer;
        transition: color 0.2s;
        font-size: 2rem;
    }

    .rating-stars i:hover,
    .rating-stars i.active {
        color: #ffc107 !important;
    }

    textarea.form-control {
        min-height: 200px;
        resize: none;
        border-radius: 10px;
    }

    .row.justify-content-center {
        margin-left: 0;
        margin-right: 0;
    }

    .col-md-5 {
        padding: 15px;
    }

    .btn {
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 500;
    }

    .btn:hover {
        opacity: 0.9;
    }

    .btn i {
        font-size: 20px;
    }
</style>

<script>
    function setRating(rating) {
        document.getElementById('ratingInput').value = rating;

        const stars = document.querySelectorAll('.rating-stars i');
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.remove('ri-star-line', 'text-muted');
                star.classList.add('ri-star-fill', 'text-warning');
            } else {
                star.classList.add('ri-star-line', 'text-muted');
                star.classList.remove('ri-star-fill', 'text-warning');
            }
        });
    }

    document.querySelector('form').addEventListener('submit', function(e) {
        const rating = document.getElementById('ratingInput').value;
        if (!rating) {
            e.preventDefault();
            alert('Silakan berikan rating terlebih dahulu');
        }
    });
</script>
@endsection