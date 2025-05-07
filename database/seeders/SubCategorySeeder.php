<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
                'show_on_menu' => 'Show',
                'show_on_home' => 'Show',
                'sub_category_order' => 1,
                'category_id' => 1,
                'language_id' => 8,
            ],
            [
                'id' => 54,
                'sub_category_name' => 'Jawa Timur',
                'show_on_menu' => 'Show',
                'show_on_home' => 'Show',
                'sub_category_order' => 2,
                'category_id' => 4,
                'language_id' => 8,
            ],
            [
                'id' => 55,
                'sub_category_name' => 'Gaya Hidup',
                'show_on_menu' => 'Show',
                'show_on_home' => 'Show',
                'sub_category_order' => 3,
                'category_id' => 2,
                'language_id' => 8,
            ],
            [
                'id' => 56,
                'sub_category_name' => 'Ekonomi & Bisnis',
                'show_on_menu' => 'Show',
                'show_on_home' => 'Show',
                'sub_category_order' => 4,
                'category_id' => 5,
                'language_id' => 8,
            ],
            [
                'id' => 57,
                'sub_category_name' => 'Wisata & Budaya',
                'show_on_menu' => 'Show',
                'show_on_home' => 'Show',
                'sub_category_order' => 5,
                'category_id' => 3,
                'language_id' => 8,
            ],
            [
                'id' => 58,
                'sub_category_name' => 'Pendidikan',
                'show_on_menu' => 'Show',
                'show_on_home' => 'Show',
                'sub_category_order' => 6,
                'category_id' => 7,
                'language_id' => 8,
            ],
            [
                'id' => 59,
                'sub_category_name' => 'Paparan Khusus',
                'show_on_menu' => 'Show',
                'show_on_home' => 'Show',
                'sub_category_order' => 7,
                'category_id' => 6,
                'language_id' => 8,
            ],
        ];

        // Add timestamps to each record
        $now = Carbon::now();
        foreach ($subCategories as &$subCategory) {
            $subCategory['created_at'] = $now;
            $subCategory['updated_at'] = $now;
        }

        // Insert data
        DB::table('sub_categories')->insert($subCategories);
    }
}
