<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\BookDiscussion;
use App\Models\DiscussionMessage;
use App\Models\DiscussionParticipant;
use App\Models\User;

class DiscussionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = Book::all();
        $users = User::all();

        if ($books->count() === 0 || $users->count() === 0) {
            $this->command->info('No books or users found. Skipping discussion seeding.');
            return;
        }

        $sampleDiscussions = [
            [
                'title' => 'Analisis Karakter Utama dalam Novel',
                'description' => 'Mari kita diskusikan perkembangan karakter utama dari awal hingga akhir cerita. Bagaimana pendapat kalian tentang transformasi karakter ini?'
            ],
            [
                'title' => 'Tema dan Pesan Moral Buku',
                'description' => 'Apa tema utama yang ingin disampaikan penulis? Bagaimana pesan moral yang bisa kita ambil dari cerita ini?'
            ],
            [
                'title' => 'Plot Twist yang Mengejutkan',
                'description' => 'Diskusikan plot twist yang paling mengejutkan dalam buku ini. Apakah kalian sudah menduganya dari awal?'
            ],
            [
                'title' => 'Perbandingan dengan Adaptasi Film',
                'description' => 'Bagi yang sudah menonton filmnya, bagaimana perbandingannya dengan buku? Apakah ada perbedaan signifikan?'
            ],
            [
                'title' => 'Rekomendasi Buku Serupa',
                'description' => 'Setelah membaca buku ini, buku apa yang kalian rekomendasikan untuk dibaca selanjutnya?'
            ]
        ];

        foreach ($books as $book) {
            // Create 2-3 random discussions for each book
            $discussionCount = rand(2, 3);
            
            for ($i = 0; $i < $discussionCount; $i++) {
                $discussionData = $sampleDiscussions[array_rand($sampleDiscussions)];
                
                $discussion = BookDiscussion::create([
                    'book_id' => $book->id,
                    'created_by' => $users->random()->id,
                    'title' => $discussionData['title'],
                    'description' => $discussionData['description'],
                    'status' => 'active',
                    'is_private' => false,
                    'max_participants' => null,
                    'last_activity_at' => now()->subDays(rand(1, 30))
                ]);

                // Add creator as moderator
                DiscussionParticipant::create([
                    'discussion_id' => $discussion->id,
                    'user_id' => $discussion->created_by,
                    'role' => 'moderator',
                    'joined_at' => $discussion->created_at,
                    'last_read_at' => now()
                ]);

                // Add 2-4 random participants
                $participantCount = min(rand(2, 4), $users->where('id', '!=', $discussion->created_by)->count());
                if ($participantCount > 0) {
                    $randomUsers = $users->where('id', '!=', $discussion->created_by)->random($participantCount);
                    
                    foreach ($randomUsers as $user) {
                        DiscussionParticipant::create([
                            'discussion_id' => $discussion->id,
                            'user_id' => $user->id,
                            'role' => 'participant',
                            'joined_at' => $discussion->created_at->addHours(rand(1, 24)),
                            'last_read_at' => now()->subHours(rand(1, 48))
                        ]);
                    }
                }

                // Create 3-8 messages for each discussion
                $messageCount = rand(3, 8);
                $participants = $discussion->participants;
                
                for ($j = 0; $j < $messageCount; $j++) {
                    $message = DiscussionMessage::create([
                        'discussion_id' => $discussion->id,
                        'user_id' => $participants->random()->id,
                        'message' => $this->getSampleMessage(),
                        'type' => 'text',
                        'created_at' => $discussion->created_at->addHours(rand(1, 72)),
                        'updated_at' => $discussion->created_at->addHours(rand(1, 72))
                    ]);
                }

                // Update discussion counts
                $discussion->updateParticipantsCount();
                $discussion->incrementMessagesCount();
            }
        }

        $this->command->info('Discussions seeded successfully!');
    }

    private function getSampleMessage(): string
    {
        $messages = [
            'Saya sangat setuju dengan pendapat Anda tentang karakter ini!',
            'Menurut saya, tema yang disampaikan sangat relevan dengan kondisi saat ini.',
            'Plot twist-nya benar-benar mengejutkan, tidak terduga sama sekali!',
            'Buku ini memberikan perspektif baru yang sangat menarik.',
            'Karakter favorit saya adalah yang memiliki perkembangan paling dinamis.',
            'Pesan moral yang bisa diambil sangat dalam dan bermakna.',
            'Saya suka bagaimana penulis menggambarkan setting dan atmosfer cerita.',
            'Dialog antar karakter sangat natural dan mengalir dengan baik.',
            'Ada beberapa bagian yang membuat saya terharu dan terinspirasi.',
            'Buku ini layak dibaca berulang kali untuk memahami maknanya.'
        ];

        return $messages[array_rand($messages)];
    }
}
