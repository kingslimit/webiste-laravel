@extends('layouts.app')

@section('title', 'Register - Open Library')

@section('content')
<div class="auth-container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="auth-card card shadow-sm">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold">📚 Daftar Akun</h2>
                        <p class="text-muted">Mulai petualangan membaca Anda!</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input 
                                type="text" 
                                class="form-control @error('name') is-invalid @enderror" 
                                id="name" 
                                name="name" 
                                value="{{ old('name') }}"
                                placeholder="John Doe"
                                required
                                autofocus
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
                                value="{{ old('email') }}"
                                placeholder="nama@email.com"
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input 
                                type="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                id="password" 
                                name="password"
                                placeholder="Minimal 8 karakter"
                                required
                            >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input 
                                type="password" 
                                class="form-control" 
                                id="password_confirmation" 
                                name="password_confirmation"
                                placeholder="Ketik ulang password"
                                required
                            >
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                            Daftar
                        </button>

                        <div class="text-center">
                            <p class="text-muted mb-0">
                                Sudah punya akun? 
                                <a href="{{ route('login') }}" class="text-decoration-none fw-bold">
                                    Login di sini
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection@extends('layouts.app')

@section('title', 'Register - Open Library')

@section('content')
<div class="auth-container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="auth-card card shadow-sm">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold">📚 Daftar Akun</h2>
                        <p class="text-muted">Mulai petualangan membaca Anda!</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input 
                                type="text" 
                                class="form-control @error('name') is-invalid @enderror" 
                                id="name" 
                                name="name" 
                                value="{{ old('name') }}"
                                placeholder="John Doe"
                                required
                                autofocus
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
                                value="{{ old('email') }}"
                                placeholder="nama@email.com"
                                required
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input 
                                type="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                id="password" 
                                name="password"
                                placeholder="Minimal 8 karakter"
                                required
                            >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input 
                                type="password" 
                                class="form-control" 
                                id="password_confirmation" 
                                name="password_confirmation"
                                placeholder="Ketik ulang password"
                                required
                            >
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                            Daftar
                        </button>

                        <div class="text-center">
                            <p class="text-muted mb-0">
                                Sudah punya akun? 
                                <a href="{{ route('login') }}" class="text-decoration-none fw-bold">
                                    Login di sini
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection