@extends('layouts.app')

@section('title', 'Achievement - ' . config('app.name'))

@push('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');

    body {
        font-family: 'Inter', sans-serif;
    }

    .animate-fade-in-down {
        animation: fadeInDown 0.8s ease-out;
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out 0.2s both;
    }

    .animate-slide-up {
        animation: slideUp 0.6s ease-out;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .glass-effect {
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
    }

    .card-hover {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card-hover:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }

    .progress-bar {
        transition: width 0.8s ease-in-out;
    }

    .status-dot {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.7;
        }
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-600 via-blue-600 to-indigo-700 p-4 md:p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8 md:mb-12 text-white">
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold drop-shadow-2xl animate-fade-in-down bg-gradient-to-r from-white to-purple-100 bg-clip-text text-transparent">
                🏆 Achievement
            </h1>
            <p class="text-base md:text-lg lg:text-xl opacity-90 animate-fade-in-up font-medium tracking-wide">
                Pencapaian Anda dalam menyelesaikan Kelas
            </p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid gap-4 md:gap-6 grid-cols-2 lg:grid-cols-4 mb-8 md:mb-12">
            <div class="glass-effect bg-white/20 rounded-2xl md:rounded-3xl p-4 md:p-6 text-center border border-white/30 card-hover group">
                <div class="text-2xl md:text-4xl font-black bg-gradient-to-r from-white to-purple-100 bg-clip-text text-transparent group-hover:scale-110 transition-transform duration-300">
                    {{ $stats['total_completed'] }}
                </div>
                <p class="text-white/90 text-sm md:text-base font-medium">Kelas Diselesaikan</p>
            </div>

            <div class="glass-effect bg-white/20 rounded-2xl md:rounded-3xl p-4 md:p-6 text-center border border-white/30 card-hover group">
                <div class="text-2xl md:text-4xl font-black bg-gradient-to-r from-white to-purple-100 bg-clip-text text-transparent group-hover:scale-110 transition-transform duration-300">
                    {{ $stats['average_score'] }}%
                </div>
                <p class="text-white/90 text-sm md:text-base font-medium">Rata-rata Skor</p>
            </div>

            <div class="glass-effect bg-white/20 rounded-2xl md:rounded-3xl p-4 md:p-6 text-center border border-white/30 card-hover group">
                <div class="text-2xl md:text-4xl font-black bg-gradient-to-r from-white to-purple-100 bg-clip-text text-transparent group-hover:scale-110 transition-transform duration-300">
                    {{ $stats['perfect_scores'] }}
                </div>
                <p class="text-white/90 text-sm md:text-base font-medium">Nilai Sempurna</p>
            </div>

            <div class="glass-effect bg-white/20 rounded-2xl md:rounded-3xl p-4 md:p-6 text-center border border-white/30 card-hover group">
                <div class="text-2xl md:text-4xl font-black bg-gradient-to-r from-white to-purple-100 bg-clip-text text-transparent group-hover:scale-110 transition-transform duration-300">
                    {{ $stats['success_rate'] }}%
                </div>
                <p class="text-white/90 text-sm md:text-base font-medium">Tingkat Keberhasilan</p>
            </div>
        </div>

        <!-- Achievement Cards -->
        @if($completedClasses->count() > 0)
        <div class="grid gap-4 md:gap-6 lg:grid-cols-2 mb-8 md:mb-12">
            @foreach($completedClasses as $class)
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl md:rounded-3xl p-4 md:p-6 shadow-xl hover:shadow-2xl card-hover border border-purple-100 group">
                <div class="flex items-start space-x-3 md:space-x-4">
                    <!-- Icon/Avatar -->
                    <div class="w-12 h-12 md:w-16 md:h-16 rounded-xl md:rounded-2xl overflow-hidden
                        @if($class->percentage == 100) bg-gradient-to-br from-yellow-400 via-orange-500 to-red-500
                        @elseif($class->percentage >= 90) bg-gradient-to-br from-green-400 via-emerald-500 to-teal-600
                        @else bg-gradient-to-br from-blue-400 via-indigo-500 to-purple-600
                        @endif
                        flex items-center justify-center text-xl md:text-2xl flex-shrink-0 shadow-lg group-hover:scale-110 transition-transform duration-300">
                        @if($class->percentage == 100)
                            🏆
                        @elseif($class->percentage >= 90)
                            ⭐
                        @else
                            📚
                        @endif
                    </div>

                    <div class="flex-1 min-w-0">
                        <!-- Status and Duration -->
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="w-2.5 h-2.5 md:w-3 md:h-3 bg-green-500 rounded-full status-dot shadow-sm"></span>
                            <span class="text-xs md:text-sm text-gray-600 font-semibold tracking-wide">Lulus</span>
                            <span class="text-xs md:text-sm text-gray-400">•</span>
                            <span class="text-xs md:text-sm text-purple-600 font-medium">{{ $class->completion_date->format('d M Y') }}</span>
                        </div>

                        <!-- Class Title -->
                        <h3 class="text-base md:text-lg font-bold text-gray-900 mb-2 md:mb-3 group-hover:text-purple-700 transition-colors">
                            {{ $class->name }}
                        </h3>

                        <!-- Mentor Info -->
                        <p class="text-xs md:text-sm text-gray-600 mb-3 md:mb-4 leading-relaxed">
                            Mentor: {{ $class->mentor->name }}
                        </p>

                        <!-- Class Stats -->
                        <div class="flex items-center justify-between text-xs text-gray-500 space-x-2 md:space-x-4 mb-4">
                            <div class="flex items-center space-x-1 bg-gray-50 px-2 py-1 rounded-lg">
                                <span class="text-xs">🎯</span>
                                <span class="font-medium">{{ $class->score }} pts</span>
                            </div>

                            <!-- Score Badge -->
                            @if($class->percentage == 100)
                                <span class="bg-yellow-50 text-yellow-700 px-2 py-1 rounded-lg text-xs font-bold flex items-center">
                                    ⭐ Sempurna
                                </span>
                            @elseif($class->percentage >= 90)
                                <span class="bg-green-50 text-green-700 px-2 py-1 rounded-lg text-xs font-bold flex items-center">
                                    🚀 Excellent
                                </span>
                            @else
                                <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded-lg text-xs font-bold flex items-center">
                                    ✅ Lulus
                                </span>
                            @endif

                            <!-- View Detail Button -->
                            <a href="{{ route('achievements.show', $class->id) }}"
                               class="text-xs text-purple-600 hover:text-purple-800 font-medium flex items-center space-x-1 bg-purple-50 px-2 py-1 rounded-lg hover:bg-purple-100 transition-colors">
                                <span>Detail</span>
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>

                        <!-- Progress Bar -->
                        <div class="space-y-2">
                            <div class="flex justify-between text-xs font-semibold text-gray-700">
                                <span>Progress</span>
                                <span>{{ $class->percentage }}%</span>
                            </div>
                            <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full progress-bar rounded-full
                                    @if($class->percentage == 100) bg-gradient-to-r from-yellow-400 to-orange-500
                                    @elseif($class->percentage >= 90) bg-gradient-to-r from-green-400 to-emerald-500
                                    @else bg-gradient-to-r from-blue-400 to-purple-500
                                    @endif"
                                     style="width: {{ $class->percentage }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Empty State -->
        <div class="glass-effect bg-white/20 rounded-2xl md:rounded-3xl p-8 md:p-12 text-center border border-white/30">
            <div class="text-6xl md:text-8xl mb-4">🏆</div>
            <h3 class="text-xl md:text-2xl font-bold text-white mb-3">Belum Ada Achievement</h3>
            <p class="text-white/80 text-sm md:text-base mb-6 max-w-md mx-auto leading-relaxed">
                Mulai ikuti kelas dan selesaikan Post Test dengan nilai ≥ 80% untuk mendapatkan achievement pertama Anda!
            </p>
            <a href="{{ route('classes.index') }}"
               class="inline-flex items-center px-6 py-3 bg-white/90 text-purple-700 rounded-2xl hover:bg-white hover:scale-105 transition-all duration-300 font-semibold shadow-lg">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                Jelajahi Kelas
            </a>
        </div>
        @endif

        <!-- Additional Stats Summary (Optional) -->

    </div>
</div>
@endsection
