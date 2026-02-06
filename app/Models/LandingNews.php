<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingNews extends Model
{
    protected $fillable = [
        'title',
        'excerpt',
        'content',
        'published_at',
        'is_active',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_active' => 'boolean',
    ];
}
