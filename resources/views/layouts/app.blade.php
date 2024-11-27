<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LiteraLink - @yield('title')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Remix Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{asset('frontend/assets/images/literalink-logo-.svg')}}">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        /* Navbar Styles */
        .navbar {
            padding: 1rem 0;
            background: white;
        }

        .navbar.scrolled {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .nav-link {
            color: #4B5563;
            font-weight: 500;
            padding: 0.5rem 1rem;
        }

        .nav-link:hover {
            color: #1D4ED8;
        }

        /* Search Box Style */
        .search-box {
            position: relative;
            width: 300px;
        }

        .search-box input {
            padding: 8px 40px 8px 16px;
            border-radius: 50px;
            border: 1px solid #E5E7EB;
            width: 100%;
        }

        .search-box input:focus {
            outline: none;
            border-color: #1D4ED8;
            box-shadow: 0 0 0 2px rgba(29, 78, 216, 0.1);
        }

        .search-box i {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #6B7280;
        }

        /* Button Styles */
        .btn-primary {
            background: #0066FF;
            border: none;
            border-radius: 50px;
            padding: 8px 24px;
            font-weight: 500;
        }

        .btn-primary:hover {
            background: #0052CC;
        }

        /* Profile Dropdown */
        .profile-dropdown .btn-link {
            color: #374151;
        }

        .profile-dropdown .btn-link:hover {
            color: #1D4ED8;
        }

        .dropdown-menu {
            margin-top: 0.5rem;
            border: none;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        .dropdown-item {
            padding: 0.5rem 1rem;
            color: #4B5563;
        }

        .dropdown-item:hover {
            background-color: #F3F4F6;
            color: #1D4ED8;
        }

        /* Responsive adjustments */
        @media (max-width: 991px) {
            .search-box {
                width: 100%;
                margin-bottom: 1rem;
            }
        }

        /* Hero Section */
        .hero-section {
            padding-top: 120px;
        }
        
        /* Service Card */
        .service-card {
            background-color: #38bdf8;
            color: white;
        }
        
        /* Book Card Styles */
        .card {
            border: none;
            transition: all 500ms cubic-bezier(0.19, 1, 0.22, 1);
            overflow: hidden;
            border-radius: 20px;
            min-height: 450px;
            box-shadow: 0 0 12px 0 rgba(0,0,0,0.2);
        }

        .card-has-bg {
            transition: all 500ms cubic-bezier(0.19, 1, 0.22, 1);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
        }

        .card-has-bg:before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background: inherit;
            filter: grayscale(0);
        }

        .card-has-bg:hover {
            transform: scale(0.98);
            box-shadow: 0 0 5px -2px rgba(0,0,0,0.3);
            background-size: 130%;
        }

        .card-img-overlay {
            transition: all 800ms cubic-bezier(0.19, 1, 0.22, 1);
            background: linear-gradient(0deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.2) 100%);
        }

        .card:hover .card-img-overlay {
            background: linear-gradient(0deg, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.3) 100%);
        }

        .card-body {
            transition: all 500ms cubic-bezier(0.19, 1, 0.22, 1);
        }

        .card:hover .card-body {
            margin-top: 30px;
        }

        .card-meta {
            color: #fff;
            text-transform: uppercase;
            font-weight: 500;
            letter-spacing: 2px;
            font-size: 0.8rem;
        }

        .card-title {
            font-weight: 800;
            color: #fff;
        }

        .card-text {
            color: rgba(255,255,255,0.8);
        }
    </style>
</head>
<body style="user-select: none;">
    @include('layouts.navbar')
    
    @yield('content')
    
    @include('layouts.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script>
        console.log('Timer started');
        let timeoutChecker = setInterval(function() {
            console.log('Checking timeout...');
            fetch('/check-timeout', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log('Response:', data);
                
                // Jika timeout atau tidak login, redirect ke login
                if (data.timeout || !data.logged_in) {
                    clearInterval(timeoutChecker);
                    if (data.message) {
                        alert(data.message);
                    }
                    window.location.href = '/login';
                    return;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                clearInterval(timeoutChecker);
            });
        }, 10000);

        // Event listener untuk aktivitas
        document.addEventListener('click', function() {
            if (timeoutChecker) {
                fetch('/check-timeout', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                });
            }
        });
    </script>
</body>
</html> 