<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'UnduhPustaka- Koleksi eBook Gratis')</title>
    
    <!--  (Tailwind CSS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-gradient-to-br from-primary-500 to-secondary-500 text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-white hover:opacity-90 transition-opacity">
                    <img src="{{ asset('image/logo2.png') }}" alt="UnduhPustaka Logo" style="height: 36px; width: 36px;">
                    <h1 class="text-2xl font-semibold">UnduhPustaka</h1>
                </a>
                
                <!-- User Menu -->
                <div class="relative">
                    @auth
                        <div class="group">
                            <button type="button" class="flex items-center gap-2 bg-white text-gray-800 px-4 py-2 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                               <!-- gambar profil -->     <img src="{{ asset('image/profil.png') }}" alt="profil" style="height: 25px; width: 25px;">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <!-- Dropdown Menu -->
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <a href="{{ route('history') }}" class="flex px-4 py-3 text-gray-700 hover:bg-gray-50 rounded-t-lg transition-colors">
                                       <img src="{{ asset('image/buku2.png') }}" alt="buku" style="height: 28px; width: 28px;"><span>Riwayat Bacaan</span>
                                </a>
                               
                              
                                <a href="{{ route('profile') }}" class="flex px-4 py-3 text-gray-700 hover:bg-gray-50 transition-colors" >
                                         <img src="{{ asset('image/profil.png') }}" alt="profil" style="height: 25px; width: 25px;"> <span>Profile</span>
                                </a>
                               
                                <hr class="border-gray-200">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-3 text-red-600 hover:bg-red-50 rounded-b-lg transition-colors">
                                         Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="flex gap-2">
                            <a href="{{ route('login') }}" class="bg-white text-gray-800 px-3 py-1  rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="border-2 border-white text-white px-3 py-1  rounded-lg font-semibold hover:bg-white hover:text-primary-500 transition-colors">
                                Register
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Search Bar -->
    <div class="bg-white py-6 shadow-sm">
        <div class="container mx-auto px-4">
            <form action="{{ route('search') }}" method="GET" class="flex gap-3" id="searchForm">
                <div class="relative flex-1">
                    <input 
                        type="text" 
                        name="q" 
                        id="searchInput"
                        class="w-full px-5 py-3 text-lg border-2 border-gray-200 rounded-xl focus:border-primary-500 focus:ring-4 focus:ring-primary-500 focus:ring-opacity-20 outline-none transition-all" 
                        placeholder="Cari buku berdasarkan judul atau penulis..."
                        value="{{ request('q') }}"
                        autocomplete="off"
                        required
                    >
                    <!-- Autocomplete Dropdown -->
                    <div class="autocomplete-dropdown" id="autocompleteDropdown"></div>
                    <!-- Loading Indicator -->
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 hidden" id="searchLoading">
                        <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-primary-500"></div>
                    </div>
                </div>
                <button type="submit" class="flex bg-primary-500 text-white px-8 py-3 rounded-xl font-semibold hover:bg-primary-600 hover:-translate-y-0.5 active:translate-y-0 transition-all shadow-md hover:shadow-lg">
                     <img src="{{ asset('image/search.png') }}" alt="buku" style="height: 28px; width: 28px;"><span> Cari</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="container mx-auto px-4 mt-4">
            <div class="bg-green-50 border-l-4 border-green-500 text-green-900 p-4 rounded-lg shadow-sm alert-dismissible" role="alert">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                          <img src="{{ asset('image/centang.png') }}" alt="buku" style="height: 28px; width: 28px;">
                        <div>
                            <strong class="font-bold">Berhasil!</strong>
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                    <button type="button" class="text-green-500 hover:text-green-700" onclick="this.closest('.alert-dismissible').remove()">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container mx-auto px-4 mt-4">
            <div class="bg-red-50 border-l-4 border-red-500 text-red-900 p-4 rounded-lg shadow-sm alert-dismissible" role="alert">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                          <img src="{{ asset('image/centang.png') }}" alt="buku" style="height: 28px; width: 28px;">
                        <div>
                            <strong class="font-bold">Error!</strong>
                            <p class="text-sm">{{ session('error') }}</p>
                        </div>
                    </div>
                    <button type="button" class="text-red-500 hover:text-red-700" onclick="this.closest('.alert-dismissible').remove()">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="py-8">
        <div class="container mx-auto px-4">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-16 py-6">
        <div class="container mx-auto px-4 text-center text-gray-600">
            <p>
                Data dari <a href="https://archive.org" target="_blank" class="text-primary-500 hover:text-primary-600 transition-colors">Internet Archive</a> | 
                
            </p>
        </div>
    </footer>
    
    @stack('scripts')
</body>
</html>