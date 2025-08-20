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
</style>

<div class="bg-main-gradient min-h-screen -mx-4 -mt-5 px-6">
    <div class="max-w-6xl mx-auto">
        <!-- Hero Header Section with proper top spacing -->
        <div class="relative text-center mb-20 px-4 pt-20 md:pt-24 lg:pt-10">
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

        <!-- Classes Content with bottom spacing -->
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
                <!-- Classes Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 lg:gap-8 px-2">
                    @foreach($classes as $index => $class)
                        <div class="scroll-fade-in group relative" style="animation-delay: {{ $index * 100 }}ms;">
                            <div class="bg-card-gradient glass-effect rounded-2xl lg:rounded-3xl shadow-xl border border-white/20 p-6 lg:p-8 h-full flex flex-col relative overflow-hidden gradient-border transition-all duration-500 hover:shadow-2xl hover:-translate-y-3 hover:scale-[1.02]">
                                <!-- Hover Glow Effect -->
                                <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/10 to-purple-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-2xl lg:rounded-3xl"></div>

                                <div class="relative z-10">
                                    <!-- Class Title -->
                                    <h3 class="text-xl lg:text-2xl font-bold text-gray-800 mb-4 group-hover:text-indigo-700 transition-colors duration-300 leading-tight">
                                        {{ $class->name }}
                                    </h3>

                                    <!-- Description -->
                                    @if($class->description)
                                        <p class="text-gray-600 leading-relaxed mb-6 flex-grow text-sm lg:text-base">
                                            {{ Str::limit($class->description, 120) }}
                                        </p>
                                    @else
                                        <div class="mb-6 flex-grow"></div>
                                    @endif

                                    <!-- Date Badge -->
                                    <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
                                        <div class="w-2 h-2 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full"></div>
                                        <span>Dibuat {{ $class->created_at->format('d M Y') }}</span>
                                    </div>

                                    <!-- Mentor Info -->
                                    <div class="flex items-center gap-4 mb-6 p-4 bg-gradient-to-r from-gray-50 to-indigo-50 rounded-xl lg:rounded-2xl border border-gray-100 group-hover:from-indigo-50 group-hover:to-purple-50 transition-all duration-300">
                                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg group-hover:scale-110 transition-transform duration-300 flex-shrink-0">
                                            {{ strtoupper(substr($class->mentor->name ?? 'U', 0, 2)) }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-bold text-gray-800 text-base lg:text-lg truncate">{{ $class->mentor->name ?? 'Mentor Tidak Diketahui' }}</h4>
                                            <p class="text-sm text-gray-500">Instruktur Ahli</p>
                                        </div>
                                        <div class="w-3 h-3 bg-green-400 rounded-full shadow-lg animate-pulse flex-shrink-0"></div>
                                    </div>

                                    <!-- Action Button -->
                                    <a href="{{ route('classes.show', $class->id) }}"
                                       class="group/btn block w-full py-3.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl lg:rounded-2xl text-center transition-all duration-300 hover:from-indigo-700 hover:to-purple-700 hover:shadow-xl hover:-translate-y-1 relative overflow-hidden text-sm lg:text-base">
                                        <span class="relative z-10 flex items-center justify-center gap-2">
                                            <i class="fas fa-eye group-hover/btn:scale-110 transition-transform"></i>
                                            Lihat Detail Kelas
                                        </span>
                                        <div class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300"></div>
                                    </a>
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
    `;
    document.head.appendChild(style);
</script>
@endsection
