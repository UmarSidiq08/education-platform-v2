@extends("layouts.admin")
@section('content')
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm text-gray-600">
                <li><a href="{{ route('teacher-classes.show', $teacherClass) }}" class="hover:text-blue-600">{{ $teacherClass->name }}</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li><a href="{{ route('teacher-classes.implementation', $teacherClass) }}" class="hover:text-blue-600">Implementasi</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li><a href="{{ route('teacher-classes.mentor-class.show', [$teacherClass, $class]) }}" class="hover:text-blue-600">{{ $class->name }}</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li class="text-gray-800">Edit</li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Edit Kelas Mentor</h1>
                    <p class="text-gray-600 mt-2">Ubah informasi kelas "{{ $class->name }}"</p>
                </div>
                <a href="{{ route('teacher-classes.mentor-class.show', [$teacherClass, $class]) }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Edit Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form method="POST" action="{{ route('teacher-classes.mentor-class.update', [$teacherClass, $class]) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Class Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Kelas <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name', $class->name) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                           placeholder="Masukkan nama kelas"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Kelas
                    </label>
                    <textarea id="description"
                              name="description"
                              rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                              placeholder="Deskripsi singkat tentang kelas ini">{{ old('description', $class->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Maksimal 2000 karakter</p>
                </div>

                <!-- Status (if applicable) -->
                @if(isset($class->is_active))
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox"
                                   name="is_active"
                                   value="1"
                                   {{ old('is_active', $class->is_active) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Aktifkan kelas</span>
                        </label>
                        <p class="mt-1 text-sm text-gray-500">Kelas yang diaktifkan dapat diakses oleh siswa</p>
                    </div>
                @endif

                <!-- Class Info (Read Only) -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-800 mb-3">Informasi Kelas</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600">Mentor:</span>
                            <span class="font-medium text-gray-800 ml-2">{{ $class->mentor->name }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Teacher Class:</span>
                            <span class="font-medium text-gray-800 ml-2">{{ $teacherClass->name }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Dibuat:</span>
                            <span class="font-medium text-gray-800 ml-2">{{ $class->created_at->format('d M Y H:i') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Terakhir diupdate:</span>
                            <span class="font-medium text-gray-800 ml-2">{{ $class->updated_at->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('teacher-classes.mentor-class.show', [$teacherClass, $class]) }}"
                       class="px-6 py-2 text-gray-600 hover:text-gray-800 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- Additional Actions -->
        <div class="bg-white rounded-lg shadow-md p-6 mt-6">
            <h3 class="text-lg font-medium text-gray-800 mb-4">Aksi Tambahan</h3>
            <div class="flex flex-wrap gap-3">
                @if(isset($class->is_active))
                    <form method="POST" action="{{ route('teacher-classes.mentor-class.toggle-status', [$teacherClass, $class]) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="px-4 py-2 bg-{{ $class->is_active ? 'orange' : 'green' }}-500 hover:bg-{{ $class->is_active ? 'orange' : 'green' }}-600 text-white rounded-lg transition-colors">
                            <i class="fas fa-toggle-{{ $class->is_active ? 'off' : 'on' }} mr-2"></i>
                            {{ $class->is_active ? 'Nonaktifkan Kelas' : 'Aktifkan Kelas' }}
                        </button>
                    </form>
                @endif

                <button onclick="confirmDelete()" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors">
                    <i class="fas fa-trash mr-2"></i>
                    Hapus Kelas
                </button>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-sm w-full mx-4">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Hapus</h3>
            <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus kelas "{{ $class->name }}"? Semua materi dan quiz akan ikut terhapus.</p>
            <div class="flex justify-end space-x-4">
                <button onclick="closeDeleteModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors">
                    Batal
                </button>
                <form method="POST" action="{{ route('teacher-classes.mentor-class.destroy', [$teacherClass, $class]) }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition-colors">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete() {
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteModal').classList.remove('flex');
        }

        // Auto-resize textarea
        const textarea = document.getElementById('description');
        if (textarea) {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        }
    </script>
@endsection
