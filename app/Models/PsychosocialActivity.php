<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PsychosocialActivity extends Model
{
    use SoftDeletes;

    protected $table = 'psychosocial_activities';

    protected $fillable = [
        'name',
        'description',
        'category',
        'duration_minutes',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'duration_minutes' => 'integer',
    ];

    public function notes()
    {
        return $this->hasMany(PsychosocialNote::class, 'psychosocial_activity_id');
    }
}
