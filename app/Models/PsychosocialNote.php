<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PsychosocialNote extends Model
{
    protected $table = 'psychosocial_notes';

    protected $fillable = [
        'user_id',
        'psychosocial_activity_id',
        'notes',
        'resilience_score',
        'mood',
    ];

    protected $casts = [
        'resilience_score' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activity()
    {
        return $this->belongsTo(PsychosocialActivity::class, 'psychosocial_activity_id');
    }
}
