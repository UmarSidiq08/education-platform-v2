@extends('layouts.app')

@section('title', 'Kelas ' . $mentor->name . ' - ' . $teacherClass->name)

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="{{ route('public.teacher-classes.index') }}" class="hover:text-blue-600">Mata Pelajaran</a></li>
                <li><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"></path>
                    </svg></li>
                <li><a href="{{ route('public.teacher-classes.show', $teacherClass) }}"
                        class="hover:text-blue-600">{{ Str::limit($teacherClass->name, 30) }}</a></li>
                <li><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"></path>
                    </svg></li>
                <li class="text-gray-900 font-medium">Kelas {{ $mentor->name }}</li>
            </ol>
        </nav>

        <!-- Header Section -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 px-6 py-8 text-white">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <div class="flex items-center mb-4">
                            <div
                                class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                                <span class="text-white font-bold text-2xl">
                                    {{ strtoupper(substr($mentor->name, 0, 1)) }}
                                </span>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold mb-1">{{ $mentor->name }}</h1>
                                <p class="text-blue-100">Mentor {{ $teacherClass->name }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 md:mt-0 text-right">
                        <div class="text-2xl font-bold">{{ $mentorClasses->total() }}</div>
                        <div class="text-blue-100">Total Kelas</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full mr-4">
                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $mentorClasses->total() }}</p>
                        <p class="text-gray-600">Total Kelas</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-full mr-4">
                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $mentorClasses->where('is_active', true)->count() }}
                        </p>
                        <p class="text-gray-600">Kelas Aktif</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-full mr-4">
                        <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $mentorClasses->sum('materials_count') }}</p>
                        <p class="text-gray-600">Total Materi</p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="p-3 bg-orange-100 rounded-full mr-4">
                        <svg class="w-6 h-6 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">
                            @if ($mentorClasses->count() > 0)
                                {{ $mentorClasses->first()->created_at->format('M Y') }}
                            @else
                                -
                            @endif
                        </p>
                        <p class="text-gray-600">Sejak</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Classes Grid -->
        @if ($mentorClasses->count() > 0)
            <div class="mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Daftar Kelas</h2>
                    <div class="flex items-center space-x-4">
                        <!-- Filter Status -->

                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="classes-grid">
                    @foreach ($mentorClasses as $class)
                        <div class="class-card bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden"
                            data-status="{{ $class->is_active ? 'active' : 'inactive' }}">
                            <!-- Header -->
                            <div class="p-6 border-b border-gray-200">
                                <div class="flex items-start justify-between mb-3">
                                    <h3 class="font-bold text-lg text-gray-900 line-clamp-2" title="{{ $class->name }}">
                                        {{ $class->name }}
                                    </h3>

                                </div>

                                @if ($class->description)
                                    <p class="text-gray-600 text-sm line-clamp-3 mb-4">
                                        {{ $class->description }}
                                    </p>
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="p-6">
                                <!-- Stats -->
                                <div class="grid grid-cols-2 gap-4 mb-6">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-blue-600">{{ $class->materials_count }}</div>
                                        <div class="text-xs text-gray-500">Materi</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-green-600">
                                            {{ $class->created_at->format('d') }}
                                        </div>
                                        <div class="text-xs text-gray-500">{{ $class->created_at->format('M Y') }}</div>
                                    </div>
                                </div>

                                <!-- Materials Preview -->
                                @if ($class->materials->count() > 0)
                                    <div class="mb-4">
                                        <h4 class="text-sm font-medium text-gray-700 mb-2">Materi Terbaru:</h4>
                                        <div class="space-y-2">
                                            @foreach ($class->materials->take(2) as $material)
                                                <div class="flex items-center text-sm text-gray-600">
                                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor"
                                                        viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="truncate">{{ $material->title }}</span>
                                                </div>
                                            @endforeach
                                            @if ($class->materials->count() > 2)
                                                <div class="text-xs text-gray-500">
                                                    +{{ $class->materials->count() - 2 }} materi lainnya
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <!-- Action Button -->
                                <a href="{{ route('classes.show', $class->id) }}"
                                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 text-center inline-block">
                                    Lihat Kelas
                                </a>
                            </div>

                            <!-- Footer -->
                            <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
                                <div class="flex justify-between items-center text-xs text-gray-500">
                                    <span>Dibuat {{ $class->created_at->format('d M Y') }}</span>
                                    <span>ID: {{ $class->id }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $mentorClasses->links() }}
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 48 48">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Kelas</h3>
                <p class="text-gray-600 mb-6">{{ $mentor->name }} belum membuat kelas untuk mata pelajaran ini.</p>
                <a href="{{ route('public.teacher-classes.show', $teacherClass) }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                    Kembali ke Mata Pelajaran
                </a>
            </div>
        @endif
    </div>

    <!-- Modal Detail Kelas -->
    <div id="classDetailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Detail Kelas</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Kelas</label>
                        <p id="modalClassName" class="mt-1 text-sm text-gray-900"></p>
                    </div>



                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jumlah Materi</label>
                        <p id="modalClassMaterials" class="mt-1 text-sm text-gray-900"></p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <p id="modalClassDescription" class="mt-1 text-sm text-gray-900"></p>
                    </div>
                </div>

                <div class="mt-6">
                    <button onclick="closeModal()"
                        class="w-full px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Filter functionality
            document.getElementById('statusFilter').addEventListener('change', function() {
                const filterValue = this.value;
                const cards = document.querySelectorAll('.class-card');

                cards.forEach(card => {
                    if (filterValue === 'all') {
                        card.style.display = 'block';
                    } else {
                        const cardStatus = card.dataset.status;
                        card.style.display = cardStatus === filterValue ? 'block' : 'none';
                    }
                });
            });

            // Modal functions
            function viewClassDetail(name, materialsCount, status, description) {
                document.getElementById('modalClassName').textContent = name;
                document.getElementById('modalClassMaterials').textContent = materialsCount + ' materi';
                document.getElementById('modalClassDescription').textContent = description || 'Tidak ada deskripsi';
                document.getElementById('classDetailModal').classList.remove('hidden');
            }

            function closeModal() {
                document.getElementById('classDetailModal').classList.add('hidden');
            }

            // Close modal when clicking outside
            document.getElementById('classDetailModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal();
                }
            });
        </script>
    @endpush
@endsection
