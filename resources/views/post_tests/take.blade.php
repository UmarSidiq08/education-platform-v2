@extends('layouts.app')

@section('title', 'Post Test: ' . $postTest->title)

@section('content')
    <!-- Background Decorations -->
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute top-[15%] left-[5%] w-32 h-32 lg:w-40 lg:h-40 bg-white bg-opacity-5 rounded-full animate-float"></div>
        <div class="absolute top-[60%] right-[8%] w-20 h-20 lg:w-25 lg:h-25 bg-white bg-opacity-5 rounded-full animate-float" style="animation-delay: 3s;"></div>
        <div class="absolute bottom-[25%] left-[15%] w-16 h-16 lg:w-20 lg:h-20 bg-white bg-opacity-5 rounded-full animate-float" style="animation-delay: 6s;"></div>
    </div>

    <!-- Main Container -->
    <div class="relative z-10 min-h-screen py-8 px-5 bg-posttest-gradient">
        <div class="max-w-6xl mx-auto">
            <div class="flex justify-center">
                <div class="w-full max-w-none md:max-w-5xl lg:max-w-5xl xl:max-w-6xl">

                    <!-- Post Test Header Card -->
                    <div class="bg-posttest-primary-gradient rounded-2xl p-8 mb-8 shadow-2xl text-white">
                        <div class="flex flex-col lg:flex-row justify-between items-center gap-8">
                            <!-- Post Test Info -->
                            <div class="text-center lg:text-left">
                                <div class="flex items-center justify-center lg:justify-start gap-3 mb-3">
                                    <i class="fas fa-graduation-cap text-2xl"></i>
                                    <span class="bg-white bg-opacity-20 backdrop-blur-lg px-3 py-1 rounded-full text-sm font-medium">POST TEST</span>
                                </div>
                                <h1 class="text-3xl lg:text-4xl font-bold mb-2 leading-tight">{{ $postTest->title }}</h1>
                                <div class="flex items-center justify-center lg:justify-start gap-2 text-lg opacity-90">
                                    <i class="fas fa-certificate"></i>
                                    <span>Tes Akhir Pembelajaran</span>
                                </div>
                            </div>

                            <!-- Timer Section -->
                            <div class="text-center">
                                <div class="bg-white bg-opacity-20 backdrop-blur-lg rounded-xl p-6 min-w-[150px]">
                                    <div id="timer" class="text-4xl font-bold font-mono mb-2">
                                        {{ isset($attempt) && $attempt ? gmdate('i:s', $attempt->time_remaining) : $postTest->time_limit . ':00' }}
                                    </div>
                                    <div class="text-sm opacity-80">Waktu Tersisa</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (!isset($attempt) || !$attempt)
                        <!-- Pre-Test Information -->
                        <div class="bg-white rounded-2xl p-8 mb-8 shadow-2xl">
                            <!-- Description -->
                            @if ($postTest->description)
                                <div class="flex items-center gap-3 p-4 bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl mb-6 text-slate-700">
                                    <i class="fas fa-info-circle text-amber-600"></i>
                                    <span>{{ $postTest->description }}</span>
                                </div>
                            @endif

                            <!-- Stats Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                                <!-- Questions Stat -->
                                <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-slate-50 to-gray-50 rounded-xl border-l-4 border-gray-600 hover:transform hover:-translate-y-1 transition-all duration-300 hover:shadow-lg">
                                    <div class="w-10 h-10 bg-posttest-primary-gradient rounded-xl flex items-center justify-center text-white">
                                        <i class="fas fa-list-ol"></i>
                                    </div>
                                    <div>
                                        <div class="text-2xl font-bold text-slate-800">{{ $postTest->questions->count() }}</div>
                                        <div class="text-sm text-gray-500">Soal</div>
                                    </div>
                                </div>

                                <!-- Time Stat -->
                                <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-slate-50 to-red-50 rounded-xl border-l-4 border-red-600 hover:transform hover:-translate-y-1 transition-all duration-300 hover:shadow-lg">
                                    <div class="w-10 h-10 bg-posttest-secondary-gradient rounded-xl flex items-center justify-center text-white">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div>
                                        <div class="text-2xl font-bold text-slate-800">{{ $postTest->time_limit }}</div>
                                        <div class="text-sm text-gray-500">Menit</div>
                                    </div>
                                </div>

                                <!-- Passing Score Stat -->
                                <div class="flex items-center gap-4 p-4 bg-gradient-to-r from-slate-50 to-emerald-50 rounded-xl border-l-4 border-emerald-600 hover:transform hover:-translate-y-1 transition-all duration-300 hover:shadow-lg">
                                    <div class="w-10 h-10 bg-posttest-success-gradient rounded-xl flex items-center justify-center text-white">
                                        <i class="fas fa-trophy"></i>
                                    </div>
                                    <div>
                                        <div class="text-2xl font-bold text-slate-800">{{ $postTest->passing_score }}%</div>
                                        <div class="text-sm text-gray-500">Nilai Kelulusan</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Important Notice -->
                            <div class="bg-gradient-to-r from-red-50 to-orange-50 border-l-4 border-red-500 p-6 rounded-xl mb-8">
                                <div class="flex items-start gap-3">
                                    <i class="fas fa-exclamation-triangle text-red-600 text-xl mt-1"></i>
                                    <div>
                                        <h4 class="font-bold text-red-800 mb-2">Penting!</h4>
                                        <ul class="text-red-700 space-y-1 text-sm">
                                            <li>• Pastikan koneksi internet stabil sebelum memulai</li>
                                            <li>• Anda hanya memiliki dua kesempatan untuk mengerjakan post test ini</li>
                                            <li>• Nilai minimum kelulusan adalah {{ $postTest->passing_score }}%</li>
                                            <li>• Waktu tidak dapat dihentikan setelah dimulai</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Start Button -->
                            <div class="text-center">
                                <form action="{{ route('post_tests.start', $postTest) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center justify-center gap-3 px-12 py-4 bg-posttest-primary-gradient text-white rounded-xl font-bold text-lg shadow-xl hover:transform hover:-translate-y-1 hover:shadow-2xl transition-all duration-300">
                                        <i class="fas fa-play text-xl"></i>
                                        <span>Mulai Post Test</span>
                                    </button>
                                </form>
                            </div>
                        </div>

                    @else
                        <!-- Resume Notice -->
                        @if (isset($attempt) && $attempt)
                            <div class="bg-white rounded-2xl p-6 mb-8 shadow-xl">
                                <div class="flex items-center gap-3 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl text-blue-800">
                                    <i class="fas fa-info-circle text-blue-600"></i>
                                    <div>
                                        <strong>Melanjutkan Post Test</strong> - Anda memiliki sesi yang sedang berjalan.
                                        <br><small class="text-blue-600">Waktu tersisa: <span id="resume-time" class="font-mono font-bold">{{ gmdate('i:s', $attempt->time_remaining) }}</span></small>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Post Test Form -->
                        <form id="posttest-form" action="{{ route('post_tests.submit', $postTest) }}" method="POST" class="space-y-8 mb-8">
                            @csrf
                            <input type="hidden" name="started_at" value="{{ $attempt->started_at }}">

                            <!-- Questions Container -->
                            @foreach ($postTest->questions as $index => $question)
                                <div class="bg-white rounded-2xl shadow-2xl overflow-hidden hover:shadow-3xl hover:transform hover:-translate-y-1 transition-all duration-300" data-question="{{ $index + 1 }}">
                                    <!-- Question Header -->
                                    <div class="bg-posttest-primary-gradient p-6 text-white flex items-center gap-4">
                                        <div class="w-12 h-12 bg-white bg-opacity-20 backdrop-blur-lg rounded-full flex items-center justify-center text-lg font-bold">
                                            {{ $index + 1 }}
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="text-xl font-semibold">Pertanyaan #{{ $index + 1 }}</h3>
                                        </div>
                                        <div class="flex items-center gap-2 bg-white bg-opacity-20 backdrop-blur-lg px-4 py-2 rounded-full">
                                            <i class="fas fa-gem"></i>
                                            <span>{{ $question->points }} poin</span>
                                        </div>
                                    </div>

                                    <!-- Question Body -->
                                    <div class="p-8">
                                        <div class="text-lg font-medium text-slate-800 mb-6 leading-relaxed">
                                            {!! nl2br(e($question->question)) !!}
                                        </div>

                                        <!-- Dynamic Options -->
                                        <div class="space-y-4">
                                            @foreach ($question->options as $optionIndex => $option)
                                                <div class="relative">
                                                    <input class="absolute opacity-0 cursor-pointer option-radio"
                                                           type="radio"
                                                           name="answers[{{ $question->id }}]"
                                                           id="q{{ $question->id }}_option{{ $optionIndex }}"
                                                           value="{{ $optionIndex }}"
                                                           data-question-id="{{ $question->id }}"
                                                           {{ isset($attempt->answers[$question->id]) && $attempt->answers[$question->id] == $optionIndex ? 'checked' : '' }}>
                                                    <label class="option-label flex items-center gap-4 p-5 border-2 border-gray-200 rounded-xl cursor-pointer bg-gray-50 hover:border-gray-600 hover:bg-white hover:shadow-lg transition-all duration-300 relative overflow-hidden group {{ isset($attempt->answers[$question->id]) && $attempt->answers[$question->id] == $optionIndex ? 'border-gray-600 bg-white shadow-lg selected-option' : '' }}"
                                                           for="q{{ $question->id }}_option{{ $optionIndex }}">
                                                        <div class="absolute inset-0 bg-posttest-primary-gradient opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                                                        <div class="option-marker w-9 h-9 bg-gray-300 rounded-full flex items-center justify-center font-bold text-gray-600 group-hover:bg-gray-600 group-hover:text-white transition-all duration-300 z-10 {{ isset($attempt->answers[$question->id]) && $attempt->answers[$question->id] == $optionIndex ? 'bg-gray-600 text-white transform scale-105' : '' }}">
                                                            {{ chr(65 + $optionIndex) }}
                                                        </div>
                                                        <div class="flex-1 text-slate-700 z-10">{{ $option }}</div>
                                                        <div class="option-check w-6 h-6 bg-gray-300 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 z-10 {{ isset($attempt->answers[$question->id]) && $attempt->answers[$question->id] == $optionIndex ? 'bg-green-600 opacity-100 transform scale-110' : '' }}">
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

                        <!-- Progress Bar (Fixed Bottom) -->
                        <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 shadow-2xl z-40">
                            <div class="max-w-6xl mx-auto">
                                <div class="flex flex-col lg:flex-row items-center justify-between gap-4">
                                    <div class="flex-1 w-full lg:w-auto">
                                        <div class="flex items-center gap-4 mb-2">
                                            <div class="text-sm font-medium text-gray-600">Progress:</div>
                                            <div id="progress-text" class="text-sm font-bold text-gray-800">0/{{ $postTest->questions->count() }} terjawab</div>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-3">
                                            <div id="progress-bar" class="bg-posttest-primary-gradient h-3 rounded-full transition-all duration-300" style="width: 0%"></div>
                                        </div>
                                    </div>
                                    <button type="button" id="submit-posttest-btn" class="w-full lg:w-auto inline-flex items-center justify-center gap-3 px-8 py-3 bg-posttest-primary-gradient text-white rounded-xl font-bold shadow-xl hover:transform hover:-translate-y-1 hover:shadow-2xl transition-all duration-300">
                                        <i class="fas fa-paper-plane"></i>
                                        <span>Submit Jawaban</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Add bottom padding to prevent content being hidden by fixed bar -->
                        <div class="h-32"></div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    @if (isset($attempt) && $attempt)
    <div id="confirmationModal" class="fixed inset-0 z-50 opacity-0 invisible transition-all duration-300">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black bg-opacity-50 modal-backdrop"></div>

        <!-- Modal Dialog -->
        <div class="relative flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-3xl max-w-md w-full transform scale-95 transition-transform duration-300">
                <!-- Modal Header -->
                <div class="bg-posttest-primary-gradient text-white p-6 rounded-t-2xl flex items-center justify-between">
                    <h5 class="text-lg font-semibold flex items-center gap-2">
                        <i class="fas fa-exclamation-triangle text-yellow-300"></i>
                        Konfirmasi Submit Post Test
                    </h5>
                    <button type="button" id="close-modal-btn" class="w-8 h-8 flex items-center justify-center text-white hover:bg-white hover:bg-opacity-20 rounded-full transition-colors">
                        <span class="text-xl">&times;</span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <p class="text-gray-700 mb-4">
                        Apakah Anda yakin ingin mengirim jawaban Post Test?
                        <strong class="text-red-600">Setelah dikirim, Anda tidak dapat mengubah jawaban lagi dan ini akan mempengaruhi nilai akhir Anda.</strong>
                    </p>

                    <div id="unanswered-alert" class="hidden bg-gradient-to-r from-red-50 to-orange-50 border-l-4 border-red-500 p-4 rounded-xl">
                        <div class="flex items-center text-red-800">
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
                    <button type="button" id="confirm-submit-btn" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 bg-posttest-primary-gradient text-white rounded-xl font-semibold hover:opacity-90 transition-opacity">
                        <i class="fas fa-check"></i>
                        Ya, Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Custom Styles -->
    <style>
        /* Post Test specific animations and gradients */
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

        /* Post Test Color Scheme - More serious and formal */
        .bg-posttest-primary-gradient { background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%); }
        .bg-posttest-secondary-gradient { background: linear-gradient(135deg, #e53e3e 0%, #c53030 100%); }
        .bg-posttest-success-gradient { background: linear-gradient(135deg, #38a169 0%, #2f855a 100%); }
        .bg-posttest-gradient { background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%); }

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

        /* Fixed bottom bar shadow */
        .fixed.bottom-0 {
            box-shadow: 0 -10px 25px -5px rgba(0, 0, 0, 0.1), 0 -10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Selected option styling */
        .selected-option {
            border-color: #4a5568 !important;
            background-color: white !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1) !important;
        }

        .selected-option .option-marker {
            background-color: #4a5568 !important;
            color: white !important;
            transform: scale(1.05) !important;
        }

        .selected-option .option-check {
            background-color: #38a169 !important;
            opacity: 1 !important;
            transform: scale(1.1) !important;
        }
    </style>

    @if (isset($attempt) && $attempt)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Timer functionality
            let timeRemaining = {{ $attempt->time_remaining }};
            const timerElement = document.getElementById('timer');
            const posttestForm = document.getElementById('posttest-form');
            const totalQuestions = {{ $postTest->questions->count() }};

            // Progress elements
            const progressBar = document.getElementById('progress-bar');
            const progressText = document.getElementById('progress-text');

            // Modal elements
            const confirmationModal = document.getElementById('confirmationModal');
            const submitPosttestBtn = document.getElementById('submit-posttest-btn');
            const confirmSubmitBtn = document.getElementById('confirm-submit-btn');
            const cancelSubmitBtn = document.getElementById('cancel-submit-btn');
            const closeModalBtn = document.getElementById('close-modal-btn');
            const modalBackdrop = confirmationModal?.querySelector('.modal-backdrop');

            // Unanswered questions alert elements
            const unansweredAlert = document.getElementById('unanswered-alert');
            const unansweredCountSpan = document.getElementById('unanswered-count');

            // Timer countdown
            const timerInterval = setInterval(function() {
                if (timeRemaining <= 0) {
                    clearInterval(timerInterval);
                    alert('Waktu telah habis! Post Test akan otomatis disubmit.');
                    submitPostTestDirectly();
                    return;
                }

                timeRemaining--;
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

                // Update waktu tersisa di server setiap 30 detik
                if (timeRemaining % 30 === 0) {
                    saveTimeRemaining();
                }
            }, 1000);

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

            // Function to submit post test directly
            function submitPostTestDirectly() {
                clearInterval(timerInterval);
                posttestForm.classList.add('submitting');
                posttestForm.submit();
            }

            // Check unanswered questions
            function checkUnansweredQuestions() {
                const answeredQuestions = document.querySelectorAll('input[type="radio"]:checked').length;
                const unansweredCount = totalQuestions - answeredQuestions;

                if (unansweredCount > 0) {
                    unansweredAlert?.classList.remove('hidden');
                    if (unansweredCountSpan) unansweredCountSpan.textContent = unansweredCount;
                } else {
                    unansweredAlert?.classList.add('hidden');
                }

                return unansweredCount;
            }

            // Update progress function
            function updateProgress() {
                const answered = document.querySelectorAll('input[type="radio"]:checked').length;
                const progress = (answered / totalQuestions) * 100;

                if (progressBar) {
                    progressBar.style.width = `${progress}%`;
                    progressBar.setAttribute('aria-valuenow', progress);
                }

                if (progressText) {
                    progressText.textContent = `${answered}/${totalQuestions} terjawab`;
                }

                // Update submit button text and style based on progress
                if (submitPosttestBtn) {
                    const submitText = submitPosttestBtn.querySelector('span');
                    if (answered === totalQuestions) {
                        submitText.textContent = 'Submit Jawaban';
                        submitPosttestBtn.classList.add('bg-green-600');
                        submitPosttestBtn.classList.remove('bg-posttest-primary-gradient');
                    } else {
                        submitText.textContent = `Submit (${answered}/${totalQuestions})`;
                        submitPosttestBtn.classList.remove('bg-green-600');
                        submitPosttestBtn.classList.add('bg-posttest-primary-gradient');
                    }
                }
            }

            // Enhanced radio button change handlers for dynamic options
            function handleOptionSelection(radio) {
                const questionId = radio.getAttribute('data-question-id');
                const selectedValue = radio.value;

                // Remove selection styling from all options in this question
                const allOptionsInQuestion = document.querySelectorAll(`input[data-question-id="${questionId}"]`);

                allOptionsInQuestion.forEach(option => {
                    const label = option.nextElementSibling;
                    const marker = label.querySelector('.option-marker');
                    const check = label.querySelector('.option-check');

                    // Reset styling
                    label.classList.remove('border-gray-600', 'bg-white', 'shadow-lg', 'selected-option');
                    label.classList.add('border-gray-200', 'bg-gray-50');

                    if (marker) {
                        marker.classList.remove('bg-gray-600', 'text-white', 'transform', 'scale-105');
                        marker.classList.add('bg-gray-300', 'text-gray-600');
                    }

                    if (check) {
                        check.classList.remove('bg-green-600', 'opacity-100', 'transform', 'scale-110');
                        check.classList.add('bg-gray-300', 'opacity-0');
                    }
                });

                // Apply selection styling to the chosen option
                const selectedLabel = radio.nextElementSibling;
                const selectedMarker = selectedLabel.querySelector('.option-marker');
                const selectedCheck = selectedLabel.querySelector('.option-check');

                selectedLabel.classList.remove('border-gray-200', 'bg-gray-50');
                selectedLabel.classList.add('border-gray-600', 'bg-white', 'shadow-lg', 'selected-option');

                if (selectedMarker) {
                    selectedMarker.classList.remove('bg-gray-300', 'text-gray-600');
                    selectedMarker.classList.add('bg-gray-600', 'text-white', 'transform', 'scale-105');
                }

                if (selectedCheck) {
                    selectedCheck.classList.remove('bg-gray-300', 'opacity-0');
                    selectedCheck.classList.add('bg-green-600', 'opacity-100', 'transform', 'scale-110');
                }

                // Smooth animation effect
                selectedLabel.style.transform = 'scale(0.98)';
                setTimeout(() => {
                    selectedLabel.style.transform = 'scale(1)';
                }, 150);

                updateProgress();
            }

            // Event listeners
            if (submitPosttestBtn) {
                submitPosttestBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    checkUnansweredQuestions();
                    showConfirmationModal();
                });
            }

            if (confirmSubmitBtn) {
                confirmSubmitBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    hideConfirmationModal();
                    submitPostTestDirectly();
                });
            }

            if (cancelSubmitBtn) {
                cancelSubmitBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    hideConfirmationModal();
                });
            }

            if (closeModalBtn) {
                closeModalBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    hideConfirmationModal();
                });
            }

            // Close modal when clicking backdrop
            if (modalBackdrop) {
                modalBackdrop.addEventListener('click', function(e) {
                    if (e.target === modalBackdrop) {
                        hideConfirmationModal();
                    }
                });
            }

            // Close modal with ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && confirmationModal && !confirmationModal.classList.contains('invisible')) {
                    hideConfirmationModal();
                }
            });

            // Dynamic radio button event listeners
            const radioButtons = document.querySelectorAll('.option-radio');
            radioButtons.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.checked) {
                        handleOptionSelection(this);
                    }
                });
            });

            // Initialize progress and styling
            updateProgress();

            // Initialize existing selections (for resume functionality)
            document.querySelectorAll('input[type="radio"]:checked').forEach(radio => {
                handleOptionSelection(radio);
            });

            // Start auto save interval
            setInterval(autoSaveProgress, 30000);

            // Warning sebelum close/tab close
            window.addEventListener('beforeunload', function(e) {
                const isSubmitting = posttestForm.classList.contains('submitting');
                if (!isSubmitting && timeRemaining > 0) {
                    // Save time remaining before leaving
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', `/post-tests/{{ $postTest->id }}/update-timer`, false);
                    xhr.setRequestHeader('Content-Type', 'application/json');
                    xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                    xhr.send(JSON.stringify({
                        time_remaining: timeRemaining
                    }));

                    e.preventDefault();
                    e.returnValue = 'Apakah Anda yakin ingin meninggalkan halaman? Progress Post Test akan hilang.';
                }
            });

            console.log('Dynamic Post Test JavaScript initialized successfully');
        });
    </script>
    @endif
@endsection
