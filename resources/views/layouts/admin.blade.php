<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title', 'Dashboard')</title>

    {{-- Bootstrap & DataTables CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        /* Custom Responsive Styles */
        :root {
            --sidebar-width: 280px;
            --sidebar-collapsed-width: 80px;
            --header-height: 70px;
        }

        * {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #f8fafc;
        }

        /* Sidebar Styles */
        .admin-sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 1000;
            transform: translateX(-100%);
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #475569 transparent;
        }

        .admin-sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .admin-sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .admin-sidebar::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 3px;
        }

        .admin-sidebar.open {
            transform: translateX(0);
        }

        /* Desktop Sidebar */
        @media (min-width: 1024px) {
            .admin-sidebar {
                transform: translateX(0);
                position: fixed;
            }

            .admin-sidebar.collapsed {
                width: var(--sidebar-collapsed-width);
            }

            .admin-sidebar.collapsed .nav-text,
            .admin-sidebar.collapsed .sidebar-brand span {
                opacity: 0;
                pointer-events: none;
            }

            .admin-sidebar.collapsed .nav-link {
                justify-content: center;
                padding: 1rem;
            }

            .main-content {
                margin-left: var(--sidebar-width);
            }

            .main-content.expanded {
                margin-left: var(--sidebar-collapsed-width);
            }
        }

        /* Mobile Overlay */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            backdrop-filter: blur(2px);
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Header Styles */
        .admin-header {
            height: var(--header-height);
            background: white;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        /* Navigation Styles */
        .nav-link {
            color: #cbd5e1;
            padding: 0.875rem 1.5rem;
            border-radius: 12px;
            margin: 0.25rem 1rem;
            display: flex;
            align-items: center;
            text-decoration: none;
            font-weight: 500;
            position: relative;
        }

        .nav-link:hover {
            background: rgba(59, 130, 246, 0.1);
            color: #60a5fa;
            transform: translateX(4px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: -1rem;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 24px;
            background: #60a5fa;
            border-radius: 2px;
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            margin-right: 0.875rem;
            flex-shrink: 0;
        }

        /* Toggle Button */
        .sidebar-toggle {
            width: 44px;
            height: 44px;
            background: #3b82f6;
            border: none;
            border-radius: 12px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
            position: relative;
            z-index: 1001;
        }

        .sidebar-toggle:hover {
            background: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
        }

        .toggle-icon {
            width: 20px;
            height: 20px;
            transition: transform 0.3s ease;
        }

        .toggle-icon.rotated {
            transform: rotate(180deg);
        }

        /* Brand Styles */
        .sidebar-brand {
            padding: 2rem 1.5rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 1rem;
        }

        .brand-logo {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
        }

        /* User Profile */
        .user-profile {
            padding: 1rem 1.5rem;
            margin: 1rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            margin-right: 0.75rem;
        }

        /* Logout Button */
        .logout-btn {
            margin: 1rem;
            padding: 0.875rem 1.5rem;
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 12px;
            color: #fca5a5;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .logout-btn:hover {
            background: #dc2626;
            color: white;
            border-color: #dc2626;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }

        /* Content Styles */
        .main-content {
            min-height: 100vh;
            background: #f8fafc;
            transition: margin-left 0.3s ease;
        }

        .content-wrapper {
            padding: 2rem;
            max-width: 1400px;
        }

        /* Mobile Responsive */
        @media (max-width: 1023px) {
            .main-content {
                margin-left: 0 !important;
            }

            .content-wrapper {
                padding: 1rem;
            }

            .admin-header {
                padding-left: 0;
            }
        }

        @media (max-width: 640px) {
            .sidebar-toggle {
                width: 40px;
                height: 40px;
            }

            .content-wrapper {
                padding: 0.75rem;
            }
        }

        /* Animation Classes */
        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .slide-in {
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                transform: translateX(-20px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Loading States */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            border: 2px solid #3b82f6;
            border-top: 2px solid transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            transform: translate(-50%, -50%);
        }

        @keyframes spin {
            to {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }
    </style>

    @stack('styles')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <!-- Brand -->
        <div class="sidebar-brand">
            <div class="flex items-center">
                <div class="brand-logo">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="nav-text">
                    <span class="text-white text-xl font-bold">Admin Panel</span>
                    <p class="text-slate-400 text-sm mt-1">Management System</p>
                </div>
            </div>
        </div>

        <!-- User Profile -->
        <div class="user-profile">
            <div class="flex items-center">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="nav-text">
                    <p class="text-white font-semibold text-sm">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="text-slate-400 text-xs">Super Administrator</p>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="mt-4">
            <ul class="space-y-1">
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('mentor.pending') }}"
                        class="nav-link {{ request()->routeIs('mentor.pending*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-graduate"></i>
                        <span class="nav-text">Mentor Requests</span>

                    </a>
                </li>




            </ul>
        </nav>

        <!-- Logout Button -->
        <div class="mt-auto mb-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn w-full">
                    <i class="fas fa-sign-out-alt mr-3"></i>
                    <span class="nav-text">Logout</span>
                </button>
            </form>
        </div>
    </aside>


    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Header -->
        <header class="admin-header">
            <div class="flex items-center justify-between h-full px-4 lg:px-6">
                <!-- Left Side - Toggle & Breadcrumb -->
                <div class="flex items-center space-x-4">
                    <!-- Sidebar Toggle -->
                    <button class="sidebar-toggle" id="sidebarToggle" title="Toggle Sidebar">
                        <i class="toggle-icon fas fa-bars"></i>
                    </button>

                    <!-- Breadcrumb (Desktop Only) -->
                    <nav class="hidden lg:block">
                        <ol class="flex items-center space-x-2 text-sm text-gray-600">
                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">
                                    <i class="fas fa-home"></i>
                                </a>
                            </li>
                            @hasSection('breadcrumb')
                                @yield('breadcrumb')
                            @endif
                        </ol>
                    </nav>
                </div>

                <!-- Right Side - User Info & Actions -->
                <div class="flex items-center space-x-4">


                    <!-- User Dropdown -->
                    <div class="flex items-center space-x-3">
                        <div class="hidden lg:block text-right">
                            <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name ?? 'Admin User' }}
                            </p>
                            <p class="text-xs text-gray-500">Administrator</p>
                        </div>
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <main class="content-wrapper fade-in">
            <!-- Alert Messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-600 mr-3"></i>
                        <div>
                            <strong>Berhasil!</strong> {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-600 mr-3"></i>
                        <div>
                            <strong>Error!</strong> {{ session('error') }}
                        </div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            @yield('modal')
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Admin Layout Script -->
    <script>
        // Admin Dashboard Manager
        const AdminLayout = {
            // Configuration
            config: {
                breakpoint: 1024,
                storageKey: 'sidebar-collapsed',
                animationDuration: 300
            },

            // Elements
            elements: {
                sidebar: null,
                mainContent: null,
                sidebarToggle: null,
                sidebarOverlay: null,
                toggleIcon: null
            },

            // State
            state: {
                isMobile: false,
                isCollapsed: false,
                isOpen: false
            },

            // Initialize
            init() {
                this.cacheElements();
                this.bindEvents();
                this.handleResize();
                this.restoreState();
                this.updatePendingBadge();

                console.log('✅ Admin Layout initialized');
            },

            // Cache DOM elements
            cacheElements() {
                this.elements.sidebar = document.getElementById('adminSidebar');
                this.elements.mainContent = document.getElementById('mainContent');
                this.elements.sidebarToggle = document.getElementById('sidebarToggle');
                this.elements.sidebarOverlay = document.getElementById('sidebarOverlay');
                this.elements.toggleIcon = this.elements.sidebarToggle?.querySelector('.toggle-icon');
            },

            // Bind event handlers
            bindEvents() {
                // Toggle button click
                this.elements.sidebarToggle?.addEventListener('click', () => {
                    this.toggleSidebar();
                });

                // Overlay click (mobile)
                this.elements.sidebarOverlay?.addEventListener('click', () => {
                    this.closeSidebar();
                });

                // Window resize
                window.addEventListener('resize', () => {
                    this.handleResize();
                });

                // Keyboard shortcuts
                document.addEventListener('keydown', (e) => {
                    // Alt + S to toggle sidebar
                    if (e.altKey && e.key === 's') {
                        e.preventDefault();
                        this.toggleSidebar();
                    }

                    // Escape to close sidebar (mobile)
                    if (e.key === 'Escape' && this.state.isMobile && this.state.isOpen) {
                        this.closeSidebar();
                    }
                });

                // Navigation link clicks
                document.querySelectorAll('.nav-link').forEach(link => {
                    link.addEventListener('click', () => {
                        // Close sidebar on mobile after navigation
                        if (this.state.isMobile) {
                            setTimeout(() => this.closeSidebar(), 150);
                        }
                    });
                });
            },

            // Handle window resize
            handleResize() {
                const wasToMobile = this.state.isMobile;
                this.state.isMobile = window.innerWidth < this.config.breakpoint;

                // If switching from desktop to mobile
                if (!wasToMobile && this.state.isMobile) {
                    this.closeSidebar();
                }

                // If switching from mobile to desktop
                if (wasToMobile && !this.state.isMobile) {
                    this.elements.sidebarOverlay?.classList.remove('active');
                    this.elements.sidebar?.classList.remove('open');
                    this.state.isOpen = false;

                    // Restore collapsed state on desktop
                    if (this.state.isCollapsed) {
                        this.elements.sidebar?.classList.add('collapsed');
                        this.elements.mainContent?.classList.add('expanded');
                    }
                }
            },

            // Toggle sidebar
            toggleSidebar() {
                if (this.state.isMobile) {
                    this.state.isOpen ? this.closeSidebar() : this.openSidebar();
                } else {
                    this.state.isCollapsed ? this.expandSidebar() : this.collapseSidebar();
                }
            },

            // Open sidebar (mobile)
            openSidebar() {
                this.elements.sidebar?.classList.add('open');
                this.elements.sidebarOverlay?.classList.add('active');
                this.elements.toggleIcon?.classList.add('rotated');
                this.state.isOpen = true;

                // Prevent body scroll
                document.body.style.overflow = 'hidden';
            },

            // Close sidebar (mobile)
            closeSidebar() {
                this.elements.sidebar?.classList.remove('open');
                this.elements.sidebarOverlay?.classList.remove('active');
                this.elements.toggleIcon?.classList.remove('rotated');
                this.state.isOpen = false;

                // Restore body scroll
                document.body.style.overflow = '';
            },

            // Collapse sidebar (desktop)
            collapseSidebar() {
                this.elements.sidebar?.classList.add('collapsed');
                this.elements.mainContent?.classList.add('expanded');
                this.elements.toggleIcon?.classList.add('rotated');
                this.state.isCollapsed = true;
                this.saveState();
            },

            // Expand sidebar (desktop)
            expandSidebar() {
                this.elements.sidebar?.classList.remove('collapsed');
                this.elements.mainContent?.classList.remove('expanded');
                this.elements.toggleIcon?.classList.remove('rotated');
                this.state.isCollapsed = false;
                this.saveState();
            },

            // Save state to localStorage
            saveState() {
                try {
                    localStorage.setItem(this.config.storageKey, JSON.stringify({
                        collapsed: this.state.isCollapsed
                    }));
                } catch (e) {
                    console.warn('Could not save sidebar state:', e);
                }
            },

            // Restore state from localStorage
            restoreState() {
                try {
                    const saved = localStorage.getItem(this.config.storageKey);
                    if (saved) {
                        const state = JSON.parse(saved);
                        if (state.collapsed && !this.state.isMobile) {
                            this.collapseSidebar();
                        }
                    }
                } catch (e) {
                    console.warn('Could not restore sidebar state:', e);
                }
            },

            // Update pending notifications badge
            updatePendingBadge() {
                // This would typically fetch from an API
                const badge = document.getElementById('pending-badge');
                if (badge) {
                    // Example: Update every 30 seconds
                    setInterval(() => {
                        // Simulate API call
                        this.fetchPendingCount().then(count => {
                            badge.textContent = count;
                            badge.style.display = count > 0 ? 'block' : 'none';
                        });
                    }, 30000);
                }
            },

            // Simulate fetching pending count
            async fetchPendingCount() {
                try {
                    // Replace with actual API endpoint
                    // const response = await fetch('/api/pending-mentors-count');
                    // const data = await response.json();
                    // return data.count;

                    // Simulate random count for demo
                    return Math.floor(Math.random() * 10);
                } catch (error) {
                    console.error('Error fetching pending count:', error);
                    return 0;
                }
            },

            // Public methods for external use
            api: {
                toggle: () => AdminLayout.toggleSidebar(),
                open: () => AdminLayout.openSidebar(),
                close: () => AdminLayout.closeSidebar(),
                isOpen: () => AdminLayout.state.isOpen,
                isCollapsed: () => AdminLayout.state.isCollapsed
            }
        };

        // Initialize when DOM is loaded
        document.addEventListener('DOMContentLoaded', () => {
            AdminLayout.init();
        });

        // Expose API globally
        window.AdminLayout = AdminLayout.api;

        // Toast notifications setup
        if (typeof toastr !== 'undefined') {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
        }

        // Display session messages
        @if (session('success'))
            if (typeof toastr !== 'undefined') {
                toastr.success("{{ session('success') }}", 'Berhasil! 🎉');
            }
        @endif

        @if (session('error'))
            if (typeof toastr !== 'undefined') {
                toastr.error("{{ session('error') }}", 'Error! ⚠️');
            }
        @endif
    </script>

    @yield('script')
    @stack('scripts')
</body>

</html>
