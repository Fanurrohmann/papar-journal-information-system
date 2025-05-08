<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'tag_name',
        'slug',
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
        static::creating(function ($tag) {
            $tag->slug = Str::slug($tag->tag_name);
        });

        static::updating(function ($tag) {
            if ($tag->isDirty('tag_name')) {
                $tag->slug = Str::slug($tag->tag_name);
            }
        });
    }

    // Relationship dengan Post (Many-to-Many)
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_tag');
    }
}
