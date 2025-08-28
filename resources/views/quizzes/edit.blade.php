@extends('layouts.app')

@section('title', 'Edit Pre Test - ' . $quiz->title)

@section('content')
<div class="max-w-7xl mx-auto p-5">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-3xl p-10 text-center mb-8 relative overflow-hidden shadow-2xl shadow-indigo-500/30">
        <div class="relative z-10">
            <h2 class="text-white text-4xl font-bold mb-3">
                <i class="fas fa-edit animate-bounce mr-3"></i>Edit Pre Test
            </h2>
            <p class="text-white/80 text-lg">
                Untuk materi: <strong>{{ $material->title }}</strong>
            </p>

            <!-- Warning jika sudah dikerjakan -->
            @if($quiz->attempts()->exists())
            <div class="bg-yellow-500/20 backdrop-blur-sm border border-yellow-300/30 rounded-xl p-4 mt-6 text-left">
                <i class="fas fa-exclamation-triangle text-yellow-200 mr-2"></i>
                <strong class="text-yellow-200">Peringatan:</strong>
                <span class="text-yellow-100">
                    Pre Test ini sudah dikerjakan oleh {{ $quiz->attempts()->count() }} siswa.
                    Perubahan mungkin mempengaruhi hasil yang sudah ada.
                </span>
            </div>
            @endif
        </div>

        <!-- Decorative elements -->
        <div class="absolute -top-12 -right-12 w-48 h-48 bg-white/10 rounded-full"></div>
        <div class="absolute top-8 right-8 w-24 h-24 bg-white/10 rounded-full"></div>
    </div>

    <!-- Main Form Card -->
    <div class="bg-white rounded-3xl overflow-hidden shadow-2xl shadow-black/10">
        <!-- Card Header -->
        <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 px-8 py-6">
            <div class="flex justify-between items-center">
                <h4 class="text-white text-2xl font-semibold">
                    <i class="fas fa-edit mr-3 animate-bounce"></i>Formulir Edit Pre Test
                </h4>
                <div class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-white text-sm">
                    <i class="fas fa-book-open mr-2"></i>{{ $material->title }}
                </div>
            </div>
        </div>

        <!-- Card Body -->
        <div class="p-10">
            <form action="{{ route('quizzes.update', [$material, $quiz]) }}" method="POST" id="quiz-form">
                @csrf
                @method('PUT')

                <!-- Basic Info Section -->
                <div class="mb-12">
                    <div class="mb-8">
                        <div class="flex justify-between items-start mb-5">
                            <div>
                                <h5 class="text-indigo-600 text-xl font-semibold mb-2">
                                    <i class="fas fa-info-circle mr-3"></i>Informasi Dasar
                                </h5>
                                <div class="h-1 w-32 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full"></div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                        <div class="lg:col-span-2">
                            <label for="title" class="block text-gray-800 font-semibold mb-2">Judul Pre Test</label>
                            <div class="relative">
                                <i class="fas fa-heading absolute left-4 top-1/2 transform -translate-y-1/2 text-indigo-500 z-10"></i>
                                <input type="text"
                                       class="w-full pl-12 pr-4 py-4 border-2 border-indigo-100 rounded-xl text-base transition-all duration-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none @error('title') border-red-500 @enderror"
                                       id="title" name="title" value="{{ old('title', $quiz->title) }}"
                                       placeholder="Masukkan judul Pre Test yang menarik" required>
                                @error('title')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="time_limit" class="block text-gray-800 font-semibold mb-2">Waktu Pengerjaan</label>
                            <div class="relative">
                                <i class="fas fa-clock absolute left-4 top-1/2 transform -translate-y-1/2 text-indigo-500 z-10"></i>
                                <input type="number"
                                       class="w-full pl-12 pr-16 py-4 border-2 border-indigo-100 rounded-xl text-base transition-all duration-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none @error('time_limit') border-red-500 @enderror"
                                       id="time_limit" name="time_limit" value="{{ old('time_limit', $quiz->time_limit) }}"
                                       min="1" required>
                                <span class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">menit</span>
                                @error('time_limit')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="description" class="block text-gray-800 font-semibold mb-2">
                            Deskripsi Pre Test <span class="text-gray-500 font-normal">(opsional)</span>
                        </label>
                        <textarea class="w-full p-4 border-2 border-indigo-100 rounded-xl text-base transition-all duration-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none resize-y min-h-[120px] @error('description') border-red-500 @enderror"
                                  id="description" name="description" rows="4"
                                  placeholder="Tambahkan deskripsi Pre Test, petunjuk pengerjaan, atau informasi penting lainnya...">{{ old('description', $quiz->description) }}</textarea>
                        @error('description')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                        <div class="text-gray-600 text-sm mt-2">
                            <i class="fas fa-lightbulb mr-1"></i>Deskripsi akan ditampilkan kepada peserta sebelum memulai Pre Test
                        </div>
                    </div>
                </div>

                <!-- Questions Section -->
                <div class="mb-12">
                    <div class="mb-8">
                        <div class="flex justify-between items-start mb-5">
                            <div class="flex-1">
                                <h5 class="text-indigo-600 text-xl font-semibold mb-1">
                                    <i class="fas fa-question-circle mr-3"></i>Daftar Pertanyaan
                                </h5>
                                <p class="text-gray-600 text-sm">Minimal 1 pertanyaan diperlukan untuk membuat Pre Test</p>
                            </div>
                            <button type="button"
                                    class="bg-gradient-to-r from-indigo-500 to-purple-500 text-white px-6 py-3 rounded-full font-semibold transition-all duration-300 hover:shadow-lg hover:shadow-indigo-500/30 hover:-translate-y-1"
                                    id="add-question">
                                <i class="fas fa-plus mr-2"></i>Tambah Pertanyaan
                            </button>
                        </div>
                        <div class="h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-transparent rounded-full"></div>
                    </div>

                    <div id="questions-container" class="space-y-6">
                        <!-- Questions will be populated via JavaScript -->
                    </div>

                    <div id="empty-state" class="text-center py-12 text-gray-500 hidden">
                        <i class="fas fa-question-circle text-5xl mb-5 opacity-50"></i>
                        <h6 class="text-lg font-semibold mb-2">Belum ada pertanyaan</h6>
                        <p class="text-sm">Klik tombol "Tambah Pertanyaan" untuk memulai</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-12">
                    <div class="h-0.5 bg-gradient-to-r from-transparent via-indigo-200 to-transparent mb-8"></div>
                    <div class="flex flex-col lg:flex-row justify-between items-center gap-4">
                        <a href="{{ route('materials.show', $material) }}"
                           class="w-full lg:w-auto inline-flex items-center justify-center px-6 py-3 bg-gray-50 text-indigo-600 border-2 border-indigo-100 rounded-full font-semibold transition-all duration-300 hover:bg-indigo-100 hover:text-indigo-700 hover:-translate-y-1">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Materi
                        </a>
                        <div class="flex flex-col lg:flex-row gap-4 w-full lg:w-auto">
                            <button type="button"
                                    class="w-full lg:w-auto inline-flex items-center justify-center px-6 py-3 bg-white text-indigo-600 border-2 border-indigo-500 rounded-full font-semibold transition-all duration-300 hover:bg-indigo-500 hover:text-white"
                                    onclick="previewQuiz()">
                                <i class="fas fa-eye mr-2"></i>Preview
                            </button>
                            <button type="submit"
                                    class="w-full lg:w-auto inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-500 text-white rounded-full font-semibold transition-all duration-300 hover:shadow-lg hover:shadow-indigo-500/30 hover:-translate-y-1">
                                <i class="fas fa-save mr-2"></i>Update Pre Test
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
let existingQuestions = @json($quiz->questions->sortBy('order')->values());

document.getElementById('add-question').addEventListener('click', function() {
    addQuestion();
    updateEmptyState();
});

function addQuestion(questionData = null) {
    questionCount++;

    const questionsContainer = document.getElementById('questions-container');
    const questionIndex = questionCount - 1;

    const questionText = questionData ? questionData.question : '';
    const options = questionData ? questionData.options : ['', '', '', ''];
    const correctAnswer = questionData ? questionData.correct_answer : 0;
    const points = questionData ? questionData.points : 1;

    const questionHtml = `
        <div class="bg-white border-2 border-indigo-50 rounded-2xl overflow-hidden transition-all duration-300 hover:border-indigo-200 hover:shadow-xl hover:shadow-indigo-500/10 hover:-translate-y-1 question-card" data-question="${questionCount}">
            <!-- Question Header -->
            <div class="bg-gradient-to-r from-gray-50 to-indigo-50 px-6 py-5 flex items-center gap-4">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-500 text-white w-12 h-12 rounded-full flex items-center justify-center font-bold text-lg flex-shrink-0 relative">
                    <i class="fas fa-question absolute top-2 text-xs"></i>
                    <span class="mt-1">${questionCount}</span>
                </div>
                <div class="flex-1">
                    <h6 class="text-gray-800 font-semibold text-lg">Pertanyaan ${questionCount}</h6>
                </div>
                <button type="button"
                        class="bg-red-500 hover:bg-red-600 text-white w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 remove-question"
                        title="Hapus pertanyaan">
                    <i class="fas fa-trash text-sm"></i>
                </button>
            </div>

            <!-- Question Body -->
            <div class="p-6">
                <!-- Question Text -->
                <div class="mb-6">
                    <label class="block text-gray-800 font-semibold mb-2">Teks Pertanyaan</label>
                    <textarea name="questions[${questionIndex}][question]"
                              class="w-full p-4 border-2 border-indigo-100 rounded-xl text-base transition-all duration-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 outline-none resize-y min-h-[100px] question-text"
                              rows="3" placeholder="Tuliskan pertanyaan Anda di sini..." required>${questionText}</textarea>
                </div>

                <!-- Options -->
                <div class="mb-6">
                    <label class="block text-gray-800 font-semibold mb-3">Pilihan Jawaban</label>
                    <div class="space-y-4">
                        ${generateOptionHtml('A', questionIndex, 0, options[0], correctAnswer === 0)}
                        ${generateOptionHtml('B', questionIndex, 1, options[1], correctAnswer === 1)}
                        ${generateOptionHtml('C', questionIndex, 2, options[2], correctAnswer === 2)}
                        ${generateOptionHtml('D', questionIndex, 3, options[3], correctAnswer === 3)}
                    </div>
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-3 mt-4">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                        <span class="text-blue-700 text-sm">Pilih radio button untuk menentukan jawaban yang benar</span>
                    </div>
                </div>

                <!-- Points -->
                <div class="bg-indigo-50 border-2 border-indigo-100 rounded-xl p-5">
                    <label class="block text-gray-800 font-semibold mb-3">Nilai Poin</label>
                    <select name="questions[${questionIndex}][points]"
                            class="w-32 p-3 border-2 border-indigo-100 rounded-lg text-base bg-white transition-all duration-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none">
                        <option value="1" ${points == 1 ? 'selected' : ''}>1 Poin</option>
                        <option value="2" ${points == 2 ? 'selected' : ''}>2 Poin</option>
                        <option value="3" ${points == 3 ? 'selected' : ''}>3 Poin</option>
                        <option value="4" ${points == 4 ? 'selected' : ''}>4 Poin</option>
                        <option value="5" ${points == 5 ? 'selected' : ''}>5 Poin</option>
                        <option value="6" ${points == 6 ? 'selected' : ''}>6 Poin</option>
                        <option value="7" ${points == 7 ? 'selected' : ''}>7 Poin</option>
                        <option value="8" ${points == 8 ? 'selected' : ''}>8 Poin</option>
                        <option value="9" ${points == 9 ? 'selected' : ''}>9 Poin</option>
                        <option value="10" ${points == 10 ? 'selected' : ''}>10 Poin</option>
                    </select>
                </div>
            </div>
        </div>
    `;

    questionsContainer.insertAdjacentHTML('beforeend', questionHtml);

    // Add event listeners
    attachQuestionEventListeners();
    animateQuestionEntry();
}

function generateOptionHtml(letter, questionIndex, optionIndex, value = '', isChecked = false) {
    return `
        <div class="flex items-center gap-4 p-4 bg-gray-50 hover:bg-white border-2 border-transparent hover:border-indigo-100 rounded-xl transition-all duration-300">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-500 text-white w-9 h-9 rounded-full flex items-center justify-center font-bold text-sm flex-shrink-0">
                ${letter}
            </div>
            <input type="text"
                   name="questions[${questionIndex}][options][]"
                   class="flex-1 border border-indigo-100 rounded-lg px-4 py-2.5 text-base transition-all duration-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none"
                   placeholder="Masukkan pilihan ${letter}"
                   value="${value}" required>
            <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-600">
                <input type="radio"
                       name="questions[${questionIndex}][correct_answer]"
                       value="${optionIndex}"
                       ${isChecked ? 'checked' : ''}
                       class="hidden" required>
                <span class="w-6 h-6 border-2 border-indigo-100 rounded-full flex items-center justify-center transition-all duration-300 ${isChecked ? 'bg-gradient-to-r from-indigo-500 to-purple-500 border-indigo-500' : 'bg-white'} flex-shrink-0">
                    <i class="fas fa-check text-white text-xs ${isChecked ? 'opacity-100' : 'opacity-0'} transition-opacity duration-300"></i>
                </span>
                <span class="whitespace-nowrap">Benar</span>
            </label>
        </div>
    `;
}

function attachQuestionEventListeners() {
    const removeButtons = document.querySelectorAll('.remove-question');
    removeButtons.forEach(button => {
        button.removeEventListener('click', handleRemoveQuestion);
        button.addEventListener('click', handleRemoveQuestion);
    });

    // Radio button event listeners
    const radioButtons = document.querySelectorAll('input[type="radio"]');
    radioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
            // Reset all radio buttons in this question
            const questionCard = this.closest('.question-card');
            const allRadios = questionCard.querySelectorAll('input[type="radio"]');
            const allSpans = questionCard.querySelectorAll('.w-6.h-6');
            const allIcons = questionCard.querySelectorAll('.fa-check');

            allSpans.forEach(span => {
                span.className = span.className.replace(/bg-gradient-to-r from-indigo-500 to-purple-500 border-indigo-500/, 'bg-white border-indigo-100');
            });
            allIcons.forEach(icon => {
                icon.className = icon.className.replace('opacity-100', 'opacity-0');
            });

            // Set the selected one
            const selectedSpan = this.nextElementSibling;
            const selectedIcon = selectedSpan.querySelector('.fa-check');
            selectedSpan.className = selectedSpan.className.replace('bg-white border-indigo-100', 'bg-gradient-to-r from-indigo-500 to-purple-500 border-indigo-500');
            selectedIcon.className = selectedIcon.className.replace('opacity-0', 'opacity-100');
        });
    });
}

function handleRemoveQuestion(e) {
    if (confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?')) {
        const questionCard = e.target.closest('.question-card');
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
    const questions = document.querySelectorAll('.question-card');
    questions.forEach((question, index) => {
        const questionNumber = index + 1;
        question.setAttribute('data-question', questionNumber);

        // Update visual number
        const numberSpan = question.querySelector('.w-12.h-12 span');
        const titleElement = question.querySelector('h6');
        if (numberSpan) numberSpan.textContent = questionNumber;
        if (titleElement) titleElement.textContent = `Pertanyaan ${questionNumber}`;

        // Update form names
        const textarea = question.querySelector('textarea');
        const inputs = question.querySelectorAll('input[type="text"]');
        const radios = question.querySelectorAll('input[type="radio"]');
        const select = question.querySelector('select');

        if (textarea) textarea.name = `questions[${questionNumber-1}][question]`;
        if (select) select.name = `questions[${questionNumber-1}][points]`;

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
    const hasQuestions = document.querySelectorAll('.question-card').length > 0;
    if (hasQuestions) {
        emptyState.classList.add('hidden');
    } else {
        emptyState.classList.remove('hidden');
    }
}

function animateQuestionEntry() {
    const lastQuestion = document.querySelector('.question-card:last-child');
    if (lastQuestion) {
        lastQuestion.style.opacity = '0';
        lastQuestion.style.transform = 'translateY(20px)';

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
    const questions = document.querySelectorAll('.question-card').length;

    if (!title || !timeLimit || questions === 0) {
        alert('Harap lengkapi informasi dasar dan tambahkan minimal 1 pertanyaan untuk preview.');
        return;
    }

    alert(`Preview Pre Test:\n\nJudul: ${title}\nWaktu: ${timeLimit} menit\nDeskripsi: ${description || 'Tidak ada'}\nJumlah Pertanyaan: ${questions}`);
}

// Initialize - Load existing questions
document.addEventListener('DOMContentLoaded', function() {
    if (existingQuestions && existingQuestions.length > 0) {
        existingQuestions.forEach(question => {
            addQuestion({
                question: question.question,
                options: question.options,
                correct_answer: question.correct_answer,
                points: question.points
            });
        });
    } else {
        addQuestion();
    }
    updateEmptyState();
});
</script>

@endsection
