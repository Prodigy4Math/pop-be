<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DisasterSimulation extends Model
{
    use SoftDeletes;

    protected $table = 'disaster_simulations';

    protected $fillable = [
        'title',
        'description',
        'simulation_date',
        'start_time',
        'end_time',
        'location',
        'disaster_type',
        'max_participants',
        'evaluation_notes',
        'is_active',
    ];

    protected $casts = [
        'simulation_date' => 'date',
        'start_time' => 'string',
        'end_time' => 'string',
        'is_active' => 'boolean',
    ];
}
