<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingSchedule extends Model
{
    protected $fillable = [
        'sport_id',
        'title',
        'team_home',
        'team_away',
        'match_date',
        'location',
        'status',
        'score_home',
        'score_away',
        'is_featured',
    ];

    protected $casts = [
        'match_date' => 'datetime',
        'is_featured' => 'boolean',
    ];

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }
}
