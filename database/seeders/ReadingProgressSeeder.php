<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ReadingSession;
use App\Models\UserBook;
use App\Models\Book;
use App\Models\User;

class ReadingProgressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing users and books
        $users = User::where('role', '!=', 'admin')->get();
        $books = Book::all();

        if ($users->isEmpty() || $books->isEmpty()) {
            $this->command->info('No users or books found. Please run UserSeeder and BookSeeder first.');
            return;
        }

        // Clear existing reading sessions
        ReadingSession::truncate();

        foreach ($users as $user) {
            foreach ($books->take(2) as $book) {
                // Create UserBook entry
                UserBook::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'book_id' => $book->id,
                    ],
                    [
                        'status' => 'reading',
                        'created_at' => now()->subDays(rand(1, 7)),
                    ]
                );

                // Create ReadingSession with proper progress
                $currentPage = rand(1, $book->pages ?? 100);
                $totalPages = $book->pages ?? 100;
                
                ReadingSession::create([
                    'user_id' => $user->id,
                    'book_id' => $book->id,
                    'started_at' => now()->subDays(rand(1, 7)),
                    'current_page' => $currentPage,
                    'total_pages' => $totalPages,
                    'last_read_at' => now()->subHours(rand(1, 24)),
                    'pages_read' => $currentPage,
                    'duration' => rand(30, 180), // 30 minutes to 3 hours
                ]);
            }
        }

        $this->command->info('Reading progress data seeded successfully!');
    }
}
