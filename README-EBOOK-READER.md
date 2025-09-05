# Fitur Pembaca E-book - Perpustakaan Digital

## Overview
Fitur ini memungkinkan pengguna untuk membaca e-book yang diupload oleh admin dalam format PDF atau EPUB. Sistem juga melacak progress membaca pengguna dan menyimpan sesi membaca.

## Fitur Utama

### 1. Pembaca E-book
- **PDF Viewer**: Menggunakan iframe untuk menampilkan PDF
- **Progress Tracking**: Melacak halaman yang sedang dibaca
- **Session Management**: Menyimpan sesi membaca pengguna
- **Download**: Pengguna dapat mengunduh file e-book

### 2. Admin Panel
- **Upload E-book**: Admin dapat upload file PDF/EPUB (max 10MB)
- **Upload Cover**: Admin dapat upload cover buku (max 2MB)
- **Book Management**: CRUD lengkap untuk buku
- **User Management**: Melihat daftar pengguna

### 3. User Experience
- **Reading Progress**: Bar progress dan halaman saat ini
- **Session Info**: Informasi waktu mulai dan terakhir membaca
- **Book Status**: Tracking status buku (reading, finished, wishlist)

## Struktur File

### Controllers
- `BookReaderController.php` - Mengelola pembaca e-book
- `AdminController.php` - Panel admin untuk upload dan kelola buku

### Views
- `resources/views/books/reader.blade.php` - Halaman pembaca e-book
- `resources/views/admin/dashboard.blade.php` - Dashboard admin
- `resources/views/admin/books/create.blade.php` - Form tambah buku
- `resources/views/admin/books/edit.blade.php` - Form edit buku
- `resources/views/admin/books/index.blade.php` - Daftar buku admin
- `resources/views/admin/users/index.blade.php` - Daftar pengguna

### Routes
```php
// E-book reader routes
Route::get('/books/{slug}/read', [BookReaderController::class, 'show'])->name('books.read');
Route::post('/books/{slug}/progress', [BookReaderController::class, 'updateProgress'])->name('books.update-progress');
Route::post('/books/{slug}/finish-reading', [BookReaderController::class, 'finishReading'])->name('books.finish-reading');
Route::get('/books/{slug}/download', [BookReaderController::class, 'getFile'])->name('books.download');

// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/books', [AdminController::class, 'manageBooks'])->name('admin.books.index');
    Route::get('/books/create', [AdminController::class, 'createBook'])->name('admin.books.create');
    Route::post('/books', [AdminController::class, 'storeBook'])->name('admin.books.store');
    Route::get('/books/{book}/edit', [AdminController::class, 'editBook'])->name('admin.books.edit');
    Route::put('/books/{book}', [AdminController::class, 'updateBook'])->name('admin.books.update');
    Route::delete('/books/{book}', [AdminController::class, 'destroyBook'])->name('admin.books.destroy');
    Route::get('/users', [AdminController::class, 'manageUsers'])->name('admin.users.index');
});
```

## Cara Penggunaan

### Untuk Admin
1. **Login sebagai admin**
2. **Akses dashboard admin**: `/admin`
3. **Upload buku baru**: Klik "Tambah Buku Baru"
4. **Isi form**: Judul, penulis, kategori, upload cover dan file e-book
5. **Kelola buku**: Edit, hapus, atau lihat statistik buku

### Untuk User
1. **Login ke sistem**
2. **Lihat katalog buku**: `/books`
3. **Pilih buku**: Klik pada buku yang ingin dibaca
4. **Baca buku**: Klik tombol "📖 Baca Buku"
5. **Track progress**: Sistem otomatis melacak progress membaca

## Database Schema

### ReadingSession Model
```php
- user_id: ID pengguna
- book_id: ID buku
- started_at: Waktu mulai membaca
- current_page: Halaman saat ini
- total_pages: Total halaman
- last_read_at: Waktu terakhir membaca
- ended_at: Waktu selesai membaca
```

### Book Model (Updated)
```php
- file_path: Path ke file e-book
- status: Status buku (draft/published/archived)
- pages: Jumlah halaman
```

## Keamanan

### File Upload
- **Validasi tipe file**: Hanya PDF dan EPUB
- **Size limit**: Cover max 2MB, e-book max 10MB
- **Storage**: File disimpan di `storage/app/public/`

### Access Control
- **Authentication required**: Hanya user login yang bisa baca
- **Book ownership**: User harus memiliki buku di library
- **Admin only**: Hanya admin yang bisa upload/edit buku

## Fitur Tambahan

### Progress Tracking
- Sistem melacak halaman yang sedang dibaca
- Progress bar visual untuk user
- Auto-save progress setiap 2 detik

### Reading Analytics
- Waktu mulai dan selesai membaca
- Total waktu membaca
- Halaman yang sudah dibaca

## Teknologi yang Digunakan

- **Backend**: Laravel 10
- **Frontend**: Blade templates + Tailwind CSS
- **File Storage**: Laravel Storage
- **PDF Viewer**: Browser built-in PDF viewer
- **Database**: MySQL/PostgreSQL

## Instalasi

1. **Clone repository**
2. **Install dependencies**: `composer install`
3. **Setup database**: `php artisan migrate`
4. **Create storage link**: `php artisan storage:link`
5. **Seed data**: `php artisan db:seed`
6. **Run server**: `php artisan serve`

## Catatan Penting

- Pastikan folder `storage/app/public/` memiliki permission write
- File e-book akan disimpan di `storage/app/public/books/`
- Cover buku akan disimpan di `storage/app/public/covers/`
- Sistem mendukung format PDF dan EPUB
- Progress reading disimpan secara real-time

## Troubleshooting

### File tidak bisa diupload
- Cek permission folder storage
- Cek file size limit di php.ini
- Cek validasi file type

### PDF tidak muncul
- Cek apakah file tersimpan di storage
- Cek route download berfungsi
- Cek browser support PDF

### Progress tidak tersimpan
- Cek database connection
- Cek model relationships
- Cek JavaScript console untuk error
