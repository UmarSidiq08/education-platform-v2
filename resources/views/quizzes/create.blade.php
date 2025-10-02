@extends('layouts.app')

@section('title', 'Tambah Pre Test - ' . $material->title)

@section('content')
<div class="max-w-6xl mx-auto p-3 sm:p-4 md:p-5">
    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-indigo-500 via-purple-600 to-purple-700 rounded-xl sm:rounded-2xl md:rounded-3xl p-4 sm:p-6 md:p-8 lg:p-10 text-center mb-4 sm:mb-6 md:mb-8 relative overflow-hidden shadow-lg sm:shadow-xl md:shadow-2xl shadow-indigo-300/30">
        <div class="relative z-10">
            <h2 class="text-white text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold mb-2 sm:mb-3">
                <i class="fas fa-magic mr-2 animate-bounce"></i>Buat Pre Test Baru
            </h2>
            <p class="text-indigo-100 text-sm sm:text-base md:text-lg">
                Untuk materi: <strong>{{ $material->title }}</strong>
            </p>
        </div>
        <div class="absolute -top-6 sm:-top-8 md:-top-12 -right-6 sm:-right-8 md:-right-12 w-24 sm:w-32 md:w-48 h-24 sm:h-32 md:h-48 bg-white/10 rounded-full"></div>
        <div class="absolute -top-3 sm:-top-4 md:-top-6 -right-3 sm:-right-4 md:-right-6 w-12 sm:w-16 md:w-24 h-12 sm:h-16 md:h-24 bg-white/10 rounded-full"></div>
    </div>

    <!-- Main Form Card -->
    <div class="bg-white rounded-xl sm:rounded-2xl md:rounded-3xl overflow-hidden shadow-lg sm:shadow-xl md:shadow-2xl shadow-gray-500/10">
        <div class="bg-gradient-to-br from-indigo-500 via-purple-600 to-purple-700 px-3 sm:px-4 md:px-6 lg:px-8 py-4 sm:py-5 md:py-6">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-2 sm:gap-3 md:gap-4">
                <h4 class="text-white text-lg sm:text-xl md:text-2xl font-semibold m-0 text-center md:text-left">
                    <i class="fas fa-plus-circle mr-2 animate-bounce"></i>Formulir Pre Test
                </h4>
                <div class="bg-white/20 backdrop-blur px-2 sm:px-3 md:px-4 py-1 sm:py-2 rounded-full text-white text-xs sm:text-sm text-center md:text-left mt-2 md:mt-0">
                    <i class="fas fa-book-open mr-1 sm:mr-2"></i>{{ $material->title }}
                </div>
            </div>
        </div>

        <div class="p-3 sm:p-4 md:p-6 lg:p-8">
            <form action="{{ route('quizzes.store', $material) }}" method="POST" id="quiz-form" enctype="multipart/form-data">
                @csrf

                <!-- Basic Info Section -->
                <div class="mb-6 sm:mb-8 md:mb-10 lg:mb-12">
                    <div class="mb-4 sm:mb-5 md:mb-6">
                        <h5 class="text-indigo-600 text-base sm:text-lg md:text-xl font-semibold mb-2">
                            <i class="fas fa-info-circle mr-2"></i>Informasi Dasar
                        </h5>
                        <div class="h-1 bg-gradient-to-r from-indigo-500 via-purple-600 to-transparent rounded-full"></div>
                    </div>

                    <div class="flex flex-col gap-3 sm:gap-4 md:gap-5 mb-4 sm:mb-5 md:mb-6">
                        <div class="flex-1">
                            <label for="title" class="block text-gray-800 font-semibold mb-2 text-xs sm:text-sm">Judul Pre Test</label>
                            <div class="relative flex items-center">
                                <i class="fas fa-heading absolute left-3 text-indigo-500 z-10 text-xs sm:text-sm"></i>
                                <input type="text" class="w-full pl-9 sm:pl-10 md:pl-12 pr-3 py-2 sm:py-3 md:py-4 border-2 border-indigo-100 rounded-lg text-xs sm:text-sm md:text-base transition-all duration-300 focus:border-indigo-500 focus:shadow-lg focus:shadow-indigo-100 focus:outline-none focus:-translate-y-0.5 @error('title') border-red-500 @enderror"
                                       id="title" name="title" value="{{ old('title') }}"
                                       placeholder="Masukkan judul Pre Test yang menarik" required>
                                @error('title')
                                    <div class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="flex-1">
                            <label for="time_limit" class="block text-gray-800 font-semibold mb-2 text-xs sm:text-sm">Waktu Pengerjaan</label>
                            <div class="relative flex items-center">
                                <i class="fas fa-clock absolute left-3 text-indigo-500 z-10 text-xs sm:text-sm"></i>
                                <input type="number" class="w-full pl-9 sm:pl-10 md:pl-12 pr-10 sm:pr-12 md:pr-16 py-2 sm:py-3 md:py-4 border-2 border-indigo-100 rounded-lg text-xs sm:text-sm md:text-base transition-all duration-300 focus:border-indigo-500 focus:shadow-lg focus:shadow-indigo-100 focus:outline-none focus:-translate-y-0.5 @error('time_limit') border-red-500 @enderror"
                                       id="time_limit" name="time_limit" value="{{ old('time_limit', 30) }}"
                                       min="1" required>
                                <span class="absolute right-3 text-gray-500 text-xs">menit</span>
                                @error('time_limit')
                                    <div class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 sm:mb-5 md:mb-6">
                        <label for="description" class="block text-gray-800 font-semibold mb-2 text-xs sm:text-sm">
                            Deskripsi Pre Test <span class="text-gray-500 font-normal">(opsional)</span>
                        </label>
                        <textarea class="w-full p-3 border-2 border-indigo-100 rounded-lg text-xs sm:text-sm md:text-base transition-all duration-300 resize-y min-h-24 sm:min-h-28 md:min-h-32 font-inherit focus:border-indigo-500 focus:shadow-lg focus:shadow-indigo-100 focus:outline-none focus:-translate-y-0.5 @error('description') border-red-500 @enderror"
                                  id="description" name="description" rows="4"
                                  placeholder="Tambahkan deskripsi Pre Test, petunjuk pengerjaan, atau informasi penting lainnya...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</div>
                        @enderror
                        <div class="mt-2 text-xs text-gray-500">
                            <i class="fas fa-lightbulb mr-1"></i>Deskripsi akan ditampilkan kepada peserta sebelum memulai Pre Test
                        </div>
                    </div>
                </div>

                <!-- Questions Section -->
                <div class="mb-6 sm:mb-8 md:mb-10 lg:mb-12">
                    <div class="mb-4 sm:mb-5 md:mb-6">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-start mb-3 sm:mb-4 md:mb-5 gap-3 sm:gap-4 md:gap-5">
                            <div class="flex-1">
                                <h5 class="text-indigo-600 text-base sm:text-lg md:text-xl font-semibold mb-1">
                                    <i class="fas fa-question-circle mr-2"></i>Daftar Pertanyaan
                                </h5>
                                <p class="text-gray-500 text-xs m-0">Minimal 1 pertanyaan diperlukan untuk membuat Pre Test</p>
                            </div>
                            <button type="button" class="inline-flex items-center px-3 sm:px-4 md:px-6 py-2 sm:py-3 bg-gradient-to-br from-indigo-500 to-purple-600 text-white font-semibold text-xs sm:text-sm md:text-base rounded-full hover:-translate-y-0.5 hover:shadow-xl hover:shadow-indigo-300/40 transition-all duration-300 w-full sm:w-auto justify-center mt-2 sm:mt-0" id="add-question">
                                <i class="fas fa-plus mr-1 sm:mr-2"></i>Tambah Pertanyaan
                            </button>
                        </div>
                        <div class="h-1 bg-gradient-to-r from-indigo-500 via-purple-600 to-transparent rounded-full"></div>
                    </div>

                    <div id="questions-container" class="min-h-16 sm:min-h-20 md:min-h-24">
                        <!-- Questions will be added here via JavaScript -->
                    </div>

                    <div id="empty-state" class="text-center py-6 sm:py-8 md:py-10 lg:py-12 text-gray-500 hidden">
                        <i class="fas fa-question-circle text-2xl sm:text-3xl md:text-4xl lg:text-5xl mb-3 sm:mb-4 md:mb-5 opacity-50"></i>
                        <h6 class="text-sm sm:text-base md:text-lg font-semibold mb-2 sm:mb-3">Belum ada pertanyaan</h6>
                        <p class="m-0 text-xs sm:text-sm md:text-base">Klik tombol "Tambah Pertanyaan" untuk memulai</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 sm:mt-8 md:mt-10 lg:mt-12">
                    <div class="h-0.5 bg-gradient-to-r from-transparent via-indigo-200 to-transparent mb-4 sm:mb-5 md:mb-6"></div>
                    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3 sm:gap-4 md:gap-5">
                        <a href="{{ route('materials.show', $material) }}" class="inline-flex items-center px-3 sm:px-4 md:px-6 py-2 sm:py-3 bg-indigo-50 text-indigo-600 font-semibold text-xs sm:text-sm md:text-base rounded-full border-2 border-indigo-100 hover:bg-indigo-100 hover:text-indigo-700 hover:-translate-y-0.5 transition-all duration-300 justify-center order-2 md:order-1">
                            <i class="fas fa-arrow-left mr-1 sm:mr-2"></i>Kembali ke Materi
                        </a>
                        <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 md:gap-4 order-1 md:order-2 mb-4 md:mb-0">
                            <button type="button" class="inline-flex items-center px-3 sm:px-4 md:px-6 py-2 sm:py-3 bg-white text-indigo-600 font-semibold text-xs sm:text-sm md:text-base rounded-full border-2 border-indigo-600 hover:bg-indigo-600 hover:text-white transition-all duration-300 justify-center" onclick="previewQuiz()">
                                <i class="fas fa-eye mr-1 sm:mr-2"></i>Preview
                            </button>
                            <button type="submit" class="inline-flex items-center px-3 sm:px-4 md:px-6 py-2 sm:py-3 bg-gradient-to-br from-indigo-500 to-purple-600 text-white font-semibold text-xs sm:text-sm md:text-base rounded-full hover:-translate-y-0.5 hover:shadow-xl hover:shadow-indigo-300/40 transition-all duration-300 justify-center">
                                <i class="fas fa-save mr-1 sm:mr-2"></i>Simpan Pre Test
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let questionCount = 0;

document.getElementById('add-question').addEventListener('click', function() {
    addQuestion();
    updateEmptyState();
});

function addQuestion() {
    questionCount++;

    const questionsContainer = document.getElementById('questions-container');
    const questionHtml = `
        <div class="bg-white border-2 border-indigo-50 rounded-xl sm:rounded-2xl overflow-hidden mb-4 sm:mb-5 md:mb-6 transition-all duration-300 hover:border-indigo-200 hover:shadow-xl hover:shadow-indigo-100/15 hover:-translate-y-0.5 opacity-0 translate-y-5" data-question="${questionCount}">
            <div class="bg-gradient-to-br from-indigo-50 to-purple-50 p-4 flex flex-col md:flex-row md:items-center gap-3 sm:gap-4">
                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 text-white w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center font-bold relative flex-shrink-0 mx-auto md:mx-0">
                    <i class="fas fa-question absolute text-xs top-1 sm:top-2"></i>
                    <span class="text-base sm:text-lg mt-0.5 sm:mt-1">${questionCount}</span>
                </div>
                <div class="flex-1 text-center md:text-left">
                    <h6 class="text-gray-800 text-base sm:text-lg font-semibold m-0">Pertanyaan ${questionCount}</h6>
                </div>
                <button type="button" class="bg-red-500 text-white w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center border-0 cursor-pointer hover:bg-red-600 hover:scale-110 transition-all duration-300 remove-question mx-auto md:mx-0 mt-2 md:mt-0" title="Hapus pertanyaan">
                    <i class="fas fa-trash text-xs sm:text-sm"></i>
                </button>
            </div>

            <div class="p-4 sm:p-5 md:p-6">
                <div class="mb-4 sm:mb-5 md:mb-6">
                    <label class="block text-gray-800 font-semibold mb-2 text-xs sm:text-sm">Teks Pertanyaan</label>
                    <textarea name="questions[${questionCount-1}][question]"
                              class="w-full p-3 border-2 border-indigo-100 rounded-lg sm:rounded-xl text-xs sm:text-sm md:text-base transition-all duration-300 resize-y min-h-20 sm:min-h-24 font-inherit focus:border-indigo-500 focus:shadow-lg focus:shadow-indigo-100 focus:outline-none focus:-translate-y-0.5 question-text" rows="3"
                              placeholder="Tuliskan pertanyaan Anda di sini..." required></textarea>
                </div>

                <!-- Image Upload Section -->
                <div class="mb-4 sm:mb-5 md:mb-6">
                    <label class="block text-gray-800 font-semibold mb-2 text-xs sm:text-sm">
                        Gambar Pertanyaan <span class="text-gray-500 font-normal">(opsional)</span>
                    </label>
                    <div class="flex flex-col gap-3">
                        <div class="relative">
                            <input type="file"
                                   name="questions[${questionCount-1}][image]"
                                   accept="image/*"
                                   class="hidden image-input"
                                   id="image-${questionCount}"
                                   onchange="previewImage(this, ${questionCount})">
                            <label for="image-${questionCount}"
                                   class="flex items-center justify-center gap-2 p-4 border-2 border-dashed border-indigo-200 rounded-lg cursor-pointer hover:border-indigo-400 hover:bg-indigo-50 transition-all duration-300">
                                <i class="fas fa-image text-indigo-500"></i>
                                <span class="text-sm text-gray-600">Klik untuk upload gambar</span>
                            </label>
                        </div>
                        <div id="preview-${questionCount}" class="hidden">
                            <div class="relative inline-block">
                                <img src="" alt="Preview" class="max-w-full h-auto rounded-lg border-2 border-indigo-100 max-h-64">
                                <button type="button"
                                        onclick="removeImage(${questionCount})"
                                        class="absolute top-2 right-2 bg-red-500 text-white w-8 h-8 rounded-full flex items-center justify-center hover:bg-red-600 transition-colors">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>Format: JPG, JPEG, PNG, GIF. Maksimal 2MB
                        </div>
                    </div>
                </div>

                <div class="mb-4 sm:mb-5 md:mb-6">
                    <label class="block text-gray-800 font-semibold mb-2 text-xs sm:text-sm">Pilihan Jawaban</label>
                    <div class="flex flex-col gap-3 sm:gap-4">
                        ${generateOptionHtml('A', questionCount-1, 0)}
                        ${generateOptionHtml('B', questionCount-1, 1)}
                        ${generateOptionHtml('C', questionCount-1, 2)}
                        ${generateOptionHtml('D', questionCount-1, 3)}
                    </div>
                    <div class="mt-3 p-2 sm:p-3 bg-blue-50 text-blue-700 rounded-lg text-xs sm:text-sm">
                        <i class="fas fa-info-circle mr-2"></i>Pilih radio button untuk menentukan jawaban yang benar
                    </div>
                </div>

                <div class="bg-indigo-50 p-3 sm:p-4 md:p-5 rounded-lg sm:rounded-xl border-2 border-indigo-100">
                    <label class="block text-gray-800 font-semibold mb-2 text-xs sm:text-sm">Nilai Poin</label>
                    <select name="questions[${questionCount-1}][points]" class="w-full max-w-xs p-2 sm:p-3 border-2 border-indigo-100 rounded-lg text-xs sm:text-sm bg-white transition-all duration-300 focus:border-indigo-500 focus:outline-none focus:shadow-md focus:shadow-indigo-100">
                        <option value="1" selected>1 Poin</option>
                        <option value="2">2 Poin</option>
                        <option value="3">3 Poin</option>
                        <option value="4">4 Poin</option>
                        <option value="5">5 Poin</option>
                        <option value="6">6 Poin</option>
                        <option value="7">7 Poin</option>
                        <option value="8">8 Poin</option>
                        <option value="9">9 Poin</option>
                        <option value="10">10 Poin</option>
                    </select>
                </div>
            </div>
        </div>
    `;

    questionsContainer.insertAdjacentHTML('beforeend', questionHtml);
    attachQuestionEventListeners();
    animateQuestionEntry();
}

function previewImage(input, questionNum) {
    const previewDiv = document.getElementById(`preview-${questionNum}`);
    const img = previewDiv.querySelector('img');

    if (input.files && input.files[0]) {
        const file = input.files[0];
        const maxSize = 2 * 1024 * 1024; // 2MB in bytes

        // Validasi ukuran file
        if (file.size > maxSize) {
            alert(`Ukuran file terlalu besar!\n\nFile: ${file.name}\nUkuran: ${(file.size / 1024 / 1024).toFixed(2)} MB\nMaksimal: 2 MB\n\nSilakan pilih gambar dengan ukuran lebih kecil.`);
            input.value = ''; // Reset input
            return;
        }

        // Validasi tipe file
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            alert(`Format file tidak didukung!\n\nFile: ${file.name}\nFormat yang diperbolehkan: JPG, JPEG, PNG, GIF`);
            input.value = ''; // Reset input
            return;
        }

        const reader = new FileReader();

        reader.onload = function(e) {
            img.src = e.target.result;
            previewDiv.classList.remove('hidden');
        };

        reader.readAsDataURL(file);
    }
}

function removeImage(questionNum) {
    const input = document.getElementById(`image-${questionNum}`);
    const previewDiv = document.getElementById(`preview-${questionNum}`);

    input.value = '';
    previewDiv.classList.add('hidden');
}

function generateOptionHtml(letter, questionIndex, optionIndex) {
    return `
        <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-4 p-3 sm:p-4 bg-indigo-50 rounded-lg sm:rounded-xl border-2 border-transparent hover:border-indigo-200 hover:bg-white transition-all duration-300">
            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 text-white w-7 h-7 sm:w-9 sm:h-9 rounded-full flex items-center justify-center font-bold text-xs sm:text-sm flex-shrink-0 mx-auto sm:mx-0">${letter}</div>
            <input type="text" name="questions[${questionIndex}][options][]"
                   class="flex-1 border border-indigo-200 rounded-lg p-2 sm:p-3 text-xs sm:text-sm transition-all duration-300 focus:border-indigo-500 focus:outline-none focus:shadow-md focus:shadow-indigo-100"
                   placeholder="Masukkan pilihan ${letter}" required>
            <label class="flex items-center gap-2 cursor-pointer text-xs sm:text-sm text-gray-500 justify-center sm:justify-start mt-2 sm:mt-0">
                <input type="radio" name="questions[${questionIndex}][correct_answer]"
                       value="${optionIndex}" class="hidden" required>
                <span class="w-5 h-5 sm:w-6 sm:h-6 border-2 border-indigo-200 rounded-full flex items-center justify-center transition-all duration-300 bg-white flex-shrink-0">
                    <i class="fas fa-check text-xs text-white opacity-0 transition-all duration-300"></i>
                </span>
                <span class="whitespace-nowrap">Benar</span>
            </label>
        </div>
    `;
}

function attachQuestionEventListeners() {
    // Handle remove buttons
    const removeButtons = document.querySelectorAll('.remove-question');
    removeButtons.forEach(button => {
        button.removeEventListener('click', handleRemoveQuestion);
        button.addEventListener('click', handleRemoveQuestion);
    });

    // Handle radio button styling for all questions
    const allQuestions = document.querySelectorAll('[data-question]');
    allQuestions.forEach(questionCard => {
        const radioInputs = questionCard.querySelectorAll('input[type="radio"]');
        radioInputs.forEach(radio => {
            radio.removeEventListener('change', handleRadioChange);
            radio.addEventListener('change', handleRadioChange);
        });
    });
}

function handleRadioChange() {
    const questionCard = this.closest('[data-question]');
    if (!questionCard) return;

    const allSpans = questionCard.querySelectorAll('input[type="radio"] + span');

    allSpans.forEach(span => {
        span.classList.remove('bg-gradient-to-br', 'from-indigo-500', 'to-purple-600', 'border-indigo-500');
        span.classList.add('border-indigo-200', 'bg-white');
        const icon = span.querySelector('i');
        if (icon) {
            icon.classList.remove('opacity-100');
            icon.classList.add('opacity-0');
        }
    });

    if (this.checked) {
        const span = this.nextElementSibling;
        if (span) {
            span.classList.remove('border-indigo-200', 'bg-white');
            span.classList.add('bg-gradient-to-br', 'from-indigo-500', 'to-purple-600', 'border-indigo-500');
            const icon = span.querySelector('i');
            if (icon) {
                icon.classList.remove('opacity-0');
                icon.classList.add('opacity-100');
            }
        }
    }
}

function handleRemoveQuestion(e) {
    if (confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?')) {
        const questionCard = e.target.closest('.bg-white');
        questionCard.style.opacity = '0';
        questionCard.style.transform = 'translateX(100px)';

        setTimeout(() => {
            questionCard.remove();
            updateQuestionNumbers();
            updateEmptyState();
        }, 300);
    }
}

function updateQuestionNumbers() {
    const questions = document.querySelectorAll('[data-question]');
    questions.forEach((question, index) => {
        const questionNumber = index + 1;
        question.setAttribute('data-question', questionNumber);

        question.querySelector('span').textContent = questionNumber;
        question.querySelector('h6').textContent = `Pertanyaan ${questionNumber}`;

        const textarea = question.querySelector('textarea');
        const inputs = question.querySelectorAll('input[type="text"]');
        const radios = question.querySelectorAll('input[type="radio"]');
        const select = question.querySelector('select');
        const imageInput = question.querySelector('.image-input');

        textarea.name = `questions[${questionNumber-1}][question]`;
        select.name = `questions[${questionNumber-1}][points]`;

        if (imageInput) {
            imageInput.name = `questions[${questionNumber-1}][image]`;
            imageInput.id = `image-${questionNumber}`;
            const label = imageInput.nextElementSibling;
            if (label) label.setAttribute('for', `image-${questionNumber}`);

            const previewDiv = question.querySelector('[id^="preview-"]');
            if (previewDiv) {
                previewDiv.id = `preview-${questionNumber}`;
                const removeBtn = previewDiv.querySelector('button');
                if (removeBtn) {
                    removeBtn.setAttribute('onclick', `removeImage(${questionNumber})`);
                }
            }

            imageInput.setAttribute('onchange', `previewImage(this, ${questionNumber})`);
        }

        inputs.forEach((input) => {
            input.name = `questions[${questionNumber-1}][options][]`;
        });

        radios.forEach((radio) => {
            radio.name = `questions[${questionNumber-1}][correct_answer]`;
        });
    });

    questionCount = questions.length;
}

function updateEmptyState() {
    const emptyState = document.getElementById('empty-state');
    const hasQuestions = document.querySelectorAll('[data-question]').length > 0;
    if (hasQuestions) {
        emptyState.classList.add('hidden');
    } else {
        emptyState.classList.remove('hidden');
    }
}

function animateQuestionEntry() {
    const lastQuestion = document.querySelector('[data-question]:last-child');
    if (lastQuestion) {
        setTimeout(() => {
            lastQuestion.style.transition = 'all 0.4s ease';
            lastQuestion.style.opacity = '1';
            lastQuestion.style.transform = 'translateY(0)';
        }, 10);
    }
}

function previewQuiz() {
    const title = document.getElementById('title').value;
    const timeLimit = document.getElementById('time_limit').value;
    const description = document.getElementById('description').value;
    const questions = document.querySelectorAll('[data-question]').length;

    if (!title || !timeLimit || questions === 0) {
        alert('Harap lengkapi informasi dasar dan tambahkan minimal 1 pertanyaan untuk preview.');
        return;
    }

    alert(`Preview Pre Test:\n\nJudul: ${title}\nWaktu: ${timeLimit} menit\nDeskripsi: ${description || 'Tidak ada'}\nJumlah Pertanyaan: ${questions}`);
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    addQuestion();
    updateEmptyState();

    // Validasi form sebelum submit
    const form = document.getElementById('quiz-form');
    form.addEventListener('submit', function(e) {
        const imageInputs = document.querySelectorAll('.image-input');
        const maxSize = 2 * 1024 * 1024; // 2MB
        let hasError = false;
        let errorMessages = [];

        imageInputs.forEach((input, index) => {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const questionNum = index + 1;

                // Cek ukuran
                if (file.size > maxSize) {
                    hasError = true;
                    errorMessages.push(`Pertanyaan ${questionNum}: File "${file.name}" terlalu besar (${(file.size / 1024 / 1024).toFixed(2)} MB). Maksimal 2 MB.`);
                }

                // Cek format
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                if (!allowedTypes.includes(file.type)) {
                    hasError = true;
                    errorMessages.push(`Pertanyaan ${questionNum}: Format file "${file.name}" tidak didukung. Gunakan JPG, JPEG, PNG, atau GIF.`);
                }
            }
        });

        if (hasError) {
            e.preventDefault();
            alert('Terdapat masalah dengan gambar yang diupload:\n\n' + errorMessages.join('\n\n') + '\n\nSilakan perbaiki sebelum menyimpan.');
            return false;
        }
    });
});
</script>

@endsection
