<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sub_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sub_category_name',
        'show_on_menu',
        'show_on_home',
        'sub_category_order',
        'category_id',
        'language_id'
    ];

    /**
     * Get the category that owns the sub-category.
     */
    public function rCategory()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Get the posts for the sub-category.
     */
    public function rPost()
    {
        return $this->hasMany(Post::class)
            ->where('status', 'acc')
            ->orderBy('id', 'desc');
    }

    /**
     * Get the language that owns the sub-category.
     */
    public function rLanguage()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    /**
     * Scope a query to only include active sub-categories.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('show_on_menu', 'Show');
    }

    /**
     * Scope a query to only include home-displayed sub-categories.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeShowOnHome($query)
    {
        return $query->where('show_on_home', 'Show');
    }

    /**
     * Get sub-categories ordered by their display order.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sub_category_order', 'asc');
    }
}
