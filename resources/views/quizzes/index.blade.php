@extends('layouts.app')

@section('title', 'Statistik Kuis - ' . $material->title)

@section('content')
<div class="stats-container">
    <!-- Header Section -->
    <div class="stats-header">
        <div class="header-content">
            <div class="header-text">
                <h2>Statistik Kuis</h2>
                <p class="material-name">Materi: {{ $material->title }}</p>
            </div>
            <a href="{{ route('materials.show', $material) }}" class="back-button">
                <span class="icon">←</span> Kembali
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="stats-content">
        @if($quizzes->count() > 0)
            @php $activeQuiz = $quizzes->where('is_active', true)->first(); @endphp
            @if($activeQuiz)
                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <h3 class="stat-value">{{ $activeQuiz->attempts->count() }}</h3>
                        <p class="stat-label">Total Peserta</p>
                    </div>
                    <div class="stat-card">
                        <h3 class="stat-value success">{{ $activeQuiz->attempts->avg('percentage') ? round($activeQuiz->attempts->avg('percentage'), 1) : 0 }}%</h3>
                        <p class="stat-label">Rata-rata Nilai</p>
                    </div>
                    <div class="stat-card">
                        <h3 class="stat-value info">{{ $activeQuiz->attempts->max('percentage') ?? 0 }}%</h3>
                        <p class="stat-label">Nilai Tertinggi</p>
                    </div>
                    <div class="stat-card">
                        <h3 class="stat-value warning">{{ $activeQuiz->attempts->min('percentage') ?? 0 }}%</h3>
                        <p class="stat-label">Nilai Terendah</p>
                    </div>
                </div>
            @endif
        @else
            <div class="empty-state">
                <div class="empty-icon">📊</div>
                <h3>Belum ada kuis</h3>
                <p>Buat kuis terlebih dahulu untuk melihat statistik</p>
                <a href="{{ route('quizzes.create', $material) }}" class="primary-button">
                    <span class="icon">+</span> Buat Kuis
                </a>
            </div>
        @endif

        @if($quizzes->count() > 0)
            @php $activeQuiz = $quizzes->where('is_active', true)->first(); @endphp
            @if($activeQuiz && $activeQuiz->attempts->count() > 0)
                <!-- Student Results Table -->
                <div class="stats-section">
                    <div class="section-header">
                        <span class="icon">👥</span>
                        <h3>Hasil Siswa</h3>
                    </div>
                    <div class="table-container">
                        <table class="results-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Siswa</th>
                                    <th>Skor</th>
                                    <th>Benar/Total</th>
                                    <th>Persentase</th>
                                    <th>Grade</th>
                                    <th>Waktu Selesai</th>
                                    <th>Durasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activeQuiz->attempts->sortByDesc('percentage') as $index => $attempt)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div class="student-info">
                                                <div class="student-avatar">
                                                    {{ strtoupper(substr($attempt->user->name, 0, 1)) }}
                                                </div>
                                                {{ $attempt->user->name }}
                                            </div>
                                        </td>
                                        <td>
                                            <strong>{{ $attempt->score }}</strong>
                                            <span class="unit">pts</span>
                                        </td>
                                        <td>{{ $attempt->correct_answers }}/{{ $attempt->total_questions }}</td>
                                        <td>
                                            <div class="progress-container">
                                                <div class="progress-bar" style="width: {{ $attempt->percentage }}%"></div>
                                                <span class="percentage-badge">{{ $attempt->percentage }}%</span>
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $percentage = $attempt->percentage;
                                                if ($percentage >= 90) {
                                                    $grade = 'A'; $gradeClass = 'success';
                                                } elseif ($percentage >= 80) {
                                                    $grade = 'B'; $gradeClass = 'info';
                                                } elseif ($percentage >= 70) {
                                                    $grade = 'C'; $gradeClass = 'warning';
                                                } elseif ($percentage >= 60) {
                                                    $grade = 'D'; $gradeClass = 'secondary';
                                                } else {
                                                    $grade = 'E'; $gradeClass = 'danger';
                                                }
                                            @endphp
                                            <span class="grade-badge {{ $gradeClass }}">{{ $grade }}</span>
                                        </td>
                                        <td>
                                            <span class="timestamp">{{ $attempt->finished_at->format('d/m/Y H:i') }}</span>
                                        </td>
                                        <td>
                                            <span class="duration">{{ $attempt->duration }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Question Analysis -->
                <div class="stats-section">
                    <div class="section-header">
                        <span class="icon">📝</span>
                        <h3>Analisis Per Soal</h3>
                    </div>
                    <div class="question-analysis-container">
                        @foreach($activeQuiz->questions as $index => $question)
                            @php
                                $totalAttempts = $activeQuiz->attempts->count();
                                $correctCount = 0;

                                foreach($activeQuiz->attempts as $attempt) {
                                    $userAnswer = isset($attempt->answers[$question->id]) ? (int)$attempt->answers[$question->id] : null;
                                    if ($userAnswer === (int)$question->correct_answer) {
                                        $correctCount++;
                                    }
                                }

                                $correctPercentage = $totalAttempts > 0 ? round(($correctCount / $totalAttempts) * 100) : 0;
                            @endphp

                            <div class="question-analysis">
                                <div class="question-header">
                                    <span class="question-number">{{ $index + 1 }}</span>
                                    <h4>{{ Str::limit($question->question, 80) }}</h4>
                                    <span class="correct-percentage {{ $correctPercentage >= 80 ? 'success' : ($correctPercentage >= 60 ? 'warning' : 'danger') }}">
                                        {{ $correctPercentage }}% benar
                                    </span>
                                </div>

                                <div class="question-progress">
                                    <div class="progress-track">
                                        <div class="progress-fill" style="width: {{ $correctPercentage }}%"></div>
                                    </div>
                                    <div class="progress-info">
                                        <span>{{ $correctCount }} dari {{ $totalAttempts }} siswa menjawab dengan benar</span>
                                        <span class="question-points">{{ $question->points }} poin</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Quiz History -->
            @if($quizzes->count() > 1)
                <div class="stats-section">
                    <div class="section-header">
                        <span class="icon">🕒</span>
                        <h3>Riwayat Kuis</h3>
                    </div>
                    <div class="table-container">
                        <table class="history-table">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Status</th>
                                    <th>Peserta</th>
                                    <th>Dibuat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($quizzes as $quiz)
                                    <tr>
                                        <td>{{ $quiz->title }}</td>
                                        <td>
                                            <span class="status-badge {{ $quiz->is_active ? 'active' : 'inactive' }}">
                                                {{ $quiz->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </td>
                                        <td>{{ $quiz->attempts->count() }}</td>
                                        <td>{{ $quiz->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            @if(!$quiz->is_active)
                                                <button class="action-button" onclick="activateQuiz({{ $quiz->id }})">
                                                    Aktifkan
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>

<style>
/* Base Styles */
.stats-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #333;
}

/* Header Styles */
.stats-header {
    background-color: #2c3e50;
    color: white;
    padding: 20px;
    border-radius: 8px 8px 0 0;
    margin-bottom: 20px;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header-text h2 {
    margin: 0;
    font-size: 24px;
}

.material-name {
    margin: 5px 0 0;
    opacity: 0.9;
    font-size: 14px;
}

.back-button {
    display: inline-flex;
    align-items: center;
    padding: 8px 15px;
    background-color: #f8f9fa;
    color: #2c3e50;
    text-decoration: none;
    border-radius: 4px;
    font-weight: 500;
    transition: background-color 0.2s;
}

.back-button:hover {
    background-color: #e9ecef;
}

.icon {
    margin-right: 5px;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
    margin-bottom: 30px;
}

.stat-card {
    background-color: white;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    text-align: center;
}

.stat-value {
    font-size: 28px;
    margin: 0 0 5px;
}

.stat-value.success {
    color: #27ae60;
}

.stat-value.info {
    color: #2980b9;
}

.stat-value.warning {
    color: #f39c12;
}

.stat-label {
    margin: 0;
    color: #7f8c8d;
    font-size: 14px;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 40px 20px;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}

.empty-icon {
    font-size: 50px;
    margin-bottom: 15px;
}

.empty-state h3 {
    margin: 10px 0;
    color: #2c3e50;
}

.empty-state p {
    color: #7f8c8d;
    margin-bottom: 20px;
}

.primary-button {
    display: inline-flex;
    align-items: center;
    padding: 10px 20px;
    background-color: #3498db;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    font-weight: 500;
    transition: background-color 0.2s;
}

.primary-button:hover {
    background-color: #2980b9;
}

/* Section Styles */
.stats-section {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    padding: 20px;
    margin-bottom: 30px;
}

.section-header {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid #ecf0f1;
}

.section-header h3 {
    margin: 0;
    font-size: 18px;
    color: #2c3e50;
}

.section-header .icon {
    font-size: 20px;
    margin-right: 10px;
}

/* Table Styles */
.table-container {
    overflow-x: auto;
}

.results-table, .history-table {
    width: 100%;
    border-collapse: collapse;
}

.results-table th, .history-table th {
    background-color: #f8f9fa;
    padding: 12px 15px;
    text-align: left;
    font-weight: 600;
    color: #2c3e50;
    border-bottom: 2px solid #ecf0f1;
}

.results-table td, .history-table td {
    padding: 12px 15px;
    border-bottom: 1px solid #ecf0f1;
    vertical-align: middle;
}

.results-table tr:hover, .history-table tr:hover {
    background-color: #f8f9fa;
}

/* Student Info */
.student-info {
    display: flex;
    align-items: center;
}

.student-avatar {
    width: 32px;
    height: 32px;
    background-color: #3498db;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 10px;
    font-weight: bold;
}

.unit {
    color: #7f8c8d;
    font-size: 12px;
    margin-left: 3px;
}

/* Progress Bar */
.progress-container {
    display: flex;
    align-items: center;
}

.progress-bar {
    height: 8px;
    background-color: #27ae60;
    border-radius: 4px;
    margin-right: 10px;
}

.percentage-badge {
    font-size: 12px;
    font-weight: 500;
    padding: 3px 8px;
    border-radius: 10px;
    background-color: #27ae60;
    color: white;
}

/* Grade Badge */
.grade-badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 12px;
    color: white;
}

.grade-badge.success {
    background-color: #27ae60;
}

.grade-badge.info {
    background-color: #2980b9;
}

.grade-badge.warning {
    background-color: #f39c12;
}

.grade-badge.secondary {
    background-color: #7f8c8d;
}

.grade-badge.danger {
    background-color: #e74c3c;
}

.timestamp, .duration {
    font-size: 13px;
    color: #7f8c8d;
}

/* Question Analysis */
.question-analysis-container {
    display: grid;
    gap: 15px;
}

.question-analysis {
    padding: 15px;
    border: 1px solid #ecf0f1;
    border-radius: 6px;
}

.question-header {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.question-number {
    background-color: #3498db;
    color: white;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: bold;
    margin-right: 10px;
}

.question-header h4 {
    margin: 0;
    font-size: 15px;
    flex-grow: 1;
    color: #2c3e50;
}

.correct-percentage {
    font-size: 13px;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 10px;
}

.correct-percentage.success {
    background-color: #d5f5e3;
    color: #27ae60;
}

.correct-percentage.warning {
    background-color: #fdebd0;
    color: #f39c12;
}

.correct-percentage.danger {
    background-color: #fadbd8;
    color: #e74c3c;
}

.question-progress {
    display: flex;
    flex-direction: column;
}

.progress-track {
    height: 10px;
    background-color: #ecf0f1;
    border-radius: 5px;
    margin-bottom: 5px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background-color: #27ae60;
}

.progress-info {
    display: flex;
    justify-content: space-between;
    font-size: 13px;
    color: #7f8c8d;
}

.question-points {
    font-weight: 600;
    color: #2c3e50;
}

/* Status Badge */
.status-badge {
    padding: 3px 10px;
    border-radius: 10px;
    font-size: 12px;
    font-weight: 600;
}

.status-badge.active {
    background-color: #d5f5e3;
    color: #27ae60;
}

.status-badge.inactive {
    background-color: #ebedef;
    color: #7f8c8d;
}

/* Action Button */
.action-button {
    padding: 5px 12px;
    background-color: transparent;
    border: 1px solid #27ae60;
    color: #27ae60;
    border-radius: 4px;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.2s;
}

.action-button:hover {
    background-color: #27ae60;
    color: white;
}

/* Responsive Design */
@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .header-content {
        flex-direction: column;
        align-items: flex-start;
    }

    .back-button {
        margin-top: 15px;
    }
}

@media (max-width: 480px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }

    .question-header {
        flex-wrap: wrap;
    }

    .correct-percentage {
        margin-top: 5px;
        margin-left: 34px; /* avatar width + margin */
    }
}
</style>

<script>
function activateQuiz(quizId) {
    if(confirm('Aktifkan kuis ini? Kuis yang sedang aktif akan dinonaktifkan.')) {
        // Implementasi activate quiz (bisa dibuat route terpisah)
        console.log('Activate quiz:', quizId);
    }
}
</script>
@endsection
