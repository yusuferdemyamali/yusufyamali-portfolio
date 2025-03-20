<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'image',
        'meta_description',
        'meta_keywords',
        'seo_title',
        'status',
        'published_at',
    ];
}
