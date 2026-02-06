<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingStanding extends Model
{
    protected $fillable = [
        'sport_id',
        'team_name',
        'position',
        'played',
        'wins',
        'draws',
        'losses',
        'points',
        'goals_for',
        'goals_against',
    ];

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }
}
