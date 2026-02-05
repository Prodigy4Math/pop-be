<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DisasterMaterial extends Model
{
    use SoftDeletes;

    protected $table = 'disaster_materials';

    protected $fillable = [
        'title',
        'description',
        'type',
        'content_url',
        'content_text',
        'category',
        'difficulty_level',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
