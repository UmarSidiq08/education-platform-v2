@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-graduation-cap me-2"></i>Buat Post Test Baru
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('post_tests.store', $class) }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="title" class="form-label">Judul Post Test *</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                       id="title" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description" name="description" rows="3">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="time_limit" class="form-label">Waktu Pengerjaan (menit) *</label>
                                <input type="number" class="form-control @error('time_limit') is-invalid @enderror"
                                       id="time_limit" name="time_limit" value="{{ old('time_limit', 30) }}" min="1" required>
                                @error('time_limit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="passing_score" class="form-label">Nilai Kelulusan (%) *</label>
                                <input type="number" class="form-control @error('passing_score') is-invalid @enderror"
                                       id="passing_score" name="passing_score" value="{{ old('passing_score', 70) }}" min="1" max="100" required>
                                @error('passing_score')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr>

                        <h5 class="mb-3">Pertanyaan Post Test</h5>

                        <div id="questions-container">
                            <!-- Pertanyaan akan ditambahkan di sini oleh JavaScript -->
                        </div>

                        <div class="mb-3">
                            <button type="button" class="btn btn-outline-primary" id="add-question">
                                <i class="fas fa-plus me-1"></i>Tambah Pertanyaan
                            </button>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('classes.show', $class->id) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Simpan Post Test
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Template untuk pertanyaan -->
<template id="question-template">
    <div class="question-card card mb-3">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h6 class="mb-0">Pertanyaan #<span class="question-number">1</span></h6>
            <button type="button" class="btn btn-sm btn-danger remove-question">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-12">
                    <label class="form-label">Pertanyaan *</label>
                    <textarea class="form-control question-text" name="questions[0][question]" rows="2" required></textarea>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Poin *</label>
                    <input type="number" class="form-control question-points" name="questions[0][points]" value="1" min="1" required>
                </div>
            </div>

            <div class="options-container">
                <label class="form-label">Pilihan Jawaban *</label>
                <div class="option-item mb-2">
                    <div class="input-group">
                        <span class="input-group-text">A</span>
                        <input type="text" class="form-control" name="questions[0][options][0]" required>
                        <span class="input-group-text">
                            <input type="radio" name="questions[0][correct_answer]" value="0" required>
                        </span>
                    </div>
                </div>
                <div class="option-item mb-2">
                    <div class="input-group">
                        <span class="input-group-text">B</span>
                        <input type="text" class="form-control" name="questions[0][options][1]" required>
                        <span class="input-group-text">
                            <input type="radio" name="questions[0][correct_answer]" value="1">
                        </span>
                    </div>
                </div>
            </div>

            <div class="mt-2">
                <button type="button" class="btn btn-sm btn-outline-secondary add-option">
                    <i class="fas fa-plus me-1"></i>Tambah Pilihan
                </button>
            </div>
        </div>
    </div>
</template>

<style>
.question-card {
    border: 1px solid #dee2e6;
}
.option-item .input-group-text {
    background-color: #f8f9fa;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let questionCount = 0;
    const questionsContainer = document.getElementById('questions-container');
    const questionTemplate = document.getElementById('question-template');
    const addQuestionBtn = document.getElementById('add-question');

    // Tambah pertanyaan pertama secara otomatis
    addQuestion();

    addQuestionBtn.addEventListener('click', addQuestion);

    function addQuestion() {
        const questionClone = questionTemplate.content.cloneNode(true);
        const questionElement = questionClone.querySelector('.question-card');

        // Update nomor pertanyaan
        const questionNumber = questionElement.querySelector('.question-number');
        questionNumber.textContent = questionCount + 1;

        // Update semua name attributes dengan index yang benar
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
                questionElement.remove();
                updateQuestionNumbers();
            } else {
                alert('Minimal harus ada 1 pertanyaan');
            }
        });

        // Handle tambah pilihan jawaban
        questionElement.querySelector('.add-option').addEventListener('click', function() {
            const optionsContainer = questionElement.querySelector('.options-container');
            const optionCount = optionsContainer.querySelectorAll('.option-item').length;

            if (optionCount >= 5) {
                alert('Maksimal 5 pilihan jawaban');
                return;
            }

            const optionLetter = String.fromCharCode(65 + optionCount);
            const newOption = document.createElement('div');
            newOption.className = 'option-item mb-2';
            newOption.innerHTML = `
                <div class="input-group">
                    <span class="input-group-text">${optionLetter}</span>
                    <input type="text" class="form-control" name="questions[${questionCount}][options][${optionCount}]" required>
                    <span class="input-group-text">
                        <input type="radio" name="questions[${questionCount}][correct_answer]" value="${optionCount}">
                    </span>
                </div>
            `;
            optionsContainer.appendChild(newOption);
        });

        questionsContainer.appendChild(questionElement);
        questionCount++;
    }

    function updateQuestionNumbers() {
        document.querySelectorAll('.question-card').forEach((card, index) => {
            card.querySelector('.question-number').textContent = index + 1;
        });
    }

    // Validasi form sebelum submit
    document.querySelector('form').addEventListener('submit', function(e) {
        const questionCards = document.querySelectorAll('.question-card');
        if (questionCards.length === 0) {
            e.preventDefault();
            alert('Minimal harus ada 1 pertanyaan');
            return;
        }

        // Validasi setiap pertanyaan
        let isValid = true;
        questionCards.forEach((card, index) => {
            const questionText = card.querySelector('.question-text').value.trim();
            const options = card.querySelectorAll('input[name^="questions[' + index + '][options]"]');
            const correctAnswer = card.querySelector('input[name="questions[' + index + '][correct_answer]"]:checked');

            if (!questionText) {
                isValid = false;
                card.querySelector('.question-text').classList.add('is-invalid');
            }

            if (!correctAnswer) {
                isValid = false;
                alert(`Pertanyaan #${index + 1} belum memiliki jawaban yang benar`);
            }
        });

        if (!isValid) {
            e.preventDefault();
        }
    });
});
</script>
@endsection
