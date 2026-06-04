<?php

namespace Database\Seeders;

use App\Models\LearningCategory;
use App\Models\LearningChapter;
use App\Models\LearningMaterial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LearningSeeder extends Seeder
{
    public function run()
    {
        // 1. Data Kategori
        $categories = [
            ['name' => 'Tes Wawasan Kebangsaan (TWK)', 'slug' => 'twk', 'icon' => 'bi bi-book', 'color_theme' => 'danger', 'description' => 'Kuasai Sejarah, Pancasila & Nasionalisme.'],
            ['name' => 'Tes Inteligensia Umum (TIU)', 'slug' => 'tiu', 'icon' => 'bi bi-calculator', 'color_theme' => 'primary', 'description' => 'Taklukkan Logika, Deret Angka & Silogisme.'],
            ['name' => 'Tes Karakteristik Pribadi (TKP)', 'slug' => 'tkp', 'icon' => 'bi bi-people', 'color_theme' => 'success', 'description' => 'Pahami Karakter & Pelayanan Publik.'],
        ];

        foreach ($categories as $cat) {
            $category = LearningCategory::create($cat);

            // 2. Buat Bab per Kategori
            for ($i = 1; $i <= 2; $i++) {
                $chapter = LearningChapter::create([
                    'learning_category_id' => $category->id,
                    'title' => "Bab $i: Materi Dasar " . $category->slug,
                    'order_number' => $i
                ]);

                // 3. Buat Materi per Bab
                for ($j = 1; $j <= 3; $j++) {
                    LearningMaterial::create([
                        'learning_chapter_id' => $chapter->id,
                        'title' => "Sub-bab $j: Topik Pembahasan",
                        // Tambahkan ID Chapter di slug agar unik
                        'slug' => Str::slug($chapter->title . " materi " . $j), 
                        'content' => "Ini adalah isi konten dummy untuk materi $j...",
                        'order_number' => $j,
                        'is_locked' => ($i == 2 && $j > 1) 
                    ]);
                }
            }
        }
    }
}