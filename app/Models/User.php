<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Activity;
use App\Models\ClassModel;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'is_verified',
        'password',
        'phone',
        'location',
        'bio',
        'skills',
        'photo',
        'password',
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
        'is_verified' => 'boolean',
    ];

    /**
     * Check if user is mentor using Spatie Permission.
     */
    public function isGuru()
    {
        return $this->role === 'guru';
    }
    public function isMentor()
    {
        return $this->role === 'mentor';
    }

    public function isSiswa()
    {
        return $this->role === 'siswa';
    }
    public function canUploadVideo(): bool
    {
        return $this->isMentor() && $this->is_verified;
    }
    public function getSkillsListAttribute(): array
    {
        return $this->skills ?? [];
    }
    public function getSkillsStringAttribute(): string
    {
        if (!$this->skills || !is_array($this->skills)) {
            return '';
        }
        return implode(', ', $this->skills);
    }
    public function activities()
    {
        return $this->hasMany(Activity::class, 'user_id');
    }
    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }
    public function classes()
    {
        return $this->hasMany(ClassModel::class, 'mentor_id');
    }
    public function mentorClasses()
    {
        return $this->hasMany(ClassModel::class, 'mentor_id');
    }



    // Scopes for different user types
    public function scopeMentors($query)
    {
        return $query->where('role', 'mentor');
    }

    public function scopeStudents($query)
    {
        return $query->where('role', 'siswa');
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'guru');
    }

    // Helper methods


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



    /**
     * Relationship: User has many classes as mentor (alias).
     */

}
