<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $fillable = [
        'school_name',
        'degree',
        'description',
        'field_of_study',
        'start_date',
        'end_date',
    ];
}
