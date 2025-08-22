<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Material;
use App\Models\Question;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function create(Material $material)
    {
        // Pastikan hanya mentor yang bisa buat quiz untuk materialnya
        if (Auth::id() !== $material->class->mentor_id || Auth::user()->role !== 'mentor') {
            abort(403, 'Unauthorized');
        }

        return view('quizzes.create', compact('material'));
    }

    public function store(Request $request, Material $material)
    {
        if (Auth::id() !== $material->class->mentor_id || Auth::user()->role !== 'mentor') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_limit' => 'required|integer|min:1',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.options' => 'required|array|min:2',
            'questions.*.correct_answer' => 'required|integer|min:0',
            'questions.*.points' => 'required|integer|min:1'
        ]);

        // Nonaktifkan quiz lama jika ada
        $material->quizzes()->update(['is_active' => false]);

        $quiz = Quiz::create([
            'title' => $request->title,
            'description' => $request->description,
            'material_id' => $material->id,
            'created_by' => Auth::id(),
            'time_limit' => $request->time_limit,
            'total_questions' => count($request->questions),
            'is_active' => true
        ]);

        foreach ($request->questions as $index => $questionData) {
            Question::create([
                'quiz_id' => $quiz->id,
                'question' => $questionData['question'],
                'options' => $questionData['options'],
                'correct_answer' => (int)$questionData['correct_answer'],
                'points' => (int)$questionData['points'],
                'order' => $index + 1
            ]);
        }

        return redirect()->route('materials.show', $material)
            ->with('success', 'Kuis berhasil ditambahkan untuk materi: ' . $material->title);
    }

    public function edit(Material $material, Quiz $quiz)
    {
        $material = $quiz->material;

        // Pastikan hanya mentor yang bisa edit quiz untuk materialnya
        if (Auth::id() !== $material->class->mentor_id || Auth::user()->role !== 'mentor') {
            abort(403, 'Unauthorized');
        }

        // Load questions dengan urutan yang benar
        $quiz->load(['questions' => function ($query) {
            $query->orderBy('order');
        }]);

        return view('quizzes.edit', compact('quiz', 'material'));
    }

    public function update(Request $request, Material $material, Quiz $quiz)
    {
        $material = $quiz->material;

        if (Auth::id() !== $material->class->mentor_id || Auth::user()->role !== 'mentor') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_limit' => 'required|integer|min:1',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.options' => 'required|array|min:2',
            'questions.*.correct_answer' => 'required|integer|min:0',
            'questions.*.points' => 'required|integer|min:1'
        ]);

        // Update quiz data
        $quiz->update([
            'title' => $request->title,
            'description' => $request->description,
            'time_limit' => $request->time_limit,
            'total_questions' => count($request->questions),
        ]);

        // Hapus semua pertanyaan lama
        $quiz->questions()->delete();

        // Tambahkan pertanyaan baru
        foreach ($request->questions as $index => $questionData) {
            Question::create([
                'quiz_id' => $quiz->id,
                'question' => $questionData['question'],
                'options' => $questionData['options'],
                'correct_answer' => (int)$questionData['correct_answer'],
                'points' => (int)$questionData['points'],
                'order' => $index + 1
            ]);
        }

        return redirect()->route('materials.show', $material)
            ->with('success', 'Kuis berhasil diperbarui untuk materi: ' . $material->title);
    }

    // UPDATED: Show quiz dengan logic untuk handle multiple attempts
    // UPDATED: Show quiz dengan logic untuk handle multiple attempts
public function show(Request $request, Quiz $quiz)
{
    $user = Auth::user();

    // Jika ada attempt_id di parameter (untuk melihat attempt tertentu)
    if ($request->has('attempt_id')) {
        $attempt = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('user_id', $user->id)
            ->where('id', $request->attempt_id)
            ->whereNotNull('finished_at')
            ->first();

        if (!$attempt) {
            return redirect()->route('quizzes.show', $quiz)
                ->with('error', 'Attempt tidak ditemukan.');
        }

        // Get all attempts dan best attempt untuk view
        $allAttempts = $quiz->attempts()
            ->where('user_id', $user->id)
            ->whereNotNull('finished_at')
            ->orderBy('finished_at', 'desc')
            ->get();

        // Add attempt numbers
        foreach ($allAttempts as $index => $att) {
            $att->attempt_number = $allAttempts->count() - $index;
        }

        $bestAttempt = $quiz->getBestAttemptByUser($user->id);

        return view('quizzes.result', [
            'quiz' => $quiz,
            'attempt' => $attempt,
            'allAttempts' => $allAttempts,
            'bestAttempt' => $bestAttempt
        ]);
    }

    // Cek apakah ada attempt yang sedang berjalan
    $ongoingAttempt = $quiz->attempts()
        ->where('user_id', $user->id)
        ->whereNull('finished_at')
        ->first();

    if ($ongoingAttempt) {
        // Hitung waktu tersisa berdasarkan waktu yang disimpan di database
        $timeRemaining = $ongoingAttempt->time_remaining;

        // Jika waktu habis, auto submit
        if ($timeRemaining <= 0) {
            $this->autoSubmitQuiz($quiz, $ongoingAttempt);
            return redirect()->route('quizzes.show', $quiz)
                ->with('warning', 'Waktu quiz telah habis. Jawaban Anda telah otomatis terkirim.');
        }

        $quiz->load(['questions', 'material.class']);
        return view('quizzes.take', [
            'quiz' => $quiz,
            'attempt' => $ongoingAttempt,
            'timeRemaining' => $timeRemaining
        ]);
    }

    // User sudah pernah mengerjakan, tampilkan hasil dengan opsi mengerjakan lagi
    $allAttempts = $quiz->attempts()
        ->where('user_id', $user->id)
        ->whereNotNull('finished_at')
        ->orderBy('finished_at', 'desc')
        ->get();

    if ($allAttempts->count() > 0) {
        // Add attempt numbers
        foreach ($allAttempts as $index => $attempt) {
            $attempt->attempt_number = $allAttempts->count() - $index;
        }

        $bestAttempt = $quiz->getBestAttemptByUser($user->id);
        $latestAttempt = $allAttempts->first(); // Yang paling baru

        return view('quizzes.result', [
            'quiz' => $quiz,
            'attempt' => $latestAttempt,
            'allAttempts' => $allAttempts,
            'bestAttempt' => $bestAttempt
        ]);
    }

    // Belum ada attempt sama sekali, load questions untuk mulai quiz baru
    $quiz->load(['questions', 'material.class']);
    return view('quizzes.take', compact('quiz'));
}

    // UPDATED: Method untuk start quiz dan create attempt (allow multiple attempts)
    public function start(Quiz $quiz)
    {
        $user = Auth::user();

        // Cek apakah ada attempt yang sedang berjalan
        $ongoingAttempt = $quiz->attempts()
            ->where('user_id', $user->id)
            ->whereNull('finished_at')
            ->first();

        if ($ongoingAttempt) {
            return redirect()->route('quizzes.show', $quiz)
                ->with('info', 'Anda masih memiliki sesi quiz yang aktif.');
        }

        // Create new attempt - tidak perlu cek apakah sudah pernah mengerjakan
        $attempt = QuizAttempt::create([
            'quiz_id' => $quiz->id,
            'user_id' => $user->id,
            'answers' => [],
            'score' => 0,
            'total_questions' => $quiz->questions->count(),
            'correct_answers' => 0,
            'started_at' => now(),
            'time_remaining' => $quiz->time_limit * 60, // Simpan waktu tersisa dalam detik
            'finished_at' => null // NULL berarti sedang berjalan
        ]);

        return redirect()->route('quizzes.show', $quiz);
    }

    // FIXED: Save progress - handle both JSON and form data
    public function saveProgress(Request $request, Quiz $quiz)
    {
        $user = Auth::user();

        DB::beginTransaction();

        try {
            $attempt = $quiz->attempts()
                ->where('user_id', $user->id)
                ->whereNull('finished_at')
                ->lockForUpdate()
                ->first();

            if (!$attempt) {
                DB::rollBack();
                return response()->json(['error' => 'No active attempt found'], 404);
            }

            // Cek apakah waktu sudah habis
            $timeLimit = $quiz->time_limit * 60;
            $elapsed = now()->diffInSeconds($attempt->started_at);

            if ($elapsed >= $timeLimit) {
                DB::rollBack();
                $this->autoSubmitQuiz($quiz, $attempt);
                return response()->json(['timeUp' => true, 'redirect' => route('quizzes.show', $quiz)]);
            }

            // FIXED: Parsing input dengan prioritas dan normalisasi yang benar
            $newAnswers = [];

            if ($request->isJson()) {
                // JSON request dari JavaScript
                $jsonAnswers = $request->input('answers', []);
                Log::info('JSON input received', ['answers' => $jsonAnswers]);
                $newAnswers = $jsonAnswers;
            } else {
                // Form data request
                $allInput = $request->all();
                Log::info('Form input received', ['all_input' => $allInput]);

                // Cek format answers sebagai array langsung
                if ($request->has('answers') && is_array($request->input('answers'))) {
                    $newAnswers = $request->input('answers');
                    Log::info('Direct answers array found', ['answers' => $newAnswers]);
                }
                // Cek format answers sebagai JSON string
                elseif ($request->has('answers') && is_string($request->input('answers'))) {
                    $answersString = $request->input('answers');
                    $decodedAnswers = json_decode($answersString, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decodedAnswers)) {
                        $newAnswers = $decodedAnswers;
                        Log::info('JSON string answers parsed', ['answers' => $newAnswers]);
                    }
                }
                // Parse dari format answers[question_id] = value
                else {
                    foreach ($allInput as $key => $value) {
                        if (preg_match('/^answers\[(\d+)\]$/', $key, $matches)) {
                            $questionId = $matches[1];
                            $newAnswers[$questionId] = (int)$value;
                            Log::info('Parsed answer from form', ['question_id' => $questionId, 'value' => $value]);
                        }
                    }
                }
            }

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

            Log::info('Progress saved successfully', [
                'user_id' => $user->id,
                'quiz_id' => $quiz->id,
                'request_format' => $request->isJson() ? 'json' : 'form',
                'new_answers' => $normalizedNewAnswers,
                'merged_answers' => $mergedAnswers,
                'answers_count' => count($mergedAnswers)
            ]);

            return response()->json([
                'success' => true,
                'timeRemaining' => $timeLimit - $elapsed,
                'answersCount' => count($mergedAnswers),
                'answers' => $mergedAnswers
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving progress: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'quiz_id' => $quiz->id,
                'request_data' => $request->all()
            ]);

            return response()->json(['error' => 'Failed to save progress: ' . $e->getMessage()], 500);
        }
    }

    // FIXED: API endpoint untuk cek status timer
    public function checkTimer(Quiz $quiz)
    {
        $user = Auth::user();

        $attempt = $quiz->attempts()
            ->where('user_id', $user->id)
            ->whereNull('finished_at')
            ->first();

        if (!$attempt) {
            return response()->json(['error' => 'No active attempt found'], 404);
        }

        $timeLimit = $quiz->time_limit * 60;
        $elapsed = now()->diffInSeconds($attempt->started_at);
        $timeRemaining = max(0, $timeLimit - $elapsed);

        if ($timeRemaining <= 0) {
            // Auto submit dengan jawaban yang sudah tersimpan
            $this->autoSubmitQuiz($quiz, $attempt);
            return response()->json([
                'timeUp' => true,
                'redirect' => route('quizzes.show', $quiz)
            ]);
        }

        return response()->json([
            'timeRemaining' => $timeRemaining,
            'serverTime' => now()->timestamp
        ]);
    }

    // FIXED: Method untuk handle auto submit dari client
    public function autoSubmit(Quiz $quiz)
    {
        $user = Auth::user();

        $attempt = $quiz->attempts()
            ->where('user_id', $user->id)
            ->whereNull('finished_at')
            ->first();

        if (!$attempt) {
            return redirect()->route('quizzes.show', $quiz)
                ->with('error', 'Session quiz tidak valid.');
        }

        // Auto submit dengan jawaban terakhir yang tersimpan di database
        $finalAttempt = $this->autoSubmitQuiz($quiz, $attempt);

        Log::info('Auto submit completed', [
            'user_id' => $user->id,
            'quiz_id' => $quiz->id,
            'final_answers' => $finalAttempt->answers,
            'final_score' => $finalAttempt->score
        ]);

        return redirect()->route('quizzes.show', $quiz)
            ->with('warning', 'Waktu quiz telah habis. Jawaban terakhir Anda telah otomatis terkirim.');
    }
    // FIXED: Submit method untuk multiple attempts
   public function submit(Request $request, Quiz $quiz)
{
    $user = Auth::user();

    DB::beginTransaction();
    try {
        // Cari attempt yang sedang berjalan
        $attempt = $quiz->attempts()
            ->where('user_id', $user->id)
            ->whereNull('finished_at')
            ->lockForUpdate()
            ->first();

        if (!$attempt) {
            DB::rollBack();
            return redirect()->route('quizzes.show', $quiz)
                ->with('error', 'Tidak ada sesi quiz yang aktif.');
        }

        // Ambil jawaban dari form
        $userAnswers = [];
        if ($request->has('answers') && is_array($request->answers)) {
            foreach ($request->answers as $questionId => $answerIndex) {
                $userAnswers[(string)$questionId] = (int)$answerIndex;
            }
        }

        // Jika tidak ada jawaban dari form, gunakan yang sudah tersimpan
        if (empty($userAnswers)) {
            $userAnswers = $attempt->answers ?? [];
        }

        // Hitung skor
        $questions = $quiz->questions;
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

        // Update attempt dengan hasil final
        $attempt->update([
            'answers' => $userAnswers,
            'score' => $totalScore,
            'correct_answers' => $correctAnswers,
            'time_remaining' => 0,
            'finished_at' => now()
        ]);

        DB::commit();

        Log::info('Quiz submitted successfully', [
            'user_id' => $user->id,
            'quiz_id' => $quiz->id,
            'final_score' => $totalScore,
            'correct_answers' => $correctAnswers,
            'total_answers' => count($userAnswers)
        ]);

        return redirect()->route('quizzes.show', ['quiz' => $quiz, 'attempt_id' => $attempt->id])
            ->with('success', 'Quiz berhasil diselesaikan! Skor: ' . $totalScore);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error submitting quiz: ' . $e->getMessage());

        return redirect()->route('quizzes.show', $quiz)
            ->with('error', 'Terjadi kesalahan saat mengirim jawaban.');
    }
}
    // REMOVED: Submit method karena sudah tidak digunakan untuk multiple attempts
    // User sekarang hanya menggunakan start -> auto submit system

    // FIXED: Private method untuk auto submit ketika waktu habis
    private function autoSubmitQuiz(Quiz $quiz, QuizAttempt $attempt)
    {
        DB::beginTransaction();
        try {
            $freshAttempt = QuizAttempt::where('id', $attempt->id)
                ->lockForUpdate()
                ->first();

            if (!$freshAttempt || $freshAttempt->finished_at) {
                DB::rollBack();
                return $freshAttempt ?? $attempt;
            }

            $questions = $quiz->questions;
            $userAnswers = $freshAttempt->answers ?? [];
            $correctAnswers = 0;
            $totalScore = 0;
            $scoringDetails = [];

            Log::info('Auto submitting quiz - starting calculation', [
                'user_id' => $freshAttempt->user_id,
                'quiz_id' => $quiz->id,
                'saved_answers' => $userAnswers,
                'answers_count' => count($userAnswers),
                'total_questions' => count($questions)
            ]);

            foreach ($questions as $question) {
                $questionId = (string)$question->id;
                $userAnswer = isset($userAnswers[$questionId]) ? (int)$userAnswers[$questionId] : null;
                $correctAnswer = (int)$question->correct_answer;
                $isCorrect = $userAnswer === $correctAnswer;

                $scoringDetails[] = [
                    'question_id' => $questionId,
                    'user_answer' => $userAnswer,
                    'correct_answer' => $correctAnswer,
                    'is_correct' => $isCorrect,
                    'points' => $question->points
                ];

                if ($isCorrect) {
                    $correctAnswers++;
                    $totalScore += $question->points;
                }
            }

            Log::info('Auto submit scoring details', [
                'user_id' => $freshAttempt->user_id,
                'quiz_id' => $quiz->id,
                'scoring_details' => $scoringDetails,
                'total_correct' => $correctAnswers,
                'total_score' => $totalScore
            ]);

            $freshAttempt->update([
                'answers' => $userAnswers,
                'score' => $totalScore,
                'correct_answers' => $correctAnswers,
                'time_remaining' => 0, // Set waktu tersisa menjadi 0
                'finished_at' => now()
            ]);

            DB::commit();

            Log::info('Quiz auto submitted successfully', [
                'user_id' => $freshAttempt->user_id,
                'quiz_id' => $quiz->id,
                'final_score' => $totalScore,
                'correct_answers' => $correctAnswers,
                'total_answers_saved' => count($userAnswers)
            ]);

            return $freshAttempt;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in autoSubmitQuiz', [
                'quiz_id' => $quiz->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return $attempt;
        }
    }

    // Tampilkan daftar quiz untuk materi tertentu (untuk mentor)
    public function index(Material $material)
    {
        if (Auth::id() !== $material->class->mentor_id || Auth::user()->role !== 'mentor') {
            abort(403, 'Unauthorized');
        }

        $quizzes = $material->quizzes()
            ->with(['attempts.user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('quizzes.index', compact('material', 'quizzes'));
    }

    public function activate(Quiz $quiz)
    {
        $material = $quiz->material;

        // Pastikan hanya mentor yang bisa mengaktifkan quiz untuk materialnya
        if (Auth::id() !== $material->class->mentor_id || Auth::user()->role !== 'mentor') {
            abort(403, 'Unauthorized');
        }

        // Nonaktifkan semua quiz lain di material yang sama
        $material->quizzes()->update(['is_active' => false]);

        // Aktifkan quiz yang dipilih
        $quiz->update(['is_active' => true]);

        return redirect()->back()
            ->with('success', 'Quiz "' . $quiz->title . '" berhasil diaktifkan.');
    }

    public function updateTimer(Request $request, Quiz $quiz)
    {
        $user = Auth::user();

        $attempt = $quiz->attempts()
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
            $this->autoSubmitQuiz($quiz, $attempt);
            return response()->json(['time_up' => true]);
        }

        return response()->json(['success' => true]);
    }
}
