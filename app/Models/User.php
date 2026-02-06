<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'age',
        'gender',
        'school',
        'phone',
        'guardian_name',
        'guardian_phone',
        'bio',
        'sport_interest_id',
        'participant_code',
        'barcode_svg',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user has admin role.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user has peserta role.
     */
    public function isPeserta(): bool
    {
        return $this->role === 'peserta';
    }

    /**
     * Relationships
     */
    public function attendance()
    {
        return $this->hasMany(AttendanceRecord::class);
    }

    public function progressNotes()
    {
        return $this->hasMany(FitnessProgressNote::class);
    }

    public function psychosocialNotes()
    {
        return $this->hasMany(PsychosocialNote::class);
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'user_badges')
            ->withPivot('earned_date')
            ->withTimestamps();
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function sportInterest()
    {
        return $this->belongsTo(Sport::class, 'sport_interest_id');
    }

    public function achievementSubmissions()
    {
        return $this->hasMany(AchievementSubmission::class);
    }

    public function equipmentLoanRequests()
    {
        return $this->hasMany(EquipmentLoanRequest::class);
    }
}
