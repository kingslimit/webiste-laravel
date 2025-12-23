@extends('layouts.app')

@section('title', ' - Koleksi eBook Gratis')

@section('content')
<div class="animate-fade-in">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
          
            <span>Buku Trending</span>
        </h2>
        
        <!-- Time Range Filter -->
        <div class="flex gap-2 flex-wrap">
            <a href="/?range=week" class="flex px-4 py-2 rounded-lg font-medium transition-all {{ $currentRange == 'week' ? 'bg-primary-500 text-white shadow-md' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                   <img src="{{ asset('image/kalender.png') }}" alt="buku" style="height: 28px; width: 28px;"> <span>1 Minggu</span>
            </a>
            <a href="/?range=month" class="flex px-4 py-2 rounded-lg font-medium transition-all {{ $currentRange == 'month' ? 'bg-primary-500 text-white shadow-md' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                <img src="{{ asset('image/kalender.png') }}" alt="buku" style="height: 28px; width: 28px;"> <span>1 Bulan</span>
            </a>
            <a href="/?range=year" class="flex px-4 py-2 rounded-lg font-medium transition-all {{ $currentRange == 'year' ? 'bg-primary-500 text-white shadow-md' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                <img src="{{ asset('image/kalender.png') }}" alt="buku" style="height: 28px; width: 28px;"> <span>1 Tahun</span>
            </a>
        </div>
    </div>

    <!-- Error Alert -->
    @if($error)
        <div class="bg-red-50 border-l-4 border-red-500 text-red-900 p-4 rounded-lg mb-6">
            <div class="flex items-center gap-3">
                <span class="text-2xl">  <img src="{{ asset('image/silang.png') }}" alt="buku" style="height: 28px; width: 28px;"></span>
                <div>
                    <strong class="font-bold">Error!</strong>
                    <p class="text-sm">{{ $error }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Book Grid -->
    @if(count($trendingBooks) > 0)
        <div class="book-grid">
            @foreach($trendingBooks as $index => $book)
                <div class="bg-white rounded-xl shadow-md overflow-hidden cursor-pointer hover:-translate-y-2 hover:shadow-xl transition-all duration-300" 
                     onclick="window.location='{{ route('buku.show', $book->book_identifier) }}'">
                    <!-- Book Cover -->
                    <div class="relative">
                        @if($book->book_cover)
                            <img src="{{ $book->book_cover }}" 
                                 alt="{{ $book->book_title }}"
                                 class="w-full h-[280px] object-cover"
                                 onerror="this.parentElement.innerHTML='<div class=\'w-full h-[280px] bg-gradient-to-br from-primary-500 to-secondary-500 flex items-center justify-center text-white text-5xl\'></div>'">
                        @else
                            <div class="w-full h-[280px] bg-gradient-to-br from-primary-500 to-secondary-500 flex items-center justify-center text-white text-5xl">
                                   <img src="{{ asset('image/buku2.png') }}" alt="buku" style="height: 28px; width: 28px;">
                            </div>
                        @endif
                        
                        <!-- Ranking Badge -->
                        <span class="absolute top-3 right-3 bg-white text-primary-500 px-3 py-1 rounded-full font-bold text-sm shadow-lg">
                             #{{ $index + 1 }}
                        </span>
                    </div>
                    
                    <!-- Book Info -->
                    <div class="p-4">
                        <h5 class="font-semibold text-gray-800 mb-2 line-clamp-2 min-h-[3rem]">
                            {{ $book->book_title }}
                        </h5>
                        <p class="text-gray-600 text-sm mb-3 truncate">
                            {{ $book->book_author ?? 'Unknown' }}
                        </p>
                        <div class="flex gap-4 text-sm text-gray-500">
                            <span class="flex items-center gap-1">
                             <img src="{{ asset('image/mata.png') }}" alt="buku" style="height: 28px; width: 28px;">
                                <span>{{ $book->total_views }}</span>
                            </span>
                            <span class="flex items-center gap-1">
                                <img src="{{ asset('image/profil.png') }}" alt="profil" style="height: 25px; width: 25px;">
                                <span>{{ $book->unique_readers }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="text-6xl opacity-50 mb-4"><img src="{{ asset('image/teleskop.png') }}" alt="buku" style="height: 28px; width: 28px;"> <span>1 Minggu</span></div>
            <h3 class="text-2xl font-semibold text-gray-600 mb-2">Belum Ada Buku Trending</h3>
            <p class="text-gray-500 mb-6">
                @auth
                    Jadilah yang pertama membaca dan membuat buku trending!
                @else
                    <a href="{{ route('login') }}" class="text-primary-500 hover:text-primary-600 font-semibold">Login</a> 
                    untuk mulai membaca dan lihat statistik trending.
                @endauth
            </p>
            <a href="{{ route('search') }}" class="inline-block bg-primary-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-600 transition-colors">
                <img src="{{ asset('image/search.png') }}" alt="buku" style="height: 28px; width: 28px;"> <span>Cari Buku</span>
            </a>
        </div>
    @endif
</div>
@endsection