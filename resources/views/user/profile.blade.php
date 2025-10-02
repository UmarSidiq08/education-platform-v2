<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Profile - Laravel</title>
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
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                transform: translateX(-100%);
            }

            to {
                transform: translateX(0);
            }
        }

        /* Improved text wrapping for mobile */
        .text-wrap-balance {
            text-wrap: balance;
            overflow-wrap: break-word;
            word-break: break-word;
        }

        /* Custom utility for text truncation with ellipsis */
        .text-truncate-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Improved responsive behavior */
        @media (max-width: 640px) {
            .profile-header-flex {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .profile-details-grid {
                grid-template-columns: 1fr !important;
            }

            .mobile-stack {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-950 via-cyan-900 to-blue-700 min-h-screen">

    <!-- Navigation -->
    <nav class="bg-white/10 backdrop-blur-lg border-b border-white/20 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center max-w-full">
                    <h1 class="text-xl sm:text-2xl font-bold text-white text-wrap-balance truncate">Dashboard Profile
                    </h1>
                </div>
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <!-- Home Button -->
                    <a href="{{ auth()->user()->role === 'guru' ? route('admin.dashboard') : route('navbar.mentor') }}"
                        onclick="
   @if (auth()->user()->role !== 'guru') // Untuk siswa dan mentor
       const referrer = document.referrer;
       const currentUrl = window.location.href;

       if (referrer && referrer !== currentUrl) {
           // Cek apakah referrer mengarah ke edit profile
           const isFromEdit = referrer.includes('edit') ||
                             referrer.includes('/profile/edit') ||
                             referrer.includes('edit-profile') ||
                             referrer.includes('profile-edit');

           if (!isFromEdit) {
               // Referrer bukan edit page, aman untuk kembali
               history.back();
               return false;
           }
       }

       return true; @endif
   "
                        class="px-4 py-2 text-white/70 hover:text-white hover:bg-white/10 rounded-lg transition-all duration-200 font-medium">
                        Kembali
                    </a>


                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            class="px-2 sm:px-4 py-2 text-sm sm:text-base text-white/70 hover:text-white hover:bg-white/10 rounded-lg transition-all duration-200 font-medium">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Profile Header -->
        <div
            class="bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 p-4 sm:p-8 mb-8 animate-fade-in overflow-hidden">
            <div
                class="flex flex-col md:flex-row items-center md:items-start space-y-6 md:space-y-0 md:space-x-8 profile-header-flex">
                <div class="relative group flex-shrink-0">
                    <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                        class="w-20 h-20 sm:w-24 sm:h-24 rounded-full object-cover border" alt="Profile">
                </div>

                <div class="flex-1 text-center md:text-left max-w-full">
                    <div
                        class="flex flex-col md:flex-row items-center md:items-start space-y-3 md:space-y-0 md:space-x-4 mb-4 mobile-stack">
                        <h2 class="text-2xl sm:text-3xl font-bold text-white text-wrap-balance max-w-full">
                            {{ $user->name }}</h2>
                        <!-- Role Badge -->
                        @if ($user->role === 'mentor')
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs sm:text-sm font-medium bg-gradient-to-r from-green-500 to-emerald-600 text-white shadow-lg flex-shrink-0 mt-2 md:mt-0">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M9.664 1.319a.75.75 0 01.672 0 41.059 41.059 0 018.198 5.424.75.75 0 01-.254 1.285 31.372 31.372 0 00-7.86 3.83.75.75 0 01-.84 0 31.508 31.508 0 00-2.08-1.287V9.394c0-.244.116-.463.302-.592a35.504 35.504 0 013.305-2.033.75.75 0 00-.714-1.319 37 37 0 00-3.446 2.12A2.216 2.216 0 006 9.393v.38a31.293 31.293 0 00-4.28-1.746.75.75 0 01-.254-1.285 41.059 41.059 0 018.198-5.424zM6 11.459a29.848 29.848 0 00-2.455-1.158 41.029 41.029 0 00-.39 3.114.75.75 0 00.419.74c.528.256 1.046.53 1.554.82-.21-.899-.322-1.85-.322-2.816zm-3.126 2.179A39.181 39.181 0 015.19 13.02a31.672 31.672 0 014.82 2.99.75.75 0 00.84 0 31.672 31.672 0 014.82-2.99 39.181 39.181 0 012.316.618A39.083 39.083 0 0110 18.999a39.083 39.083 0 01-7.126-5.361z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                eBuddy
                            </span>
                        @elseif($user->role === 'siswa')
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs sm:text-sm font-medium bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg flex-shrink-0 mt-2 md:mt-0">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z">
                                    </path>
                                </svg>
                                Enova
                            </span>
                        @endif
                    </div>

                    <p
                        class="text-white/60 mb-6 max-w-full text-sm sm:text-base text-wrap-balance text-truncate-3 leading-relaxed">
                        {{ $user->bio ?? 'Belum ada bio.' }}</p>

                    <div
                        class="flex flex-col sm:flex-row flex-wrap gap-2 sm:gap-4 justify-center md:justify-start max-w-full mobile-stack">
                        <div
                            class="flex items-center justify-center md:justify-start space-x-2 text-white/60 text-sm sm:text-base text-wrap-balance max-w-full">
                            <span class="text-wrap-balance truncate">{{ $user->email }}</span>
                        </div>
                        @if ($user->location)
                            <div
                                class="flex items-center justify-center md:justify-start space-x-2 text-white/60 text-sm sm:text-base text-wrap-balance max-w-full">
                                <span class="text-wrap-balance truncate">{{ $user->location }}</span>
                            </div>
                        @endif
                        <div
                            class="flex items-center justify-center md:justify-start space-x-2 text-white/60 text-sm sm:text-base text-wrap-balance max-w-full">
                            <span class="text-wrap-balance truncate">Bergabung sejak
                                {{ $user->created_at->translatedFormat('F Y') }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex-shrink-0 w-full md:w-auto mt-4 md:mt-0">
                    <a href="{{ route('profile.edit') }}"
                        class="w-full md:w-auto px-4 sm:px-6 py-2 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 flex items-center justify-center space-x-2 text-sm sm:text-base">
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>

        <!-- Profile Information -->
        <div
            class="bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 p-4 sm:p-8 animate-fade-in overflow-hidden">
            <h3 class="text-lg sm:text-xl font-bold text-white mb-6">Profile Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 profile-details-grid">
                <div class="max-w-full">
                    <label class="block text-white/60 text-sm font-medium mb-2">Nama Lengkap</label>
                    <p
                        class="text-white bg-white/5 p-3 rounded-lg border border-white/10 text-sm sm:text-base text-wrap-balance max-w-full">
                        {{ $user->name }}</p>
                </div>
                <div class="max-w-full">
                    <label class="block text-white/60 text-sm font-medium mb-2">Email</label>
                    <p
                        class="text-white bg-white/5 p-3 rounded-lg border border-white/10 text-sm sm:text-base text-wrap-balance max-w-full">
                        {{ $user->email }}</p>
                </div>
                <div class="max-w-full">
                    <label class="block text-white/60 text-sm font-medium mb-2">Role</label>
                    <p
                        class="text-white bg-white/5 p-3 rounded-lg border border-white/10 flex items-center text-sm sm:text-base text-wrap-balance max-w-full">
                        @if ($user->role === 'mentor')
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 text-green-400 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M9.664 1.319a.75.75 0 01.672 0 41.059 41.059 0 018.198 5.424.75.75 0 01-.254 1.285 31.372 31.372 0 00-7.86 3.83.75.75 0 01-.84 0 31.508 31.508 0 00-2.08-1.287V9.394c0-.244.116-.463.302-.592a35.504 35.504 0 013.305-2.033.75.75 0 00-.714-1.319 37 37 0 00-3.446 2.12A2.216 2.216 0 006 9.393v.38a31.293 31.293 0 00-4.28-1.746.75.75 0 01-.254-1.285 41.059 41.059 0 018.198-5.424zM6 11.459a29.848 29.848 0 00-2.455-1.158 41.029 41.029 0 00-.39 3.114.75.75 0 00.419.74c.528.256 1.046.53 1.554.82-.21-.899-.322-1.85-.322-2.816zm-3.126 2.179A39.181 39.181 0 015.19 13.02a31.672 31.672 0 014.82 2.99.75.75 0 00.84 0 31.672 31.672 0 014.82-2.99 39.181 39.181 0 012.316.618A39.083 39.083 0 0110 18.999a39.083 39.083 0 01-7.126-5.361z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-wrap-balance">eBuddy</span>
                        @elseif($user->role === 'siswa')
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 text-blue-400 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z">
                                </path>
                            </svg>
                            <span class="text-wrap-balance">Enova</span>
                        @else
                            <span class="capitalize text-wrap-balance">{{ $user->role ?? 'User' }}</span>
                        @endif
                    </p>
                </div>
                <div class="max-w-full">
                    <label class="block text-white/60 text-sm font-medium mb-2">Nomor Telepon</label>
                    <p
                        class="text-white bg-white/5 p-3 rounded-lg border border-white/10 text-sm sm:text-base text-wrap-balance max-w-full">
                        {{ $user->phone ?? '-' }}</p>
                </div>
                <div class="max-w-full">
                    <label class="block text-white/60 text-sm font-medium mb-2">Lokasi</label>
                    <p
                        class="text-white bg-white/5 p-3 rounded-lg border border-white/10 text-sm sm:text-base text-wrap-balance max-w-full">
                        {{ $user->location ?? '-' }}</p>
                </div>
                <div class="md:col-span-2 max-w-full">
                    <label class="block text-white/60 text-sm font-medium mb-2">Bio</label>
                    <p
                        class="text-white bg-white/5 p-3 rounded-lg border border-white/10 text-sm sm:text-base text-wrap-balance max-w-full leading-relaxed">
                        {{ $user->bio ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>


</body>

</html>
