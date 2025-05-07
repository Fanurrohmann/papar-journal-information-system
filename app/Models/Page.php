<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'about_title',
        'about_detail',
        'about_status',
        'faq_title',
        'faq_detail',
        'faq_status',
        'contact_title',
        'contact_detail',
        'contact_map',
        'contact_status',
        'terms_title',
        'terms_detail',
        'terms_status',
        'privacy_title',
        'privacy_detail',
        'privacy_status',
        'disclaimer_title',
        'disclaimer_detail',
        'disclaimer_status',
        'login_title',
        'login_status',
        'language_id'
    ];

    public function rLanguage()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
