<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingGallery extends Model
{
    protected $fillable = [
        'title',
        'type',
        'media_url',
        'thumbnail_url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
