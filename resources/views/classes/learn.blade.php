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

        /* Progress Bar Styles */
        .progress-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1.5rem;
            border-radius: 1rem;
            margin-bottom: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .progress-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.1) 50%, rgba(255, 255, 255, 0.1) 75%, transparent 75%, transparent);
            background-size: 20px 20px;
            animation: move 1s linear infinite;
        }

        @keyframes move {
            0% {
                background-position: 0 0;
            }

            100% {
                background-position: 20px 20px;
            }
        }

        .progress-bar {
            background: linear-gradient(90deg, #10b981 0%, #059669 50%, #047857 100%);
            height: 12px;
            border-radius: 6px;
            transition: width 1s ease-in-out;
            position: relative;
            overflow: hidden;
        }

        .progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        .material-card.completed {
            border-left-color: #10b981 !important;
            background: linear-gradient(135deg, #ecfdf5 0%, #f0fdf4 100%);
        }

        .material-card.attempted {
            border-left-color: #f59e0b !important;
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
        }

        .material-card.completed .material-number {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        }

        .material-card.attempted .material-number {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
        }

        .completed-badge {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .attempted-badge {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }
    </style>

    <div class="bg-main-gradient min-h-screen -mx-4 -mt-5 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto px-8 py-8 font-sans">
            <!-- Header Section -->
            <div
                class="relative mb-12 p-8 bg-gradient-to-br from-indigo-600 to-purple-700 rounded-2xl text-white overflow-hidden">
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

                <!-- Decorative circles -->
                <div class="absolute top-0 right-0 w-full h-full overflow-hidden pointer-events-none">
                    <div class="absolute -top-12 -right-12 w-48 h-48 bg-white bg-opacity-10 rounded-full"></div>
                    <div class="absolute top-1/2 right-24 w-36 h-36 bg-white bg-opacity-10 rounded-full"></div>
                    <div class="absolute -bottom-8 right-48 w-24 h-24 bg-white bg-opacity-10 rounded-full"></div>
                </div>
            </div>

            <!-- Card Container -->
            <div class="relative -mt-12 z-10">
                <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                    <!-- Content Section -->
                    <div class="p-8">
                        <!-- Progress Section -->
                        @if ($totalMaterials > 0 && auth()->user()->role === 'siswa')
                            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6 rounded-xl mb-6 text-white">
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <h3 class="text-xl font-bold mb-1">Progress Belajar</h3>
                                        <p class="text-white/80">{{ $completedMaterials }} dari {{ $totalMaterials }} materi
                                            selesai (≥80%)</p>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-3xl font-bold">{{ $progressPercentage }}%</div>
                                        <div class="text-white/80 text-sm">Diselesaikan</div>
                                    </div>
                                </div>

                                <div class="bg-white/20 rounded-full h-3 mb-2">
                                    <div class="bg-gradient-to-r from-green-400 to-green-500 h-full rounded-full transition-all duration-1000 ease-out"
                                        style="width: {{ $progressPercentage }}%"></div>
                                </div>

                                @if ($progressPercentage == 100)
                                    <div class="flex items-center gap-2 text-green-200 font-semibold">
                                        <i class="fas fa-trophy"></i>
                                        <span>Selamat! Anda telah menyelesaikan semua materi dengan nilai ≥80%!</span>
                                    </div>
                                @elseif ($progressPercentage >= 75)
                                    <div class="flex items-center gap-2 text-yellow-200 font-semibold">
                                        <i class="fas fa-fire"></i>
                                        <span>Hampir selesai! Pastikan semua quiz mencapai nilai ≥80%!</span>
                                    </div>
                                @elseif ($progressPercentage >= 50)
                                    <div class="flex items-center gap-2 text-blue-200 font-semibold">
                                        <i class="fas fa-rocket"></i>
                                        <span>Kerja bagus! Jangan lupa nilai quiz minimal 80% untuk menyelesaikan
                                            materi!</span>
                                    </div>
                                @elseif ($progressPercentage > 0)
                                    <div class="flex items-center gap-2 text-purple-200 font-semibold">
                                        <i class="fas fa-seedling"></i>
                                        <span>Awal yang baik! Lanjutkan belajar dan capai nilai ≥80% untuk setiap
                                            quiz!</span>
                                    </div>
                                @else
                                    <div class="flex items-center gap-2 text-white/80 font-semibold">
                                        <i class="fas fa-play"></i>
                                        <span>Siap memulai? Capai nilai ≥80% di setiap quiz untuk menyelesaikan
                                            materi!</span>
                                    </div>
                                @endif
                            </div>
                        @endif



                        <!-- POST TEST SECTION -->
                        <!-- POST TEST SECTION -->
                        <!-- POST TEST SECTION -->
                        @if (auth()->user()->role === 'mentor' && auth()->id() === $class->mentor_id)
                            <div class="mb-8">
                                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl p-6 shadow-lg">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="text-xl font-bold text-white mb-2">
                                                <i class="fas fa-graduation-cap mr-3"></i>Post Test Management
                                            </h3>
                                            <p class="text-blue-100">Kelola post test untuk mengukur pemahaman siswa</p>
                                        </div>
                                        <a href="{{ route('post_tests.create', $class) }}"
                                            class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-blue-50 transition-all duration-300 hover:-translate-y-0.5 shadow-md">
                                            <i class="fas fa-plus mr-2"></i>Buat Post Test
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($class->activePostTest)
                            <div class="mb-8">
                                <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                                    <!-- Header -->
                                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="text-2xl font-bold text-white mb-2">
                                                    <i class="fas fa-graduation-cap mr-3"></i>Post Test Kelas
                                                </h4>
                                                <p class="text-indigo-100">Uji pemahaman Anda setelah menyelesaikan semua
                                                    materi</p>
                                            </div>
                                            <div class="text-white text-right">
                                                <div class="text-3xl font-bold">80%</div>
                                                <div class="text-indigo-200 text-sm">Nilai Minimum</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Content -->
                                    <div class="p-6">
                                        @php
                                            $postTest = $class->activePostTest;

                                            // HANYA HITUNG ATTEMPT ASLI (bukan approval request)
                                            $finishedAttempts = $postTest
                                                ->attempts()
                                                ->where('user_id', auth()->id())
                                                ->whereNotNull('finished_at')
                                                ->where(function ($query) {
                                                    $query
                                                        ->whereNull('requires_approval')
                                                        ->orWhere('requires_approval', false);
                                                })
                                                ->count();

                                            $pendingApproval = $postTest
                                                ->attempts()
                                                ->where('user_id', auth()->id())
                                                ->where('requires_approval', true)
                                                ->where('mentor_approved', false)
                                                ->exists();

                                            $approved = $postTest
                                                ->attempts()
                                                ->where('user_id', auth()->id())
                                                ->where('requires_approval', true)
                                                ->where('mentor_approved', true)
                                                ->exists();

                                            // HANYA AMBIL ATTEMPT ASLI TERAKHIR (bukan approval request)
                                            $lastAttempt = $postTest
                                                ->attempts()
                                                ->where('user_id', auth()->id())
                                                ->whereNotNull('finished_at')
                                                ->where(function ($query) {
                                                    $query
                                                        ->whereNull('requires_approval')
                                                        ->orWhere('requires_approval', false);
                                                })
                                                ->latest()
                                                ->first();

                                            $lastScore = $lastAttempt ? $lastAttempt->getPercentageAttribute() : 0;
                                            $hasPassed = $lastScore >= 80;
                                        @endphp
                                        @if (auth()->user()->role === 'mentor' && auth()->id() === $class->mentor_id)
                                            <!-- Mentor View -->
                                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                                <!-- Stats Cards -->
                                                <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                                                    <div class="flex items-center justify-between">
                                                        <div>
                                                            <p class="text-blue-600 font-semibold text-sm">Total Soal</p>
                                                            <p class="text-2xl font-bold text-blue-800">
                                                                {{ $postTest->questions->count() }}</p>
                                                        </div>
                                                        <div class="bg-blue-500 rounded-full p-3">
                                                            <i class="fas fa-question text-white"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                                                    <div class="flex items-center justify-between">
                                                        <div>
                                                            <p class="text-green-600 font-semibold text-sm">Durasi</p>
                                                            <p class="text-2xl font-bold text-green-800">
                                                                {{ $postTest->time_limit ?? 'Unlimited' }} min</p>
                                                        </div>
                                                        <div class="bg-green-500 rounded-full p-3">
                                                            <i class="fas fa-clock text-white"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="bg-purple-50 rounded-lg p-4 border border-purple-200">
                                                    <div class="flex items-center justify-between">
                                                        <div>
                                                            <p class="text-purple-600 font-semibold text-sm">Passing Score
                                                            </p>
                                                            <p class="text-2xl font-bold text-purple-800">80%</p>
                                                        </div>
                                                        <div class="bg-purple-500 rounded-full p-3">
                                                            <i class="fas fa-trophy text-white"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-6">
                                                <a href="{{ route('post_tests.edit', [$class, $postTest]) }}"
                                                    class="inline-block bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-8 py-3 rounded-lg font-semibold hover:from-indigo-600 hover:to-purple-700 transition-all duration-300 hover:-translate-y-0.5 shadow-lg">
                                                    <i class="fas fa-edit mr-2"></i> Edit Post Test
                                                </a>
                                            </div>
                                        @elseif(auth()->user()->role === 'siswa')
                                            @if ($progressPercentage == 100)
                                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                                    <!-- Status Card -->
                                                    <div class="space-y-4">
                                                        <!-- Attempt Status -->
                                                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                                            <div class="flex items-center justify-between mb-3">
                                                                <h5 class="font-semibold text-gray-800">Status Attempt</h5>
                                                                <span
                                                                    class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                                                                    {{ $finishedAttempts }}/2 Percobaan
                                                                </span>
                                                            </div>

                                                            @if ($lastAttempt)
                                                                <div class="space-y-2">
                                                                    <div class="flex justify-between items-center">
                                                                        <span class="text-gray-600">Nilai Terakhir:</span>
                                                                        <span
                                                                            class="font-bold text-lg {{ $hasPassed ? 'text-green-600' : 'text-red-600' }}">
                                                                            {{ $lastScore }}%
                                                                        </span>
                                                                    </div>
                                                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                                                        <div class="bg-gradient-to-r {{ $hasPassed ? 'from-green-400 to-green-600' : 'from-red-400 to-red-600' }} h-2 rounded-full transition-all duration-1000"
                                                                            style="width: {{ $lastScore }}%"></div>
                                                                    </div>
                                                                    <div class="flex justify-between text-xs text-gray-500">
                                                                        <span>0%</span>
                                                                        <span class="text-orange-600 font-medium">80%
                                                                            (Pass)</span>
                                                                        <span>100%</span>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <p class="text-gray-500 text-center py-4">
                                                                    <i class="fas fa-info-circle mr-2"></i>Belum ada
                                                                    percobaan
                                                                </p>
                                                            @endif
                                                        </div>

                                                        <!-- Instructions -->
                                                        <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                                                            <h5 class="font-semibold text-blue-800 mb-2">
                                                                <i class="fas fa-info-circle mr-2"></i>Informasi Penting
                                                            </h5>
                                                            <ul class="text-blue-700 text-sm space-y-1">
                                                                <li>• Nilai minimum untuk lulus adalah 80%</li>
                                                                <li>• Anda memiliki maksimal 2 percobaan</li>
                                                                <li>• Setelah 2 percobaan dengan nilai < 80%, perlu approval
                                                                        mentor</li>
                                                            </ul>
                                                        </div>
                                                    </div>

                                                    <!-- Action Card -->
                                                    <div class="flex flex-col justify-center">
                                                        @if ($hasPassed)
                                                            <!-- Already Passed -->
                                                            <div
                                                                class="text-center p-6 bg-green-50 rounded-lg border border-green-200">
                                                                <div class="text-5xl text-green-500 mb-4">
                                                                    <i class="fas fa-trophy"></i>
                                                                </div>
                                                                <h5 class="text-xl font-bold text-green-800 mb-2">Selamat!
                                                                </h5>
                                                                <p class="text-green-700 mb-4">
                                                                    Anda telah berhasil mencapai nilai passing score dengan
                                                                    {{ $lastScore }}%
                                                                </p>
                                                                <div
                                                                    class="bg-green-100 text-green-800 px-4 py-2 rounded-lg font-medium">
                                                                    Post Test Selesai
                                                                </div>
                                                            </div>
                                                        @else
                                                            <!-- Can Take Test -->
                                                            @if ($finishedAttempts < 2 || ($finishedAttempts >= 2 && $approved))
                                                                <div class="text-center p-6">
                                                                    <div class="text-5xl text-indigo-500 mb-4">
                                                                        <i class="fas fa-play-circle"></i>
                                                                    </div>
                                                                    <h5 class="text-xl font-bold text-gray-800 mb-2">
                                                                        @if ($finishedAttempts > 0)
                                                                            Coba Lagi Post Test
                                                                        @else
                                                                            Mulai Post Test
                                                                        @endif
                                                                    </h5>
                                                                    <p class="text-gray-600 mb-6">
                                                                        @if ($finishedAttempts > 0)
                                                                            Tingkatkan nilai Anda untuk mencapai 80%
                                                                        @else
                                                                            Uji pemahaman Anda terhadap materi yang telah
                                                                            dipelajari
                                                                        @endif
                                                                    </p>
                                                                    <a href="{{ route('post_tests.show', $class->activePostTest) }}"
                                                                        class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-8 py-3 rounded-lg font-semibold hover:from-indigo-600 hover:to-purple-700 transition-all duration-300 hover:-translate-y-0.5 shadow-lg">
                                                                        <i class="fas fa-eye mr-2"></i>
                                                                        @if ($finishedAttempts > 0)
                                                                            Attempt ke-{{ $finishedAttempts + 1 }}
                                                                        @else
                                                                            Mulai Sekarang
                                                                        @endif
                                                                    </a>


                                                                </div>
                                                            @endif

                                                            <!-- Approval Section -->
                                                            @if ($finishedAttempts >= 2 && !$approved)
                                                                <div
                                                                    class="p-6 bg-orange-50 rounded-lg border border-orange-200">
                                                                    @if ($pendingApproval)
                                                                        <div class="text-center">
                                                                            <div class="text-4xl text-orange-500 mb-4">
                                                                                <i class="fas fa-hourglass-half"></i>
                                                                            </div>
                                                                            <h5
                                                                                class="text-lg font-bold text-orange-800 mb-2">
                                                                                Menunggu Approval</h5>
                                                                            <p class="text-orange-700 mb-4">
                                                                                Permintaan Anda sedang menunggu persetujuan
                                                                                dari mentor
                                                                            </p>
                                                                            <div
                                                                                class="bg-orange-100 text-orange-800 px-4 py-2 rounded-lg font-medium">
                                                                                <i class="fas fa-clock mr-2"></i>Dalam
                                                                                Proses Review
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <div class="text-center">
                                                                            <div class="text-4xl text-orange-500 mb-4">
                                                                                <i class="fas fa-hand-paper"></i>
                                                                            </div>
                                                                            <h5
                                                                                class="text-lg font-bold text-orange-800 mb-2">
                                                                                Butuh Approval Mentor</h5>
                                                                            <p class="text-orange-700 mb-6">
                                                                                Anda telah menggunakan 2 percobaan dengan
                                                                                nilai di bawah 80%.
                                                                                Silakan minta approval dari mentor untuk
                                                                                percobaan tambahan.
                                                                            </p>
                                                                            <a href="{{ route('post_tests.request_approval.form', $postTest) }}"
                                                                                class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-6 py-3 rounded-lg font-semibold hover:from-orange-600 hover:to-red-600 transition-all duration-300 hover:-translate-y-0.5 shadow-lg">
                                                                                <i
                                                                                    class="fas fa-paper-plane mr-2"></i>Minta
                                                                                Approval
                                                                            </a>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            @else
                                                <!-- Progress Incomplete -->
                                                <div class="text-center p-8 bg-gray-50 rounded-lg border border-gray-200">
                                                    <div class="text-5xl text-gray-400 mb-4">
                                                        <i class="fas fa-lock"></i>
                                                    </div>
                                                    <h5 class="text-xl font-bold text-gray-700 mb-2">Post Test Terkunci
                                                    </h5>
                                                    <p class="text-gray-600 mb-6">
                                                        Selesaikan semua materi dengan nilai minimal 80% untuk membuka post
                                                        test
                                                    </p>
                                                    <div
                                                        class="bg-blue-100 text-blue-800 px-6 py-3 rounded-lg font-semibold inline-block">
                                                        Progress Anda: {{ $progressPercentage }}%
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @elseif(auth()->user()->role === 'mentor' && auth()->id() === $class->mentor_id)
                            <!-- No Post Test Yet - Mentor View -->
                            <div class="mb-8">
                                <div class="bg-white rounded-xl border-2 border-dashed border-gray-300 p-12 text-center">
                                    <div class="text-6xl text-gray-400 mb-6">
                                        <i class="fas fa-graduation-cap"></i>
                                    </div>
                                    <h5 class="text-2xl font-bold text-gray-700 mb-4">Belum Ada Post Test</h5>
                                    <p class="text-gray-500 text-lg mb-8 max-w-2xl mx-auto">
                                        Buat post test untuk menguji pemahaman siswa setelah mereka menyelesaikan semua
                                        materi pembelajaran.
                                        Post test akan membantu mengukur efektivitas pembelajaran.
                                    </p>
                                    <a href="{{ route('post_tests.create', [$class->id]) }}"
                                        class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-8 py-4 rounded-lg font-bold text-lg hover:from-indigo-600 hover:to-purple-700 transition-all duration-300 hover:-translate-y-0.5 shadow-lg">
                                        <i class="fas fa-plus mr-3"></i>Buat Post Test Sekarang
                                    </a>
                                </div>
                            </div>
                        @endif

                        @if ($class->materials->count() > 0)
                            <!-- Stats Bar -->
                            <div class="bg-gray-50 p-5 rounded-xl mb-6 border border-gray-200">
                                <div class="flex justify-center items-center gap-8 flex-wrap">
                                    <div class="flex items-center gap-2.5 text-gray-600 font-semibold">
                                        <div
                                            class="w-8 h-8 bg-stat-gradient rounded-full flex items-center justify-center text-white text-sm">
                                            <i class="fas fa-book"></i>
                                        </div>
                                        <span>{{ $class->materials->count() }} Materi Tersedia</span>
                                    </div>
                                    <div class="flex items-center gap-2.5 text-gray-600 font-semibold">
                                        <div
                                            class="w-8 h-8 bg-stat-gradient rounded-full flex items-center justify-center text-white text-sm">
                                            <i class="fas fa-user-tie"></i>
                                        </div>
                                        <span>Mentor: {{ $class->mentor->name ?? 'Unknown' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2.5 text-gray-600 font-semibold">
                                        <div
                                            class="w-8 h-8 bg-stat-gradient rounded-full flex items-center justify-center text-white text-sm">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <span>Terakhir Update: {{ $class->updated_at->format('d M Y') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Materials Grid -->
                            <div class="space-y-6">
                                @foreach ($class->materials as $index => $material)
                                    @php
                                        $activeQuiz = $material->quizzes->where('is_active', true)->first();
                                        $completionStatus = $activeQuiz
                                            ? $activeQuiz->getCompletionStatusByUser(auth()->id())
                                            : [
                                                'attempted' => false,
                                                'completed' => false,
                                                'passed' => false,
                                                'score' => 0,
                                                'percentage' => 0,
                                                'status' => 'not_attempted',
                                            ];
                                    @endphp

                                    <div
                                        class="material-card bg-white border border-gray-200 rounded-xl p-5 transition-all duration-300 border-l-4 border-l-indigo-600 shadow-sm hover:-translate-y-0.5 hover:shadow-lg hover:border-l-green-500
                                        {{ $completionStatus['completed'] ? 'completed' : ($completionStatus['attempted'] ? 'attempted' : '') }}">
                                        <div class="flex flex-col lg:flex-row justify-between items-start gap-5">
                                            <div class="flex-1">
                                                <h3
                                                    class="text-xl font-semibold text-gray-800 m-0 mb-2 flex items-center gap-2.5">
                                                    <div
                                                        class="material-number w-9 h-9 bg-material-gradient rounded-lg flex items-center justify-center text-white flex-shrink-0">
                                                        @if ($completionStatus['completed'])
                                                            <i class="fas fa-check"></i>
                                                        @elseif ($completionStatus['attempted'])
                                                            <i class="fas fa-exclamation"></i>
                                                        @else
                                                            {{ $index + 1 }}
                                                        @endif
                                                    </div>
                                                    {{ $material->title }}
                                                    @if ($completionStatus['completed'])
                                                        <span class="completed-badge">
                                                            <i class="fas fa-trophy"></i>
                                                            Selesai ({{ $completionStatus['percentage'] }}%)
                                                        </span>
                                                    @elseif ($completionStatus['attempted'])
                                                        <span class="attempted-badge">
                                                            <i class="fas fa-redo"></i>
                                                            Coba Lagi ({{ $completionStatus['percentage'] }}%)
                                                        </span>
                                                    @endif
                                                </h3>

                                                @if ($material->description)
                                                    <p class="text-gray-600 leading-relaxed m-0 mb-3 text-base">
                                                        {{ $material->description }}
                                                    </p>
                                                @endif

                                                <div class="flex items-center gap-4 text-gray-500 text-sm">
                                                    <div class="flex items-center gap-1">
                                                        <i class="fas fa-calendar-alt"></i>
                                                        <span>Dibuat:
                                                            {{ $material->created_at->format('d M Y H:i') }}</span>
                                                    </div>

                                                    @if ($activeQuiz)
                                                        <div class="flex items-center gap-1">
                                                            <i class="fas fa-question-circle"></i>
                                                            <span>Quiz: {{ $activeQuiz->questions->count() }}
                                                                pertanyaan</span>
                                                        </div>

                                                        @if ($completionStatus['attempted'])
                                                            <div
                                                                class="flex items-center gap-1 {{ $completionStatus['completed'] ? 'text-green-600' : 'text-orange-600' }}">
                                                                <i class="fas fa-star"></i>
                                                                <span>Best: {{ $completionStatus['score'] }} poin
                                                                    ({{ $completionStatus['percentage'] }}%)
                                                                </span>
                                                            </div>
                                                        @endif

                                                        @if (!$completionStatus['completed'] && $completionStatus['attempted'])
                                                            <div class="flex items-center gap-1 text-red-600">
                                                                <i class="fas fa-info-circle"></i>
                                                                <span>Perlu ≥80% untuk selesai</span>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>

                                            <div
                                                class="flex flex-row gap-2 items-center flex-shrink-0 flex-wrap w-full lg:w-auto justify-center lg:justify-start">
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
                                                        <button
                                                            class="bg-red-500 text-white border-0 p-2 rounded-md font-semibold text-base transition-all duration-300 text-center inline-flex items-center justify-center w-9 h-9 min-w-9 hover:bg-red-600 hover:-translate-y-0.5"
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
                                                        <i class="fas fa-play"></i>
                                                        @if ($completionStatus['completed'])
                                                            Lihat Lagi
                                                        @elseif ($completionStatus['attempted'])
                                                            Ulangi Quiz
                                                        @else
                                                            Pelajari
                                                        @endif
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <!-- Empty State -->
                            <div
                                class="text-center py-16 px-8 bg-gray-50 rounded-xl border-2 border-dashed border-gray-300">
                                <div class="text-6xl text-gray-400 mb-6">
                                    <i class="fas fa-book-open"></i>
                                </div>
                                <h3 class="text-2xl font-semibold text-gray-600 mb-2">Belum Ada Materi</h3>
                                <p class="text-gray-500 text-lg">Belum ada materi yang tersedia untuk kelas ini. Silakan
                                    tunggu mentor menambahkan materi pembelajaran.</p>

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
            // Animate progress bar on load
            const progressBar = document.querySelector('.progress-bar');
            if (progressBar) {
                const targetWidth = progressBar.style.width;
                progressBar.style.width = '0%';
                setTimeout(() => {
                    progressBar.style.width = targetWidth;
                }, 500);
            }

            // Enhanced hover effects for buttons
            document.querySelectorAll('a, button').forEach(element => {
                element.addEventListener('mouseenter', function() {
                    if (this.classList.contains('hover:-translate-y-1') || this.classList.contains(
                            'hover:-translate-y-0.5')) {
                        this.style.transform = this.classList.contains('hover:-translate-y-1') ?
                            'translateY(-4px)' :
                            'translateY(-2px)';
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

            // Add celebration effect when progress is 100%
            const progressPercentage = {{ $progressPercentage }};
            if (progressPercentage === 100) {
                setTimeout(() => {
                    createConfetti();
                }, 1000);
            }
        });

        // Confetti animation for 100% completion
        function createConfetti() {
            const colors = ['#10b981', '#059669', '#047857', '#34d399', '#6ee7b7'];
            const confettiCount = 100;

            for (let i = 0; i < confettiCount; i++) {
                setTimeout(() => {
                    const confetti = document.createElement('div');
                    confetti.style.cssText = `
                        position: fixed;
                        width: 6px;
                        height: 6px;
                        background: ${colors[Math.floor(Math.random() * colors.length)]};
                        left: ${Math.random() * 100}vw;
                        top: -10px;
                        z-index: 9999;
                        border-radius: 50%;
                        pointer-events: none;
                        animation: confetti-fall 3s linear forwards;
                    `;

                    document.body.appendChild(confetti);

                    setTimeout(() => {
                        confetti.remove();
                    }, 3000);
                }, i * 20);
            }
        }

        // Add ripple animation CSS
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to { transform: scale(4); opacity: 0; }
            }

            @keyframes confetti-fall {
                0% {
                    transform: translateY(-10px) rotate(0deg);
                    opacity: 1;
                }
                100% {
                    transform: translateY(100vh) rotate(720deg);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);

        function showIncompleteAlert() {
            alert(
                'Anda harus menyelesaikan semua materi dengan nilai minimal 80% terlebih dahulu sebelum dapat mengerjakan post test!'
            );
        }
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

        @media (max-width: 768px) {
            .progress-container {
                padding: 1rem;
            }

            .progress-container .flex {
                flex-direction: column;
                text-align: center;
            }

            .progress-container .text-right {
                text-align: center;
                margin-top: 1rem;
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

            .completed-badge,
            .attempted-badge {
                font-size: 0.625rem;
                padding: 0.125rem 0.5rem;
            }
        }
    </style>
@endsection
