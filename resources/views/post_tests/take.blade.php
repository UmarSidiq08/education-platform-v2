@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <i class="fas fa-graduation-cap me-2"></i>Post Test: {{ $postTest->title }}
                            </h4>
                            <div id="timer" class="bg-danger px-3 py-1 rounded">
                                <i class="fas fa-clock me-1"></i>
                                <span
                                    id="time-remaining">{{ gmdate('i:s', $timeRemaining ?? $postTest->time_limit * 60) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (isset($attempt) && $attempt)
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                Anda memiliki attempt yang sedang berjalan. Waktu tersisa:
                                <strong id="resume-time">{{ gmdate('i:s', $attempt->time_remaining) }}</strong>
                            </div>
                        @endif

                        <div class="mb-4">
                            <h5>Deskripsi Post Test:</h5>
                            <p>{{ $postTest->description ?? 'Tidak ada deskripsi' }}</p>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h6><i class="fas fa-clock me-1"></i>Waktu</h6>
                                            <p class="mb-0">{{ $postTest->time_limit }} menit</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h6><i class="fas fa-trophy me-1"></i>Nilai Kelulusan</h6>
                                            <p class="mb-0">{{ $postTest->passing_score }}%</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body text-center">
                                            <h6><i class="fas fa-question-circle me-1"></i>Jumlah Soal</h6>
                                            <p class="mb-0">{{ $postTest->questions->count() }} soal</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        @if (!isset($attempt) || !$attempt)
                            <div class="text-center py-4">
                                <h5>Mulai Post Test</h5>
                                <p class="text-muted">Pastikan Anda sudah siap sebelum memulai post test.</p>
                                <form action="{{ route('post_tests.start', $postTest) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-play me-2"></i>Mulai Post Test
                                    </button>
                                </form>
                            </div>
                        @else
                            <form id="quiz-form" action="{{ route('post_tests.submit', $postTest) }}" method="POST">
                                @csrf
                                <input type="hidden" name="started_at" value="{{ $attempt->started_at }}">

                                <div class="questions-container">
                                    @foreach ($postTest->questions as $index => $question)
                                        <div class="question-card card mb-4">
                                            <div class="card-header bg-light">
                                                <h6 class="mb-0">Pertanyaan #{{ $index + 1 }}</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="question-text mb-3">
                                                    <p class="fw-bold">{!! nl2br(e($question->question)) !!}</p>
                                                    <small class="text-muted">Poin: {{ $question->points }}</small>
                                                </div>

                                                <div class="options-list">
                                                    @foreach ($question->options as $optionIndex => $option)
                                                        <div class="form-check mb-2">
                                                            <input class="form-check-input" type="radio"
                                                                name="answers[{{ $question->id }}]"
                                                                id="q{{ $question->id }}_opt{{ $optionIndex }}"
                                                                value="{{ $optionIndex }}"
                                                                {{ isset($attempt->answers[$question->id]) && $attempt->answers[$question->id] == $optionIndex ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="q{{ $question->id }}_opt{{ $optionIndex }}">
                                                                {{ chr(65 + $optionIndex) }}. {{ $option }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="fixed-bottom bg-white border-top p-3">
                                    <div class="container">
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <div class="progress">
                                                    <div class="progress-bar" id="progress-bar" role="progressbar"
                                                        style="width: 0%" aria-valuenow="0" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                                <small class="text-muted"
                                                    id="progress-text">0/{{ $postTest->questions->count() }}
                                                    terjawab</small>
                                            </div>
                                            <div class="col-md-6 text-end">
                                                <button type="submit" class="btn btn-success btn-lg">
                                                    <i class="fas fa-paper-plane me-2"></i>Submit Jawaban
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @if (isset($attempt) && $attempt)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const quizForm = document.getElementById('quiz-form');
                const timeRemainingElement = document.getElementById('time-remaining');
                const progressBar = document.getElementById('progress-bar');
                const progressText = document.getElementById('progress-text');
                const totalQuestions = {{ $postTest->questions->count() }};

                let timeRemaining = {{ $attempt->time_remaining }};
                let timerInterval;

                // Fungsi update timer
                function updateTimer() {
                    if (timeRemaining <= 0) {
                        clearInterval(timerInterval);
                        alert('Waktu telah habis! Jawaban akan otomatis disubmit.');
                        quizForm.submit();
                        return;
                    }

                    timeRemaining--;
                    const minutes = Math.floor(timeRemaining / 60);
                    const seconds = timeRemaining % 60;
                    timeRemainingElement.textContent =
                        `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                    // Update waktu tersisa di server setiap 30 detik
                    if (timeRemaining % 30 === 0) {
                        saveTimeRemaining();
                    }
                }

                // Fungsi save time remaining ke server
                function saveTimeRemaining() {
                    fetch(`/post-tests/{{ $postTest->id }}/update-timer`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            time_remaining: timeRemaining
                        })
                    }).catch(error => console.error('Error saving time:', error));
                }

                // Fungsi hitung progress
                function updateProgress() {
                    const answered = document.querySelectorAll('input[type="radio"]:checked').length;
                    const progress = (answered / totalQuestions) * 100;

                    progressBar.style.width = `${progress}%`;
                    progressBar.setAttribute('aria-valuenow', progress);
                    progressText.textContent = `${answered}/${totalQuestions} terjawab`;

                    // Warning jika waktu hampir habis
                    if (timeRemaining < 60) {
                        timeRemainingElement.parentElement.classList.add('bg-warning');
                    }
                    if (timeRemaining < 30) {
                        timeRemainingElement.parentElement.classList.remove('bg-warning');
                        timeRemainingElement.parentElement.classList.add('bg-danger');
                    }
                }

                // Auto save progress setiap 30 detik
                function autoSaveProgress() {
                    const answers = {};

                    document.querySelectorAll('input[type="radio"]:checked').forEach(input => {
                        answers[input.name.replace('answers[', '').replace(']', '')] = input.value;
                    });

                    fetch(`/post-tests/{{ $postTest->id }}/save-progress`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            answers: answers
                        })
                    }).catch(error => console.error('Error saving progress:', error));
                }

                // Event listeners
                document.querySelectorAll('input[type="radio"]').forEach(input => {
                    input.addEventListener('change', updateProgress);
                });

                // Initialize
                updateProgress();
                timerInterval = setInterval(updateTimer, 1000);
                setInterval(autoSaveProgress, 30000);

                // Handle form submit
                quizForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Kumpulkan semua jawaban
                    const formData = new FormData(this);
                    const answers = {};

                    document.querySelectorAll('input[type="radio"]:checked').forEach(input => {
                        const questionId = input.name.replace('answers[', '').replace(']', '');
                        answers[questionId] = input.value;
                    });

                    // Tambahkan answers ke form data
                    const answersInput = document.createElement('input');
                    answersInput.type = 'hidden';
                    answersInput.name = 'answers';
                    answersInput.value = JSON.stringify(answers);
                    this.appendChild(answersInput);

                    const answered = Object.keys(answers).length;
                    if (answered < totalQuestions) {
                        if (!confirm(
                                `Anda hanya menjawab ${answered} dari ${totalQuestions} soal. Yakin ingin submit?`
                                )) {
                            this.removeChild(answersInput);
                            return;
                        }
                    }

                    clearInterval(timerInterval);
                    this.submit();
                });

                // Warning sebelum close/tab close
                window.addEventListener('beforeunload', function(e) {
                    if (timeRemaining > 0) {
                        const message =
                            'Progress Anda akan disimpan otomatis. Yakin ingin meninggalkan halaman?';
                        e.returnValue = message;
                        return message;
                    }
                });
            });
        </script>
    @endif
@endsection

<style>
    .question-card {
        border-left: 4px solid #007bff;
    }

    #timer {
        font-size: 1.1rem;
        font-weight: bold;
    }

    .fixed-bottom {
        box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
    }

    .progress {
        height: 8px;
    }

    .options-list .form-check {
        padding-left: 2rem;
    }

    .options-list .form-check-input {
        width: 1.2em;
        height: 1.2em;
        margin-top: 0.15em;
    }
</style>
