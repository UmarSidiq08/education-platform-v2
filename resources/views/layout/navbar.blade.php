<nav class="fixed top-0 left-0 right-0 z-[1000] h-[85px] m-0 p-0 shadow-lg"
    style="background: linear-gradient(135deg, #4fc3f7 0%, #29b6f6 100%); backdrop-filter: blur(20px);">
    <div class="flex justify-between items-center max-w-[1400px] mx-auto w-full h-full px-8">
        <div class="flex items-center gap-8">
    <div class="logo relative w-[100px] h-[100px] flex items-center justify-center">
        <!-- Logo -->
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-contain relative z-10">
    </div>

    <!-- Mobile Menu Button - Hidden on Desktop -->
    <button class="mobile-menu-btn hidden md:hidden" id="mobileMenuBtn" onclick="toggleMobileMenu()">
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
    </button>

    <!-- Desktop Navigation - Hidden on Mobile -->
    <ul class="nav-links flex gap-2 list-none items-center m-0 p-2 rounded-[15px] shadow-xl md:flex hidden"
        style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(15px);">

        <li class="m-0 p-0">
            <a href="{{ route('dashboard') }}"
                class="no-underline font-semibold px-5 py-3 rounded-[15px] transition-all duration-300 ease-in-out relative whitespace-nowrap text-sm block hover:text-blue-600 hover:-translate-y-0.5 {{ request()->routeIs('dashboard') ? 'text-white shadow-lg' : 'text-gray-700' }}"
                style="{{ request()->routeIs('dashboard') ? 'background: linear-gradient(135deg, #1976d2 0%, #42a5f5 100%); box-shadow: 0 4px 15px rgba(25, 118, 210, 0.3);' : '' }}">Dashboard</a>
        </li>

        <li class="m-0 p-0">
            <a href="{{ route('classes.index') }}"
                class="no-underline font-semibold px-5 py-3 rounded-[15px] transition-all duration-300 ease-in-out relative whitespace-nowrap text-sm block hover:text-blue-600 hover:-translate-y-0.5 {{ request()->routeIs('classes.index') || request()->routeIs('classes.*') || request()->routeIs('materials.*') ? 'text-white shadow-lg' : 'text-gray-700' }}"
                style="{{ request()->routeIs('classes.*') || request()->routeIs('materials.*') ? 'background: linear-gradient(135deg, #1976d2 0%, #42a5f5 100%); box-shadow: 0 4px 15px rgba(25, 118, 210, 0.3);' : '' }}">Classes</a>
        </li>

        <li class="m-0 p-0">
            <a href="{{ route('public.teacher-classes.index') }}"
                class="no-underline font-semibold px-5 py-3 rounded-[15px] transition-all duration-300 ease-in-out relative whitespace-nowrap text-sm block hover:text-blue-600 hover:-translate-y-0.5 {{ request()->routeIs('public.teacher-classes.*') ? 'text-white shadow-lg' : 'text-gray-700' }}"
                style="{{ request()->routeIs('public.teacher-classes.*') ? 'background: linear-gradient(135deg, #1976d2 0%, #42a5f5 100%); box-shadow: 0 4px 15px rgba(25, 118, 210, 0.3);' : '' }}">eMaster</a>
        </li>

        <li class="m-0 p-0">
            <a href="{{ route('navbar.mentor') }}"
                class="no-underline font-semibold px-5 py-3 rounded-[15px] transition-all duration-300 ease-in-out relative whitespace-nowrap text-sm block hover:text-blue-600 hover:-translate-y-0.5 {{ request()->routeIs('navbar.mentor') || request()->routeIs('mentor.*') ? 'text-white shadow-lg' : 'text-gray-700' }}"
                style="{{ request()->routeIs('navbar.mentor') || request()->routeIs('mentor.*') ? 'background: linear-gradient(135deg, #1976d2 0%, #42a5f5 100%); box-shadow: 0 4px 15px rgba(25, 118, 210, 0.3);' : '' }}">eBuddy</a>
        </li>

        @if (auth()->user()->role === 'siswa')
            <li class="m-0 p-0">
                <a href="{{ route('achievements.index') }}"
                    class="no-underline font-semibold px-5 py-3 rounded-[15px] transition-all duration-300 ease-in-out relative whitespace-nowrap text-sm block hover:text-blue-600 hover:-translate-y-0.5 {{ request()->routeIs('achievements.*') ? 'text-white shadow-lg' : 'text-gray-700' }}"
                    style="{{ request()->routeIs('achievements.*') ? 'background: linear-gradient(135deg, #1976d2 0%, #42a5f5 100%); box-shadow: 0 4px 15px rgba(25, 118, 210, 0.3);' : '' }}">Achievement</a>
            </li>
        @endif

        @if (auth()->user()->role === 'mentor')
            <li class="nav-item m-0 p-0">
                <a class="nav-link no-underline font-semibold px-5 py-3 rounded-[15px] transition-all duration-300 ease-in-out relative whitespace-nowrap text-sm block hover:text-blue-600 hover:-translate-y-0.5 {{ request()->routeIs('post_tests.approval_requests') ? 'text-white shadow-lg' : 'text-gray-700' }}"
                    href="{{ route('post_tests.approval_requests') }}"
                    style="{{ request()->routeIs('post_tests.approval_requests') ? 'background: linear-gradient(135deg, #1976d2 0%, #42a5f5 100%); box-shadow: 0 4px 15px rgba(25, 118, 210, 0.3);' : '' }}">
                    <i class="fas fa-clipboard-check mr-1"></i>Approval Requests
                    @php
                        $pendingCount = App\Models\PostTestAttempt::whereHas('postTest.class', function ($query) {
                            $query->where('mentor_id', auth()->id());
                        })
                            ->where('requires_approval', true)
                            ->where('mentor_approved', false)
                            ->count();
                    @endphp
                    @if ($pendingCount > 0)
                        <span
                            class="badge bg-red-500 absolute -top-1 -right-1 text-white text-xs rounded-full px-1.5 py-0.5 min-w-[1.25rem] h-5 flex items-center justify-center">{{ $pendingCount }}</span>
                    @endif
                </a>
            </li>
        @endif

        <!-- Chat Button -->
        <li class="m-0 p-0">
            <a href="{{ route('chat.index') }}"
                class="no-underline font-semibold px-5 py-3 rounded-[15px] transition-all duration-300 ease-in-out relative whitespace-nowrap text-sm block hover:text-blue-600 hover:-translate-y-0.5 {{ request()->routeIs('chat.*') ? 'text-white shadow-lg' : 'text-gray-700' }}"
                style="{{ request()->routeIs('chat.*') ? 'background: linear-gradient(135deg, #1976d2 0%, #42a5f5 100%); box-shadow: 0 4px 15px rgba(25, 118, 210, 0.3);' : '' }}">
                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a8.959 8.959 0 01-2.4-.32l-4.6 1.92 1.92-4.6A8.959 8.959 0 013 12c0-4.418 3.582-8 8-8s8 3.582 8 8z"></path>
                </svg>
                Pesan
                <span id="unreadBadge" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1.5 py-0.5 min-w-[1.25rem] h-5 flex items-center justify-center font-bold animate-pulse" style="display: none;">
                    <span id="unreadCount">0</span>
                </span>
            </a>
        </li>
    </ul>

    <!-- Mobile Navigation Menu -->
    <div class="mobile-nav-menu fixed top-[85px] left-0 right-0 bg-white shadow-lg rounded-b-[20px] z-[999] overflow-hidden transform -translate-y-full opacity-0 invisible transition-all duration-300"
        id="mobileNavMenu">
        <div class="p-4 space-y-2">
            <a href="{{ route('dashboard') }}"
                class="mobile-nav-link block px-4 py-3 rounded-[12px] text-gray-700 font-medium transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-blue-500 text-white' : '' }}"
                onclick="closeMobileMenu()">
                <span class="text-lg mr-3">🏠</span>Dashboard
            </a>

            <a href="{{ route('classes.index') }}"
                class="mobile-nav-link block px-4 py-3 rounded-[12px] text-gray-700 font-medium transition-all duration-300 {{ request()->routeIs('classes.*') || request()->routeIs('materials.*') ? 'bg-blue-500 text-white' : '' }}"
                onclick="closeMobileMenu()">
                <span class="text-lg mr-3">📚</span>Classes
            </a>

            <a href="{{ route('public.teacher-classes.index') }}"
                class="mobile-nav-link block px-4 py-3 rounded-[12px] text-gray-700 font-medium transition-all duration-300 {{ request()->routeIs('public.teacher-classes.*') ? 'bg-blue-500 text-white' : '' }}"
                onclick="closeMobileMenu()">
                <span class="text-lg mr-3">👩‍🏫</span>Guru
            </a>

            <a href="{{ route('navbar.mentor') }}"
                class="mobile-nav-link block px-4 py-3 rounded-[12px] text-gray-700 font-medium transition-all duration-300 {{ request()->routeIs('navbar.mentor') || request()->routeIs('mentor.*') ? 'bg-blue-500 text-white' : '' }}"
                onclick="closeMobileMenu()">
                <span class="text-lg mr-3">👨‍🏫</span>Mentor
            </a>

            @if (auth()->user()->role === 'siswa')
                <a href="{{ route('achievements.index') }}"
                    class="mobile-nav-link block px-4 py-3 rounded-[12px] text-gray-700 font-medium transition-all duration-300 {{ request()->routeIs('achievements.*') ? 'bg-blue-500 text-white' : '' }}"
                    onclick="closeMobileMenu()">
                    <span class="text-lg mr-3">🏆</span>Achievement
                </a>
            @endif

            @if (auth()->user()->role === 'mentor')
                <a href="{{ route('post_tests.approval_requests') }}"
                    class="mobile-nav-link block px-4 py-3 rounded-[12px] text-gray-700 font-medium transition-all duration-300 relative {{ request()->routeIs('post_tests.approval_requests') ? 'bg-blue-500 text-white' : '' }}"
                    onclick="closeMobileMenu()">
                    <span class="text-lg mr-3">✅</span>Approval Requests
                    @if ($pendingCount > 0)
                        <span class="absolute top-2 right-2 bg-red-500 text-white text-xs rounded-full px-1.5 py-0.5 min-w-[1.25rem] h-5 flex items-center justify-center">{{ $pendingCount }}</span>
                    @endif
                </a>
            @endif

            <!-- Chat Button Mobile -->
            <a href="{{ route('chat.index') }}"
                class="mobile-nav-link block px-4 py-3 rounded-[12px] text-gray-700 font-medium transition-all duration-300 relative {{ request()->routeIs('chat.*') ? 'bg-blue-500 text-white' : '' }}"
                onclick="closeMobileMenu()">
                <span class="text-lg mr-3">💬</span>Pesan
                <span id="unreadBadgeMobile" class="absolute top-2 right-2 bg-red-500 text-white text-xs rounded-full px-1.5 py-0.5 min-w-[1.25rem] h-5 flex items-center justify-center font-bold animate-pulse" style="display: none;">
                    <span id="unreadCountMobile">0</span>
                </span>
            </a>
        </div>
    </div>
</div>

        <div class="user-dropdown relative" id="userDropdown">
            <div class="user-info flex items-center gap-3 px-5 py-2.5 rounded-[30px] cursor-pointer transition-all duration-300 ease-in-out border-0 m-0 hover:-translate-y-px hover:bg-white"
                style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(15px); box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);"
                onclick="toggleDropdown()">
                @if (auth()->check())
                    <span class="user-name font-semibold text-gray-700 text-sm">{{ auth()->user()->name }}</span>

                    {{-- Updated Avatar Section --}}
                    <div
                        class="user-avatar w-[38px] h-[38px] rounded-full overflow-hidden shadow-lg border-2 border-white/30">
                        @if (auth()->user()->avatar)
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}"
                                alt="{{ auth()->user()->name }}" class="w-full h-full object-cover"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            {{-- Fallback if image fails to load --}}
                            <div class="w-full h-full flex items-center justify-center text-white font-bold text-sm"
                                style="background: linear-gradient(135deg, #4fc3f7 0%, #29b6f6 100%); display: none;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @else
                            {{-- Fallback to UI Avatars if no avatar uploaded --}}
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&size=38&background=4fc3f7&color=ffffff&font-size=0.6"
                                alt="{{ auth()->user()->name }}" class="w-full h-full object-cover"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            {{-- Final fallback --}}
                            <div class="w-full h-full flex items-center justify-center text-white font-bold text-sm"
                                style="background: linear-gradient(135deg, #4fc3f7 0%, #29b6f6 100%); display: none;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                @else
                    <span class="user-name font-semibold text-gray-700 text-sm">Guest</span>
                    <div class="user-avatar w-[38px] h-[38px] rounded-full flex items-center justify-center text-white font-bold text-sm"
                        style="background: linear-gradient(135deg, #4fc3f7 0%, #29b6f6 100%); box-shadow: 0 2px 10px rgba(79, 195, 247, 0.3);">
                        👤</div>
                @endif
                <span
                    class="dropdown-arrow text-xs text-gray-500 transition-transform duration-300 ease-in-out">▼</span>
            </div>

            <div class="dropdown-menu absolute top-full mt-4 right-0 bg-white rounded-[20px] min-w-[200px] opacity-0 invisible -translate-y-4 scale-95 z-[1000] overflow-hidden border border-black border-opacity-5"
                style="box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
                <a href="{{ route('profile.index') }}"
                    class="dropdown-item flex items-center gap-4 px-6 py-4 text-gray-700 no-underline transition-all duration-300 ease-in-out font-medium text-sm hover:text-blue-600"
                    style="hover:background: rgba(79, 195, 247, 0.1);">
                    <span class="dropdown-icon text-lg">👤</span>
                    Profile
                </a>

                @if (auth()->check())
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit"
                            class="dropdown-item logout flex items-center gap-4 px-6 py-4 text-gray-700 transition-all duration-300 ease-in-out font-medium border-0 bg-transparent w-full cursor-pointer text-sm hover:text-red-500"
                            style="font-family: inherit; hover:background: rgba(239, 68, 68, 0.1);">
                            <span class="dropdown-icon text-lg">🚪</span>
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="dropdown-item flex items-center gap-4 px-6 py-4 text-gray-700 no-underline transition-all duration-300 ease-in-out font-medium text-sm hover:text-blue-600"
                        style="hover:background: rgba(79, 195, 247, 0.1);">
                        <span class="dropdown-icon text-lg">👤</span>
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="dropdown-item flex items-center gap-4 px-6 py-4 text-gray-700 no-underline transition-all duration-300 ease-in-out font-medium text-sm hover:text-blue-600"
                        style="hover:background: rgba(79, 195, 247, 0.1);">
                        <span class="dropdown-icon text-lg">📝</span>
                        Sign Up
                    </a>
                @endif
            </div>
        </div>
    </div>
</nav>

<style>
    /* RESET GLOBAL - PENTING UNTUK INCLUDE */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html {
        margin: 0;
        padding: 0;
        scroll-behavior: smooth;
    }

    /* BODY DENGAN PADDING-TOP YANG BENAR */
    body {
        margin: 0 !important;
        padding: 0 !important;
        padding-top: 85px !important;
        font-family: 'Figtree', sans-serif;
        background: #f8fafc;
        line-height: 1.6;
        overflow-x: hidden;
    }

    /* NAVBAR DENGAN POSISI FIXED YANG BENAR */
    .navbar {
        background: linear-gradient(135deg, #4fc3f7 0%, #29b6f6 100%);
        padding: 0;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        backdrop-filter: blur(20px);
        height: 85px;
        margin: 0;
    }

    /* Mobile Menu Button */
    .mobile-menu-btn {
        display: flex;
        flex-direction: column;
        gap: 4px;
        background: rgba(255, 255, 255, 0.9);
        border: none;
        padding: 8px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .hamburger-line {
        width: 20px;
        height: 2px;
        background: #374151;
        transition: all 0.3s ease;
        border-radius: 2px;
    }

    .mobile-menu-btn.active .hamburger-line:nth-child(1) {
        transform: rotate(45deg) translate(5px, 5px);
    }

    .mobile-menu-btn.active .hamburger-line:nth-child(2) {
        opacity: 0;
    }

    .mobile-menu-btn.active .hamburger-line:nth-child(3) {
        transform: rotate(-45deg) translate(7px, -6px);
    }

    /* Mobile Navigation Menu */
    .mobile-nav-menu.active {
        transform: translateY(0);
        opacity: 1;
        visibility: visible;
    }

    .mobile-nav-link:hover {
        background: rgba(79, 195, 247, 0.1) !important;
        color: #1976d2 !important;
    }

    /* User Avatar Styles */
    .user-avatar {
        transition: all 0.3s ease;
    }

    .user-avatar:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(79, 195, 247, 0.4) !important;
    }

    /* User Dropdown Active State */
    .user-dropdown.active .dropdown-arrow {
        transform: rotate(180deg);
    }

    .user-dropdown.active .dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0) scale(1);
    }

    /* Hover Effects */
    .nav-links li a:hover {
        background: rgba(79, 195, 247, 0.15) !important;
        color: #1976d2 !important;
    }

    .user-info:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
    }

    .dropdown-item:hover {
        background: rgba(79, 195, 247, 0.1) !important;
        color: #1976d2 !important;
    }

    .dropdown-item.logout:hover {
        background: rgba(239, 68, 68, 0.1) !important;
        color: #ef4444 !important;
    }

    /* Focus untuk accessibility */
    .nav-links li a:focus,
    .user-info:focus,
    .dropdown-item:focus {
        outline: 2px solid #1976d2;
        outline-offset: 2px;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .nav-left {
            gap: 1.5rem;
        }

        .nav-links {
            gap: 0.3rem;
        }

        .nav-links li a {
            padding: 0.7rem 1rem;
            font-size: 0.85rem;
        }
    }

    @media (min-width: 769px) {
        .mobile-menu-btn {
            display: none !important;
            /* Force hide di desktop */
        }

        .nav-links {
            display: flex !important;
            /* Force show di desktop */
        }

        .mobile-nav-menu {
            display: none !important;
            /* Force hide mobile menu di desktop */
        }
    }

    @media (max-width: 768px) {
        body {
            padding-top: 85px !important;
            /* Tetap sama untuk konsistensi */
        }

        nav {
            height: 85px;
            /* Tetap sama */
        }

        .flex.justify-between.items-center {
            padding: 0 1rem;
        }

        .nav-links {
            display: none !important;
            /* Force hide desktop menu di mobile */
        }

        .mobile-menu-btn {
            display: flex !important;
            /* Force show mobile menu button */
        }

        .mobile-nav-menu {
            top: 85px;
            /* Sesuaikan dengan tinggi navbar */
        }

        .user-info {
            padding: 0.5rem 1rem;
        }

        .user-name {
            display: none;
            /* Sembunyikan nama di mobile */
        }

        .dropdown-menu {
            min-width: 180px;
            right: -10px;
        }

        .logo {
            width: 60px;
            height: 60px;
        }

        .user-avatar {
            width: 32px !important;
            height: 32px !important;
        }
    }

    @media (max-width: 480px) {
        .flex.justify-between.items-center {
            padding: 0 0.8rem;
        }

        .user-info {
            padding: 0.4rem 0.8rem;
        }

        .dropdown-menu {
            min-width: 160px;
            right: -5px;
        }

        .dropdown-item {
            padding: 0.8rem 1.2rem;
            font-size: 0.85rem;
        }

        .logo {
            width: 50px;
            height: 50px;
        }

        .user-avatar {
            width: 28px !important;
            height: 28px !important;
        }
    }
</style>

<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('userDropdown');
        dropdown.classList.toggle('active');
    }

    function toggleMobileMenu() {
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileNavMenu = document.getElementById('mobileNavMenu');

        mobileMenuBtn.classList.toggle('active');
        mobileNavMenu.classList.toggle('active');
    }

    function closeMobileMenu() {
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileNavMenu = document.getElementById('mobileNavMenu');

        mobileMenuBtn.classList.remove('active');
        mobileNavMenu.classList.remove('active');
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('userDropdown');
        const mobileMenu = document.getElementById('mobileNavMenu');
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');

        // Close user dropdown
        if (!dropdown.contains(event.target)) {
            dropdown.classList.remove('active');
        }

        // Close mobile menu
        if (!mobileMenu.contains(event.target) && !mobileMenuBtn.contains(event.target)) {
            mobileMenu.classList.remove('active');
            mobileMenuBtn.classList.remove('active');
        }
    });

    // Enhanced dropdown functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Smooth navbar scroll effect - REMOVED THE HIDE FUNCTIONALITY
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('nav');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(79, 195, 247, 0.95)';
                navbar.style.boxShadow = '0 8px 32px rgba(0, 0, 0, 0.15)';
            } else {
                navbar.style.background = 'linear-gradient(135deg, #4fc3f7 0%, #29b6f6 100%)';
                navbar.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.1)';
            }
        });

        // Keyboard navigation for dropdown
        document.addEventListener('keydown', function(e) {
            const dropdown = document.getElementById('userDropdown');
            const mobileMenu = document.getElementById('mobileNavMenu');
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');

            if (e.key === 'Escape') {
                dropdown.classList.remove('active');
                mobileMenu.classList.remove('active');
                mobileMenuBtn.classList.remove('active');
            }
        });

        // Prevent body scroll when mobile menu is open
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileNavMenu = document.getElementById('mobileNavMenu');

        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                    if (mobileNavMenu.classList.contains('active')) {
                        document.body.style.overflow = 'hidden';
                    } else {
                        document.body.style.overflow = '';
                    }
                }
            });
        });

        observer.observe(mobileNavMenu, {
            attributes: true
        });
    });

    // Chat Unread Count Functions
    @auth
    function updateUnreadCount() {
        fetch('{{ route("chat.unread-count") }}')
            .then(response => response.json())
            .then(data => {
                const count = data.unread_count;
                const badge = document.getElementById('unreadBadge');
                const badgeMobile = document.getElementById('unreadBadgeMobile');
                const floatingBadge = document.getElementById('floatingBadge');
                const countElement = document.getElementById('unreadCount');
                const countMobileElement = document.getElementById('unreadCountMobile');
                const floatingCountElement = document.getElementById('floatingCount');
                
                if (count > 0) {
                    // Show badges
                    if (badge) {
                        badge.style.display = 'flex';
                        countElement.textContent = count > 99 ? '99+' : count;
                    }
                    if (badgeMobile) {
                        badgeMobile.style.display = 'flex';
                        countMobileElement.textContent = count > 99 ? '99+' : count;
                    }
                    if (floatingBadge) {
                        floatingBadge.style.display = 'flex';
                        floatingCountElement.textContent = count > 99 ? '99+' : count;
                    }
                    
                    // Update page title with unread count
                    const originalTitle = document.title.replace(/^\(\d+\)\s/, '');
                    document.title = `(${count}) ${originalTitle}`;
                } else {
                    // Hide badges
                    if (badge) badge.style.display = 'none';
                    if (badgeMobile) badgeMobile.style.display = 'none';
                    if (floatingBadge) floatingBadge.style.display = 'none';
                    
                    // Remove count from title
                    document.title = document.title.replace(/^\(\d+\)\s/, '');
                }
            })
            .catch(error => {
                console.log('Error fetching unread count:', error);
            });
    }

    // Update count on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateUnreadCount();
    });

    // Update count every 30 seconds
    setInterval(updateUnreadCount, 30000);

    // Update count when page becomes visible (user switches back to tab)
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            updateUnreadCount();
        }
    });

    // Listen for Livewire events to update count immediately
    document.addEventListener('livewire:init', () => {
        Livewire.on('conversation-updated', () => {
            setTimeout(updateUnreadCount, 1000); // Small delay to ensure DB is updated
        });
    });
    @endauth

    // Chat Unread Count Functions
    @auth
    function updateUnreadCount() {
        fetch('{{ route("chat.unread-count") }}')
            .then(response => response.json())
            .then(data => {
                const count = data.unread_count;
                const badge = document.getElementById('unreadBadge');
                const badgeMobile = document.getElementById('unreadBadgeMobile');
                const floatingBadge = document.getElementById('floatingBadge');
                const countElement = document.getElementById('unreadCount');
                const countMobileElement = document.getElementById('unreadCountMobile');
                const floatingCountElement = document.getElementById('floatingCount');
                
                if (count > 0) {
                    // Show badges
                    if (badge) {
                        badge.style.display = 'flex';
                        countElement.textContent = count > 99 ? '99+' : count;
                    }
                    if (badgeMobile) {
                        badgeMobile.style.display = 'flex';
                        countMobileElement.textContent = count > 99 ? '99+' : count;
                    }
                    if (floatingBadge) {
                        floatingBadge.style.display = 'flex';
                        floatingCountElement.textContent = count > 99 ? '99+' : count;
                    }
                    
                    // Update page title with unread count
                    const originalTitle = document.title.replace(/^\(\d+\)\s/, '');
                    document.title = `(${count}) ${originalTitle}`;
                } else {
                    // Hide badges
                    if (badge) badge.style.display = 'none';
                    if (badgeMobile) badgeMobile.style.display = 'none';
                    if (floatingBadge) floatingBadge.style.display = 'none';
                    
                    // Remove count from title
                    document.title = document.title.replace(/^\(\d+\)\s/, '');
                }
            })
            .catch(error => {
                console.log('Error fetching unread count:', error);
            });
    }

    // Update count on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateUnreadCount();
    });

    // Update count every 30 seconds
    setInterval(updateUnreadCount, 30000);

    // Update count when page becomes visible (user switches back to tab)
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            updateUnreadCount();
        }
    });

    // Listen for Livewire events to update count immediately
    document.addEventListener('livewire:init', () => {
        Livewire.on('conversation-updated', () => {
            setTimeout(updateUnreadCount, 1000); // Small delay to ensure DB is updated
        });
    });
    @endauth
</script>

<!-- Floating Chat Button (Mobile) -->
@auth
<div class="fixed bottom-6 right-6 z-50 md:hidden">
    <a href="{{ route('chat.index') }}" 
       class="relative inline-flex items-center justify-center w-14 h-14 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full shadow-lg hover:shadow-xl transform hover:scale-110 transition-all duration-300">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a8.959 8.959 0 01-2.4-.32l-4.6 1.92 1.92-4.6A8.959 8.959 0 013 12c0-4.418 3.582-8 8-8s8 3.582 8 8z"></path>
        </svg>
        <span id="floatingBadge" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold animate-bounce" style="display: none;">
            <span id="floatingCount">0</span>
        </span>
    </a>
</div>
@endauth

<!-- Floating Chat Button (Mobile) -->
@auth
<div class="fixed bottom-6 right-6 z-50 md:hidden">
    <a href="{{ route('chat.index') }}" 
       class="relative inline-flex items-center justify-center w-14 h-14 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full shadow-lg hover:shadow-xl transform hover:scale-110 transition-all duration-300">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a8.959 8.959 0 01-2.4-.32l-4.6 1.92 1.92-4.6A8.959 8.959 0 013 12c0-4.418 3.582-8 8-8s8 3.582 8 8z"></path>
        </svg>
        <span id="floatingBadge" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold animate-bounce" style="display: none;">
            <span id="floatingCount">0</span>
        </span>
    </a>
</div>
@endauth
