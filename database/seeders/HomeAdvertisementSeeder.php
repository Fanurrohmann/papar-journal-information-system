<?php

namespace Database\Seeders;

use App\Models\HomeAdvertisement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HomeAdvertisementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing data
        HomeAdvertisement::truncate();

        // Create default advertisement settings
        HomeAdvertisement::create([
            'above_search_ad' => 'above_search_ad.jpg',
            'above_search_ad_url' => null,
            'above_search_ad_status' => 'Show',
            'above_footer_ad' => 'above_footer_ad.jpg',
            'above_footer_ad_url' => 'https://www.youtube.com/',
            'above_footer_ad_status' => 'Show',
        ]);
    }
}
