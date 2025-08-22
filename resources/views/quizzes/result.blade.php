@extends('layouts.app')

@section('title', 'Hasil Kuis: ' . $quiz->title)

@section('content')
    <div class="max-w-4xl mx-auto p-5 font-sans text-gray-800">
        <!-- Header Section -->
        <div
            class="bg-gradient-to-br from-purple-600 to-indigo-600 text-white p-8 rounded-xl mb-8 shadow-lg relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-600/90 to-indigo-600/90"></div>
            <div class="relative z-10 flex justify-between items-center flex-wrap">
                <div class="mb-5 md:mb-0">
                    <h1 class="text-3xl md:text-4xl font-bold mb-1">Hasil Kuis</h1>
                    <h2 class="text-xl md:text-2xl font-semibold mb-2">{{ $quiz->title }}</h2>
                    <p class="opacity-90 text-sm md:text-base">Materi: {{ $quiz->material->title }}</p>
                </div>
                <div class="flex items-center">
                    <div
                        class="w-20 h-20 md:w-24 md:h-24 rounded-full bg-white flex flex-col justify-center items-center shadow-lg">
                        <span
                            class="text-2xl md:text-3xl font-bold text-purple-600 leading-none">{{ $attempt->percentage }}%</span>
                        <span class="text-xs text-gray-600 mt-1">Skor Anda</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-xl p-4 md:p-5 flex items-center shadow-sm border border-gray-100">
                <div
                    class="w-10 h-10 rounded-full bg-purple-400 flex items-center justify-center mr-3 md:mr-4 text-white flex-shrink-0">
                    <i class="fas fa-star text-base md:text-lg"></i>
                </div>
                <div class="flex flex-col min-w-0">
                    <span class="text-lg md:text-xl font-bold leading-none text-gray-800">{{ $attempt->score }}</span>
                    <span class="text-xs text-gray-500 mt-1">Total Poin</span>
                </div>
            </div>

            <div class="bg-white rounded-xl p-4 md:p-5 flex items-center shadow-sm border border-gray-100">
                <div
                    class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center mr-3 md:mr-4 text-white flex-shrink-0">
                    <i class="fas fa-check-circle text-base md:text-lg"></i>
                </div>
                <div class="flex flex-col min-w-0">
                    <span
                        class="text-lg md:text-xl font-bold leading-none text-gray-800">{{ $attempt->correct_answers }}</span>
                    <span class="text-xs text-gray-500 mt-1">Jawaban Benar</span>
                </div>
            </div>

            <div class="bg-white rounded-xl p-4 md:p-5 flex items-center shadow-sm border border-gray-100">
                <div
                    class="w-10 h-10 rounded-full bg-pink-400 flex items-center justify-center mr-3 md:mr-4 text-white flex-shrink-0">
                    <i class="fas fa-times-circle text-base md:text-lg"></i>
                </div>
                <div class="flex flex-col min-w-0">
                    <span
                        class="text-lg md:text-xl font-bold leading-none text-gray-800">{{ $attempt->total_questions - $attempt->correct_answers }}</span>
                    <span class="text-xs text-gray-500 mt-1">Jawaban Salah</span>
                </div>
            </div>

            <div class="bg-white rounded-xl p-4 md:p-5 flex items-center shadow-sm border border-gray-100">
                <div
                    class="w-10 h-10 rounded-full bg-teal-400 flex items-center justify-center mr-3 md:mr-4 text-white flex-shrink-0">
                    <i class="fas fa-clock text-base md:text-lg"></i>
                </div>
                <div class="flex flex-col min-w-0">
                    <span
                        class="text-lg md:text-xl font-bold leading-none text-gray-800">{{ $attempt->duration ?? 'N/A' }}</span>
                    <span class="text-xs text-gray-500 mt-1">Waktu Pengerjaan</span>
                </div>
            </div>
        </div>

        <!-- Grade Badge -->
        <div class="text-center mb-8">
            @php
                $percentage = $attempt->percentage;
                if ($percentage >= 90) {
                    $grade = 'A';
                    $gradeClass = 'bg-gradient-to-r from-purple-500 to-purple-600';
                    $gradeText = 'Excellent!';
                } elseif ($percentage >= 80) {
                    $grade = 'B';
                    $gradeClass = 'bg-gradient-to-r from-blue-500 to-indigo-600';
                    $gradeText = 'Good Job!';
                } elseif ($percentage >= 70) {
                    $grade = 'C';
                    $gradeClass = 'bg-gradient-to-r from-teal-400 to-teal-600';
                    $gradeText = 'Not Bad!';
                } elseif ($percentage >= 60) {
                    $grade = 'D';
                    $gradeClass = 'bg-gradient-to-r from-orange-400 to-orange-600';
                    $gradeText = 'Needs Improvement';
                } else {
                    $grade = 'E';
                    $gradeClass = 'bg-gradient-to-r from-pink-400 to-pink-600';
                    $gradeText = 'Try Again';
                }
            @endphp
            <div
                class="inline-flex items-center px-6 py-3 rounded-full font-semibold shadow-lg {{ $gradeClass }} text-white transform hover:scale-105 transition-transform duration-200">
                <span class="text-xl md:text-2xl mr-3">Grade {{ $grade }}</span>
                <span class="text-sm md:text-base">{{ $gradeText }}</span>
            </div>
        </div>

        <!-- Performance Summary -->
        <div class="bg-white rounded-xl p-6 mb-8 shadow-sm border border-gray-100">
            <div class="flex items-center justify-center mb-8">
                <div class="text-center">
                    <div class="w-32 h-32 mx-auto mb-4 relative">
                        <!-- Circular Progress -->
                        <svg class="w-32 h-32 transform -rotate-90" viewBox="0 0 36 36">
                            <path class="text-gray-200" stroke="currentColor" stroke-width="2" fill="none"
                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                            <path class="text-purple-600" stroke="currentColor" stroke-width="2" fill="none"
                                stroke-dasharray="{{ $attempt->percentage }}, 100"
                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-gray-800">{{ $attempt->percentage }}%</div>
                                <div class="text-sm text-gray-500">Akurasi</div>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Ringkasan Performa</h3>
                    <p class="text-gray-600">Anda berhasil menjawab {{ $attempt->correct_answers }} dari
                        {{ $attempt->total_questions }} pertanyaan dengan benar</p>
                </div>
            </div>

            <!-- Performance Metrics -->
            <div class="grid grid-cols-3 gap-4">
                <div class="text-center p-4 bg-green-50 rounded-xl border border-green-200">
                    <div class="text-2xl font-bold text-green-600">{{ $attempt->correct_answers }}</div>
                    <div class="text-sm text-green-700 font-medium">Benar</div>
                </div>
                <div class="text-center p-4 bg-red-50 rounded-xl border border-red-200">
                    <div class="text-2xl font-bold text-red-600">
                        {{ $attempt->total_questions - $attempt->correct_answers }}</div>
                    <div class="text-sm text-red-700 font-medium">Salah</div>
                </div>
                <div class="text-center p-4 bg-blue-50 rounded-xl border border-blue-200">
                    <div class="text-2xl font-bold text-blue-600">{{ $attempt->total_questions }}</div>
                    <div class="text-sm text-blue-700 font-medium">Total Soal</div>
                </div>
            </div>
        </div>

        <!-- Feedback & Actions -->
        <div class="mb-8">
            @if ($attempt->percentage < 70)
                <div class="flex items-start p-5 bg-orange-50 rounded-xl mb-6 text-orange-800 border border-orange-200">
                    <i class="fas fa-book-open text-2xl mr-4 mt-1 flex-shrink-0"></i>
                    <div>
                        <h4 class="text-lg font-semibold mb-1">Tips untuk meningkatkan</h4>
                        <p class="text-sm mb-0">Nilai Anda masih di bawah 70%. Silakan pelajari kembali materi untuk
                            pemahaman yang lebih baik.</p>
                    </div>
                </div>
            @elseif($attempt->percentage >= 90)
                <div class="flex items-start p-5 bg-green-50 rounded-xl mb-6 text-green-800 border border-green-200">
                    <i class="fas fa-trophy text-2xl mr-4 mt-1 flex-shrink-0"></i>
                    <div>
                        <h4 class="text-lg font-semibold mb-1">Selamat!</h4>
                        <p class="text-sm mb-0">Nilai Anda sangat baik! Anda telah menguasai materi dengan baik.</p>
                    </div>
                </div>
            @endif

            <div class="text-center space-x-4">
                <a href="{{ route('materials.show', $quiz->material) }}"
                    class="inline-flex items-center px-6 py-3 bg-purple-600 text-white rounded-full font-semibold transition-all duration-300 hover:bg-purple-700 hover:-translate-y-1 hover:shadow-lg transform focus:outline-none focus:ring-4 focus:ring-purple-300">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Materi
                </a>

                @if ($attempt->percentage < 70)
               
                    <form action="{{ route('quizzes.start', $quiz) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-orange-600 text-white rounded-full font-semibold transition-all duration-300 hover:bg-orange-700 hover:-translate-y-1 hover:shadow-lg transform focus:outline-none focus:ring-4 focus:ring-orange-300">
                            <i class="fas fa-redo mr-2"></i> Coba Lagi
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <style>
        /* Custom gradients for grade badges */
        @media (prefers-color-scheme: dark) {
            .quiz-result-container {
                color-scheme: light;
            }
        }

        /* Additional responsive adjustments */
        @media (max-width: 640px) {
            .quiz-result-container {
                padding: 1rem;
            }
        }

        /* Circular progress animation */
        @keyframes progressFill {
            from {
                stroke-dasharray: 0, 100;
            }

            to {
                stroke-dasharray: var(--progress), 100;
            }
        }

        .progress-circle {
            animation: progressFill 2s ease-out 0.5s both;
        }

        /* Smooth transitions for interactive elements */
        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Focus states for accessibility */
        .focus\:ring-4:focus {
            box-shadow: 0 0 0 4px var(--tw-ring-color);
        }
    </style>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Animate stats cards on scroll
                const observerOptions = {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px'
                };

                const observer = new IntersectionObserver(function(entries) {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('animate-fade-in');
                        }
                    });
                }, observerOptions);

                // Observe stats cards
                document.querySelectorAll('.grid > div').forEach(card => {
                    observer.observe(card);
                });

                // Add smooth scroll behavior
                document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', function(e) {
                        e.preventDefault();
                        const target = document.querySelector(this.getAttribute('href'));
                        if (target) {
                            target.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
