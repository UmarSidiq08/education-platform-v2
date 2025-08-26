<nav class="fixed top-0 left-0 right-0 z-[1000] h-[85px] m-0 p-0 shadow-lg"
    style="background: linear-gradient(135deg, #4fc3f7 0%, #29b6f6 100%); backdrop-filter: blur(20px);">
    <div class="flex justify-between items-center max-w-[1400px] mx-auto w-full h-full px-8">
        <div class="flex items-center gap-8">
            <div class="logo">
                <div
                    class="logo-icon w-[45px] h-[45px] bg-white rounded-xl flex items-center justify-center text-[1.6rem] shadow-lg transition-transform duration-300 ease-in-out hover:scale-105">
                    😹
                </div>
            </div>
            <ul class="nav-links flex gap-2 list-none items-center m-0 p-2 rounded-[15px] shadow-xl"
                style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(15px);">


                <li class="m-0 p-0">
                    <a href="{{ route('dashboard') }}"
                        class="no-underline font-semibold px-5 py-3 rounded-[15px] transition-all duration-300 ease-in-out relative whitespace-nowrap text-sm block hover:text-blue-600 hover:-translate-y-0.5 active:text-white {{ request()->routeIs('dashboard') ? 'text-white shadow-lg' : 'text-gray-700' }}"
                        style="{{ request()->routeIs('dashboard') ? 'background: linear-gradient(135deg, #1976d2 0%, #42a5f5 100%); box-shadow: 0 4px 15px rgba(25, 118, 210, 0.3);' : '' }}">Dashboard</a>
                </li>
                <li class="m-0 p-0">
                    <a href="{{ route('classes.index') }}"
                        class="no-underline font-semibold px-5 py-3 rounded-[15px] transition-all duration-300 ease-in-out relative whitespace-nowrap text-sm block hover:text-blue-600 hover:-translate-y-0.5 {{ request()->routeIs('classes.index') || request()->routeIs('classes.*') || request()->routeIs('materials.*') ? 'text-white shadow-lg' : 'text-gray-700' }}"
                        style="{{ request()->routeIs('classes.*') || request()->routeIs('materials.*') ? 'background: linear-gradient(135deg, #1976d2 0%, #42a5f5 100%); box-shadow: 0 4px 15px rgba(25, 118, 210, 0.3);' : '' }}">Classes</a>
                </li>

                <li class="m-0 p-0">
                    <a href="{{ route('navbar.mentor') }}"
                        class="no-underline font-semibold px-5 py-3 rounded-[15px] transition-all duration-300 ease-in-out relative whitespace-nowrap text-sm block hover:text-blue-600 hover:-translate-y-0.5 {{ request()->routeIs('navbar.mentor') ? 'text-white shadow-lg' : 'text-gray-700' }}"
                        style="{{ request()->routeIs('navbar.mentor') ? 'background: linear-gradient(135deg, #1976d2 0%, #42a5f5 100%); box-shadow: 0 4px 15px rgba(25, 118, 210, 0.3);' : '' }}">Mentor</a>
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
                                $pendingCount = App\Models\PostTestAttempt::whereHas('postTest.class', function ($query, ) {
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
            </ul>
        </div>
        <div class="user-dropdown relative" id="userDropdown">
            <div class="user-info flex items-center gap-3 px-5 py-2.5 rounded-[30px] cursor-pointer transition-all duration-300 ease-in-out border-0 m-0 hover:-translate-y-px hover:bg-white"
                style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(15px); box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);"
                onclick="toggleDropdown()">
                @if (auth()->check())
                    <span class="user-name font-semibold text-gray-700 text-sm">{{ auth()->user()->name }}</span>
                    <div class="user-avatar w-[38px] h-[38px] rounded-full flex items-center justify-center text-white font-bold text-sm"
                        style="background: linear-gradient(135deg, #4fc3f7 0%, #29b6f6 100%); box-shadow: 0 2px 10px rgba(79, 195, 247, 0.3);">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
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

    @media (max-width: 768px) {
        body {
            padding-top: 75px !important;
        }

        nav {
            height: 75px;
        }

        .nav-container {
            padding: 0 1rem;
        }

        .nav-links {
            display: none;
        }

        .nav-left {
            gap: 1rem;
        }

        .user-info {
            padding: 0.5rem 1rem;
        }

        .user-name {
            display: none;
        }

        .dropdown-menu {
            min-width: 180px;
            right: -10px;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            font-size: 1.4rem;
        }
    }

    @media (max-width: 480px) {
        body {
            padding-top: 70px !important;
        }

        nav {
            height: 70px;
        }

        .nav-container {
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
    }
</style>

<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('userDropdown');
        dropdown.classList.toggle('active');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function (event) {
        const dropdown = document.getElementById('userDropdown');
        if (!dropdown.contains(event.target)) {
            dropdown.classList.remove('active');
        }
    });

    // Enhanced dropdown functionality
    document.addEventListener('DOMContentLoaded', function () {
        // Smooth navbar scroll effect
        window.addEventListener('scroll', function () {
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
        document.addEventListener('keydown', function (e) {
            const dropdown = document.getElementById('userDropdown');
            if (e.key === 'Escape') {
                dropdown.classList.remove('active');
            }
        });

        // Enhanced mobile menu handling
        const navbar = document.querySelector('nav');
        let lastScrollY = window.scrollY;

        window.addEventListener('scroll', () => {
            if (window.innerWidth <= 768) {
                if (window.scrollY > lastScrollY && window.scrollY > 100) {
                    navbar.style.transform = 'translateY(-100%)';
                } else {
                    navbar.style.transform = 'translateY(0)';
                }
                lastScrollY = window.scrollY;
            }
        });
    });
</script>