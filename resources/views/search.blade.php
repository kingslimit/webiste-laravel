@extends('layouts.app')

@section('title', 'Hasil Pencarian - ' . $query)

@section('content')
<div class="animate-fade-in">
    <!-- Header Section -->
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
            <span>Hasil Pencarian untuk "{{ $query }}"</span>
            @if($total > 0)
                <span class="bg-primary-500 text-white px-3 py-1 rounded-full text-lg font-semibold">
                    {{ $total }}
                </span>
            @endif
        </h2>
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span class="font-medium">Kembali</span>
        </a>
    </div>

    <!-- Error Alert -->
    @if($error)
        <div class="bg-red-50 border-l-4 border-red-500 text-red-900 p-4 rounded-lg mb-6">
            <div class="flex items-center gap-3">
                  <img src="{{ asset('image/silang.png') }}" alt="buku" style="height: 28px; width: 28px;">
                <div>
                    <strong class="font-bold">Error!</strong>
                    <p class="text-sm">{{ $error }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(count($books) > 0)
        <!-- Book Grid -->
        <div class="book-grid">
            @foreach($books as $book)
                <div class="bg-white rounded-xl shadow-md overflow-hidden cursor-pointer hover:-translate-y-2 hover:shadow-xl transition-all duration-300" 
                     onclick="window.location='{{ route('buku.show', $book['identifier']) }}'">
                    <!-- Book Cover -->
                    <div class="relative">
                        @if(isset($book['identifier']))
                            <img src="https://archive.org/services/img/{{ $book['identifier'] }}" 
                                 alt="{{ $book['title'] ?? 'Book cover' }}"
                                 class="w-full h-[280px] object-cover"
                                 onerror="this.parentElement.innerHTML='<div class=\'w-full h-[280px] bg-gradient-to-br from-primary-500 to-secondary-500 flex items-center justify-center text-white text-5xl\'></div>'">
                        @else
                            <div class="w-full h-[280px] bg-gradient-to-br from-primary-500 to-secondary-500 flex items-center justify-center text-white text-5xl">
                                  <img src="{{ asset('image/buku2.png') }}" alt="buku" style="height: 28px; width: 28px;">
                            </div>
                        @endif
                    </div>
                    
                    <!-- Book Info -->
                    <div class="p-4">
                        <h5 class="font-semibold text-gray-800 mb-2 line-clamp-2 min-h-[3rem]">
                            {{ $book['title'] ?? 'Tidak ada judul' }}
                        </h5>
                        <p class="text-gray-600 text-sm mb-3 truncate">
                            {{ is_array($book['creator'] ?? null) ? implode(', ', $book['creator']) : ($book['creator'] ?? 'Unknown') }}
                        </p>
                        @if(isset($book['year']))
                            <small class="text-gray-500 text-xs">{{ $book['year'] }}</small>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="text-6xl opacity-50 mb-4">  </div>
            <h3 class="text-2xl font-semibold text-gray-600 mb-2">Tidak ada hasil ditemukan</h3>
            <p class="text-gray-500 mb-6">Coba kata kunci lain atau periksa ejaan Anda</p>
            <a href="{{ route('home') }}" class="inline-block bg-primary-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-600 transition-colors">
                Kembali ke Beranda
            </a>
        </div>
    @endif
</div>
@endsection