<?php

namespace App\Http\Controllers;

use App\Models\PostTest;
use App\Models\ClassModel;
use App\Models\PostTestQuestion;
use App\Models\PostTestAttempt;
use App\Models\Material;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PostTestController extends Controller
{
    public function create(ClassModel $class)
    {
        if (Auth::id() !== $class->mentor_id || Auth::user()->role !== 'mentor') {
            abort(403, 'Unauthorized');
        }

        return view('post_tests.create', compact('class'));
    }

    public function store(Request $request, ClassModel $class)
    {
        if (Auth::id() !== $class->mentor_id || Auth::user()->role !== 'mentor') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_limit' => 'required|integer|min:1',
            'passing_score' => 'required|integer|min:1|max:100',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // TAMBAHKAN INI
            'questions.*.options' => 'required|array|min:2',
            'questions.*.correct_answer' => 'required|integer|min:0',
            'questions.*.points' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();

        try {
            $class->postTests()->update(['is_active' => false]);

            $postTest = PostTest::create([
                'title' => $request->title,
                'description' => $request->description,
                'class_id' => $class->id,
                'mentor_id' => Auth::id(),
                'time_limit' => $request->time_limit,
                'passing_score' => $request->passing_score,
                'is_active' => true
            ]);

            foreach ($request->questions as $index => $questionData) {
                $imagePath = null;

                // Handle image upload - TAMBAHKAN INI
                if (isset($questionData['image']) && $questionData['image'] instanceof \Illuminate\Http\UploadedFile) {
                    $imagePath = $questionData['image']->store('post-test-images', 'public');
                }

                PostTestQuestion::create([
                    'post_test_id' => $postTest->id,
                    'question' => $questionData['question'],
                    'image' => $imagePath, // TAMBAHKAN INI
                    'options' => $questionData['options'],
                    'correct_answer' => (int)$questionData['correct_answer'],
                    'points' => (int)$questionData['points'],
                    'order' => $index + 1
                ]);
            }

            DB::commit();

            return redirect()->route('classes.learn', $class)
                ->with('success', 'Post Test berhasil ditambahkan untuk kelas: ' . $class->name);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating post test: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat membuat post test.')
                ->withInput();
        }
    }

    public function show(PostTest $postTest)
    {
        $user = Auth::user();
        $class = $postTest->class;

        // Cek apakah user berhak mengakses post test
        if ($user->role === 'siswa') {
            if (!$this->hasCompletedAllPreTests($class->id, $user->id)) {
                abort(403, 'Anda harus menyelesaikan semua pre test terlebih dahulu.');
            }
        } elseif ($user->role === 'mentor') {
            // PEMILIK KELAS: Tetap fungsi CRUD dan approve (tidak berubah)
            if ($class->mentor_id === $user->id) {
                $postTest->load(['questions', 'class']);
                return view('post_tests.show', [
                    'postTest' => $postTest,
                    'class' => $class
                ]);
            }
            // MENTOR NON-PEMILIK: Cek pre test juga (sama kayak siswa)
            if (!$this->hasCompletedAllPreTests($class->id, $user->id)) {
                abort(403, 'Anda harus menyelesaikan semua pre test terlebih dahulu.');
            }
        } else {
            abort(403, 'Unauthorized');
        }

        // LOGIKA UNTUK SISWA DAN MENTOR NON-PEMILIK (SAMA PERSIS)
        // CEK APAKAH ADA ATTEMPT YANG SEDANG BERJALAN
        $ongoingAttempt = $postTest->attempts()
            ->where('user_id', $user->id)
            ->whereNull('finished_at')
            ->first();

        if ($ongoingAttempt) {
            $timeRemaining = $ongoingAttempt->time_remaining;

            if ($timeRemaining <= 0) {
                $this->autoSubmitPostTest($postTest, $ongoingAttempt);
                return redirect()->route('post_tests.show', $postTest)
                    ->with('warning', 'Waktu post test telah habis. Jawaban Anda telah otomatis terkirim.');
            }

            $postTest->load(['questions', 'class']);
            return view('post_tests.take', [
                'postTest' => $postTest,
                'attempt' => $ongoingAttempt,
                'timeRemaining' => $timeRemaining,
                'class' => $class
            ]);
        }

        // HITUNG SEMUA ATTEMPT YANG SUDAH SELESAI (normal + approval attempts)
        $totalFinishedAttempts = $postTest->attempts()
            ->where('user_id', $user->id)
            ->whereNotNull('finished_at')
            ->where(function ($query) {
                $query->where('requires_approval', false)
                    ->orWhere('is_approval_attempt', true);
            })
            ->count();

        // Cek apakah ada pending approval (yang belum di-approve)
        $pendingApproval = $postTest->attempts()
            ->where('user_id', $user->id)
            ->where('requires_approval', true)
            ->where('mentor_approved', false)
            ->exists();

        // Ambil attempt terakhir untuk cek nilai
        $lastFinishedAttempt = $postTest->attempts()
            ->where('user_id', $user->id)
            ->whereNotNull('finished_at')
            ->where(function ($query) {
                $query->where('requires_approval', false)
                    ->orWhere('is_approval_attempt', true);
            })
            ->latest('finished_at')
            ->first();

        // Cek apakah sudah lulus (nilai >= 80%)
        $lastScore = $lastFinishedAttempt ? $lastFinishedAttempt->getPercentageAttribute() : 0;
        $hasPassed = $lastScore >= 80;

        if ($hasPassed) {
            // Sudah lulus, tampilkan hasil
            $postTest->load(['questions', 'class']);
            return view('post_tests.result', [
                'postTest' => $postTest,
                'attempt' => $lastFinishedAttempt,
                'class' => $class
            ]);
        }

        // BELUM LULUS - TENTUKAN APAKAH BISA MENGERJAKAN TEST
        $canTakeTest = false;
        $hasAvailableApproval = false;

        if ($totalFinishedAttempts < 2) {
            // Attempt 1-2: boleh langsung
            $canTakeTest = true;
        } else {
            // Attempt 3+: perlu cek approval yang tersedia
            $availableApprovalQuery = $postTest->attempts()
                ->where('user_id', $user->id)
                ->where('requires_approval', true)
                ->where('mentor_approved', true)
                ->where('is_used', false);

            // Jika ada attempt terakhir, approval harus dibuat setelah attempt terakhir selesai
            if ($lastFinishedAttempt) {
                $availableApprovalQuery = $availableApprovalQuery->where('approved_at', '>', $lastFinishedAttempt->finished_at);
            }

            $hasAvailableApproval = $availableApprovalQuery->exists();
            $canTakeTest = $hasAvailableApproval;
        }

        // LOGIKA TAMPILAN BERDASARKAN STATUS
        if ($canTakeTest) {
            // Boleh mengerjakan, tampilkan form
            $postTest->load(['questions', 'class']);
            return view('post_tests.take', [
                'postTest' => $postTest,
                'class' => $class
            ]);
        } else {
            // Tidak boleh mengerjakan
            if ($pendingApproval) {
                // Ada pending approval, tunggu persetujuan
                $message = 'Anda sudah meminta approval mentor. Tunggu persetujuan.';
            } else {
                // Perlu request approval baru
                if ($totalFinishedAttempts >= 2) {
                    $message = 'Anda sudah mencapai batas maksimal attempt. Silakan request approval mentor untuk percobaan ke-' . ($totalFinishedAttempts + 1) . '.';
                } else {
                    $message = 'Anda perlu approval mentor untuk melanjutkan.';
                }
            }

            return view('post_tests.blocked', [
                'postTest' => $postTest,
                'class' => $class,
                'message' => $message,
                'canRequestApproval' => !$pendingApproval,
                'attempts' => $postTest->attempts()
                    ->where('user_id', $user->id)
                    ->whereNotNull('finished_at')
                    ->where(function ($query) {
                        $query->where('requires_approval', false)
                            ->orWhere('is_approval_attempt', true);
                    })
                    ->orderBy('attempt_number')
                    ->get()
            ]);
        }
    }



    public function start(PostTest $postTest)
    {
        $user = Auth::user();
        $class = $postTest->class;

        // MENTOR PEMILIK KELAS: Tidak bisa start, redirect ke show
        if ($user->role === 'mentor' && $class->mentor_id === $user->id) {
            return redirect()->route('post_tests.show', $postTest);
        }

        // VALIDASI PRE TEST UNTUK SISWA DAN MENTOR NON-PEMILIK
        if (!$this->hasCompletedAllPreTests($class->id, $user->id)) {
            abort(403, 'Anda harus menyelesaikan semua pre test terlebih dahulu.');
        }

        // Cek apakah ada attempt yang sedang berjalan
        $ongoingAttempt = $postTest->attempts()
            ->where('user_id', $user->id)
            ->whereNull('finished_at')
            ->first();

        if ($ongoingAttempt) {
            return redirect()->route('post_tests.show', $postTest);
        }

        // HITUNG SEMUA ATTEMPT YANG SUDAH SELESAI (normal + approval attempts)
        $totalFinishedAttempts = $postTest->attempts()
            ->where('user_id', $user->id)
            ->whereNotNull('finished_at')
            ->where(function ($query) {
                $query->where('requires_approval', false)
                    ->orWhere('is_approval_attempt', true);
            })
            ->count();

        // Cek nilai attempt terakhir
        $lastAttempt = $postTest->attempts()
            ->where('user_id', $user->id)
            ->whereNotNull('finished_at')
            ->where(function ($query) {
                $query->where('requires_approval', false)
                    ->orWhere('is_approval_attempt', true);
            })
            ->latest('finished_at')
            ->first();

        // Jika sudah lulus, tidak boleh mengerjakan lagi
        if ($lastAttempt && $lastAttempt->getPercentageAttribute() >= 80) {
            return redirect()->route('post_tests.show', $postTest)
                ->with('error', 'Anda sudah mencapai nilai passing score. Tidak dapat mengerjakan lagi.');
        }

        // LOGIKA ATTEMPT (SAMA UNTUK SISWA DAN MENTOR NON-PEMILIK):
        if ($totalFinishedAttempts < 2) {
            // Attempt 1 dan 2: Tanpa approval
            $attemptNumber = $totalFinishedAttempts + 1;
            $this->createNewAttempt($postTest, $user, $attemptNumber, false);
            return redirect()->route('post_tests.show', $postTest);
        } else {
            // Attempt 3+: Perlu approval
            $availableApprovalQuery = $postTest->attempts()
                ->where('user_id', $user->id)
                ->where('requires_approval', true)
                ->where('mentor_approved', true)
                ->where('is_used', false);

            // Jika ada attempt terakhir, approval harus dibuat setelah attempt terakhir selesai
            if ($lastAttempt) {
                $availableApprovalQuery = $availableApprovalQuery->where('approved_at', '>', $lastAttempt->finished_at);
            }

            $approval = $availableApprovalQuery->orderBy('approved_at', 'asc')->first();

            if ($approval) {
                // Gunakan approval dan tandai sebagai used
                $approval->update(['is_used' => true]);
                $attemptNumber = $totalFinishedAttempts + 1;
                $this->createNewAttempt($postTest, $user, $attemptNumber, true);
                return redirect()->route('post_tests.show', $postTest);
            } else {
                // Tidak ada approval yang tersedia
                $pendingApproval = $postTest->attempts()
                    ->where('user_id', $user->id)
                    ->where('requires_approval', true)
                    ->where('mentor_approved', false)
                    ->exists();

                if ($pendingApproval) {
                    return redirect()->route('post_tests.show', $postTest)
                        ->with('info', 'Permintaan approval sudah dikirim. Tunggu persetujuan mentor.');
                } else {
                    return redirect()->route('post_tests.request_approval.form', $postTest)
                        ->with('info', 'Anda perlu approval mentor untuk percobaan ke-' . ($totalFinishedAttempts + 1) . '.');
                }
            }
        }
    }

    /**
     * Helper method untuk membuat attempt baru
     */
    private function createNewAttempt($postTest, $user, $attemptNumber, $isApprovalAttempt)
    {
        return PostTestAttempt::create([
            'post_test_id' => $postTest->id,
            'user_id' => $user->id,
            'answers' => [],
            'score' => 0,
            'total_questions' => $postTest->questions->count(),
            'correct_answers' => 0,
            'started_at' => now(),
            'time_remaining' => $postTest->time_limit * 60,
            'finished_at' => null,
            'attempt_number' => $attemptNumber,
            'requires_approval' => false,
            'mentor_approved' => false,
            'is_approval_attempt' => $isApprovalAttempt,
            'is_used' => false
        ]);
    }

    public function activate(PostTest $postTest)
    {
        $class = $postTest->class;

        if (Auth::id() !== $class->mentor_id || Auth::user()->role !== 'mentor') {
            abort(403, 'Unauthorized');
        }

        // Nonaktifkan semua post test lain di kelas yang sama
        $class->postTests()->update(['is_active' => false]);

        // Aktifkan post test yang dipilih
        $postTest->update(['is_active' => true]);

        return redirect()->back()
            ->with('success', 'Post Test "' . $postTest->title . '" berhasil diaktifkan.');
    }

    // Helper method untuk mengecek apakah semua pre test sudah diselesaikan
    private function hasCompletedAllPreTests($classId, $userId)
    {
        $materials = Material::where('class_id', $classId)->get();

        foreach ($materials as $material) {
            $activeQuiz = $material->quizzes()->where('is_active', true)->first();

            if ($activeQuiz && !$activeQuiz->isCompletedByUser($userId)) {
                return false;
            }
        }

        return true;
    }

    // Method untuk auto submit (mirip dengan QuizController)
    private function autoSubmitPostTest(PostTest $postTest, PostTestAttempt $attempt)
    {
        DB::beginTransaction();
        try {
            $freshAttempt = PostTestAttempt::where('id', $attempt->id)
                ->lockForUpdate()
                ->first();

            if (!$freshAttempt || $freshAttempt->finished_at) {
                DB::rollBack();
                return $freshAttempt ?? $attempt;
            }

            $questions = $postTest->questions;
            $userAnswers = $freshAttempt->answers ?? [];
            $correctAnswers = 0;
            $totalScore = 0;

            foreach ($questions as $question) {
                $questionId = (string)$question->id;
                $userAnswer = isset($userAnswers[$questionId]) ? (int)$userAnswers[$questionId] : null;
                $correctAnswer = (int)$question->correct_answer;

                if ($userAnswer === $correctAnswer) {
                    $correctAnswers++;
                    $totalScore += $question->points;
                }
            }

            $freshAttempt->update([
                'answers' => $userAnswers,
                'score' => $totalScore,
                'correct_answers' => $correctAnswers,
                'time_remaining' => 0,
                'finished_at' => now()
            ]);

            DB::commit();
            return $freshAttempt;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in autoSubmitPostTest: ' . $e->getMessage());
            return $attempt;
        }
    }

    public function updateTimer(Request $request, PostTest $postTest)
    {
        $user = Auth::user();

        $attempt = $postTest->attempts()
            ->where('user_id', $user->id)
            ->whereNull('finished_at')
            ->first();

        if (!$attempt) {
            return response()->json(['error' => 'No active attempt found'], 404);
        }

        $timeRemaining = $request->input('time_remaining');

        // Update waktu tersisa
        $attempt->update(['time_remaining' => $timeRemaining]);

        // Jika waktu habis, auto submit
        if ($timeRemaining <= 0) {
            $this->autoSubmitPostTest($postTest, $attempt);
            return response()->json(['time_up' => true]);
        }

        return response()->json(['success' => true]);
    }

    public function saveProgress(Request $request, PostTest $postTest)
    {
        $user = Auth::user();

        DB::beginTransaction();

        try {
            $attempt = $postTest->attempts()
                ->where('user_id', $user->id)
                ->whereNull('finished_at')
                ->lockForUpdate()
                ->first();

            if (!$attempt) {
                DB::rollBack();
                return response()->json(['error' => 'No active attempt found'], 404);
            }

            // Cek apakah waktu sudah habis
            $timeLimit = $postTest->time_limit * 60;
            $elapsed = now()->diffInSeconds($attempt->started_at);

            if ($elapsed >= $timeLimit) {
                DB::rollBack();
                $this->autoSubmitPostTest($postTest, $attempt);
                return response()->json(['timeUp' => true, 'redirect' => route('post_tests.show', $postTest)]);
            }

            // Ambil jawaban dari request
            $newAnswers = $request->input('answers', []);

            // Normalisasi format key dan value
            $normalizedNewAnswers = [];
            foreach ($newAnswers as $questionId => $answer) {
                $normalizedQuestionId = (string)$questionId;
                $normalizedAnswer = (int)$answer;
                $normalizedNewAnswers[$normalizedQuestionId] = $normalizedAnswer;
            }

            // Ambil jawaban yang sudah tersimpan
            $currentAnswers = $attempt->answers ?? [];
            $normalizedCurrentAnswers = [];
            foreach ($currentAnswers as $questionId => $answer) {
                $normalizedCurrentAnswers[(string)$questionId] = (int)$answer;
            }

            // Merge jawaban
            $mergedAnswers = array_merge($normalizedCurrentAnswers, $normalizedNewAnswers);

            // Update attempt
            $attempt->update(['answers' => $mergedAnswers]);

            DB::commit();

            return response()->json([
                'success' => true,
                'timeRemaining' => $timeLimit - $elapsed,
                'answersCount' => count($mergedAnswers),
                'answers' => $mergedAnswers
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving progress: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to save progress: ' . $e->getMessage()], 500);
        }
    }

    public function submit(Request $request, PostTest $postTest)
    {
        $user = Auth::user();

        // MENTOR PEMILIK KELAS: Tidak bisa submit
        if ($user->role === 'mentor' && $postTest->class->mentor_id === $user->id) {
            abort(403, 'Mentor pemilik kelas tidak dapat mengerjakan post test.');
        }

        // VALIDASI PRE TEST UNTUK SISWA DAN MENTOR NON-PEMILIK
        if (!$this->hasCompletedAllPreTests($postTest->class_id, $user->id)) {
            abort(403, 'Anda harus menyelesaikan semua pre test terlebih dahulu.');
        }

        $request->validate([
            'answers' => 'required|array',
            'started_at' => 'required|date'
        ]);

        $questions = $postTest->questions;
        $userAnswers = $request->answers;
        $correctAnswers = 0;
        $totalScore = 0;

        // Hitung skor
        foreach ($questions as $question) {
            $userAnswer = isset($userAnswers[$question->id]) ? (int)$userAnswers[$question->id] : null;
            $correctAnswer = (int)$question->correct_answer;

            if ($userAnswer === $correctAnswer) {
                $correctAnswers++;
                $totalScore += $question->points;
            }
        }

        // Cari attempt yang sedang berjalan
        $attempt = $postTest->attempts()
            ->where('user_id', $user->id)
            ->whereNull('finished_at')
            ->first();

        if ($attempt) {
            // Update attempt yang sudah ada
            $attempt->update([
                'answers' => $userAnswers,
                'score' => $totalScore,
                'total_questions' => $questions->count(),
                'correct_answers' => $correctAnswers,
                'finished_at' => now()
            ]);
        } else {
            // Jika tidak ada attempt yang sedang berjalan, buat baru
            $totalFinishedAttempts = $postTest->attempts()
                ->where('user_id', $user->id)
                ->whereNotNull('finished_at')
                ->count();

            $finishedNormalAttempts = $postTest->attempts()
                ->where('user_id', $user->id)
                ->whereNotNull('finished_at')
                ->where('requires_approval', false)
                ->count();

            $attemptNumber = $totalFinishedAttempts + 1;
            $isApprovalAttempt = $finishedNormalAttempts >= 2;

            $attempt = PostTestAttempt::create([
                'post_test_id' => $postTest->id,
                'user_id' => $user->id,
                'answers' => $userAnswers,
                'score' => $totalScore,
                'total_questions' => $questions->count(),
                'correct_answers' => $correctAnswers,
                'started_at' => $request->started_at,
                'finished_at' => now(),
                'attempt_number' => $attemptNumber,
                'requires_approval' => false,
                'mentor_approved' => false,
                'is_approval_attempt' => $isApprovalAttempt,
                'is_used' => false
            ]);
        }

        return redirect()->route('classes.learn', $postTest->class_id)
            ->with('success', 'Post Test berhasil diselesaikan!');
    }

    public function requestApproval(Request $request, PostTest $postTest)
    {
        $user = Auth::user();

        // HANYA SISWA DAN MENTOR NON-PEMILIK yang dapat meminta approval
        if ($user->role === 'mentor' && $postTest->class->mentor_id === $user->id) {
            abort(403, 'Mentor pemilik kelas tidak dapat meminta approval.');
        }

        // Cek apakah sudah meminta approval yang belum di-approve
        $pendingApproval = $postTest->attempts()
            ->where('user_id', $user->id)
            ->where('requires_approval', true)
            ->where('mentor_approved', false)
            ->first();

        if ($pendingApproval) {
            return redirect()->route('post_tests.show', $postTest)
                ->with('info', 'Permintaan approval sudah dikirim. Tunggu persetujuan mentor.');
        }

        // Buat record untuk request approval
        $attempt = PostTestAttempt::create([
            'post_test_id' => $postTest->id,
            'user_id' => $user->id,
            'requires_approval' => true,
            'approval_requested_at' => now(),
            'mentor_approved' => false,
            'is_used' => false,
            'answers' => [],
            'score' => 0,
            'total_questions' => 0,
            'correct_answers' => 0,
            'is_approval_attempt' => false,
            'attempt_number' => 0,
            'approval_reason' => $request->input('approval_reason')
        ]);

        return redirect()->route('classes.learn', $postTest->class_id)
            ->with('success', 'Permintaan approval telah dikirim ke mentor.');
    }

    public function approveAttempt(Request $request, PostTest $postTest, $attemptId)
    {
        $user = Auth::user();
        $class = $postTest->class;

        if ($user->role !== 'mentor' || $user->id !== $class->mentor_id) {
            abort(403, 'Unauthorized');
        }

        $attempt = PostTestAttempt::findOrFail($attemptId);

        $attempt->update([
            'mentor_approved' => true,
            'approved_at' => now(),
            'is_used' => false // Marking as available to be used
        ]);

        return redirect()->route('post_tests.approval_requests')
            ->with('success', 'Approval berhasil diberikan untuk ' . $attempt->user->name . '.');
    }

    public function showRequestApprovalForm(PostTest $postTest)
    {
        $user = Auth::user();

        // HANYA SISWA DAN MENTOR NON-PEMILIK yang dapat meminta approval
        if ($user->role === 'mentor' && $postTest->class->mentor_id === $user->id) {
            abort(403, 'Mentor pemilik kelas tidak dapat meminta approval.');
        }

        // Cek apakah sudah meminta approval yang pending
        $pendingApproval = $postTest->attempts()
            ->where('user_id', $user->id)
            ->where('requires_approval', true)
            ->where('mentor_approved', false)
            ->exists();

        if ($pendingApproval) {
            return redirect()->route('post_tests.show', $postTest)
                ->with('info', 'Permintaan approval sudah dikirim. Tunggu persetujuan mentor.');
        }

        // Hitung semua attempt yang sudah selesai
        $totalFinishedAttempts = $postTest->attempts()
            ->where('user_id', $user->id)
            ->whereNotNull('finished_at')
            ->where(function ($query) {
                $query->where('requires_approval', false)
                    ->orWhere('is_approval_attempt', true);
            })
            ->count();

        // Cek apakah ada approval yang belum digunakan
        $lastAttempt = $postTest->attempts()
            ->where('user_id', $user->id)
            ->whereNotNull('finished_at')
            ->where(function ($query) {
                $query->where('requires_approval', false)
                    ->orWhere('is_approval_attempt', true);
            })
            ->latest('finished_at')
            ->first();

        $availableApprovalQuery = $postTest->attempts()
            ->where('user_id', $user->id)
            ->where('requires_approval', true)
            ->where('mentor_approved', true)
            ->where('is_used', false);

        if ($lastAttempt) {
            $availableApprovalQuery = $availableApprovalQuery->where('approved_at', '>', $lastAttempt->finished_at);
        }

        $availableApproval = $availableApprovalQuery->first();

        if ($availableApproval) {
            return redirect()->route('post_tests.show', $postTest)
                ->with('success', 'Approval sudah tersedia. Anda dapat mengerjakan sekarang.');
        }

        // Cek apakah sudah memenuhi syarat untuk request approval
        if ($totalFinishedAttempts < 2) {
            return redirect()->route('post_tests.show', $postTest)
                ->with('error', 'Anda masih memiliki kesempatan attempt gratis. Silakan kerjakan terlebih dahulu.');
        }

        $attempts = $postTest->attempts()
            ->where('user_id', $user->id)
            ->whereNotNull('finished_at')
            ->where(function ($query) {
                $query->where('requires_approval', false)
                    ->orWhere('is_approval_attempt', true);
            })
            ->orderBy('attempt_number')
            ->get();

        $nextAttemptNumber = $totalFinishedAttempts + 1;

        return view('post_tests.request_approval', compact('postTest', 'attempts', 'nextAttemptNumber'));
    }
    public function approvalRequests()
    {
        $user = Auth::user();

        if ($user->role !== 'mentor') {
            abort(403, 'Hanya mentor yang dapat mengakses halaman ini.');
        }

        // Get all classes taught by this mentor
        $classIds = ClassModel::where('mentor_id', $user->id)->pluck('id');

        // Get all pending approval requests for these classes
        $requests = PostTestAttempt::with(['postTest.class', 'user'])
            ->whereHas('postTest', function ($query) use ($classIds) {
                $query->whereIn('class_id', $classIds);
            })
            ->where('requires_approval', true)
            ->where('mentor_approved', false)
            ->orderBy('approval_requested_at', 'desc')
            ->get();

        return view('post_tests.approval_requests', compact('requests'));
    }

    // Rest of the methods remain the same...
    public function edit(ClassModel $class, PostTest $postTest)
    {
        // Check authorization
        if (Auth::id() !== $class->mentor_id || Auth::user()->role !== 'mentor') {
            abort(403, 'Unauthorized');
        }

        // Ensure the post test belongs to the class
        if ($postTest->class_id !== $class->id) {
            abort(404, 'Post test not found for this class');
        }

        // Load questions with their options
        $postTest->load(['questions' => function ($query) {
            $query->orderBy('order');
        }]);

        return view('post_tests.edit', compact('class', 'postTest'));
    }

    public function update(Request $request, ClassModel $class, PostTest $postTest)
    {
        if (Auth::id() !== $class->mentor_id || Auth::user()->role !== 'mentor') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_limit' => 'required|integer|min:1',
            'passing_score' => 'required|integer|min:1|max:100',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // TAMBAHKAN INI
            'questions.*.existing_image' => 'nullable|string', // TAMBAHKAN INI
            'questions.*.options' => 'required|array|min:2',
            'questions.*.options.*' => 'required|string',
            'questions.*.correct_answer' => 'required|integer|min:0',
            'questions.*.points' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();

        try {
            $postTest->update([
                'title' => $request->title,
                'description' => $request->description,
                'time_limit' => $request->time_limit,
                'passing_score' => $request->passing_score,
            ]);

            // Ambil gambar lama untuk dihapus - TAMBAHKAN INI
            $oldImages = $postTest->questions()->pluck('image')->filter()->toArray();

            $postTest->questions()->delete();

            // Tambahkan pertanyaan baru - UPDATE INI
            $usedImages = [];
            foreach ($request->questions as $index => $questionData) {
                $imagePath = null;

                // Jika ada gambar baru diupload
                if (isset($questionData['image']) && $questionData['image'] instanceof \Illuminate\Http\UploadedFile) {
                    $imagePath = $questionData['image']->store('post-test-images', 'public');
                }
                // Jika menggunakan gambar yang sudah ada
                elseif (isset($questionData['existing_image']) && !empty($questionData['existing_image'])) {
                    $imagePath = $questionData['existing_image'];
                    $usedImages[] = $imagePath;
                }

                $correctAnswerIndex = (int)$questionData['correct_answer'];
                if ($correctAnswerIndex >= count($questionData['options'])) {
                    throw new \Exception("Invalid correct answer index for question " . ($index + 1));
                }

                PostTestQuestion::create([
                    'post_test_id' => $postTest->id,
                    'question' => $questionData['question'],
                    'image' => $imagePath, // TAMBAHKAN INI
                    'options' => $questionData['options'],
                    'correct_answer' => $correctAnswerIndex,
                    'points' => (int)$questionData['points'],
                    'order' => $index + 1
                ]);
            }

            // Hapus gambar lama yang tidak digunakan lagi - TAMBAHKAN INI
            foreach ($oldImages as $oldImage) {
                if (!in_array($oldImage, $usedImages) && Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            DB::commit();

            return redirect()->route('classes.learn', $class)
                ->with('success', 'Post Test berhasil diperbarui untuk kelas: ' . $class->name);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating post test: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui post test: ' . $e->getMessage())
                ->withInput();
        }
    }
    public function destroy(ClassModel $class, PostTest $postTest)
    {
        // Check authorization
        if (Auth::id() !== $class->mentor_id || Auth::user()->role !== 'mentor') {
            abort(403, 'Unauthorized');
        }

        // Ensure the post test belongs to the class
        if ($postTest->class_id !== $class->id) {
            abort(404, 'Post test not found for this class');
        }

        DB::beginTransaction();

        try {
            // Check if there are any attempts
            $hasAttempts = $postTest->attempts()->exists();

            if ($hasAttempts) {
                // If there are attempts, just deactivate instead of deleting
                $postTest->update(['is_active' => false]);
                $message = 'Post Test berhasil dinonaktifkan karena sudah ada siswa yang mengerjakan.';
            } else {
                // If no attempts, safe to delete
                $postTest->questions()->delete(); // Delete questions first
                $postTest->delete(); // Then delete the post test
                $message = 'Post Test berhasil dihapus.';
            }

            DB::commit();

            return redirect()->route('classes.show', $class)
                ->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting post test: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus post test.');
        }
    }

    public function toggleStatus(ClassModel $class, PostTest $postTest)
    {
        // Check authorization
        if (Auth::id() !== $class->mentor_id || Auth::user()->role !== 'mentor') {
            abort(403, 'Unauthorized');
        }

        // Ensure the post test belongs to the class
        if ($postTest->class_id !== $class->id) {
            abort(404, 'Post test not found for this class');
        }

        try {
            if (!$postTest->is_active) {
                // Activating this post test - deactivate others first
                $class->postTests()->where('id', '!=', $postTest->id)->update(['is_active' => false]);
            }

            $postTest->update(['is_active' => !$postTest->is_active]);

            $status = $postTest->is_active ? 'diaktifkan' : 'dinonaktifkan';

            return redirect()->back()
                ->with('success', "Post Test berhasil {$status}.");
        } catch (\Exception $e) {
            Log::error('Error toggling post test status: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengubah status post test.');
        }
    }

    /**
     * Duplicate an existing post test.
     */
    public function duplicate(ClassModel $class, PostTest $postTest)
    {
        // Check authorization
        if (Auth::id() !== $class->mentor_id || Auth::user()->role !== 'mentor') {
            abort(403, 'Unauthorized');
        }

        // Ensure the post test belongs to the class
        if ($postTest->class_id !== $class->id) {
            abort(404, 'Post test not found for this class');
        }

        DB::beginTransaction();

        try {
            // Deactivate all existing post tests
            $class->postTests()->update(['is_active' => false]);

            // Create duplicate post test
            $duplicatePostTest = PostTest::create([
                'title' => $postTest->title . ' (Copy)',
                'description' => $postTest->description,
                'class_id' => $class->id,
                'mentor_id' => Auth::id(),
                'time_limit' => $postTest->time_limit,
                'passing_score' => $postTest->passing_score,
                'is_active' => true
            ]);

            // Duplicate questions
            $postTest->load(['questions' => function ($query) {
                $query->orderBy('order');
            }]);

            foreach ($postTest->questions as $question) {
                PostTestQuestion::create([
                    'post_test_id' => $duplicatePostTest->id,
                    'question' => $question->question,
                    'options' => $question->options,
                    'correct_answer' => $question->correct_answer,
                    'points' => $question->points,
                    'order' => $question->order
                ]);
            }

            DB::commit();

            return redirect()->route('post_tests.edit', [$class, $duplicatePostTest])
                ->with('success', 'Post Test berhasil diduplikasi. Anda dapat mengeditnya sekarang.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error duplicating post test: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menduplikasi post test.');
        }
    }
}
