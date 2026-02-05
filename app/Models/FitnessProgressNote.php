<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FitnessProgressNote extends Model
{
    protected $table = 'fitness_progress_notes';

    protected $fillable = [
        'user_id',
        'sport_id',
        'note_date',
        'progress_notes',
        'performance_level',
        'endurance_level',
        'strength_level',
        'recommendations',
    ];

    protected $casts = [
        'note_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }
}
