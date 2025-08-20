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
            'questions.*.options' => 'required|array|min:2',
            'questions.*.correct_answer' => 'required|integer|min:0',
            'questions.*.points' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();

        try {
            // Nonaktifkan post test lama jika ada
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
                PostTestQuestion::create([
                    'post_test_id' => $postTest->id,
                    'question' => $questionData['question'],
                    'options' => $questionData['options'],
                    'correct_answer' => (int)$questionData['correct_answer'],
                    'points' => (int)$questionData['points'],
                    'order' => $index + 1
                ]);
            }

            DB::commit();

            return redirect()->route('classes.show', $class)
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
            // Pastikan siswa sudah menyelesaikan semua pre test
            if (!$this->hasCompletedAllPreTests($class->id, $user->id)) {
                abort(403, 'Anda harus menyelesaikan semua pre test terlebih dahulu.');
            }
        } elseif ($user->role === 'mentor') {
            // Pastikan mentor adalah pemilik kelas
            if ($class->mentor_id !== $user->id) {
                abort(403, 'Unauthorized');
            }
        } else {
            abort(403, 'Unauthorized');
        }

        // Cek apakah user sudah pernah selesai mengerjakan post test ini
        $completedAttempt = $postTest->attempts()
            ->where('user_id', $user->id)
            ->whereNotNull('finished_at')
            ->first();

        if ($completedAttempt) {
            return view('post_tests.result', [
                'postTest' => $postTest,
                'attempt' => $completedAttempt,
                'class' => $class
            ]);
        }

        // Cek apakah ada attempt yang sedang berjalan
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

        // Belum ada attempt, load questions untuk mulai post test baru
        $postTest->load(['questions', 'class']);
        return view('post_tests.take', [
            'postTest' => $postTest,
            'class' => $class
        ]);
    }

    public function start(PostTest $postTest)
    {
        $user = Auth::user();
        $class = $postTest->class;

        // Validasi untuk siswa
        if ($user->role === 'siswa') {
            // Pastikan siswa sudah menyelesaikan semua pre test
            if (!$this->hasCompletedAllPreTests($class->id, $user->id)) {
                abort(403, 'Anda harus menyelesaikan semua pre test terlebih dahulu.');
            }

            // Cek apakah user sudah pernah mengerjakan
            if ($postTest->hasBeenAttemptedBy($user->id)) {
                return redirect()->route('post_tests.show', $postTest)
                    ->with('error', 'Anda sudah mengerjakan post test ini sebelumnya.');
            }
        }

        // Create new attempt
        $attempt = PostTestAttempt::create([
            'post_test_id' => $postTest->id,
            'user_id' => $user->id,
            'answers' => [],
            'score' => 0,
            'total_questions' => $postTest->questions->count(),
            'correct_answers' => 0,
            'started_at' => now(),
            'time_remaining' => $postTest->time_limit * 60,
            'finished_at' => null
        ]);

        return redirect()->route('post_tests.show', $postTest);
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

        // Validasi untuk siswa
        if ($user->role === 'siswa') {
            if (!$this->hasCompletedAllPreTests($postTest->class_id, $user->id)) {
                abort(403, 'Anda harus menyelesaikan semua pre test terlebih dahulu.');
            }

            // Cek apakah user sudah pernah mengerjakan post test ini
            $existingAttempt = $postTest->attempts()
                ->where('user_id', $user->id)
                ->whereNotNull('finished_at')
                ->first();

            if ($existingAttempt) {
                return redirect()->route('post_tests.show', $postTest)
                    ->with('error', 'Anda sudah mengerjakan post test ini sebelumnya.');
            }
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
            // Buat attempt baru
            $attempt = PostTestAttempt::create([
                'post_test_id' => $postTest->id,
                'user_id' => $user->id,
                'answers' => $userAnswers,
                'score' => $totalScore,
                'total_questions' => $questions->count(),
                'correct_answers' => $correctAnswers,
                'started_at' => $request->started_at,
                'finished_at' => now()
            ]);
        }

        return redirect()->route('post_tests.show', $postTest)
            ->with('success', 'Post Test berhasil diselesaikan!');
    }
}
