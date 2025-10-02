@extends("layouts.admin")
@section('content')
    {{-- Extends layouts.app jika menggunakan Laravel Blade --}}

    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center mb-6">
                <a href="{{ route('teacher-classes.index') }}" class="text-blue-600 hover:text-blue-800 mr-4">
                    ← Kembali
                </a>
                <h1 class="text-2xl font-bold text-gray-900">Buat Kelas Baru</h1>
            </div>

            {{-- Error Messages --}}
            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('teacher-classes.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Nama Kelas --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Kelas <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Contoh: Matematika Dasar"
                        required
                    >
                </div>

                {{-- Mata Pelajaran --}}
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                        Mata Pelajaran
                    </label>
                    <input
                        type="text"
                        name="subject"
                        id="subject"
                        value="{{ old('subject') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Contoh: Matematika"
                    >
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Kelas
                    </label>
                    <textarea
                        name="description"
                        id="description"
                        rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Jelaskan tentang kelas ini..."
                    >{{ old('description') }}</textarea>
                </div>

                {{-- Preview Info --}}
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h3 class="text-sm font-medium text-blue-800 mb-2">📝 Info:</h3>
                    <ul class="text-sm text-blue-700 space-y-1">
                        <li>• Setelah kelas dibuat, calon mentor dapat mendaftar untuk mengajar di kelas ini</li>
                        <li>• Anda akan menerima notifikasi permintaan mentor yang perlu disetujui</li>
                        <li>• Kelas akan tampil di daftar pilihan saat pendaftaran mentor</li>
                    </ul>
                </div>

                {{-- Buttons --}}
                <div class="flex justify-end space-x-4 pt-6">
                    <a href="{{ route('teacher-classes.index') }}"
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                        Buat Kelas
                    </button>
                </div>
            </form>
        </div>

        {{-- Preview Card --}}
        <div class="mt-8 bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Preview Tampilan untuk Mentor</h3>
            <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                <div class="flex justify-between items-center">
                    <div>
                        <h4 class="font-medium text-gray-900" id="preview-name">Nama Kelas</h4>
                        <p class="text-sm text-gray-600">
                            by <span class="font-medium">{{ auth()->user()->name }}</span>
                            <span id="preview-subject"></span>
                        </p>
                        <p class="text-sm text-gray-500 mt-1" id="preview-description">Deskripsi akan muncul di sini...</p>
                    </div>
                    <button class="bg-blue-100 text-blue-700 px-3 py-1 rounded text-sm">
                        Pilih
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Live preview
        document.getElementById('name').addEventListener('input', function(e) {
            document.getElementById('preview-name').textContent = e.target.value || 'Nama Kelas';
        });

        document.getElementById('subject').addEventListener('input', function(e) {
            const subjectPreview = document.getElementById('preview-subject');
            subjectPreview.textContent = e.target.value ? ` (${e.target.value})` : '';
        });

        document.getElementById('description').addEventListener('input', function(e) {
            document.getElementById('preview-description').textContent = e.target.value || 'Deskripsi akan muncul di sini...';
        });
    </script>
@endsection
