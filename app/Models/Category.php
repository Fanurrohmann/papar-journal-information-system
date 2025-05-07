<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name',
        'show_on_menu',
        'category_order',
        'language_id'
    ];

    public function rSubCategory()
    {
        return $this->hasMany(SubCategory::class)
            ->where('show_on_menu', 'Show')
            ->orderBy('sub_category_order', 'asc');
    }

    public function rLanguage()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    // Additional relationship to get all subcategories regardless of menu visibility
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    // Get posts that belong to this category
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
