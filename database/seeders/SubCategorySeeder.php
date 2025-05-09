<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Data from the provided table
        $subCategories = [
            [
                'id' => 53,
                'sub_category_name' => 'nasional',
                'slug' => 'nasional',
                'show_on_menu' => 'Show',
                'show_on_home' => 'Show',
                'sub_category_order' => 1,
                'category_id' => 1,
                'language_id' => 1,
            ],
            [
                'id' => 54,
                'sub_category_name' => 'Jawa Timur',
                'slug' => 'jawa-timur',
                'show_on_menu' => 'Show',
                'show_on_home' => 'Show',
                'sub_category_order' => 2,
                'category_id' => 4,
                'language_id' => 1,
            ],
            [
                'id' => 55,
                'sub_category_name' => 'Gaya Hidup',
                'slug' => 'gaya-hidup',
                'show_on_menu' => 'Show',
                'show_on_home' => 'Show',
                'sub_category_order' => 3,
                'category_id' => 2,
                'language_id' => 1,
            ],
            [
                'id' => 56,
                'sub_category_name' => 'Ekonomi & Bisnis',
                'slug' => 'ekonomi-bisnis',
                'show_on_menu' => 'Show',
                'show_on_home' => 'Show',
                'sub_category_order' => 4,
                'category_id' => 5,
                'language_id' => 1,
            ],
            [
                'id' => 57,
                'sub_category_name' => 'Wisata & Budaya',
                'slug' => 'wisata-budaya',
                'show_on_menu' => 'Show',
                'show_on_home' => 'Show',
                'sub_category_order' => 5,
                'category_id' => 3,
                'language_id' => 1,
            ],
            [
                'id' => 51,
                'sub_category_name' => 'Pendidikan',
                'slug' => 'pendidikan',
                'show_on_menu' => 'Show',
                'show_on_home' => 'Show',
                'sub_category_order' => 6,
                'category_id' => 7,
                'language_id' => 1,
            ],
            [
                'id' => 59,
                'sub_category_name' => 'Paparan Khusus',
                'slug' => 'paparan-khusus',
                'show_on_menu' => 'Show',
                'show_on_home' => 'Show',
                'sub_category_order' => 7,
                'category_id' => 6,
                'language_id' => 1,
            ],
        ];

        // Add timestamps to each record
        $now = Carbon::now();
        foreach ($subCategories as &$subCategory) {
            // Generate slug from sub_category_name if not already set
            if (!isset($subCategory['slug'])) {
                $subCategory['slug'] = Str::slug($subCategory['sub_category_name']);
            }

            $subCategory['created_at'] = $now;
            $subCategory['updated_at'] = $now;
        }

        // Insert data
        DB::table('sub_categories')->insert($subCategories);
    }
}
