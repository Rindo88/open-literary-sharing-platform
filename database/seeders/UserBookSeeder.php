<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Book;
use App\Models\UserBook;

class UserBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $books = Book::all();

        if ($users->count() === 0 || $books->count() === 0) {
            $this->command->info('No users or books found. Skipping user book seeding.');
            return;
        }

        foreach ($users as $user) {
            // Randomly assign 2-4 books to each user
            $bookCount = min(rand(2, 4), $books->count());
            if ($bookCount > 0) {
                $randomBooks = $books->random($bookCount);
                
                foreach ($randomBooks as $book) {
                    $status = ['reading', 'finished', 'wishlist'][array_rand(['reading', 'finished', 'wishlist'])];
                    
                    UserBook::create([
                        'user_id' => $user->id,
                        'book_id' => $book->id,
                        'status' => $status,
                        'started_at' => $status === 'reading' || $status === 'finished' ? now()->subDays(rand(1, 30)) : null,
                        'finished_at' => $status === 'finished' ? now()->subDays(rand(1, 7)) : null,
                        'last_page' => $status === 'reading' ? rand(1, 100) : ($status === 'finished' ? 100 : null),
                        'reading_duration' => $status === 'reading' || $status === 'finished' ? rand(30, 300) : null,
                    ]);
                }
            }
        }

        $this->command->info('User books seeded successfully!');
    }

    private function getSampleReview(): string
    {
        $reviews = [
            'Buku yang sangat menarik dan memberikan wawasan baru.',
            'Cerita yang mengalir dengan baik dan karakter yang berkembang.',
            'Tema yang relevan dengan kondisi saat ini.',
            'Penulisan yang enak dibaca dan mudah dipahami.',
            'Buku yang layak dibaca berulang kali.',
            'Memberikan perspektif baru yang mengejutkan.',
            'Karakter yang relatable dan plot yang menegangkan.',
            'Pesan moral yang dalam dan bermakna.',
            'Setting yang detail dan atmosfer yang kuat.',
            'Dialog yang natural dan mengalir dengan baik.'
        ];

        return $reviews[array_rand($reviews)];
    }
}
