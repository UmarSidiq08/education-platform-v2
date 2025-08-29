@extends('layouts.admin')
@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Kelola Kelas Saya</h1>
        <a href="{{ route('teacher-classes.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors">
            Buat Kelas Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-6">
        @forelse($teacherClasses as $teacherClass)
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                            {{ $teacherClass->name }}
                            @if($teacherClass->subject)
                                <span class="text-sm text-gray-600">({{ $teacherClass->subject }})</span>
                            @endif
                        </h3>
                        @if($teacherClass->description)
                            <p class="text-gray-600 mb-4">{{ $teacherClass->description }}</p>
                        @endif

                        <div class="flex space-x-6 text-sm text-gray-500">
                            <span>📚 {{ $teacherClass->implementationClasses->count() }} Implementation Classes</span>
                            <span>👨‍🏫 {{ $teacherClass->approvedMentors->count() }} Mentor Aktif</span>
                            <span class="flex items-center">
                                ⏳ {{ $teacherClass->pending_requests_count }} Pending Request
                                @if($teacherClass->pending_requests_count > 0)
                                    <span class="ml-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">New</span>
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-2">


                        <!-- Edit Button -->
                        <a href="{{ route('teacher-classes.edit', $teacherClass) }}"
                           class="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 px-4 py-2 rounded transition-colors"
                           title="Edit Kelas">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit
                        </a>

                        <!-- Delete Button -->
                        <button onclick="confirmDelete('{{ $teacherClass->id }}', '{{ $teacherClass->name }}')"
                                class="bg-red-100 hover:bg-red-200 text-red-700 px-4 py-2 rounded transition-colors"
                                title="Hapus Kelas">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Hapus
                        </button>

                        <!-- Hidden Delete Form -->
                        <form id="delete-form-{{ $teacherClass->id }}"
                              action="{{ route('teacher-classes.destroy', $teacherClass) }}"
                              method="POST"
                              style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-gray-50 rounded-lg p-8 text-center">
                <p class="text-gray-600 mb-4">Belum ada kelas yang dibuat.</p>
                <a href="{{ route('teacher-classes.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors">
                    Buat Kelas Pertama
                </a>
            </div>
        @endforelse
    </div>

    <!-- Quick Stats -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-blue-50 rounded-lg p-4 text-center">
            <div class="text-2xl font-bold text-blue-600">{{ $teacherClasses->count() }}</div>
            <div class="text-blue-600 text-sm">Total Kelas</div>
        </div>
        <div class="bg-green-50 rounded-lg p-4 text-center">
            <div class="text-2xl font-bold text-green-600">{{ $teacherClasses->sum(fn($tc) => $tc->approvedMentors->count()) }}</div>
            <div class="text-green-600 text-sm">Mentor Aktif</div>
        </div>
        <div class="bg-orange-50 rounded-lg p-4 text-center">
            <div class="text-2xl font-bold text-orange-600">{{ $teacherClasses->sum('pending_requests_count') }}</div>
            <div class="text-orange-600 text-sm">Pending Request</div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Konfirmasi Hapus Kelas</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Apakah Anda yakin ingin menghapus kelas "<span id="className" class="font-semibold"></span>"?
                </p>
                <p class="text-sm text-red-500 mt-2">
                    <strong>Peringatan:</strong> Tindakan ini akan menghapus semua data terkait termasuk implementation classes, materials, dan Pre Test yang ada di dalamnya. Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="confirmDelete"
                        class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                    Ya, Hapus Kelas
                </button>
                <button id="cancelDelete"
                        class="mt-3 px-4 py-2 bg-gray-300 text-gray-700 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let currentDeleteId = null;

function confirmDelete(classId, className) {
    currentDeleteId = classId;
    document.getElementById('className').textContent = className;
    document.getElementById('deleteModal').classList.remove('hidden');
}

document.getElementById('confirmDelete').addEventListener('click', function() {
    if (currentDeleteId) {
        document.getElementById('delete-form-' + currentDeleteId).submit();
    }
});

document.getElementById('cancelDelete').addEventListener('click', function() {
    document.getElementById('deleteModal').classList.add('hidden');
    currentDeleteId = null;
});

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        this.classList.add('hidden');
        currentDeleteId = null;
    }
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.getElementById('deleteModal').classList.add('hidden');
        currentDeleteId = null;
    }
});
</script>
@endsection
