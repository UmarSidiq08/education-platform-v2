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



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'skills' => 'array', // Cast skills sebagai array
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

    /**
     * Check if user can upload video.
     */
    public function canUploadVideo(): bool
    {
        return $this->isMentor() && $this->is_verified;
    }

    /**
     * Get skills as array (accessor).
     */
    public function getSkillsListAttribute(): array
    {
        return $this->skills ?? [];
    }

    /**
     * Get skills as comma-separated string.
     */
    public function getSkillsStringAttribute(): string
    {
        if (!$this->skills || !is_array($this->skills)) {
            return '';
        }
        return implode(', ', $this->skills);
    }

    /**
     * Relationship: User has many activities.
     */
    public function activities()
    {
        return $this->hasMany(Activity::class, 'user_id');
    }

    /**
     * Relationship: User has many classes (as mentor).
     */
    public function classes()
    {
        return $this->hasMany(ClassModel::class, 'mentor_id');
    }


}
