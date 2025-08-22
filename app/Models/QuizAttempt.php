<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'user_id',
        'answers',
        'score',
        'total_questions',
        'correct_answers',
        'started_at',
        'finished_at',
        'time_remaining' // TAMBAHAN untuk mendukung persistent timer
    ];

    protected $casts = [
        'answers' => 'array',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'score' => 'integer',
        'total_questions' => 'integer',
        'correct_answers' => 'integer',
        'time_remaining' => 'integer' // TAMBAHAN
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPercentageAttribute()
    {
        if ($this->total_questions == 0) return 0;
        return round(($this->correct_answers / $this->total_questions) * 100);
    }

    public function getDurationAttribute()
    {
        if ($this->started_at && $this->finished_at) {
            $diff = $this->started_at->diff($this->finished_at);

            if ($diff->h > 0) {
                return $diff->h . ' jam ' . $diff->i . ' menit';
            } elseif ($diff->i > 0) {
                return $diff->i . ' menit ' . $diff->s . ' detik';
            } else {
                return $diff->s . ' detik';
            }
        }
        return 'N/A';
    }

    // TAMBAHAN: Helper methods untuk multiple attempts
    public function isCompleted()
    {
        return !is_null($this->finished_at);
    }

    public function isOngoing()
    {
        return is_null($this->finished_at);
    }

    public function getGradeAttribute()
    {
        $percentage = $this->percentage;

        if ($percentage >= 90) return 'A';
        if ($percentage >= 80) return 'B';
        if ($percentage >= 70) return 'C';
        if ($percentage >= 60) return 'D';
        return 'E';
    }

    public function getGradeColorAttribute()
    {
        switch ($this->grade) {
            case 'A': return 'text-purple-600 bg-purple-100';
            case 'B': return 'text-blue-600 bg-blue-100';
            case 'C': return 'text-teal-600 bg-teal-100';
            case 'D': return 'text-yellow-600 bg-yellow-100';
            case 'E': return 'text-red-600 bg-red-100';
            default: return 'text-gray-600 bg-gray-100';
        }
    }

    // NEW: Check if this attempt is passing (≥80%)
    public function isPassingAttribute()
    {
        return $this->percentage >= 80;
    }

    // NEW: Get status description
    public function getStatusAttribute()
    {
        if (!$this->isCompleted()) {
            return 'ongoing';
        }

        return $this->percentage >= 80 ? 'passed' : 'failed';
    }

    // NEW: Get status description in Indonesian
    public function getStatusTextAttribute()
    {
        switch ($this->status) {
            case 'ongoing':
                return 'Sedang Berlangsung';
            case 'passed':
                return 'Lulus';
            case 'failed':
                return 'Belum Lulus';
            default:
                return 'Unknown';
        }
    }

    // NEW: Get detailed status with color
    public function getStatusBadgeAttribute()
    {
        switch ($this->status) {
            case 'ongoing':
                return [
                    'text' => 'Sedang Berlangsung',
                    'class' => 'bg-blue-100 text-blue-800'
                ];
            case 'passed':
                return [
                    'text' => 'Lulus (' . $this->percentage . '%)',
                    'class' => 'bg-green-100 text-green-800'
                ];
            case 'failed':
                return [
                    'text' => 'Belum Lulus (' . $this->percentage . '%)',
                    'class' => 'bg-red-100 text-red-800'
                ];
            default:
                return [
                    'text' => 'Unknown',
                    'class' => 'bg-gray-100 text-gray-800'
                ];
        }
    }
}
