@extends('layouts.app')

@section('content')
<style>
    .bg-main-gradient {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    .bg-success-gradient {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .bg-success-gradient:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
    }

    .request-card {
        transition: all 0.3s ease;
    }

    .request-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }

    .score-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
</style>

<div class="bg-main-gradient min-h-screen -mx-4 -mt-5 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto px-8 py-8 font-sans">
        <!-- Header Section -->
        <div class="relative mb-12 p-8 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl text-white overflow-hidden">
            <div class="relative z-10">
                <h1 class="text-4xl font-extrabold mb-2">
                    <i class="fas fa-user-check me-3"></i>Approval Management
                </h1>
                <p class="text-lg opacity-90 mb-6">Kelola permintaan approval post test dari siswa</p>
            </div>

            <!-- Decorative circles -->
            <div class="absolute top-0 right-0 w-full h-full overflow-hidden pointer-events-none">
                <div class="absolute -top-12 -right-12 w-48 h-48 bg-white bg-opacity-10 rounded-full"></div>
                <div class="absolute top-1/2 right-24 w-36 h-36 bg-white bg-opacity-10 rounded-full"></div>
                <div class="absolute -bottom-8 right-48 w-24 h-24 bg-white bg-opacity-10 rounded-full"></div>
            </div>
        </div>

        <!-- Main Card -->
        <div class="relative -mt-12 z-10">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <div class="p-8">
                    @if($requests->isEmpty())
                        <!-- Empty State -->
                        <div class="text-center py-16 px-8 bg-gray-50 rounded-xl border-2 border-dashed border-gray-300">
                            <div class="text-6xl text-gray-400 mb-6">
                                <i class="fas fa-clipboard-check"></i>
                            </div>
                            <h3 class="text-2xl font-semibold text-gray-600 mb-2">Tidak Ada Request Approval</h3>
                            <p class="text-gray-500 text-lg">Semua request approval telah diproses atau belum ada siswa yang meminta approval.</p>
                        </div>
                    @else
                        <!-- Stats Header -->
                        <div class="bg-blue-50 p-6 rounded-xl mb-8 border border-blue-200">
                            <div class="flex items-center justify-center gap-8 flex-wrap">
                                <div class="flex items-center gap-2.5 text-blue-700 font-semibold">
                                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <span>{{ $requests->count() }} Permintaan Menunggu</span>
                                </div>
                            </div>
                        </div>

                        <!-- Requests Grid -->
                        <div class="space-y-6">
                            @foreach($requests as $request)
                                @php
                                    $lastAttempt = App\Models\PostTestAttempt::where('post_test_id', $request->post_test_id)
                                        ->where('user_id', $request->user_id)
                                        ->whereNotNull('finished_at')
                                        ->latest()
                                        ->first();
                                    $score = $lastAttempt ? $lastAttempt->getPercentageAttribute() : 0;
                                @endphp

                                <div class="request-card bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-lg transition-all duration-300">
                                    <div class="p-6">
                                        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-center">
                                            <!-- Student Info -->
                                            <div class="lg:col-span-1">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                                        {{ substr($request->user->name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <h4 class="font-semibold text-gray-800">{{ $request->user->name }}</h4>
                                                        <p class="text-sm text-gray-600">{{ $request->user->email }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Class & Test Info -->
                                            <div class="lg:col-span-1">
                                                <div class="space-y-2">
                                                    <div>
                                                        <span class="text-xs text-gray-500 uppercase tracking-wide">Kelas</span>
                                                        <p class="font-medium text-gray-800">{{ $request->postTest->class->name }}</p>
                                                    </div>
                                                    <div>
                                                        <span class="text-xs text-gray-500 uppercase tracking-wide">Post Test</span>
                                                        <p class="font-medium text-gray-800">{{ $request->postTest->title ?? 'Post Test' }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Attempt & Score Info -->
                                            <div class="lg:col-span-1">
                                                <div class="space-y-3">
                                                    <div class="flex items-center gap-2">
                                                        <span class="text-xs text-gray-500 uppercase tracking-wide">Attempt</span>
                                                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-semibold">
                                                            #{{ $request->attempt_number }}
                                                        </span>
                                                    </div>

                                                    <div>
                                                        <span class="text-xs text-gray-500 uppercase tracking-wide">Nilai Terakhir</span>
                                                        <div class="score-badge">
                                                            <span class="text-2xl font-bold {{ $score >= 80 ? 'text-green-600' : 'text-red-600' }}">
                                                                {{ $score }}%
                                                            </span>
                                                            <span class="text-xs {{ $score >= 80 ? 'text-green-500 bg-green-50' : 'text-red-500 bg-red-50' }} px-2 py-1 rounded-full font-medium">
                                                                {{ $score >= 80 ? 'LULUS' : 'TIDAK LULUS' }}
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                                        <div class="h-2 rounded-full transition-all duration-1000 {{ $score >= 80 ? 'bg-gradient-to-r from-green-400 to-green-600' : 'bg-gradient-to-r from-red-400 to-red-600' }}"
                                                             style="width: {{ $score }}%"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Date & Action -->
                                            <div class="lg:col-span-1">
                                                <div class="space-y-4">
                                                    <div>
                                                        <span class="text-xs text-gray-500 uppercase tracking-wide">Tanggal Request</span>
                                                        <p class="font-medium text-gray-700">{{ $request->approval_requested_at->format('d M Y') }}</p>
                                                        <p class="text-sm text-gray-500">{{ $request->approval_requested_at->format('H:i') }}</p>
                                                    </div>

                                                    <form action="{{ route('post_tests.approve_attempt', [$request->postTest, $request->id]) }}" method="POST" class="w-full">
                                                        @csrf
                                                        <button type="submit"
                                                                class="w-full bg-success-gradient text-white px-4 py-3 rounded-lg font-semibold hover:-translate-y-0.5 transition-all duration-300 shadow-md"
                                                                onclick="return confirm('Approve request dari {{ $request->user->name }}?\n\nSiswa akan dapat mengerjakan post test lagi setelah disetujui.')">
                                                            <i class="fas fa-check mr-2"></i>Approve Request
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Timeline indicator -->
                                    <div class="border-t border-gray-100 px-6 py-3 bg-gray-50">
                                        <div class="flex items-center gap-2 text-xs text-gray-500">
                                            <i class="fas fa-clock"></i>
                                            <span>Menunggu approval sejak {{ $request->approval_requested_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination if needed -->
                        @if(method_exists($requests, 'links'))
                            <div class="mt-8">
                                {{ $requests->links() }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced JavaScript for better UX -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add ripple effect to approval buttons
    document.querySelectorAll('button[type="submit"]').forEach(button => {
        button.addEventListener('click', function(e) {
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

    // Smooth scroll animation for request cards
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

    // Observe all request cards
    document.querySelectorAll('.request-card').forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = `opacity 0.6s ease-out ${index * 0.1}s, transform 0.6s ease-out ${index * 0.1}s`;
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

<!-- Responsive adjustments -->
<style>
@media (max-width: 1024px) {
    .request-card .grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    .request-card .lg\\:col-span-1 {
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: 1rem;
    }

    .request-card .lg\\:col-span-1:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
}

@media (max-width: 768px) {
    .score-badge {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
    }

    .max-w-7xl {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}
</style>
@endsection
