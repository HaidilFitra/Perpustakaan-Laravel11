@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="hero-section" id="home">
    <div class="container">
        <div class="row align-items-center gy-5">
            <div class="col-md-6">
                <h1 class="display-5 fw-bold mb-4">
                    Perpustakaan Digital Masa Depan
                    <span class="text-primary">LiteraLink</span>
                </h1>
                <p class="mb-4">
                    Jelajahi ribuan buku digital dalam genggaman Anda. LiteraLink menghadirkan perpustakaan masa depan,
                    menggabungkan teknologi canggih dengan kekayaan literatur.
                </p>
                <a href="#books" class="btn btn-primary rounded-pill px-4">
                    Lihat Daftar Buku <i class="ri-book-2-line ms-1"></i>
                </a>
            </div>
            <div class="col-md-6">
                <img src="{{ asset('frontend/assets/images/book.webp') }}" alt="book image" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<!-- Services Section -->
<section class="py-5" id="services">
    <div class="container">
        <h2 class="text-center mb-4">Layanan Unggulan LiteraLink</h2>
        <p class="text-center mb-5">Nikmati pengalaman membaca digital terbaik dengan fitur-fitur inovatif kami.</p>

        <div class="row g-4">
            @foreach($services as $service)
            <div class="col-md-4">
                <div class="service-card p-4 rounded h-100">
                    <i class="ri-number-{{ $loop->iteration }} text-white fs-1"></i>
                    <h3 class="mt-4 mb-3">{{ $service['title'] }}</h3>
                    <p class="mb-0">{{ $service['description'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Books Section -->
<section class="py-5" id="books">
    <div class="container">
        <h2 class="text-center mb-4">Koleksi Unggulan LiteraLink</h2>
        <div class="row g-4">
            @forelse($buku as $item)
            <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
                <a href="{{ route('buku.show', $item->id) }}" class="text-decoration-none">
                    <div class="card text-white card-has-bg"
                        style="background-image:url('{{ asset($item->image) }}');">
                        <div class="card-img-overlay d-flex flex-column">
                            <div class="card-body">
                                <small class="card-meta mb-2">{{ $item->penerbit }}</small>
                                <h4 class="card-title mt-0">{{ $item->judul }}</h4>
                                <small class="text-white">
                                    <i class="far fa-calendar me-1"></i>
                                    {{ date('Y', strtotime($item->tahunTerbit)) }}
                                </small>
                            </div>
                            <div class="card-footer mt-auto">
                                <div class="media d-flex align-items-center">
                                    <div class="media-body">
                                        <h6 class="my-0 text-white d-block">{{ $item->pengarang }}</h6>
                                        <small class="text-white-50">Penulis</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12 text-center">
                <p>Tidak ada buku yang tersedia saat ini.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
@endsection