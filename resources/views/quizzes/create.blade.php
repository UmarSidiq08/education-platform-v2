@extends('layouts.app')

@section('title', 'Tambah Pre Test - ' . $material->title)

@section('content')
<div class="max-w-7xl mx-auto p-3 sm:p-5">
    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl sm:rounded-3xl p-6 sm:p-8 md:p-10 text-center mb-6 sm:mb-8 relative overflow-hidden shadow-2xl shadow-indigo-500/30">
        <div class="relative z-10">
            <h2 class="text-white text-2xl sm:text-3xl md:text-4xl font-bold mb-2 sm:mb-3">
                <i class="fas fa-magic animate-bounce mr-2 sm:mr-3"></i>Buat Pre Test Baru
            </h2>
            <p class="text-white/80 text-sm sm:text-base md:text-lg px-2 sm:px-0">
                Untuk materi: <strong class="break-words">{{ $material->title }}</strong>
            </p>
        </div>
        <div class="absolute -top-8 sm:-top-12 -right-8 sm:-right-12 w-32 sm:w-48 h-32 sm:h-48 bg-white/10 rounded-full">
            <div class="absolute top-6 sm:top-12 left-6 sm:left-12 w-16 sm:w-24 h-16 sm:h-24 bg-white/10 rounded-full"></div>
        </div>
    </div>

    <!-- Main Form Card -->
    <div class="bg-white rounded-2xl sm:rounded-3xl overflow-hidden shadow-2xl shadow-black/10">
        <div class="bg-gradient-to-br from-indigo-500 to-purple-600 p-4 sm:p-6 md:p-8">
            <div class="flex justify-between items-center flex-col md:flex-row gap-3 sm:gap-4">
                <h4 class="text-white text-lg sm:text-xl md:text-2xl font-semibold m-0 text-center md:text-left">
                    <i class="fas fa-plus-circle animate-bounce mr-2 sm:mr-3"></i>Formulir Pre Test
                </h4>
                <div class="bg-white/20 backdrop-blur-md px-3 sm:px-4 py-2 rounded-full text-white text-xs sm:text-sm max-w-full">
                    <i class="fas fa-book-open mr-1 sm:mr-2"></i>
                    <span class="truncate inline-block max-w-[200px] sm:max-w-none">{{ $material->title }}</span>
                </div>
            </div>
        </div>

        <div class="p-4 sm:p-6 md:p-8 lg:p-10">
            <form action="{{ route('quizzes.store', $material) }}" method="POST" id="quiz-form">
                @csrf

                <!-- Basic Info Section -->
                <div class="mb-8 sm:mb-10 md:mb-12">
                    <div class="mb-6 sm:mb-8">
                        <h5 class="text-indigo-600 text-lg sm:text-xl font-semibold mb-2">
                            <i class="fas fa-info-circle mr-2 sm:mr-3"></i>Informasi Dasar
                        </h5>
                        <div class="h-1 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full mb-4"></div>
                    </div>

                    <div class="flex flex-col lg:flex-row gap-4 sm:gap-5 mb-4 sm:mb-6">
                        <div class="flex-1 lg:flex-[2]">
                            <label for="title" class="block text-gray-800 font-semibold mb-2 text-sm sm:text-base">Judul Pre Test</label>
                            <div class="relative flex items-center">
                                <i class="fas fa-heading absolute left-3 sm:left-4 text-indigo-500 z-10 text-sm sm:text-base"></i>
                                <input type="text" class="w-full pl-10 sm:pl-12 pr-3 sm:pr-4 py-3 sm:py-4 border-2 border-indigo-100 rounded-lg sm:rounded-xl text-sm sm:text-base transition-all duration-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 focus:-translate-y-0.5 @error('title') border-red-500 @enderror"
                                       id="title" name="title" value="{{ old('title') }}"
                                       placeholder="Masukkan judul Pre Test yang menarik" required>
                                @error('title')
                                    <div class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="flex-1">
                            <label for="time_limit" class="block text-gray-800 font-semibold mb-2 text-sm sm:text-base">Waktu Pengerjaan</label>
                            <div class="relative flex items-center">
                                <i class="fas fa-clock absolute left-3 sm:left-4 text-indigo-500 z-10 text-sm sm:text-base"></i>
                                <input type="number" class="w-full pl-10 sm:pl-12 pr-12 sm:pr-16 py-3 sm:py-4 border-2 border-indigo-100 rounded-lg sm:rounded-xl text-sm sm:text-base transition-all duration-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 focus:-translate-y-0.5 @error('time_limit') border-red-500 @enderror"
                                       id="time_limit" name="time_limit" value="{{ old('time_limit', 30) }}"
                                       min="1" required>
                                <span class="absolute right-3 sm:right-4 text-gray-500 text-xs sm:text-sm">menit</span>
                                @error('time_limit')
                                    <div class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 sm:mb-6">
                        <label for="description" class="block text-gray-800 font-semibold mb-2 text-sm sm:text-base">
                            Deskripsi Pre Test <span class="text-gray-500 font-normal">(opsional)</span>
                        </label>
                        <textarea class="w-full p-3 sm:p-4 border-2 border-indigo-100 rounded-lg sm:rounded-xl text-sm sm:text-base transition-all duration-300 resize-y min-h-[100px] sm:min-h-[120px] font-inherit focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 focus:-translate-y-0.5 @error('description') border-red-500 @enderror"
                                  id="description" name="description" rows="4"
                                  placeholder="Tambahkan deskripsi Pre Test, petunjuk pengerjaan, atau informasi penting lainnya...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</div>
                        @enderror
                        <div class="mt-2 text-xs sm:text-sm text-gray-500">
                            <i class="fas fa-lightbulb mr-1"></i>Deskripsi akan ditampilkan kepada peserta sebelum memulai Pre Test
                        </div>
                    </div>
                </div>

                <!-- Questions Section -->
                <div class="mb-8 sm:mb-10 md:mb-12">
                    <div class="mb-6 sm:mb-8">
                        <div class="flex flex-col lg:flex-row justify-between items-start mb-4 sm:mb-5 gap-4 sm:gap-5">
                            <div class="flex-1 w-full lg:w-auto">
                                <h5 class="text-indigo-600 text-lg sm:text-xl font-semibold mb-1">
                                    <i class="fas fa-question-circle mr-2 sm:mr-3"></i>Daftar Pertanyaan
                                </h5>
                                <p class="text-gray-500 text-xs sm:text-sm m-0">Minimal 1 pertanyaan diperlukan untuk membuat Pre Test</p>
                            </div>
                            <button type="button" class="w-full lg:w-auto inline-flex items-center justify-center px-4 sm:px-6 py-2 sm:py-3 bg-gradient-to-br from-indigo-500 to-purple-600 text-white font-semibold rounded-full transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-indigo-500/40 text-sm sm:text-base" id="add-question">
                                <i class="fas fa-plus mr-2"></i>Tambah Pertanyaan
                            </button>
                        </div>
                        <div class="h-1 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full"></div>
                    </div>

                    <div id="questions-container" class="min-h-[100px]">
                        <!-- Questions will be added here via JavaScript -->
                    </div>

                    <div id="empty-state" class="text-center py-8 sm:py-12 px-4 sm:px-5 text-gray-500 hidden">
                        <i class="fas fa-question-circle text-3xl sm:text-4xl md:text-5xl mb-4 sm:mb-5 opacity-50"></i>
                        <h6 class="text-base sm:text-lg font-semibold mb-2">Belum ada pertanyaan</h6>
                        <p class="m-0 text-sm sm:text-base">Klik tombol "Tambah Pertanyaan" untuk memulai</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 sm:mt-10 md:mt-12">
                    <div class="h-0.5 bg-gradient-to-r from-transparent via-indigo-200 to-transparent mb-6 sm:mb-8"></div>
                    <div class="flex flex-col lg:flex-row justify-between items-stretch lg:items-center gap-4 sm:gap-5">
                        <a href="{{ route('materials.show', $material) }}" class="w-full lg:w-auto inline-flex items-center justify-center px-4 sm:px-6 py-2 sm:py-3 bg-indigo-50 text-indigo-500 border-2 border-indigo-200 font-semibold rounded-full transition-all duration-300 hover:bg-indigo-200 hover:text-indigo-600 hover:-translate-y-0.5 text-sm sm:text-base">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Materi
                        </a>
                        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                            <button type="button" class="w-full sm:w-auto inline-flex items-center justify-center px-4 sm:px-6 py-2 sm:py-3 bg-white text-indigo-500 border-2 border-indigo-500 font-semibold rounded-full transition-all duration-300 hover:bg-indigo-500 hover:text-white text-sm sm:text-base" onclick="previewQuiz()">
                                <i class="fas fa-eye mr-2"></i>Preview
                            </button>
                            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-4 sm:px-6 py-2 sm:py-3 bg-gradient-to-br from-indigo-500 to-purple-600 text-white font-semibold rounded-full transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-indigo-500/40 text-sm sm:text-base">
                                <i class="fas fa-save mr-2"></i>Simpan Pre Test
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
        <div class="bg-white border-2 border-indigo-50 rounded-xl sm:rounded-2xl overflow-hidden mb-4 sm:mb-6 transition-all duration-300 hover:border-indigo-200 hover:shadow-lg hover:shadow-indigo-500/15 hover:-translate-y-0.5 opacity-0 translate-y-5" data-question="${questionCount}">
            <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 p-3 sm:p-4 md:p-5 flex flex-col sm:flex-row items-center gap-3 sm:gap-4">
                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 text-white w-10 sm:w-12 h-10 sm:h-12 rounded-full flex items-center justify-center font-bold relative flex-shrink-0">
                    <i class="fas fa-question absolute text-xs top-1 sm:top-2"></i>
                    <span class="text-base sm:text-lg mt-1">${questionCount}</span>
                </div>
                <div class="flex-1 text-center sm:text-left">
                    <h6 class="m-0 text-gray-800 text-base sm:text-lg font-semibold">Pertanyaan ${questionCount}</h6>
                </div>
                <button type="button" class="bg-red-500 text-white w-8 sm:w-10 h-8 sm:h-10 rounded-full flex items-center justify-center border-none cursor-pointer transition-all duration-300 hover:bg-red-400 hover:scale-110 remove-question flex-shrink-0" title="Hapus pertanyaan">
                    <i class="fas fa-trash text-xs sm:text-sm"></i>
                </button>
            </div>

            <div class="p-4 sm:p-5 md:p-6">
                <div class="mb-4 sm:mb-6">
                    <label class="block text-gray-800 font-semibold mb-2 text-sm sm:text-base">Teks Pertanyaan</label>
                    <textarea name="questions[${questionCount-1}][question]"
                              class="w-full p-3 sm:p-4 border-2 border-indigo-100 rounded-lg sm:rounded-xl text-sm sm:text-base transition-all duration-300 resize-y min-h-[80px] sm:min-h-[100px] font-inherit focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 focus:-translate-y-0.5" rows="3"
                              placeholder="Tuliskan pertanyaan Anda di sini..." required></textarea>
                </div>

                <div class="mb-4 sm:mb-6">
                    <label class="block text-gray-800 font-semibold mb-2 text-sm sm:text-base">Pilihan Jawaban</label>
                    <div class="flex flex-col gap-3 sm:gap-4">
                        ${generateOptionHtml('A', questionCount-1, 0)}
                        ${generateOptionHtml('B', questionCount-1, 1)}
                        ${generateOptionHtml('C', questionCount-1, 2)}
                        ${generateOptionHtml('D', questionCount-1, 3)}
                    </div>
                    <div class="mt-3 sm:mt-4 p-3 bg-blue-50 text-blue-600 rounded-lg text-xs sm:text-sm">
                        <i class="fas fa-info-circle mr-2"></i>Pilih radio button untuk menentukan jawaban yang benar
                    </div>
                </div>

                <div class="bg-indigo-50 p-3 sm:p-4 md:p-5 rounded-lg sm:rounded-xl border-2 border-indigo-100">
                    <label class="block text-gray-800 font-semibold mb-2 text-sm sm:text-base">Nilai Poin</label>
                    <select name="questions[${questionCount-1}][points]" class="w-full max-w-xs p-2 sm:p-3 border-2 border-indigo-100 rounded-lg text-sm sm:text-base bg-white transition-all duration-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
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

    // Add event listeners
    attachQuestionEventListeners();
    animateQuestionEntry();
}

function generateOptionHtml(letter, questionIndex, optionIndex) {
    return `
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 sm:gap-4 p-3 sm:p-4 bg-indigo-50 rounded-lg sm:rounded-xl border-2 border-transparent transition-all duration-300 hover:border-indigo-200 hover:bg-white">
            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 text-white w-8 sm:w-9 h-8 sm:h-9 rounded-full flex items-center justify-center font-bold text-sm flex-shrink-0">
                ${letter}
            </div>
            <input type="text" name="questions[${questionIndex}][options][]"
                   class="flex-1 w-full sm:flex-1 border border-indigo-200 rounded-lg p-2 sm:p-2.5 text-sm sm:text-base transition-all duration-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                   placeholder="Masukkan pilihan ${letter}" required>
            <label class="flex items-center gap-2 cursor-pointer text-xs sm:text-sm text-gray-600 flex-shrink-0">
                <input type="radio" name="questions[${questionIndex}][correct_answer]"
                       value="${optionIndex}" class="hidden" required>
                <span class="w-5 sm:w-6 h-5 sm:h-6 border-2 border-indigo-200 rounded-full flex items-center justify-center transition-all duration-300 bg-white flex-shrink-0">
                    <i class="fas fa-check text-xs text-white opacity-0 transition-all duration-300"></i>
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

    // Attach radio button listeners
    const radioInputs = document.querySelectorAll('input[type="radio"]');
    radioInputs.forEach(radio => {
        radio.addEventListener('change', function() {
            // Reset all radio customs in the same group
            const groupName = this.name;
            const groupRadios = document.querySelectorAll(`input[name="${groupName}"]`);
            groupRadios.forEach(r => {
                const custom = r.nextElementSibling;
                const icon = custom.querySelector('i');
                if (r === this) {
                    custom.classList.add('bg-gradient-to-br', 'from-indigo-500', 'to-purple-600', 'border-indigo-500');
                    custom.classList.remove('border-indigo-200');
                    icon.classList.remove('opacity-0');
                    icon.classList.add('opacity-100');
                } else {
                    custom.classList.remove('bg-gradient-to-br', 'from-indigo-500', 'to-purple-600', 'border-indigo-500');
                    custom.classList.add('border-indigo-200');
                    icon.classList.add('opacity-0');
                    icon.classList.remove('opacity-100');
                }
            });
        });
    });
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

        // Update visual number
        question.querySelector('span').textContent = questionNumber;
        question.querySelector('h6').textContent = `Pertanyaan ${questionNumber}`;

        // Update form names
        const textarea = question.querySelector('textarea');
        const inputs = question.querySelectorAll('input[type="text"]');
        const radios = question.querySelectorAll('input[type="radio"]');
        const select = question.querySelector('select');

        textarea.name = `questions[${questionNumber-1}][question]`;
        select.name = `questions[${questionNumber-1}][points]`;

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
});
</script>

<style>
/* Custom animations for icons that Tailwind doesn't cover */
@keyframes bounce {
    0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
    40% { transform: translateY(-5px); }
    60% { transform: translateY(-3px); }
}

.animate-bounce-custom {
    animation: bounce 2s infinite;
}

/* Custom scrollbar styling */
.questions-container::-webkit-scrollbar {
    width: 8px;
}

.questions-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.questions-container::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 4px;
}

.questions-container::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
}

/* Loading state */
.loading {
    opacity: 0.7;
    pointer-events: none;
    position: relative;
}

.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin: -10px 0 0 -10px;
    border: 2px solid #667eea;
    border-top-color: transparent;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Responsive improvements */
@media (max-width: 640px) {
    .max-w-7xl {
        max-width: 100%;
    }

    /* Better text wrapping on small screens */
    .break-words {
        word-break: break-word;
        hyphens: auto;
    }

    /* Stack form elements better on mobile */
    .flex-col.lg\:flex-row > * {
        width: 100%;
    }

    /* Better button spacing on mobile */
    .flex.flex-col.sm\:flex-row.gap-3 {
        gap: 0.75rem;
    }

    /* Ensure full width buttons on very small screens */
    @media (max-width: 480px) {
        .w-full.sm\:w-auto {
            width: 100% !important;
        }
    }
}

@media (max-width: 768px) {
    /* Optimize spacing for tablet sizes */
    .gap-4.sm\:gap-5 {
        gap: 1rem;
    }

    /* Better form field sizing */
    .max-w-xs {
        max-width: 100%;
    }
}

/* Print styles */
@media print {
    .bg-gradient-to-br,
    .shadow-2xl,
    button,
    .hover\:shadow-lg,
    .hover\:-translate-y-0\.5 {
        display: none !important;
    }

    .bg-white {
        box-shadow: none !important;
        border: 1px solid #ccc !important;
    }

    [data-question] {
        break-inside: avoid;
        margin-bottom: 20px;
    }
}

/* Focus ring improvements for accessibility */
.focus\:ring-4:focus {
    --tw-ring-offset-shadow: 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
    --tw-ring-shadow: 0 0 0 calc(4px + var(--tw-ring-offset-width)) var(--tw-ring-color);
    box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
}

/* Custom disabled states */
button:disabled {
    opacity: 0.6 !important;
    cursor: not-allowed !important;
    transform: none !important;
}

input:disabled,
textarea:disabled,
select:disabled {
    background-color: #f7fafc !important;
    color: #a0aec0 !important;
    cursor: not-allowed !important;
}

/* Touch-friendly improvements for mobile */
@media (hover: none) {
    .hover\:-translate-y-0\.5:hover {
        transform: none;
    }

    .hover\:scale-110:hover {
        transform: scale(1.05);
    }
}

/* Improve tap targets for mobile */
@media (max-width: 768px) {
    button,
    input[type="radio"] + span,
    .cursor-pointer {
        min-height: 44px;
        min-width: 44px;
    }

    /* Better spacing for mobile form elements */
    .p-3.sm\:p-4 {
        padding: 1rem;
    }
}
</style>
@endsection
