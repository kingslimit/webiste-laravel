@extends('layouts.app')

@section('title', 'Login - Open Library')

@section('content')
<div class="auth-container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="auth-card card shadow-sm">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold">📚 Login</h2>
                        <p class="text-muted">Selamat datang kembali!</p>
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

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        
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
                                autofocus
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
                                placeholder="Masukkan password"
                                required
                            >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input 
                                type="checkbox" 
                                class="form-check-input" 
                                id="remember" 
                                name="remember"
                            >
                            <label class="form-check-label" for="remember">
                                Ingat saya
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                            Login
                        </button>

                        <div class="text-center">
                            <p class="text-muted mb-0">
                                Belum punya akun? 
                                <a href="{{ route('register') }}" class="text-decoration-none fw-bold">
                                    Daftar sekarang
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