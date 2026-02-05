<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sport extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'category',
        'difficulty_level',
        'icon',
    ];

    public function schedules()
    {
        return $this->hasMany(FitnessSchedule::class);
    }

    public function progressNotes()
    {
        return $this->hasMany(FitnessProgressNote::class);
    }
}
