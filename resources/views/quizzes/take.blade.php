@extends('layouts.app')

@section('title', 'Kuis: ' . $quiz->title)

@section('content')
    <div class="quiz-container">
        <div class="container">
            <!-- Background Elements -->
            <div class="bg-decoration">
                <div class="circle circle-1"></div>
                <div class="circle circle-2"></div>
                <div class="circle circle-3"></div>
            </div>

            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-10 col-xl-9">
                    <!-- Quiz Header Card -->
                    <div class="quiz-header-card">
                        <div class="quiz-header-content">
                            <div class="quiz-info">
                                <h1 class="quiz-title">{{ $quiz->title }}</h1>
                                <div class="quiz-subtitle">
                                    <i class="fas fa-book-open"></i>
                                    <span>{{ $quiz->material->title }}</span>
                                </div>
                            </div>
                            <div class="timer-section">
                                <div class="timer-container">
                                    <div id="timer" class="timer-display">
                                        {{ $quiz->time_limit }}:00
                                    </div>
                                    <div class="timer-label">Waktu Tersisa</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quiz Info Stats -->
                    <div class="quiz-stats">
                        @if ($quiz->description)
                            <div class="quiz-description">
                                <i class="fas fa-info-circle"></i>
                                <span>{{ $quiz->description }}</span>
                            </div>
                        @endif

                        <div class="stats-grid">
                            <div class="stat-item">
                                <div class="stat-icon">
                                    <i class="fas fa-list-ol"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-number">{{ $quiz->total_questions }}</div>
                                    <div class="stat-label">Soal</div>
                                </div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-number">{{ $quiz->time_limit }}</div>
                                    <div class="stat-label">Menit</div>
                                </div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-icon">
                                    <i class="fas fa-star"></i>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-number">{{ $quiz->questions->sum('points') }}</div>
                                    <div class="stat-label">Poin</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quiz Form -->
                    <form id="quiz-form" action="{{ route('quizzes.submit', $quiz) }}" method="POST">
                        @csrf
                        <input type="hidden" name="started_at" value="{{ now() }}">

                        <div class="questions-container">
                            @foreach ($quiz->questions as $index => $question)
                                <div class="question-card" data-question="{{ $index + 1 }}">
                                    <div class="question-header">
                                        <div class="question-number">
                                            <span>{{ $index + 1 }}</span>
                                        </div>
                                        <div class="question-info">
                                            <h3 class="question-title">Soal {{ $index + 1 }}</h3>
                                            <div class="question-points">
                                                <i class="fas fa-gem"></i>
                                                {{ $question->points }} poin
                                            </div>
                                        </div>
                                    </div>

                                    <div class="question-body">
                                        <div class="question-text">{{ $question->question }}</div>

                                        <div class="options-container">
                                            @foreach ($question->options as $optionIndex => $option)
                                                <div class="option-item">
                                                    <input class="option-input" type="radio"
                                                        name="answers[{{ $question->id }}]"
                                                        id="q{{ $question->id }}_option{{ $optionIndex }}"
                                                        value="{{ $optionIndex }}" required>
                                                    <label class="option-label"
                                                        for="q{{ $question->id }}_option{{ $optionIndex }}">
                                                        <div class="option-marker">{{ chr(65 + $optionIndex) }}</div>
                                                        <div class="option-content">{{ $option }}</div>
                                                        <div class="option-check">
                                                            <i class="fas fa-check"></i>
                                                        </div>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Action Buttons - FIXED: Hapus semua atribut Bootstrap modal -->
                        <div class="quiz-actions">
                            <a href="{{ route('materials.show', $quiz->material) }}" class="btn btn-secondary-custom">
                                <i class="fas fa-arrow-left"></i>
                                <span>Kembali ke Materi</span>
                            </a>

                            <!-- PENTING: Hanya ID, tidak ada data-bs-* apapun -->
                            <button type="button" class="btn btn-primary-custom" id="submit-quiz-btn">
                                <i class="fas fa-paper-plane"></i>
                                <span>Selesai & Submit</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- FIXED Submit Confirmation Modal - Hapus semua auto-trigger -->
    <div class="modal" id="confirmationModal" style="display: none;">
        <div class="modal-backdrop"></div>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                        Konfirmasi Submit
                    </h5>
                    <button type="button" class="btn-close" id="close-modal-btn">×</button>
                </div>
                <div class="modal-body">
                    <p class="modal-description">
                        Apakah Anda yakin ingin mengirim jawaban?
                        <strong>Setelah dikirim, Anda tidak dapat mengubah jawaban lagi.</strong>
                    </p>
                    <div id="unanswered-alert" class="alert alert-warning custom-alert" style="display: none;">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Perhatian:</strong> Masih ada <span id="unanswered-count">0</span> soal yang belum dijawab.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary-custom" id="cancel-submit-btn">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="button" class="btn btn-primary-custom" id="confirm-submit-btn">
                        <i class="fas fa-check me-2"></i>Ya, Kirim Jawaban
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Existing CSS styles remain the same... */
        /* Root Variables */
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --card-shadow-hover: 0 20px 40px rgba(0, 0, 0, 0.15);
            --border-radius: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Custom Modal Styles - FIXED */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .modal.show {
            opacity: 1;
            visibility: visible;
        }

        .modal-backdrop {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }

        .modal-dialog {
            position: relative;
            margin: 0 auto;
            top: 50%;
            transform: translateY(-50%);
            max-width: 500px;
            width: 90%;
        }

        .custom-modal {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            background: white;
        }

        .custom-modal .modal-header {
            background: var(--primary-gradient);
            color: white;
            border-bottom: none;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
            padding: 1.5rem;
        }

        .custom-modal .modal-body {
            padding: 2rem;
        }

        .custom-modal .modal-footer {
            border-top: 1px solid #e9ecef;
            padding: 1.5rem;
        }

        .btn-close {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .alert.custom-alert {
            border-radius: 10px;
            border: none;
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            color: #856404;
            margin-top: 1rem;
        }

        /* Rest of your existing CSS... */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .quiz-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 2rem 0;
            position: relative;
            overflow-x: hidden;
        }

        .bg-decoration {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            animation: float 8s ease-in-out infinite;
        }

        .circle-1 {
            width: 150px;
            height: 150px;
            top: 15%;
            left: 5%;
            animation-delay: 0s;
        }

        .circle-2 {
            width: 100px;
            height: 100px;
            top: 60%;
            right: 8%;
            animation-delay: 3s;
        }

        .circle-3 {
            width: 80px;
            height: 80px;
            bottom: 25%;
            left: 15%;
            animation-delay: 6s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        /* Quiz Header */
        .quiz-header-card {
            background: var(--primary-gradient);
            border-radius: var(--border-radius);
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
            color: white;
        }

        .quiz-header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 2rem;
        }

        .quiz-title {
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
            line-height: 1.2;
        }

        .quiz-subtitle {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .timer-section {
            text-align: center;
        }

        .timer-container {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 1.5rem;
            min-width: 150px;
        }

        .timer-display {
            font-size: 2.5rem;
            font-weight: 700;
            font-family: 'Courier New', monospace;
            margin-bottom: 0.5rem;
        }

        .timer-label {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .timer-display.warning {
            color: #ffc107 !important;
            animation: pulse-warning 2s infinite;
        }

        .timer-display.danger {
            color: #dc3545 !important;
            animation: pulse-danger 1s infinite;
        }

        @keyframes pulse-warning {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        @keyframes pulse-danger {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.7;
            }
        }

        /* Quiz Stats */
        .quiz-stats {
            background: white;
            border-radius: var(--border-radius);
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
        }

        .quiz-description {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 1.5rem;
            background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-size: 1rem;
            color: #2c3e50;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1.5rem;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%);
            border-radius: 12px;
            border-left: 4px solid;
            transition: var(--transition);
        }

        .stat-item:nth-child(1) {
            border-left-color: #667eea;
        }

        .stat-item:nth-child(2) {
            border-left-color: #f093fb;
        }

        .stat-item:nth-child(3) {
            border-left-color: #4facfe;
        }

        .stat-item:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: white;
        }

        .stat-item:nth-child(1) .stat-icon {
            background: var(--primary-gradient);
        }

        .stat-item:nth-child(2) .stat-icon {
            background: var(--secondary-gradient);
        }

        .stat-item:nth-child(3) .stat-icon {
            background: var(--success-gradient);
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #6c757d;
        }

        /* Questions Container */
        .questions-container {
            display: flex;
            flex-direction: column;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        /* Question Card */
        .question-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            overflow: hidden;
            transition: var(--transition);
        }

        .question-card:hover {
            box-shadow: var(--card-shadow-hover);
            transform: translateY(-2px);
        }

        .question-header {
            background: var(--primary-gradient);
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            color: white;
        }

        .question-number {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: 700;
            backdrop-filter: blur(10px);
        }

        .question-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin: 0;
        }

        .question-points {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            backdrop-filter: blur(10px);
        }

        .question-body {
            padding: 2rem;
        }

        .question-text {
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
            color: #2c3e50;
            line-height: 1.6;
        }

        /* Options */
        .options-container {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .option-item {
            position: relative;
        }

        .option-input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .option-label {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.2rem;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            cursor: pointer;
            transition: var(--transition);
            background: #f8f9fa;
            position: relative;
            overflow: hidden;
        }

        .option-label::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background: var(--primary-gradient);
            transition: width 0.3s ease;
            z-index: -1;
            opacity: 0.1;
        }

        .option-label:hover {
            border-color: #667eea;
            background: white;
            box-shadow: 0 3px 10px rgba(102, 126, 234, 0.08);
        }

        .option-label:hover::before {
            width: 100%;
        }

        .option-input:checked+.option-label {
            border-color: #667eea;
            background: white;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.2);
        }

        .option-input:checked+.option-label::before {
            width: 100%;
            opacity: 0.15;
        }

        .option-marker {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #6c757d;
            transition: var(--transition);
            flex-shrink: 0;
        }

        .option-input:checked+.option-label .option-marker {
            background: var(--primary-gradient);
            color: white;
            transform: scale(1.05);
        }

        .option-content {
            flex: 1;
            font-size: 1rem;
            color: #2c3e50;
            line-height: 1.5;
        }

        .option-check {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            opacity: 0;
        }

        .option-input:checked+.option-label .option-check {
            background: var(--success-gradient);
            color: white;
            opacity: 1;
            transform: scale(1.1);
        }

        /* Action Buttons */
        .quiz-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            padding: 2rem 0;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            font-size: 1rem;
        }

        .btn-primary-custom {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-primary-custom:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.35);
            color: white;
        }

        .btn-secondary-custom {
            background: #6c757d;
            color: white;
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
        }

        .btn-secondary-custom:hover {
            background: #5a6268;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(108, 117, 125, 0.35);
            color: white;
            text-decoration: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .quiz-header-content {
                flex-direction: column;
                text-align: center;
                gap: 1.5rem;
            }

            .quiz-title {
                font-size: 1.5rem;
            }

            .timer-display {
                font-size: 2rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .quiz-actions {
                flex-direction: column-reverse;
                gap: 1rem;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .option-label {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.75rem;
                text-align: left;
            }

            .option-marker {
                align-self: flex-start;
            }
        }

        @media (max-width: 576px) {
            .quiz-container {
                padding: 1rem 0;
            }

            .quiz-header-card,
            .quiz-stats,
            .question-body {
                padding: 1.5rem;
            }

            .question-header {
                padding: 1rem 1.5rem;
            }
        }
    </style>

    <script>
        // Fixed JavaScript untuk Quiz - Konfirmasi hanya muncul saat klik Submit

        document.addEventListener('DOMContentLoaded', function() {
            // Timer functionality
            const timeLimit = {{ $quiz->time_limit }};
            let timeRemaining = timeLimit * 60; // convert to seconds
            const timerElement = document.getElementById('timer');
            const quizForm = document.getElementById('quiz-form');

            // Modal elements - menggunakan custom modal, BUKAN Bootstrap
            const confirmationModal = document.getElementById('confirmationModal');
            const submitQuizBtn = document.getElementById('submit-quiz-btn');
            const confirmSubmitBtn = document.getElementById('confirm-submit-btn');
            const cancelSubmitBtn = document.getElementById('cancel-submit-btn');
            const closeModalBtn = document.getElementById('close-modal-btn');
            const modalBackdrop = confirmationModal.querySelector('.modal-backdrop');

            // Unanswered questions alert elements
            const unansweredAlert = document.getElementById('unanswered-alert');
            const unansweredCountSpan = document.getElementById('unanswered-count');

            // Timer countdown
            const timerInterval = setInterval(function() {
                const minutes = Math.floor(timeRemaining / 60);
                const seconds = timeRemaining % 60;

                timerElement.textContent =
                    `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                // Warning when 5 minutes left
                if (timeRemaining <= 300 && timeRemaining > 60) {
                    timerElement.classList.add('warning');
                    timerElement.classList.remove('danger');
                }

                // Danger when 1 minute left
                if (timeRemaining <= 60) {
                    timerElement.classList.remove('warning');
                    timerElement.classList.add('danger');
                }

                // Auto submit when time is up
                if (timeRemaining <= 0) {
                    clearInterval(timerInterval);
                    alert('Waktu habis! Quiz akan otomatis disubmit.');
                    submitQuizDirectly();
                    return;
                }

                timeRemaining--;
            }, 1000);

            // Function to show custom modal
            function showConfirmationModal() {
                confirmationModal.classList.add('show');
                confirmationModal.style.display = 'block';
                document.body.style.overflow = 'hidden'; // Prevent background scrolling
            }

            // Function to hide custom modal
            function hideConfirmationModal() {
                confirmationModal.classList.remove('show');
                setTimeout(() => {
                    confirmationModal.style.display = 'none';
                    document.body.style.overflow = 'auto'; // Restore scrolling
                }, 300);
            }

            // Function to submit quiz directly (bypassing confirmation)
            function submitQuizDirectly() {
                clearInterval(timerInterval);
                quizForm.classList.add('submitting'); // Prevent beforeunload warning
                quizForm.submit();
            }

            // Function to check and update unanswered questions
            function checkUnansweredQuestions() {
                const totalQuestions = {{ $quiz->questions->count() }};
                const answeredQuestions = document.querySelectorAll('input[type="radio"]:checked').length;
                const unansweredCount = totalQuestions - answeredQuestions;

                if (unansweredCount > 0) {
                    unansweredAlert.style.display = 'block';
                    unansweredCountSpan.textContent = unansweredCount;
                } else {
                    unansweredAlert.style.display = 'none';
                }

                return unansweredCount;
            }

            // Event listener untuk submit button - SHOW MODAL
            submitQuizBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                console.log('Submit button clicked - showing confirmation modal');

                // Check unanswered questions
                checkUnansweredQuestions();

                // Show confirmation modal
                showConfirmationModal();
            });

            // Event listener untuk CONFIRM SUBMIT - ACTUAL SUBMIT
            confirmSubmitBtn.addEventListener('click', function(e) {
                e.preventDefault();

                console.log('Confirmed submit - submitting form');

                // Hide modal first
                hideConfirmationModal();

                // Submit form
                submitQuizDirectly();
            });

            // Event listeners untuk CANCEL/CLOSE modal
            cancelSubmitBtn.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Submit cancelled');
                hideConfirmationModal();
            });

            closeModalBtn.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Modal closed');
                hideConfirmationModal();
            });

            // Close modal when clicking backdrop
            modalBackdrop.addEventListener('click', function(e) {
                if (e.target === modalBackdrop) {
                    console.log('Modal closed via backdrop');
                    hideConfirmationModal();
                }
            });

            // Close modal with ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && confirmationModal.classList.contains('show')) {
                    console.log('Modal closed via ESC key');
                    hideConfirmationModal();
                }
            });

            // Radio button change handlers
            const radioButtons = document.querySelectorAll('input[type="radio"]');
            radioButtons.forEach(radio => {
                radio.addEventListener('change', function() {
                    console.log('Answer changed for question:', this.name, 'value:', this.value);

                    // Add smooth animation when option is selected
                    const label = this.nextElementSibling;
                    if (label) {
                        label.style.transform = 'scale(0.98)';
                        setTimeout(() => {
                            label.style.transform = 'scale(1)';
                        }, 150);
                    }

                    // Update progress
                    updateProgress();
                });
            });

            // Progress tracking function
            function updateProgress() {
                const totalQuestions = {{ $quiz->questions->count() }};
                const answeredQuestions = document.querySelectorAll('input[type="radio"]:checked').length;
                const progress = (answeredQuestions / totalQuestions) * 100;

                console.log(`Progress: ${answeredQuestions}/${totalQuestions} (${progress.toFixed(1)}%)`);

                // Update submit button text and style based on progress
                const submitText = submitQuizBtn.querySelector('span');
                if (answeredQuestions === totalQuestions) {
                    submitText.textContent = 'Selesai & Submit';
                    submitQuizBtn.classList.add('btn-success');
                    submitQuizBtn.classList.remove('btn-primary-custom');
                } else {
                    submitText.textContent = `Submit (${answeredQuestions}/${totalQuestions})`;
                    submitQuizBtn.classList.remove('btn-success');
                    submitQuizBtn.classList.add('btn-primary-custom');
                }
            }

            // Prevent page refresh/back dengan konfirmasi
            window.addEventListener('beforeunload', function(e) {
                // Hanya tampilkan peringatan jika quiz belum selesai dan tidak sedang submit
                const isSubmitting = quizForm.classList.contains('submitting');
                if (!isSubmitting) {
                    e.preventDefault();
                    e.returnValue =
                        'Apakah Anda yakin ingin meninggalkan halaman? Progress quiz akan hilang.';
                }
            });

            // Smooth scroll untuk question cards
            document.querySelectorAll('.question-card').forEach((card, index) => {
                card.addEventListener('click', function(e) {
                    // Hanya scroll jika yang diklik bukan radio button atau label
                    if (e.target.type !== 'radio' && !e.target.closest('.option-label')) {
                        const firstUnanswered = card.querySelector(
                            'input[type="radio"]:not(:checked)');
                        if (firstUnanswered && !card.querySelector('input[type="radio"]:checked')) {
                            card.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                        }
                    }
                });
            });

            // Prevent form submission via Enter key tanpa konfirmasi
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && e.target.type !== 'submit') {
                    // Jangan prevent Enter di radio buttons
                    if (e.target.type === 'radio') {
                        return; // Allow normal behavior
                    }

                    // Prevent Enter dari accidentally submit form
                    const activeElement = document.activeElement;
                    if (activeElement && activeElement.form && activeElement.form.id === 'quiz-form') {
                        e.preventDefault();
                    }
                }
            });

            // Initial progress update
            updateProgress();

            // Debug logs
            console.log('Quiz JavaScript initialized');
            console.log('Submit button:', submitQuizBtn);
            console.log('Confirm button:', confirmSubmitBtn);
            console.log('Modal element:', confirmationModal);
            console.log('Quiz form:', quizForm);
        });
    </script>
@endsection
