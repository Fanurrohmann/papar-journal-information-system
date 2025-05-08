<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'news_ticker_total',
        'news_ticker_status',
        'video_total',
        'video_status',
        'logo',
        'favicon',
        'top_bar_date_status',
        'top_bar_email',
        'top_bar_email_status',
        'theme_color_1',
        'theme_color_2',
        'analytic_id',
        'analytic_status',
        'disqus_code',
    ];

    /**
     * Get the settings singleton instance
     *
     * @return \App\Models\Setting
     */
    public static function getSettings()
    {
        return self::firstOrCreate(['id' => 1], [
            'news_ticker_total' => '5',
            'news_ticker_status' => 'Show',
            'video_total' => '6',
            'video_status' => 'Show',
            'logo' => 'logo.jpg',
            'favicon' => 'favicon.ico',
            'top_bar_date_status' => 'Show',
            'top_bar_email' => 'info@example.com',
            'top_bar_email_status' => 'Show',
            'theme_color_1' => '#0d6efd',
            'theme_color_2' => '#dc3545',
            'analytic_id' => '',
            'analytic_status' => 'Hide',
            'disqus_code' => '',
        ]);
    }
}
