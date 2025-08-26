@extends('layouts.app')

@section('title', 'Detail Achievement - ' . $class->name)

@section('content')
<!-- Option 1: Gradient background -->
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 p-4 md:p-6">
    <!-- Alternative gradient options:
    bg-gradient-to-br from-green-50 via-emerald-50 to-teal-50
    bg-gradient-to-br from-orange-50 via-amber-50 to-yellow-50
    bg-gradient-to-br from-pink-50 via-rose-50 to-red-50
    -->

    <div class="max-w-7xl mx-auto">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('achievements.index') }}"
               class="inline-flex items-center text-blue-600 hover:text-blue-800 bg-white/80 backdrop-blur-sm px-4 py-2 rounded-lg shadow-sm border hover:shadow-md transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Achievement
            </a>
        </div>

        <!-- Achievement Header with glassmorphism effect -->
        <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg p-6 md:p-8 mb-8 border border-white/20">
            <div class="flex flex-col lg:flex-row items-center lg:items-start">
                <div class="mr-0 lg:mr-8 mb-6 lg:mb-0">
                    @if($bestAttempt->getPercentageAttribute() == 100)
                        <div class="w-24 h-24 md:w-32 md:h-32 bg-gradient-to-br from-yellow-100 to-yellow-200 rounded-full flex items-center justify-center shadow-lg border-4 border-yellow-300/50">
                            <div class="text-4xl md:text-6xl">🏆</div>
                        </div>
                    @elseif($bestAttempt->getPercentageAttribute() >= 90)
                        <div class="w-24 h-24 md:w-32 md:h-32 bg-gradient-to-br from-green-100 to-green-200 rounded-full flex items-center justify-center shadow-lg border-4 border-green-300/50">
                            <div class="text-4xl md:text-6xl">⭐</div>
                        </div>
                    @else
                        <div class="w-24 h-24 md:w-32 md:h-32 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center shadow-lg border-4 border-blue-300/50">
                            <div class="text-4xl md:text-6xl">🎓</div>
                        </div>
                    @endif
                </div>

                <div class="flex-1 text-center lg:text-left">
                    <div class="flex flex-col lg:flex-row lg:items-center mb-4">
                        <h1 class="text-2xl md:text-3xl font-bold mb-2 lg:mb-0 lg:mr-4 text-gray-900">
                            {{ $class->name }}
                        </h1>
                        @if($bestAttempt->getPercentageAttribute() == 100)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800 border border-yellow-300/50 shadow-sm">
                                🌟 Perfect Achievement
                            </span>
                        @elseif($bestAttempt->getPercentageAttribute() >= 90)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gradient-to-r from-green-100 to-green-200 text-green-800 border border-green-300/50 shadow-sm">
                                🚀 Excellent Performance
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 border border-blue-300/50 shadow-sm">
                                ✅ Achievement Unlocked
                            </span>
                        @endif
                    </div>

                    <div class="space-y-2 mb-6 text-gray-600">
                        <p class="text-lg flex items-center justify-center lg:justify-start">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Mentor: {{ $class->mentor->name }}
                        </p>
                        <p class="flex items-center justify-center lg:justify-start">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Diselesaikan: {{ $bestAttempt->finished_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                </div>

                <div class="text-center lg:text-right">
                    <div class="text-4xl md:text-5xl font-bold mb-2 text-gray-900">
                        {{ $bestAttempt->getPercentageAttribute() }}%
                    </div>
                    <div class="text-sm text-gray-600 bg-gray-100/80 backdrop-blur-sm px-3 py-1 rounded-lg border border-gray-200/50">
                        Skor Post Test: {{ $bestAttempt->score }} / {{ $bestAttempt->postTest->questions->sum('points') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Post Test Achievement Details with glassmorphism -->
                <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg p-6 border border-white/20">
                    <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center mr-3 shadow-sm">
                            📊
                        </div>
                        Detail Pencapaian Post Test
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gradient-to-br from-green-50 to-green-100/80 backdrop-blur-sm rounded-lg p-4 border border-green-200/50 shadow-sm">
                            <div class="flex items-center mb-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center text-white mr-3 shadow-sm">
                                    ✅
                                </div>
                                <div>
                                    <p class="text-sm text-green-600 font-medium">Jawaban Benar</p>
                                    <p class="text-2xl font-bold text-green-800">{{ $bestAttempt->correct_answers }}</p>
                                </div>
                            </div>
                            <p class="text-xs text-green-700">Dari {{ $bestAttempt->total_questions }} soal Post Test</p>
                        </div>

                        <div class="bg-gradient-to-br from-blue-50 to-blue-100/80 backdrop-blur-sm rounded-lg p-4 border border-blue-200/50 shadow-sm">
                            <div class="flex items-center mb-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center text-white mr-3 shadow-sm">
                                    ⏱️
                                </div>
                                <div>
                                    <p class="text-sm text-blue-600 font-medium">Durasi Pengerjaan</p>
                                    <p class="text-2xl font-bold text-blue-800">{{ $bestAttempt->getDurationAttribute() }}</p>
                                </div>
                            </div>
                            <p class="text-xs text-blue-700">Waktu pengerjaan Post Test</p>
                        </div>

                        <div class="bg-gradient-to-br from-purple-50 to-purple-100/80 backdrop-blur-sm rounded-lg p-4 border border-purple-200/50 shadow-sm">
                            <div class="flex items-center mb-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center text-white mr-3 shadow-sm">
                                    🎯
                                </div>
                                <div>
                                    <p class="text-sm text-purple-600 font-medium">Percobaan Ke-</p>
                                    <p class="text-2xl font-bold text-purple-800">#{{ $bestAttempt->attempt_number }}</p>
                                </div>
                            </div>
                            <p class="text-xs text-purple-700">Attempt terbaik Post Test</p>
                        </div>

                        <div class="bg-gradient-to-br from-orange-50 to-orange-100/80 backdrop-blur-sm rounded-lg p-4 border border-orange-200/50 shadow-sm">
                            <div class="flex items-center mb-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg flex items-center justify-center text-white mr-3 shadow-sm">
                                    🎓
                                </div>
                                <div>
                                    <p class="text-sm text-orange-600 font-medium">Batas Kelulusan</p>
                                    <p class="text-2xl font-bold text-orange-800">{{ $bestAttempt->postTest->passing_score }}%</p>
                                </div>
                            </div>
                            <p class="text-xs text-orange-700">Minimum nilai untuk lulus Post Test</p>
                        </div>
                    </div>

                    <!-- Progress Visualization with gradient -->
                    <div class="mt-6">
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-lg font-bold text-gray-800">Progress Achievement</span>
                            <span class="text-xl font-bold text-gray-900">{{ $bestAttempt->getPercentageAttribute() }}%</span>
                        </div>
                        <div class="w-full h-3 bg-gray-200/80 rounded-full backdrop-blur-sm">
                            <div class="h-3 rounded-full
                                @if($bestAttempt->getPercentageAttribute() == 100) bg-gradient-to-r from-yellow-400 to-yellow-500
                                @elseif($bestAttempt->getPercentageAttribute() >= 90) bg-gradient-to-r from-green-400 to-green-500
                                @else bg-gradient-to-r from-blue-400 to-blue-500
                                @endif shadow-sm"
                                 style="width: {{ $bestAttempt->getPercentageAttribute() }}%"></div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500 mt-1">
                            <span>0%</span>
                            <span class="text-orange-600 font-medium">{{ $bestAttempt->postTest->passing_score }}% (Lulus)</span>
                            <span>100%</span>
                        </div>
                    </div>
                </div>

                <!-- All Post Test Attempts History -->
                @if($attempts->count() > 1)
                <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg p-6 border border-white/20">
                    <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-6 flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-100 to-indigo-200 rounded-lg flex items-center justify-center mr-3 shadow-sm">
                            📝
                        </div>
                        Riwayat Percobaan Post Test
                    </h2>

                    <div class="space-y-4">
                        @foreach($attempts as $attempt)
                        <div class="border rounded-lg p-4 backdrop-blur-sm
                            {{ $attempt->id === $bestAttempt->id ? 'border-green-300/50 bg-green-50/80' : 'border-gray-200/50 bg-white/60' }}">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                                <div class="flex items-center mb-4 sm:mb-0">
                                    <div class="mr-4">
                                        @if($attempt->id === $bestAttempt->id)
                                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center text-white shadow-md">
                                                🏆
                                            </div>
                                        @elseif($attempt->getPercentageAttribute() >= 80)
                                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white shadow-md">
                                                <span class="font-bold">{{ $attempt->attempt_number }}</span>
                                            </div>
                                        @else
                                            <div class="w-12 h-12 bg-gradient-to-br from-gray-400 to-gray-500 rounded-full flex items-center justify-center text-white shadow-md">
                                                <span class="font-bold">{{ $attempt->attempt_number }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div>
                                        <div class="flex flex-wrap items-center gap-2 mb-1">
                                            <h3 class="font-bold text-gray-900">Percobaan #{{ $attempt->attempt_number }}</h3>
                                            @if($attempt->id === $bestAttempt->id)
                                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-green-100 to-green-200 text-green-800 border border-green-300/50 shadow-sm">
                                                    🌟 Best Score
                                                </span>
                                            @endif
                                            @if($attempt->is_approval_attempt)
                                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 border border-blue-300/50 shadow-sm">
                                                    📋 Approval
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-600">{{ $attempt->finished_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>

                                <div class="text-center sm:text-right">
                                    <div class="text-2xl font-bold mb-1 {{ $attempt->getPercentageAttribute() >= 80 ? 'text-green-600' : 'text-red-500' }}">
                                        {{ $attempt->getPercentageAttribute() }}%
                                    </div>
                                    <div class="text-sm text-gray-600 bg-gray-100/80 backdrop-blur-sm px-2 py-1 rounded border border-gray-200/50">
                                        {{ $attempt->correct_answers }}/{{ $attempt->total_questions }} benar
                                    </div>
                                </div>
                            </div>

                            <!-- Simple Progress bar with gradient -->
                            <div class="mt-3">
                                <div class="w-full h-2 bg-gray-200/80 rounded-full backdrop-blur-sm">
                                    <div class="h-2 rounded-full {{ $attempt->getPercentageAttribute() >= 80 ? 'bg-gradient-to-r from-green-400 to-green-500' : 'bg-gradient-to-r from-red-400 to-red-500' }} shadow-sm"
                                         style="width: {{ $attempt->getPercentageAttribute() }}%"></div>
                                </div>
                                <div class="text-center text-xs mt-1 font-medium {{ $attempt->getPercentageAttribute() >= 80 ? 'text-green-600' : 'text-red-500' }}">
                                    {{ $attempt->getPercentageAttribute() >= 80 ? 'LULUS' : 'BELUM LULUS' }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Class Information -->
                <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg p-6 border border-white/20">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg flex items-center justify-center mr-3 shadow-sm">
                            📚
                        </div>
                        Informasi Kelas
                    </h3>

                    <div class="space-y-4">
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100/80 backdrop-blur-sm rounded-lg p-3 border border-blue-200/50 shadow-sm">
                            <p class="text-sm text-blue-600 font-medium mb-1">Nama Kelas</p>
                            <p class="font-bold text-gray-900 text-sm">{{ $class->name }}</p>
                        </div>

                        @if($class->description)
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100/80 backdrop-blur-sm rounded-lg p-3 border border-purple-200/50 shadow-sm">
                            <p class="text-sm text-purple-600 font-medium mb-1">Deskripsi</p>
                            <p class="text-gray-900 text-sm">{{ Str::limit($class->description, 100) }}</p>
                        </div>
                        @endif

                        <div class="bg-gradient-to-br from-green-50 to-green-100/80 backdrop-blur-sm rounded-lg p-3 border border-green-200/50 shadow-sm">
                            <p class="text-sm text-green-600 font-medium mb-1">Mentor Pengajar</p>
                            <p class="font-bold text-gray-900 text-sm">{{ $class->mentor->name }}</p>
                        </div>

                        <div class="bg-gradient-to-br from-orange-50 to-orange-100/80 backdrop-blur-sm rounded-lg p-3 border border-orange-200/50 shadow-sm">
                            <p class="text-sm text-orange-600 font-medium mb-1">Total Materi</p>
                            <p class="font-bold text-gray-900 text-sm">{{ $class->materials->count() }} materi pembelajaran</p>
                        </div>
                    </div>
                </div>

                <!-- Share Achievement -->
                <div class="bg-white/80 backdrop-blur-sm rounded-xl shadow-lg p-6 border border-white/20">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-green-100 to-green-200 rounded-lg flex items-center justify-center mr-3 shadow-sm">
                            🎉
                        </div>
                        Bagikan Achievement
                    </h3>

                    <div class="bg-gradient-to-br from-green-50 to-green-100/80 backdrop-blur-sm rounded-lg p-3 mb-4 border border-green-200/50 shadow-sm">
                        <p class="text-sm text-gray-700 text-center">
                            Bagikan pencapaian Post Test Anda! 🎊
                        </p>
                    </div>

                    <button onclick="shareAchievement()"
                            class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-4 py-3 rounded-lg transition-all duration-200 font-medium shadow-md hover:shadow-lg flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                        </svg>
                        Share Achievement
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function shareAchievement() {
    const achievementText = `🏆 Achievement Unlocked!

Saya berhasil menyelesaikan Post Test kelas "{{ $class->name }}" dengan nilai {{ $bestAttempt->getPercentageAttribute() }}%!

📚 Kelas: {{ $class->name }}
👨‍🏫 Mentor: {{ $class->mentor->name }}
🎯 Skor: {{ $bestAttempt->score }}/{{ $bestAttempt->postTest->questions->sum('points') }}
📊 Persentase: {{ $bestAttempt->getPercentageAttribute() }}%
📅 Diselesaikan: {{ $bestAttempt->finished_at->format('d M Y') }}

#Achievement #PostTest #Learning`;

    if (navigator.share) {
        navigator.share({
            title: '🏆 Achievement Unlocked!',
            text: achievementText,
            url: window.location.href
        });
    } else {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(achievementText + '\n\n' + window.location.href).then(() => {
                showNotification('✅ Achievement telah disalin ke clipboard!');
            });
        } else {
            const textArea = document.createElement('textarea');
            textArea.value = achievementText + '\n\n' + window.location.href;
            textArea.style.position = 'fixed';
            textArea.style.left = '-999999px';
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            showNotification('✅ Achievement telah disalin ke clipboard!');
        }
    }
}

function showNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 z-50 bg-gradient-to-r from-green-600 to-green-700 text-white px-4 py-2 rounded-lg shadow-lg backdrop-blur-sm';
    notification.textContent = message;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>
@endsection
