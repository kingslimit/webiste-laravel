@extends('layouts.app')

@section('title', isset($book) ? $book['title'] . '' : 'Buku Tidak Ditemukan')

@section('content')
<div class="animate-fade-in">
    <!-- Back Button -->
    <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 mb-6 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span class="font-medium">Kembali</span>
    </a>

    @if($error)
        <!-- Error State -->
        <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-6 shadow-md">
            <div class="flex items-start gap-4">
                <img src="{{ asset('image/silang.png') }}" alt="buku" style="height: 28px; width: 28px;">
                <div class="flex-1">
                    <h4 class="text-xl font-bold text-red-900 mb-2">Error!</h4>
                    <p class="text-red-800 mb-4">{{ $error }}</p>
                    <a href="{{ route('home') }}" class="inline-block bg-primary-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-primary-600 transition-colors">
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    @elseif($book)
        <!-- Book Detail Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-6 md:p-8">
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Book Cover -->
                    <div class="md:col-span-1">
                        <div class="rounded-lg overflow-hidden shadow-xl">
                            @if($book['cover'])
                                <img src="{{ $book['cover'] }}" 
                                     alt="{{ $book['title'] }}"
                                     class="w-full h-[500px] object-cover"
                                     onerror="this.parentElement.innerHTML='<div class=\'w-full h-[500px] bg-gradient-to-br from-primary-500 to-secondary-500 flex items-center justify-center text-white text-7xl\'>Buku </div>'">
                            @else
                                <div class="w-full h-[500px] bg-gradient-to-br from-primary-500 to-secondary-500 flex items-center justify-center text-white text-7xl">
                                       <img src="{{ asset('image/buku2.png') }}" alt="buku" style="height: 28px; width: 28px;">
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Book Info -->
                    <div class="md:col-span-2">
                        <h2 class="text-3xl font-bold text-gray-800 mb-6">{{ $book['title'] }}</h2>
                        
                        <!-- Meta Information -->
                        <div class="space-y-3 mb-6">
                            <div class="flex items-start gap-3">
                                <span class="text-gray-600 font-semibold min-w-[120px]">Penulis:</span>
                                <span class="text-gray-700">{{ $book['creator'] }}</span>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="text-gray-600 font-semibold min-w-[120px]">Tahun Terbit:</span>
                                <span class="text-gray-700">{{ $book['year'] }}</span>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="text-gray-600 font-semibold min-w-[120px]">Penerbit:</span>
                                <span class="text-gray-700">{{ $book['publisher'] }}</span>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="text-gray-600 font-semibold min-w-[120px]">Bahasa:</span>
                                <span class="text-gray-700">{{ $book['language'] }}</span>
                            </div>
                       
                        </div>

                        <!-- Description -->
                        <div class="mb-8">
                            <h5 class="text-xl font-semibold text-gray-800 mb-3">Deskripsi</h5>
                            <div class="text-gray-600 leading-relaxed whitespace-pre-line">
                                 {{ strip_tags(str_replace(['<br />', '<br/>', '<br>', '</div><div>', '</div>'], ["\n", "\n", "\n", "\n\n", "\n"], $book['description'])) }}
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-wrap gap-3">
                            
                            <a href="{{ route('buku.download', $book['identifier']) }}" 
                               target="_blank" 
                               class="inline-flex items-center gap-2 bg-primary-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-600 hover:-translate-y-0.5 active:translate-y-0 transition-all shadow-md hover:shadow-lg">
                               
                                <span>Download Buku</span>
                            </a>
                           
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection