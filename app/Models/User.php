<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'location',
        'bio',
        'avatar',
        'profile_photo_path',
        'expertise',
        'specialties',
        'rating',
        'total_students',
        'mentor_badge',
        'badge_color',
        'skills',
        'total_projects',
        'completed_tasks',
        'total_hours',
        'achievements',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'specialties' => 'array', // JSON to array
        'skills' => 'array', // JSON to array
        'rating' => 'decimal:2',
    ];

    /**
     * Check if user is mentor using Spatie Permission.
     */
    public function isGuru()
    {
        return $this->role === 'guru';
    }

    // Scopes for different user types
    public function scopeMentors($query)
    {
        return $query->where('role', 'mentor');
    }

    public function scopeStudents($query)
    {
        return $query->where('role', 'student');
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'guru');
    }

    // Helper methods
    public function isMentor()
    {
        return $this->role === 'mentor';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }

    public function isAdmin()
    {
        return $this->role === 'guru';
    }

    // Get avatar URL
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        
        if ($this->profile_photo_path) {
            return asset('storage/' . $this->profile_photo_path);
        }

        // Default avatar
        $initials = strtoupper(substr($this->name, 0, 2));
        return "https://via.placeholder.com/400x400/4F46E5/FFFFFF?text={$initials}";
    }

    // Get full rating stars
    public function getFullStarsAttribute()
    {
        return floor($this->rating);
    }

    // Check if has half star
    public function getHasHalfStarAttribute()
    {
        return ($this->rating - floor($this->rating)) >= 0.5;
    }
}