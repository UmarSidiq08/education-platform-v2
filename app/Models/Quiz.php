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

    // UPDATED: Check apakah user sudah pernah mengerjakan quiz ini
    public function hasBeenAttemptedBy($userId)
    {
        return $this->attempts()
            ->where('user_id', $userId)
            ->whereNotNull('finished_at')
            ->exists();
    }

    // UPDATED: Get completed attempts by user untuk quiz ini
    public function getCompletedAttemptsByUser($userId)
    {
        return $this->attempts()
            ->where('user_id', $userId)
            ->whereNotNull('finished_at')
            ->orderBy('finished_at', 'desc')
            ->get();
    }

    // NEW: Get best attempt by user (skor tertinggi)
    public function getBestAttemptByUser($userId)
    {
        return $this->attempts()
            ->where('user_id', $userId)
            ->whereNotNull('finished_at')
            ->orderBy('score', 'desc')
            ->orderBy('correct_answers', 'desc')
            ->orderBy('finished_at', 'asc') // Jika skor sama, ambil yang lebih dulu
            ->first();
    }

    // DEPRECATED: Method ini sudah tidak relevan untuk multiple attempts
    // Tapi tetap dipertahankan untuk backward compatibility
    public function getAttemptByUser($userId)
    {
        return $this->getBestAttemptByUser($userId);
    }

    // Hitung total poin maksimal
    public function getTotalPointsAttribute()
    {
        return $this->questions->sum('points');
    }

    // UPDATED: Check if completed menggunakan best attempt dengan syarat minimal 80%
    public function isCompletedByUser($userId)
    {
        $bestAttempt = $this->getBestAttemptByUser($userId);

        if (!$bestAttempt) {
            return false;
        }

        // Material dianggap selesai hanya jika nilai >= 80%
        return $bestAttempt->percentage >= 80;
    }

    // NEW: Check if user has attempted (regardless of score)
    public function hasBeenAttemptedByUser($userId)
    {
        return $this->hasBeenAttemptedBy($userId);
    }

    // NEW: Get user's best score percentage
    public function getBestScorePercentageByUser($userId)
    {
        $bestAttempt = $this->getBestAttemptByUser($userId);
        return $bestAttempt ? $bestAttempt->percentage : 0;
    }

    // NEW: Get total attempts count by user
    public function getTotalAttemptsByUser($userId)
    {
        return $this->attempts()
            ->where('user_id', $userId)
            ->whereNotNull('finished_at')
            ->count();
    }

    // NEW: Check if user has ongoing attempt
    public function hasOngoingAttemptByUser($userId)
    {
        return $this->attempts()
            ->where('user_id', $userId)
            ->whereNull('finished_at')
            ->exists();
    }

    // NEW: Get ongoing attempt by user
    public function getOngoingAttemptByUser($userId)
    {
        return $this->attempts()
            ->where('user_id', $userId)
            ->whereNull('finished_at')
            ->first();
    }

    // NEW: Check if user passed the quiz (score >= 80%)
    public function isPassedByUser($userId)
    {
        return $this->isCompletedByUser($userId); // Sekarang sama dengan isCompletedByUser
    }

    // NEW: Get completion status with details for display
    public function getCompletionStatusByUser($userId)
    {
        $bestAttempt = $this->getBestAttemptByUser($userId);

        if (!$bestAttempt) {
            return [
                'attempted' => false,
                'completed' => false,
                'passed' => false,
                'score' => 0,
                'percentage' => 0,
                'status' => 'not_attempted'
            ];
        }

        $percentage = $bestAttempt->percentage;
        $passed = $percentage >= 80;

        return [
            'attempted' => true,
            'completed' => $passed,
            'passed' => $passed,
            'score' => $bestAttempt->score,
            'percentage' => $percentage,
            'status' => $passed ? 'completed' : 'attempted_not_passed',
            'attempt' => $bestAttempt
        ];
    }
}
