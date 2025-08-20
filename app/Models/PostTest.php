<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'mentor_id',
        'title',
        'description',
        'time_limit',
        'passing_score',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'time_limit' => 'integer',
        'passing_score' => 'integer'
    ];

   public function class()
{
    return $this->belongsTo(ClassModel::class, 'class_id'); // Tambahkan 'class_id'
}

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function questions()
    {
        return $this->hasMany(PostTestQuestion::class)->orderBy('order');
    }

    public function attempts()
    {
        return $this->hasMany(PostTestAttempt::class);
    }

    public function getTotalPointsAttribute()
    {
        return $this->questions->sum('points');
    }

    public function hasBeenAttemptedBy($userId)
    {
        return $this->attempts()->where('user_id', $userId)->exists();
    }

    public function getAttemptByUser($userId)
    {
        return $this->attempts()->where('user_id', $userId)->first();
    }

    public function isCompletedByUser($userId)
    {
        return $this->attempts()
            ->where('user_id', $userId)
            ->whereNotNull('finished_at')
            ->exists();
    }
}
