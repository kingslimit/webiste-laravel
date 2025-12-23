@extends('layouts.app')

@section('title', 'Riwayat Bacaan - Open Library')

@section('content')
<div class="animate-fade-in">
    <!-- Header with Clear All Button -->
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
               <img src="{{ asset('image/buku2.png') }}" alt="buku" style="height: 28px; width: 28px;">
            <span>Riwayat Bacaan Saya</span>
        </h2>
        
        @if($total > 0)
            <form action="{{ route('history.clear') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus semua riwayat?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="flex items-center gap-2 bg-red-50 text-red-600 px-4 py-2 rounded-lg font-semibold border border-red-200 hover:bg-red-100 transition-colors">
                    
                    <span>Hapus Semua</span>
                </button>
            </form>
        @endif
    </div>

    @if($total > 0)
        <!-- Total Count -->
        <p class="text-gray-600 mb-6">
            Total: <strong class="text-gray-800">{{ $total }}</strong> buku
        </p>

        <!-- Book Grid -->
        <div class="book-grid">
            @foreach($history as $item)
                <div class="group relative bg-white rounded-xl shadow-md overflow-hidden hover:-translate-y-2 hover:shadow-xl transition-all duration-300">
                    <!-- Remove Button -->
                    <form action="{{ route('history.destroy', $item->id) }}" method="POST" class="absolute top-3 left-3 z-10 opacity-0 group-hover:opacity-100 transition-opacity">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-8 h-8 flex items-center justify-center bg-red-500 text-white rounded-full hover:bg-red-600 shadow-lg transition-colors" 
                                onclick="return confirm('Hapus dari riwayat?')">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </form>

                    <!-- Book Card (clickable) -->
                    <div onclick="window.location='{{ route('buku.show', $item->book_identifier) }}'" class="cursor-pointer">
                        <!-- Book Cover -->
                        <div class="relative">
                            @if($item->book_cover)
                                <img src="{{ $item->book_cover }}" 
                                     alt="{{ $item->book_title }}"
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
                                {{ $item->book_title }}
                            </h5>
                            <p class="text-gray-600 text-sm mb-3 truncate">
                                {{ $item->book_author ?? 'Unknown' }}
                            </p>
                            <small class="flex items-center gap-1 text-gray-500 text-xs">
                                 <img src="{{ asset('image/mata.png') }}" alt="buku" style="height: 28px; width: 28px;">
                                <span>{{ $item->accessed_at->diffForHumans() }}</span>
                            </small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $history->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="text-6xl opacity-50 mb-4">  <img src="{{ asset('image/teleskop.png') }}" alt="buku" style="height: 28px; width: 28px;"></div>
            <h3 class="text-2xl font-semibold text-gray-600 mb-2">Riwayat Bacaan Kosong</h3>
            <p class="text-gray-500 mb-6">Belum ada buku yang Anda baca. Mulai jelajahi koleksi kami!</p>
            <a href="{{ route('home') }}" class="inline-flex bg-primary-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-600 transition-colors">
                   <img src="{{ asset('image/search.png') }}" alt="buku" style="height: 28px; width: 28px;"> Jelajahi Buku
            </a>
        </div>
    @endif
</div>
@endsection