<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'news_ticker_total' => '5',
            'news_ticker_status' => 'Show',
            'video_total' => '5',
            'video_status' => 'Show',
            'logo' => 'logo.jpg',
            'favicon' => 'LOGO-JP.jpeg',
            'top_bar_date_status' => 'Hide',
            'top_bar_email' => 'jurnalpapar@gmail.com',
            'top_bar_email_status' => 'Show',
            'theme_color_1' => '3013A5',
            'theme_color_2' => '093A23',
            'analytic_id' => 'G-WZSQ1MD13S',
            'analytic_status' => 'Hide',
            'disqus_code' => "<script>
                        (function() { // DON'T EDIT BELOW THIS LINE
                            var d = document,
                                s = d.createElement('script');
                            s.src = 'https://news-portal-com.disqus.com/embed.js';
                            s.setAttribute('data-timestamp', +new Date());
                            (d.head || d.body).appendChild(s);
                        })();</script>",
        ]);
    }
}
