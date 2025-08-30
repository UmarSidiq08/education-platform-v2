@extends('layouts.app')

@section('content')
<style>
    /* Minimal custom styles untuk gradients kompleks */
    .bg-main-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .gradient-primary {
        background: linear-gradient(45deg, #667eea, #764ba2);
    }

    .gradient-primary:hover {
        background: linear-gradient(45deg, #5a6fd1, #6740a0);
    }

    .gradient-success {
        background: linear-gradient(45deg, #48bb78, #38a169);
    }

    .gradient-success:hover {
        background: linear-gradient(45deg, #38a169, #2f855a);
    }

    .card-entrance {
        animation: slideUpFade 0.6s ease-out forwards;
    }

    @keyframes slideUpFade {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .floating-decoration {
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-10px) rotate(5deg); }
    }

    /* Enhanced Mobile Responsiveness */
    @media (max-width: 640px) {
        .bg-main-gradient {
            min-height: 100vh;
            padding-left: 20px;
            padding-right: 20px;
        }

        /* Mobile header adjustments */
        .mobile-header {
            padding-top: 60px !important;
            padding-left: 16px !important;
            padding-right: 16px !important;
            margin-bottom: 32px !important;
        }

        /* Mobile title container spacing */
        .mobile-title-container {
            padding-left: 8px !important;
            padding-right: 8px !important;
            margin-bottom: 20px !important;
        }

        /* Mobile title sizing */
        .mobile-title {
            font-size: 2rem !important;
            line-height: 1.1 !important;
            margin-bottom: 12px !important;
        }

        /* Mobile description */
        .mobile-description {
            font-size: 1rem !important;
            margin-bottom: 24px !important;
            padding-left: 8px !important;
            padding-right: 8px !important;
            line-height: 1.5 !important;
        }

        /* Mobile button container */
        .mobile-buttons {
            flex-direction: column;
            gap: 12px;
            width: 100%;
        }

        /* Mobile button sizing */
        .mobile-btn {
            width: 100%;
            padding: 16px 20px !important;
            font-size: 1rem !important;
        }

        /* Mobile card adjustments */
        .mobile-card {
            margin: 0 -4px;
            padding: 20px !important;
            border-radius: 20px !important;
        }

        /* Mobile empty state */
        .mobile-empty-state {
            padding: 32px 20px !important;
            margin: 0 4px;
        }

        /* Mobile empty state icon */
        .mobile-empty-icon {
            width: 80px !important;
            height: 80px !important;
            margin-bottom: 24px !important;
        }

        /* Mobile empty state text */
        .mobile-empty-title {
            font-size: 1.5rem !important;
            margin-bottom: 16px !important;
        }

        .mobile-empty-desc {
            font-size: 0.95rem !important;
            margin-bottom: 24px !important;
        }

        /* Mobile class card grid */
        .mobile-grid {
            grid-template-columns: 1fr !important;
            gap: 20px !important;
            padding: 0 4px;
        }

        /* Mobile class card content */
        .mobile-class-card {
            padding: 20px !important;
            border-radius: 20px !important;
        }

        .mobile-class-title {
            font-size: 1.25rem !important;
            line-height: 1.3 !important;
        }

        .mobile-class-desc {
            font-size: 0.9rem !important;
        }

        /* Mobile action buttons */
        .mobile-actions {
            flex-direction: column;
            gap: 8px;
        }

        .mobile-action-btn {
            width: 100%;
            padding: 12px 16px !important;
            font-size: 0.9rem !important;
        }

        /* Mobile floating decorations - hide on very small screens */
        .floating-decoration {
            display: none;
        }

        /* Mobile alert */
        .mobile-alert {
            margin: 0 8px 32px 8px;
            padding: 16px 20px !important;
            border-radius: 16px !important;
        }

        /* Touch-friendly hover states */
        .touch-friendly:active {
            transform: scale(0.98);
        }
    }

    /* Tablet adjustments */
    @media (min-width: 641px) and (max-width: 1024px) {
        .tablet-grid {
            grid-template-columns: repeat(2, 1fr) !important;
        }

        .tablet-header {
            padding-top: 80px !important;
        }

        .tablet-buttons {
            flex-direction: row;
            gap: 16px;
        }
    }

    /* Small mobile (iPhone SE, etc) */
    @media (max-width: 375px) {
        .xs-mobile-padding {
            padding-left: 8px !important;
            padding-right: 8px !important;
        }

        .xs-mobile-title {
            font-size: 1.75rem !important;
        }

        .xs-mobile-card {
            padding: 16px !important;
        }

        .xs-mobile-btn {
            padding: 14px 16px !important;
            font-size: 0.9rem !important;
        }
    }
</style>

<div class="bg-main-gradient min-h-screen -mx-4 -mt-5 px-4 sm:px-6 lg:px-8 xs-mobile-padding">
    <div class="max-w-7xl mx-auto">
        <!-- Decorative Elements - Hidden on mobile -->
        <div class="absolute top-20 left-10 w-20 h-20 bg-white/10 rounded-full floating-decoration hidden lg:block" style="animation-delay: 0s;"></div>
        <div class="absolute top-32 right-20 w-16 h-16 bg-white/5 rounded-full floating-decoration hidden lg:block" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-40 left-1/4 w-12 h-12 bg-white/10 rounded-full floating-decoration hidden lg:block" style="animation-delay: 4s;"></div>

        <!-- Header Section -->
        <div class="relative flex flex-col lg:flex-row lg:justify-between lg:items-center mb-12 gap-6 pt-20 md:pt-24 lg:pt-12 mobile-header tablet-header xs-mobile-header">
            <div class="flex-1 min-w-0 mobile-title-container xs-mobile-title-container">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-chalkboard-teacher text-white text-lg sm:text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-2 tracking-tight mobile-title xs-mobile-title">
                            Kelas Saya
                        </h1>
                        <div class="w-20 sm:w-24 h-1 bg-gradient-to-r from-yellow-300 to-orange-300 rounded-full"></div>
                    </div>
                </div>
                <p class="text-base sm:text-lg text-white/90 max-w-2xl leading-relaxed mobile-description xs-mobile-description">
                    Kelola semua kelas yang telah Anda buat dan pantau perkembangan mengajar Anda
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 lg:flex-shrink-0 mobile-buttons tablet-buttons">
                <a href="{{ route('classes.index') }}"
                   class="group flex items-center justify-center gap-3 px-4 sm:px-6 py-3 bg-white/10 border-2 border-white/30 rounded-2xl text-white font-medium transition-all duration-300 hover:bg-white/20 hover:border-white/50 hover:scale-105 hover:-translate-y-1 backdrop-blur-sm mobile-btn touch-friendly">
                    <i class="fas fa-list group-hover:rotate-12 transition-transform"></i>
                    <span>Semua Kelas</span>
                </a>
                <a href="{{ route('classes.create') }}"
                   class="group gradient-success flex items-center justify-center gap-3 px-4 sm:px-6 py-3 text-white font-medium rounded-2xl transition-all duration-300 hover:scale-105 hover:-translate-y-1 shadow-xl hover:shadow-2xl mobile-btn touch-friendly">
                    <i class="fas fa-plus group-hover:rotate-90 transition-transform"></i>
                    <span>Kelas Baru</span>
                </a>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="mb-8 mobile-alert">
                <div class="bg-green-500/90 backdrop-blur-sm text-white px-4 sm:px-6 py-4 rounded-2xl shadow-xl border border-white/20 flex items-center gap-4 card-entrance">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-check text-sm sm:text-lg"></i>
                    </div>
                    <span class="font-medium flex-1 text-sm sm:text-base">{{ session('success') }}</span>
                    <button type="button" class="text-white/80 hover:text-white transition-colors p-2 rounded-lg hover:bg-white/10 touch-friendly" data-bs-dismiss="alert">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>
            </div>
        @endif

        <!-- Content Section -->
        <div class="pb-16 md:pb-20 lg:pb-24">
            @if($classes->isEmpty())
            <!-- Empty State -->
            <div class="max-w-2xl mx-auto">
                <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl border border-white/20 text-center p-8 sm:p-12 card-entrance mobile-empty-state xs-mobile-card">
                    <div class="relative mb-6 sm:mb-8">
                        <div class="w-24 h-24 sm:w-28 sm:h-28 mx-auto bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-2xl transform rotate-3 mobile-empty-icon">
                            <i class="fas fa-chalkboard-teacher text-3xl sm:text-4xl text-white"></i>
                        </div>
                        <div class="absolute -top-2 -right-2 w-6 h-6 sm:w-8 sm:h-8 bg-yellow-400 rounded-full flex items-center justify-center">
                            <i class="fas fa-plus text-white text-xs sm:text-sm"></i>
                        </div>
                    </div>

                    <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-800 mb-3 sm:mb-4 mobile-empty-title">
                        Belum Ada Kelas yang Dibuat
                    </h3>
                    <p class="text-gray-600 mb-6 sm:mb-8 leading-relaxed text-sm sm:text-lg mobile-empty-desc">
                        Mulai berbagi pengetahuan Anda dengan membuat kelas pertama. Rancang konten yang menarik dan bantu siswa belajar secara efektif.
                    </p>

                    <a href="{{ route('classes.create') }}"
                       class="group gradient-primary inline-flex items-center gap-3 px-6 sm:px-8 py-3 sm:py-4 text-white font-semibold rounded-2xl transition-all duration-300 hover:scale-105 hover:-translate-y-2 shadow-xl hover:shadow-2xl mobile-btn touch-friendly">
                        <i class="fas fa-rocket group-hover:translate-x-1 transition-transform"></i>
                        <span class="text-sm sm:text-base">Buat Kelas Pertama</span>
                    </a>
                </div>
            </div>
        @else
            <!-- Classes Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 lg:gap-8 mobile-grid tablet-grid">
                @foreach($classes as $index => $class)
                    <div class="group relative card-entrance" style="animation-delay: {{ $index * 0.1 }}s;">
                        <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-xl border border-white/20 p-6 lg:p-8 h-full flex flex-col transition-all duration-500 hover:shadow-2xl hover:-translate-y-3 hover:scale-[1.02] relative overflow-hidden mobile-class-card xs-mobile-card">
                            <!-- Hover Glow Effect -->
                            <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/10 to-purple-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-3xl"></div>

                            <!-- Top Border Gradient -->
                            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-t-3xl"></div>

                            <div class="relative z-10 flex flex-col h-full">
                                <!-- Class Header -->
                                <div class="mb-4 sm:mb-6">
                                    <h3 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-800 mb-2 sm:mb-3 group-hover:text-indigo-700 transition-colors duration-300 leading-tight mobile-class-title">
                                        {{ $class->name }}
                                    </h3>

                                    @if($class->description)
                                        <p class="text-gray-600 leading-relaxed text-sm lg:text-base mb-3 sm:mb-4 mobile-class-desc">
                                            {{ Str::limit($class->description, 100) }}
                                        </p>
                                    @endif

                                    <!-- Date Info -->
                                    <div class="flex items-center gap-2 sm:gap-3 text-xs sm:text-sm text-gray-500 bg-gray-50 rounded-xl px-3 sm:px-4 py-2">
                                        <div class="w-2 h-2 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full animate-pulse"></div>
                                        <span>Dibuat {{ $class->created_at->format('d M Y') }}</span>
                                    </div>
                                </div>

                                <!-- Spacer untuk push footer ke bawah -->
                                <div class="flex-grow"></div>

                                <!-- Action Buttons -->
                                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 pt-3 sm:pt-4 border-t border-gray-100 mobile-actions">
                                    <a href="{{ route('classes.show', $class->id) }}"
                                       class="group/btn gradient-primary flex items-center justify-center gap-2 px-3 sm:px-4 py-2 sm:py-3 text-white font-medium rounded-xl transition-all duration-300 hover:scale-105 hover:-translate-y-1 shadow-lg hover:shadow-xl flex-1 mobile-action-btn xs-mobile-btn touch-friendly">
                                        <i class="fas fa-eye group-hover/btn:scale-110 transition-transform text-sm"></i>
                                        <span class="text-sm sm:text-base">Lihat</span>
                                    </a>

                                    <a href="{{ route('classes.edit', $class->id) }}"
                                       class="group/btn bg-amber-100 hover:bg-amber-200 text-amber-700 hover:text-amber-800 flex items-center justify-center gap-2 px-3 sm:px-4 py-2 sm:py-3 font-medium rounded-xl transition-all duration-300 hover:scale-105 hover:-translate-y-1 border border-amber-200 mobile-action-btn xs-mobile-btn touch-friendly">
                                        <i class="fas fa-edit group-hover/btn:scale-110 transition-transform text-sm"></i>
                                        <span class="text-sm sm:text-base">Edit</span>
                                    </a>

                                    <form action="{{ route('classes.destroy', $class->id) }}" method="POST" class="inline flex-1 sm:flex-none">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="group/btn bg-red-100 hover:bg-red-200 text-red-700 hover:text-red-800 flex items-center justify-center gap-2 px-3 sm:px-4 py-2 sm:py-3 font-medium rounded-xl transition-all duration-300 hover:scale-105 hover:-translate-y-1 border border-red-200 w-full mobile-action-btn xs-mobile-btn touch-friendly"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">
                                            <i class="fas fa-trash group-hover/btn:scale-110 transition-transform text-sm"></i>
                                            <span class="text-sm sm:text-base">Hapus</span>
                                        </button>
                                    </form>
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
        // Enhanced Intersection Observer for better animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('card-entrance');
                    }, index * 100);
                }
            });
        }, observerOptions);

        // Observe all cards
        document.querySelectorAll('.group.relative:not(.card-entrance)').forEach(card => {
            observer.observe(card);
        });

        // Enhanced hover effects - adjusted for mobile
        document.querySelectorAll('[class*="group/btn"]').forEach(btn => {
            // Only apply hover effects on non-touch devices
            if (!('ontouchstart' in window)) {
                btn.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px) scale(1.05)';
                });
                btn.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            }
        });

        // Auto-dismiss alerts
        setTimeout(() => {
            const alerts = document.querySelectorAll('[data-bs-dismiss="alert"]');
            alerts.forEach(btn => {
                const alert = btn.closest('.mb-8, .mobile-alert');
                if (alert) {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    setTimeout(() => alert.remove(), 300);
                }
            });
        }, 5000);

        // Add ripple effect to buttons - optimized for mobile
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

        // Parallax effect for floating decorations - disabled on mobile for performance
        if (window.innerWidth > 1024) {
            window.addEventListener('scroll', () => {
                const scrolled = window.pageYOffset;
                const decorations = document.querySelectorAll('.floating-decoration');

                decorations.forEach((decoration, index) => {
                    const speed = 0.2 + (index * 0.1);
                    decoration.style.transform += ` translateY(${scrolled * speed}px)`;
                });
            });
        }

        // Handle orientation changes on mobile
        window.addEventListener('orientationchange', function() {
            setTimeout(() => {
                // Recalculate layout if needed
                window.scrollTo(0, 0);
            }, 100);
        });

        // Optimize touch interactions
        let touchTimeout;
        document.addEventListener('touchstart', function() {
            clearTimeout(touchTimeout);
        });

        document.addEventListener('touchend', function() {
            touchTimeout = setTimeout(() => {
                // Reset any lingering hover states
                document.querySelectorAll(':hover').forEach(element => {
                    if (element.blur) element.blur();
                });
            }, 300);
        });
    });

    // Add ripple animation CSS
    const style = document.createElement('style');
    style.textContent = `
        @keyframes ripple {
            to { transform: scale(4); opacity: 0; }
        }

        /* Prevent zoom on input focus on iOS */
        input, select, textarea, button {
            font-size: 16px;
        }

        /* Smooth scrolling for mobile */
        @media (max-width: 640px) {
            html {
                scroll-behavior: smooth;
            }

            body {
                -webkit-overflow-scrolling: touch;
            }
        }

        /* Disable animations on reduced motion preference */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    `;
    document.head.appendChild(style);
</script>
@endsection
