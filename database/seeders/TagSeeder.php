<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Seed the tags table with initial data.
     *
     * @return void
     */
    public function run()
    {
        // Daftar tag umum untuk website berita
        $tags = [
            'Berita Nasional',
            'Politik',
            'Ekonomi',
            'Pendidikan',
            'Kesehatan',
            'Teknologi',
            'Olahraga',
            'Hiburan',
            'Gaya Hidup',
            'Budaya',
            'Wisata',
            'Kuliner',
            'Bisnis',
            'Finansial',
            'Otomotif',
            'Internasional',
            'Sosial',
            'Lingkungan',
            'Hukum',
            'Sains',
            'Keamanan',
            'Transportasi',
            'Pemerintahan',
            'Pariwisata',
            'Agama',
            'Pertanian',
            'UMKM',
            'Inspirasi',
            'Kesehatan Mental',
            'COVID-19',
        ];

        // Tambahkan tag ke database
        foreach ($tags as $tagName) {
            Tag::create([
                'tag_name' => $tagName,
            ]);
        }

        // Tambahkan tag dengan bahasa yang berbeda jika sudah ada language_id
        // Pastikan language_id 1 dan 2 ada sebelum menjalankan kode ini
        if (\App\Models\Language::count() >= 2) {
            // Tag dalam Bahasa Inggris (ID 2)
            $englishTags = [
                'National News',
                'Politics',
                'Economy',
                'Education',
                'Health',
                'Technology',
                'Sports',
                'Entertainment',
                'Lifestyle',
                'Culture',
            ];

            foreach ($englishTags as $tagName) {
                Tag::create([
                    'tag_name' => $tagName,
                ]);
            }
        }

        // $this->command->info('Tag data seeded successfully!');
    }
}
