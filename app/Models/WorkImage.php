<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkImage extends Model
{
    protected $table = 'works_images';

    protected $fillable = [
        'work_id',
        'image',
        'alt_text',
        'title',
        'order',
        'is_featured'
    ];

    protected $casts = [
        'is_featured' => 'boolean'
    ];

    public function work()
    {
        return $this->belongsTo(Work::class);
    }
}
