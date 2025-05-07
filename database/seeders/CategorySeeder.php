<?php

namespace Database\Seeders;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert categories based on the provided data
        $categories = [
            [
                'category_name' => 'Nasional',
                'show_on_menu' => 'Show',
                'category_order' => 1,
                'language_id' => 1, // Assuming language_id 1 is for Indonesian
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'category_name' => 'Gaya Hidup',
                'show_on_menu' => 'Show',
                'category_order' => 2,
                'language_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'category_name' => 'Wisata dan Budaya',
                'show_on_menu' => 'Show',
                'category_order' => 3,
                'language_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'category_name' => 'Jawa Timur',
                'show_on_menu' => 'Show',
                'category_order' => 4,
                'language_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'category_name' => 'Ekonomi dan Bisnis',
                'show_on_menu' => 'Show',
                'category_order' => 5,
                'language_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'category_name' => 'Khusus',
                'show_on_menu' => 'Show',
                'category_order' => 6,
                'language_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'category_name' => 'Pendidikan',
                'show_on_menu' => 'Show',
                'category_order' => 7,
                'language_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        // Insert the categories using the model
        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
