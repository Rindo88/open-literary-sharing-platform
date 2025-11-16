<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Book;
use App\Models\Rating;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        // Create categories
        $categories = [

            ['name' => 'Non-Fiksi', 'description' => 'Buku non-fiksi dan referensi', 'color' => 'green', 'icon' => '📖'],
            ['name' => 'Teknologi', 'description' => 'Buku teknologi dan komputer', 'color' => 'purple', 'icon' => '💻'],
            ['name' => 'Bisnis', 'description' => 'Buku bisnis dan ekonomi', 'color' => 'yellow', 'icon' => '💼'],
            ['name' => 'Sejarah', 'description' => 'Buku sejarah dan budaya', 'color' => 'red', 'icon' => '🏛️'],
        ];

        foreach ($categories as $categoryData) {
            $categoryData['slug'] = Str::slug($categoryData['name']);
            Category::create($categoryData);
        }

        // Create sample books
        $books = [
            [
                'title' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'description' => 'Novel yang mengisahkan perjuangan anak-anak di Belitung untuk mendapatkan pendidikan yang layak.',
                'isbn' => '978-979-3062-92-8',
                'published_year' => 2005,
                'publisher' => 'Bentang Pustaka',
                'pages' => 529,
                'category_id' => 1,
                'status' => 'published',
            ],
            [
                'title' => 'Bumi Manusia',
                'author' => 'Pramoedya Ananta Toer',
                'description' => 'Novel sejarah yang mengisahkan perjuangan Minke dalam menghadapi kolonialisme Belanda.',
                'isbn' => '978-979-3062-92-9',
                'published_year' => 1980,
                'publisher' => 'Hasta Mitra',
                'pages' => 535,
                'category_id' => 1,
                'status' => 'published',
            ],
            [
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'description' => 'Panduan menulis kode yang bersih, mudah dibaca, dan mudah dipelihara.',
                'isbn' => '978-013-2350-88-4',
                'published_year' => 2008,
                'publisher' => 'Prentice Hall',
                'pages' => 464,
                'category_id' => 3,
                'status' => 'published',
            ],
            [
                'title' => 'The Lean Startup',
                'author' => 'Eric Ries',
                'description' => 'Metodologi untuk mengembangkan bisnis dan produk yang berkelanjutan.',
                'isbn' => '978-030-7887-89-4',
                'published_year' => 2011,
                'publisher' => 'Crown Business',
                'pages' => 336,
                'category_id' => 4,
                'status' => 'published',
            ],
            [
                'title' => 'Sejarah Indonesia Modern',
                'author' => 'M.C. Ricklefs',
                'description' => 'Buku sejarah Indonesia dari masa kolonial hingga era reformasi.',
                'isbn' => '978-979-3780-47-5',
                'published_year' => 2008,
                'publisher' => 'Serambi',
                'pages' => 720,
                'category_id' => 5,
                'status' => 'published',
            ],
            [
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'description' => 'Strategi membangun kebiasaan baik dan menghilangkan kebiasaan buruk.',
                'isbn' => '978-073-5211-29-2',
                'published_year' => 2018,
                'publisher' => 'Avery',
                'pages' => 320,
                'category_id' => 2,
                'status' => 'published',
            ],
        ];

        foreach ($books as $bookData) {
            $bookData['slug'] = Str::slug($bookData['title']);
            Book::create($bookData);
        }

        // Create sample ratings
        $ratings = [
            ['book_id' => 1, 'rating' => 5, 'review' => 'Buku yang sangat inspiratif dan mengharukan.'],
            ['book_id' => 2, 'rating' => 5, 'review' => 'Novel sejarah yang luar biasa dan mendalam.'],
            ['book_id' => 3, 'rating' => 5, 'review' => 'Wajib dibaca untuk semua programmer.'],
            ['book_id' => 4, 'rating' => 4, 'review' => 'Panduan bisnis yang sangat praktis.'],
            ['book_id' => 5, 'rating' => 4, 'review' => 'Buku sejarah yang komprehensif.'],
            ['book_id' => 6, 'rating' => 5, 'review' => 'Mengubah cara berpikir tentang kebiasaan.'],
        ];

        foreach ($ratings as $ratingData) {
            Rating::create([
                'user_id' => 1, // Admin user
                'book_id' => $ratingData['book_id'],
                'rating' => $ratingData['rating'],
                'review' => $ratingData['review'],
            ]);
        }
    }
}
