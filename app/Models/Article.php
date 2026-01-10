<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'content',
        'thumbnail',
        'is_published',
        'view_count'
    ];

    public function category()
    {
        return $this->belongsTo(ArticleCategory::class, 'category_id');
    }
}
