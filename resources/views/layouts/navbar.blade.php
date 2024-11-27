<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">LiteraLink.</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">Tentang Kami</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#services">Layanan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#books">Buku</a>
                </li>
            </ul>
            <div class="nav-right d-flex align-items-center gap-4">
                <div class="search-box">
                    <input type="text" class="form-control" placeholder="Search">
                    <i class="bi bi-search"></i>
                </div>

                @auth
                <div class="profile-dropdown">
                    <button class="btn btn-link p-0" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle fs-4"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @if (Auth::user()->role == 'peminjam')
                        <li><a class="dropdown-item" href="{{ route('peminjam.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                        @endif
                        @if (Auth::user()->role == 'petugas')
                        <li><a class="dropdown-item" href="{{ route('petugas.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                        @endif
                        @if (Auth::user()->role == 'administrator')
                        <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
                        @endif
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                @else
                <a href="{{ route('login') }}" class="btn btn-primary px-4">Sign In</a>
                @endauth
            </div>
        </div>
    </div>
</nav>