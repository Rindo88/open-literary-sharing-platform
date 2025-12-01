# LitShare — Perpustakaan Digital untuk Berbagi Karya Amatir

LitShare adalah aplikasi perpustakaan digital yang didesain khusus bagi penulis amatir untuk mengunggah dan berbagi karya mereka secara terbuka. Terinspirasi dari Scribd, LitShare menekankan keterbukaan, akses mudah, dan katalog modern yang nyaman dijelajahi.

## Gambaran & Tujuan
- Mendukung penulis amatir mempublikasikan naskah (buku, cerpen, esai) secara terbuka.
- Memudahkan pembaca menemukan, menyimpan, dan mendiskusikan karya favorit.
- Menumbuhkan komunitas pembaca/penulis melalui diskusi yang sehat.

## Fitur
- Katalog buku dengan pencarian dan kategori yang mudah dijelajahi.
- Halaman utama menampilkan banner dan koleksi terbaru.
- Berbagi/unggah karya (roadmap): upload naskah, atur metadata, terbitkan ke katalog.
- Diskusi komunitas per karya (opsional sesuai konfigurasi).

## Prasyarat
- PHP 8.2+ dan Composer.
- Node.js 18+ dan npm.
- Database MySQL/MariaDB atau SQLite.

## Instalasi (GitHub)
Ikuti langkah standar seperti README profesional di GitHub.

1. Clone repository dan masuk ke folder proyek:
   - `git clone <url_repo_github>`
   - `cd <nama_folder_repo>`
2. Install dependency backend dan frontend:
   - Backend: `composer install`
   - Frontend: `npm install`
3. Salin file environment dari contoh:
   - `cp .env.example .env`
   - Atur nilai dasar seperti `APP_URL`, `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.
4. Generate kunci aplikasi:
   - `php artisan key:generate`
5. Migrasi database:
   - `php artisan migrate`
6. Buat symbolic link untuk storage:
   - `php artisan storage:link`
7. Jalankan aplikasi:
   - Frontend dev: `npm run dev` (opsional `npm run build` untuk produksi)
   - Server PHP: `php artisan serve`
8. Buka aplikasi:
   - `http://127.0.0.1:8000/`

## Menjalankan & Build
- `php artisan serve` menjalankan server pengembangan.
- `npm run dev` menjalankan Vite untuk hot-reload aset.
- `npm run build` membundel aset produksi.

## Troubleshooting
- Ekstensi PHP: pastikan `pdo_mysql`, `openssl`, `fileinfo` aktif.
- Aset tidak termuat: jalankan `npm run dev` atau `npm run build` dan cek `vite.config.js`.
- Storage: jalankan `php artisan storage:link` jika file tidak dapat diakses.
- Database: verifikasi kredensial di `.env` dan pastikan database tersedia.

## Lisensi
Proyek pembelajaran. Silakan gunakan dan modifikasi untuk kebutuhan edukasi.
