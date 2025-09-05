# Admin Access Control - Perpustakaan Digital

## Overview
Sistem kontrol akses admin yang membatasi akses ke panel admin hanya untuk pengguna dengan role 'admin'.

## Fitur Utama

### 1. Admin Middleware
- **File**: `app/Http/Middleware/AdminMiddleware.php`
- **Fungsi**: Memverifikasi bahwa pengguna yang mengakses route admin memiliki role 'admin'
- **Logika**: 
  - Cek apakah user sudah login
  - Cek apakah user memiliki role 'admin'
  - Jika tidak memenuhi syarat, redirect ke halaman 403 (Forbidden)

### 2. Route Protection
- **File**: `routes/web.php`
- **Middleware**: Semua route admin dilindungi dengan `middleware('admin')`
- **Route yang Dilindungi**:
  - `/admin` - Dashboard admin
  - `/admin/books` - Manajemen buku
  - `/admin/books/create` - Tambah buku baru
  - `/admin/books/{book}/edit` - Edit buku
  - `/admin/users` - Manajemen pengguna

### 3. Error Pages
- **403 Forbidden**: `resources/views/errors/403.blade.php`
  - Ditampilkan ketika user non-admin mencoba akses admin
  - Pesan error yang informatif
  - Tombol navigasi ke halaman yang diizinkan
- **404 Not Found**: `resources/views/errors/404.blade.php`
  - Halaman tidak ditemukan
- **500 Server Error**: `resources/views/errors/500.blade.php`
  - Error server internal

## Cara Kerja

### 1. Registrasi Middleware
```php
// bootstrap/app.php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ]);
})
```

### 2. Penerapan pada Route
```php
// routes/web.php
Route::prefix('admin')->middleware('admin')->group(function () {
    // Semua route admin di sini
});
```

### 3. Verifikasi Role
```php
// AdminMiddleware.php
if (!auth()->check() || auth()->user()->role !== 'admin') {
    abort(403, 'Unauthorized access. Admin privileges required.');
}
```

## Setup dan Konfigurasi

### 1. Pastikan Tabel Users Memiliki Kolom Role
```php
// database/migrations/xxxx_add_role_to_users_table.php
Schema::table('users', function (Blueprint $table) {
    $table->enum('role', ['user', 'admin'])->default('user');
});
```

### 2. Buat User Admin Pertama
```bash
php artisan db:seed --class=AdminUserSeeder
```

**Kredensial Default:**
- Email: `admin@perpustakaan.com`
- Password: `admin123`

### 3. Update User Existing (Jika Perlu)
```sql
UPDATE users SET role = 'admin' WHERE email = 'email_admin@example.com';
```

## Keamanan

### 1. Role-Based Access Control
- Hanya user dengan role 'admin' yang bisa akses panel admin
- User biasa akan mendapat error 403 jika mencoba akses

### 2. Middleware Protection
- Semua route admin dilindungi di level route
- Tidak ada kemungkinan bypass tanpa middleware

### 3. Error Handling
- Error 403 memberikan feedback yang jelas
- Tidak ada informasi sensitif yang terekspos

## Troubleshooting

### 1. User Tidak Bisa Akses Admin
- **Cek Role**: Pastikan user memiliki role 'admin' di database
- **Cek Middleware**: Pastikan AdminMiddleware terdaftar di bootstrap/app.php
- **Cek Route**: Pastikan route admin menggunakan middleware 'admin'

### 2. Error 403 Muncul
- **Normal**: Ini adalah behavior yang diharapkan untuk user non-admin
- **Jika Admin**: Cek role user di database

### 3. Middleware Tidak Berfungsi
- **Clear Cache**: `php artisan config:clear`
- **Restart Server**: Restart web server
- **Cek Log**: Lihat log Laravel untuk error

## Best Practices

### 1. Role Management
- Gunakan enum untuk role (user, admin)
- Jangan hardcode role di controller
- Gunakan middleware untuk semua route admin

### 2. Security
- Selalu verifikasi role di middleware
- Gunakan abort(403) untuk unauthorized access
- Log semua akses admin untuk audit trail

### 3. User Experience
- Berikan pesan error yang jelas
- Sediakan navigasi alternatif
- Konsisten dalam handling unauthorized access

## Pengembangan Selanjutnya

### 1. Role Hierarchy
- Tambah role 'super_admin', 'moderator'
- Implementasi permission-based access control

### 2. Audit Log
- Log semua akses admin
- Track perubahan data penting

### 3. Admin Panel Enhancement
- Dashboard analytics untuk admin
- User management yang lebih advanced
- System configuration panel

## Kesimpulan

Sistem admin access control ini memberikan keamanan yang kuat untuk panel admin dengan:
- Middleware yang reliable
- Error handling yang user-friendly
- Struktur yang mudah di-maintain
- Kemampuan untuk dikembangkan lebih lanjut

Pastikan untuk selalu menggunakan middleware 'admin' pada semua route yang memerlukan akses admin, dan verifikasi role user sebelum memberikan akses ke fitur administratif.
