@extends("layouts.admin")
@section('content')
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-6 py-8 max-w-7xl">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="{{ route('teacher-classes.implementation', $teacherClass) }}" class="hover:text-blue-600 transition-colors duration-200">{{ $teacherClass->name }}</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li class="text-gray-900 font-medium">{{ $class->name }}</li>
            </ol>
        </nav>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-gradient-to-r from-emerald-50 to-emerald-100 border-l-4 border-emerald-500 p-4 mb-6 rounded-r-lg shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-emerald-500 text-lg"></i>
                    </div>
                    <p class="ml-3 text-emerald-700 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Class Header -->
        <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
            <!-- Top Row: Title, Status, and Action Buttons -->
            <div class="flex justify-between items-start mb-4">
                <div class="flex items-center flex-1 min-w-0">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                        <i class="fas fa-chalkboard-teacher text-white text-xl"></i>
                    </div>
                    <div class="flex items-center space-x-3 min-w-0 flex-1">
                        <h1 class="text-2xl font-bold text-gray-900 truncate">{{ $class->name }}</h1>
                        @if(isset($class->is_active))
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold flex-shrink-0 {{ $class->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                <span class="w-2 h-2 mr-2 rounded-full {{ $class->is_active ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                                {{ $class->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="flex items-center space-x-3 flex-shrink-0">
                    <a href="{{ route('teacher-classes.implementation', $teacherClass) }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-semibold rounded-lg transition-colors duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    <a href="{{ route('teacher-classes.mentor-class.edit', [$teacherClass, $class]) }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-colors duration-200">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>

                    @if(isset($class->is_active))
                        <form method="POST" action="{{ route('teacher-classes.mentor-class.toggle-status', [$teacherClass, $class]) }}" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="inline-flex items-center px-4 py-2 {{ $class->is_active ? 'bg-orange-600 hover:bg-orange-700' : 'bg-green-600 hover:bg-green-700' }} text-white text-sm font-semibold rounded-lg transition-colors duration-200">
                                <i class="fas fa-toggle-{{ $class->is_active ? 'off' : 'on' }} mr-2"></i>
                                {{ $class->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>
                    @endif

                    <button onclick="confirmDelete()" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg transition-colors duration-200">
                        <i class="fas fa-trash mr-2"></i>Hapus
                    </button>
                </div>
            </div>

            <!-- Second Row: Mentor Info and Description -->
            <div class="mb-4">
                <div class="flex items-center text-sm text-gray-600 mb-3">
                    <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center mr-2 flex-shrink-0">
                        <i class="fas fa-user text-white text-xs"></i>
                    </div>
                    <span class="truncate">Mentor: <span class="font-medium">{{ $class->mentor->name }}</span></span>
                </div>
                @if($class->description)
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-100">
                        <p class="text-gray-700 text-sm leading-relaxed break-words">{{ $class->description }}</p>
                    </div>
                @endif
            </div>

            <!-- Compact Stats -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 pt-4 border-t border-gray-100">
                <div class="flex items-center space-x-3 p-3 bg-blue-50 rounded-lg">
                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-book text-white text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="text-xl font-bold text-gray-900">{{ $class->materials->count() }}</div>
                        <div class="text-xs text-gray-600">Materi</div>
                    </div>
                </div>
                <div class="flex items-center space-x-3 p-3 bg-emerald-50 rounded-lg">
                    <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-question-circle text-white text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="text-xl font-bold text-gray-900">{{ $class->materials->sum(function($material) { return $material->quizzes->count(); }) }}</div>
                        <div class="text-xs text-gray-600">Pre Test</div>
                    </div>
                </div>
                <div class="flex items-center space-x-3 p-3 bg-purple-50 rounded-lg">
                    <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-clipboard-check text-white text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="text-xl font-bold text-gray-900">{{ $class->postTests ? $class->postTests->count() : 0 }}</div>
                        <div class="text-xs text-gray-600">Post Test</div>
                    </div>
                </div>
                <div class="flex items-center space-x-3 p-3 bg-orange-50 rounded-lg">
                    <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-users text-white text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="text-xl font-bold text-gray-900">0</div>
                        <div class="text-xs text-gray-600">Siswa</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Materials Section -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900">Materi Pembelajaran</h2>
                @if($class->materials->count() > 0)
                    <span class="text-sm text-gray-500">{{ $class->materials->count() }} materi tersedia</span>
                @endif
            </div>

            @if($class->materials->count() > 0)
                <div class="space-y-4">
                    @foreach($class->materials as $index => $material)
                        <div class="border border-gray-200 rounded-lg p-5 hover:shadow-md hover:border-gray-300 transition-all duration-200">
                            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start space-y-4 lg:space-y-0">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-3 mb-3">
                                        <span class="flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-600 rounded-full text-sm font-bold flex-shrink-0">
                                            {{ $index + 1 }}
                                        </span>
                                        <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $material->title }}</h3>
                                        @if(isset($material->is_active))
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold flex-shrink-0 {{ $material->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">
                                                <span class="w-1.5 h-1.5 mr-1 rounded-full {{ $material->is_active ? 'bg-emerald-500' : 'bg-gray-500' }}"></span>
                                                {{ $material->is_active ? 'Aktif' : 'Draft' }}
                                            </span>
                                        @endif
                                    </div>

                                    @if($material->content)
                                        <div class="mb-3">
                                            <p class="text-gray-600 text-sm leading-relaxed break-words max-w-full">{{ Str::limit(strip_tags($material->content), 150) }}</p>
                                        </div>
                                    @endif

                                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                                        @if($material->video_url)
                                            <span class="inline-flex items-center">
                                                <i class="fas fa-video mr-1 text-red-500"></i>Video tersedia
                                            </span>
                                        @endif
                                        <span class="inline-flex items-center">
                                            <i class="fas fa-question-circle mr-1 text-blue-500"></i>{{ $material->quizzes->count() }} Pre Test
                                        </span>
                                        <span class="inline-flex items-center">
                                            <i class="fas fa-calendar mr-1 text-gray-400"></i>{{ $material->created_at->format('d M Y') }}
                                        </span>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-2 lg:ml-4 flex-shrink-0">
                                    <a href="{{ route('teacher-classes.mentor-class.material.show', [$teacherClass, $class, $material]) }}"
                                       class="w-8 h-8 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg flex items-center justify-center transition-all duration-200" title="Lihat Detail">
                                        <i class="fas fa-eye text-sm"></i>
                                    </a>
                                    <a href="{{ route('teacher-classes.mentor-class.material.edit', [$teacherClass, $class, $material]) }}"
                                       class="w-8 h-8 text-green-600 hover:text-green-800 hover:bg-green-50 rounded-lg flex items-center justify-center transition-all duration-200" title="Edit">
                                        <i class="fas fa-edit text-sm"></i>
                                    </a>
                                    <button onclick="confirmDeleteMaterial('{{ $material->title }}', '{{ route('teacher-classes.mentor-class.material.destroy', [$teacherClass, $class, $material]) }}')"
                                            class="w-8 h-8 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg flex items-center justify-center transition-all duration-200" title="Hapus">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Quiz List -->
                            @if($material->quizzes->count() > 0)
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Pre Test Tersedia:</h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($material->quizzes as $quiz)
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium border {{ $quiz->is_active ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-gray-50 text-gray-600 border-gray-200' }}">
                                                <i class="fas fa-{{ $quiz->is_active ? 'check-circle' : 'clock' }} mr-1.5"></i>
                                                {{ $quiz->title ?? 'Pre Test ' . $loop->iteration }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>


            @else
                <div class="text-center py-16">
                    <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-book text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Belum ada materi</h3>
                    <p class="text-gray-500 mb-6 max-w-md mx-auto">Mentor belum membuat materi untuk kelas ini. Mulai dengan menambahkan materi pembelajaran pertama.</p>

                </div>
            @endif
        </div>
    </div>

    <!-- Enhanced Delete Class Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95">
            <div class="p-8">
                <div class="flex items-center mb-6">
                    <div class="flex-shrink-0 w-12 h-12 rounded-2xl bg-red-100 flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-600 text-lg"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-gray-900">Konfirmasi Hapus Kelas</h3>
                        <p class="text-sm text-gray-500 mt-1">Tindakan ini tidak dapat dibatalkan</p>
                    </div>
                </div>

                <div class="mb-8">
                    <p class="text-gray-600 leading-relaxed">
                        Apakah Anda yakin ingin menghapus kelas "<span class="font-semibold text-gray-900">{{ $class->name }}</span>"?
                    </p>
                    <div class="mt-4 p-4 bg-red-50 rounded-xl border border-red-100">
                        <p class="text-sm text-red-700 flex items-start">
                            <i class="fas fa-info-circle mr-2 mt-0.5"></i>
                            <span>Semua materi, Pre Test, dan data terkait akan terhapus secara permanen.</span>
                        </p>
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <button onclick="closeDeleteModal()" class="px-6 py-3 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200">
                        Batal
                    </button>
                    <form method="POST" action="{{ route('teacher-classes.mentor-class.destroy', [$teacherClass, $class]) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-6 py-3 text-sm font-semibold text-white bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                            <i class="fas fa-trash mr-2"></i>
                            Hapus Kelas
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Delete Material Modal -->
    <div id="deleteMaterialModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95">
            <div class="p-8">
                <div class="flex items-center mb-6">
                    <div class="flex-shrink-0 w-12 h-12 rounded-2xl bg-red-100 flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-600 text-lg"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-gray-900">Konfirmasi Hapus Materi</h3>
                        <p class="text-sm text-gray-500 mt-1">Tindakan ini tidak dapat dibatalkan</p>
                    </div>
                </div>

                <div class="mb-8">
                    <p class="text-gray-600 leading-relaxed">
                        Apakah Anda yakin ingin menghapus materi "<span id="materialName" class="font-semibold text-gray-900"></span>"?
                    </p>
                    <div class="mt-4 p-4 bg-red-50 rounded-xl border border-red-100">
                        <p class="text-sm text-red-700 flex items-start">
                            <i class="fas fa-info-circle mr-2 mt-0.5"></i>
                            <span>Semua Pre Test terkait akan ikut terhapus secara permanen.</span>
                        </p>
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <button onclick="closeMaterialDeleteModal()" class="px-6 py-3 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200">
                        Batal
                    </button>
                    <form id="deleteMaterialForm" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-6 py-3 text-sm font-semibold text-white bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                            <i class="fas fa-trash mr-2"></i>
                            Hapus Materi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete() {
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            // Trigger animation
            setTimeout(() => {
                modal.querySelector('.transform').classList.remove('scale-95');
                modal.querySelector('.transform').classList.add('scale-100');
            }, 10);
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.querySelector('.transform').classList.add('scale-95');
            modal.querySelector('.transform').classList.remove('scale-100');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 200);
        }

        function confirmDeleteMaterial(materialName, action) {
            document.getElementById('materialName').textContent = materialName;
            document.getElementById('deleteMaterialForm').action = action;
            const modal = document.getElementById('deleteMaterialModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            // Trigger animation
            setTimeout(() => {
                modal.querySelector('.transform').classList.remove('scale-95');
                modal.querySelector('.transform').classList.add('scale-100');
            }, 10);
        }

        function closeMaterialDeleteModal() {
            const modal = document.getElementById('deleteMaterialModal');
            modal.querySelector('.transform').classList.add('scale-95');
            modal.querySelector('.transform').classList.remove('scale-100');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 200);
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeDeleteModal();
                closeMaterialDeleteModal();
            }
        });
    </script>
@endsection
