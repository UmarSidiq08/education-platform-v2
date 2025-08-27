<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'subject',
        'description',
        'teacher_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke User (teacher/guru)
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Relasi ke MentorRequest
     */
    public function mentorRequests()
    {
        return $this->hasMany(MentorRequest::class);
    }

    /**
     * Relasi ke approved mentors through mentor_requests
     */
    public function approvedMentors()
    {
        return $this->belongsToMany(User::class, 'mentor_requests', 'teacher_class_id', 'mentor_id')
            ->wherePivot('status', 'approved')
            ->withPivot(['status', 'requested_at', 'approved_at']);
    }

    /**
     * Relasi ke ImplementationClass (ClassModel)
     */
    public function implementationClasses()
    {
        return $this->hasMany(ClassModel::class, 'teacher_class_id');
    }

    /**
     * Get full class name with teacher
     */
    public function getFullNameAttribute()
    {
        return $this->name . ' by ' . $this->teacher->name;
    }

    /**
     * Check if mentor has been approved for this teacher class
     */
    public function hasMentorApproved($mentorId)
    {
        return $this->mentorRequests()
            ->where('mentor_id', $mentorId)
            ->where('status', 'approved')
            ->exists();
    }

    /**
     * Get pending requests count
     */
    public function getPendingRequestsCountAttribute()
    {
        return $this->mentorRequests()->where('status', 'pending')->count();
    }
}
