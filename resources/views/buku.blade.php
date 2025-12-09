@extends('layouts.app')

@section('title', isset($book) ? $book['title'] . ' - Open Library' : 'Buku Tidak Ditemukan')

@section('content')
<div class="detail-container">
    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mb-4">
        ← Kembali
    </a>

    @if($error)
        <div class="alert alert-danger">
            <h4 class="alert-heading">Error!</h4>
            <p>{{ $error }}</p>
            <hr>
            <a href="{{ route('home') }}" class="btn btn-primary">Kembali ke Beranda</a>
        </div>
    @elseif($book)
        <div class="book-detail card shadow-sm">
            <div class="card-body">
                <div class="detail-content row">
                    <div class="col-md-4 mb-4 mb-md-0">
                        <div class="detail-cover">
                            <img src="{{ $book['cover'] }}" 
                                 alt="{{ $book['title'] }}"
                                 onerror="this.parentElement.innerHTML='<div class=\'placeholder-cover\'>📖</div>'">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="detail-info">
                            <h2 class="mb-3">{{ $book['title'] }}</h2>
                            
                            <div class="detail-meta mb-4">
                                <p class="mb-2">
                                    <strong>Penulis:</strong> 
                                    <span class="text-muted">{{ $book['creator'] }}</span>
                                </p>
                                <p class="mb-2">
                                    <strong>Tahun Terbit:</strong> 
                                    <span class="text-muted">{{ $book['year'] }}</span>
                                </p>
                                <p class="mb-2">
                                    <strong>Penerbit:</strong> 
                                    <span class="text-muted">{{ $book['publisher'] }}</span>
                                </p>
                                <p class="mb-2">
                                    <strong>Bahasa:</strong> 
                                    <span class="text-muted">{{ $book['language'] }}</span>
                                </p>
                                @if($book['downloads'] > 0)
                                    <p class="mb-2">
                                        <strong>Total Unduhan:</strong> 
                                        <span class="badge bg-success">{{ number_format($book['downloads']) }}</span>
                                    </p>
                                @endif
                            </div>

                            <div class="detail-description mb-4">
                                <h5 class="mb-3">Deskripsi</h5>
                                <p class="text-muted">{{ $book['description'] }}</p>
                            </div>

                            <div class="detail-actions d-flex gap-2 flex-wrap">
                                <a href="{{ $book['download_link'] }}" 
                                   target="_blank" 
                                   class="btn btn-primary btn-lg">
                                    ⬇️ Download Buku
                                </a>
                                <a href="{{ $book['detail_link'] }}" 
                                   target="_blank" 
                                   class="btn btn-outline-secondary btn-lg">
                                    🔗 Lihat di Internet Archive
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection