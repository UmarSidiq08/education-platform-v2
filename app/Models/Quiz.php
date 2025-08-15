<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'material_id',
        'created_by',
        'time_limit',
        'total_questions',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'time_limit' => 'integer',
        'total_questions' => 'integer'
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class)->orderBy('order');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    // Check apakah user sudah pernah mengerjakan quiz ini
    public function hasBeenAttemptedBy($userId)
    {
        return $this->attempts()->where('user_id', $userId)->exists();
    }

    // Get attempt user untuk quiz ini
    public function getAttemptByUser($userId)
    {
        return $this->attempts()->where('user_id', $userId)->first();
    }

    // Hitung total poin maksimal
    public function getTotalPointsAttribute()
    {
        return $this->questions->sum('points');
    }
}
