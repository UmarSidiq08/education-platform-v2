<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 2px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 2px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        /* Consistent transitions */
        .nav-item {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-item:hover {
            transform: translateX(4px);
        }

        /* Profile dropdown animation */
        .profile-dropdown {
            transform: translateY(-8px) scale(0.95);
            opacity: 0;
            visibility: hidden;
            transition: all 0.15s ease-out;
        }

        .profile-dropdown.show {
            transform: translateY(0) scale(1);
            opacity: 1;
            visibility: visible;
        }
    </style>

    @stack('styles')
</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 z-50 w-72 bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 shadow-2xl">

            <!-- Logo/Brand Section -->
            <div class="flex items-center justify-between p-6 border-b border-white/10">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-graduation-cap text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white tracking-tight">EduPlatform</h1>
                        <p class="text-sm text-purple-200 font-medium">Admin Panel</p>
                    </div>
                </div>
                <button id="closeSidebar"
                    class="lg:hidden text-gray-400 hover:text-white p-2 rounded-lg hover:bg-white/10 transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 custom-scrollbar overflow-y-auto">
                <div class="space-y-6">

                    <!-- Main Navigation -->
                    <div>
                        <h3 class="px-4 py-2 text-xs font-semibold text-purple-200 uppercase tracking-wider">Main Menu
                        </h3>
                        <ul class="space-y-1 mt-3">
                            <!-- Dashboard -->
                            <li>
                                <a href="{{ route('admin.dashboard') ?? '#' }}"
                                    class="nav-item flex items-center space-x-3 px-4 py-3 text-base font-medium text-gray-300 hover:bg-white/10 hover:text-white rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-white/10 text-white' : '' }}">
                                    <i class="fas fa-home text-lg w-5"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Request Classes (filtered by current teacher's classes) -->
                    @php
                        // Ambil hanya teacher classes milik guru yang sedang login dan memiliki mentor requests
                        $teacherClassesWithRequests = auth()
                            ->user()
                            ->teacherClasses()
                            ->whereHas('mentorRequests')
                            ->get();

                        // Alternative: Jika ingin yang lebih spesifik hanya pending requests
                        // $teacherClassesWithRequests = auth()->user()->teacherClasses()
                        //     ->whereHas('mentorRequests', function($query) {
                        //         $query->where('status', 'pending');
                        //     })->get();

                    @endphp

                    @if ($teacherClassesWithRequests && $teacherClassesWithRequests->count() > 0)
                        <div>
                            <h3 class="px-4 py-2 text-xs font-semibold text-purple-200 uppercase tracking-wider">
                                Permintaan Mentor</h3>
                            <ul class="space-y-1 mt-3">
                                @foreach ($teacherClassesWithRequests as $teacherClass)
                                    @php
                                        $href = '#';
                                        $isActive = false;
                                        try {
                                            $href = route('mentor-requests.by-class', $teacherClass);
                                            $isActive =
                                                request()->routeIs('mentor-requests.by-class') &&
                                                request()->route('teacherClass') &&
                                                request()->route('teacherClass')->id == $teacherClass->id;
                                        } catch (Exception $e) {
                                            // Route tidak ada, gunakan #
                                        }
                                    @endphp
                                    <li>
                                        <a href="{{ $href }}"
                                            class="nav-item flex items-center justify-between px-4 py-3 text-sm font-medium text-gray-300 hover:bg-white/10 hover:text-white rounded-xl transition-all duration-200 {{ $isActive ? 'bg-white/10 text-white' : '' }}">
                                            <div class="flex items-center space-x-3">
                                                <i class="fas fa-user-graduate text-base w-5"></i>
                                                <span>{{ Str::limit($teacherClass->name, 18) }}</span>
                                            </div>
                                            <span
                                                class="bg-red-500 text-white text-xs px-2 py-1 rounded-full font-semibold min-w-[24px] text-center">
                                                {{ $teacherClass->mentorRequests->where('status', 'pending')->count() }}
                                            </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Mentor Classes (existing structure) -->
                    @if (auth()->user()->teacherClasses && auth()->user()->teacherClasses->count() > 0)
                        <div>
                            <h3 class="px-4 py-2 text-xs font-semibold text-purple-200 uppercase tracking-wider">Kelas
                                Mentor</h3>
                            <ul class="space-y-1 mt-3">
                                @foreach (auth()->user()->teacherClasses as $teacherClass)
                                    <li>
                                        <a href="{{ route('teacher-classes.implementation', $teacherClass) }}"
                                            class="nav-item flex items-center justify-between px-4 py-3 text-sm font-medium text-gray-300 hover:bg-white/10 hover:text-white rounded-xl transition-all duration-200 {{ request()->routeIs('teacher-classes.implementation') && request()->route('teacherClass')->id == $teacherClass->id ? 'bg-white/10 text-white' : '' }}">
                                            <div class="flex items-center space-x-3">
                                                <i class="fas fa-users text-base w-5"></i>
                                                <span>{{ Str::limit($teacherClass->name, 18) }}</span>
                                            </div>
                                            <span
                                                class="bg-blue-500 text-white text-xs px-2 py-1 rounded-full font-semibold min-w-[24px] text-center">
                                                {{ $teacherClass->implementationClasses->count() }}
                                            </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Additional Menu Items -->
                    <div class="border-t border-white/10 pt-6">

                    </div>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden lg:ml-0">
            <!-- Top Bar -->
            <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <button id="openSidebar"
                            class="lg:hidden text-gray-500 hover:text-gray-700 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                            <p class="text-sm text-gray-600 mt-1">@yield('page-description', 'Welcome back to your dashboard')</p>
                        </div>
                    </div>

                    <!-- Profile Section - Top Right -->
                    <div class="flex items-center space-x-4">


                        <!-- Profile Dropdown -->
                        <div class="relative">
                            <button id="profileButton"
                                class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                                <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                                    alt="{{ auth()->user()->name }}"
                                    class="w-10 h-10 rounded-full border-2 border-gray-200">
                                <div class="text-left hidden sm:block">
                                    <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ ucfirst(auth()->user()->role ?? 'Admin') }}</p>
                                </div>
                                <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                            </button>

                            <!-- Dropdown Menu -->
                            <div id="profileDropdown"
                                class="profile-dropdown absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-200 py-2 z-50">
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                </div>
                                <div class="py-2">
                                    <a href="{{ route('profile.index') ?? '#' }}"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                        <i class="fas fa-user mr-3 text-gray-400"></i>
                                        View Profile
                                    </a>

                                    <div class="border-t border-gray-100 mt-2 pt-2">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit"
                                                class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                                <i class="fas fa-sign-out-alt mr-3"></i>
                                                Sign Out
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto custom-scrollbar">
                <div class="p-6">
                    @if (session('success'))
                        <div
                            class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center">
                            <i class="fas fa-check-circle mr-3 text-green-600"></i>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('error'))
                        <div
                            class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center">
                            <i class="fas fa-exclamation-circle mr-3 text-red-600"></i>
                            <span class="font-medium">{{ session('error') }}</span>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Sidebar Overlay for Mobile -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"></div>

    <script>
        // Sidebar toggle functionality
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const openSidebar = document.getElementById('openSidebar');
        const closeSidebar = document.getElementById('closeSidebar');

        function showSidebar() {
            sidebar.classList.remove('-translate-x-full');
            sidebarOverlay.classList.remove('hidden');
        }

        function hideSidebar() {
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        }

        openSidebar.addEventListener('click', showSidebar);
        closeSidebar.addEventListener('click', hideSidebar);
        sidebarOverlay.addEventListener('click', hideSidebar);

        // Close sidebar on window resize if large screen
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                hideSidebar();
            }
        });

        // Profile dropdown toggle
        const profileButton = document.getElementById('profileButton');
        const profileDropdown = document.getElementById('profileDropdown');

        profileButton.addEventListener('click', function(e) {
            e.stopPropagation();
            profileDropdown.classList.toggle('show');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function() {
            profileDropdown.classList.remove('show');
        });

        profileDropdown.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    </script>

    @stack('scripts')
</body>

</html>
