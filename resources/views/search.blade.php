@extends('layouts.app')

@section('title', 'Hasil Pencarian - ' . $query)

@section('content')
<div class="search-view">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title mb-0">
            Hasil Pencarian untuk "{{ $query }}" 
            @if($total > 0)
                <span class="badge bg-primary">{{ $total }}</span>
            @endif
        </h2>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
            ← Kembali
        </a>
    </div>

    @if($error)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ $error }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(count($books) > 0)
        <div class="book-grid">
            @foreach($books as $book)
                <div class="book-card" onclick="window.location='{{ route('buku.show', $book['identifier']) }}'">
                    <div class="book-cover">
                        @if(isset($book['identifier']))
                            <img src="https://archive.org/services/img/{{ $book['identifier'] }}" 
                                 alt="{{ $book['title'] ?? 'Book cover' }}"
                                 onerror="this.parentElement.innerHTML='📖'">
                        @else
                            📖
                        @endif
                    </div>
                    <div class="book-info">
                        <div class="book-title">{{ $book['title'] ?? 'Tidak ada judul' }}</div>
                        <div class="book-author text-muted">
                            {{ is_array($book['creator'] ?? null) ? implode(', ', $book['creator']) : ($book['creator'] ?? 'Unknown') }}
                        </div>
                        @if(isset($book['year']))
                            <small class="text-muted d-block mt-1">{{ $book['year'] }}</small>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <div class="no-results-icon">🔭</div>
            <h3 class="text-muted">Tidak ada hasil ditemukan</h3>
            <p class="text-muted">Coba kata kunci lain atau periksa ejaan Anda</p>
            <a href="{{ route('home') }}" class="btn btn-primary mt-3">
                Kembali ke Beranda
            </a>
        </div>
    @endif
</div>
@endsection