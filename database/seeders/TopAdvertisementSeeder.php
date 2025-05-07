<?php

namespace Database\Seeders;

use App\Models\TopAdvertisement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TopAdvertisementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Delete existing records to avoid duplicate entries
        // TopAdvertisement::truncate();

        // Create sample advertisements
        $advertisements = [
            [
                'top_ad' => 'top_ad.jpg',
                'top_ad_url' => null,
                'top_ad_status' => 'Show',
            ],
        ];

        // Insert the sample advertisements
        foreach ($advertisements as $advertisement) {
            TopAdvertisement::create($advertisement);
        }
    }
}
