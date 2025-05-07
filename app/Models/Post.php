<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function rSubCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function rLanguage()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function editor()
    {
        return $this->belongsTo(Editor::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag'); // Sesuaikan dengan nama tabel pivot
    }
}
