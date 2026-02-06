<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentLoanRequest extends Model
{
    protected $fillable = [
        'user_id',
        'sport_id',
        'item_name',
        'quantity',
        'needed_date',
        'return_date',
        'purpose',
        'status',
        'admin_comment',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'needed_date' => 'date',
        'return_date' => 'date',
        'reviewed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
