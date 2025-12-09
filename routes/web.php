<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HistoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes (accessible by everyone)
Route::get('/', [BookController::class, 'index'])->name('home');
Route::get('/search', [BookController::class, 'search'])->name('search');
Route::get('/buku/{id}', [BookController::class, 'show'])->name('buku.show');

// Guest Routes (only accessible when not logged in)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Routes (only accessible when logged in)
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Profile
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [AuthController::class, 'changePassword'])->name('profile.password');
    
    // Reading History
    Route::get('/history', [HistoryController::class, 'index'])->name('history');
    Route::delete('/history/{id}', [HistoryController::class, 'destroy'])->name('history.destroy');
    Route::delete('/history', [HistoryController::class, 'clear'])->name('history.clear');
});