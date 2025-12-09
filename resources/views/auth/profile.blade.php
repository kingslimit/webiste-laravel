@extends('layouts.app')

@section('title', 'Profile - Open Library')

@section('content')
<div class="profile-view">
    <h2 class="section-title mb-4">👤 Profile Saya</h2>

    <div class="row">
        <!-- Update Profile -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">📝 Update Profile</h5>

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input 
                                type="text" 
                                class="form-control @error('name') is-invalid @enderror" 
                                id="name" 
                                name="name" 
                                value="{{ old('name', Auth::user()->name) }}"
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input 
                                type="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                id="email" 
                                name="email" 
                                value="{{ old('email', Auth::user()->email) }}"
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            💾 Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Change Password -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4">🔒 Ubah Password</h5>

                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Password Saat Ini</label>
                            <input 
                                type="password" 
                                class="form-control @error('current_password') is-invalid @enderror" 
                                id="current_password" 
                                name="current_password"
                                required
                            >
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password Baru</label>
                            <input 
                                type="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                id="password" 
                                name="password"
                                required
                            >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input 
                                type="password" 
                                class="form-control" 
                                id="password_confirmation" 
                                name="password_confirmation"
                                required
                            >
                        </div>

                        <button type="submit" class="btn btn-primary">
                            🔒 Ubah Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Reading Stats -->
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title mb-4">📊 Statistik Bacaan</h5>
            
            <div class="row text-center">
                <div class="col-md-4">
                    <div class="stat-box">
                        <h2 class="text-primary">{{ Auth::user()->readingHistory()->count() }}</h2>
                        <p class="text-muted mb-0">Total Buku Dibaca</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-box">
                        <h2 class="text-success">{{ Auth::user()->readingHistory()->where('accessed_at', '>=', now()->subDays(30))->count() }}</h2>
                        <p class="text-muted mb-0">Bulan Ini</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stat-box">
                        <h2 class="text-info">{{ Auth::user()->readingHistory()->where('accessed_at', '>=', now()->subDays(7))->count() }}</h2>
                        <p class="text-muted mb-0">Minggu Ini</p>
                    </div>
                </div>
            </div>

            <div class="mt-4 text-center">
                <a href="{{ route('history') }}" class="btn btn-outline-primary">
                    📖 Lihat Riwayat Lengkap
                </a>
            </div>
        </div>
    </div>
</div>
@endsection