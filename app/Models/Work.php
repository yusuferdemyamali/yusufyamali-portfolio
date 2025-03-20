<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'demo_link',
        'work_type',
        'github_link',
        'technologies',
        'order',
        'image',
        'status'
    ];

    protected $casts = [
        'completion_date' => 'date',
        'status' => 'boolean'
    ];

    // İlişkili görselleri getir
    public function images()
    {
        return $this->hasMany(WorkImage::class);
    }

}
