@extends('layouts.app')
@section('content')

<style>
    /* Custom gradient and glass effects */
    .bg-main-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .bg-card-gradient {
        background: linear-gradient(145deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.9) 100%);
    }

    .glass-effect {
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
    }

    .gradient-border::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea, #764ba2, #48bb78);
    }

    .floating-animation {
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .hero-decoration {
        position: absolute;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .scroll-fade-in {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s ease;
    }

    .scroll-fade-in.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Simplified card styles */
    .compact-info-badge {
        background: linear-gradient(135deg, rgba(79, 70, 229, 0.1) 0%, rgba(124, 58, 237, 0.1) 100%);
        border: 1px solid rgba(79, 70, 229, 0.2);
    }

    .mentor-badge {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.1) 0%, rgba(16, 185, 129, 0.1) 100%);
        border: 1px solid rgba(34, 197, 94, 0.2);
    }

    /* Search box styles */
    .search-container {
        position: relative;
        max-width: 500px;
        margin: 0 auto 40px;
    }

    .search-box {
        width: 100%;
        padding: 16px 50px 16px 20px;
        border: none;
        border-radius: 50px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        color: white;
        font-size: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .search-box::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }

    .search-box:focus {
        outline: none;
        background: rgba(255, 255, 255, 0.25);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
    }

    .search-icon {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: white;
        font-size: 20px;
    }

    .no-results {
        text-align: center;
        padding: 40px 20px;
        color: white;
    }

    .no-results i {
        font-size: 48px;
        margin-bottom: 16px;
        opacity: 0.7;
    }

    .no-results h3 {
        font-size: 24px;
        margin-bottom: 8px;
    }

    .no-results p {
        opacity: 0.8;
    }
</style>

<div class="bg-main-gradient min-h-screen -mx-4 -mt-5 px-6">
    <div class="max-w-6xl mx-auto">
        <!-- Hero Header Section -->
        <div class="relative text-center mb-12 px-4 pt-20 md:pt-24 lg:pt-10">
            <!-- Floating Decorative Elements -->
            <div class="hero-decoration w-24 h-24 absolute -top-2 -left-6 floating-animation" style="animation-delay: 0s;"></div>
            <div class="hero-decoration w-16 h-16 absolute top-6 -right-2 floating-animation" style="animation-delay: 2s;"></div>
            <div class="hero-decoration w-12 h-12 absolute -bottom-6 left-1/4 floating-animation" style="animation-delay: 4s;"></div>

            <div class="relative z-10">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 tracking-tight leading-tight">
                    <span class="block mb-2">Jelajahi</span>
                    <span class="block bg-gradient-to-r from-yellow-300 to-orange-300 bg-clip-text text-transparent">Kelas Terbaik</span>
                </h1>

                <p class="text-lg md:text-xl text-white/90 max-w-2xl mx-auto mb-10 leading-relaxed px-4">
                    Kembangkan potensi dirimu dengan kursus berkualitas dari mentor berpengalaman.
                    Tingkatkan kemampuanmu bersama platform pembelajaran terdepan.
                </p>

                @if(auth()->user()->isMentor())
                    <div class="flex flex-col sm:flex-row justify-center items-center gap-5 mb-8">
                        <a href="{{ route('classes.my') }}"
                           class="group px-8 py-3.5 bg-white/20 border-2 border-white/30 rounded-full text-white font-semibold transition-all duration-300 hover:bg-white/30 hover:scale-105 hover:-translate-y-1 glass-effect min-w-48 text-center">
                            <i class="fas fa-chalkboard-teacher mr-2 group-hover:rotate-12 transition-transform"></i>
                            Kelas Saya
                        </a>
                        <a href="{{ route('classes.create') }}"
                           class="group px-8 py-3.5 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-full transition-all duration-300 hover:from-green-600 hover:to-green-700 hover:scale-105 hover:-translate-y-1 shadow-xl min-w-48 text-center">
                            <i class="fas fa-plus mr-2 group-hover:rotate-90 transition-transform"></i>
                            Buat Kelas Baru
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Search Box -->
        <div class="search-container">
            <input type="text" id="searchInput" class="search-box" placeholder="Cari kelas atau mentor..." autocomplete="off">
            <div class="search-icon">
                <i class="fas fa-search"></i>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="mb-8 mx-2">
                <div class="bg-green-500/90 text-white px-6 py-4 rounded-2xl shadow-xl glass-effect border border-white/20 flex items-center gap-3">
                    <i class="fas fa-check-circle text-xl"></i>
                    <span class="font-medium flex-1">{{ session('success') }}</span>
                    <button type="button" class="text-white/80 hover:text-white transition-colors p-1" data-bs-dismiss="alert">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-8 mx-2">
                <div class="bg-red-500/90 text-white px-6 py-4 rounded-2xl shadow-xl glass-effect border border-white/20 flex items-center gap-3">
                    <i class="fas fa-exclamation-circle text-xl"></i>
                    <span class="font-medium flex-1">{{ session('error') }}</span>
                    <button type="button" class="text-white/80 hover:text-white transition-colors p-1" data-bs-dismiss="alert">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif

        <!-- Classes Content -->
        <div class="pb-16 md:pb-20 lg:pb-24">
            @if($classes->isEmpty())
                <!-- Empty State -->
                <div class="mx-2">
                    <div class="bg-card-gradient glass-effect rounded-3xl shadow-2xl border border-white/20 text-center py-16 px-8">
                        <div class="relative max-w-md mx-auto">
                            <div class="w-28 h-28 mx-auto mb-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center shadow-xl">
                                <i class="fas fa-graduation-cap text-4xl text-white"></i>
                            </div>

                            <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">Belum Ada Kelas Tersedia</h3>
                            <p class="text-base md:text-lg text-gray-600 mb-8 leading-relaxed">
                                Jadilah yang pertama mengeksplorasi peluang belajar yang menakjubkan! Kelas-kelas baru akan segera ditambahkan.
                            </p>

                            @if(auth()->user()->isMentor())
                                <a href="{{ route('classes.create') }}"
                                   class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-full transition-all duration-300 hover:from-indigo-700 hover:to-purple-700 hover:scale-105 hover:-translate-y-2 shadow-2xl">
                                    <i class="fas fa-rocket mr-3 group-hover:translate-x-1 transition-transform"></i>
                                    Buat Kelas Pertama
                                    <div class="absolute inset-0 rounded-full bg-gradient-to-r from-indigo-600 to-purple-600 opacity-0 group-hover:opacity-20 transition-opacity blur"></div>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <!-- No Results Message (Initially Hidden) -->
                <div id="noResults" class="no-results hidden">
                    <i class="fas fa-search"></i>
                    <h3>Tidak ada hasil ditemukan</h3>
                    <p>Coba gunakan kata kunci yang berbeda atau lebih umum</p>
                </div>

                <!-- Classes Grid -->
                <div id="classesGrid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 lg:gap-8 px-2">
                    @foreach($classes as $index => $class)
                        <div class="class-card scroll-fade-in group relative h-full"
                             data-class-name="{{ strtolower($class->name) }}"
                             data-mentor-name="{{ isset($class->mentor) ? strtolower($class->mentor->name) : '' }}"
                             style="animation-delay: {{ $index * 100 }}ms;">
                            <div class="bg-card-gradient glass-effect rounded-3xl shadow-xl border border-white/20 h-full flex flex-col relative overflow-hidden gradient-border transition-all duration-500 hover:shadow-2xl hover:-translate-y-3 hover:scale-[1.02]">
                                <!-- Hover Glow Effect -->
                                <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/10 to-purple-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-3xl"></div>

                                <div class="relative z-10 p-6 flex flex-col h-full">
                                    <!-- Class Title -->
                                    <div class="mb-4">
                                        <h3 class="text-xl font-bold text-gray-800 group-hover:text-indigo-700 transition-colors duration-300 leading-tight mb-2">
                                            {{ $class->name }}
                                        </h3>
                                        @if($class->description)
                                            <p class="text-gray-600 text-sm leading-relaxed line-clamp-2">
                                                {{ $class->description }}
                                            </p>
                                        @endif
                                    </div>

                                    <!-- Compact Info Section -->
                                    <div class="mb-4 space-y-3">
                                        <!-- MENTOR INFO (Main Focus - Clean & Elegant) -->
                                        <div class="mentor-badge rounded-2xl p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-300 shadow-md">
                                            <div class="flex items-center gap-3">
                                                <!-- Elegant Mentor Avatar with Profile Photo -->
                                                <div class="relative flex-shrink-0">
                                                    <div class="w-12 h-12 rounded-full overflow-hidden shadow-lg border-2 border-white">
                                                        @if($class->mentor && $class->mentor->avatar)
                                                            <img src="{{ asset('storage/' . $class->mentor->avatar) }}"
                                                                 alt="{{ $class->mentor->name }}"
                                                                 class="w-full h-full object-cover"
                                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                            {{-- Fallback if image fails to load --}}
                                                            <div class="w-full h-full flex items-center justify-center text-white font-bold text-lg bg-gradient-to-br from-green-500 to-emerald-600"
                                                                 style="display: none;">
                                                                {{ strtoupper(substr($class->mentor->name ?? 'M', 0, 2)) }}
                                                            </div>
                                                        @else
                                                            {{-- Fallback to UI Avatars if no avatar uploaded --}}
                                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($class->mentor->name ?? 'Mentor') }}&size=48&background=10b981&color=ffffff&font-size=0.6"
                                                                 alt="{{ $class->mentor->name ?? 'Mentor' }}"
                                                                 class="w-full h-full object-cover"
                                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                            {{-- Final fallback --}}
                                                            <div class="w-full h-full flex items-center justify-center text-white font-bold text-lg bg-gradient-to-br from-green-500 to-emerald-600"
                                                                 style="display: none;">
                                                                {{ strtoupper(substr($class->mentor->name ?? 'M', 0, 2)) }}
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>

                                                <div class="flex-1 min-w-0">
                                                    <!-- Mentor name with elegant styling -->
                                                    <h4 class="text-base font-bold text-gray-800 truncate mb-1">
                                                        {{ $class->mentor->name ?? 'Mentor Tidak Diketahui' }}
                                                    </h4>
                                                    <div class="flex items-center gap-2">
                                                        <span class="px-3 py-1 bg-gradient-to-r from-green-500 to-emerald-500 text-white rounded-full text-xs font-semibold">
                                                            eBuddy
                                                        </span>

                                                    </div>
                                                </div>

                                                <!-- Elegant right accent -->
                                                <div class="text-green-500 text-xl flex-shrink-0">
                                                    <i class="fas fa-user-tie"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Teacher & Class Info (Minimal & Subtle) -->
                                        @if($class->teacherClass && $class->teacherClass->teacher)
                                            <div class="bg-gray-50 rounded-lg p-3 border border-gray-200">
                                                <div class="flex items-center gap-2">
                                                    <!-- Small Teacher Avatar with Profile Photo -->
                                                    <div class="w-7 h-7 rounded-lg overflow-hidden shadow-sm border border-gray-300 flex-shrink-0">
                                                        @if($class->teacherClass->teacher->avatar)
                                                            <img src="{{ asset('storage/' . $class->teacherClass->teacher->avatar) }}"
                                                                 alt="{{ $class->teacherClass->teacher->name }}"
                                                                 class="w-full h-full object-cover"
                                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                            {{-- Fallback if image fails to load --}}
                                                            <div class="w-full h-full flex items-center justify-center text-white font-medium text-xs bg-gradient-to-br from-gray-400 to-gray-500"
                                                                 style="display: none;">
                                                                {{ strtoupper(substr($class->teacherClass->teacher->name, 0, 1)) }}
                                                            </div>
                                                        @else
                                                            {{-- Fallback to UI Avatars if no avatar uploaded --}}
                                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($class->teacherClass->teacher->name) }}&size=28&background=6b7280&color=ffffff&font-size=0.6"
                                                                 alt="{{ $class->teacherClass->teacher->name }}"
                                                                 class="w-full h-full object-cover"
                                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                            {{-- Final fallback --}}
                                                            <div class="w-full h-full flex items-center justify-center text-white font-medium text-xs bg-gradient-to-br from-gray-400 to-gray-500"
                                                                 style="display: none;">
                                                                {{ strtoupper(substr($class->teacherClass->teacher->name, 0, 1)) }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex items-center gap-2 text-sm">
                                                            <span class="font-medium text-gray-700 truncate">{{ $class->teacherClass->teacher->name }}</span>
                                                            <span class="text-gray-400">•</span>
                                                            <span class="text-gray-500 truncate">{{ $class->teacherClass->name }}</span>
                                                        </div>
                                                        <p class="text-xs text-gray-400 mt-0.5">eMaster</p>
                                                    </div>
                                                    <div class="text-gray-400 flex-shrink-0">
                                                        <i class="fas fa-graduation-cap text-sm"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Compact Stats -->
                                    <div class="mb-4">
                                        <div class="flex items-center justify-between text-sm">
                                            <div class="flex items-center gap-4">
                                                <div class="flex items-center gap-1 text-blue-600">
                                                    <i class="fas fa-book text-xs"></i>
                                                    <span class="font-semibold">{{ $class->materials->count() ?? 0 }}</span>
                                                </div>
                                                <div class="flex items-center gap-1 text-green-600">
                                                    <i class="fas fa-{{ ($class->is_active ?? true) ? 'check' : 'pause' }}-circle text-xs"></i>
                                                    <span class="font-semibold">{{ ($class->is_active ?? true) ? 'Aktif' : 'Nonaktif' }}</span>
                                                </div>
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ $class->created_at->format('d M Y') }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Button -->
                                    <div class="mt-auto">
                                        <a href="{{ route('classes.show', $class->id) }}"
                                           class="group/btn block w-full py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-2xl text-center transition-all duration-300 hover:from-indigo-700 hover:to-purple-700 hover:shadow-xl hover:-translate-y-1 relative overflow-hidden">
                                            <span class="relative z-10 flex items-center justify-center gap-2">
                                                <i class="fas fa-eye group-hover/btn:scale-110 transition-transform"></i>
                                                Lihat Detail
                                            </span>
                                            <div class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300"></div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const classCards = document.querySelectorAll('.class-card');
        const classesGrid = document.getElementById('classesGrid');
        const noResults = document.getElementById('noResults');

        // Add data attributes for search if not already present
        classCards.forEach(card => {
            const className = card.querySelector('h3').textContent.toLowerCase();
            const mentorName = card.querySelector('.mentor-badge h4')?.textContent.toLowerCase() || '';

            card.setAttribute('data-class-name', className);
            card.setAttribute('data-mentor-name', mentorName);
        });

        // Search function
        function performSearch() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            let hasResults = false;

            if (searchTerm === '') {
                // Show all cards if search is empty
                classCards.forEach(card => {
                    card.style.display = 'block';
                });
                if (noResults) noResults.classList.add('hidden');
                return;
            }

            // Filter cards based on search term
            classCards.forEach(card => {
                const className = card.getAttribute('data-class-name');
                const mentorName = card.getAttribute('data-mentor-name');

                if (className.includes(searchTerm) || mentorName.includes(searchTerm)) {
                    card.style.display = 'block';
                    hasResults = true;
                } else {
                    card.style.display = 'none';
                }
            });

            // Show/hide no results message
            if (noResults) {
                if (hasResults) {
                    noResults.classList.add('hidden');
                } else {
                    noResults.classList.remove('hidden');
                }
            }
        }

        // Event listener for search input
        searchInput.addEventListener('input', performSearch);

        // Add debounce to improve performance
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(performSearch, 300);
        });

        // Intersection Observer for scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('visible');
                    }, index * 150);
                }
            });
        }, observerOptions);

        // Observe all cards
        document.querySelectorAll('.scroll-fade-in').forEach(card => {
            observer.observe(card);
        });

        // Enhanced hover effects for buttons
        document.querySelectorAll('a[href*="classes.show"]').forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px) scale(1.02)';
            });

            btn.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Parallax effect for hero decorations
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const decorations = document.querySelectorAll('.hero-decoration');

            decorations.forEach((decoration, index) => {
                const speed = 0.3 + (index * 0.1);
                decoration.style.transform = `translateY(${scrolled * speed}px)`;
            });
        });

        // Auto-dismiss alerts
        setTimeout(() => {
            document.querySelectorAll('[data-bs-dismiss="alert"]').forEach(btn => {
                const alert = btn.closest('.mb-8');
                if (alert) {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    setTimeout(() => {
                        alert.remove();
                    }, 300);
                }
            });
        }, 5000);

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
    });

    // Add ripple animation CSS
    const style = document.createElement('style');
    style.textContent = `
        @keyframes ripple {
            to { transform: scale(4); opacity: 0; }
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    `;
    document.head.appendChild(style);
</script>
@endsection
