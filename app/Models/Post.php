<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_category_id',
        'post_title',
        'post_subtitle',
        'post_slug',
        'content',
        'post_photo',
        'photo_caption', // ini adalah caption
        'visitors',
        'author_id',
        'admin_id',
        'editor_id',
        'is_share',
        'is_comment',
        'is_featured',
        'meta_description',
        // 'focus_keywords',
        'language_id',
        'status',
        'published_at',
        'schema_type'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_share' => 'boolean',
        'is_comment' => 'boolean',
        'is_featured' => 'boolean',
    ];

    // Relationship dengan SubCategory
    public function rSubCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    // Relationship dengan Category melalui SubCategory
    public function category()
    {
        return $this->hasOneThrough(
            Category::class,
            SubCategory::class,
            'id', // Foreign key pada SubCategory
            'id', // Foreign key pada Category
            'sub_category_id', // Local key pada Post
            'category_id' // Local key pada SubCategory
        );
    }

    // Relationship dengan Language
    public function rLanguage()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    // Relationship dengan User (Author)
    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    // Relationship dengan Admin
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    // Relationship dengan Editor
    public function editor()
    {
        return $this->belongsTo(Editor::class, 'editor_id');
    }

    // Relationship dengan Tags (Many-to-Many)
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }

    // // Relationship dengan Comments
    // public function comments()
    // {
    //     return $this->hasMany(Comment::class)->whereNull('parent_id');
    // }

    // Custom Accessor untuk Post URL/Slug
    public function getUrlAttribute()
    {
        return route('news_detail', $this->post_slug);
    }

    // Custom Accessor untuk Post's Reading Time
    public function getReadingTimeAttribute()
    {
        // Rata-rata kecepatan baca: 200 kata per menit
        $word_count = str_word_count(strip_tags($this->content));
        $minutes = ceil($word_count / 200);

        return $minutes;
    }

    // Accessor untuk Post tanggal publikasi yang diformat
    public function getFormattedDateAttribute()
    {
        return $this->published_at ? $this->published_at->format('d F Y H:i') : $this->created_at->format('d F Y H:i');
    }

    // Method untuk mendapatkan tag names sebagai string dipisahkan koma
    public function getTagNamesAttribute()
    {
        return $this->tags->pluck('tag_name')->implode(', ');
    }

    // Scope untuk publikasi yang aktif
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->where(function ($q) {
                $q->whereNull('published_at')
                    ->orWhere('published_at', '<=', Carbon::now());
            });
    }

    // Scope untuk featured post
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', 1);
    }

    // Scope untuk mencari post berdasarkan keyword
    public function scopeSearch($query, $keyword)
    {
        if ($keyword) {
            return $query->where('post_title', 'LIKE', "%{$keyword}%")
                ->orWhere('content', 'LIKE', "%{$keyword}%")
                ->orWhere('meta_description', 'LIKE', "%{$keyword}%")
                ->orWhere('focus_keywords', 'LIKE', "%{$keyword}%");
        }
        return $query;
    }

    // Scope untuk related posts berdasarkan kategori
    public function scopeRelated($query, $categoryId, $postId)
    {
        return $query->where('sub_category_id', $categoryId)
            ->where('id', '!=', $postId)
            ->published()
            ->latest('published_at')
            ->limit(4);
    }

    // Scope untuk posts dengan tag tertentu
    public function scopeHasTag($query, $tagId)
    {
        return $query->whereHas('tags', function ($q) use ($tagId) {
            $q->where('tags.id', $tagId);
        });
    }

    // Event untuk auto-generate slug jika belum ada
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->post_slug)) {
                $post->post_slug = Str::slug($post->post_title);
            }

            if (empty($post->published_at) && $post->status === 'published') {
                $post->published_at = Carbon::now();
            }

            // Default schema type jika tidak disetel
            if (empty($post->schema_type)) {
                $post->schema_type = 'NewsArticle';
            }
        });

        static::updating(function ($post) {
            // Update published_at jika status berubah menjadi published
            if ($post->isDirty('status') && $post->status === 'published' && empty($post->published_at)) {
                $post->published_at = Carbon::now();
            }
        });
    }

    // Method untuk mendapatkan format JSON-LD schema (untuk SEO)
    public function getSchemaJson()
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => $this->schema_type,
            'headline' => $this->post_title,
            'description' => $this->meta_description ?? Str::limit(strip_tags($this->content), 160),
            'image' => asset('uploads/post_photos/' . $this->post_photo),
            'datePublished' => $this->published_at ? $this->published_at->toIso8601String() : $this->created_at->toIso8601String(),
            'dateModified' => $this->updated_at->toIso8601String(),
            'author' => [
                '@type' => 'Person',
                'name' => $this->author->name ?? ($this->admin->name ?? 'Admin')
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => config('app.name'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('uploads/site_logo.png')
                ]
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $this->url
            ]
        ];

        // Menambah keywords jika ada tags
        if ($this->tags->count() > 0) {
            $schema['keywords'] = $this->tags->pluck('tag_name')->implode(', ');
        }

        return json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    // Menambah jumlah pengunjung
    public function incrementVisitors()
    {
        $this->increment('visitors');
        return $this;
    }
}
