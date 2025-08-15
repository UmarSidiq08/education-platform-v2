<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Material;
use App\Models\Question;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

    // Tampilkan quiz untuk dikerjakan
    public function show(Quiz $quiz)
    {
        $user = Auth::user();

        // Cek apakah user sudah pernah mengerjakan quiz ini
        if ($quiz->hasBeenAttemptedBy($user->id)) {
            $attempt = $quiz->getAttemptByUser($user->id);
            return view('quizzes.result', compact('quiz', 'attempt'));
        }

        // Load questions untuk dikerjakan
        $quiz->load(['questions', 'material.class']);

        return view('quizzes.take', compact('quiz'));
    }

    // Submit jawaban quiz
    public function submit(Request $request, Quiz $quiz)
    {
        $user = Auth::user();

        // Cek apakah user sudah pernah mengerjakan
        if ($quiz->hasBeenAttemptedBy($user->id)) {
            return redirect()->route('quizzes.show', $quiz)
                ->with('error', 'Anda sudah mengerjakan kuis ini sebelumnya.');
        }

        $request->validate([
            'answers' => 'required|array',
            'started_at' => 'required|date'
        ]);

        $questions = $quiz->questions;
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

        // Simpan attempt
        $attempt = QuizAttempt::create([
            'quiz_id' => $quiz->id,
            'user_id' => $user->id,
            'answers' => $userAnswers,
            'score' => $totalScore,
            'total_questions' => $questions->count(),
            'correct_answers' => $correctAnswers,
            'started_at' => $request->started_at,
            'finished_at' => now()
        ]);

        return redirect()->route('quizzes.show', $quiz)
            ->with('success', 'Quiz berhasil diselesaikan!');
    }

    // Tampilkan daftar quiz untuk materi tertentu (untuk mentor)
    // Tambahkan method ini di QuizController

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
}
