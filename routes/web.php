<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamController;
use App\Http\Controllers\TransaksiController;

// Welcome page - redirect ke login jika belum login
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Protected Routes (memerlukan authentication)
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Buku Management
    Route::resource('buku', BukuController::class);
    
    // Peminjam Management  
    Route::resource('peminjam', PeminjamController::class);
    
    // Transaksi Management
    Route::resource('transaksi', TransaksiController::class);
    Route::patch('/transaksi/{transaksi}/kembalikan', [TransaksiController::class, 'kembalikan'])
        ->name('transaksi.kembalikan');
});
