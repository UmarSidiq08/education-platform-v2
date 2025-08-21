
            <nav class="navbar">
                <div class="nav-container">
                    <div class="nav-left">
                        <div class="logo">
                            <div class="logo-icon">📚</div>
                        </div>
                        <ul class="nav-links">
                            <li><a href="{{ route('dashboard') }}"
                                    class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Home</a></li>

                            <li><a href="{{ route('navbar.achievement') }}" class="{{ request()->routeIs('navbar.achievement') ? 'active' : '' }}">Achievement</a></li>

                            <li><a href="{{ route('classes.index') }}"
                                    class="{{ request()->routeIs('classes.index') || request()->routeIs('classes.*') ? 'active' : '' }}">Classes</a>
                            </li>

                            <li><a href="{{ route('navbar.mentor') }}" class="{{ request()->routeIs('navbar.mentor') ? 'active' : '' }}">Mentor</a></li>

                            <li><a href="{{ route('navbar.leaderboard') }}"
                                    class="{{ request()->routeIs('leaderboard') ? 'active' : '' }}">Leaderboard</a></li>
                        </ul>
                    </div>
                    <div class="user-dropdown" id="userDropdown">
                        <div class="user-info" onclick="toggleDropdown()">
                            @if (auth()->check())
                                <span class="user-name">{{ auth()->user()->name }}</span>
                                <div class="user-avatar">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @else
                                <span class="user-name">Guest</span>
                                <div class="user-avatar">👤</div>
                            @endif

                            
                            <span class="dropdown-arrow">▼</span>
                        </div>

                        <div class="dropdown-menu">
                            {{-- Profile Link --}}

                   


                            <a href="{{ route('profile.index') }}" class="dropdown-item">
                                <span class="dropdown-icon">👤</span>
                                Profile
                            </a>


                            @if (auth()->check())
                                {{-- Logout --}}
                                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <button type="submit" class="dropdown-item logout">
                                        <span class="dropdown-icon">🚪</span>
                                        Logout
                                    </button>
                                </form>
                            @else
                                {{-- Login & Sign Up --}}
                                <a href="{{ route('login') }}" class="dropdown-item">
                                    <span class="dropdown-icon">👤</span>
                                    Login
                                </a>
                                <a href="{{ route('register') }}" class="dropdown-item">
                                    <span class="dropdown-icon">📝</span>
                                    Sign Up
                                </a>
                            @endif
                            
                        </div>
                    </div>

                </div>
            </nav>

            <!-- Page Heading (opsional) -->


        <!-- Additional scripts -->


        <style>
            /* ===================
               CRITICAL FIXES FOR INCLUDE
               =================== */

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
                padding-top: 85px !important; /* KOMPENSASI NAVBAR FIXED */
                font-family: 'Figtree', sans-serif;
                background: #f8fafc;
                line-height: 1.6;
                overflow-x: hidden;
            }

            /* NAVBAR DENGAN POSISI FIXED YANG BENAR */
            .navbar {
                background: linear-gradient(135deg, #4fc3f7 0%, #29b6f6 100%);
                padding: 0; /* HAPUS PADDING DARI NAVBAR */
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                z-index: 1000;
                backdrop-filter: blur(20px);
                height: 85px; /* TINGGI NAVBAR YANG PASTI */
                margin: 0; /* PASTIKAN TIDAK ADA MARGIN */
            }

            .nav-container {
                display: flex;
                justify-content: space-between;
                align-items: center;
                max-width: 1400px;
                margin: 0 auto;
                width: 100%;
                height: 100%; /* GUNAKAN FULL HEIGHT */
                padding: 0 2rem; /* PADDING PINDAH KE CONTAINER */
            }

            .nav-left {
                display: flex;
                align-items: center;
                gap: 2rem;
            }

            .logo-icon {
                width: 45px;
                height: 45px;
                background: white;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.6rem;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s ease;
            }

            .logo-icon:hover {
                transform: scale(1.05);
            }

            .nav-links {
                display: flex;
                gap: 0.5rem;
                list-style: none;
                align-items: center;
                background: rgba(255, 255, 255, 0.95);
                padding: 0.4rem;
                border-radius: 15px;
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
                backdrop-filter: blur(15px);
                margin: 0; /* HAPUS DEFAULT MARGIN UL */
            }

            .nav-links li {
                margin: 0;
                padding: 0;
            }

            .nav-links li a {
                text-decoration: none;
                color: #374151;
                font-weight: 600;
                padding: 0.8rem 1.3rem;
                border-radius: 15px;
                transition: all 0.3s ease;
                position: relative;
                white-space: nowrap;
                font-size: 0.9rem;
                display: block;
            }

            .nav-links li a:hover {
                background: rgba(79, 195, 247, 0.15);
                color: #1976d2;
                transform: translateY(-2px);
            }

            .nav-links li a.active {
                background: linear-gradient(135deg, #1976d2 0%, #42a5f5 100%);
                color: white;
                box-shadow: 0 4px 15px rgba(25, 118, 210, 0.3);
            }

            /* User Dropdown */
            .user-dropdown {
                position: relative;
            }

            .user-info {
                display: flex;
                align-items: center;
                gap: 0.8rem;
                background: rgba(255, 255, 255, 0.95);
                padding: 0.6rem 1.2rem;
                border-radius: 30px;
                cursor: pointer;
                transition: all 0.3s ease;
                backdrop-filter: blur(15px);
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                border: none;
                margin: 0;
            }

            .user-info:hover {
                background: white;
                transform: translateY(-1px);
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            }

            .user-avatar {
                width: 38px;
                height: 38px;
                border-radius: 50%;
                background: linear-gradient(135deg, #4fc3f7 0%, #29b6f6 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                font-weight: bold;
                box-shadow: 0 2px 10px rgba(79, 195, 247, 0.3);
                font-size: 0.9rem;
            }

            .user-name {
                font-weight: 600;
                color: #374151;
                font-size: 0.9rem;
            }

            .dropdown-arrow {
                font-size: 0.7rem;
                color: #6b7280;
                transition: transform 0.3s ease;
            }

            .user-dropdown.active .dropdown-arrow {
                transform: rotate(180deg);
            }

            .dropdown-menu {
                position: absolute;
                top: calc(100% + 15px);
                right: 0;
                background: white;
                border-radius: 20px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
                min-width: 200px;
                opacity: 0;
                visibility: hidden;
                transform: translateY(-15px) scale(0.95);
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                z-index: 1000;
                overflow: hidden;
                border: 1px solid rgba(0, 0, 0, 0.05);
            }

            .user-dropdown.active .dropdown-menu {
                opacity: 1;
                visibility: visible;
                transform: translateY(0) scale(1);
            }

            .dropdown-item {
                display: flex;
                align-items: center;
                gap: 1rem;
                padding: 1rem 1.5rem;
                color: #374151;
                text-decoration: none;
                transition: all 0.3s ease;
                font-weight: 500;
                border: none;
                background: none;
                width: 100%;
                cursor: pointer;
                font-family: inherit;
                font-size: 0.9rem;
            }

            .dropdown-item:hover {
                background: rgba(79, 195, 247, 0.1);
                color: #1976d2;
            }

            .dropdown-item.logout:hover {
                background: rgba(239, 68, 68, 0.1);
                color: #ef4444;
            }

            .dropdown-icon {
                font-size: 1.2rem;
            }

            /* ===================
               FIXES FOR CONTAINERS
               =================== */

            /* PASTIKAN CONTAINER UTAMA TIDAK ADA MARGIN/PADDING BERLEBIH */
            .min-h-screen {
                margin: 0 !important;
                padding: 0 !important;
            }

            /* HEADER SECTION */
            header.bg-white {
                margin: 0 !important;
                padding: 0 !important;
            }

            /* MAIN CONTENT */
            main {
                margin: 0 !important;
                padding: 0 !important;
            }

            /* CAROUSEL WRAPPER ADJUSTMENT */
            .carousel-wrapper {
                margin-top: 0 !important; /* HAPUS MARGIN-TOP KARENA BODY SUDAH ADA PADDING-TOP */
                padding: 2rem;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: calc(100vh - 85px); /* SESUAIKAN DENGAN TINGGI NAVBAR */
                display: flex;
                align-items: center;
                position: relative;
                overflow: hidden;
            }

            /* BOTTOM SECTION ADJUSTMENT */
            .bottom-section {
                margin: 0 !important;
                padding: 6rem 2rem !important;
            }

            /* ===================
               RESPONSIVE DESIGN
               =================== */
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
                    padding-top: 75px !important; /* SESUAIKAN UNTUK MOBILE */
                }

                .navbar {
                    height: 75px; /* TINGGI NAVBAR MOBILE */
                }

                .nav-container {
                    padding: 0 1rem;
                }

                .nav-links {
                    display: none; /* SEMBUNYIKAN MENU DI MOBILE */
                }

                .nav-left {
                    gap: 1rem;
                }

                .user-info {
                    padding: 0.5rem 1rem;
                }

                .user-name {
                    display: none; /* SEMBUNYIKAN NAMA USER DI MOBILE */
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

                .carousel-wrapper {
                    min-height: calc(100vh - 75px);
                }
            }

            @media (max-width: 480px) {
                body {
                    padding-top: 70px !important;
                }

                .navbar {
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

                .carousel-wrapper {
                    min-height: calc(100vh - 70px);
                }
            }

            /* ===================
               ACCESSIBILITY
               =================== */
            .nav-links li a:focus,
            .user-info:focus,
            .dropdown-item:focus {
                outline: 2px solid #1976d2;
                outline-offset: 2px;
            }
        </style>

        <script>
            function toggleDropdown() {
                const dropdown = document.getElementById('userDropdown');
                dropdown.classList.toggle('active');
            }

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                const dropdown = document.getElementById('userDropdown');
                if (!dropdown.contains(event.target)) {
                    dropdown.classList.remove('active');
                }
            });

            // Enhanced dropdown functionality
            document.addEventListener('DOMContentLoaded', function() {
                // Smooth navbar scroll effect
                window.addEventListener('scroll', function() {
                    const navbar = document.querySelector('.navbar');
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
                    if (e.key === 'Escape') {
                        dropdown.classList.remove('active');
                    }
                });

                // Enhanced mobile menu handling
                const navbar = document.querySelector('.navbar');
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
    </body>
</html>
