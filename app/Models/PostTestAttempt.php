<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostTestAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_test_id',
        'user_id',
        'answers',
        'score',
        'total_questions',
        'correct_answers',
        'time_remaining',
        'started_at',
        'finished_at',
        'attempt_number', // Tambahkan ini
        'requires_approval', // Tambahkan ini
        'mentor_approved', // Tambahkan ini
        'approval_requested_at', // Tambahkan ini
        'approved_at', // Tambahkan ini
        'approval_reason' // Tambahkan ini
    ];

    protected $casts = [
        'answers' => 'array',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'score' => 'integer',
        'total_questions' => 'integer',
        'correct_answers' => 'integer',
        'time_remaining' => 'integer',
        'attempt_number' => 'integer', // Tambahkan ini
        'requires_approval' => 'boolean', // Tambahkan ini
        'mentor_approved' => 'boolean', // Tambahkan ini
        'approval_requested_at' => 'datetime', // Tambahkan ini
        'approved_at' => 'datetime' // Tambahkan ini
    ];

    public function postTest()
    {
        return $this->belongsTo(PostTest::class);
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

    public function isPassed()
    {
        if ($this->postTest && $this->finished_at) {
            $percentage = $this->percentage;
            return $percentage >= $this->postTest->passing_score;
        }
        return false;
    }
    public function isPendingApproval()
    {
        return $this->requires_approval && !$this->mentor_approved;
    }

    public function isApproved()
    {
        return $this->requires_approval && $this->mentor_approved;
    }

    public function canRetake()
    {
        // Bisa retake jika attempt < 2 atau sudah disetujui mentor
        return $this->attempt_number < 3 || $this->isApproved();
    }
}
