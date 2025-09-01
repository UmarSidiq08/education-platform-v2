@extends('layouts.admin')
@section('content')

    <div class="container mx-auto px-4 py-4 md:py-8">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6">
            <div class="mb-4 md:mb-0">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Permintaan Mentor - {{ $teacherClass->name }}</h1>
                <p class="text-gray-600 mt-1 text-sm md:text-base">
                    {{ $teacherClass->subject ? $teacherClass->subject . ' • ' : '' }}
                    Kelola permintaan mentor untuk kelas ini
                </p>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 text-sm md:text-base">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 text-sm md:text-base">
                {{ session('error') }}
            </div>
        @endif

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-4 mb-6 md:mb-8">
            <div class="bg-white rounded-lg shadow-md p-4 md:p-6">
                <div class="flex items-center">
                    <div class="bg-orange-100 p-2 md:p-3 rounded-full">
                        <span class="text-xl md:text-2xl">⏳</span>
                    </div>
                    <div class="ml-3 md:ml-4">
                        <div class="text-xl md:text-2xl font-bold text-orange-600">
                            {{ $requests->where('status', 'pending')->count() }}
                        </div>
                        <div class="text-orange-600 text-xs md:text-sm">Permintaan Pending</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4 md:p-6">
                <div class="flex items-center">
                    <div class="bg-green-100 p-2 md:p-3 rounded-full">
                        <span class="text-xl md:text-2xl">✅</span>
                    </div>
                    <div class="ml-3 md:ml-4">
                        <div class="text-xl md:text-2xl font-bold text-green-600">
                            {{ $requests->where('status', 'approved')->count() }}
                        </div>
                        <div class="text-green-600 text-xs md:text-sm">Mentor Disetujui</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4 md:p-6">
                <div class="flex items-center">
                    <div class="bg-red-100 p-2 md:p-3 rounded-full">
                        <span class="text-xl md:text-2xl">❌</span>
                    </div>
                    <div class="ml-3 md:ml-4">
                        <div class="text-xl md:text-2xl font-bold text-red-600">
                            {{ $requests->where('status', 'rejected')->count() }}
                        </div>
                        <div class="text-red-600 text-xs md:text-sm">Request Ditolak</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter Tabs --}}
        <div class="bg-white rounded-lg shadow-md mb-4 md:mb-6 overflow-x-auto">
            <div class="border-b border-gray-200">
                <nav class="flex space-x-4 md:space-x-8 px-4 md:px-6 min-w-max">
                    <button class="filter-tab py-3 md:py-4 px-1 border-b-2 font-medium text-xs md:text-sm active whitespace-nowrap"
                            data-status="all">
                        Semua Request ({{ $requests->count() }})
                    </button>
                    <button class="filter-tab py-3 md:py-4 px-1 border-b-2 font-medium text-xs md:text-sm whitespace-nowrap"
                            data-status="pending">
                        Pending ({{ $requests->where('status', 'pending')->count() }})
                    </button>
                    <button class="filter-tab py-3 md:py-4 px-1 border-b-2 font-medium text-xs md:text-sm whitespace-nowrap"
                            data-status="approved">
                        Disetujui ({{ $requests->where('status', 'approved')->count() }})
                    </button>
                    <button class="filter-tab py-3 md:py-4 px-1 border-b-2 font-medium text-xs md:text-sm whitespace-nowrap"
                            data-status="rejected">
                        Ditolak ({{ $requests->where('status', 'rejected')->count() }})
                    </button>
                </nav>
            </div>
        </div>

        {{-- Requests List --}}
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-4 md:p-6 border-b border-gray-200">
                <h2 class="text-lg md:text-xl font-semibold text-gray-900">Permintaan Mentor</h2>
            </div>

            @forelse($requests as $request)
                <div class="border-b border-gray-200 last:border-b-0 request-item" data-status="{{ $request->status }}">
                    <div class="p-4 md:p-6">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-start">
                            <div class="flex-1">
                                {{-- Mentor Info --}}
                                <div class="flex items-start mb-3">
                                    <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <span class="text-blue-600 font-bold text-base md:text-lg">
                                            {{ substr($request->mentor->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <div class="ml-3 md:ml-4 flex-1 min-w-0">
                                        <h3 class="text-base md:text-lg font-semibold text-gray-900 truncate">
                                            {{ $request->mentor->name }}
                                        </h3>
                                        <p class="text-xs md:text-sm text-gray-600 truncate">{{ $request->mentor->email }}</p>

                                        {{-- Status Badge --}}
                                        <div class="mt-2 md:mt-0 md:ml-4 md:inline-block">
                                            <span class="px-2 py-1 md:px-3 md:py-1 rounded-full text-xs font-medium
                                                {{ $request->status === 'pending' ? 'bg-orange-100 text-orange-800' :
                                                   ($request->status === 'approved' ? 'bg-green-100 text-green-800' :
                                                    'bg-red-100 text-red-800') }}">
                                                {{ $request->status === 'pending' ? 'Pending' :
                                                   ($request->status === 'approved' ? 'Disetujui' : 'Ditolak') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Request Details --}}
                                <div class="flex flex-col md:flex-row md:items-center text-xs md:text-sm text-gray-500 space-y-1 md:space-y-0 md:space-x-4 mb-3">
                                    <span>📅 {{ $request->requested_at->format('d M Y, H:i') }}</span>
                                    <span class="hidden md:block">•</span>
                                    <span>⏰ {{ $request->requested_at->diffForHumans() }}</span>
                                </div>

                                {{-- Status Details --}}
                                @if($request->status === 'approved' && $request->approved_at)
                                    <div class="bg-green-50 rounded-lg p-3 mb-3 text-xs md:text-sm">
                                        <p class="text-green-800">
                                            ✅ <strong>Disetujui:</strong> {{ $request->approved_at->format('d M Y, H:i') }}
                                            ({{ $request->approved_at->diffForHumans() }})
                                        </p>
                                    </div>
                                @elseif($request->status === 'rejected' && $request->rejected_at)
                                    <div class="bg-red-50 rounded-lg p-3 mb-3 text-xs md:text-sm">
                                        <p class="text-red-800">
                                            ❌ <strong>Ditolak:</strong> {{ $request->rejected_at->format('d M Y, H:i') }}
                                            ({{ $request->rejected_at->diffForHumans() }})
                                        </p>
                                    </div>
                                @endif
                            </div>

                            {{-- Action Buttons --}}
                            @if($request->status === 'pending')
                                <div class="flex space-x-2 mt-4 md:mt-0 md:ml-6 justify-end md:justify-start">
                                    <form action="{{ route('mentor-requests.approve', $request) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                                onclick="return confirm('Yakin ingin menyetujui {{ $request->mentor->name }} sebagai mentor untuk kelas {{ $teacherClass->name }}?')"
                                                class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 md:px-4 md:py-2 rounded-lg text-xs md:text-sm transition-colors">
                                            ✓ Setujui
                                        </button>
                                    </form>

                                    <form action="{{ route('mentor-requests.reject', $request) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                                onclick="return confirm('Yakin ingin menolak permintaan dari {{ $request->mentor->name }}?')"
                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 md:px-4 md:py-2 rounded-lg text-xs md:text-sm transition-colors">
                                            ✗ Tolak
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>

                        {{-- Additional Info for pending requests --}}

                    </div>
                </div>
            @empty
                <div class="p-6 md:p-8 text-center">
                    <div class="text-gray-400 text-4xl md:text-6xl mb-4">📭</div>
                    <h3 class="text-lg md:text-xl font-semibold text-gray-600 mb-2">Belum Ada Permintaan</h3>
                    <p class="text-gray-500 mb-4 text-sm md:text-base">
                        Saat ini tidak ada permintaan mentor untuk kelas "{{ $teacherClass->name }}".
                    </p>
                    <div class="bg-blue-50 rounded-lg p-3 md:p-4 max-w-md mx-auto text-sm md:text-base">
                        <p class="text-blue-800">
                            💡 Permintaan akan muncul ketika calon mentor mendaftar khusus untuk kelas ini.
                        </p>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($requests->hasPages())
            <div class="mt-4 md:mt-6">
                {{ $requests->links() }}
            </div>
        @endif

     
    </div>

    <script>
        // Filter functionality
        document.addEventListener('DOMContentLoaded', function() {
            const filterTabs = document.querySelectorAll('.filter-tab');
            const requestItems = document.querySelectorAll('.request-item');

            filterTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const status = this.getAttribute('data-status');

                    // Update active tab
                    filterTabs.forEach(t => t.classList.remove('active', 'border-blue-500', 'text-blue-600'));
                    filterTabs.forEach(t => t.classList.add('border-transparent', 'text-gray-500'));

                    this.classList.add('active', 'border-blue-500', 'text-blue-600');
                    this.classList.remove('border-transparent', 'text-gray-500');

                    // Filter requests
                    requestItems.forEach(item => {
                        if (status === 'all' || item.getAttribute('data-status') === status) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });

            // Set initial active state
            const activeTab = document.querySelector('.filter-tab.active');
            if (activeTab) {
                activeTab.classList.add('border-blue-500', 'text-blue-600');
                activeTab.classList.remove('border-transparent', 'text-gray-500');
            }
        });

        function approveAll() {
            if (!confirm('Yakin ingin menyetujui SEMUA permintaan mentor pending untuk kelas "{{ $teacherClass->name }}"? Tindakan ini tidak dapat dibatalkan.')) {
                return;
            }

            // You can implement bulk approve here
            alert('Fitur approve semua akan segera tersedia!');
        }
    </script>

    <style>
        .filter-tab {
            @apply border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300;
        }
        .filter-tab.active {
            @apply border-blue-500 text-blue-600;
        }

        /* Mobile-specific adjustments */
        @media (max-width: 768px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }
    </style>
@endsection
