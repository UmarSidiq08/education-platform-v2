<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Activity;
use App\Models\ClassModel;
use App\Models\QuizAttempt;

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
     * Get user's progress for a specific class
     */
    public function getClassProgress($classId)
    {
        $class = ClassModel::with([
            'materials.quizzes' => function ($query) {
                $query->where('is_active', true);
            }
        ])->find($classId);

        if (!$class) {
            return [
                'total_materials' => 0,
                'completed_materials' => 0,
                'progress_percentage' => 0,
                'completed_quizzes' => collect()
            ];
        }

        $totalMaterials = $class->materials->count();
        $completedMaterials = 0;
        $completedQuizzes = collect();

        foreach ($class->materials as $material) {
            $activeQuiz = $material->quizzes->where('is_active', true)->first();

            if ($activeQuiz && $activeQuiz->isCompletedByUser($this->id)) {
                $completedMaterials++;
                $attempt = $activeQuiz->getAttemptByUser($this->id);
                $completedQuizzes->push([
                    'material_title' => $material->title,
                    'quiz_title' => $activeQuiz->title,
                    'score' => $attempt->score ?? 0,
                    'completed_at' => $attempt->finished_at ?? null
                ]);
            }
        }

        $progressPercentage = $totalMaterials > 0
            ? round(($completedMaterials / $totalMaterials) * 100)
            : 0;

        return [
            'total_materials' => $totalMaterials,
            'completed_materials' => $completedMaterials,
            'progress_percentage' => $progressPercentage,
            'completed_quizzes' => $completedQuizzes
        ];
    }

    /**
     * Check if user has completed all materials in a class
     */
    public function hasCompletedAllMaterials($classId)
    {
        $progress = $this->getClassProgress($classId);
        return $progress['progress_percentage'] == 100;
    }

    /**
     * Get user's overall learning statistics
     */
    public function getLearningStats()
    {
        $totalAttempts = $this->quizAttempts()
            ->whereNotNull('finished_at')
            ->count();

        $averageScore = $this->quizAttempts()
            ->whereNotNull('finished_at')
            ->avg('score') ?? 0;

        $totalClasses = ClassModel::whereHas('materials.quizzes.attempts', function ($query) {
            $query->where('user_id', $this->id)
                ->whereNotNull('finished_at');
        })->distinct()->count();

        $completedClasses = ClassModel::whereHas('materials', function ($query) {
            $query->whereHas('quizzes', function ($subQuery) {
                $subQuery->where('is_active', true)
                    ->whereHas('attempts', function ($attemptQuery) {
                        $attemptQuery->where('user_id', $this->id)
                            ->whereNotNull('finished_at');
                    });
            });
        })->get()->filter(function ($class) {
            return $this->hasCompletedAllMaterials($class->id);
        })->count();

        return [
            'total_quiz_attempts' => $totalAttempts,
            'average_score' => round($averageScore, 1),
            'total_classes_enrolled' => $totalClasses,
            'completed_classes' => $completedClasses,
            'completion_rate' => $totalClasses > 0
                ? round(($completedClasses / $totalClasses) * 100)
                : 0
        ];
    }

    /**
     * Get completed classes with post test score >= 80%
     * Using Data Transfer Object approach (returns array structure)
     */
    public function getCompletedClassesWithPostTest()
    {
        return ClassModel::with(['mentor', 'postTests', 'materials'])
            ->whereHas('postTests.attempts', function ($query) {
                $query->where('user_id', $this->id)
                    ->whereNotNull('finished_at')
                    ->where(function ($subQuery) {
                        $subQuery->where('requires_approval', false)
                            ->orWhere('is_approval_attempt', true);
                    });
            })
            ->get()
            ->map(function ($class) {
                $bestAttempt = $this->getBestPostTestAttemptForClass($class);

                if ($bestAttempt && $bestAttempt->getPercentageAttribute() >= 80) {
                    return [
                        'class' => $class,
                        'best_attempt' => $bestAttempt,
                        'completion_date' => $bestAttempt->finished_at,
                        'score' => $bestAttempt->score,
                        'percentage' => $bestAttempt->getPercentageAttribute(),
                        'total_materials' => $class->materials->count()
                    ];
                }

                return null;
            })
            ->filter()
            ->sortByDesc('completion_date');
    }

    /**
     * Alternative: Get completed classes with dynamic properties (original approach)
     * Keep this for backward compatibility if needed
     */
    public function getCompletedClassesWithDynamicProps()
    {
        return ClassModel::with(['mentor', 'postTests', 'materials'])
            ->whereHas('postTests.attempts', function ($query) {
                $query->where('user_id', $this->id)
                    ->whereNotNull('finished_at')
                    ->where(function ($subQuery) {
                        $subQuery->where('requires_approval', false)
                            ->orWhere('is_approval_attempt', true);
                    });
            })
            ->get()
            ->map(function ($class) {
                $bestAttempt = $this->getBestPostTestAttemptForClass($class);

                if ($bestAttempt && $bestAttempt->getPercentageAttribute() >= 80) {
                    // Use helper method instead of direct assignment
                    $this->addAchievementPropertiesToClass($class, $bestAttempt);
                    return $class;
                }

                return null;
            })
            ->filter()
            ->sortByDesc('completion_date');
    }

    /**
     * Helper method to add achievement properties to class model
     * This helps with IDE recognition and makes code more maintainable
     *
     * @param ClassModel $class
     * @param PostTestAttempt $bestAttempt
     * @return ClassModel
     */
    private function addAchievementPropertiesToClass($class, $bestAttempt)
    {
        $class->best_attempt = $bestAttempt;
        $class->completion_date = $bestAttempt->finished_at;
        $class->score = $bestAttempt->score;
        $class->percentage = $bestAttempt->getPercentageAttribute();
        $class->total_materials = $class->materials->count();

        return $class;
    }

    /**
     * Get best post test attempt for a specific class
     */
    public function getBestPostTestAttemptForClass($class)
    {
        $activePostTest = $class->postTests()->where('is_active', true)->first();

        if (!$activePostTest) {
            return null;
        }

        return $activePostTest->attempts()
            ->where('user_id', $this->id)
            ->whereNotNull('finished_at')
            ->where(function ($query) {
                $query->where('requires_approval', false)
                    ->orWhere('is_approval_attempt', true);
            })
            ->orderBy('score', 'desc')
            ->first();
    }

    /**
     * Check if user has completed post test for a specific class with score >= 80%
     */
    public function hasCompletedPostTestForClass($classId)
    {
        $class = ClassModel::with('postTests')->find($classId);

        if (!$class) {
            return false;
        }

        $attempt = $this->getBestPostTestAttemptForClass($class);

        return $attempt && $attempt->getPercentageAttribute() >= 80;
    }

    /**
     * Get post test achievement statistics
     * Updated to work with Data Transfer Object approach
     */
    public function getPostTestAchievementStats()
    {
        $completedClasses = $this->getCompletedClassesWithPostTest();

        $totalCompleted = $completedClasses->count();
        $averageScore = $completedClasses->avg('percentage') ?? 0;
        $perfectScores = $completedClasses->where('percentage', 100)->count();
        $highScores = $completedClasses->where('percentage', '>=', 90)->count();

        // Get total post test attempts
        $totalAttempts = PostTestAttempt::where('user_id', $this->id)
            ->whereNotNull('finished_at')
            ->where(function ($query) {
                $query->where('requires_approval', false)
                    ->orWhere('is_approval_attempt', true);
            })
            ->count();

        $successRate = $totalAttempts > 0 ? round(($totalCompleted / $totalAttempts) * 100, 1) : 0;

        return [
            'total_completed' => $totalCompleted,
            'average_score' => round($averageScore, 1),
            'perfect_scores' => $perfectScores,
            'high_scores' => $highScores,
            'total_attempts' => $totalAttempts,
            'success_rate' => $successRate
        ];
    }

    public function teacherClasses()
    {
        return $this->hasMany(TeacherClass::class, 'teacher_id');
    }

    // Relasi MentorRequest untuk mentor
    public function mentorRequests()
    {
        return $this->hasMany(MentorRequest::class, 'mentor_id');
    }

    // Relasi approved teacher classes untuk mentor
    public function approvedTeacherClasses()
    {
        return $this->belongsToMany(TeacherClass::class, 'mentor_requests', 'mentor_id', 'teacher_class_id')
            ->wherePivot('status', 'approved')
            ->withPivot(['status', 'requested_at', 'approved_at']);
    }
}
