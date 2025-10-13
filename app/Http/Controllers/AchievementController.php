<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\PostTestAttempt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AchievementController extends Controller
{
    /**
     * Display user's achievements page
     */
    public function index()
    {
        $user = Auth::user();



        // Get completed classes with post test scores >= 80%
        $completedClasses = $this->getCompletedClasses($user->id);

        // Get achievement statistics
        $stats = $this->getAchievementStats($user->id);

        // Get recent achievements (last 5)
        $recentAchievements = $completedClasses->take(5);

        return view('achievements.index', compact('completedClasses', 'stats', 'recentAchievements'));
    }

    /**
     * Get all classes completed by user with post test score >= 80%
     */
    private function getCompletedClasses($userId)
    {
        return ClassModel::with(['mentor', 'postTests', 'materials'])
            ->whereHas('postTests.attempts', function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->whereNotNull('finished_at')
                    ->where(function ($subQuery) {
                        $subQuery->where('requires_approval', false)
                            ->orWhere('is_approval_attempt', true);
                    });
            })
            ->get()
            ->map(function ($class) use ($userId) {
                // Get the best attempt for this class
                $bestAttempt = $this->getBestPostTestAttempt($class, $userId);

                if ($bestAttempt && $bestAttempt->getPercentageAttribute() >= 80) {
                    // Using the helper method instead of direct assignment
                    $class->setAchievementData($bestAttempt, $class->materials->count());

                    return $class;
                }

                return null;
            })
            ->filter() // Remove null values
            ->sortByDesc('completion_date');
    }

    /**
     * Alternative approach: Create a proper data transfer object
     */
    private function getCompletedClassesAsArray($userId)
    {
        return ClassModel::with(['mentor', 'postTests', 'materials'])
            ->whereHas('postTests.attempts', function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->whereNotNull('finished_at')
                    ->where(function ($subQuery) {
                        $subQuery->where('requires_approval', false)
                            ->orWhere('is_approval_attempt', true);
                    });
            })
            ->get()
            ->map(function ($class) use ($userId) {
                $bestAttempt = $this->getBestPostTestAttempt($class, $userId);

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
     * Get the best post test attempt for a specific class and user
     */
    private function getBestPostTestAttempt($class, $userId)
    {
        $activePostTest = $class->postTests()->where('is_active', true)->first();

        if (!$activePostTest) {
            return null;
        }

        return $activePostTest->attempts()
            ->where('user_id', $userId)
            ->whereNotNull('finished_at')
            ->where(function ($query) {
                $query->where('requires_approval', false)
                    ->orWhere('is_approval_attempt', true);
            })
            ->orderBy('score', 'desc')
            ->first();
    }

    /**
     * Get achievement statistics for the user
     */
    private function getAchievementStats($userId)
    {
        $completedClasses = $this->getCompletedClasses($userId);

        $totalCompleted = $completedClasses->count();
        $averageScore = $completedClasses->avg('percentage') ?? 0;
        $perfectScores = $completedClasses->where('percentage', 100)->count();
        $highScores = $completedClasses->where('percentage', '>=', 90)->count();

        // Get total post test attempts
        $totalAttempts = PostTestAttempt::where('user_id', $userId)
            ->whereNotNull('finished_at')
            ->where(function ($query) {
                $query->where('requires_approval', false)
                    ->orWhere('is_approval_attempt', true);
            })
            ->count();

        // Calculate success rate
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

    /**
     * Get achievement statistics for the user
     */

    private function getAchievementBadges($userId)
    {
        $stats = $this->getAchievementStats($userId);
        $badges = [];

        // Beginner Badge
        if ($stats['total_completed'] >= 1) {
            $badges[] = [
                'name' => 'First Achievement',
                'description' => 'Menyelesaikan post test pertama dengan nilai ≥ 80%',
                'icon' => 'trophy',
                'color' => 'bg-yellow-500'
            ];
        }

        // Scholar Badge
        if ($stats['total_completed'] >= 5) {
            $badges[] = [
                'name' => 'Scholar',
                'description' => 'Menyelesaikan 5 kelas dengan nilai ≥ 80%',
                'icon' => 'academic-cap',
                'color' => 'bg-blue-500'
            ];
        }

        // Expert Badge
        if ($stats['total_completed'] >= 10) {
            $badges[] = [
                'name' => 'Expert Learner',
                'description' => 'Menyelesaikan 10 kelas dengan nilai ≥ 80%',
                'icon' => 'star',
                'color' => 'bg-purple-500'
            ];
        }

        // Perfect Score Badge
        if ($stats['perfect_scores'] >= 1) {
            $badges[] = [
                'name' => 'Perfect Score',
                'description' => 'Mendapatkan nilai sempurna (100%) dalam post test',
                'icon' => 'sparkles',
                'color' => 'bg-green-500'
            ];
        }

        // High Achiever Badge
        if ($stats['high_scores'] >= 3) {
            $badges[] = [
                'name' => 'High Achiever',
                'description' => 'Mendapatkan nilai ≥ 90% dalam 3 post test',
                'icon' => 'fire',
                'color' => 'bg-red-500'
            ];
        }

        // Consistent Performer Badge
        if ($stats['average_score'] >= 90) {
            $badges[] = [
                'name' => 'Consistent Performer',
                'description' => 'Rata-rata nilai post test ≥ 90%',
                'icon' => 'chart-bar',
                'color' => 'bg-indigo-500'
            ];
        }

        return $badges;
    }

    /**
     * Show detailed achievement information
     */
    public function show($classId)
    {
        $user = Auth::user();
        // Cari class berdasarkan ID
        $class = ClassModel::with(['mentor', 'postTests.questions', 'materials'])->findOrFail($classId);

        // Check if user has completed this class
        $bestAttempt = $this->getBestPostTestAttempt($class, $user->id);

        if (!$bestAttempt || $bestAttempt->getPercentageAttribute() < 80) {
            abort(404, 'Achievement tidak ditemukan untuk kelas ini.');
        }

        // Get all attempts for this class
        $activePostTest = $class->postTests()->where('is_active', true)->first();
        $attempts = $activePostTest ? $activePostTest->attempts()
            ->where('user_id', $user->id)
            ->whereNotNull('finished_at')
            ->where(function ($query) {
                $query->where('requires_approval', false)
                    ->orWhere('is_approval_attempt', true);
            })
            ->orderBy('finished_at')
            ->get() : collect();

        return view('achievements.show', compact('class', 'bestAttempt', 'attempts'));
    }
}
