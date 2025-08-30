@extends("layouts.admin")
@section('content')
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 sm:px-6 py-4 sm:py-8 max-w-7xl">
        <!-- Breadcrumb -->
        <nav class="mb-4 sm:mb-6">
            <ol class="flex items-center flex-wrap space-x-1 sm:space-x-2 text-xs sm:text-sm text-gray-500">
                <li><a href="{{ route('teacher-classes.implementation', $teacherClass) }}" class="hover:text-blue-600 transition-colors duration-200 truncate max-w-[120px] sm:max-w-none">{{ $teacherClass->name }}</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li class="text-gray-900 font-medium truncate max-w-[120px] sm:max-w-none">{{ $class->name }}</li>
            </ol>
        </nav>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-gradient-to-r from-emerald-50 to-emerald-100 border-l-4 border-emerald-500 p-3 sm:p-4 mb-4 sm:mb-6 rounded-r-lg shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-emerald-500 text-base sm:text-lg"></i>
                    </div>
                    <p class="ml-2 sm:ml-3 text-emerald-700 font-medium text-sm sm:text-base">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Class Header -->
        <div class="bg-white rounded-lg shadow-sm border p-4 sm:p-6 mb-4 sm:mb-6">
            <!-- Top Row: Title, Status, and Action Buttons -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-4 gap-3">
                <div class="flex items-center flex-1 min-w-0">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mr-3 sm:mr-4 flex-shrink-0">
                        <i class="fas fa-chalkboard-teacher text-white text-lg sm:text-xl"></i>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-3 min-w-0 flex-1">
                        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 truncate">{{ $class->name }}</h1>
                        @if(isset($class->is_active))
                            <span class="inline-flex items-center px-2 py-1 sm:px-3 sm:py-1.5 rounded-full text-xs font-semibold flex-shrink-0 mt-1 sm:mt-0 {{ $class->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 mr-1 sm:mr-2 rounded-full {{ $class->is_active ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                                {{ $class->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="flex flex-wrap gap-2 sm:gap-3 items-center flex-shrink-0">
                    <a href="{{ route('teacher-classes.implementation', $teacherClass) }}"
                       class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 bg-gray-600 hover:bg-gray-700 text-white text-xs sm:text-sm font-semibold rounded-lg transition-colors duration-200">
                        <i class="fas fa-arrow-left mr-1 sm:mr-2 text-xs"></i>Kembali
                    </a>
                    <a href="{{ route('teacher-classes.mentor-class.edit', [$teacherClass, $class]) }}"
                       class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-semibold rounded-lg transition-colors duration-200">
                        <i class="fas fa-edit mr-1 sm:mr-2 text-xs"></i>Edit
                    </a>

                    @if(isset($class->is_active))
                        <form method="POST" action="{{ route('teacher-classes.mentor-class.toggle-status', [$teacherClass, $class]) }}" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 {{ $class->is_active ? 'bg-orange-600 hover:bg-orange-700' : 'bg-green-600 hover:bg-green-700' }} text-white text-xs sm:text-sm font-semibold rounded-lg transition-colors duration-200">
                                <i class="fas fa-toggle-{{ $class->is_active ? 'off' : 'on' }} mr-1 sm:mr-2 text-xs"></i>
                                {{ $class->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>
                    @endif

                    <button onclick="confirmDelete()" class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 bg-red-600 hover:bg-red-700 text-white text-xs sm:text-sm font-semibold rounded-lg transition-colors duration-200">
                        <i class="fas fa-trash mr-1 sm:mr-2 text-xs"></i>Hapus
                    </button>
                </div>
            </div>

            <!-- Second Row: Mentor Info and Description -->
            <div class="mb-4">
                <div class="flex items-center text-xs sm:text-sm text-gray-600 mb-3">
                    <div class="w-5 h-5 sm:w-6 sm:h-6 bg-blue-500 rounded-full flex items-center justify-center mr-2 flex-shrink-0">
                        <i class="fas fa-user text-white text-xs"></i>
                    </div>
                    <span class="truncate">Mentor: <span class="font-medium">{{ $class->mentor->name }}</span></span>
                </div>
                @if($class->description)
                    <div class="bg-gray-50 rounded-lg p-3 sm:p-4 border border-gray-100">
                        <p class="text-gray-700 text-xs sm:text-sm leading-relaxed break-words">{{ $class->description }}</p>
                    </div>
                @endif
            </div>

            <!-- Compact Stats -->
            <div class="grid grid-cols-2 gap-2 sm:gap-4 pt-4 border-t border-gray-100">
                <div class="flex items-center space-x-2 sm:space-x-3 p-2 sm:p-3 bg-blue-50 rounded-lg">
                    <div class="w-6 h-6 sm:w-8 sm:h-8 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-book text-white text-xs sm:text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="text-lg sm:text-xl font-bold text-gray-900">{{ $class->materials->count() }}</div>
                        <div class="text-xs text-gray-600">Materi</div>
                    </div>
                </div>
                <div class="flex items-center space-x-2 sm:space-x-3 p-2 sm:p-3 bg-emerald-50 rounded-lg">
                    <div class="w-6 h-6 sm:w-8 sm:h-8 bg-emerald-500 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-question-circle text-white text-xs sm:text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="text-lg sm:text-xl font-bold text-gray-900">{{ $class->materials->sum(function($material) { return $material->quizzes->count(); }) }}</div>
                        <div class="text-xs text-gray-600">Pre Test</div>
                    </div>
                </div>
                <div class="flex items-center space-x-2 sm:space-x-3 p-2 sm:p-3 bg-purple-50 rounded-lg">
                    <div class="w-6 h-6 sm:w-8 sm:h-8 bg-purple-500 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-clipboard-check text-white text-xs sm:text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="text-lg sm:text-xl font-bold text-gray-900">{{ $class->postTests ? $class->postTests->count() : 0 }}</div>
                        <div class="text-xs text-gray-600">Post Test</div>
                    </div>
                </div>
                <div class="flex items-center space-x-2 sm:space-x-3 p-2 sm:p-3 bg-orange-50 rounded-lg">
                    <div class="w-6 h-6 sm:w-8 sm:h-8 bg-orange-500 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-users text-white text-xs sm:text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="text-lg sm:text-xl font-bold text-gray-900">0</div>
                        <div class="text-xs text-gray-600">Siswa</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Materials Section -->
        <div class="bg-white rounded-lg shadow-sm border p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 sm:mb-6 gap-2">
                <h2 class="text-lg sm:text-xl font-bold text-gray-900">Materi Pembelajaran</h2>
                @if($class->materials->count() > 0)
                    <span class="text-xs sm:text-sm text-gray-500">{{ $class->materials->count() }} materi tersedia</span>
                @endif
            </div>

            @if($class->materials->count() > 0)
                <div class="space-y-3 sm:space-y-4">
                    @foreach($class->materials as $index => $material)
                        <div class="border border-gray-200 rounded-lg p-4 sm:p-5 hover:shadow-md hover:border-gray-300 transition-all duration-200">
                            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start space-y-4 lg:space-y-0">
                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-3 mb-3 gap-2">
                                        <div class="flex items-center">
                                            <span class="flex items-center justify-center w-6 h-6 sm:w-8 sm:h-8 bg-blue-100 text-blue-600 rounded-full text-xs sm:text-sm font-bold flex-shrink-0">
                                                {{ $index + 1 }}
                                            </span>
                                            <h3 class="text-base sm:text-lg font-semibold text-gray-900 truncate ml-2 sm:ml-3">{{ $material->title }}</h3>
                                        </div>
                                        @if(isset($material->is_active))
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold flex-shrink-0 {{ $material->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600' }} self-start sm:self-auto">
                                                <span class="w-1.5 h-1.5 mr-1 rounded-full {{ $material->is_active ? 'bg-emerald-500' : 'bg-gray-500' }}"></span>
                                                {{ $material->is_active ? 'Aktif' : 'Draft' }}
                                            </span>
                                        @endif
                                    </div>

                                    @if($material->content)
                                        <div class="mb-3">
                                            <p class="text-gray-600 text-xs sm:text-sm leading-relaxed break-words max-w-full">{{ Str::limit(strip_tags($material->content), 150) }}</p>
                                        </div>
                                    @endif

                                    <div class="flex flex-col sm:flex-row sm:flex-wrap sm:items-center gap-2 sm:gap-4 text-xs sm:text-sm text-gray-500">
                                        @if($material->video_url)
                                            <span class="inline-flex items-center">
                                                <i class="fas fa-video mr-1 text-red-500 text-xs"></i>Video tersedia
                                            </span>
                                        @endif
                                        <span class="inline-flex items-center">
                                            <i class="fas fa-question-circle mr-1 text-blue-500 text-xs"></i>{{ $material->quizzes->count() }} Pre Test
                                        </span>
                                        <span class="inline-flex items-center">
                                            <i class="fas fa-calendar mr-1 text-gray-400 text-xs"></i>{{ $material->created_at->format('d M Y') }}
                                        </span>
                                    </div>
                                </div>

                                <div class="flex items-center justify-end sm:justify-start space-x-2 lg:ml-4 flex-shrink-0 pt-2 sm:pt-0 border-t border-gray-100 sm:border-none">
                                    <a href="{{ route('teacher-classes.mentor-class.material.show', [$teacherClass, $class, $material]) }}"
                                       class="w-7 h-7 sm:w-8 sm:h-8 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg flex items-center justify-center transition-all duration-200" title="Lihat Detail">
                                        <i class="fas fa-eye text-xs sm:text-sm"></i>
                                    </a>
                                    <a href="{{ route('teacher-classes.mentor-class.material.edit', [$teacherClass, $class, $material]) }}"
                                       class="w-7 h-7 sm:w-8 sm:h-8 text-green-600 hover:text-green-800 hover:bg-green-50 rounded-lg flex items-center justify-center transition-all duration-200" title="Edit">
                                        <i class="fas fa-edit text-xs sm:text-sm"></i>
                                    </a>
                                    <button onclick="confirmDeleteMaterial('{{ $material->title }}', '{{ route('teacher-classes.mentor-class.material.destroy', [$teacherClass, $class, $material]) }}')"
                                            class="w-7 h-7 sm:w-8 sm:h-8 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg flex items-center justify-center transition-all duration-200" title="Hapus">
                                        <i class="fas fa-trash text-xs sm:text-sm"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Quiz List -->
                            @if($material->quizzes->count() > 0)
                                <div class="mt-3 sm:mt-4 pt-3 sm:pt-4 border-t border-gray-100">
                                    <h4 class="text-xs sm:text-sm font-semibold text-gray-700 mb-2 sm:mb-3">Pre Test Tersedia:</h4>
                                    <div class="flex flex-wrap gap-1 sm:gap-2">
                                        @foreach($material->quizzes as $quiz)
                                            <span class="inline-flex items-center px-2 py-1 sm:px-3 sm:py-1.5 rounded-lg text-xs font-medium border {{ $quiz->is_active ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-gray-50 text-gray-600 border-gray-200' }}">
                                                <i class="fas fa-{{ $quiz->is_active ? 'check-circle' : 'clock' }} mr-1 text-xs"></i>
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
                <div class="text-center py-10 sm:py-16">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 mx-auto mb-4 sm:mb-6 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-book text-xl sm:text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2 sm:mb-3">Belum ada materi</h3>
                    <p class="text-gray-500 mb-4 sm:mb-6 max-w-md mx-auto text-xs sm:text-sm">Mentor belum membuat materi untuk kelas ini. Mulai dengan menambahkan materi pembelajaran pertama.</p>

                </div>
            @endif
        </div>
    </div>

    <!-- Enhanced Delete Class Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-xl sm:shadow-2xl max-w-md w-full mx-2 sm:mx-4 transform transition-all duration-300 scale-95">
            <div class="p-6 sm:p-8">
                <div class="flex items-center mb-4 sm:mb-6">
                    <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-red-100 flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-600 text-base sm:text-lg"></i>
                    </div>
                    <div class="ml-3 sm:ml-4">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900">Konfirmasi Hapus Kelas</h3>
                        <p class="text-xs sm:text-sm text-gray-500 mt-1">Tindakan ini tidak dapat dibatalkan</p>
                    </div>
                </div>

                <div class="mb-6 sm:mb-8">
                    <p class="text-gray-600 leading-relaxed text-sm sm:text-base">
                        Apakah Anda yakin ingin menghapus kelas "<span class="font-semibold text-gray-900">{{ $class->name }}</span>"?
                    </p>
                    <div class="mt-3 sm:mt-4 p-3 sm:p-4 bg-red-50 rounded-lg sm:rounded-xl border border-red-100">
                        <p class="text-xs sm:text-sm text-red-700 flex items-start">
                            <i class="fas fa-info-circle mr-2 mt-0.5 text-xs"></i>
                            <span>Semua materi, Pre Test, dan data terkait akan terhapus secara permanen.</span>
                        </p>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 sm:space-x-4">
                    <button onclick="closeDeleteModal()" class="px-4 py-2 sm:px-6 sm:py-3 text-xs sm:text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg sm:rounded-xl transition-colors duration-200">
                        Batal
                    </button>
                    <form method="POST" action="{{ route('teacher-classes.mentor-class.destroy', [$teacherClass, $class]) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 sm:px-6 sm:py-3 text-xs sm:text-sm font-semibold text-white bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 rounded-lg sm:rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                            <i class="fas fa-trash mr-1 sm:mr-2"></i>
                            Hapus Kelas
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Delete Material Modal -->
    <div id="deleteMaterialModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl sm:rounded-2xl shadow-xl sm:shadow-2xl max-w-md w-full mx-2 sm:mx-4 transform transition-all duration-300 scale-95">
            <div class="p-6 sm:p-8">
                <div class="flex items-center mb-4 sm:mb-6">
                    <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-red-100 flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-600 text-base sm:text-lg"></i>
                    </div>
                    <div class="ml-3 sm:ml-4">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900">Konfirmasi Hapus Materi</h3>
                        <p class="text-xs sm:text-sm text-gray-500 mt-1">Tindakan ini tidak dapat dibatalkan</p>
                    </div>
                </div>

                <div class="mb-6 sm:mb-8">
                    <p class="text-gray-600 leading-relaxed text-sm sm:text-base">
                        Apakah Anda yakin ingin menghapus materi "<span id="materialName" class="font-semibold text-gray-900"></span>"?
                    </p>
                    <div class="mt-3 sm:mt-4 p-3 sm:p-4 bg-red-50 rounded-lg sm:rounded-xl border border-red-100">
                        <p class="text-xs sm:text-sm text-red-700 flex items-start">
                            <i class="fas fa-info-circle mr-2 mt-0.5 text-xs"></i>
                            <span>Semua Pre Test terkait akan ikut terhapus secara permanen.</span>
                        </p>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 sm:space-x-4">
                    <button onclick="closeMaterialDeleteModal()" class="px-4 py-2 sm:px-6 sm:py-3 text-xs sm:text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg sm:rounded-xl transition-colors duration-200">
                        Batal
                    </button>
                    <form id="deleteMaterialForm" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 sm:px-6 sm:py-3 text-xs sm:text-sm font-semibold text-white bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 rounded-lg sm:rounded-xl shadow-md hover:shadow-lg transition-all duration-200">
                            <i class="fas fa-trash mr-1 sm:mr-2"></i>
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
