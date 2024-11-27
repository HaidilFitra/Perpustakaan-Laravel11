<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{asset('frontend/assets/images/literalink-logo-.svg')}}">
    <title>@yield('title') - LiteraLink</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Remix Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <style>
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .nav-link {
            color: #344767;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 5px;
        }

        .nav-link:hover,
        .nav-link.active {
            background-color: #f8f9fa;
        }

        .nav-link i {
            margin-right: 10px;
        }

        .top-navbar {
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 15px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar" style="width: 250px;">
        <div class="d-flex align-items-center mb-4 px-2">
            <h4 class="mb-0">LiteraLink</h4>
        </div>

        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="bi bi-house"></i>
                    Daftar Buku
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('peminjam.dashboard') ? 'active' : '' }}"
                    href="{{ route('peminjam.dashboard') }}">
                    <i class="bi bi-book"></i>
                    Daftar Peminjaman
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('peminjam.koleksi.*') ? 'active' : '' }}"
                    href="{{ route('peminjam.koleksi.index') }}">
                    <i class="ri-bookmark-line me-2"></i>
                    <span>Koleksi Pribadi</span>
                </a>
            </li>
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="nav-link text-danger border-0 w-100 text-start">
                        <i class="bi bi-box-arrow-right"></i>
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <div class="top-navbar rounded">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-0">@yield('page-title')</h6>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Peminjam</a></li>
                            <li class="breadcrumb-item active">@yield('breadcrumb')</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <span class="fw-bold">{{ Auth::user()->name }}</span>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>