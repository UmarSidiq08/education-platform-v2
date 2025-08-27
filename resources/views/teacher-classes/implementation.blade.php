@extends("layouts.admin")
@section('content')
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-6 py-8 max-w-7xl">
        <!-- Compact Header -->
        <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <div class="flex items-center flex-1">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-chalkboard-teacher text-white"></i>
                    </div>
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold text-gray-900">{{ $teacherClass->name }}</h1>
                        <div class="flex items-center space-x-3 mt-1">
                            <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-semibold bg-blue-50 text-blue-700">
                                <i class="fas fa-book-open mr-1 text-xs"></i>
                                {{ $teacherClass->subject }}
                            </span>
                            @if($teacherClass->description)
                                <p class="text-sm text-gray-600">{{ $teacherClass->description }}</p>
                            @endif
                        </div>
                    </div>
                </div>
             
            </div>

            <!-- Compact Stats -->
            <div class="grid grid-cols-3 gap-4 pt-4 border-t border-gray-100">
                <div class="flex items-center justify-center space-x-3 p-3 bg-emerald-50 rounded-lg">
                    <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-school text-white text-sm"></i>
                    </div>
                    <div>
                        <div class="text-xl font-bold text-gray-900">{{ $teacherClass->implementationClasses->count() }}</div>
                        <div class="text-xs text-gray-600">Total Kelas</div>
                    </div>
                </div>
                <div class="flex items-center justify-center space-x-3 p-3 bg-blue-50 rounded-lg">
                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-book text-white text-sm"></i>
                    </div>
                    <div>
                        <div class="text-xl font-bold text-gray-900">{{ $teacherClass->implementationClasses->sum(function($class) { return $class->materials->count(); }) }}</div>
                        <div class="text-xs text-gray-600">Total Materi</div>
                    </div>
                </div>
                <div class="flex items-center justify-center space-x-3 p-3 bg-purple-50 rounded-lg">
                    <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-question-circle text-white text-sm"></i>
                    </div>
                    <div>
                        <div class="text-xl font-bold text-gray-900">{{ $teacherClass->implementationClasses->sum(function($class) { return $class->materials->sum(function($material) { return $material->quizzes->count(); }); }) }}</div>
                        <div class="text-xs text-gray-600">Total Quiz</div>
                    </div>
                </div>
            </div>
        </div>

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

        <!-- Compact Search Bar -->
        <div class="bg-white rounded-lg shadow-sm border p-4 mb-6">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-base font-semibold text-gray-900">Pencarian Kelas</h2>
                <span class="text-sm text-gray-500" id="searchResults">{{ $teacherClass->implementationClasses->count() }} kelas ditemukan</span>
            </div>
            <div class="flex items-center space-x-3">
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400 text-sm"></i>
                        </div>
                        <input type="text"
                               id="generalSearch"
                               placeholder="Cari berdasarkan nama mentor atau nama kelas..."
                               class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-lg bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-sm">
                    </div>
                </div>
                <button onclick="clearSearch()" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:text-gray-800 bg-gray-100 hover:bg-gray-200 border border-gray-200 rounded-lg transition-all duration-200">
                    <i class="fas fa-times mr-1"></i>Clear
                </button>
            </div>
        </div>

        <!-- Enhanced Classes Grid - 4 columns -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="classesGrid">
            @forelse($teacherClass->implementationClasses as $class)
                <div class="class-card group bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-lg hover:border-gray-300 transition-all duration-300 overflow-hidden"
                     data-mentor-name="{{ strtolower($class->mentor->name) }}"
                     data-class-name="{{ strtolower($class->name) }}">

                    <!-- Card Header -->
                    <div class="p-6 pb-4">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex-1 pr-3">
                                <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition-colors duration-200 line-clamp-2">
                                    {{ $class->name }}
                                </h3>
                                <div class="flex items-center text-sm text-gray-600">
                                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                        <i class="fas fa-user-tie text-white text-xs"></i>
                                    </div>
                                    <span class="mentor-name font-medium truncate">{{ $class->mentor->name }}</span>
                                </div>
                            </div>

                            <!-- Dropdown Menu -->
                            <div class="relative flex-shrink-0">
                                <button class="w-10 h-10 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg flex items-center justify-center transition-all duration-200 opacity-0 group-hover:opacity-100" onclick="toggleDropdown('dropdown-{{ $class->id }}')">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div id="dropdown-{{ $class->id }}" class="hidden absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-xl border border-gray-200 z-20 overflow-hidden">
                                    <div class="py-2">
                                        <a href="{{ route('teacher-classes.mentor-class.show', [$teacherClass, $class]) }}"
                                           class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200">
                                            <i class="fas fa-eye mr-3 w-4 text-blue-500"></i>Lihat Detail
                                        </a>
                                        <a href="{{ route('teacher-classes.mentor-class.edit', [$teacherClass, $class]) }}"
                                           class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-700 transition-colors duration-200">
                                            <i class="fas fa-edit mr-3 w-4 text-orange-500"></i>Edit
                                        </a>
                                        @if(isset($class->is_active))
                                            <form method="POST" action="{{ route('teacher-classes.mentor-class.toggle-status', [$teacherClass, $class]) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="flex items-center w-full px-4 py-3 text-sm text-gray-700 hover:bg-purple-50 hover:text-purple-700 transition-colors duration-200">
                                                    <i class="fas fa-toggle-{{ $class->is_active ? 'off' : 'on' }} mr-3 w-4 text-purple-500"></i>
                                                    {{ $class->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                                </button>
                                            </form>
                                        @endif
                                        <div class="border-t border-gray-100 my-1"></div>
                                        <button onclick="confirmDelete('{{ $class->name }}', '{{ route('teacher-classes.mentor-class.destroy', [$teacherClass, $class]) }}')"
                                                class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                                            <i class="fas fa-trash mr-3 w-4"></i>Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status Badge -->
                        @if(isset($class->is_active))
                            <div class="flex items-center justify-between mb-4">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold {{ $class->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                    <span class="w-2 h-2 mr-2 rounded-full {{ $class->is_active ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                                    {{ $class->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>
                        @endif

                        @if($class->description)
                            <p class="text-sm text-gray-600 mb-4 line-clamp-3">{{ Str::limit($class->description, 100) }}</p>
                        @endif
                    </div>

                    <!-- Enhanced Stats -->
                    <div class="px-6 pb-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gradient-to-br from-teal-50 to-cyan-50 rounded-lg p-4 text-center border border-teal-100 hover:border-teal-200 transition-colors duration-200">
                                <div class="w-10 h-10 bg-teal-500 rounded-lg flex items-center justify-center mx-auto mb-2">
                                    <i class="fas fa-book text-white text-sm"></i>
                                </div>
                                <div class="text-xl font-bold text-teal-700">{{ $class->materials->count() }}</div>
                                <div class="text-xs text-teal-600 font-medium">Materi</div>
                            </div>
                            <div class="bg-gradient-to-br from-purple-50 to-violet-50 rounded-lg p-4 text-center border border-purple-100 hover:border-purple-200 transition-colors duration-200">
                                <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center mx-auto mb-2">
                                    <i class="fas fa-question-circle text-white text-sm"></i>
                                </div>
                                <div class="text-xl font-bold text-purple-700">{{ $class->materials->sum(function($material) { return $material->quizzes->count(); }) }}</div>
                                <div class="text-xs text-purple-600 font-medium">Quiz</div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Footer -->
                    <div class="p-6 pt-0">
                        <a href="{{ route('teacher-classes.mentor-class.show', [$teacherClass, $class]) }}"
                           class="inline-flex items-center justify-center w-full px-4 py-3 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 rounded-lg shadow-sm hover:shadow-md transition-all duration-200 transform hover:-translate-y-0.5">
                            <i class="fas fa-cog mr-2"></i>
                            Kelola Kelas
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="bg-white rounded-xl border-2 border-dashed border-gray-200 p-16 text-center">
                        <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center">
                            <i class="fas fa-book-open text-3xl text-gray-400"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Belum ada kelas implementasi</h3>
                        <p class="text-gray-500 mb-6">Mentor belum membuat kelas untuk TeacherClass ini.</p>
                        <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full mx-auto"></div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- No Results Message -->
        <div id="noResults" class="hidden">
            <div class="bg-white rounded-xl border p-16 text-center">
                <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-search text-3xl text-gray-400"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Tidak ada hasil</h3>
                <p class="text-gray-500">Tidak ditemukan kelas dengan nama mentor atau nama kelas yang dicari.</p>
            </div>
        </div>
    </div>

    <!-- Enhanced Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95">
            <div class="p-8">
                <div class="flex items-center mb-6">
                    <div class="flex-shrink-0 w-12 h-12 rounded-2xl bg-red-100 flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-red-600 text-lg"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-gray-900">Konfirmasi Hapus</h3>
                        <p class="text-sm text-gray-500 mt-1">Tindakan ini tidak dapat dibatalkan</p>
                    </div>
                </div>

                <div class="mb-8">
                    <p class="text-gray-600 leading-relaxed">
                        Apakah Anda yakin ingin menghapus kelas "<span id="className" class="font-semibold text-gray-900"></span>"?
                    </p>
                    <div class="mt-4 p-4 bg-red-50 rounded-xl border border-red-100">
                        <p class="text-sm text-red-700 flex items-start">
                            <i class="fas fa-info-circle mr-2 mt-0.5"></i>
                            <span>Semua materi dan quiz akan ikut terhapus secara permanen.</span>
                        </p>
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <button onclick="closeDeleteModal()"
                            class="px-6 py-3 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200">
                        Batal
                    </button>
                    <form id="deleteForm" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-6 py-3 text-sm font-semibold text-white bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
                            <i class="fas fa-trash mr-2"></i>
                            Hapus Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Enhanced search functionality with results counter
        document.getElementById('generalSearch').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase().trim();
            const cards = document.querySelectorAll('.class-card');
            const noResults = document.getElementById('noResults');
            const searchResults = document.getElementById('searchResults');
            let visibleCount = 0;

            cards.forEach(card => {
                const mentorName = card.getAttribute('data-mentor-name');
                const className = card.getAttribute('data-class-name');

                if (mentorName.includes(searchTerm) || className.includes(searchTerm)) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Update results counter
            searchResults.textContent = `${visibleCount} kelas ditemukan`;

            if (visibleCount === 0 && searchTerm !== '') {
                noResults.style.display = 'block';
                document.getElementById('classesGrid').style.display = 'none';
            } else {
                noResults.style.display = 'none';
                document.getElementById('classesGrid').style.display = 'grid';
            }
        });

        function clearSearch() {
            const searchInput = document.getElementById('generalSearch');
            const cards = document.querySelectorAll('.class-card');
            const searchResults = document.getElementById('searchResults');

            searchInput.value = '';
            cards.forEach(card => {
                card.style.display = 'block';
            });

            document.getElementById('noResults').style.display = 'none';
            document.getElementById('classesGrid').style.display = 'grid';
            searchResults.textContent = `${cards.length} kelas ditemukan`;

            searchInput.focus();
        }

        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            // Close all other dropdowns
            document.querySelectorAll('[id^="dropdown-"]').forEach(el => {
                if (el.id !== id) {
                    el.classList.add('hidden');
                }
            });
            // Toggle current dropdown
            dropdown.classList.toggle('hidden');
        }

        function confirmDelete(className, action) {
            document.getElementById('className').textContent = className;
            document.getElementById('deleteForm').action = action;
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

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.relative')) {
                document.querySelectorAll('[id^="dropdown-"]').forEach(el => {
                    el.classList.add('hidden');
                });
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeDeleteModal();
            }
        });
    </script>
@endsection
