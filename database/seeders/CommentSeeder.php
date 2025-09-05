<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Book;
use App\Models\User;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = Book::all();
        $users = User::all();

        if ($books->count() === 0 || $users->count() === 0) {
            $this->command->info('No books or users found. Skipping comment seeding.');
            return;
        }

        $sampleComments = [
            'Buku yang sangat informatif dan mudah dipahami!',
            'Saya suka cara penulis menjelaskan konsep-konsepnya.',
            'Buku ini sangat membantu untuk memahami topik ini.',
            'Bagus sekali! Sangat direkomendasikan untuk dibaca.',
            'Kontennya lengkap dan terstruktur dengan baik.',
            'Saya sudah membaca buku ini 2 kali, sangat bermanfaat!',
            'Penjelasannya detail dan contoh-contohnya relevan.',
            'Buku yang wajib dibaca untuk pemula di bidang ini.',
            'Sangat puas dengan pembelian buku ini.',
            'Kualitas konten dan penyajiannya sangat baik.'
        ];

        foreach ($books as $book) {
            // Create 2-5 random comments for each book
            $commentCount = rand(2, 5);
            
            for ($i = 0; $i < $commentCount; $i++) {
                Comment::create([
                    'user_id' => $users->random()->id,
                    'book_id' => $book->id,
                    'content' => $sampleComments[array_rand($sampleComments)],
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now()->subDays(rand(1, 30)),
                ]);
            }
        }

        $this->command->info('Comments seeded successfully!');
    }
}
