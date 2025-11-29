<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\BookController;
use App\Http\Controllers\Web\AdminCategoryController;
use App\Http\Controllers\Web\AuthorController;

// Authentication routes - TANPA middleware guest
require __DIR__ . '/auth.php';

// Public book routes - accessible
Route::get('/', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{slug}', [BookController::class, 'show'])->name('books.show');

// Author profile route - lebih spesifik
Route::get('/author/{id}', [AuthorController::class, 'show'])->name('author.show');
Route::get('/authors/create', [AuthorController::class, 'create'])->name('author.create');
Route::post('authors/create', [AuthorController::class, 'store'])->name('author.store');


// Protected routes - HANYA untuk user yang login
Route::middleware('auth')->group(function () {
    // Logout harus dalam middleware auth
    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [App\Http\Controllers\Web\DashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::prefix('profile')->group(function () {
        Route::get('/', [App\Http\Controllers\Web\ProfileController::class, 'show'])->name('profile.show');
        Route::get('/edit', [App\Http\Controllers\Web\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/', [App\Http\Controllers\Web\ProfileController::class, 'updat'])->name('profile.update');

        // Password routes
        Route::get('/change-password', [App\Http\Controllers\Web\ProfileController::class, 'changePassword'])->name('profile.change-password');
        Route::put('/change-password', [App\Http\Controllers\Web\ProfileController::class, 'updatePassword'])->name('profile.update-password');

        // Photo delete route
        Route::delete('/photo', [App\Http\Controllers\Web\ProfileController::class, 'deletePhoto'])->name('profile.delete-photo');
    });

    // Book management routes - SEMUA dalam prefix yang sama
    Route::prefix('books')->group(function () {
        Route::get('/my-books', [BookController::class, 'myBooks'])->name('books.my-books');
        Route::post('/{book}/start-reading', [BookController::class, 'startReading'])->name('books.start-reading');
        Route::post('/{book}/wishlist', [BookController::class, 'addToWishlist'])->name('books.add-to-wishlist');
        Route::delete('/{book}/wishlist', [BookController::class, 'removeFromWishlist'])->name('books.remove-from-wishlist');
        Route::post('/{book}/rate', [BookController::class, 'rateBook'])->name('books.rate');
        Route::post('/{book}/bookmark', [BookController::class, 'bookmarkBook'])->name('books.bookmark');

        // E-book reader routes
        Route::get('/{slug}/read', [App\Http\Controllers\Web\BookReaderController::class, 'show'])->name('books.read');
        Route::post('/{slug}/progress', [App\Http\Controllers\Web\BookReaderController::class, 'updateProgress'])->name('books.update-progress');
        Route::post('/{slug}/finish-reading', [App\Http\Controllers\Web\BookReaderController::class, 'finishReading'])->name('books.finish-reading');
        Route::get('/{slug}/download', [App\Http\Controllers\Web\BookReaderController::class, 'getFile'])->name('books.download');
        Route::get('/{slug}/stream', [App\Http\Controllers\Web\BookReaderController::class, 'streamFile'])->name('books.stream');
    });

    // Diskusi routes
    Route::prefix('discussions')->group(function () {
        Route::get('/', [App\Http\Controllers\Web\DiscussionController::class, 'index'])->name('discussions.index');
        Route::get('/{book}', [App\Http\Controllers\Web\DiscussionController::class, 'show'])->name('discussions.show');
        Route::get('/{book}/create', [App\Http\Controllers\Web\DiscussionController::class, 'create'])->name('discussions.create');
        Route::post('/{book}', [App\Http\Controllers\Web\DiscussionController::class, 'store'])->name('discussions.store');
        Route::post('/{book}/{discussion}/join', [App\Http\Controllers\Web\DiscussionController::class, 'join'])->name('discussions.join');
        Route::post('/{book}/{discussion}/leave', [App\Http\Controllers\Web\DiscussionController::class, 'leave'])->name('discussions.leave');
        Route::post('/{book}/{discussion}/messages', [App\Http\Controllers\Web\DiscussionController::class, 'storeMessage'])->name('discussions.messages.store');
        Route::get('/{book}/{discussion}/chat', [App\Http\Controllers\Web\DiscussionController::class, 'chat'])->name('discussions.chat');
    });

    // Author profile management - untuk user yang login
    Route::prefix('authors')->middleware('profile.author')->group(function () {
        Route::get('/profile', [AuthorController::class, 'index'])->name('authors.profile');
        Route::get('/', [AuthorController::class, 'dashboard'])->name('authors.dashboard');
        Route::get('/books', [AuthorController::class, 'manageBooks'])->name('authors.books.index');
        Route::post('/books/create', [AuthorController::class, 'storeBook'])->name('authors.books.store');
        Route::get('/books/create', [AuthorController::class, 'createBook'])->name('authors.books.create');
        Route::get('/books/{book}/edit', [AuthorController::class, 'editBook'])->name('authors.books.edit');
        Route::put('/books/{book}', [AuthorController::class, 'updateBook'])->name('authors.books.update');
        Route::delete('/books/{book}', [AuthorController::class, 'destroyBook'])->name('authors.books.destroy');
        Route::get('/reports', [AuthorController::class, 'reports'])->name('authors.reports.index');
    });
});

// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/books', [AdminController::class, 'manageBooks'])->name('admin.books.index');
    Route::get('/books/create', [AdminController::class, 'createBook'])->name('admin.books.create');
    Route::post('/books', [AdminController::class, 'storeBook'])->name('admin.books.store');
    Route::get('/books/{book}/edit', [AdminController::class, 'editBook'])->name('admin.books.edit');
    Route::put('/books/{book}', [AdminController::class, 'updateBook'])->name('admin.books.update');
    Route::delete('/books/{book}', [AdminController::class, 'destroyBook'])->name('admin.books.destroy');
    Route::get('/users', [AdminController::class, 'manageUsers'])->name('admin.users.index');
    Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports.index');

    // Categories routes
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('admin.categories.index');
    Route::get('/categories/create', [AdminCategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('/categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.destroy');
});
