<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
        'company_name',
        'position',
        'description',
        'start_date',
        'end_date',
        'location',
    ];
}
