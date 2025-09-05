<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class ProfileDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update existing users with profile data
        $users = User::all();
        
        foreach ($users as $user) {
            $user->update([
                'phone' => '+62' . rand(800, 899) . rand(10000000, 99999999),
                'address' => $this->getRandomAddress(),
                'bio' => $this->getRandomBio(),
                'birth_date' => $this->getRandomBirthDate(),
                'gender' => $this->getRandomGender(),
                'city' => $this->getRandomCity(),
                'postal_code' => rand(10000, 99999),
            ]);
        }
        
        $this->command->info('Profile data seeded successfully!');
    }
    
    private function getRandomAddress(): string
    {
        $addresses = [
            'Jl. Sudirman No. 123, Jakarta Pusat',
            'Jl. Thamrin No. 45, Jakarta Selatan',
            'Jl. Gatot Subroto No. 67, Jakarta Barat',
            'Jl. Hayam Wuruk No. 89, Jakarta Utara',
            'Jl. Asia Afrika No. 12, Bandung',
            'Jl. Malioboro No. 34, Yogyakarta',
            'Jl. Pahlawan No. 56, Surabaya',
            'Jl. Ahmad Yani No. 78, Semarang',
            'Jl. Veteran No. 90, Malang',
            'Jl. Merdeka No. 11, Medan',
        ];
        
        return $addresses[array_rand($addresses)];
    }
    
    private function getRandomBio(): string
    {
        $bios = [
            'Pecinta buku yang senang menghabiskan waktu di perpustakaan digital.',
            'Pembaca setia yang selalu mencari pengetahuan baru dari setiap halaman.',
            'Penggemar literasi yang percaya bahwa buku adalah jendela dunia.',
            'Pembaca yang berkomitmen untuk terus belajar dan berkembang.',
            'Pecinta cerita yang menemukan petualangan di setiap buku.',
            'Pembaca yang percaya bahwa pengetahuan adalah investasi terbaik.',
            'Penggemar buku yang senang berbagi rekomendasi bacaan.',
            'Pembaca yang menemukan inspirasi dari setiap kata yang dibaca.',
            'Pecinta literasi yang mendukung gerakan membaca nasional.',
            'Pembaca yang percaya bahwa membaca membuka pikiran dan hati.',
        ];
        
        return $bios[array_rand($bios)];
    }
    
    private function getRandomBirthDate(): string
    {
        $start = strtotime('1980-01-01');
        $end = strtotime('2005-12-31');
        $timestamp = rand($start, $end);
        
        return date('Y-m-d', $timestamp);
    }
    
    private function getRandomGender(): string
    {
        $genders = ['male', 'female', 'other'];
        return $genders[array_rand($genders)];
    }
    
    private function getRandomCity(): string
    {
        $cities = [
            'Jakarta Pusat', 'Jakarta Selatan', 'Jakarta Barat', 'Jakarta Utara',
            'Bandung', 'Yogyakarta', 'Surabaya', 'Semarang', 'Malang', 'Medan',
            'Palembang', 'Makassar', 'Denpasar', 'Manado', 'Balikpapan'
        ];
        
        return $cities[array_rand($cities)];
    }
}
