@extends("layouts.app")
@section("content")
    <style>
        /* Custom styles for full-width options on desktop */
        .option-container {
            width: 100%;
        }

        .option-input {
            width: 100% !important;
            min-width: 300px !important;
        }

        @media (min-width: 1024px) {
            .option-input {
                min-width: 400px !important;
            }

            /* Full width for options on desktop */
            .option-item .flex-col {
                width: 100%;
            }

            .option-item .flex-col > div:first-child {
                width: 100%;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .option-input {
                flex-grow: 1;
                margin-right: 1rem;
            }
        }

        @media (min-width: 1280px) {
            .option-input {
                min-width: 500px !important;
            }
        }

        /* Animation for alerts */
        @keyframes slideIn {
            from { transform: translateX(100%); }
            to { transform: translateX(0); }
        }

        @keyframes slideOut {
            from { transform: translateX(0); }
            to { transform: translateX(100%); }
        }

        .alert-slide-in {
            animation: slideIn 0.3s forwards;
        }

        .alert-slide-out {
            animation: slideOut 0.3s forwards;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #c5c5c5;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50">
    <div class="container mx-auto px-2 sm:px-4 py-4 sm:py-8 max-w-6xl">
        <!-- Header Section -->
        <div class="mb-6 sm:mb-8">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between space-y-4 sm:space-y-0">
                        <div class="flex-1">
                            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-white mb-2">
                                <i class="fas fa-graduation-cap mr-2 sm:mr-3"></i>Buat Post Test Baru
                            </h1>
                            <p class="text-blue-100 text-sm sm:text-base">
                                Buat soal evaluasi akhir untuk mengukur pemahaman siswa terhadap seluruh materi
                            </p>
                        </div>
                        <div class="hidden sm:block">
                            <div class="bg-white bg-opacity-20 rounded-lg p-3 sm:p-4">
                                <i class="fas fa-clipboard-list text-2xl sm:text-4xl text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Form -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200">
            <div class="p-4 sm:p-6 lg:p-8">
                <form action="{{ route('post_tests.store', $class) }}" method="POST" id="postTestForm">
                    <!-- Basic Information -->
                    <div class="mb-6 sm:mb-8">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-4 sm:mb-6 pb-3 border-b border-gray-200">
                            <i class="fas fa-info-circle text-blue-500 mr-2"></i>Informasi Dasar
                        </h3>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
                            <!-- Title -->
                            <div class="lg:col-span-2">
                                <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Judul Post Test <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                       id="title"
                                       name="title"
                                       value=""
                                       placeholder="Masukkan judul post test yang menarik..."
                                       required>
                            </div>

                            <!-- Description -->
                            <div class="lg:col-span-2">
                                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Deskripsi
                                </label>
                                <textarea class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                          id="description"
                                          name="description"
                                          rows="3"
                                          placeholder="Berikan deskripsi singkat tentang post test ini..."></textarea>
                            </div>

                            <!-- Time Limit -->
                            <div>
                                <label for="time_limit" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Waktu Pengerjaan (menit) <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number"
                                           class="w-full px-3 sm:px-4 py-2 sm:py-3 pr-10 sm:pr-12 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                           id="time_limit"
                                           name="time_limit"
                                           value="30"
                                           min="1"
                                           required>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <i class="fas fa-clock text-gray-400"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Passing Score -->
                            <div>
                                <label for="passing_score" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nilai Kelulusan (%) <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number"
                                           class="w-full px-3 sm:px-4 py-2 sm:py-3 pr-10 sm:pr-12 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                           id="passing_score"
                                           name="passing_score"
                                           value="80"
                                           min="1"
                                           max="100"
                                           required>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <i class="fas fa-percentage text-gray-400"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Questions Section -->
                    <div class="mb-6 sm:mb-8">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 sm:mb-6 pb-3 border-b border-gray-200 space-y-3 sm:space-y-0">
                            <h3 class="text-lg sm:text-xl font-bold text-gray-800">
                                <i class="fas fa-question-circle text-purple-500 mr-2"></i>Pertanyaan Post Test
                            </h3>
                            <button type="button"
                                    class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-4 sm:px-6 py-2 rounded-lg font-semibold hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 hover:-translate-y-0.5 shadow-lg text-sm sm:text-base w-full sm:w-auto"
                                    id="add-question">
                                <i class="fas fa-plus mr-2"></i>Tambah Pertanyaan
                            </button>
                        </div>

                        <div id="questions-container" class="space-y-4 sm:space-y-6">
                            <!-- Questions will be added here by JavaScript -->
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-between pt-4 sm:pt-6 border-t border-gray-200">
                        <a href="{{ route('classes.show', $class->id) }}"
                           class="flex items-center justify-center px-4 sm:px-6 py-2 sm:py-3 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition-all duration-300 text-sm sm:text-base order-2 sm:order-1">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                        <button type="submit"
                                class="flex items-center justify-center bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 sm:px-8 py-2 sm:py-3 rounded-lg font-bold hover:from-green-600 hover:to-emerald-700 transition-all duration-300 hover:-translate-y-0.5 shadow-lg text-sm sm:text-base order-1 sm:order-2">
                            <i class="fas fa-save mr-2"></i>Simpan Post Test
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Question Template -->
    <template id="question-template">
        <div class="question-card bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h4 class="text-base sm:text-lg font-bold text-gray-800">
                        <i class="fas fa-edit text-blue-500 mr-2"></i>
                        Pertanyaan #<span class="question-number">1</span>
                    </h4>
                    <button type="button"
                            class="remove-question bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition-all duration-300 hover:-translate-y-0.5 shadow-md">
                        <i class="fas fa-trash text-xs sm:text-sm"></i>
                    </button>
                </div>
            </div>

            <div class="p-4 sm:p-6">
                <!-- Question Text -->
                <div class="mb-4 sm:mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Pertanyaan <span class="text-red-500">*</span>
                    </label>
                    <textarea class="question-text w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                              name="questions[0][question]"
                              rows="3"
                              placeholder="Tulis pertanyaan Anda di sini..."
                              required></textarea>
                </div>

                <!-- Points -->
                <div class="mb-4 sm:mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Poin <span class="text-red-500">*</span>
                    </label>
                    <div class="relative w-24 sm:w-32">
                        <input type="number"
                               class="question-points w-full px-3 sm:px-4 py-2 sm:py-3 pr-8 sm:pr-12 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                               name="questions[0][points]"
                               value="1"
                               min="1"
                               required>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:pr-3">
                            <i class="fas fa-star text-yellow-400 text-xs sm:text-sm"></i>
                        </div>
                    </div>
                </div>

                <!-- Fixed 4 Options -->
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        Pilihan Jawaban <span class="text-red-500">*</span>
                        <span class="block sm:inline text-xs text-gray-500 font-normal sm:ml-2 mt-1 sm:mt-0">(Klik radio button untuk menandai jawaban yang benar)</span>
                    </label>

                    <div class="options-container space-y-3">
                        <!-- Option A -->
                        <div class="option-item">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-3 border border-gray-200 rounded-lg hover:border-blue-300 transition-colors duration-300 option-container">
                                <div class="flex items-center w-full sm:w-auto sm:flex-1">
                                    <div class="flex-shrink-0 mr-3">
                                        <span class="inline-flex items-center justify-center w-6 sm:w-8 h-6 sm:h-8 bg-blue-100 text-blue-800 rounded-full font-semibold text-xs sm:text-sm">A</span>
                                    </div>
                                    <input type="text"
                                           class="option-input px-2 sm:px-3 py-1 sm:py-2 text-sm sm:text-base border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                           name="questions[0][options][0]"
                                           placeholder="Masukkan pilihan jawaban A..."
                                           required>
                                </div>
                                <div class="flex-shrink-0 mt-2 sm:mt-0 sm:ml-4 pl-9 sm:pl-0">
                                    <label class="inline-flex items-center">
                                        <input type="radio"
                                               name="questions[0][correct_answer]"
                                               value="0"
                                               class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500"
                                               required>
                                        <span class="ml-2 text-xs sm:text-sm font-medium text-gray-700">Benar</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Option B -->
                        <div class="option-item">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-3 border border-gray-200 rounded-lg hover:border-blue-300 transition-colors duration-300 option-container">
                                <div class="flex items-center w-full sm:w-auto sm:flex-1">
                                    <div class="flex-shrink-0 mr-3">
                                        <span class="inline-flex items-center justify-center w-6 sm:w-8 h-6 sm:h-8 bg-blue-100 text-blue-800 rounded-full font-semibold text-xs sm:text-sm">B</span>
                                    </div>
                                    <input type="text"
                                           class="option-input px-2 sm:px-3 py-1 sm:py-2 text-sm sm:text-base border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                           name="questions[0][options][1]"
                                           placeholder="Masukkan pilihan jawaban B..."
                                           required>
                                </div>
                                <div class="flex-shrink-0 mt-2 sm:mt-0 sm:ml-4 pl-9 sm:pl-0">
                                    <label class="inline-flex items-center">
                                        <input type="radio"
                                               name="questions[0][correct_answer]"
                                               value="1"
                                               class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500">
                                        <span class="ml-2 text-xs sm:text-sm font-medium text-gray-700">Benar</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Option C -->
                        <div class="option-item">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-3 border border-gray-200 rounded-lg hover:border-blue-300 transition-colors duration-300 option-container">
                                <div class="flex items-center w-full sm:w-auto sm:flex-1">
                                    <div class="flex-shrink-0 mr-3">
                                        <span class="inline-flex items-center justify-center w-6 sm:w-8 h-6 sm:h-8 bg-blue-100 text-blue-800 rounded-full font-semibold text-xs sm:text-sm">C</span>
                                    </div>
                                    <input type="text"
                                           class="option-input px-2 sm:px-3 py-1 sm:py-2 text-sm sm:text-base border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                           name="questions[0][options][2]"
                                           placeholder="Masukkan pilihan jawaban C..."
                                           required>
                                </div>
                                <div class="flex-shrink-0 mt-2 sm:mt-0 sm:ml-4 pl-9 sm:pl-0">
                                    <label class="inline-flex items-center">
                                        <input type="radio"
                                               name="questions[0][correct_answer]"
                                               value="2"
                                               class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500">
                                        <span class="ml-2 text-xs sm:text-sm font-medium text-gray-700">Benar</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Option D -->
                        <div class="option-item">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-3 border border-gray-200 rounded-lg hover:border-blue-300 transition-colors duration-300 option-container">
                                <div class="flex items-center w-full sm:w-auto sm:flex-1">
                                    <div class="flex-shrink-0 mr-3">
                                        <span class="inline-flex items-center justify-center w-6 sm:w-8 h-6 sm:h-8 bg-blue-100 text-blue-800 rounded-full font-semibold text-xs sm:text-sm">D</span>
                                    </div>
                                    <input type="text"
                                           class="option-input px-2 sm:px-3 py-1 sm:py-2 text-sm sm:text-base border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                           name="questions[0][options][3]"
                                           placeholder="Masukkan pilihan jawaban D..."
                                           required>
                                </div>
                                <div class="flex-shrink-0 mt-2 sm:mt-0 sm:ml-4 pl-9 sm:pl-0">
                                    <label class="inline-flex items-center">
                                        <input type="radio"
                                               name="questions[0][correct_answer]"
                                               value="3"
                                               class="w-4 h-4 text-green-600 border-gray-300 focus:ring-green-500">
                                        <span class="ml-2 text-xs sm:text-sm font-medium text-gray-700">Benar</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        let questionCount = 0;
        const questionsContainer = document.getElementById('questions-container');
        const questionTemplate = document.getElementById('question-template');
        const addQuestionBtn = document.getElementById('add-question');

        // Add first question automatically
        addQuestion();

        addQuestionBtn.addEventListener('click', addQuestion);

        function addQuestion() {
            const questionClone = questionTemplate.content.cloneNode(true);
            const questionElement = questionClone.querySelector('.question-card');

            // Update question number
            const questionNumber = questionElement.querySelector('.question-number');
            questionNumber.textContent = questionCount + 1;

            // Update all name attributes with correct index
            const textareas = questionElement.querySelectorAll('textarea');
            const inputs = questionElement.querySelectorAll('input');
            const selects = questionElement.querySelectorAll('select');

            [...textareas, ...inputs, ...selects].forEach(element => {
                if (element.name) {
                    element.name = element.name.replace(/questions\[\d+\]/g, `questions[${questionCount}]`);
                }
            });

            // Handle remove button
            questionElement.querySelector('.remove-question').addEventListener('click', function() {
                if (document.querySelectorAll('.question-card').length > 1) {
                    // Fade out animation
                    questionElement.style.transform = 'scale(0.95)';
                    questionElement.style.opacity = '0';
                    setTimeout(() => {
                        questionElement.remove();
                        updateQuestionNumbers();
                    }, 200);
                } else {
                    // Show modern alert
                    showAlert('Minimal harus ada 1 pertanyaan', 'warning');
                }
            });

            // Add fade in animation for new question
            questionElement.style.opacity = '0';
            questionElement.style.transform = 'translateY(-20px)';
            questionsContainer.appendChild(questionElement);

            setTimeout(() => {
                questionElement.style.transition = 'all 0.3s ease';
                questionElement.style.opacity = '1';
                questionElement.style.transform = 'translateY(0)';
            }, 10);

            questionCount++;
        }

        function updateQuestionNumbers() {
            document.querySelectorAll('.question-card').forEach((card, index) => {
                card.querySelector('.question-number').textContent = index + 1;
            });
        }

        function showAlert(message, type = 'info') {
            // Create alert element
            const alertDiv = document.createElement('div');
            const bgColor = type === 'warning' ? 'bg-yellow-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';

            alertDiv.className = `fixed top-4 right-2 sm:right-4 left-2 sm:left-auto ${bgColor} text-white px-4 sm:px-6 py-3 sm:py-4 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300 text-sm sm:text-base`;
            alertDiv.innerHTML = `
                <div class="flex items-center">
                    <i class="fas ${type === 'warning' ? 'fa-exclamation-triangle' : type === 'error' ? 'fa-times-circle' : 'fa-info-circle'} mr-2"></i>
                    <span>${message}</span>
                </div>
            `;

            document.body.appendChild(alertDiv);

            // Show alert with animation
            setTimeout(() => {
                alertDiv.classList.add('alert-slide-in');
            }, 100);

            // Hide alert after 3 seconds
            setTimeout(() => {
                alertDiv.classList.remove('alert-slide-in');
                alertDiv.classList.add('alert-slide-out');
                setTimeout(() => {
                    document.body.removeChild(alertDiv);
                }, 300);
            }, 3000);
        }

        // Form validation
        document.getElementById('postTestForm').addEventListener('submit', function(e) {
            const questionCards = document.querySelectorAll('.question-card');
            if (questionCards.length === 0) {
                e.preventDefault();
                showAlert('Minimal harus ada 1 pertanyaan', 'error');
                return;
            }

            let isValid = true;
            questionCards.forEach((card, index) => {
                const questionText = card.querySelector('.question-text').value.trim();
                const correctAnswer = card.querySelector(`input[name="questions[${index}][correct_answer]"]:checked`);

                if (!questionText) {
                    isValid = false;
                    card.querySelector('.question-text').classList.add('border-red-500');
                    card.querySelector('.question-text').classList.remove('border-gray-300');
                }

                if (!correctAnswer) {
                    isValid = false;
                    showAlert(`Pertanyaan #${index + 1} belum memiliki jawaban yang benar`, 'error');
                }
            });

            if (!isValid) {
                e.preventDefault();
            } else {
                // Show loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menyimpan...';
                submitBtn.disabled = true;
            }
        });

        // Remove error styling when user starts typing
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('question-text')) {
                e.target.classList.remove('border-red-500');
                e.target.classList.add('border-gray-300');
            }
        });
    });
    </script>
@endsection
