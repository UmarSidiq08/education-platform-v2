<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Mentor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-in': 'slideIn 0.3s ease-out'
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideIn {
            from { transform: translateX(-100%); }
            to { transform: translateX(0); }
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-950 via-cyan-900 to-blue-700 min-h-screen">

<!-- Navigation -->
<nav class="bg-white/10 backdrop-blur-lg border-b border-white/20 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
            <div class="flex items-center">
                <h1 class="text-2xl font-bold text-white">Detail Mentor</h1>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('dashboard') }}"
                    class="px-4 py-2 text-white/70 hover:text-white hover:bg-white/10 rounded-lg transition-all duration-200 font-medium">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</nav>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Profile Header -->
    <div class="bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 p-8 mb-8 animate-fade-in">
        <div class="flex flex-col md:flex-row items-center md:items-start space-y-6 md:space-y-0 md:space-x-8">
            <div class="relative group">
                <img src="{{ $mentor->avatar ? asset('storage/' . $mentor->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($mentor->name) }}"
                    alt="Profile"
                    class="w-32 h-32 rounded-full border-4 border-white/20 group-hover:border-white/40 transition-all duration-300 object-cover">
            </div>

            <div class="flex-1 text-center md:text-left">
                <div class="flex flex-col md:flex-row items-center md:items-start space-y-3 md:space-y-0 md:space-x-4 mb-4">
                    <h2 class="text-3xl font-bold text-white">{{ $mentor->name }}</h2>
                    @if($mentor->role === 'mentor')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gradient-to-r from-green-500 to-emerald-600 text-white shadow-lg">
                            Mentor
                        </span>
                    @endif
                </div>

                <p class="text-white/60 mb-6 max-w-2xl">{{ $mentor->bio ?? 'Belum ada bio.' }}</p>

                <div class="flex flex-wrap gap-4 justify-center md:justify-start">
                    <div class="flex items-center space-x-2 text-white/60">
                        <span>{{ $mentor->email }}</span>
                    </div>
                    @if($mentor->location)
                        <div class="flex items-center space-x-2 text-white/60">
                            <span>{{ $mentor->location }}</span>
                        </div>
                    @endif
                    <div class="flex items-center space-x-2 text-white/60">
                        <span>Bergabung sejak {{ $mentor->created_at->translatedFormat('F Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi Kelas yang Diikuti -->
    @if($mentor->approvedTeacherClasses && $mentor->approvedTeacherClasses->count() > 0)
    <div class="bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 p-8 mb-8 animate-fade-in">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-white">Kelas yang Diikuti</h3>
            <span class="bg-blue-500/20 text-blue-300 text-sm px-3 py-1 rounded-full">
                {{ $mentor->approvedTeacherClasses->count() }} Kelas
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($mentor->approvedTeacherClasses as $teacherClass)
            <div class="bg-gradient-to-br from-blue-900/30 to-indigo-900/30 rounded-xl p-5 border border-white/10 hover:border-blue-400/30 transition-all duration-300 group">
                <!-- Header Kelas -->
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <h4 class="font-bold text-white text-lg mb-2 group-hover:text-blue-200 transition-colors">
                            {{ $teacherClass->name }}
                        </h4>

                        <!-- Informasi Guru -->
                        <div class="flex items-center text-white/70 mb-2">
                            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="truncate">{{ $teacherClass->teacher->name }}</span>
                        </div>

                        <!-- Informasi Mata Pelajaran -->
                        @if($teacherClass->subject)
                        <div class="flex items-center text-blue-300 mb-3">
                            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <span>{{ $teacherClass->subject }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- Badge Kelas -->
                    <div class="bg-blue-500/20 text-blue-300 text-xs px-2 py-1 rounded-full ml-2 flex-shrink-0">
                        Kelas
                    </div>
                </div>

                <!-- Informasi Tambahan -->
                <div class="flex items-center justify-between text-sm text-white/50 border-t border-white/10 pt-3">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ $teacherClass->academic_year ?? '2025/2026' }}</span>
                    </div>

                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 极 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 极 0 2 2 0 014 0z"></path>
                        </svg>
                        <span>{{ $teacherClass->grade_level ?? 'Semua Tingkat' }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @else
    <div class="bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 p-8 mb-8 animate-fade-in">
        <h3 class="text-xl font-bold text-white mb-6">Kelas yang Diikuti</h3>
        <div class="text-center py-8">
            <div class="bg-purple-500/20 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-purple-300" fill="none" stroke="currentColor" viewBox="0 极 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2极v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </div>
            <p class="text-white/60">Mentor ini belum bergabung dengan kelas tertentu</p>
        </div>
    </div>
    @endif

    <!-- Profile Information -->
    <div class="bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 p-8 animate-fade-in">
        <h3 class="text-xl font-bold text-white mb-6">Informasi Mentor</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-white/60 text-sm font-medium mb-2">Nama Lengkap</label>
                <p class="text-white bg-white/5 p-3 rounded-lg border border-white/10">{{ $mentor->name }}</p>
            </div>
            <div>
                <label class="block text-white/60 text-sm font-medium mb-2">Email</label>
                <p class="text-white bg-white/5 p-3 rounded-lg border border-white/10">{{ $mentor->email }}</p>
            </div>
            <div>
                <label class="block text-white/60 text-sm font-medium mb-2">Role</label>
                <p class="text-white bg-white/5 p-3 rounded-lg border border-white/10 capitalize">{{ $mentor->role }}</p>
            </div>
            <div>
                <label class="block text-white/60 text-sm font-medium mb-2">Nomor Telepon</label>
                <p class="text-white bg-white/5 p-3 rounded-lg border border-white/10">{{ $mentor->phone ?? '-' }}</p>
            </div>
            <div>
                <label class="block text-white/60 text-sm font-medium mb-2">Lokasi</label>
                <p class="text-white bg-white/5 p-3 rounded-lg border border-white/10">{{ $mentor->location ?? '-' }}</p>
            </div>
            <div class="md:col-span-2">
                <label class="block text-white/60 text-sm font-medium mb-2">Bio</label>
                <p class="text-white bg-white/5 p-3 rounded-lg border border-white/10">{{ $mentor->bio ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>

</body>
</html>
