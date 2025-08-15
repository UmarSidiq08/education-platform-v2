@extends('layouts.app')

@section('title', 'Hasil Kuis: ' . $quiz->title)

@section('content')
<div class="quiz-result-container">
    <!-- Header Section -->
    <div class="result-header">
        <div class="header-content">
            <div class="header-text">
                <h1>Hasil Kuis</h1>
                <h2>{{ $quiz->title }}</h2>
                <p class="material-info">Materi: {{ $quiz->material->title }}</p>
            </div>
            <div class="score-display">
                <div class="score-circle">
                    <span class="percentage">{{ $attempt->percentage }}%</span>
                    <span class="score-label">Skor Anda</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="stats-overview">
        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-info">
                <span class="stat-value">{{ $attempt->score }}</span>
                <span class="stat-label">Total Poin</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <span class="stat-value">{{ $attempt->correct_answers }}</span>
                <span class="stat-label">Jawaban Benar</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon pink">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stat-info">
                <span class="stat-value">{{ $attempt->total_questions - $attempt->correct_answers }}</span>
                <span class="stat-label">Jawaban Salah</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon teal">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <span class="stat-value">{{ $attempt->duration ?? 'N/A' }}</span>
                <span class="stat-label">Waktu Pengerjaan</span>
            </div>
        </div>
    </div>

    <!-- Grade Badge -->
    <div class="grade-section">
        @php
            $percentage = $attempt->percentage;
            if ($percentage >= 90) {
                $grade = 'A';
                $gradeClass = 'excellent';
            } elseif ($percentage >= 80) {
                $grade = 'B';
                $gradeClass = 'good';
            } elseif ($percentage >= 70) {
                $grade = 'C';
                $gradeClass = 'average';
            } elseif ($percentage >= 60) {
                $grade = 'D';
                $gradeClass = 'below-average';
            } else {
                $grade = 'E';
                $gradeClass = 'poor';
            }
        @endphp
        <div class="grade-badge {{ $gradeClass }}">
            <span class="grade-letter">Grade {{ $grade }}</span>
            <span class="grade-text">
                @if($grade === 'A') Excellent!
                @elseif($grade === 'B') Good Job!
                @elseif($grade === 'C') Not Bad!
                @elseif($grade === 'D') Needs Improvement
                @else Try Again
                @endif
            </span>
        </div>
    </div>

    <!-- Answer Review -->
    <div class="answer-review-section">
        <div class="section-header">
            <i class="fas fa-list-check"></i>
            <h3>Review Jawaban</h3>
        </div>

        <div class="questions-container">
            @foreach($quiz->questions as $index => $question)
                @php
                    $userAnswer = isset($attempt->answers[$question->id]) ? (int)$attempt->answers[$question->id] : null;
                    $isCorrect = $userAnswer === (int)$question->correct_answer;
                    $options = $question->options;
                @endphp

                <div class="question-card {{ $isCorrect ? 'correct' : 'incorrect' }}">
                    <div class="question-header">
                        <span class="question-number">{{ $index + 1 }}</span>
                        <div class="question-points">{{ $question->points }} poin</div>
                    </div>

                    <div class="question-text">{{ $question->question }}</div>

                    <div class="options-container">
                        @foreach($options as $optionIndex => $option)
                            @php
                                $isUserAnswer = $userAnswer === $optionIndex;
                                $isCorrectAnswer = $optionIndex === (int)$question->correct_answer;
                            @endphp

                            <div class="option {{ $isCorrectAnswer ? 'correct-answer' : '' }} {{ $isUserAnswer && !$isCorrectAnswer ? 'user-incorrect' : '' }}">
                                <span class="option-letter">{{ chr(65 + $optionIndex) }}</span>
                                <span class="option-text">{{ $option }}</span>
                                @if($isCorrectAnswer)
                                    <span class="option-feedback correct">
                                        <i class="fas fa-check"></i> Jawaban Benar
                                    </span>
                                @elseif($isUserAnswer && !$isCorrectAnswer)
                                    <span class="option-feedback incorrect">
                                        <i class="fas fa-times"></i> Jawaban Anda
                                    </span>
                                @endif
                            </div>
                        @endforeach

                        @if($userAnswer === null)
                            <div class="not-answered">
                                <i class="fas fa-exclamation-circle"></i> Tidak dijawab
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Feedback & Actions -->
    <div class="feedback-section">
        @if($attempt->percentage < 70)
            <div class="feedback-message improvement">
                <i class="fas fa-book-open"></i>
                <div>
                    <h4>Tips untuk meningkatkan</h4>
                    <p>Nilai Anda masih di bawah 70%. Silakan pelajari kembali materi untuk pemahaman yang lebih baik.</p>
                </div>
            </div>
        @elseif($attempt->percentage >= 90)
            <div class="feedback-message excellent">
                <i class="fas fa-trophy"></i>
                <div>
                    <h4>Selamat!</h4>
                    <p>Nilai Anda sangat baik! Anda telah menguasai materi dengan baik.</p>
                </div>
            </div>
        @endif

        <div class="action-buttons">
            <a href="{{ route('materials.show', $quiz->material) }}" class="back-button">
                <i class="fas fa-arrow-left"></i> Kembali ke Materi
            </a>
        </div>
    </div>
</div>

<style>
/* Base Styles */
.quiz-result-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 20px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #333;
}

/* Header Section */
.result-header {
    background: linear-gradient(135deg, #6a5acd 0%, #4b6cb7 100%);
    color: white;
    padding: 30px;
    border-radius: 12px;
    margin-bottom: 30px;
    box-shadow: 0 4px 20px rgba(106, 90, 205, 0.3);
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header-text h1 {
    margin: 0;
    font-size: 28px;
    font-weight: 700;
}

.header-text h2 {
    margin: 5px 0 0;
    font-size: 22px;
    font-weight: 600;
}

.material-info {
    margin: 8px 0 0;
    opacity: 0.9;
    font-size: 15px;
}

.score-display {
    display: flex;
    align-items: center;
}

.score-circle {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background-color: white;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.percentage {
    font-size: 28px;
    font-weight: 700;
    color: #6a5acd;
    line-height: 1;
}

.score-label {
    font-size: 14px;
    color: #666;
    margin-top: 5px;
}

/* Stats Overview */
.stats-overview {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
    margin-bottom: 30px;
}

.stat-card {
    background-color: white;
    border-radius: 10px;
    padding: 20px 15px;
    display: flex;
    align-items: center;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.stat-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    color: white;
    font-size: 18px;
}

.stat-icon.purple {
    background-color: #9c7be8;
}

.stat-icon.blue {
    background-color: #6a8cff;
}

.stat-icon.pink {
    background-color: #ff7eb9;
}

.stat-icon.teal {
    background-color: #4dc4d0;
}

.stat-info {
    display: flex;
    flex-direction: column;
}

.stat-value {
    font-size: 22px;
    font-weight: 700;
    line-height: 1;
}

.stat-label {
    font-size: 13px;
    color: #777;
    margin-top: 3px;
}

/* Grade Section */
.grade-section {
    margin-bottom: 30px;
    text-align: center;
}

.grade-badge {
    display: inline-flex;
    align-items: center;
    padding: 12px 25px;
    border-radius: 50px;
    font-weight: 600;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.grade-letter {
    font-size: 24px;
    margin-right: 10px;
}

.grade-text {
    font-size: 16px;
}

.grade-badge.excellent {
    background: linear-gradient(135deg, #9c7be8 0%, #6a5acd 100%);
    color: white;
}

.grade-badge.good {
    background: linear-gradient(135deg, #6a8cff 0%, #4b6cb7 100%);
    color: white;
}

.grade-badge.average {
    background: linear-gradient(135deg, #4dc4d0 0%, #2a9bb3 100%);
    color: white;
}

.grade-badge.below-average {
    background: linear-gradient(135deg, #ffb347 0%, #ff8c00 100%);
    color: white;
}

.grade-badge.poor {
    background: linear-gradient(135deg, #ff7eb9 0%, #ff5a8a 100%);
    color: white;
}

/* Answer Review Section */
.answer-review-section {
    background-color: white;
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 30px;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
}

.section-header {
    display: flex;
    align-items: center;
    margin-bottom: 25px;
}

.section-header i {
    font-size: 22px;
    color: #6a5acd;
    margin-right: 10px;
}

.section-header h3 {
    margin: 0;
    font-size: 20px;
    color: #444;
}

.questions-container {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.question-card {
    border-radius: 10px;
    padding: 20px;
    background-color: #f9f9f9;
    border-left: 5px solid;
}

.question-card.correct {
    border-color: #4caf50;
}

.question-card.incorrect {
    border-color: #f44336;
}

.question-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.question-number {
    width: 28px;
    height: 28px;
    background-color: #6a5acd;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 600;
}

.question-card.correct .question-number {
    background-color: #4caf50;
}

.question-card.incorrect .question-number {
    background-color: #f44336;
}

.question-points {
    font-size: 14px;
    font-weight: 600;
    color: #666;
}

.question-text {
    font-size: 16px;
    line-height: 1.5;
    margin-bottom: 15px;
    color: #333;
}

.options-container {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.option {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    background-color: white;
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    position: relative;
}

.option-letter {
    font-weight: 600;
    margin-right: 10px;
    color: #6a5acd;
}

.option-text {
    flex-grow: 1;
}

.option-feedback {
    font-size: 13px;
    margin-left: 10px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.correct-answer {
    border-color: #4caf50;
    background-color: #e8f5e9;
}

.user-incorrect {
    border-color: #f44336;
    background-color: #ffebee;
}

.option-feedback.correct {
    color: #4caf50;
}

.option-feedback.incorrect {
    color: #f44336;
}

.not-answered {
    padding: 10px 15px;
    background-color: #fff3e0;
    border-radius: 8px;
    color: #ff9800;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* Feedback Section */
.feedback-section {
    margin-bottom: 30px;
}

.feedback-message {
    display: flex;
    align-items: center;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    gap: 15px;
}

.feedback-message i {
    font-size: 24px;
}

.feedback-message.excellent {
    background-color: #e8f5e9;
    color: #2e7d32;
}

.feedback-message.improvement {
    background-color: #fff3e0;
    color: #e65100;
}

.feedback-message h4 {
    margin: 0 0 5px;
    font-size: 18px;
}

.feedback-message p {
    margin: 0;
    font-size: 15px;
}

.action-buttons {
    text-align: center;
}

.back-button {
    display: inline-flex;
    align-items: center;
    padding: 12px 25px;
    background-color: #6a5acd;
    color: white;
    text-decoration: none;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 10px rgba(106, 90, 205, 0.3);
}

.back-button:hover {
    background-color: #5a4ab5;
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(106, 90, 205, 0.4);
}

.back-button i {
    margin-right: 8px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        text-align: center;
    }

    .score-display {
        margin-top: 20px;
    }

    .stats-overview {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 480px) {
    .stats-overview {
        grid-template-columns: 1fr;
    }

    .result-header {
        padding: 20px;
    }

    .score-circle {
        width: 80px;
        height: 80px;
    }

    .percentage {
        font-size: 24px;
    }
}
</style>
@endsection
