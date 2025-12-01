<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Book;
use App\Models\AuthorProfile;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create categories
        $categories = [
            ['name' => 'Fiksi', 'slug' => 'fiksi', 'icon' => '📖'],
            ['name' => 'Non-Fiksi', 'slug' => 'non-fiksi', 'icon' => '📚'],
            ['name' => 'Sains', 'slug' => 'sains', 'icon' => '🔬'],
            ['name' => 'Teknologi', 'slug' => 'teknologi', 'icon' => '💻'],
            ['name' => 'Sejarah', 'slug' => 'sejarah', 'icon' => '🏛️'],
            ['name' => 'Biografi', 'slug' => 'biografi', 'icon' => '👤'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create a test user and author
        $user = User::create([
            'name' => 'Test Author',
            'email' => 'author@test.com',
            'password' => bcrypt('password'),
        ]);

        $author = AuthorProfile::create([
            'user_id' => $user->id,
            'pen_name' => 'Penulis Test',
            'bio' => 'Penulis profesional',
            'is_verified' => true,
        ]);

        // Create some test books
        $books = [
            [
                'title' => 'Belajar Laravel untuk Pemula',
                'slug' => 'belajar-laravel-untuk-pemula',
                'author_id' => $author->id,
                'description' => 'Buku panduan lengkap belajar Laravel dari dasar hingga mahir',
                'publisher' => 'Penerbit Test',
                'published_year' => 2024,
                'pages' => 300,
                'status' => 'published',
                'categories' => [4, 2] // Teknologi, Non-Fiksi
            ],
            [
                'title' => 'Sejarah Indonesia Modern',
                'slug' => 'sejarah-indonesia-modern', 
                'author_id' => $author->id,
                'description' => 'Sejarah perkembangan Indonesia dari masa kemerdekaan hingga sekarang',
                'publisher' => 'Penerbit Sejarah',
                'published_year' => 2023,
                'pages' => 450,
                'status' => 'published',
                'categories' => [5, 2] // Sejarah, Non-Fiksi
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}