<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Portal Alumni - Universitas Sebelas Maret</title>
    <link rel="icon" type="image/png" href="https://uns.ac.id/id/wp-content/uploads/2023/06/logo-uns-biru.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* GLOBAL STYLE */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa; /* Abu-abu sangat muda */
            color: #333;
        }
        
        /* UNS COLOR PALETTE */
        .text-uns { color: #0076bd; }
        .bg-uns { background-color: #0076bd; }
        .btn-uns { background-color: #0076bd; color: white; border: none; }
        .btn-uns:hover { background-color: #005a91; color: white; }

        /* NAVBAR CLEAN STYLE */
        .navbar {
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            background: white !important;
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            color: #1a1a1a !important;
            letter-spacing: -0.5px;
        }
        .nav-link {
            font-weight: 500;
            color: #555 !important;
            font-size: 0.95rem;
        }
        .nav-link:hover { color: #0076bd !important; }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white sticky-top">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
                    <img src="https://uns.ac.id/id/wp-content/uploads/2023/06/logo-uns-biru.png" alt="Logo UNS" height="45">
                    <div class="d-flex flex-column" style="line-height: 1.2;">
                        <span style="font-size: 0.9rem; color: #666; font-weight: 400;">IKATAN ALUMNI</span>
                        <span class="text-uns">UNIVERSITAS SEBELAS MARET</span>
                    </div>
                </a>

                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto align-items-center">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link px-3" href="{{ route('login') }}">Masuk</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-outline-secondary btn-sm rounded-pill px-4 ms-2" href="{{ route('register') }}">Daftar</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle fw-bold text-dark" href="#" role="button" data-bs-toggle="dropdown">
                                    <img src="{{ Auth::user()->foto ? asset('storage/'.Auth::user()->foto) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}" 
                                         class="rounded-circle border me-1" width="30" height="30" style="object-fit: cover;">
                                    {{ Auth::user()->name }}
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow mt-2">
                                    <li><a class="dropdown-item py-2" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
                                    <li><a class="dropdown-item py-2" href="{{ route('profile.edit') }}"><i class="bi bi-person-gear me-2"></i> Edit Profil</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button class="dropdown-item py-2 text-danger"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-0">
            @yield('content')
        </main>
        
        <footer class="bg-white text-center py-4 mt-5 border-top">
            <div class="container">
                <p class="text-muted small mb-0">&copy; {{ date('Y') }} Universitas Sebelas Maret. All rights reserved.</p>
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
</body>
</html>