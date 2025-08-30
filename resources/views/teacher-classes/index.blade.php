@extends("layouts.admin")
@section('content')
    <style>
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr) !important;
            }

            .action-buttons {
                flex-direction: column;
                gap: 0.5rem;
            }

            .action-buttons a, .action-buttons button {
                width: 100%;
                justify-content: center;
            }

            .class-info-items {
                flex-direction: column;
                gap: 0.5rem;
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr !important;
            }

            .page-header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start !important;
            }

            .class-main-content {
                flex-direction: column;
            }
        }

        .class-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .class-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        /* Animasi untuk modal */
        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .modal-content {
            animation: modalFadeIn 0.3s ease-out;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6 page-header">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Kelola Kelas Saya</h1>
            <a href="{{ route('teacher-classes.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors text-sm md:text-base flex items-center">
                <i class="fas fa-plus-circle mr-2"></i> Buat Kelas Baru
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-6">
            @forelse($teacherClasses as $teacherClass)
                <div class="bg-white rounded-lg shadow-md p-4 md:p-6 border-l-4 border-blue-500 class-card">
                    <div class="flex flex-col md:flex-row justify-between items-start gap-4 class-main-content">
                        <div class="flex-1">
                            <h3 class="text-lg md:text-xl font-semibold text-gray-900 mb-2">
                                {{ $teacherClass->name }}
                                @if($teacherClass->subject)
                                    <span class="text-sm text-gray-600">({{ $teacherClass->subject }})</span>
                                @endif
                            </h3>
                            @if($teacherClass->description)
                                <p class="text-gray-600 mb-4 text-sm md:text-base">{{ $teacherClass->description }}</p>
                            @endif

                            <div class="flex flex-wrap gap-4 text-sm text-gray-500 class-info-items">
                                <span class="flex items-center"><i class="fas fa-book mr-2"></i> {{ $teacherClass->implementationClasses->count() }} Implementation Classes</span>
                                <span class="flex items-center"><i class="fas fa-chalkboard-teacher mr-2"></i> {{ $teacherClass->approvedMentors->count() }} Mentor Aktif</span>
                                <span class="flex items-center">
                                    <i class="fas fa-clock mr-2"></i> {{ $teacherClass->pending_requests_count }} Pending Request
                                    @if($teacherClass->pending_requests_count > 0)
                                        <span class="ml-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">New</span>
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-wrap gap-2 action-buttons w-full md:w-auto">
                            <!-- View Button -->
                         

                            <!-- Edit Button -->
                            <a href="{{ route('teacher-classes.edit', $teacherClass) }}"
                               class="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 px-3 py-2 rounded transition-colors text-sm flex items-center justify-center"
                               title="Edit Kelas">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>

                            <!-- Delete Button -->
                            <button onclick="confirmDelete('{{ $teacherClass->id }}', '{{ $teacherClass->name }}')"
                                    class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-2 rounded transition-colors text-sm flex items-center justify-center"
                                    title="Hapus Kelas">
                                <i class="fas fa-trash mr-1"></i> Hapus
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
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4 stats-grid">
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
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center p-4">
        <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full mx-auto modal-content">
            <div class="p-6 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mt-4">Konfirmasi Hapus Kelas</h3>
                <div class="mt-2 px-2">
                    <p class="text-sm text-gray-500">
                        Apakah Anda yakin ingin menghapus kelas "<span id="className" class="font-semibold"></span>"?
                    </p>
                    <p class="text-sm text-red-500 mt-2">
                        <strong>Peringatan:</strong> Tindakan ini akan menghapus semua data terkait termasuk implementation classes, materials, dan Pre Test yang ada di dalamnya. Tindakan ini tidak dapat dibatalkan.
                    </p>
                </div>
                <div class="mt-6 flex flex-col sm:flex-row gap-3">
                    <button id="confirmDelete"
                            class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                        Ya, Hapus Kelas
                    </button>
                    <button id="cancelDelete"
                            class="px-4 py-2 bg-gray-300 text-gray-700 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
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
