@extends("layouts.admin")
@section('content')
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-6 py-8 max-w-7xl">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="{{ route('teacher-classes.implementation', $teacherClass) }}" class="hover:text-blue-600 transition-colors duration-200">{{ $teacherClass->name }}</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li><a href="{{ route('teacher-classes.mentor-class.show', [$teacherClass, $class]) }}" class="hover:text-blue-600 transition-colors duration-200">{{ $class->name }}</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li class="text-gray-900 font-medium">{{ $material->title }}</li>
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

        <!-- Material Header -->
        <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
            <!-- Top Row: Title, Status, and Action Buttons -->
            <div class="flex justify-between items-start mb-4">
                <div class="flex items-center flex-1 min-w-0">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                        <i class="fas fa-book-open text-white text-xl"></i>
                    </div>
                    <div class="flex items-center space-x-3 min-w-0 flex-1">
                        <h1 class="text-2xl font-bold text-gray-900 truncate">{{ $material->title }}</h1>
                        @if(isset($material->is_active))
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold flex-shrink-0 {{ $material->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">
                                <span class="w-2 h-2 mr-2 rounded-full {{ $material->is_active ? 'bg-emerald-500' : 'bg-gray-500' }}"></span>
                                {{ $material->is_active ? 'Aktif' : 'Draft' }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="flex items-center space-x-3 flex-shrink-0">
                    <a href="{{ route('teacher-classes.mentor-class.show', [$teacherClass, $class]) }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-semibold rounded-lg transition-colors duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    <a href="{{ route('teacher-classes.mentor-class.material.edit', [$teacherClass, $class, $material]) }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-colors duration-200">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>
                    <button onclick="confirmDelete()" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg transition-colors duration-200">
                        <i class="fas fa-trash mr-2"></i>Hapus
                    </button>
                </div>
            </div>

            <!-- Second Row: Material Info -->
            <div class="mb-4">
                <div class="flex items-center text-sm text-gray-600 mb-3">
                    <div class="w-6 h-6 bg-purple-500 rounded-full flex items-center justify-center mr-2 flex-shrink-0">
                        <i class="fas fa-user text-white text-xs"></i>
                    </div>
                    <span class="truncate">Mentor: <span class="font-medium">{{ $material->class->mentor->name }}</span></span>
                    <span class="mx-3">•</span>
                    <i class="fas fa-calendar mr-1 text-gray-400"></i>
                    <span>{{ $material->created_at->format('d M Y H:i') }}</span>
                    @if($material->updated_at != $material->created_at)
                        <span class="mx-3">•</span>
                        <i class="fas fa-edit mr-1 text-gray-400"></i>
                        <span>Diupdate: {{ $material->updated_at->format('d M Y H:i') }}</span>
                    @endif
                </div>
            </div>

            <!-- Compact Stats -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 pt-4 border-t border-gray-100">
                <div class="flex items-center space-x-3 p-3 bg-blue-50 rounded-lg">
                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-question-circle text-white text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="text-xl font-bold text-gray-900">{{ $material->quizzes->count() }}</div>
                        <div class="text-xs text-gray-600">Quiz</div>
                    </div>
                </div>
                <div class="flex items-center space-x-3 p-3 bg-emerald-50 rounded-lg">
                    <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-play text-white text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="text-xl font-bold text-gray-900">{{ $material->quizzes->where('is_active', true)->count() }}</div>
                        <div class="text-xs text-gray-600">Quiz Aktif</div>
                    </div>
                </div>
                <div class="flex items-center space-x-3 p-3 bg-purple-50 rounded-lg">
                    <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-video text-white text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="text-xl font-bold text-gray-900">{{ $material->video_url ? 1 : 0 }}</div>
                        <div class="text-xs text-gray-600">Video</div>
                    </div>
                </div>
                <div class="flex items-center space-x-3 p-3 bg-orange-50 rounded-lg">
                    <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-file-alt text-white text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="text-xl font-bold text-gray-900">{{ $material->content ? str_word_count(strip_tags($material->content)) : 0 }}</div>
                        <div class="text-xs text-gray-600">Kata</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Video Section -->
                @if($material->video_url)
                    <div class="bg-white rounded-lg shadow-sm border p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-bold text-gray-900">Video Pembelajaran</h2>
                            <span class="text-sm text-gray-500">{{ $material->created_at->format('d M Y') }}</span>
                        </div>

                        <div class="aspect-video bg-gray-100 rounded-lg overflow-hidden">
                            @if(str_contains($material->video_url, 'youtube.com') || str_contains($material->video_url, 'youtu.be'))
                                @php
                                    $videoId = '';
                                    if (str_contains($material->video_url, 'youtube.com/watch?v=')) {
                                        $videoId = substr($material->video_url, strpos($material->video_url, 'v=') + 2);
                                        $videoId = substr($videoId, 0, strpos($videoId, '&') ?: strlen($videoId));
                                    } elseif (str_contains($material->video_url, 'youtu.be/')) {
                                        $videoId = substr($material->video_url, strrpos($material->video_url, '/') + 1);
                                    }
                                @endphp
                                @if($videoId)
                                    <iframe src="https://www.youtube.com/embed/{{ $videoId }}"
                                            class="w-full h-full"
                                            frameborder="0"
                                            allowfullscreen>
                                    </iframe>
                                @else
                                    <div class="flex items-center justify-center h-full">
                                        <a href="{{ $material->video_url }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-colors duration-200">
                                            <i class="fas fa-external-link-alt mr-2"></i>Buka Video
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div class="flex items-center justify-center h-full">
                                    <a href="{{ $material->video_url }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-colors duration-200">
                                        <i class="fas fa-external-link-alt mr-2"></i>Buka Video
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Content Section -->
                <div class="bg-white rounded-lg shadow-sm border p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Konten Materi</h2>
                        @if($material->content)
                            <span class="text-sm text-gray-500">{{ str_word_count(strip_tags($material->content)) }} kata</span>
                        @endif
                    </div>

                    @if($material->content)
                        <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed">
                            {!! $material->content !!}
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center">
                                <i class="fas fa-file-alt text-3xl text-gray-400"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Belum ada konten</h3>
                            <p class="text-gray-500 mb-6 max-w-md mx-auto">Konten materi belum tersedia. Silakan edit materi untuk menambahkan konten pembelajaran.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Quiz Section -->
                <div class="bg-white rounded-lg shadow-sm border p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Quiz</h2>
                        @if($material->quizzes->count() > 0)
                            <span class="text-sm text-gray-500">{{ $material->quizzes->count() }} quiz tersedia</span>
                        @endif
                    </div>

                    @if($material->quizzes->count() > 0)
                        <div class="space-y-4">
                            @foreach($material->quizzes as $quiz)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md hover:border-gray-300 transition-all duration-200">
                                    <div class="flex items-center justify-between mb-3">
                                        <h3 class="font-semibold text-gray-900 truncate">{{ $quiz->title ?? 'Quiz ' . $loop->iteration }}</h3>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold flex-shrink-0 {{ $quiz->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">
                                            <span class="w-1.5 h-1.5 mr-1 rounded-full {{ $quiz->is_active ? 'bg-emerald-500' : 'bg-gray-500' }}"></span>
                                            {{ $quiz->is_active ? 'Aktif' : 'Draft' }}
                                        </span>
                                    </div>

                                    @if($quiz->description)
                                        <p class="text-sm text-gray-600 mb-3">{{ Str::limit($quiz->description, 100) }}</p>
                                    @endif

                                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                                        @if(isset($quiz->questions_count))
                                            <span class="inline-flex items-center">
                                                <i class="fas fa-question-circle mr-1 text-blue-500"></i>{{ $quiz->questions_count ?? 0 }} Soal
                                            </span>
                                        @endif
                                        @if(isset($quiz->time_limit))
                                            <span class="inline-flex items-center">
                                                <i class="fas fa-clock mr-1 text-orange-500"></i>{{ $quiz->time_limit ?? 0 }} Menit
                                            </span>
                                        @endif
                                        @if($quiz->created_at)
                                            <span class="inline-flex items-center">
                                                <i class="fas fa-calendar mr-1 text-gray-400"></i>{{ $quiz->created_at->format('d M Y') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center">
                                <i class="fas fa-question-circle text-3xl text-gray-400"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Belum ada quiz</h3>
                            <p class="text-gray-500 mb-6 max-w-md mx-auto">Quiz belum tersedia untuk materi ini. Tambahkan quiz untuk menguji pemahaman siswa.</p>
                        </div>
                    @endif
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-sm border p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Aksi Cepat</h2>

                    <div class="space-y-3">
                        <a href="{{ route('teacher-classes.mentor-class.material.edit', [$teacherClass, $class, $material]) }}"
                           class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-colors duration-200">
                            <i class="fas fa-edit mr-2"></i>Edit Materi
                        </a>

                        <a href="{{ route('teacher-classes.mentor-class.show', [$teacherClass, $class]) }}"
                           class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-semibold rounded-lg transition-colors duration-200">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Kelas
                        </a>

                        <button onclick="confirmDelete()"
                                class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg transition-colors duration-200">
                            <i class="fas fa-trash mr-2"></i>Hapus Materi
                        </button>
                    </div>
                </div>

                <!-- Material Statistics -->
                <div class="bg-white rounded-lg shadow-sm border p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Detail Materi</h2>

                    <div class="space-y-4 text-sm">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Dibuat:</span>
                            <span class="font-medium text-gray-900">{{ $material->created_at->format('d M Y') }}</span>
                        </div>

                        @if($material->updated_at != $material->created_at)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Diperbarui:</span>
                                <span class="font-medium text-gray-900">{{ $material->updated_at->format('d M Y') }}</span>
                            </div>
                        @endif

                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Total Quiz:</span>
                            <span class="font-medium text-gray-900">{{ $material->quizzes->count() }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Quiz Aktif:</span>
                            <span class="font-medium text-emerald-600">{{ $material->quizzes->where('is_active', true)->count() }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Video:</span>
                            <span class="font-medium {{ $material->video_url ? 'text-emerald-600' : 'text-gray-400' }}">
                                {{ $material->video_url ? 'Tersedia' : 'Tidak Ada' }}
                            </span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Status:</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold {{ isset($material->is_active) && $material->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">
                                {{ isset($material->is_active) && $material->is_active ? 'Aktif' : 'Draft' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Delete Material Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm hidden items-center justify-center z-50 p-4">
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
                        Apakah Anda yakin ingin menghapus materi "<span class="font-semibold text-gray-900">{{ $material->title }}</span>"?
                    </p>
                    <div class="mt-4 p-4 bg-red-50 rounded-xl border border-red-100">
                        <p class="text-sm text-red-700 flex items-start">
                            <i class="fas fa-info-circle mr-2 mt-0.5"></i>
                            <span>Semua quiz terkait akan ikut terhapus secara permanen.</span>
                        </p>
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <button onclick="closeDeleteModal()" class="px-6 py-3 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200">
                        Batal
                    </button>
                    <form method="POST" action="{{ route('teacher-classes.mentor-class.material.destroy', [$teacherClass, $class, $material]) }}" class="inline">
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

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeDeleteModal();
            }
        });
    </script>
@endsection
