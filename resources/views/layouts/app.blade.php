<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Open Library - Koleksi eBook Gratis')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    @stack('styles')
</head>
<body>
    <!-- Header -->
    <header class="gradient-header">
        <div class="container">
            <div class="header-content d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="{{ route('home') }}" class="text-decoration-none text-white d-flex align-items-center gap-2">
                        <span class="logo-icon">📚</span>
                        <h1 class="mb-0">Open Library</h1>
                    </a>
                </div>
                
                <!-- User Menu -->
                <div class="user-menu">
                    @auth
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                👤 {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ route('history') }}">📖 Riwayat Bacaan</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile') }}">👤 Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">🚪 Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <div class="d-flex gap-2">
                            <a href="{{ route('login') }}" class="btn btn-light">Login</a>
                            <a href="{{ route('register') }}" class="btn btn-outline-light">Register</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Search Bar -->
    <div class="search-container">
        <div class="container">
            <form action="{{ route('search') }}" method="GET" class="search-form" id="searchForm">
                <div class="search-wrapper">
                    <input 
                        type="text" 
                        name="q" 
                        id="searchInput"
                        class="form-control search-input" 
                        placeholder="Cari buku berdasarkan judul atau penulis..."
                        value="{{ request('q') }}"
                        autocomplete="off"
                        required
                    >
                    <!-- Autocomplete Dropdown -->
                    <div class="autocomplete-dropdown" id="autocompleteDropdown"></div>
                    <!-- Loading Indicator -->
                    <div class="search-loading" id="searchLoading">
                        <div class="spinner-border spinner-border-sm text-primary"></div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary search-btn">
                    🔍 Cari
                </button>
            </form>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer mt-5 py-4 bg-light">
        <div class="container text-center text-muted">
            <p class="mb-0">
                Data dari <a href="https://archive.org" target="_blank" class="text-decoration-none">Internet Archive</a> | 
                Open Library &copy; {{ date('Y') }}
            </p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="{{ asset('js/script.js') }}"></script>
    
    @stack('scripts')
</body>
</html>