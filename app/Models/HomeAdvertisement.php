<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeAdvertisement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'above_search_ad',
        'above_search_ad_url',
        'above_search_ad_status',
        'above_footer_ad',
        'above_footer_ad_url',
        'above_footer_ad_status',
    ];

    /**
     * Get the formatted status for above search ad.
     *
     * @return bool
     */
    public function getAboveSearchActiveAttribute()
    {
        return $this->above_search_ad_status === 'Show';
    }

    /**
     * Get the formatted status for above footer ad.
     *
     * @return bool
     */
    public function getAboveFooterActiveAttribute()
    {
        return $this->above_footer_ad_status === 'Show';
    }
}
