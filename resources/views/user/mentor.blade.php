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
