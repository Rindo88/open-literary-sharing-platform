<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Di sini Anda dapat mendaftarkan rute API untuk aplikasi Anda. Rute-rute
| ini dimuat oleh RouteServiceProvider dan semuanya akan
| ditugaskan ke grup middleware "api".
|
*/

// =========================================================================
// RUTE PUBLIK (Tidak Perlu Login)
// =========================================================================

// --- Autentikasi ---
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// --- Google OAuth ---
Route::get('/auth/google/redirect', [AuthController::class, 'redirectToGoogle'])->name('api.google.redirect');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('api.google.callback');

// --- Data Buku & Kategori ---
Route::get('/books', [BookController::class, 'index']);
Route::get('/books/{book:slug}', [BookController::class, 'show']); // Menggunakan slug untuk URL yang lebih ramah SEO
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category:slug}', [CategoryController::class, 'show']);


// =========================================================================
// RUTE TERPROTEKSI (Wajib Login / Membutuhkan Token)
// =========================================================================

Route::middleware('auth:sanctum')->group(function () {
    
    // --- Autentikasi ---
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // --- Profil & Rak Buku Pengguna ---
    Route::get('/user/profile', [UserController::class, 'profile']);
    Route::get('/user/my-books', [UserController::class, 'myBooks']);
    
    // --- Interaksi Pengguna dengan Buku ---
    Route::post('/books/{book}/start-reading', [UserController::class, 'startReading']);
    Route::post('/books/{book}/wishlist', [UserController::class, 'toggleWishlist']);
    Route::post('/books/{book}/rate', [UserController::class, 'rateBook']);

    // --- Rute untuk Admin/Pustakawan ---
    // Catatan: Idealnya, rute ini harus dilindungi lebih lanjut dengan middleware khusus admin.
    // Contoh: ->middleware('is_admin')
    Route::post('/admin/books', [BookController::class, 'store'])->name('api.admin.books.store');
    Route::put('/admin/books/{book}', [BookController::class, 'update'])->name('api.admin.books.update');
    Route::delete('/admin/books/{book}', [BookController::class, 'destroy'])->name('api.admin.books.destroy');
    
});