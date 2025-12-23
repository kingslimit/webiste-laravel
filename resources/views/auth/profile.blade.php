@extends('layouts.app')

@section('title', 'Profile - Open Library')

@section('content')
<div class="animate-fade-in">
    <h2 class="text-3xl font-bold text-gray-800 mb-8 flex items-center gap-2">
         <img src="{{ asset('image/profil.png') }}" alt="profil" style="height: 25px; width: 25px;">
        <span>Profile Saya</span>
    </h2>

    <div class="grid md:grid-cols-2 gap-6 mb-8">
        <!-- Update Profile Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6">
                <h5 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                     <img src="{{ asset('image/Updateprofile.png') }}" alt="updateprofil" style="height: 28px; width: 28px;">
                    <span>Update Profile</span>
                </h5>

                <form action="{{ route('profile.update') }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama
                        </label>
                        <input 
                            type="text" 
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-primary-500 focus:ring-4 focus:ring-primary-500 focus:ring-opacity-20 outline-none transition-all @error('name') border-red-500 @enderror" 
                            id="name" 
                            name="name" 
                            value="{{ old('name', Auth::user()->name) }}"
                            required
                        >
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email
                        </label>
                        <input 
                            type="email" 
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-primary-500 focus:ring-4 focus:ring-primary-500 focus:ring-opacity-20 outline-none transition-all @error('email') border-red-500 @enderror" 
                            id="email" 
                            name="email" 
                            value="{{ old('email', Auth::user()->email) }}"
                            required
                        >
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="flex items-center gap-2 bg-primary-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-600 hover:-translate-y-0.5 active:translate-y-0 transition-all shadow-md">
                      
                        <span>Simpan Perubahan</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Change Password Card -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6">
                <h5 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                     <img src="{{ asset('image/gembok2.png') }}" alt="gembok" style="height: 28px; width: 28px;">
                    <span>Ubah Password</span>
                </h5>

                <form action="{{ route('profile.password') }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <!-- Current Password -->
                    <div>
                        <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Password Saat Ini
                        </label>
                        <input 
                            type="password" 
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-primary-500 focus:ring-4 focus:ring-primary-500 focus:ring-opacity-20 outline-none transition-all @error('current_password') border-red-500 @enderror" 
                            id="current_password" 
                            name="current_password"
                            required
                        >
                        @error('current_password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Password Baru
                        </label>
                        <input 
                            type="password" 
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-primary-500 focus:ring-4 focus:ring-primary-500 focus:ring-opacity-20 outline-none transition-all @error('password') border-red-500 @enderror" 
                            id="password" 
                            name="password"
                            required
                        >
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                            Konfirmasi Password Baru
                        </label>
                        <input 
                            type="password" 
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-primary-500 focus:ring-4 focus:ring-primary-500 focus:ring-opacity-20 outline-none transition-all" 
                            id="password_confirmation" 
                            name="password_confirmation"
                            required
                        >
                    </div>

                    <button type="submit" class="flex items-center gap-2 bg-primary-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-600 hover:-translate-y-0.5 active:translate-y-0 transition-all shadow-md">
                      
                        <span>Ubah Password</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Reading Stats Card -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-6">
            <h5 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
               <img src="{{ asset('image/batang.png') }}" alt="batang" style="height: 28px; width: 28px;">
                <span>Statistik Bacaan</span>
            </h5>
            
            <div class="grid md:grid-cols-3 gap-6 mb-6">
                <!-- Total Books -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-xl text-center">
                    <h2 class="text-4xl font-bold text-primary-500 mb-2">
                        {{ Auth::user()->readingHistory()->count() }}
                    </h2>
                    <p class="text-gray-700 font-medium">Total Buku Dibaca</p>
                </div>
                
                <!-- This Month -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-xl text-center">
                    <h2 class="text-4xl font-bold text-green-600 mb-2">
                        {{ Auth::user()->readingHistory()->where('accessed_at', '>=', now()->subDays(30))->count() }}
                    </h2>
                    <p class="text-gray-700 font-medium">Bulan Ini</p>
                </div>
                
                <!-- This Week -->
                <div class="bg-gradient-to-br from-cyan-50 to-cyan-100 p-6 rounded-xl text-center">
                    <h2 class="text-4xl font-bold text-cyan-600 mb-2">
                        {{ Auth::user()->readingHistory()->where('accessed_at', '>=', now()->subDays(7))->count() }}
                    </h2>
                    <p class="text-gray-700 font-medium">Minggu Ini</p>
                </div>
            </div>

            <div class="text-center">
                <a href="{{ route('history') }}" class="inline-flex items-center gap-2 bg-white border-2 border-primary-500 text-primary-500 px-6 py-3 rounded-lg font-semibold hover:bg-primary-50 transition-colors">
                     <img src="{{ asset('image/buku2.png') }}" alt="buku" style="height: 28px; width: 28px;">
                    <span>Lihat Riwayat Lengkap</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection