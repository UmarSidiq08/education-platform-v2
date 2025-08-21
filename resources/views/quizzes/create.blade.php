@extends('layouts.app')

@section('title', 'Tambah Kuis - ' . $material->title)

@section('content')
<div class="container">
    <!-- Hero Section -->
    <div class="hero-banner">
        <div class="hero-content">
            <h2><i class="fas fa-magic"></i>Buat Kuis Baru</h2>
            <p>Untuk materi: <strong>{{ $material->title }}</strong></p>
        </div>
        <div class="hero-decoration"></div>
    </div>

    <!-- Main Form Card -->
    <div class="main-card">
        <div class="card-header">
            <div class="header-content">
                <h4><i class="fas fa-plus-circle bounce-icon"></i>Formulir Kuis</h4>
                <div class="status-badge">
                    <i class="fas fa-book-open"></i>{{ $material->title }}
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('quizzes.store', $material) }}" method="POST" id="quiz-form">
                @csrf

                <!-- Basic Info Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h5 class="section-title">
                            <i class="fas fa-info-circle"></i>Informasi Dasar
                        </h5>
                        <div class="section-line"></div>
                    </div>

                    <div class="form-row">
                        <div class="form-col-8">
                            <label for="title" class="form-label">Judul Kuis</label>
                            <div class="input-wrapper">
                                <i class="fas fa-heading input-icon"></i>
                                <input type="text" class="form-input @error('title') error @enderror"
                                       id="title" name="title" value="{{ old('title') }}"
                                       placeholder="Masukkan judul kuis yang menarik" required>
                                @error('title')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-col-4">
                            <label for="time_limit" class="form-label">Waktu Pengerjaan</label>
                            <div class="input-wrapper">
                                <i class="fas fa-clock input-icon"></i>
                                <input type="number" class="form-input @error('time_limit') error @enderror"
                                       id="time_limit" name="time_limit" value="{{ old('time_limit', 30) }}"
                                       min="1" required>
                                <span class="input-suffix">menit</span>
                                @error('time_limit')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">
                            Deskripsi Kuis <span class="optional">(opsional)</span>
                        </label>
                        <textarea class="form-textarea @error('description') error @enderror"
                                  id="description" name="description" rows="4"
                                  placeholder="Tambahkan deskripsi kuis, petunjuk pengerjaan, atau informasi penting lainnya...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                        <div class="form-help">
                            <i class="fas fa-lightbulb"></i>Deskripsi akan ditampilkan kepada peserta sebelum memulai kuis
                        </div>
                    </div>
                </div>

                <!-- Questions Section -->
                <div class="form-section">
                    <div class="section-header">
                        <div class="section-header-flex">
                            <div class="section-info">
                                <h5 class="section-title">
                                    <i class="fas fa-question-circle"></i>Daftar Pertanyaan
                                </h5>
                                <p class="section-subtitle">Minimal 1 pertanyaan diperlukan untuk membuat kuis</p>
                            </div>
                            <button type="button" class="btn btn-add" id="add-question">
                                <i class="fas fa-plus"></i>Tambah Pertanyaan
                            </button>
                        </div>
                        <div class="section-line"></div>
                    </div>

                    <div id="questions-container" class="questions-list">
                        <!-- Questions will be added here via JavaScript -->
                    </div>

                    <div id="empty-state" class="empty-state hidden">
                        <i class="fas fa-question-circle"></i>
                        <h6>Belum ada pertanyaan</h6>
                        <p>Klik tombol "Tambah Pertanyaan" untuk memulai</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="form-actions">
                    <div class="actions-border"></div>
                    <div class="actions-flex">
                        <a href="{{ route('materials.show', $material) }}" class="btn btn-back">
                            <i class="fas fa-arrow-left"></i>Kembali ke Materi
                        </a>
                        <div class="actions-right">
                            <button type="button" class="btn btn-preview" onclick="previewQuiz()">
                                <i class="fas fa-eye"></i>Preview
                            </button>
                            <button type="submit" class="btn btn-save">
                                <i class="fas fa-save"></i>Simpan Kuis
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
        <div class="question-card" data-question="${questionCount}">
            <div class="question-header">
                <div class="question-number">
                    <i class="fas fa-question"></i>
                    <span class="number">${questionCount}</span>
                </div>
                <div class="question-title">
                    <h6>Pertanyaan ${questionCount}</h6>
                </div>
                <button type="button" class="btn-remove remove-question" title="Hapus pertanyaan">
                    <i class="fas fa-trash"></i>
                </button>
            </div>

            <div class="question-body">
                <div class="form-group">
                    <label class="form-label">Teks Pertanyaan</label>
                    <textarea name="questions[${questionCount-1}][question]"
                              class="form-textarea question-text" rows="3"
                              placeholder="Tuliskan pertanyaan Anda di sini..." required></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Pilihan Jawaban</label>
                    <div class="options-container">
                        ${generateOptionHtml('A', questionCount-1, 0)}
                        ${generateOptionHtml('B', questionCount-1, 1)}
                        ${generateOptionHtml('C', questionCount-1, 2)}
                        ${generateOptionHtml('D', questionCount-1, 3)}
                    </div>
                    <div class="answer-help">
                        <i class="fas fa-info-circle"></i>Pilih radio button untuk menentukan jawaban yang benar
                    </div>
                </div>

                <div class="points-section">
                    <label class="form-label">Nilai Poin</label>
                    <select name="questions[${questionCount-1}][points]" class="form-select">
                        <option value="1" selected>1 Poin</option>
                        <option value="2">2 Poin</option>
                        <option value="3">3 Poin</option>
                        <option value="4">4 Poin</option>
                        <option value="5">5 Poin</option>
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
        <div class="option-item">
            <div class="option-letter">${letter}</div>
            <input type="text" name="questions[${questionIndex}][options][]"
                   class="option-input"
                   placeholder="Masukkan pilihan ${letter}" required>
            <label class="correct-answer-radio">
                <input type="radio" name="questions[${questionIndex}][correct_answer]"
                       value="${optionIndex}" required>
                <span class="radio-custom">
                    <i class="fas fa-check"></i>
                </span>
                <span class="radio-label">Benar</span>
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
        question.querySelector('.number').textContent = questionNumber;
        question.querySelector('.question-title h6').textContent = `Pertanyaan ${questionNumber}`;

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

    alert(`Preview Kuis:\n\nJudul: ${title}\nWaktu: ${timeLimit} menit\nDeskripsi: ${description || 'Tidak ada'}\nJumlah Pertanyaan: ${questions}`);
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    addQuestion();
    updateEmptyState();
});
</script>

<style>
/* Reset & Base Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
}

/* Container */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* Hero Section */
.hero-banner {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 40px 30px;
    text-align: center;
    margin-bottom: 30px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.hero-content {
    position: relative;
    z-index: 2;
}

.hero-banner h2 {
    color: white;
    font-size: 2.2rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.hero-banner p {
    color: rgba(255, 255, 255, 0.8);
    font-size: 1.1rem;
}

.hero-decoration {
    position: absolute;
    top: -50px;
    right: -50px;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    z-index: 1;
}

.hero-decoration::before {
    content: '';
    position: absolute;
    top: 50px;
    left: 50px;
    width: 100px;
    height: 100px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}

/* Main Card */
.main-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 25px 30px;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header-content h4 {
    color: white;
    font-size: 1.5rem;
    font-weight: 600;
    margin: 0;
}

.bounce-icon {
    animation: bounce 2s infinite;
    margin-right: 10px;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
    40% { transform: translateY(-5px); }
    60% { transform: translateY(-3px); }
}

.status-badge {
    background: rgba(255, 255, 255, 0.2);
    padding: 8px 16px;
    border-radius: 20px;
    color: white;
    font-size: 0.9rem;
    backdrop-filter: blur(10px);
}

.status-badge i {
    margin-right: 8px;
}

/* Card Body */
.card-body {
    padding: 40px;
}

/* Form Sections */
.form-section {
    margin-bottom: 50px;
}

.section-header {
    margin-bottom: 30px;
}

.section-header-flex {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 20px;
}

.section-info {
    flex: 1;
}

.section-title {
    color: #4c63d2;
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 5px;
}

.section-title i {
    margin-right: 10px;
}

.section-subtitle {
    color: #6c757d;
    font-size: 0.9rem;
    margin: 0;
}

.section-line {
    height: 3px;
    background: linear-gradient(90deg, #667eea, #764ba2, transparent);
    border-radius: 2px;
}

/* Form Elements */
.form-row {
    display: flex;
    gap: 20px;
    margin-bottom: 25px;
}

.form-col-8 {
    flex: 2;
}

.form-col-4 {
    flex: 1;
}

.form-group {
    margin-bottom: 25px;
}

.form-label {
    display: block;
    color: #2d3748;
    font-weight: 600;
    margin-bottom: 8px;
    font-size: 0.95rem;
}

.optional {
    color: #6c757d;
    font-weight: 400;
}

/* Input Wrapper */
.input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.input-icon {
    position: absolute;
    left: 15px;
    color: #667eea;
    z-index: 3;
    font-size: 16px;
}

.form-input {
    width: 100%;
    padding: 15px 15px 15px 45px;
    border: 2px solid #e1e8ff;
    border-radius: 12px;
    font-size: 16px;
    transition: all 0.3s ease;
    background: white;
}

.form-input:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    outline: none;
}

.form-input.error {
    border-color: #e53e3e;
}

.input-suffix {
    position: absolute;
    right: 15px;
    color: #6c757d;
    font-size: 14px;
    z-index: 3;
}

.form-textarea {
    width: 100%;
    padding: 15px;
    border: 2px solid #e1e8ff;
    border-radius: 12px;
    font-size: 16px;
    transition: all 0.3s ease;
    resize: vertical;
    min-height: 120px;
    font-family: inherit;
}

.form-textarea:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    outline: none;
}

.form-textarea.error {
    border-color: #e53e3e;
}

.form-select {
    width: 100%;
    max-width: 150px;
    padding: 12px 15px;
    border: 2px solid #e1e8ff;
    border-radius: 8px;
    font-size: 15px;
    background: white;
    transition: all 0.3s ease;
}

.form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.1);
    outline: none;
}

.form-help {
    margin-top: 8px;
    font-size: 13px;
    color: #6c757d;
}

.form-help i {
    margin-right: 5px;
}

.error-message {
    color: #e53e3e;
    font-size: 0.85rem;
    margin-top: 5px;
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    padding: 12px 24px;
    border: none;
    border-radius: 25px;
    font-size: 16px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn i {
    margin-right: 8px;
}

.btn-add {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.btn-add:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
}

.btn-back {
    background: #f8f9ff;
    color: #667eea;
    border: 2px solid #e1e8ff;
}

.btn-back:hover {
    background: #e1e8ff;
    color: #4c63d2;
    transform: translateY(-1px);
}

.btn-preview {
    background: white;
    color: #667eea;
    border: 2px solid #667eea;
}

.btn-preview:hover {
    background: #667eea;
    color: white;
}

.btn-save {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.btn-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
}

.btn-remove {
    background: #ff6b6b;
    color: white;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-remove:hover {
    background: #ff5252;
    transform: scale(1.1);
}

/* Questions */
.questions-list {
    min-height: 100px;
}

.question-card {
    background: white;
    border: 2px solid #f0f4ff;
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 25px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(102, 126, 234, 0.05);
}

.question-card:hover {
    border-color: #e1e8ff;
    box-shadow: 0 8px 30px rgba(102, 126, 234, 0.15);
    transform: translateY(-2px);
}

.question-header {
    background: linear-gradient(135deg, #f8f9ff 0%, #e1e8ff 100%);
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.question-number {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    position: relative;
    flex-shrink: 0;
}

.question-number .fas {
    position: absolute;
    font-size: 12px;
    top: 8px;
}

.question-number .number {
    font-size: 18px;
    margin-top: 5px;
}

.question-title {
    flex: 1;
}

.question-title h6 {
    margin: 0;
    color: #2d3748;
    font-size: 1.1rem;
    font-weight: 600;
}

.question-body {
    padding: 25px;
}

.question-text {
    min-height: 100px;
}

/* Options */
.options-container {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.option-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    background: #f8f9ff;
    border-radius: 12px;
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.option-item:hover {
    border-color: #e1e8ff;
    background: white;
}

.option-letter {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 14px;
    flex-shrink: 0;
}

.option-input {
    flex: 1;
    border: 1px solid #e1e8ff;
    border-radius: 8px;
    padding: 10px 15px;
    font-size: 15px;
    transition: all 0.3s ease;
}

.option-input:focus {
    border-color: #667eea;
    outline: none;
    box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.1);
}

.correct-answer-radio {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    font-size: 14px;
    color: #6c757d;
}

.correct-answer-radio input[type="radio"] {
    display: none;
}

.radio-custom {
    width: 24px;
    height: 24px;
    border: 2px solid #e1e8ff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    background: white;
    flex-shrink: 0;
}

.radio-custom i {
    font-size: 12px;
    color: white;
    opacity: 0;
    transition: all 0.3s ease;
}

.correct-answer-radio input[type="radio"]:checked + .radio-custom {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: #667eea;
}

.correct-answer-radio input[type="radio"]:checked + .radio-custom i {
    opacity: 1;
}

.radio-label {
    white-space: nowrap;
}

.answer-help {
    margin-top: 15px;
    padding: 12px 16px;
    background: #e3f2fd;
    color: #1976d2;
    border-radius: 8px;
    font-size: 13px;
}

.answer-help i {
    margin-right: 8px;
}

/* Points Section */
.points-section {
    background: #f8f9ff;
    padding: 20px;
    border-radius: 12px;
    border: 2px solid #e1e8ff;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 50px 20px;
    color: #6c757d;
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 20px;
    opacity: 0.5;
}

.empty-state h6 {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 10px;
}

.empty-state p {
    margin: 0;
}

.hidden {
    display: none;
}

/* Form Actions */
.form-actions {
    margin-top: 50px;
}

.actions-border {
    height: 2px;
    background: linear-gradient(90deg, transparent, #e1e8ff, transparent);
    margin-bottom: 30px;
}

.actions-flex {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.actions-right {
    display: flex;
    gap: 15px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        padding: 15px;
    }

    .hero-banner {
        padding: 30px 20px;
    }

    .hero-banner h2 {
        font-size: 1.8rem;
    }

    .card-body {
        padding: 25px;
    }

    .form-row {
        flex-direction: column;
        gap: 15px;
    }

    .form-col-8,
    .form-col-4 {
        flex: 1;
    }

    .section-header-flex {
        flex-direction: column;
        align-items: stretch;
        gap: 20px;
    }

    .question-header {
        flex-direction: column;
        text-align: center;
        gap: 10px;
    }

    .option-item {
        flex-direction: column;
        gap: 10px;
        text-align: center;
    }

    .actions-flex {
        flex-direction: column;
        gap: 20px;
        align-items: stretch;
    }

    .actions-right {
        flex-direction: column;
        gap: 10px;
    }

    .btn {
        width: 100%;
        justify-content: center;
    }

    .header-content {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }

    .input-wrapper {
        flex-direction: column;
        align-items: stretch;
    }

    .input-suffix {
        position: static;
        text-align: center;
        margin-top: 5px;
        font-size: 12px;
    }
}

@media (max-width: 480px) {
    .hero-banner h2 {
        font-size: 1.5rem;
    }

    .card-body {
        padding: 20px;
    }

    .question-body {
        padding: 20px;
    }

    .section-title {
        font-size: 1.1rem;
    }

    .form-input,
    .form-textarea {
        font-size: 14px;
    }

    .btn {
        padding: 10px 20px;
        font-size: 14px;
    }
}

/* Animation Classes */
.fade-in {
    animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.slide-out {
    animation: slideOut 0.3s ease-out;
}

@keyframes slideOut {
    from {
        opacity: 1;
        transform: translateX(0);
    }
    to {
        opacity: 0;
        transform: translateX(100px);
    }
}

/* Focus States */
.form-input:focus,
.form-textarea:focus,
.form-select:focus,
.option-input:focus {
    transform: translateY(-1px);
}

/* Loading State */
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
    to {
        transform: rotate(360deg);
    }
}

/* Custom Scrollbar */
.questions-list::-webkit-scrollbar {
    width: 8px;
}

.questions-list::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.questions-list::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 4px;
}

.questions-list::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
}

/* Hover Effects */
.btn:hover {
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.question-card:hover .question-number {
    transform: scale(1.05);
}

.option-item:hover .option-letter {
    transform: scale(1.1);
}

/* Success States */
.form-input.success {
    border-color: #48bb78;
    background-color: #f0fff4;
}

.form-textarea.success {
    border-color: #48bb78;
    background-color: #f0fff4;
}

/* Disabled States */
.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none !important;
}

.form-input:disabled,
.form-textarea:disabled,
.form-select:disabled {
    background-color: #f7fafc;
    color: #a0aec0;
    cursor: not-allowed;
}

/* Print Styles */
@media print {
    .hero-banner,
    .btn,
    .form-actions {
        display: none;
    }

    .main-card {
        box-shadow: none;
        border: 1px solid #ccc;
    }

    .question-card {
        break-inside: avoid;
        margin-bottom: 20px;
    }
}
</style>
@endsection
