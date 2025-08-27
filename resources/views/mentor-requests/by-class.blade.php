@extends('layouts.admin')
@section('content')

    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Permintaan Mentor - {{ $teacherClass->name }}</h1>
                <p class="text-gray-600 mt-1">
                    {{ $teacherClass->subject ? $teacherClass->subject . ' • ' : '' }}
                    Kelola permintaan mentor untuk kelas ini
                </p>
            </div>

        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="bg-orange-100 p-3 rounded-full">
                        <span class="text-2xl">⏳</span>
                    </div>
                    <div class="ml-4">
                        <div class="text-2xl font-bold text-orange-600">
                            {{ $requests->where('status', 'pending')->count() }}
                        </div>
                        <div class="text-orange-600 text-sm">Permintaan Pending</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded-full">
                        <span class="text-2xl">✅</span>
                    </div>
                    <div class="ml-4">
                        <div class="text-2xl font-bold text-green-600">
                            {{ $requests->where('status', 'approved')->count() }}
                        </div>
                        <div class="text-green-600 text-sm">Mentor Disetujui</div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="bg-red-100 p-3 rounded-full">
                        <span class="text-2xl">❌</span>
                    </div>
                    <div class="ml-4">
                        <div class="text-2xl font-bold text-red-600">
                            {{ $requests->where('status', 'rejected')->count() }}
                        </div>
                        <div class="text-red-600 text-sm">Request Ditolak</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter Tabs --}}
        <div class="bg-white rounded-lg shadow-md mb-6">
            <div class="border-b border-gray-200">
                <nav class="flex space-x-8 px-6">
                    <button class="filter-tab py-4 px-1 border-b-2 font-medium text-sm active"
                            data-status="all">
                        Semua Request ({{ $requests->count() }})
                    </button>
                    <button class="filter-tab py-4 px-1 border-b-2 font-medium text-sm"
                            data-status="pending">
                        Pending ({{ $requests->where('status', 'pending')->count() }})
                    </button>
                    <button class="filter-tab py-4 px-1 border-b-2 font-medium text-sm"
                            data-status="approved">
                        Disetujui ({{ $requests->where('status', 'approved')->count() }})
                    </button>
                    <button class="filter-tab py-4 px-1 border-b-2 font-medium text-sm"
                            data-status="rejected">
                        Ditolak ({{ $requests->where('status', 'rejected')->count() }})
                    </button>
                </nav>
            </div>
        </div>

        {{-- Requests List --}}
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Permintaan Mentor</h2>
            </div>

            @forelse($requests as $request)
                <div class="border-b border-gray-200 last:border-b-0 request-item" data-status="{{ $request->status }}">
                    <div class="p-6">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                {{-- Mentor Info --}}
                                <div class="flex items-center mb-3">
                                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                        <span class="text-blue-600 font-bold text-lg">
                                            {{ substr($request->mentor->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            {{ $request->mentor->name }}
                                        </h3>
                                        <p class="text-sm text-gray-600">{{ $request->mentor->email }}</p>
                                    </div>

                                    {{-- Status Badge --}}
                                    <div class="ml-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-medium
                                            {{ $request->status === 'pending' ? 'bg-orange-100 text-orange-800' :
                                               ($request->status === 'approved' ? 'bg-green-100 text-green-800' :
                                                'bg-red-100 text-red-800') }}">
                                            {{ $request->status === 'pending' ? 'Pending' :
                                               ($request->status === 'approved' ? 'Disetujui' : 'Ditolak') }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Request Details --}}
                                <div class="flex items-center text-sm text-gray-500 space-x-4 mb-3">
                                    <span>📅 Diajukan: {{ $request->requested_at->format('d M Y, H:i') }}</span>
                                    <span>⏰ {{ $request->requested_at->diffForHumans() }}</span>
                                </div>

                                {{-- Status Details --}}
                                @if($request->status === 'approved' && $request->approved_at)
                                    <div class="bg-green-50 rounded-lg p-3 mb-3">
                                        <p class="text-sm text-green-800">
                                            ✅ <strong>Disetujui:</strong> {{ $request->approved_at->format('d M Y, H:i') }}
                                            ({{ $request->approved_at->diffForHumans() }})
                                        </p>
                                    </div>
                                @elseif($request->status === 'rejected' && $request->rejected_at)
                                    <div class="bg-red-50 rounded-lg p-3 mb-3">
                                        <p class="text-sm text-red-800">
                                            ❌ <strong>Ditolak:</strong> {{ $request->rejected_at->format('d M Y, H:i') }}
                                            ({{ $request->rejected_at->diffForHumans() }})
                                        </p>
                                    </div>
                                @endif
                            </div>

                            {{-- Action Buttons --}}
                            @if($request->status === 'pending')
                                <div class="flex space-x-2 ml-6">
                                    <form action="{{ route('mentor-requests.approve', $request) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                                onclick="return confirm('Yakin ingin menyetujui {{ $request->mentor->name }} sebagai mentor untuk kelas {{ $teacherClass->name }}?')"
                                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                            ✓ Setujui
                                        </button>
                                    </form>

                                    <form action="{{ route('mentor-requests.reject', $request) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                                onclick="return confirm('Yakin ingin menolak permintaan dari {{ $request->mentor->name }}?')"
                                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                            ✗ Tolak
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>

                        {{-- Additional Info for pending requests --}}
                        @if($request->status === 'pending')
                            <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                                <p class="text-sm text-blue-800">
                                    💡 <strong>Tips:</strong> Setelah Anda menyetujui, {{ $request->mentor->name }}
                                    akan dapat membuat dan mengelola kelas implementasi dari template "{{ $teacherClass->name }}" Anda.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="p-8 text-center">
                    <div class="text-gray-400 text-6xl mb-4">📭</div>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">Belum Ada Permintaan</h3>
                    <p class="text-gray-500 mb-4">
                        Saat ini tidak ada permintaan mentor untuk kelas "{{ $teacherClass->name }}".
                    </p>
                    <div class="bg-blue-50 rounded-lg p-4 max-w-md mx-auto">
                        <p class="text-sm text-blue-800">
                            💡 Permintaan akan muncul ketika calon mentor mendaftar khusus untuk kelas ini.
                        </p>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($requests->hasPages())
            <div class="mt-6">
                {{ $requests->links() }}
            </div>
        @endif

        {{-- Quick Actions untuk pending requests --}}
        @if($requests->where('status', 'pending')->count() > 0)
            <div class="mt-6 bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Tindakan Cepat</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="border border-green-200 rounded-lg p-4">
                        <h4 class="font-medium text-green-800 mb-2">Setujui Semua Permintaan Pending</h4>
                        <p class="text-sm text-green-600 mb-3">
                            Setujui semua {{ $requests->where('status', 'pending')->count() }} permintaan mentor sekaligus untuk kelas ini.
                        </p>
                        <button onclick="approveAll()"
                                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm">
                            Setujui Semua
                        </button>
                    </div>

                    <div class="border border-blue-200 rounded-lg p-4">
                        <h4 class="font-medium text-blue-800 mb-2">Lihat Kelas Implementasi</h4>
                        <p class="text-sm text-blue-600 mb-3">
                            Lihat kelas implementasi yang sudah dibuat mentor dari template ini.
                        </p>
                        <a href="{{ route('teacher-classes.implementation', $teacherClass) }}"
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm inline-block">
                            Lihat Implementasi
                        </a>
                    </div>
                </div>
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
            activeTab.classList.add('border-blue-500', 'text-blue-600');
            activeTab.classList.remove('border-transparent', 'text-gray-500');
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
    </style>
@endsection
