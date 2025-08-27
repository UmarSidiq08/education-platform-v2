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
                <li class="text-gray-900 font-medium">Edit: {{ $material->title }}</li>
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

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-red-500 text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-red-700 font-medium mb-2">Terdapat kesalahan pada form:</h4>
                        <ul class="text-red-700 list-disc pl-5 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Material Header -->
        <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
            <div class="flex justify-between items-start mb-4">
                <div class="flex items-center flex-1 min-w-0">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                        <i class="fas fa-edit text-white text-xl"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h1 class="text-2xl font-bold text-gray-900 truncate">Edit Materi</h1>
                        <p class="text-gray-600 text-sm mt-1 truncate">{{ $material->title }}</p>
                    </div>
                </div>

                <div class="flex items-center space-x-3 flex-shrink-0">
                    <a href="{{ route('teacher-classes.mentor-class.material.show', [$teacherClass, $class, $material]) }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-semibold rounded-lg transition-colors duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 pt-4 border-t border-gray-100">
                <div class="flex items-center space-x-3 p-3 bg-blue-50 rounded-lg">
                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-calendar text-white text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="text-sm font-bold text-gray-900">{{ $material->created_at->format('d M Y') }}</div>
                        <div class="text-xs text-gray-600">Dibuat</div>
                    </div>
                </div>
                <div class="flex items-center space-x-3 p-3 bg-emerald-50 rounded-lg">
                    <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-question-circle text-white text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="text-xl font-bold text-gray-900">{{ $material->quizzes->count() }}</div>
                        <div class="text-xs text-gray-600">Quiz</div>
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
                        <i class="fas fa-{{ $material->is_published ? 'eye' : 'eye-slash' }} text-white text-sm"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="text-sm font-bold text-gray-900">{{ $material->is_published ? 'Published' : 'Draft' }}</div>
                        <div class="text-xs text-gray-600">Status</div>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('teacher-classes.mentor-class.material.update', [$teacherClass, $class, $material]) }}" method="POST" enctype="multipart/form-data" id="materialForm">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div class="bg-white rounded-lg shadow-sm border p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Informasi Dasar</h2>

                        <!-- Title -->
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Judul Materi <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   id="title"
                                   name="title"
                                   value="{{ old('title', $material->title) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror"
                                   placeholder="Masukkan judul materi yang menarik"
                                   required>
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi Singkat
                            </label>
                            <textarea id="description"
                                      name="description"
                                      rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                                      placeholder="Berikan deskripsi singkat tentang materi ini...">{{ old('description', $material->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Video URL -->
                        <div class="mb-6">
                            <label for="video_url" class="block text-sm font-medium text-gray-700 mb-2">
                                URL Video (Opsional)
                            </label>
                            <input type="url"
                                   id="video_url"
                                   name="video_url"
                                   value="{{ old('video_url', $material->video_url) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('video_url') border-red-500 @enderror"
                                   placeholder="https://youtube.com/watch?v=... atau URL video lainnya">
                            @error('video_url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Masukkan URL video pembelajaran (YouTube, Vimeo, dll.)</p>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="bg-white rounded-lg shadow-sm border p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Konten Materi</h2>

                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                                Konten Materi <span class="text-red-500">*</span>
                            </label>
                            <div class="border-2 border-gray-300 rounded-md overflow-hidden transition-all duration-300 focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-200 @error('content') border-red-500 @enderror">
                                <div id="quill-editor" style="height: 400px;">{!! old('content', $material->content) !!}</div>
                                <textarea name="content" id="content" class="hidden" required>{{ old('content', $material->content) }}</textarea>
                            </div>
                            @error('content')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">
                                <i class="fas fa-lightbulb text-amber-500 mr-1"></i>
                                Gunakan toolbar di atas untuk memformat konten dengan heading, teks tebal, list, dan lainnya.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Publishing Status -->
                    <div class="bg-white rounded-lg shadow-sm border p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Status Publikasi</h3>

                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <input type="hidden" name="is_published" value="0">
                                <input type="checkbox"
                                       id="is_published"
                                       name="is_published"
                                       value="1"
                                       {{ old('is_published', $material->is_published) ? 'checked' : '' }}
                                       class="mt-1">
                                <div>
                                    <label for="is_published" class="text-sm font-medium text-gray-900 cursor-pointer">
                                        Publikasikan Materi
                                    </label>
                                    <p class="text-sm text-gray-500">Materi akan terlihat oleh siswa</p>
                                </div>
                            </div>

                            @if($material->is_published)
                                <div class="p-3 bg-emerald-50 rounded-lg border border-emerald-200">
                                    <div class="flex items-center">
                                        <i class="fas fa-eye text-emerald-600 mr-2"></i>
                                        <span class="text-sm font-medium text-emerald-800">Status: Dipublikasikan</span>
                                    </div>
                                </div>
                            @else
                                <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                                    <div class="flex items-center">
                                        <i class="fas fa-eye-slash text-gray-600 mr-2"></i>
                                        <span class="text-sm font-medium text-gray-800">Status: Draft</span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        @error('is_published')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Current Video Preview -->
                    @if($material->video_url)
                        <div class="bg-white rounded-lg shadow-sm border p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Video Saat Ini</h3>

                            <div class="mb-4">
                                <div class="aspect-w-16 aspect-h-9 bg-gray-100 rounded-lg overflow-hidden">
                                    @if(str_contains($material->video_url, 'youtube.com') || str_contains($material->video_url, 'youtu.be'))
                                        @php
                                            $video_id = '';
                                            if (str_contains($material->video_url, 'youtube.com/watch?v=')) {
                                                parse_str(parse_url($material->video_url, PHP_URL_QUERY), $query);
                                                $video_id = $query['v'] ?? '';
                                            } elseif (str_contains($material->video_url, 'youtu.be/')) {
                                                $video_id = basename(parse_url($material->video_url, PHP_URL_PATH));
                                            }
                                        @endphp
                                        @if($video_id)
                                            <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $video_id }}" frameborder="0" allowfullscreen></iframe>
                                        @else
                                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                                <i class="fas fa-video text-gray-400 text-2xl"></i>
                                            </div>
                                        @endif
                                    @else
                                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                            <i class="fas fa-external-link-alt text-gray-400 text-2xl"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="text-sm text-gray-600 break-all">
                                <strong>URL:</strong><br>
                                <a href="{{ $material->video_url }}" target="_blank" class="text-blue-600 hover:underline">
                                    {{ Str::limit($material->video_url, 50) }}
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="bg-white rounded-lg shadow-sm border p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Aksi</h3>

                        <div class="space-y-3">
                            <button type="submit"
                                    class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-colors duration-200">
                                <i class="fas fa-save mr-2"></i>Update Materi
                            </button>

                            <a href="{{ route('teacher-classes.mentor-class.material.show', [$teacherClass, $class, $material]) }}"
                               class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-semibold rounded-lg transition-colors duration-200">
                                <i class="fas fa-times mr-2"></i>Batal
                            </a>
                        </div>
                    </div>

                    <!-- Material Info -->
                    <div class="bg-white rounded-lg shadow-sm border p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Materi</h3>

                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Dibuat:</span>
                                <span class="font-medium">{{ $material->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Diupdate:</span>
                                <span class="font-medium">{{ $material->updated_at->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Quiz:</span>
                                <span class="font-medium">{{ $material->quizzes->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Quill CSS & JS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi Quill editor
            var quill = new Quill('#quill-editor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'indent': '-1'}, { 'indent': '+1' }],
                        [{ 'align': [] }],
                        ['blockquote', 'code-block'],
                        ['link', 'image'],
                        ['clean']
                    ]
                },
                placeholder: 'Tulis konten materi pembelajaran di sini...'
            });

            // Sinkronisasi konten Quill dengan textarea tersembunyi
            quill.on('text-change', function() {
                var content = quill.root.innerHTML;
                document.getElementById('content').value = content;
            });

            // Set initial content jika ada
            var initialContent = document.getElementById('content').value;
            if (initialContent) {
                quill.root.innerHTML = initialContent;
            }

            // Form validation
            document.getElementById('materialForm').addEventListener('submit', function(e) {
                var title = document.getElementById('title').value.trim();
                var content = quill.getText().trim();

                if (!title || !content) {
                    e.preventDefault();
                    alert('Judul dan konten materi harus diisi!');
                    return false;
                }

                // Pastikan textarea tersembunyi memiliki konten terbaru
                document.getElementById('content').value = quill.root.innerHTML;
            });
        });
    </script>

    <style>
        /* Quill Editor Styling */
        .ql-toolbar {
            border: none !important;
            border-bottom: 1px solid #e5e7eb !important;
            background: #f9fafb;
            padding: 12px !important;
        }

        .ql-container {
            border: none !important;
            font-size: 16px !important;
        }

        .ql-editor {
            padding: 16px !important;
            line-height: 1.6 !important;
        }

        .ql-editor.ql-blank::before {
            color: #9ca3af !important;
            font-style: normal !important;
        }

        /* Focus styles untuk Quill */
        .ql-snow.ql-toolbar button:hover,
        .ql-snow .ql-toolbar button:hover,
        .ql-snow.ql-toolbar button.ql-active,
        .ql-snow .ql-toolbar button.ql-active {
            color: #3b82f6 !important;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .ql-toolbar {
                padding: 8px !important;
            }

            .ql-editor {
                padding: 12px !important;
            }
        }
    </style>
@endsection
