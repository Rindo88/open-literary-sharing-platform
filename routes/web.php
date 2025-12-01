    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\AdminController;
    use App\Http\Controllers\AuthController;
    use App\Http\Controllers\AdminCategoryController;
    use App\Http\Controllers\AuthorController;
    use App\Http\Controllers\BookController;
    use App\Http\Controllers\BookReaderController;
    use App\Http\Controllers\DashboardController;
    use App\Http\Controllers\DiscussionController;
    use App\Http\Controllers\ProfileController;

    // Authentication routes - TANPA middleware guest
    require __DIR__ . '/auth.php';

    Route::get('/', function () {
        return view('welcome');
    })->name('landing');

    Route::get('/home', [BookController::class, 'home'])->name('home.index');

    // Books catalog
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/books/type/{type}', [BookController::class, 'booksByType'])->name('books.by-type');
    Route::get('/books/detail/{type}/{id}', [BookController::class, 'show'])->name('books.show');
    Route::get('/books/{slug}/read', [BookReaderController::class, 'show'])->name('books.read');

    // Author profile route - lebih spesifik
    Route::get('/author/{id}', [AuthorController::class, 'show'])->name('author.show');
    Route::get('/authors/create', [AuthorController::class, 'create'])->name('author.create');
    Route::post('authors/create', [AuthorController::class, 'store'])->name('author.store');


    // Protected routes - HANYA untuk user yang login
    Route::middleware('auth')->group(function () {
        // Logout harus dalam middleware auth
        Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Profile routes
        Route::prefix('profile')->group(function () {
            Route::get('/', [ProfileController::class, 'show'])->name('profile.show');
            Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::put('/', [ProfileController::class, 'updat'])->name('profile.update');

            // Password routes
            Route::get('/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
            Route::put('/change-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

            // Photo delete route
            Route::delete('/photo', [ProfileController::class, 'deletePhoto'])->name('profile.delete-photo');
        });

        // Book management routes - SEMUA dalam prefix yang sama
        Route::prefix('/books')->group(function () {
            Route::get('/my-books', [BookController::class, 'myBooks'])->name('books.my-books');

            // Ubah semua parameter menjadi {id} untuk konsistensi
            Route::post('/{id}/start-reading', [BookController::class, 'startReading'])->whereNumber('id')->name('books.start-reading');
            Route::post('/{id}/finish-reading', [BookController::class, 'finishReading'])->whereNumber('id')->name('books.finish-reading');
            Route::post('/{id}/wishlist', [BookController::class, 'addToWishlist'])->whereNumber('id')->name('books.add-to-wishlist');
            Route::delete('/{id}/wishlist', [BookController::class, 'removeFromWishlist'])->whereNumber('id')->name('books.remove-from-wishlist');
            Route::post('/toogle/{id}/wishlist', [BookController::class, 'toggleWishlist'])
                ->whereNumber('id')
                ->name('books.toggle-wishlist');
            Route::post('/{id}/rate', [BookController::class, 'rateBook'])->whereNumber('id')->name('books.rate');
            Route::post('/{id}/bookmark', [BookController::class, 'bookmarkBook'])->whereNumber('id')->name('books.bookmark');

            // E-book reader routes - tetap pakai {slug} untuk URL yang lebih friendly

            Route::post('/{slug}/progress', [BookReaderController::class, 'updateProgress'])->whereAlphaNumeric('slug')->name('books.update-progress');
            Route::post('/{slug}/finish-reading', [BookReaderController::class, 'finishReading'])->whereAlphaNumeric('slug')->name('books.finish-reading');
            Route::get('/{slug}/download', [BookReaderController::class, 'getFile'])->whereAlphaNumeric('slug')->name('books.download');
            Route::get('/{slug}/stream', [BookReaderController::class, 'streamFile'])->whereAlphaNumeric('slug')->name('books.stream');
        });

        // Diskusi routes
        Route::prefix('discussions')->group(function () {
            Route::get('/', [DiscussionController::class, 'index'])->name('discussions.index');
            Route::get('/{book}', [DiscussionController::class, 'show'])->name('discussions.show');
            Route::get('/{book}/create', [DiscussionController::class, 'create'])->name('discussions.create');
            Route::post('/{book}', [DiscussionController::class, 'store'])->name('discussions.store');
            Route::post('/{book}/{discussion}/join', [DiscussionController::class, 'join'])->name('discussions.join');
            Route::post('/{book}/{discussion}/leave', [DiscussionController::class, 'leave'])->name('discussions.leave');
            Route::post('/{book}/{discussion}/messages', [DiscussionController::class, 'storeMessage'])->name('discussions.messages.store');
            Route::get('/{book}/{discussion}/chat', [DiscussionController::class, 'chat'])->name('discussions.chat');
        });

        // Author profile management - untuk user yang login
        Route::prefix('authors')->middleware('profile.author')->group(function () {
            Route::get('/profile', [AuthorController::class, 'index'])->name('authors.profile');
            Route::get('/edit', [AuthorController::class, 'edit'])->name('authors.profile.edit');
            Route::put('/update', [AuthorController::class, 'update'])->name('authors.profile.update');
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
