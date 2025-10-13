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

        /* Enhanced Responsive Styles */
        @media (max-width: 1280px) {
            .max-w-7xl {
                max-width: 1024px;
            }
        }

        @media (max-width: 1024px) {
            .max-w-7xl {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .px-8 {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }

            /* Header adjustments */
            .header-section h1 {
                font-size: 2.5rem;
                line-height: 1.2;
            }

            .header-section p {
                font-size: 1rem;
            }
        }

        @media (max-width: 768px) {
            /* Main container adjustments */
            .bg-main-gradient {
                margin-left: -1rem;
                margin-right: -1rem;
                margin-top: -1.25rem;
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .max-w-7xl {
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }

            .px-8 {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            /* Header section */
            .header-section {
                padding: 1.5rem;
                margin-bottom: 2rem;
            }

            .header-section h1 {
                font-size: 2rem;
                margin-bottom: 0.5rem;
            }

            .header-section p {
                font-size: 0.875rem;
                margin-bottom: 1.5rem;
            }

            .header-section .flex {
                justify-content: center;
            }

            .header-section a {
                padding: 0.75rem 1.5rem;
                font-size: 0.875rem;
            }

            /* Progress container */
            .progress-container {
                padding: 1rem;
            }

            .progress-container .flex {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .progress-container .text-right {
                text-align: center;
                margin-top: 0;
            }

            .progress-container h3 {
                font-size: 1.25rem;
            }

            .progress-container .text-3xl {
                font-size: 2rem;
            }

            /* Stats bar responsive */
            .stats-bar {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }

            .stats-bar > div {
                justify-content: center;
                text-align: center;
            }

            /* Post test section responsive */
            .post-test-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .post-test-stats {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            /* Material card responsive */
            .material-card {
                padding: 1rem;
                border-left-width: 3px;
            }

            .material-card-content {
                flex-direction: column;
                gap: 1rem;
            }

            .material-header h3 {
                font-size: 1.125rem;
                flex-wrap: wrap;
                gap: 0.5rem 1rem;
            }

            .material-number {
                width: 2rem;
                height: 2rem;
            }

            .material-actions {
                flex-direction: row;
                justify-content: center;
                width: 100%;
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            .material-info {
                flex-direction: column;
                gap: 0.75rem;
                font-size: 0.75rem;
            }

            /* Badge responsive */
            .completed-badge,
            .attempted-badge {
                font-size: 0.625rem;
                padding: 0.125rem 0.5rem;
                white-space: nowrap;
            }

            /* Empty state responsive */
            .empty-state {
                padding: 2rem 1rem;
            }

            .empty-state .text-6xl {
                font-size: 3rem;
            }

            .empty-state h3 {
                font-size: 1.5rem;
            }

            .empty-state p {
                font-size: 1rem;
            }
        }

        @media (max-width: 640px) {
            /* Ultra small screens */
            .bg-main-gradient {
                margin-left: -1rem;
                margin-right: -1rem;
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }

            .max-w-7xl {
                padding-left: 0.25rem;
                padding-right: 0.25rem;
            }

            .px-8 {
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }

            /* Header ultra responsive */
            .header-section {
                padding: 1rem;
                margin-bottom: 1.5rem;
            }

            .header-section h1 {
                font-size: 1.5rem;
                text-align: center;
            }

            .header-section h1 i {
                display: block;
                margin-bottom: 0.5rem;
                margin-right: 0;
            }

            .header-section p {
                text-align: center;
                font-size: 0.8125rem;
            }

            .header-section a {
                width: 100%;
                padding: 1rem;
                justify-content: center;
                text-align: center;
            }

            /* Progress ultra responsive */
            .progress-container {
                padding: 0.75rem;
            }

            .progress-container .text-xl {
                font-size: 1.125rem;
            }

            .progress-container .text-3xl {
                font-size: 1.5rem;
            }

            /* Material card ultra responsive */
            .material-card {
                padding: 0.75rem;
            }

            .material-header h3 {
                font-size: 1rem;
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .material-title-row {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                width: 100%;
            }

            .material-badges {
                width: 100%;
            }

            .material-actions {
                gap: 0.25rem;
            }

            .btn-icon {
                width: 2.25rem !important;
                height: 2.25rem !important;
                min-width: 2.25rem !important;
                padding: 0.5rem !important;
                font-size: 0.75rem;
            }

            .btn-text {
                padding: 0.625rem 1rem !important;
                font-size: 0.75rem !important;
                min-width: auto !important;
            }

            /* Post test ultra responsive */
            .post-test-action {
                padding: 1rem;
            }

            .post-test-action .text-5xl {
                font-size: 2.5rem;
            }

            .post-test-action h5 {
                font-size: 1.125rem;
            }

            .post-test-action a {
                padding: 0.75rem 1.5rem;
                font-size: 0.875rem;
            }

            /* Empty state ultra responsive */
            .empty-state {
                padding: 1.5rem 0.75rem;
            }

            .empty-state .text-6xl {
                font-size: 2.5rem;
                margin-bottom: 1rem;
            }

            .empty-state h3 {
                font-size: 1.25rem;
                margin-bottom: 0.5rem;
            }

            .empty-state p {
                font-size: 0.875rem;
                margin-bottom: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            /* Extra small screens */
            .header-section h1 {
                font-size: 1.25rem;
                line-height: 1.3;
            }

            .material-card {
                padding: 0.5rem;
            }

            .material-number {
                width: 1.75rem;
                height: 1.75rem;
                font-size: 0.75rem;
            }

            .material-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-icon,
            .btn-text {
                width: 100% !important;
                justify-content: center !important;
            }

            .material-info {
                font-size: 0.6875rem;
            }

            /* Decorative circles responsive */
            .header-section .absolute {
                display: none;
            }
        }

        /* Utility classes for responsive behavior */
        .flex-responsive {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        @media (max-width: 768px) {
            .flex-responsive {
                flex-direction: column;
                align-items: stretch;
            }
        }

        .text-responsive {
            overflow-wrap: break-word;
            word-wrap: break-word;
            hyphens: auto;
        }

        /* Fix for button responsiveness */
        .btn-responsive {
            min-width: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        @media (max-width: 640px) {
            .btn-responsive {
                white-space: normal;
                min-height: 2.5rem;
            }
        }

        /* Additional ripple animation CSS */
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
    </style>

    <div class="bg-main-gradient min-h-screen -mx-4 -mt-5 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8 py-4 sm:py-6 lg:py-8 font-sans">
            <!-- Header Section -->
            <div class="header-section relative mb-8 sm:mb-12 p-4 sm:p-6 lg:p-8 bg-gradient-to-br from-indigo-600 to-purple-700 rounded-xl sm:rounded-2xl text-white overflow-hidden">
                <div class="relative z-10">
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold mb-2 text-responsive">
                        <i class="fas fa-graduation-cap me-2 sm:me-3"></i>
                        <span class="break-words">Belajar: {{ $class->name }}</span>
                    </h1>
                    <p class="text-sm sm:text-base lg:text-lg opacity-90 mb-4 sm:mb-6 text-responsive">Mulai perjalanan belajar Anda dan kembangkan kemampuan</p>

                    <div class="flex flex-wrap gap-2 sm:gap-3 justify-center sm:justify-start">
                        <a href="{{ route('classes.show', $class->id) }}"
                            class="group inline-flex items-center gap-1 sm:gap-2 px-4 sm:px-6 py-2.5 sm:py-3 bg-white text-indigo-600 font-semibold rounded-md sm:rounded-lg transition-all duration-300 hover:bg-indigo-50 hover:-translate-y-1 text-sm sm:text-base btn-responsive">
                            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform text-sm sm:text-base"></i>
                            <span class="hidden xs:inline">Kembali ke Detail Kelas</span>
                            <span class="xs:hidden">Kembali</span>
                        </a>
                    </div>
                </div>

                <!-- Decorative circles - hidden on very small screens -->
                <div class="absolute top-0 right-0 w-full h-full overflow-hidden pointer-events-none hidden sm:block">
                    <div class="absolute -top-6 sm:-top-12 -right-6 sm:-right-12 w-24 sm:w-36 lg:w-48 h-24 sm:h-36 lg:h-48 bg-white bg-opacity-10 rounded-full"></div>
                    <div class="absolute top-1/2 right-12 sm:right-24 w-18 sm:w-24 lg:w-36 h-18 sm:h-24 lg:h-36 bg-white bg-opacity-10 rounded-full"></div>
                    <div class="absolute -bottom-4 sm:-bottom-8 right-24 sm:right-48 w-12 sm:w-16 lg:w-24 h-12 sm:h-16 lg:h-24 bg-white bg-opacity-10 rounded-full"></div>
                </div>
            </div>

            <!-- Card Container -->
            <div class="relative -mt-6 sm:-mt-12 z-10">
                <div class="bg-white rounded-xl sm:rounded-2xl shadow-xl sm:shadow-2xl overflow-hidden">
                    <!-- Content Section -->
                    <div class="p-4 sm:p-6 lg:p-8">
                        <!-- Progress Section -->
                        @if ($totalMaterials > 0 && auth()->user()->role === 'siswa')
                            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-4 sm:p-6 rounded-lg sm:rounded-xl mb-4 sm:mb-6 text-white">
                                <div class="flex flex-col sm:flex-row items-center justify-between mb-4 gap-2 sm:gap-0">
                                    <div class="text-center sm:text-left w-full sm:w-auto">
                                        <h3 class="text-lg sm:text-xl font-bold mb-1">Progress Belajar</h3>
                                        <p class="text-white/80 text-sm sm:text-base">{{ $completedMaterials }} dari {{ $totalMaterials }} materi selesai (≥80%)</p>
                                    </div>
                                    <div class="text-center sm:text-right">
                                        <div class="text-2xl sm:text-3xl font-bold">{{ $progressPercentage }}%</div>
                                        <div class="text-white/80 text-xs sm:text-sm">Diselesaikan</div>
                                    </div>
                                </div>

                                <div class="bg-white/20 rounded-full h-3 mb-2">
                                    <div class="bg-gradient-to-r from-green-400 to-green-500 h-full rounded-full transition-all duration-1000 ease-out"
                                        style="width: {{ $progressPercentage }}%"></div>
                                </div>

                                @if ($progressPercentage == 100)
                                    <div class="flex items-center justify-center sm:justify-start gap-2 text-green-200 font-semibold text-sm sm:text-base">
                                        <i class="fas fa-trophy"></i>
                                        <span class="text-center sm:text-left">Selamat! Anda telah menyelesaikan semua materi dengan nilai ≥80%!</span>
                                    </div>
                                @elseif ($progressPercentage >= 75)
                                    <div class="flex items-center justify-center sm:justify-start gap-2 text-yellow-200 font-semibold text-sm sm:text-base">
                                        <i class="fas fa-fire"></i>
                                        <span class="text-center sm:text-left">Hampir selesai! Pastikan semua Pre Test mencapai nilai ≥80%!</span>
                                    </div>
                                @elseif ($progressPercentage >= 50)
                                    <div class="flex items-center justify-center sm:justify-start gap-2 text-blue-200 font-semibold text-sm sm:text-base">
                                        <i class="fas fa-rocket"></i>
                                        <span class="text-center sm:text-left">Kerja bagus! Jangan lupa nilai Pre Test minimal 80% untuk menyelesaikan materi!</span>
                                    </div>
                                @elseif ($progressPercentage > 0)
                                    <div class="flex items-center justify-center sm:justify-start gap-2 text-purple-200 font-semibold text-sm sm:text-base">
                                        <i class="fas fa-seedling"></i>
                                        <span class="text-center sm:text-left">Awal yang baik! Lanjutkan belajar dan capai nilai ≥80% untuk setiap Pre Test!</span>
                                    </div>
                                @else
                                    <div class="flex items-center justify-center sm:justify-start gap-2 text-white/80 font-semibold text-sm sm:text-base">
                                        <i class="fas fa-play"></i>
                                        <span class="text-center sm:text-left">Siap memulai? Capai nilai ≥80% di setiap Pre Test untuk menyelesaikan materi!</span>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- POST TEST SECTION -->
                        @if (auth()->user()->role === 'mentor' && auth()->id() === $class->mentor_id)
                            <div class="mb-6 sm:mb-8">
                                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg sm:rounded-xl p-4 sm:p-6 shadow-lg">
                                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                                        <div class="text-center sm:text-left w-full sm:w-auto">
                                            <h3 class="text-lg sm:text-xl font-bold text-white mb-2">
                                                <i class="fas fa-graduation-cap mr-2 sm:mr-3"></i>Post Test Management
                                            </h3>
                                            <p class="text-blue-100 text-sm sm:text-base">Kelola post test untuk mengukur pemahaman siswa</p>
                                        </div>
                                        <a href="{{ route('post_tests.create', $class) }}"
                                            class="bg-white text-blue-600 px-4 sm:px-6 py-2.5 sm:py-3 rounded-md sm:rounded-lg font-semibold hover:bg-blue-50 transition-all duration-300 hover:-translate-y-0.5 shadow-md text-sm sm:text-base whitespace-nowrap">
                                            <i class="fas fa-plus mr-1 sm:mr-2"></i>Buat Post Test
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($class->activePostTest)
                            <div class="mb-6 sm:mb-8">
                                <div class="bg-white rounded-lg sm:rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                                    <!-- Header -->
                                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-4 sm:p-6">
                                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                                            <div class="text-center sm:text-left w-full sm:w-auto">
                                                <h4 class="text-xl sm:text-2xl font-bold text-white mb-2">
                                                    <i class="fas fa-graduation-cap mr-2 sm:mr-3"></i>Post Test Kelas
                                                </h4>
                                                <p class="text-indigo-100 text-sm sm:text-base">Uji pemahaman Anda setelah menyelesaikan semua materi</p>
                                            </div>
                                            <div class="text-white text-center sm:text-right">
                                                <div class="text-2xl sm:text-3xl font-bold">80%</div>
                                                <div class="text-indigo-200 text-xs sm:text-sm">Nilai Minimum</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Content -->
                                    <div class="p-4 sm:p-6">
                                        @php
                                            $postTest = $class->activePostTest;

                                            // HITUNG SEMUA ATTEMPT ASLI YANG SUDAH SELESAI (normal + approval attempts)
                                            $totalFinishedAttempts = $postTest
                                                ->attempts()
                                                ->where('user_id', auth()->id())
                                                ->whereNotNull('finished_at')
                                                ->where(function ($query) {
                                                    $query
                                                        ->where('requires_approval', false)
                                                        ->orWhere('is_approval_attempt', true);
                                                })
                                                ->count();

                                            // Cek pending approval (yang belum di-approve)
                                            $pendingApproval = $postTest
                                                ->attempts()
                                                ->where('user_id', auth()->id())
                                                ->where('requires_approval', true)
                                                ->where('mentor_approved', false)
                                                ->exists();

                                            // Cek approval yang tersedia (approved tapi belum digunakan, dan dibuat setelah attempt terakhir)
                                            $lastFinishedAttempt = $postTest
                                                ->attempts()
                                                ->where('user_id', auth()->id())
                                                ->whereNotNull('finished_at')
                                                ->where(function ($query) {
                                                    $query
                                                        ->where('requires_approval', false)
                                                        ->orWhere('is_approval_attempt', true);
                                                })
                                                ->latest('finished_at')
                                                ->first();

                                            $hasAvailableApproval = false;
                                            if ($totalFinishedAttempts >= 2) {
                                                $availableApprovalQuery = $postTest
                                                    ->attempts()
                                                    ->where('user_id', auth()->id())
                                                    ->where('requires_approval', true)
                                                    ->where('mentor_approved', true)
                                                    ->where('is_used', false);

                                                if ($lastFinishedAttempt) {
                                                    $availableApprovalQuery = $availableApprovalQuery->where(
                                                        'approved_at',
                                                        '>',
                                                        $lastFinishedAttempt->finished_at,
                                                    );
                                                }

                                                $hasAvailableApproval = $availableApprovalQuery->exists();
                                            }

                                            // Ambil attempt terakhir untuk nilai
                                            $lastScore = $lastFinishedAttempt
                                                ? $lastFinishedAttempt->getPercentageAttribute()
                                                : 0;
                                            $hasPassed = $lastScore >= 80;

                                            // Tentukan apakah bisa mengerjakan test
                                            $canTakeTest = false;
                                            if ($totalFinishedAttempts < 2) {
                                                // Attempt 1-2: boleh langsung
                                                $canTakeTest = true;
                                            } elseif ($totalFinishedAttempts >= 2 && $hasAvailableApproval) {
                                                // Attempt 3+: hanya jika ada approval yang tersedia
                                                $canTakeTest = true;
                                            }
                                        @endphp

                                        @if (auth()->user()->role === 'mentor' && auth()->id() === $class->mentor_id)
                                            <!-- Mentor View -->
                                            <div class="post-test-stats grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                                                <!-- Stats Cards -->
                                                <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                                                    <div class="flex items-center justify-between">
                                                        <div>
                                                            <p class="text-blue-600 font-semibold text-xs sm:text-sm">Total Soal</p>
                                                            <p class="text-xl sm:text-2xl font-bold text-blue-800">
                                                                {{ $postTest->questions->count() }}</p>
                                                        </div>
                                                        <div class="bg-blue-500 rounded-full p-2 sm:p-3">
                                                            <i class="fas fa-question text-white text-sm sm:text-base"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                                                    <div class="flex items-center justify-between">
                                                        <div>
                                                            <p class="text-green-600 font-semibold text-xs sm:text-sm">Durasi</p>
                                                            <p class="text-xl sm:text-2xl font-bold text-green-800">
                                                                {{ $postTest->time_limit ?? 'Unlimited' }} min</p>
                                                        </div>
                                                        <div class="bg-green-500 rounded-full p-2 sm:p-3">
                                                            <i class="fas fa-clock text-white text-sm sm:text-base"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="bg-purple-50 rounded-lg p-4 border border-purple-200">
                                                    <div class="flex items-center justify-between">
                                                        <div>
                                                            <p class="text-purple-600 font-semibold text-xs sm:text-sm">Passing Score</p>
                                                            <p class="text-xl sm:text-2xl font-bold text-purple-800">80%</p>
                                                        </div>
                                                        <div class="bg-purple-500 rounded-full p-2 sm:p-3">
                                                            <i class="fas fa-trophy text-white text-sm sm:text-base"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 sm:mt-6">
                                                <a href="{{ route('post_tests.edit', [$class, $postTest]) }}"
                                                    class="inline-block bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-6 sm:px-8 py-2.5 sm:py-3 rounded-md sm:rounded-lg font-semibold hover:from-indigo-600 hover:to-purple-700 transition-all duration-300 hover:-translate-y-0.5 shadow-lg text-sm sm:text-base">
                                                    <i class="fas fa-edit mr-1 sm:mr-2"></i> Edit Post Test
                                                </a>
                                            </div>
                                        @elseif(auth()->user()->role === 'siswa')
                                            @if ($progressPercentage == 100)
                                                <div class="post-test-grid grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
                                                    <!-- Status Card -->
                                                    <div class="space-y-4">
                                                        <!-- Attempt Status -->
                                                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                                            <div class="flex flex-col sm:flex-row items-center justify-between mb-3 gap-2">
                                                                <h5 class="font-semibold text-gray-800 text-sm sm:text-base">Status Attempt</h5>
                                                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs sm:text-sm font-medium">
                                                                    @if ($totalFinishedAttempts <= 2)
                                                                        {{ $totalFinishedAttempts }}/2 Percobaan
                                                                    @else
                                                                        {{ $totalFinishedAttempts }} Percobaan
                                                                        ({{ $totalFinishedAttempts - 2 }} dengan Approval)
                                                                    @endif
                                                                </span>
                                                            </div>

                                                            @if ($lastFinishedAttempt)
                                                                <div class="space-y-2">
                                                                    <div class="flex justify-between items-center">
                                                                        <span class="text-gray-600 text-sm sm:text-base">Nilai Terakhir:</span>
                                                                        <span class="font-bold text-lg {{ $hasPassed ? 'text-green-600' : 'text-red-600' }}">
                                                                            {{ $lastScore }}%
                                                                        </span>
                                                                    </div>
                                                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                                                        <div class="bg-gradient-to-r {{ $hasPassed ? 'from-green-400 to-green-600' : 'from-red-400 to-red-600' }} h-2 rounded-full transition-all duration-1000"
                                                                            style="width: {{ $lastScore }}%"></div>
                                                                    </div>
                                                                    <div class="flex justify-between text-xs text-gray-500">
                                                                        <span>0%</span>
                                                                        <span class="text-orange-600 font-medium">80% (Pass)</span>
                                                                        <span>100%</span>
                                                                    </div>
                                                                </div>
                                                            @else
                                                                <p class="text-gray-500 text-center py-4 text-sm sm:text-base">
                                                                    <i class="fas fa-info-circle mr-2"></i>Belum ada percobaan
                                                                </p>
                                                            @endif
                                                        </div>

                                                        <!-- Instructions -->
                                                        <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                                                            <h5 class="font-semibold text-blue-800 mb-2 text-sm sm:text-base">
                                                                <i class="fas fa-info-circle mr-2"></i>Informasi Penting
                                                            </h5>
                                                            <ul class="text-blue-700 text-xs sm:text-sm space-y-1">
                                                                <li>• Nilai minimum untuk lulus adalah 80%</li>
                                                                <li>• Anda memiliki 2 percobaan gratis</li>
                                                                <li>• Setelah 2 percobaan dengan nilai < 80%, perlu approval mentor untuk setiap percobaan tambahan</li>
                                                                <li>• Satu approval hanya berlaku untuk satu percobaan</li>
                                                            </ul>
                                                        </div>
                                                    </div>

                                                    <!-- Action Card -->
                                                    <div class="flex flex-col justify-center">
                                                        @if ($hasPassed)
                                                            <!-- Already Passed -->
                                                            <div class="text-center p-4 sm:p-6 bg-green-50 rounded-lg border border-green-200">
                                                                <div class="text-4xl sm:text-5xl text-green-500 mb-4">
                                                                    <i class="fas fa-trophy"></i>
                                                                </div>
                                                                <h5 class="text-lg sm:text-xl font-bold text-green-800 mb-2">Selamat!</h5>
                                                                <p class="text-green-700 mb-4 text-sm sm:text-base">
                                                                    Anda telah berhasil mencapai nilai passing score dengan {{ $lastScore }}%
                                                                </p>
                                                                <div class="bg-green-100 text-green-800 px-4 py-2 rounded-lg font-medium text-sm sm:text-base">
                                                                    Post Test Selesai
                                                                </div>
                                                            </div>
                                                        @else
                                                            <!-- Can Take Test -->
                                                            @if ($canTakeTest)
                                                                <div class="post-test-action text-center p-4 sm:p-6">
                                                                    <div class="text-4xl sm:text-5xl text-indigo-500 mb-4">
                                                                        <i class="fas fa-play-circle"></i>
                                                                    </div>
                                                                    <h5 class="text-lg sm:text-xl font-bold text-gray-800 mb-2">
                                                                        @if ($totalFinishedAttempts > 0)
                                                                            @if ($totalFinishedAttempts < 2)
                                                                                Percobaan ke-{{ $totalFinishedAttempts + 1 }} (Gratis)
                                                                            @else
                                                                                Percobaan ke-{{ $totalFinishedAttempts + 1 }} (Dengan Approval)
                                                                            @endif
                                                                        @else
                                                                            Mulai Post Test
                                                                        @endif
                                                                    </h5>
                                                                    <p class="text-gray-600 mb-4 sm:mb-6 text-sm sm:text-base">
                                                                        @if ($totalFinishedAttempts > 0)
                                                                            Tingkatkan nilai Anda untuk mencapai 80%
                                                                        @else
                                                                            Uji pemahaman Anda terhadap materi yang telah dipelajari
                                                                        @endif
                                                                    </p>
                                                                    <a href="{{ route('post_tests.show', $class->activePostTest) }}"
                                                                        class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-6 sm:px-8 py-2.5 sm:py-3 rounded-md sm:rounded-lg font-semibold hover:from-indigo-600 hover:to-purple-700 transition-all duration-300 hover:-translate-y-0.5 shadow-lg text-sm sm:text-base btn-responsive">
                                                                        <i class="fas fa-eye mr-1 sm:mr-2"></i>
                                                                        @if ($totalFinishedAttempts >= 2)
                                                                            <span class="hidden xs:inline">Gunakan Approval</span>
                                                                            <span class="xs:hidden">Mulai</span>
                                                                        @else
                                                                            <span class="hidden xs:inline">Mulai Sekarang</span>
                                                                            <span class="xs:hidden">Mulai</span>
                                                                        @endif
                                                                    </a>
                                                                </div>
                                                            @else
                                                                <!-- Need Approval -->
                                                                <div class="p-4 sm:p-6 bg-orange-50 rounded-lg border border-orange-200">
                                                                    @if ($pendingApproval)
                                                                        <div class="text-center">
                                                                            <div class="text-3xl sm:text-4xl text-orange-500 mb-4">
                                                                                <i class="fas fa-hourglass-half"></i>
                                                                            </div>
                                                                            <h5 class="text-base sm:text-lg font-bold text-orange-800 mb-2">
                                                                                Menunggu Approval</h5>
                                                                            <p class="text-orange-700 mb-4 text-sm sm:text-base">
                                                                                Permintaan Anda sedang menunggu persetujuan dari mentor
                                                                            </p>
                                                                            <div class="bg-orange-100 text-orange-800 px-4 py-2 rounded-lg font-medium text-sm sm:text-base">
                                                                                <i class="fas fa-clock mr-2"></i>Dalam Proses Review
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <div class="text-center">
                                                                            <div class="text-3xl sm:text-4xl text-orange-500 mb-4">
                                                                                <i class="fas fa-hand-paper"></i>
                                                                            </div>
                                                                            <h5 class="text-base sm:text-lg font-bold text-orange-800 mb-2">
                                                                                Butuh Approval Mentor</h5>
                                                                            <p class="text-orange-700 mb-4 sm:mb-6 text-sm sm:text-base">
                                                                                @if ($totalFinishedAttempts >= 2)
                                                                                    Anda telah menggunakan {{ $totalFinishedAttempts }} percobaan
                                                                                    dengan nilai di bawah 80%. Silakan minta approval dari mentor untuk
                                                                                    percobaan tambahan.
                                                                                @else
                                                                                    Anda telah menggunakan 2 percobaan gratis dengan nilai di bawah 80%.
                                                                                    Silakan minta approval dari mentor untuk percobaan tambahan.
                                                                                @endif
                                                                            </p>
                                                                            <a href="{{ route('post_tests.request_approval.form', $postTest) }}"
                                                                                class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-md sm:rounded-lg font-semibold hover:from-orange-600 hover:to-red-600 transition-all duration-300 hover:-translate-y-0.5 shadow-lg text-sm sm:text-base btn-responsive">
                                                                                <i class="fas fa-paper-plane mr-1 sm:mr-2"></i>
                                                                                <span class="hidden xs:inline">Minta Approval</span>
                                                                                <span class="xs:hidden">Approval</span>
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
                                                <div class="text-center p-6 sm:p-8 bg-gray-50 rounded-lg border border-gray-200">
                                                    <div class="text-4xl sm:text-5xl text-gray-400 mb-4">
                                                        <i class="fas fa-lock"></i>
                                                    </div>
                                                    <h5 class="text-lg sm:text-xl font-bold text-gray-700 mb-2">Post Test Terkunci</h5>
                                                    <p class="text-gray-600 mb-4 sm:mb-6 text-sm sm:text-base">
                                                        Selesaikan semua materi dengan nilai minimal 80% untuk membuka post test
                                                    </p>
                                                    <div class="bg-blue-100 text-blue-800 px-4 sm:px-6 py-2 sm:py-3 rounded-lg font-semibold inline-block text-sm sm:text-base">
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
                            <div class="mb-6 sm:mb-8">
                                <div class="empty-state bg-white rounded-lg sm:rounded-xl border-2 border-dashed border-gray-300 p-8 sm:p-12 text-center">
                                    <div class="text-4xl sm:text-6xl text-gray-400 mb-4 sm:mb-6">
                                        <i class="fas fa-graduation-cap"></i>
                                    </div>
                                    <h5 class="text-xl sm:text-2xl font-bold text-gray-700 mb-3 sm:mb-4">Belum Ada Post Test</h5>
                                    <p class="text-gray-500 text-base sm:text-lg mb-6 sm:mb-8 max-w-2xl mx-auto">
                                        Buat post test untuk menguji pemahaman siswa setelah mereka menyelesaikan semua
                                        materi pembelajaran. Post test akan membantu mengukur efektivitas pembelajaran.
                                    </p>
                                    <a href="{{ route('post_tests.create', [$class->id]) }}"
                                        class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-6 sm:px-8 py-3 sm:py-4 rounded-md sm:rounded-lg font-bold text-base sm:text-lg hover:from-indigo-600 hover:to-purple-700 transition-all duration-300 hover:-translate-y-0.5 shadow-lg btn-responsive">
                                        <i class="fas fa-plus mr-2 sm:mr-3"></i>
                                        <span class="hidden sm:inline">Buat Post Test Sekarang</span>
                                        <span class="sm:hidden">Buat Post Test</span>
                                    </a>
                                </div>
                            </div>
                        @endif

                        @if ($class->materials->count() > 0)
                            <!-- Stats Bar -->
                            <div class="stats-bar bg-gray-50 p-4 sm:p-5 rounded-lg sm:rounded-xl mb-4 sm:mb-6 border border-gray-200">
                                <div class="flex flex-col sm:flex-row justify-center items-center gap-4 sm:gap-6 lg:gap-8 flex-wrap">
                                    <div class="flex items-center gap-2 sm:gap-2.5 text-gray-600 font-semibold text-sm sm:text-base">
                                        <div class="w-6 sm:w-8 h-6 sm:h-8 bg-stat-gradient rounded-full flex items-center justify-center text-white text-xs sm:text-sm">
                                            <i class="fas fa-book"></i>
                                        </div>
                                        <span>{{ $class->materials->count() }} Materi Tersedia</span>
                                    </div>
                                    <div class="flex items-center gap-2 sm:gap-2.5 text-gray-600 font-semibold text-sm sm:text-base">
                                        <div class="w-6 sm:w-8 h-6 sm:h-8 bg-stat-gradient rounded-full flex items-center justify-center text-white text-xs sm:text-sm">
                                            <i class="fas fa-user-tie"></i>
                                        </div>
                                        <span class="truncate">Mentor: {{ $class->mentor->name ?? 'Unknown' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 sm:gap-2.5 text-gray-600 font-semibold text-sm sm:text-base">
                                        <div class="w-6 sm:w-8 h-6 sm:h-8 bg-stat-gradient rounded-full flex items-center justify-center text-white text-xs sm:text-sm">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <span class="hidden sm:inline">Terakhir Update: {{ $class->updated_at->format('d M Y') }}</span>
                                        <span class="sm:hidden">{{ $class->updated_at->format('d M Y') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Materials Grid -->
                            <div class="space-y-4 sm:space-y-6">
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

                                    <div class="material-card bg-white border border-gray-200 rounded-lg sm:rounded-xl p-3 sm:p-4 lg:p-5 transition-all duration-300 border-l-4 border-l-indigo-600 shadow-sm hover:-translate-y-0.5 hover:shadow-lg hover:border-l-green-500
                                        {{ $completionStatus['completed'] ? 'completed' : ($completionStatus['attempted'] ? 'attempted' : '') }}">
                                        <div class="material-card-content flex flex-col lg:flex-row justify-between items-start gap-3 sm:gap-4 lg:gap-5">
                                            <div class="flex-1 w-full lg:w-auto">
                                                <div class="material-header">
                                                    <h3 class="text-base sm:text-lg lg:text-xl font-semibold text-gray-800 m-0 mb-2 flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-2.5">
                                                        <div class="material-title-row flex items-center gap-2 sm:gap-2.5">
                                                            <div class="material-number w-7 sm:w-8 lg:w-9 h-7 sm:h-8 lg:h-9 bg-material-gradient rounded-md sm:rounded-lg flex items-center justify-center text-white flex-shrink-0 text-xs sm:text-sm">
                                                                @if ($completionStatus['completed'])
                                                                    <i class="fas fa-check"></i>
                                                                @elseif ($completionStatus['attempted'])
                                                                    <i class="fas fa-exclamation"></i>
                                                                @else
                                                                    {{ $index + 1 }}
                                                                @endif
                                                            </div>
                                                            <span class="text-responsive break-words">{{ $material->title }}</span>
                                                        </div>
                                                        <div class="material-badges w-full sm:w-auto flex flex-wrap gap-1 sm:gap-2">
                                                            @if ($completionStatus['completed'])
                                                                <span class="completed-badge">
                                                                    <i class="fas fa-trophy"></i>
                                                                    <span class="hidden xs:inline">Selesai ({{ $completionStatus['percentage'] }}%)</span>
                                                                    <span class="xs:hidden">{{ $completionStatus['percentage'] }}%</span>
                                                                </span>
                                                            @elseif ($completionStatus['attempted'])
                                                                <span class="attempted-badge">
                                                                    <i class="fas fa-redo"></i>
                                                                    <span class="hidden xs:inline">Coba Lagi ({{ $completionStatus['percentage'] }}%)</span>
                                                                    <span class="xs:hidden">{{ $completionStatus['percentage'] }}%</span>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </h3>
                                                </div>

                                                @if ($material->description)
                                                    <p class="text-gray-600 leading-relaxed m-0 mb-3 text-sm sm:text-base text-responsive">
                                                        {{ $material->description }}
                                                    </p>
                                                @endif

                                                <div class="material-info flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-4 text-gray-500 text-xs sm:text-sm">
                                                    <div class="flex items-center gap-1">
                                                        <i class="fas fa-calendar-alt"></i>
                                                        <span class="hidden sm:inline">Dibuat: {{ $material->created_at->format('d M Y H:i') }}</span>
                                                        <span class="sm:hidden">{{ $material->created_at->format('d M Y') }}</span>
                                                    </div>

                                                    @if ($activeQuiz)
                                                        <div class="flex items-center gap-1">
                                                            <i class="fas fa-question-circle"></i>
                                                            <span>Quiz: {{ $activeQuiz->questions->count() }} pertanyaan</span>
                                                        </div>

                                                        @if ($completionStatus['attempted'])
                                                            <div class="flex items-center gap-1 {{ $completionStatus['completed'] ? 'text-green-600' : 'text-orange-600' }}">
                                                                <i class="fas fa-star"></i>
                                                                <span class="hidden sm:inline">Best: {{ $completionStatus['score'] }} poin ({{ $completionStatus['percentage'] }}%)</span>
                                                                <span class="sm:hidden">{{ $completionStatus['percentage'] }}%</span>
                                                            </div>
                                                        @endif

                                                        @if (!$completionStatus['completed'] && $completionStatus['attempted'])
                                                            <div class="flex items-center gap-1 text-red-600">
                                                                <i class="fas fa-info-circle"></i>
                                                                <span class="hidden sm:inline">Perlu ≥80% untuk selesai</span>
                                                                <span class="sm:hidden">≥80%</span>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="material-actions flex flex-row gap-1 sm:gap-2 items-center flex-shrink-0 w-full lg:w-auto justify-center lg:justify-start">
                                                @if (auth()->id() === $class->mentor_id && auth()->user()->role === 'mentor')
                                                    <a href="{{ route('materials.show', $material) }}"
                                                        class="btn btn-success flex-1 sm:flex-initial text-xs sm:text-sm px-3 sm:px-4 py-2 sm:py-2.5">
                                                        <i class="fas fa-book-open me-1 sm:me-2"></i>
                                                        <span class="hidden sm:inline">Buka Materi</span>
                                                        <span class="sm:hidden">Buka</span>
                                                    </a>
                                                    <a href="{{ route('materials.edit', $material->id) }}"
                                                        class="btn-icon bg-yellow-400 text-yellow-800 border-0 p-2 sm:p-2.5 rounded-md font-semibold transition-all duration-300 no-underline text-center inline-flex items-center justify-center w-8 sm:w-9 h-8 sm:h-9 min-w-8 sm:min-w-9 hover:bg-yellow-300 hover:text-yellow-800 hover:-translate-y-0.5 hover:shadow-lg text-xs sm:text-sm"
                                                        style="box-shadow: 0 2px 8px rgba(255, 215, 0, 0.3);"
                                                        title="Edit Materi">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('materials.destroy', $material->id) }}"
                                                        method="POST" class="inline-block"
                                                        onsubmit="return confirm('Yakin mau hapus materi ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn-icon bg-red-500 text-white border-0 p-2 sm:p-2.5 rounded-md font-semibold transition-all duration-300 text-center inline-flex items-center justify-center w-8 sm:w-9 h-8 sm:h-9 min-w-8 sm:min-w-9 hover:bg-red-600 hover:-translate-y-0.5 text-xs sm:text-sm"
                                                            style="box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);"
                                                            title="Hapus Materi">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    <a href="{{ route('quizzes.create', $material) }}"
                                                        class="btn-text bg-quiz-gradient text-white border-0 px-3 sm:px-4 py-2 sm:py-2.5 rounded-md font-semibold transition-all duration-300 no-underline text-center inline-flex items-center justify-center gap-1 sm:gap-1.5 whitespace-nowrap hover:-translate-y-0.5 text-xs sm:text-sm">
                                                        <i class="fas fa-question-circle"></i>
                                                        <span class="hidden sm:inline">Tambah Pre Test</span>
                                                        <span class="sm:hidden">Pre Test</span>
                                                    </a>
                                                @else
                                                    <a href="{{ route('materials.show', $material->id) }}"
                                                        class="btn-text bg-study-gradient text-white border-0 px-4 sm:px-5 py-2.5 sm:py-3 rounded-md sm:rounded-lg font-semibold transition-all duration-300 no-underline inline-flex items-center justify-center gap-1 sm:gap-2 text-center whitespace-nowrap hover:-translate-y-0.5 w-full sm:w-auto text-sm sm:text-base"
                                                        style="box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);">
                                                        <i class="fas fa-play"></i>
                                                        @if ($completionStatus['completed'])
                                                            Lihat Lagi
                                                        @elseif ($completionStatus['attempted'])
                                                            Ulangi Pre Test
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
