@extends('layouts.app')

@section('content')
<style>
    /* Minimal custom styles untuk complex gradients */
    .bg-main-gradient {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    .gradient-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #6366f1 40%, #8b5cf6 100%);
    }

    .gradient-success {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    }

    .gradient-success:hover {
        background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
    }

    .backdrop-blur-custom {
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
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
</style>

<div class="bg-main-gradient min-h-screen -mx-4 -mt-5 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto px-8 py-8 font-sans">
        <!-- Header Section - Updated to match create material page -->
        <div class="relative mb-12 p-8 bg-gradient-to-br from-indigo-600 to-purple-700 rounded-2xl text-white overflow-hidden">
            <div class="relative z-10">
                <h1 class="text-4xl font-extrabold mb-2">{{ $class->name }}</h1>
                <p class="text-lg opacity-90 mb-6">Explore and manage your learning materials</p>

                <div class="flex flex-wrap gap-3 sm:gap-4">
                    <a href="{{ route('classes.index') }}"
                       class="group inline-flex items-center gap-2 px-4 sm:px-6 py-2.5 sm:py-3 bg-white text-indigo-600 font-semibold rounded-lg transition-all duration-300 hover:bg-indigo-50 hover:-translate-y-1 text-sm sm:text-base">
                        <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                        <span>Kembali ke Kelas</span>
                    </a>

                    @if($class->mentor_id === auth()->id())
                        <a href="{{ route('classes.edit', $class->id) }}"
                           class="group inline-flex items-center gap-2 px-4 sm:px-6 py-2.5 sm:py-3 bg-yellow-400 hover:bg-yellow-300 text-yellow-900 font-semibold rounded-lg transition-all duration-300 hover:-translate-y-1 text-sm sm:text-base">
                            <i class="fas fa-edit group-hover:rotate-12 transition-transform"></i>
                            <span>Edit Kelas</span>
                        </a>

                        <form action="{{ route('classes.destroy', $class->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="group inline-flex items-center gap-2 px-4 sm:px-6 py-2.5 sm:py-3 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg transition-all duration-300 hover:-translate-y-1 text-sm sm:text-base"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus kelas ini?')">
                                <i class="fas fa-trash group-hover:scale-110 transition-transform"></i>
                                <span>Hapus Kelas</span>
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Decorative circles - same as create page -->
            <div class="absolute top-0 right-0 w-full h-full overflow-hidden pointer-events-none">
                <div class="absolute -top-12 -right-12 w-48 h-48 bg-white bg-opacity-10 rounded-full"></div>
                <div class="absolute top-1/2 right-24 w-36 h-36 bg-white bg-opacity-10 rounded-full"></div>
                <div class="absolute -bottom-8 right-48 w-24 h-24 bg-white bg-opacity-10 rounded-full"></div>
            </div>
        </div>

        <!-- Card Container - Updated positioning to match create page -->
        <div class="relative -mt-12 z-10">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden card-entrance">
                <!-- Content Section -->
                <div class="p-6 sm:p-8 lg:p-12 space-y-8">
                    <!-- Description Section -->
                    <div class="bg-slate-50 rounded-2xl p-6 lg:p-8 border-l-4 border-blue-500">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-10 h-10 gradient-primary rounded-full flex items-center justify-center">
                                <i class="fas fa-info-circle text-white"></i>
                            </div>
                            <h3 class="text-xl lg:text-2xl font-semibold text-gray-800">
                                Deskripsi Kelas
                            </h3>
                        </div>

                        @if($class->description)
                            <p class="text-base lg:text-lg text-gray-600 leading-relaxed">
                                {{ $class->description }}
                            </p>
                        @else
                            <div class="text-center py-12">
                                <div class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-file-alt text-2xl text-gray-400"></i>
                                </div>
                                <p class="text-gray-500 italic">Belum ada deskripsi untuk kelas ini.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Student Learning Section -->
                    @if(auth()->user()->role === 'siswa' || auth()->user()->role === 'mentor' && $class->mentor_id !== auth()->id())
                        <div class="bg-white border-2 border-gray-200 rounded-2xl p-8 lg:p-12 text-center">
                            <div class="w-20 h-20 gradient-success rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-graduation-cap text-3xl text-white"></i>
                            </div>

                            <h3 class="text-2xl lg:text-3xl font-semibold text-gray-800 mb-4">
                                Siap untuk Belajar?
                            </h3>
                            <p class="text-gray-600 mb-8 text-lg">
                                Mulai perjalanan belajar Anda dengan kelas ini
                            </p>

                            <a href="{{ route('classes.learn', $class->id) }}"
                               class="group gradient-success hover:shadow-xl inline-flex items-center gap-3 px-8 py-4 text-white font-semibold rounded-xl transition-all duration-300 hover:-translate-y-2 text-lg">
                                <i class="fas fa-book-open group-hover:scale-110 transition-transform"></i>
                                <span>Mulai Belajar</span>
                            </a>
                        </div>
                    @endif

                    <!-- Mentor Management Section -->
                    @if($class->mentor_id === auth()->id())
                        <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-2xl p-8">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-10 h-10 gradient-primary rounded-full flex items-center justify-center">
                                    <i class="fas fa-cogs text-white"></i>
                                </div>
                                <h3 class="text-xl lg:text-2xl font-semibold text-gray-800">
                                    Pengelolaan Kelas
                                </h3>
                            </div>

                            <p class="text-gray-600 text-center mb-8">
                                Kelola materi dan konten kelas Anda
                            </p>

                            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                <a href="{{ route('materials.create', [$class->id]) }}"
                                   class="group gradient-success hover:shadow-xl inline-flex items-center justify-center gap-3 px-6 py-3 text-white font-semibold rounded-xl transition-all duration-300 hover:-translate-y-1">
                                    <i class="fas fa-plus group-hover:rotate-90 transition-transform"></i>
                                    <span>Tambah Materi</span>
                                </a>

                                <a href="{{ route('classes.learn', $class->id) }}"
                                   class="group gradient-primary hover:shadow-xl inline-flex items-center justify-center gap-3 px-6 py-3 text-white font-semibold rounded-xl transition-all duration-300 hover:-translate-y-1">
                                    <i class="fas fa-eye group-hover:scale-110 transition-transform"></i>
                                    <span>Lihat Materi</span>
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Info Grid Section -->
                    <div class="bg-slate-50 rounded-2xl p-6 lg:p-8 border border-gray-200">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
                            <!-- Mentor Info -->
                            <div class="bg-white rounded-xl p-4 lg:p-6 shadow-sm flex items-center gap-4">
                                <div class="w-10 h-10 gradient-primary rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-chalkboard-teacher text-white text-sm"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">
                                        Mentor
                                    </p>
                                    <p class="text-base font-semibold text-gray-800 truncate">
                                        {{ $class->mentor->name ?? 'Tidak Diketahui' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Created Date -->
                            <div class="bg-white rounded-xl p-4 lg:p-6 shadow-sm flex items-center gap-4">
                                <div class="w-10 h-10 gradient-primary rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-calendar-plus text-white text-sm"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">
                                        Dibuat
                                    </p>
                                    <p class="text-base font-semibold text-gray-800">
                                        {{ $class->created_at->format('j M Y') }}
                                    </p>
                                </div>
                            </div>

                            <!-- Last Updated -->
                            <div class="bg-white rounded-xl p-4 lg:p-6 shadow-sm flex items-center gap-4 sm:col-span-2 lg:col-span-1">
                                <div class="w-10 h-10 gradient-primary rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-clock text-white text-sm"></i>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">
                                        Terakhir Diperbarui
                                    </p>
                                    <p class="text-base font-semibold text-gray-800">
                                        {{ $class->updated_at->format('j M Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Enhanced hover effects untuk buttons
        document.querySelectorAll('a, button').forEach(element => {
            element.addEventListener('mouseenter', function() {
                if (this.classList.contains('hover:-translate-y-1') || this.classList.contains('hover:-translate-y-2')) {
                    this.style.transform = this.classList.contains('hover:-translate-y-2')
                        ? 'translateY(-8px)'
                        : 'translateY(-4px)';
                }
            });

            element.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Add ripple effect
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

        // Smooth scroll to sections
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
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

    // Add ripple animation CSS
    const style = document.createElement('style');
    style.textContent = `
        @keyframes ripple {
            to { transform: scale(4); opacity: 0; }
        }

        /* Responsive adjustments */
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
    `;
    document.head.appendChild(style);
</script>
@endsection
