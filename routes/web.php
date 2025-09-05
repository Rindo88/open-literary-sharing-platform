<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\BookController;
use App\Http\Controllers\Web\AdminCategoryController;

Route::get('/', function () {
    return redirect()->route('login');
})->name('welcome');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Google OAuth routes
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');

// Public book routes
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{slug}', [BookController::class, 'show'])->name('books.show');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Web\DashboardController::class, 'index'])->name('dashboard');
    
    // Profile routes - PERBAIKAN: Pisahkan route delete photo
    Route::get('/profile', [App\Http\Controllers\Web\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [App\Http\Controllers\Web\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\Web\ProfileController::class, 'update'])->name('profile.update');
    
    // Password routes
    Route::get('/profile/change-password', [App\Http\Controllers\Web\ProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::put('/profile/change-password', [App\Http\Controllers\Web\ProfileController::class, 'updatePassword'])->name('profile.update-password');
    
    // Photo delete route
    Route::delete('/profile/photo', [App\Http\Controllers\Web\ProfileController::class, 'deletePhoto'])->name('profile.delete-photo');
    
    // Book management routes
    Route::get('/my-books', [BookController::class, 'myBooks'])->name('books.my-books');
    Route::post('/books/{book}/start-reading', [BookController::class, 'startReading'])->name('books.start-reading');
    Route::post('/books/{book}/wishlist', [BookController::class, 'addToWishlist'])->name('books.add-to-wishlist');
    Route::delete('/books/{book}/wishlist', [BookController::class, 'removeFromWishlist'])->name('books.remove-from-wishlist');
    Route::post('/books/{book}/rate', [BookController::class, 'rateBook'])->name('books.rate');
    Route::post('/books/{book}/bookmark', [BookController::class, 'bookmarkBook'])->name('books.bookmark');
    
    
    // E-book reader routes
    Route::get('/books/{slug}/read', [App\Http\Controllers\Web\BookReaderController::class, 'show'])->name('books.read');
    Route::post('/books/{slug}/progress', [App\Http\Controllers\Web\BookReaderController::class, 'updateProgress'])->name('books.update-progress');
    Route::post('/books/{slug}/finish-reading', [App\Http\Controllers\Web\BookReaderController::class, 'finishReading'])->name('books.finish-reading');
    Route::get('/books/{slug}/download', [App\Http\Controllers\Web\BookReaderController::class, 'getFile'])->name('books.download');
    Route::get('/books/{slug}/stream', [App\Http\Controllers\Web\BookReaderController::class, 'streamFile'])->name('books.stream');

    // Diskusi routes
    Route::get('/discussions', [App\Http\Controllers\Web\DiscussionController::class, 'index'])->name('discussions.index');
    Route::get('/discussions/{book}', [App\Http\Controllers\Web\DiscussionController::class, 'show'])->name('discussions.show');
    Route::get('/discussions/{book}/create', [App\Http\Controllers\Web\DiscussionController::class, 'create'])->name('discussions.create');
    Route::post('/discussions/{book}', [App\Http\Controllers\Web\DiscussionController::class, 'store'])->name('discussions.store');
    Route::post('/discussions/{book}/{discussion}/join', [App\Http\Controllers\Web\DiscussionController::class, 'join'])->name('discussions.join');
    Route::post('/discussions/{book}/{discussion}/leave', [App\Http\Controllers\Web\DiscussionController::class, 'leave'])->name('discussions.leave');
    Route::post('/discussions/{book}/{discussion}/messages', [App\Http\Controllers\Web\DiscussionController::class, 'storeMessage'])->name('discussions.messages.store');
    Route::get('/discussions/{book}/{discussion}/chat', [App\Http\Controllers\Web\DiscussionController::class, 'chat'])->name('discussions.chat');

    // Book discussion routes
    Route::get('/books/{book}/discussions', [App\Http\Controllers\Web\BookDiscussionController::class, 'index'])->name('books.discussions.index');
    Route::get('/books/{book}/discussions/create', [App\Http\Controllers\Web\BookDiscussionController::class, 'create'])->name('books.discussions.create');
    Route::post('/books/{book}/discussions', [App\Http\Controllers\Web\BookDiscussionController::class, 'store'])->name('books.discussions.store');
    Route::get('/books/{book}/discussions/{discussion}', [App\Http\Controllers\Web\BookDiscussionController::class, 'show'])->name('books.discussions.show');
    Route::post('/books/{book}/discussions/{discussion}/messages', [App\Http\Controllers\Web\BookDiscussionController::class, 'storeMessage'])->name('books.discussions.messages.store');
    Route::post('/books/{book}/discussions/{discussion}/join', [App\Http\Controllers\Web\BookDiscussionController::class, 'join'])->name('books.discussions.join');
    Route::post('/books/{book}/discussions/{discussion}/leave', [App\Http\Controllers\Web\BookDiscussionController::class, 'leave'])->name('books.discussions.leave');

    // Admin routes
    Route::prefix('admin')->middleware('admin')->group(function () {
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
});

// Test route for admin login
Route::get('/test-admin-login', function () {
    if (auth()->attempt(['email' => 'admin@perpustakaan.com', 'password' => 'admin123'])) {
        return response()->json([
            'success' => true,
            'message' => 'Admin login successful',
            'user' => [
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'role' => auth()->user()->role
            ]
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Admin login failed'
        ]);
    }
});

// Test routes for popup notifications
Route::get('/test-notifications', function () {
    return redirect()->route('books.index')->with('success', 'Ini adalah notifikasi sukses untuk menguji popup!');
});

Route::get('/test-error-notifications', function () {
    return redirect()->route('books.index')->with('error', 'Ini adalah notifikasi error untuk menguji popup!');
});