@extends('layouts.app')

@section('title', 'Open Library - Koleksi eBook Gratis')

@section('content')
<div class="home-view">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title mb-0">🔥 Buku Trending</h2>
        
        <!-- Time Range Filter -->
        <div class="trending-filters">
            <a href="/?range=week" class="filter-btn {{ $currentRange == 'week' ? 'active' : '' }}">
                📅 1 Minggu
            </a>
            <a href="/?range=month" class="filter-btn {{ $currentRange == 'month' ? 'active' : '' }}">
                📅 1 Bulan
            </a>
            <a href="/?range=year" class="filter-btn {{ $currentRange == 'year' ? 'active' : '' }}">
                📅 1 Tahun
            </a>
        </div>
    </div>

    @if($error)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ $error }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(count($trendingBooks) > 0)
        <div class="book-grid">
            @foreach($trendingBooks as $index => $book)
                <div class="book-card" onclick="window.location='{{ route('buku.show', $book->book_identifier) }}'">
                    <div class="book-cover">
                        @if($book->book_cover)
                            <img src="{{ $book->book_cover }}" 
                                 alt="{{ $book->book_title }}"
                                 onerror="this.parentElement.innerHTML='📖'">
                        @else
                            📖
                        @endif
                        
                        <!-- Ranking Badge -->
                        <div class="ranking-badge">
                            🔥 #{{ $index + 1 }}
                        </div>
                    </div>
                    <div class="book-info">
                        <div class="book-title">{{ $book->book_title }}</div>
                        <div class="book-author text-muted">
                            {{ $book->book_author ?? 'Unknown' }}
                        </div>
                        <div class="book-stats mt-2">
                            <small class="text-muted">
                                👁️ {{ $book->total_views }} views
                            </small>
                            <small class="text-muted ms-2">
                                👤 {{ $book->unique_readers }} readers
                            </small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <div class="no-results-icon">🔭</div>
            <h3 class="text-muted">Belum Ada Buku Trending</h3>
            <p class="text-muted">
                @auth
                    Jadilah yang pertama membaca dan membuat buku trending!
                @else
                    <a href="{{ route('login') }}">Login</a> untuk mulai membaca dan lihat statistik trending.
                @endauth
            </p>
            <a href="{{ route('search') }}" class="btn btn-primary mt-3">
                🔍 Cari Buku
            </a>
        </div>
    @endif
</div>
@endsection