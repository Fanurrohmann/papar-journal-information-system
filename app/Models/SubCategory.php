<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        'slug',
        'show_on_menu',
        'show_on_home',
        'sub_category_order',
        'category_id',
        'language_id'
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug before saving the model
        static::creating(function ($subCategory) {
            $subCategory->slug = Str::slug($subCategory->sub_category_name);
        });

        static::updating(function ($subCategory) {
            if ($subCategory->isDirty('sub_category_name')) {
                $subCategory->slug = Str::slug($subCategory->sub_category_name);
            }
        });
    }

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
            ->where('status', 'published')
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
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('show_on_menu', 'Show');
    }

    /**
     * Scope a query to only include home-displayed sub-categories.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeShowOnHome($query)
    {
        return $query->where('show_on_home', 'Show');
    }

    /**
     * Get sub-categories ordered by their display order.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sub_category_order', 'asc');
    }
}
