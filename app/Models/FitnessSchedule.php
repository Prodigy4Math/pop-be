<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FitnessSchedule extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'sport_id',
        'schedule_date',
        'start_time',
        'end_time',
        'location',
        'description',
        'max_participants',
        'is_active',
    ];

    protected $casts = [
        'schedule_date' => 'date',
        'start_time' => 'string',
        'end_time' => 'string',
        'is_active' => 'boolean',
    ];

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function attendance()
    {
        return $this->hasMany(AttendanceRecord::class);
    }
}
