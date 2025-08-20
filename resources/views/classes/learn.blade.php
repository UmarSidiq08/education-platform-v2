@extends('layouts.app')

@section('content')
    <style>
        /* Custom gradient classes untuk Tailwind */
        .bg-main-gradient {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        .bg-material-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .bg-quiz-gradient {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        }
        .bg-quiz-gradient:hover {
            background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
        }
        .bg-study-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .bg-study-gradient:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
        }
        .bg-stat-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>

    <div class="bg-main-gradient min-h-screen -mx-4 -mt-5 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto px-8 py-8 font-sans">
            <!-- Header Section - Updated to match other pages -->
            <div class="relative mb-12 p-8 bg-gradient-to-br from-indigo-600 to-purple-700 rounded-2xl text-white overflow-hidden">
                <div class="relative z-10">
                    <h1 class="text-4xl font-extrabold mb-2">
                        <i class="fas fa-graduation-cap me-3"></i>Belajar: {{ $class->name }}
                    </h1>
                    <p class="text-lg opacity-90 mb-6">Mulai perjalanan belajar Anda dan kembangkan kemampuan</p>

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('classes.show', $class->id) }}"
                           class="group inline-flex items-center gap-2 px-6 py-3 bg-white text-indigo-600 font-semibold rounded-lg transition-all duration-300 hover:bg-indigo-50 hover:-translate-y-1">
                            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                            <span>Kembali ke Detail Kelas</span>
                        </a>
                    </div>
                </div>

                <!-- Decorative circles - same as other pages -->
                <div class="absolute top-0 right-0 w-full h-full overflow-hidden pointer-events-none">
                    <div class="absolute -top-12 -right-12 w-48 h-48 bg-white bg-opacity-10 rounded-full"></div>
                    <div class="absolute top-1/2 right-24 w-36 h-36 bg-white bg-opacity-10 rounded-full"></div>
                    <div class="absolute -bottom-8 right-48 w-24 h-24 bg-white bg-opacity-10 rounded-full"></div>
                </div>
            </div>

            <!-- Card Container - Updated positioning -->
            <div class="relative -mt-12 z-10">
                <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                    <!-- Content Section -->
                    <div class="p-8">
                        <!-- POST TEST SECTION -->
                        @if (auth()->user()->role === 'mentor' && auth()->id() === $class->mentor_id)
                            <div class="mb-6">
                                <a href="{{ route('post_tests.create', $class) }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-2"></i>Buat Post Test
                                </a>
                            </div>
                        @endif

                        @if ($class->activePostTest)
                            <div class="bg-white border border-gray-200 rounded-xl mb-6 shadow-sm">
                                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                                    <h4 class="text-lg font-semibold text-gray-800 m-0">
                                        <i class="fas fa-graduation-cap me-2"></i>Post Test Kelas
                                    </h4>
                                </div>
                                <div class="p-6">
                                    <h5 class="text-xl font-semibold text-gray-800 mb-3">{{ $class->activePostTest->title }}</h5>
                                    <p class="text-gray-600 mb-4">{{ $class->activePostTest->description }}</p>
                                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <p class="text-gray-700 m-0">
                                                <i class="fas fa-clock me-2"></i>Waktu: {{ $class->activePostTest->time_limit }} menit
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-gray-700 m-0">
                                                <i class="fas fa-trophy me-2"></i>Nilai Kelulusan: {{ $class->activePostTest->passing_score }}%
                                            </p>
                                        </div>
                                    </div>

                                    @if (auth()->user()->role === 'mentor' && auth()->id() === $class->mentor_id)
                                        <a href="{{ route('post_tests.show', $class->activePostTest) }}"
                                            class="btn btn-info">
                                            <i class="fas fa-eye me-2"></i>Lihat Post Test
                                        </a>
                                    @elseif(auth()->user()->role === 'siswa')
                                        @php
                                            // HITUNG APAKAH SUDAH SELESAI SEMUA PRE TEST
                                            $hasCompletedAllPreTests = true;
                                            foreach ($class->materials as $material) {
                                                $activeQuiz = $material->quizzes()->where('is_active', true)->first();
                                                if ($activeQuiz && !$activeQuiz->isCompletedByUser(auth()->id())) {
                                                    $hasCompletedAllPreTests = false;
                                                    break;
                                                }
                                            }
                                        @endphp

                                        @if ($hasCompletedAllPreTests)
                                            <a href="{{ route('post_tests.show', $class->activePostTest) }}"
                                                class="btn btn-success">
                                                <i class="fas fa-play me-2"></i>Kerjakan Post Test
                                            </a>
                                        @else
                                            <button class="btn btn-secondary" disabled>
                                                <i class="fas fa-lock me-2"></i>Selesaikan Semua Pre Test Terlebih Dahulu
                                            </button>
                                            <p class="text-gray-500 mt-2 text-sm m-0">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Anda harus menyelesaikan semua kuis pre test di setiap materi sebelum dapat
                                                mengerjakan post test.
                                            </p>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @elseif(auth()->user()->role === 'mentor' && auth()->id() === $class->mentor_id)
                            <!-- TAMPILKAN JIKA MENTOR DAN BELUM ADA POST TEST -->
                            <div class="bg-white border border-gray-200 rounded-xl mb-6 shadow-sm">
                                <div class="p-12 text-center">
                                    <i class="fas fa-graduation-cap text-5xl text-gray-400 mb-4"></i>
                                    <h5 class="text-xl font-semibold text-gray-800 mb-2">Belum Ada Post Test</h5>
                                    <p class="text-gray-500 mb-4">Buat post test untuk menguji pemahaman siswa setelah menyelesaikan semua materi.</p>
                                    <a href="{{ route('post_tests.create', [$class->id]) }}"
                                    class="bg-study-gradient text-white border-0 px-5 py-3 rounded-lg font-semibold text-base transition-all duration-300 no-underline inline-flex items-center justify-center gap-2 text-center whitespace-nowrap hover:-translate-y-0.5"
                                    style="box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);">
                                    <i class="fas fa-plus me-2"></i>Buat Post Test
                                </a>
                                </div>
                            </div>
                        @endif

                        @if ($class->materials->count() > 0)
                            <!-- Stats Bar -->
                            <div class="bg-gray-50 p-5 rounded-xl mb-6 border border-gray-200">
                                <div class="flex justify-center items-center gap-8 flex-wrap">
                                    <div class="flex items-center gap-2.5 text-gray-600 font-semibold">
                                        <div class="w-8 h-8 bg-stat-gradient rounded-full flex items-center justify-center text-white text-sm">
                                            <i class="fas fa-book"></i>
                                        </div>
                                        <span>{{ $class->materials->count() }} Materi Tersedia</span>
                                    </div>
                                    <div class="flex items-center gap-2.5 text-gray-600 font-semibold">
                                        <div class="w-8 h-8 bg-stat-gradient rounded-full flex items-center justify-center text-white text-sm">
                                            <i class="fas fa-user-tie"></i>
                                        </div>
                                        <span>Mentor: {{ $class->mentor->name ?? 'Unknown' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2.5 text-gray-600 font-semibold">
                                        <div class="w-8 h-8 bg-stat-gradient rounded-full flex items-center justify-center text-white text-sm">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <span>Terakhir Update: {{ $class->updated_at->format('d M Y') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Materials Grid -->
                            <div class="space-y-6">
                                @foreach ($class->materials as $index => $material)
                                    <div class="bg-white border border-gray-200 rounded-xl p-5 transition-all duration-300 border-l-4 border-l-indigo-600 shadow-sm hover:-translate-y-0.5 hover:shadow-lg hover:border-l-green-500">
                                        <div class="flex flex-col lg:flex-row justify-between items-start gap-5">
                                            <div class="flex-1">
                                                <h3 class="text-xl font-semibold text-gray-800 m-0 mb-2 flex items-center gap-2.5">
                                                    <div class="w-9 h-9 bg-material-gradient rounded-lg flex items-center justify-center text-white flex-shrink-0">
                                                        {{ $index + 1 }}
                                                    </div>
                                                    {{ $material->title }}
                                                </h3>

                                                @if ($material->description)
                                                    <p class="text-gray-600 leading-relaxed m-0 mb-3 text-base">{{ $material->description }}</p>
                                                @endif

                                                <div class="flex items-center gap-2.5 text-gray-500 text-sm">
                                                    <i class="fas fa-calendar-alt"></i>
                                                    <span>Dibuat: {{ $material->created_at->format('d M Y H:i') }}</span>
                                                </div>
                                            </div>

                                            <div class="flex flex-row gap-2 items-center flex-shrink-0 flex-wrap w-full lg:w-auto justify-center lg:justify-start">
                                                @if (auth()->id() === $class->mentor_id && auth()->user()->role === 'mentor')
                                                    <a href="{{ route('materials.show', $material) }}"
                                                       class="btn btn-success">
                                                        <i class="fas fa-book-open me-2"></i>Buka Materi
                                                    </a>
                                                    <a href="{{ route('materials.edit', $material->id) }}"
                                                       class="bg-yellow-400 text-yellow-800 border-0 p-2 rounded-md font-semibold text-base transition-all duration-300 no-underline text-center inline-flex items-center justify-center w-9 h-9 min-w-9 hover:bg-yellow-300 hover:text-yellow-800 hover:-translate-y-0.5 hover:shadow-lg"
                                                       style="box-shadow: 0 2px 8px rgba(255, 215, 0, 0.3);"
                                                       title="Edit Materi">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('materials.destroy', $material->id) }}"
                                                          method="POST" class="inline-block"
                                                          onsubmit="return confirm('Yakin mau hapus materi ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="bg-red-500 text-white border-0 p-2 rounded-md font-semibold text-base transition-all duration-300 text-center inline-flex items-center justify-center w-9 h-9 min-w-9 hover:bg-red-600 hover:-translate-y-0.5"
                                                                style="box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);"
                                                                title="Hapus Materi">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    <a href="{{ route('quizzes.create', $material) }}"
                                                       class="bg-quiz-gradient text-white border-0 px-4 py-2.5 rounded-md font-semibold text-sm transition-all duration-300 no-underline text-center inline-flex items-center justify-center gap-1.5 whitespace-nowrap hover:-translate-y-0.5">
                                                        <i class="fas fa-question-circle"></i>Tambah Kuis
                                                    </a>
                                                @else
                                                    <a href="{{ route('materials.show', $material->id) }}"
                                                       class="bg-study-gradient text-white border-0 px-5 py-3 rounded-lg font-semibold text-base transition-all duration-300 no-underline inline-flex items-center justify-center gap-2 text-center whitespace-nowrap hover:-translate-y-0.5"
                                                       style="box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);">
                                                        <i class="fas fa-play"></i>Pelajari
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <!-- Empty State -->
                            <div class="text-center py-16 px-8 bg-gray-50 rounded-xl border-2 border-dashed border-gray-300">
                                <div class="text-6xl text-gray-400 mb-6">
                                    <i class="fas fa-book-open"></i>
                                </div>
                                <h3 class="text-2xl font-semibold text-gray-600 mb-2">Belum Ada Materi</h3>
                                <p class="text-gray-500 text-lg">Belum ada materi yang tersedia untuk kelas ini. Silakan tunggu mentor menambahkan materi pembelajaran.</p>

                                @if (auth()->id() === $class->mentor_id && auth()->user()->role === 'mentor')
                                    <div class="mt-4">
                                        <a href="{{ route('materials.create', [$class->id]) }}"
                                           class="bg-study-gradient text-white border-0 px-5 py-3 rounded-lg font-semibold text-base transition-all duration-300 no-underline inline-flex items-center justify-center gap-2 text-center whitespace-nowrap hover:-translate-y-0.5"
                                           style="box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);">
                                            <i class="fas fa-plus me-2"></i>Tambah Materi Pertama
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced JavaScript for better UX -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Enhanced hover effects for buttons
            document.querySelectorAll('a, button').forEach(element => {
                element.addEventListener('mouseenter', function() {
                    if (this.classList.contains('hover:-translate-y-1') || this.classList.contains('hover:-translate-y-0.5')) {
                        this.style.transform = this.classList.contains('hover:-translate-y-1')
                            ? 'translateY(-4px)'
                            : 'translateY(-2px)';
                    }
                });

                element.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Add ripple effect to buttons
            document.querySelectorAll('a, button').forEach(element => {
                element.addEventListener('click', function(e) {
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;

                    ripple.style.cssText = `
                        position: absolute;
                        width: ${size}px;
                        height: ${size}px;
                        left: ${x}px;
                        top: ${y}px;
                        background: rgba(255, 255, 255, 0.3);
                        border-radius: 50%;
                        transform: scale(0);
                        animation: ripple 0.6s ease-out;
                        pointer-events: none;
                    `;

                    this.style.position = 'relative';
                    this.style.overflow = 'hidden';
                    this.appendChild(ripple);

                    setTimeout(() => ripple.remove(), 600);
                });
            });

            // Smooth scroll animation for material cards
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe all material cards
            document.querySelectorAll('.space-y-6 > div').forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
                observer.observe(card);
            });
        });

        // Add ripple animation CSS
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to { transform: scale(4); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    </script>

    <!-- Responsive adjustments with Tailwind -->
    <style>
        @media (max-width: 1024px) {
            .max-w-7xl {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .px-8 {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .material-actions {
                justify-content: center !important;
                width: 100% !important;
            }

            .btn-edit,
            .btn-delete {
                width: 40px !important;
                height: 40px !important;
                min-width: 40px !important;
            }

            .btn-quiz,
            .btn-study {
                width: auto !important;
                min-width: 120px !important;
                padding: 10px 16px !important;
            }

            .stats-content {
                flex-direction: column !important;
                gap: 1rem !important;
            }
        }
    </style>
@endsection
