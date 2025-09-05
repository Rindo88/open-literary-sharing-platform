<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Novel',
                'slug' => 'novel',
                'description' => 'Karya sastra prosa yang panjang',
                'color' => 'blue',
                'icon' => 'book-open'
            ],
            [
                'name' => 'Pendidikan',
                'slug' => 'pendidikan',
                'description' => 'Buku-buku pendidikan dan pembelajaran',
                'color' => 'green',
                'icon' => 'academic-cap'
            ],
            [
                'name' => 'Teknologi',
                'slug' => 'teknologi',
                'description' => 'Buku tentang teknologi dan komputer',
                'color' => 'purple',
                'icon' => 'chip'
            ],
            [
                'name' => 'Bisnis',
                'slug' => 'bisnis',
                'description' => 'Buku tentang bisnis dan ekonomi',
                'color' => 'yellow',
                'icon' => 'briefcase'
            ],
            [
                'name' => 'Sejarah',
                'slug' => 'sejarah',
                'description' => 'Buku tentang sejarah dan peradaban',
                'color' => 'red',
                'icon' => 'clock'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
