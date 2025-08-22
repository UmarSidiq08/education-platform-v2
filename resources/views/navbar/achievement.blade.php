@extends('layouts.app')

@section('title', 'Achievement - Pencapaian Saya')

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
        background: linear-gradient(90deg, #0ea5e9 0%, #0284c7 100%);
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
<div class="min-h-screen bg-gradient-to-br from-sky-400 via-sky-500 to-indigo-600 p-4 md:p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8 md:mb-12 text-white">
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold drop-shadow-2xl animate-fade-in-down bg-gradient-to-r from-white to-sky-100 bg-clip-text text-transparent">
                🏆 Achievement
            </h1>
            <p class="text-base md:text-lg lg:text-xl opacity-90 animate-fade-in-up font-medium tracking-wide">
                Pencapaian dan Progress Perjalanan Saya
            </p>
        </div>

        <!-- Stats Grid -->
        <div class="grid gap-4 md:gap-6 grid-cols-2 lg:grid-cols-4 mb-8 md:mb-12">
            <div class="glass-effect bg-white/20 rounded-2xl md:rounded-3xl p-4 md:p-6 text-center border border-white/30 card-hover group">
                <div class="text-2xl md:text-4xl font-black bg-gradient-to-r from-white to-sky-100 bg-clip-text text-transparent group-hover:scale-110 transition-transform duration-300">
                    25
                </div>
                <p class="text-white/90 text-sm md:text-base font-medium">Total Achievement</p>
            </div>
            <div class="glass-effect bg-white/20 rounded-2xl md:rounded-3xl p-4 md:p-6 text-center border border-white/30 card-hover group">
                <div class="text-2xl md:text-4xl font-black bg-gradient-to-r from-white to-sky-100 bg-clip-text text-transparent group-hover:scale-110 transition-transform duration-300">
                    8
                </div>
                <p class="text-white/90 text-sm md:text-base font-medium">Bulan Ini</p>
            </div>
            <div class="glass-effect bg-white/20 rounded-2xl md:rounded-3xl p-4 md:p-6 text-center border border-white/30 card-hover group">
                <div class="text-2xl md:text-4xl font-black bg-gradient-to-r from-white to-sky-100 bg-clip-text text-transparent group-hover:scale-110 transition-transform duration-300">
                    156
                </div>
                <p class="text-white/90 text-sm md:text-base font-medium">Poin Terkumpul</p>
            </div>
            <div class="glass-effect bg-white/20 rounded-2xl md:rounded-3xl p-4 md:p-6 text-center border border-white/30 card-hover group">
                <div class="text-2xl md:text-4xl font-black bg-gradient-to-r from-white to-sky-100 bg-clip-text text-transparent group-hover:scale-110 transition-transform duration-300">
                    92%
                </div>
                <p class="text-white/90 text-sm md:text-base font-medium">Tingkat Completion</p>
            </div>
        </div>

        <!-- Achievements Section -->
        <div class="grid gap-4 md:gap-6 lg:grid-cols-2 mb-8 md:mb-12">
            <!-- Achievement Card 1 -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl md:rounded-3xl p-4 md:p-6 shadow-xl hover:shadow-2xl card-hover border border-sky-100 group">
                <div class="flex items-start space-x-3 md:space-x-4">
                    <div class="w-12 h-12 md:w-16 md:h-16 rounded-xl md:rounded-2xl overflow-hidden bg-gradient-to-br from-green-400 via-emerald-500 to-teal-600 flex items-center justify-center text-xl md:text-2xl flex-shrink-0 shadow-lg group-hover:scale-110 transition-transform duration-300">
                        🐍
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="w-2.5 h-2.5 md:w-3 md:h-3 bg-green-500 rounded-full status-dot shadow-sm"></span>
                            <span class="text-xs md:text-sm text-gray-600 font-semibold tracking-wide">Lulus</span>
                            <span class="text-xs md:text-sm text-gray-400">•</span>
                            <span class="text-xs md:text-sm text-sky-600 font-medium">16 Jam</span>
                        </div>
                        <h3 class="text-base md:text-lg font-bold text-gray-900 mb-2 md:mb-3 group-hover:text-sky-700 transition-colors">
                            Memulai Pemrograman dengan Python
                        </h3>
                        <p class="text-xs md:text-sm text-gray-600 mb-3 md:mb-4 leading-relaxed line-clamp-2">
                            Pelajari dasar Python hingga library populer yang menjadi landasan tren industri data science, machine learning, dan back-end development.
                        </p>
                        <div class="flex items-center justify-between text-xs text-gray-500 space-x-2 md:space-x-4">
                            <div class="flex items-center space-x-1 bg-gray-50 px-2 py-1 rounded-lg">
                                <span class="text-xs">📚</span>
                                <span class="font-medium">91 Modul</span>
                            </div>
                            <div class="flex items-center space-x-1 bg-gray-50 px-2 py-1 rounded-lg">
                                <span class="text-xs">👥</span>
                                <span class="font-medium hidden sm:inline">170.139</span>
                                <span class="font-medium sm:hidden">170K</span>
                            </div>
                            <div class="flex items-center space-x-1 bg-yellow-50 px-2 py-1 rounded-lg">
                                <span class="text-xs">⭐</span>
                                <span class="font-bold text-yellow-600">4.81</span>
                            </div>
                            <span class="bg-sky-100 text-sky-700 px-2 py-1 rounded-lg text-xs font-bold">Dasar</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Achievement Card 2 -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl md:rounded-3xl p-4 md:p-6 shadow-xl hover:shadow-2xl card-hover border border-sky-100 group">
                <div class="flex items-start space-x-3 md:space-x-4">
                    <div class="w-12 h-12 md:w-16 md:h-16 rounded-xl md:rounded-2xl overflow-hidden bg-gradient-to-br from-blue-400 via-indigo-500 to-purple-600 flex items-center justify-center text-xl md:text-2xl flex-shrink-0 shadow-lg group-hover:scale-110 transition-transform duration-300">
                        📊
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="w-2.5 h-2.5 md:w-3 md:h-3 bg-green-500 rounded-full status-dot shadow-sm"></span>
                            <span class="text-xs md:text-sm text-gray-600 font-semibold tracking-wide">Lulus</span>
                            <span class="text-xs md:text-sm text-gray-400">•</span>
                            <span class="text-xs md:text-sm text-sky-600 font-medium">16 Jam</span>
                        </div>
                        <h3 class="text-base md:text-lg font-bold text-gray-900 mb-2 md:mb-3 group-hover:text-sky-700 transition-colors">
                            Belajar Dasar Visualisasi Data
                        </h3>
                        <p class="text-xs md:text-sm text-gray-600 mb-3 md:mb-4 leading-relaxed line-clamp-2">
                            Pelajari teknik dasar untuk representasi hasil secara visual sehingga dapat menceritakan dan mempresentasikan data secara efektif.
                        </p>
                        <div class="flex items-center justify-between text-xs text-gray-500 space-x-2 md:space-x-4">
                            <div class="flex items-center space-x-1 bg-gray-50 px-2 py-1 rounded-lg">
                                <span class="text-xs">📚</span>
                                <span class="font-medium">50 Modul</span>
                            </div>
                            <div class="flex items-center space-x-1 bg-gray-50 px-2 py-1 rounded-lg">
                                <span class="text-xs">👥</span>
                                <span class="font-medium hidden sm:inline">131.521</span>
                                <span class="font-medium sm:hidden">131K</span>
                            </div>
                            <div class="flex items-center space-x-1 bg-yellow-50 px-2 py-1 rounded-lg">
                                <span class="text-xs">⭐</span>
                                <span class="font-bold text-yellow-600">4.86</span>
                            </div>
                            <span class="bg-sky-100 text-sky-700 px-2 py-1 rounded-lg text-xs font-bold">Dasar</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Achievement Card 3 -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl md:rounded-3xl p-4 md:p-6 shadow-xl hover:shadow-2xl card-hover border border-sky-100 group">
                <div class="flex items-start space-x-3 md:space-x-4">
                    <div class="w-12 h-12 md:w-16 md:h-16 rounded-xl md:rounded-2xl overflow-hidden bg-gradient-to-br from-purple-400 via-pink-500 to-red-500 flex items-center justify-center text-xl md:text-2xl flex-shrink-0 shadow-lg group-hover:scale-110 transition-transform duration-300">
                        🤖
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="w-2.5 h-2.5 md:w-3 md:h-3 bg-green-500 rounded-full status-dot shadow-sm"></span>
                            <span class="text-xs md:text-sm text-gray-600 font-semibold tracking-wide">Lulus</span>
                            <span class="text-xs md:text-sm text-gray-400">•</span>
                            <span class="text-xs md:text-sm text-sky-600 font-medium">30 Jam</span>
                        </div>
                        <h3 class="text-base md:text-lg font-bold text-gray-900 mb-2 md:mb-3 group-hover:text-sky-700 transition-colors">
                            Belajar Machine Learning untuk Pemula
                        </h3>
                        <p class="text-xs md:text-sm text-gray-600 mb-3 md:mb-4 leading-relaxed line-clamp-2">
                            Pelajari dasar machine learning dengan fokus materi supervised learning, unsupervised learning, hingga teknik meningkatkan performa model.
                        </p>
                        <div class="flex items-center justify-between text-xs text-gray-500 space-x-2 md:space-x-4">
                            <div class="flex items-center space-x-1 bg-gray-50 px-2 py-1 rounded-lg">
                                <span class="text-xs">📚</span>
                                <span class="font-medium">117 Modul</span>
                            </div>
                            <div class="flex items-center space-x-1 bg-gray-50 px-2 py-1 rounded-lg">
                                <span class="text-xs">👥</span>
                                <span class="font-medium hidden sm:inline">140.936</span>
                                <span class="font-medium sm:hidden">140K</span>
                            </div>
                            <div class="flex items-center space-x-1 bg-yellow-50 px-2 py-1 rounded-lg">
                                <span class="text-xs">⭐</span>
                                <span class="font-bold text-yellow-600">4.84</span>
                            </div>
                            <span class="bg-orange-100 text-orange-700 px-2 py-1 rounded-lg text-xs font-bold">Pemula</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Achievement Card 4 -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl md:rounded-3xl p-4 md:p-6 shadow-xl hover:shadow-2xl card-hover border border-sky-100 group">
                <div class="flex items-start space-x-3 md:space-x-4">
                    <div class="w-12 h-12 md:w-16 md:h-16 rounded-xl md:rounded-2xl overflow-hidden bg-gradient-to-br from-cyan-400 via-blue-500 to-indigo-600 flex items-center justify-center text-xl md:text-2xl flex-shrink-0 shadow-lg group-hover:scale-110 transition-transform duration-300">
                        🧠
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="w-2.5 h-2.5 md:w-3 md:h-3 bg-green-500 rounded-full status-dot shadow-sm"></span>
                            <span class="text-xs md:text-sm text-gray-600 font-semibold tracking-wide">Lulus</span>
                            <span class="text-xs md:text-sm text-gray-400">•</span>
                            <span class="text-xs md:text-sm text-sky-600 font-medium">10 Jam</span>
                        </div>
                        <h3 class="text-base md:text-lg font-bold text-gray-900 mb-2 md:mb-3 group-hover:text-sky-700 transition-colors">
                            Belajar Dasar AI
                        </h3>
                        <p class="text-xs md:text-sm text-gray-600 mb-3 md:mb-4 leading-relaxed line-clamp-2">
                            Kelas ini memberikan pemahaman terkait dasar-dasar Artificial Intelligence dan subbidang AI mencakup Machine Learning serta Deep Learning.
                        </p>
                        <div class="flex items-center justify-between text-xs text-gray-500 space-x-2 md:space-x-4">
                            <div class="flex items-center space-x-1 bg-gray-50 px-2 py-1 rounded-lg">
                                <span class="text-xs">📚</span>
                                <span class="font-medium">39 Modul</span>
                            </div>
                            <div class="flex items-center space-x-1 bg-gray-50 px-2 py-1 rounded-lg">
                                <span class="text-xs">👥</span>
                                <span class="font-medium hidden sm:inline">127.141</span>
                                <span class="font-medium sm:hidden">127K</span>
                            </div>
                            <div class="flex items-center space-x-1 bg-yellow-50 px-2 py-1 rounded-lg">
                                <span class="text-xs">⭐</span>
                                <span class="font-bold text-yellow-600">4.87</span>
                            </div>
                            <span class="bg-sky-100 text-sky-700 px-2 py-1 rounded-lg text-xs font-bold">Dasar</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Progress Section -->
        <div class="glass-effect bg-white/20 rounded-2xl md:rounded-3xl p-6 md:p-8 border border-white/30 text-sky-100 animate-slide-up">
            <h2 class="text-xl md:text-2xl font-bold text-center mb-6 md:mb-8 text-white">
                Progress Menuju Achievement Berikutnya
            </h2>

            <div class="space-y-4 md:space-y-6">
                <div class="group">
                    <div class="flex justify-between mb-2 font-semibold text-white">
                        <span class="text-sm md:text-base">Leadership Excellence</span>
                        <span class="text-sm md:text-base">80%</span>
                    </div>
                    <div class="w-full h-2 md:h-3 bg-white/30 rounded-full overflow-hidden">
                        <div class="h-full progress-bar rounded-full shadow-sm" style="width:80%"></div>
                    </div>
                </div>

                <div class="group">
                    <div class="flex justify-between mb-2 font-semibold text-white">
                        <span class="text-sm md:text-base">Innovation Master</span>
                        <span class="text-sm md:text-base">65%</span>
                    </div>
                    <div class="w-full h-2 md:h-3 bg-white/30 rounded-full overflow-hidden">
                        <div class="h-full progress-bar rounded-full shadow-sm" style="width:65%"></div>
                    </div>
                </div>

                <div class="group">
                    <div class="flex justify-between mb-2 font-semibold text-white">
                        <span class="text-sm md:text-base">Mentor Champion</span>
                        <span class="text-sm md:text-base">45%</span>
                    </div>
                    <div class="w-full h-2 md:h-3 bg-white/30 rounded-full overflow-hidden">
                        <div class="h-full progress-bar rounded-full shadow-sm" style="width:45%"></div>
                    </div>
                </div>

                <div class="group">
                    <div class="flex justify-between mb-2 font-semibold text-white">
                        <span class="text-sm md:text-base">Global Impact</span>
                        <span class="text-sm md:text-base">30%</span>
                    </div>
                    <div class="w-full h-2 md:h-3 bg-white/30 rounded-full overflow-hidden">
                        <div class="h-full progress-bar rounded-full shadow-sm" style="width:30%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.app')
</body>

</html>
