<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\BookDiscussion;
use App\Models\DiscussionMessage;
use App\Models\User;

class BookDiscussionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = Book::take(3)->get();
        $users = User::take(5)->get();

        if ($books->isEmpty() || $users->isEmpty()) {
            return;
        }

        foreach ($books as $book) {
            // Create 2-3 discussions per book
            for ($i = 0; $i < rand(2, 3); $i++) {
                $discussion = BookDiscussion::create([
                    'book_id' => $book->id,
                    'title' => $this->getDiscussionTitles()[$i] ?? 'Diskusi Umum tentang ' . $book->title,
                    'description' => $this->getDiscussionDescriptions()[$i] ?? 'Mari kita diskusikan berbagai aspek dari buku ini bersama-sama.',
                    'status' => 'active',
                    'participants_count' => 0,
                    'messages_count' => 0,
                    'last_activity_at' => now(),
                    'created_by' => $users->random()->id,
                ]);

                // Add participants
                $participantCount = min(rand(3, 5), $users->count());
                $selectedUsers = $users->random($participantCount);
                
                foreach ($selectedUsers as $index => $user) {
                    $role = $index === 0 ? 'moderator' : 'member';
                    $discussion->participants()->attach($user->id, [
                        'role' => $role,
                        'joined_at' => now()->subDays(rand(1, 7)),
                        'last_read_at' => now()->subHours(rand(1, 24)),
                    ]);
                }

                // Create messages
                $messageCount = rand(5, 15);
                for ($j = 0; $j < $messageCount; $j++) {
                    $messageUser = $selectedUsers->random();
                    DiscussionMessage::create([
                        'discussion_id' => $discussion->id,
                        'user_id' => $messageUser->id,
                        'message' => $this->getSampleMessages()[$j % count($this->getSampleMessages())],
                        'is_edited' => rand(0, 10) === 0, // 10% chance of being edited
                        'edited_at' => null,
                    ]);
                }

                // Update discussion stats
                $discussion->updateParticipantsCount();
                $discussion->update([
                    'messages_count' => $messageCount,
                    'last_activity_at' => now()->subHours(rand(1, 6)),
                ]);
            }
        }
    }

    private function getDiscussionTitles(): array
    {
        return [
            'Analisis Karakter Utama',
            'Interpretasi Plot dan Tema',
            'Diskusi Umum Buku',
            'Pertanyaan dan Jawaban',
            'Review dan Rekomendasi'
        ];
    }

    private function getDiscussionDescriptions(): array
    {
        return [
            'Mari kita bahas karakter utama dalam buku ini. Bagaimana perkembangannya dari awal hingga akhir?',
            'Apa tema utama yang ingin disampaikan penulis? Bagaimana plot mendukung tema tersebut?',
            'Diskusi bebas tentang berbagai aspek buku yang menarik perhatian Anda.',
            'Ada pertanyaan tentang buku ini? Mari kita diskusikan bersama.',
            'Bagaimana pendapat Anda tentang buku ini? Apakah akan merekomendasikannya kepada orang lain?'
        ];
    }

    private function getSampleMessages(): array
    {
        return [
            'Saya sangat suka dengan karakter utama dalam buku ini. Perkembangannya sangat menarik untuk diikuti.',
            'Menurut saya tema yang disampaikan sangat relevan dengan kondisi saat ini.',
            'Ada bagian yang menurut saya agak membingungkan. Ada yang bisa menjelaskan?',
            'Plot twist di akhir benar-benar mengejutkan! Tidak menyangka akan seperti itu.',
            'Buku ini memberikan perspektif baru tentang topik yang sudah familiar.',
            'Saya setuju dengan pendapat Anda. Karakter antagonis juga sangat kompleks.',
            'Bagian favorit saya adalah ketika karakter utama menghadapi konflik internal.',
            'Apakah ada yang sudah membaca buku lain dari penulis yang sama?',
            'Saya akan merekomendasikan buku ini kepada teman-teman saya.',
            'Ada yang bisa menjelaskan makna simbolis dari adegan tersebut?',
            'Menurut saya ending-nya sangat memuaskan dan memberikan closure yang baik.',
            'Karakter supporting juga sangat berperan dalam mengembangkan cerita.',
            'Saya suka bagaimana penulis menggambarkan setting dan atmosfer cerita.',
            'Ada yang sudah mencoba menganalisis dari sudut pandang yang berbeda?',
            'Buku ini membuat saya berpikir ulang tentang banyak hal.'
        ];
    }
}
