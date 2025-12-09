@extends('layouts.app')

@section('title', 'Riwayat Bacaan - Open Library')

@section('content')
<div class="history-view">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title mb-0">📖 Riwayat Bacaan Saya</h2>
        
        @if($total > 0)
            <form action="{{ route('history.clear') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus semua riwayat?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger btn-sm">
                    🗑️ Hapus Semua
                </button>
            </form>
        @endif
    </div>

    @if($total > 0)
        <p class="text-muted mb-4">Total: {{ $total }} buku</p>

        <div class="book-grid">
            @foreach($history as $item)
                <div class="book-card position-relative">
                    <!-- Remove Button -->
                    <form action="{{ route('history.destroy', $item->id) }}" method="POST" class="remove-history-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger remove-btn" onclick="return confirm('Hapus dari riwayat?')">
                            ✕
                        </button>
                    </form>

                    <!-- Book Card (clickable) -->
                    <div onclick="window.location='{{ route('buku.show', $item->book_identifier) }}'">
                        <div class="book-cover">
                            @if($item->book_cover)
                                <img src="{{ $item->book_cover }}" 
                                     alt="{{ $item->book_title }}"
                                     onerror="this.parentElement.innerHTML='📖'">
                            @else
                                📖
                            @endif
                        </div>
                        <div class="book-info">
                            <div class="book-title">{{ $item->book_title }}</div>
                            <div class="book-author text-muted">
                                {{ $item->book_author ?? 'Unknown' }}
                            </div>
                            <small class="text-muted d-block mt-2">
                                👁️ {{ $item->accessed_at->diffForHumans() }}
                            </small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $history->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <div class="no-results-icon">📭</div>
            <h3 class="text-muted">Riwayat Bacaan Kosong</h3>
            <p class="text-muted">Belum ada buku yang Anda baca. Mulai jelajahi koleksi kami!</p>
            <a href="{{ route('home') }}" class="btn btn-primary mt-3">
                🔍 Jelajahi Buku
            </a>
        </div>
    @endif
</div>
@endsection