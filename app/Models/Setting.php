<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'site_title',
        'site_description',
        'site_favicon',
        'site_logo',
        'email',
        'phone',
        'instagram',
        'linkedin',
        'github',
        'meta_keywords',
        'meta_description',
    ];

    public $timestamps = false;
}
