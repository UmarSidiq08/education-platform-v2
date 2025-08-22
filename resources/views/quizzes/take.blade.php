@extends('layouts.app')

@section('title', 'Kuis: ' . $quiz->title)

@section('content')
    <!-- Background Decorations -->
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute top-[15%] left-[5%] w-32 h-32 lg:w-40 lg:h-40 bg-white bg-opacity-10 rounded-full animate-float"></div>
        <div class="absolute top-[60%] right-[8%] w-20 h-20 lg:w-25 lg:h-25 bg-white bg-opacity-10 rounded-full animate-float" style="animation-delay: 3s;"></div>
        <div class="absolute bottom-[25%] left-[15%] w-16 h-16 lg:w-20 lg:h-20 bg-white bg-opacity-10 rounded-full animate-float" style="animation-delay: 6s;"></div>
    </div>

    <!-- Main Container -->
    <div class="relative z-10 min-h-screen py-8 px-5 bg-quiz-gradient">
        <div class="max-w-6xl mx-auto">
            <div class="flex justify-center">
                <div class="w-full max-w-none md:max-w-5xl lg:max-w-5xl xl:max-w-6xl">

                    <!-- Quiz Header Card -->
                    <div class="bg-primary-gradient rounded-2xl p-8 mb-8 shadow-2xl text-white">
                        <div class="flex flex-col lg:flex-row justify-between items-center gap-8">
                            <!-- Quiz Info -->
                            <div class="text-center lg:text-left">
                                <h1 class="text-3xl lg:text-4xl font-bold mb-2 leading-tight">{{ $quiz->title }}</h1>
                                <div class="flex items-center justify-center lg:justify-start gap-2 text-lg opacity-90">
                                    <i class="fas fa-book-open"></i>
                                    <span>{{ $quiz->material->title }}</span>
                                </div>
                            </div>

                            <!-- Timer Section -->
                            <div class="text-center">
                                <div class="bg-white bg-opacity-20 backdrop-blur-lg rounded-xl p-6 min-w-[150px]">
                                    <div id="timer" class="text-4xl font-bold font-mono mb-2">{{ $quiz->time_limit }}:00</div>
                                    <div class="text-sm opacity-80">Waktu Tersisa</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quiz Stats -->
                    <div class="bg-white rounded-2xl p-8 mb-8 shadow-2xl">
                        <!-- Quiz Description -->
                        @if ($quiz->description)
                            <div class="flex items-center gap-3 p-4 bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl mb-6 text-slate-700">
                                <i class="fas fa-info-circle text-blue-500"></i>
                                <span>{{ $quiz->description }}</span>
                            </div>
                        @endif

                        <!-- Stats Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Questions Stat -->
                            <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-slate-50 to-blue-50 rounded-xl border-l-4 border-blue-500 hover:transform hover:-translate-y-1 transition-all duration-300 hover:shadow-lg">
                                <div class="w-10 h-10 bg-primary-gradient rounded-xl flex items-center justify-center text-white">
                                    <i class="fas fa-list-ol"></i>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-slate-800">{{ $quiz->total_questions }}</div>
                                    <div class="text-sm text-gray-500">Soal</div>
                                </div>
                            </div>

                            <!-- Time Stat -->
                            <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-slate-50 to-pink-50 rounded-xl border-l-4 border-pink-500 hover:transform hover:-translate-y-1 transition-all duration-300 hover:shadow-lg">
                                <div class="w-10 h-10 bg-secondary-gradient rounded-xl flex items-center justify-center text-white">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-slate-800">{{ $quiz->time_limit }}</div>
                                    <div class="text-sm text-gray-500">Menit</div>
                                </div>
                            </div>

                            <!-- Points Stat -->
                            <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-slate-50 to-cyan-50 rounded-xl border-l-4 border-cyan-500 hover:transform hover:-translate-y-1 transition-all duration-300 hover:shadow-lg">
                                <div class="w-10 h-10 bg-success-gradient rounded-xl flex items-center justify-center text-white">
                                    <i class="fas fa-star"></i>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-slate-800">{{ $quiz->questions->sum('points') }}</div>
                                    <div class="text-sm text-gray-500">Poin</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quiz Form -->
                    <form id="quiz-form" action="{{ route('quizzes.submit', $quiz) }}" method="POST" class="space-y-8 mb-8">
                        @csrf
                        <input type="hidden" name="started_at" value="{{ now() }}">

                        <!-- Questions Container -->
                        @foreach ($quiz->questions as $index => $question)
                            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden hover:shadow-3xl hover:transform hover:-translate-y-1 transition-all duration-300" data-question="{{ $index + 1 }}">
                                <!-- Question Header -->
                                <div class="bg-primary-gradient p-6 text-white flex items-center gap-4">
                                    <div class="w-12 h-12 bg-white bg-opacity-20 backdrop-blur-lg rounded-full flex items-center justify-center text-lg font-bold">
                                        {{ $index + 1 }}
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-xl font-semibold">Soal {{ $index + 1 }}</h3>
                                    </div>
                                    <div class="flex items-center gap-2 bg-white bg-opacity-20 backdrop-blur-lg px-4 py-2 rounded-full">
                                        <i class="fas fa-gem"></i>
                                        <span>{{ $question->points }} poin</span>
                                    </div>
                                </div>

                                <!-- Question Body -->
                                <div class="p-8">
                                    <div class="text-lg font-medium text-slate-800 mb-6 leading-relaxed">
                                        {{ $question->question }}
                                    </div>

                                    <!-- Options -->
                                    <div class="space-y-4">
                                        @foreach ($question->options as $optionIndex => $option)
                                            <div class="relative">
                                                <input class="absolute opacity-0 cursor-pointer"
                                                       type="radio"
                                                       name="answers[{{ $question->id }}]"
                                                       id="q{{ $question->id }}_option{{ $optionIndex }}"
                                                       value="{{ $optionIndex }}"
                                                       required>
                                                <label class="flex items-center gap-4 p-5 border-2 border-gray-200 rounded-xl cursor-pointer bg-gray-50 hover:border-blue-400 hover:bg-white hover:shadow-lg transition-all duration-300 relative overflow-hidden group"
                                                       for="q{{ $question->id }}_option{{ $optionIndex }}">
                                                    <div class="absolute inset-0 bg-primary-gradient opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                                                    <div class="w-9 h-9 bg-gray-300 rounded-full flex items-center justify-center font-bold text-gray-600 group-hover:bg-blue-500 group-hover:text-white transition-all duration-300 z-10">
                                                        {{ chr(65 + $optionIndex) }}
                                                    </div>
                                                    <div class="flex-1 text-slate-700 z-10">{{ $option }}</div>
                                                    <div class="w-6 h-6 bg-gray-300 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 z-10">
                                                        <i class="fas fa-check text-white text-xs"></i>
                                                    </div>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </form>

                    <!-- Action Buttons -->
                    <div class="flex flex-col-reverse lg:flex-row justify-between items-center gap-4 py-8">
                        <a href="{{ route('materials.show', $quiz->material) }}" class="w-full lg:w-auto inline-flex items-center justify-center gap-2 px-8 py-3 bg-gray-600 text-white rounded-xl font-semibold shadow-lg hover:bg-gray-700 hover:transform hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
                            <i class="fas fa-arrow-left"></i>
                            <span>Kembali ke Materi</span>
                        </a>

                        <button type="button" id="submit-quiz-btn" class="w-full lg:w-auto inline-flex items-center justify-center gap-2 px-8 py-3 bg-primary-gradient text-white rounded-xl font-semibold shadow-lg hover:transform hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
                            <i class="fas fa-paper-plane"></i>
                            <span>Selesai & Submit</span>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="fixed inset-0 z-50 opacity-0 invisible transition-all duration-300">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black bg-opacity-50 modal-backdrop"></div>

        <!-- Modal Dialog -->
        <div class="relative flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-3xl max-w-md w-full transform scale-95 transition-transform duration-300">
                <!-- Modal Header -->
                <div class="bg-primary-gradient text-white p-6 rounded-t-2xl flex items-center justify-between">
                    <h5 class="text-lg font-semibold flex items-center gap-2">
                        <i class="fas fa-exclamation-triangle text-yellow-300"></i>
                        Konfirmasi Submit
                    </h5>
                    <button type="button" id="close-modal-btn" class="w-8 h-8 flex items-center justify-center text-white hover:bg-white hover:bg-opacity-20 rounded-full transition-colors">
                        <span class="text-xl">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <p class="text-gray-700 mb-4">
                        Apakah Anda yakin ingin mengirim jawaban?
                        <strong>Setelah dikirim, Anda tidak dapat mengubah jawaban lagi.</strong>
                    </p>

                    <div id="unanswered-alert" class="hidden bg-gradient-to-r from-yellow-50 to-orange-50 border-l-4 border-yellow-400 p-4 rounded-xl">
                        <div class="flex items-center text-yellow-800">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <strong>Perhatian:</strong> Masih ada <span id="unanswered-count">0</span> soal yang belum dijawab.
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex gap-3 p-6 border-t border-gray-100">
                    <button type="button" id="cancel-submit-btn" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 bg-gray-600 text-white rounded-xl font-semibold hover:bg-gray-700 transition-colors">
                        <i class="fas fa-times"></i>
                        Batal
                    </button>
                    <button type="button" id="confirm-submit-btn" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 bg-primary-gradient text-white rounded-xl font-semibold hover:opacity-90 transition-opacity">
                        <i class="fas fa-check"></i>
                        Ya, Kirim Jawaban
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Styles -->
    <style>
        /* Custom animations and gradients */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }

        @keyframes pulse-warning {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        @keyframes pulse-danger {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.7; }
        }

        .bg-primary-gradient { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .bg-secondary-gradient { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .bg-success-gradient { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
        .bg-warning-gradient { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }
        .bg-quiz-gradient { background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); }

        .animate-float { animation: float 8s ease-in-out infinite; }
        .animate-pulse-warning { animation: pulse-warning 2s infinite; }
        .animate-pulse-danger { animation: pulse-danger 1s infinite; }

        /* Modal show state */
        .modal.show {
            opacity: 1 !important;
            visibility: visible !important;
        }

        .modal.show .bg-white {
            transform: scale(1) !important;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Timer functionality
            const timeLimit = {{ $quiz->time_limit }};
            let timeRemaining = timeLimit * 60; // convert to seconds
            const timerElement = document.getElementById('timer');
            const quizForm = document.getElementById('quiz-form');
            const updateTimerUrl = "{{ route('quizzes.update-timer', $quiz) }}";

            // Modal elements
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

                timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                // Warning when 5 minutes left
                if (timeRemaining <= 300 && timeRemaining > 60) {
                    timerElement.className = 'text-4xl font-bold font-mono mb-2 text-yellow-400 animate-pulse-warning';
                }

                // Danger when 1 minute left
                if (timeRemaining <= 60) {
                    timerElement.className = 'text-4xl font-bold font-mono mb-2 text-red-400 animate-pulse-danger';
                }

                // Auto submit when time is up
                if (timeRemaining <= 0) {
                    clearInterval(timerInterval);
                    alert('Waktu habis! Quiz akan otomatis disubmit.');
                    submitQuizDirectly();
                    return;
                }

                timeRemaining--;

                // Save time to server every 10 seconds
                if (timeRemaining % 10 === 0) {
                    saveTimeToServer(timeRemaining);
                }
            }, 1000);

            function saveTimeToServer(timeRemaining) {
                fetch(updateTimerUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        time_remaining: timeRemaining
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.time_up) {
                        clearInterval(timerInterval);
                        submitQuizDirectly();
                    }
                })
                .catch(error => console.error('Error saving time:', error));
            }

            // Save time when user leaves page
            window.addEventListener('beforeunload', function(e) {
                const isSubmitting = quizForm.classList.contains('submitting');
                if (!isSubmitting && timeRemaining > 0) {
                    // Synchronous request to ensure time is saved
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', updateTimerUrl, false);
                    xhr.setRequestHeader('Content-Type', 'application/json');
                    xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                    xhr.send(JSON.stringify({
                        time_remaining: timeRemaining
                    }));
                }
            });

            // Function to show modal
            function showConfirmationModal() {
                confirmationModal.classList.remove('opacity-0', 'invisible');
                confirmationModal.classList.add('opacity-100', 'visible');
                const modalDialog = confirmationModal.querySelector('.bg-white');
                modalDialog.classList.remove('scale-95');
                modalDialog.classList.add('scale-100');
                document.body.style.overflow = 'hidden';
            }

            // Function to hide modal
            function hideConfirmationModal() {
                confirmationModal.classList.add('opacity-0', 'invisible');
                confirmationModal.classList.remove('opacity-100', 'visible');
                const modalDialog = confirmationModal.querySelector('.bg-white');
                modalDialog.classList.add('scale-95');
                modalDialog.classList.remove('scale-100');
                document.body.style.overflow = 'auto';
            }

            // Function to submit quiz directly
            function submitQuizDirectly() {
                clearInterval(timerInterval);
                quizForm.classList.add('submitting');
                quizForm.submit();
            }

            // Check unanswered questions
            function checkUnansweredQuestions() {
                const totalQuestions = {{ $quiz->questions->count() }};
                const answeredQuestions = document.querySelectorAll('input[type="radio"]:checked').length;
                const unansweredCount = totalQuestions - answeredQuestions;

                if (unansweredCount > 0) {
                    unansweredAlert.classList.remove('hidden');
                    unansweredCountSpan.textContent = unansweredCount;
                } else {
                    unansweredAlert.classList.add('hidden');
                }

                return unansweredCount;
            }

            // Event listeners
            submitQuizBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                checkUnansweredQuestions();
                showConfirmationModal();
            });

            confirmSubmitBtn.addEventListener('click', function(e) {
                e.preventDefault();
                hideConfirmationModal();
                submitQuizDirectly();
            });

            cancelSubmitBtn.addEventListener('click', function(e) {
                e.preventDefault();
                hideConfirmationModal();
            });

            closeModalBtn.addEventListener('click', function(e) {
                e.preventDefault();
                hideConfirmationModal();
            });

            // Close modal when clicking backdrop
            modalBackdrop?.addEventListener('click', function(e) {
                if (e.target === modalBackdrop) {
                    hideConfirmationModal();
                }
            });

            // Close modal with ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !confirmationModal.classList.contains('invisible')) {
                    hideConfirmationModal();
                }
            });

            // Radio button change handlers with animations
            const radioButtons = document.querySelectorAll('input[type="radio"]');
            radioButtons.forEach(radio => {
                radio.addEventListener('change', function() {
                    // Remove previous selection styling from all options of the same question
                    const questionName = this.name;
                    const allOptionsForQuestion = document.querySelectorAll(`input[name="${questionName}"]`);

                    allOptionsForQuestion.forEach(option => {
                        const label = option.nextElementSibling;
                        if (label) {
                            // Reset all labels
                            label.classList.remove('border-blue-500', 'bg-white', 'shadow-lg');
                            label.classList.add('border-gray-200', 'bg-gray-50');

                            // Reset marker and check
                            const marker = label.querySelector('.w-9.h-9');
                            const check = label.querySelector('.w-6.h-6');

                            if (marker) {
                                marker.classList.remove('bg-blue-500', 'text-white', 'transform', 'scale-105');
                                marker.classList.add('bg-gray-300', 'text-gray-600');
                            }

                            if (check) {
                                check.classList.remove('bg-green-500', 'opacity-100', 'transform', 'scale-110');
                                check.classList.add('bg-gray-300', 'opacity-0');
                            }
                        }
                    });

                    // Style the selected option
                    const selectedLabel = this.nextElementSibling;
                    if (selectedLabel) {
                        selectedLabel.classList.remove('border-gray-200', 'bg-gray-50');
                        selectedLabel.classList.add('border-blue-500', 'bg-white', 'shadow-lg');

                        // Style marker
                        const marker = selectedLabel.querySelector('.w-9.h-9');
                        if (marker) {
                            marker.classList.remove('bg-gray-300', 'text-gray-600');
                            marker.classList.add('bg-blue-500', 'text-white', 'transform', 'scale-105');
                        }

                        // Style check
                        const check = selectedLabel.querySelector('.w-6.h-6');
                        if (check) {
                            check.classList.remove('bg-gray-300', 'opacity-0');
                            check.classList.add('bg-green-500', 'opacity-100', 'transform', 'scale-110');
                        }

                        // Smooth animation effect
                        selectedLabel.style.transform = 'scale(0.98)';
                        setTimeout(() => {
                            selectedLabel.style.transform = 'scale(1)';
                        }, 150);
                    }

                    updateProgress();
                });
            });

            // Progress tracking function
            function updateProgress() {
                const totalQuestions = {{ $quiz->questions->count() }};
                const answeredQuestions = document.querySelectorAll('input[type="radio"]:checked').length;

                // Update submit button text and style based on progress
                const submitText = submitQuizBtn.querySelector('span');
                if (answeredQuestions === totalQuestions) {
                    submitText.textContent = 'Selesai & Submit';
                    submitQuizBtn.classList.add('bg-green-600');
                    submitQuizBtn.classList.remove('bg-primary-gradient');
                } else {
                    submitText.textContent = `Submit (${answeredQuestions}/${totalQuestions})`;
                    submitQuizBtn.classList.remove('bg-green-600');
                    submitQuizBtn.classList.add('bg-primary-gradient');
                }
            }

            // Prevent page refresh/back with confirmation
            window.addEventListener('beforeunload', function(e) {
                const isSubmitting = quizForm.classList.contains('submitting');
                if (!isSubmitting) {
                    e.preventDefault();
                    e.returnValue = 'Apakah Anda yakin ingin meninggalkan halaman? Progress quiz akan hilang.';
                }
            });

            // Initialize progress
            updateProgress();

            console.log('Quiz JavaScript initialized with Tailwind CSS and Laravel Blade');
        });
    </script>
@endsection
