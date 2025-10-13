@extends('layouts.app')

@section('content')
    <style>
        /* Custom gradient classes untuk Tailwind */
        .bg-header-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .bg-btn-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .bg-btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .deco-circle {
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }

        /* Custom styling for select dropdown */
        .custom-select {
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 20px;
            padding-right: 40px;
        }

        /* Teacher class preview card */
        .teacher-preview {
            display: none;
            animation: fadeIn 0.3s ease-in;
        }
        .teacher-preview.show {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <div class="max-w-6xl mx-auto p-4 md:p-8 font-sans">
        <!-- Header Section -->
        <div class="relative mb-12 p-6 md:p-8 bg-header-gradient rounded-2xl text-white overflow-hidden">
            <div class="relative z-10">
                <h1 class="text-3xl md:text-4xl font-extrabold mb-2">Create New Learning Space</h1>
                <p class="text-lg opacity-90">Design your perfect classroom environment</p>
            </div>

            <!-- Decorative Circles -->
            <div class="absolute top-0 right-0 w-full h-full overflow-hidden">
                <div class="deco-circle absolute w-48 h-48 -top-12 -right-12"></div>
                <div class="deco-circle absolute w-36 h-36 top-1/2 right-24"></div>
                <div class="deco-circle absolute w-24 h-24 -bottom-8 right-48"></div>
            </div>
        </div>

        <!-- Card Container -->
        <div class="relative -mt-12 z-10">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <!-- Card Header -->
                <div class="px-6 py-4 md:px-8 md:py-6 bg-gray-50 border-b border-gray-200">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div>
                            <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-1">Class Details</h2>
                            <p class="text-sm text-gray-600">Fill in the information below</p>
                        </div>
                        <a href="{{ route('classes.my') }}"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 no-underline font-medium transition-all duration-300 hover:bg-gray-100 hover:-translate-y-0.5">
                            <i class="fas fa-arrow-left"></i> My Classes
                        </a>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-6 md:p-8">
                    <!-- Error Alert -->
                    @if ($errors->any())
                        <div class="flex gap-4 p-4 bg-red-50 border-l-4 border-red-400 rounded mb-6">
                            <div class="text-red-500 text-lg">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-base font-semibold text-red-700 mb-2">Oops! There's an issue</h4>
                                <ul class="text-red-700 list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <!-- Check if mentor has approved teacher class -->
                    @if($approvedTeacherClasses->isEmpty())
                        <div class="flex gap-4 p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded mb-6">
                            <div class="text-yellow-500 text-lg">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-base font-semibold text-yellow-700 mb-2">No Approved Teacher Class</h4>
                                <p class="text-yellow-700">You don't have any approved mentor requests yet. Please wait for teacher approval before creating classes.</p>
                                <a href="{{ route('classes.index') }}" class="inline-flex items-center gap-2 mt-3 px-4 py-2 bg-yellow-100 text-yellow-700 rounded-lg font-medium hover:bg-yellow-200 transition-colors">
                                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                                </a>
                            </div>
                        </div>
                    @else
                        <!-- Form -->
                        <form action="{{ route('classes.store.new') }}" method="POST" class="space-y-6">
                            @csrf

                            <!-- Teacher Class Selection -->
                            <div class="space-y-2">
                                <div class="flex justify-between items-center">
                                    <label for="teacher_class_id" class="block text-sm font-semibold text-gray-800">Pilih Teacher Class</label>
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-semibold">Wajib</span>
                                </div>
                                <div class="relative">
                                    <i class="fas fa-graduation-cap absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 z-10"></i>
                                    <select name="teacher_class_id"
                                            id="teacher_class_id"
                                            class="custom-select w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg text-base transition-all duration-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 focus:outline-none @error('teacher_class_id') border-red-500 @enderror appearance-none cursor-pointer"
                                            required onchange="showTeacherPreview()">
                                        <option value="">-- Pilih Teacher Class --</option>
                                        @foreach($approvedTeacherClasses as $teacherClass)
                                            <option value="{{ $teacherClass->id }}"
                                                    {{ old('teacher_class_id') == $teacherClass->id ? 'selected' : '' }}
                                                    data-teacher="{{ $teacherClass->teacher->name }}"
                                                    data-subject="{{ $teacherClass->subject ?? 'Umum' }}"
                                                    data-description="{{ $teacherClass->description }}"
                                                    data-avatar="{{ $teacherClass->teacher->avatar ? asset('storage/' . $teacherClass->teacher->avatar) : '' }}">
                                                {{ $teacherClass->name }} - {{ $teacherClass->teacher->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('teacher_class_id')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                                <p class="text-xs text-gray-500 flex items-center gap-1">
                                    <i class="fas fa-info-circle"></i>
                                    Pilih teacher class dimana kelas mentoring Anda akan dibuat
                                </p>
                            </div>

                            <!-- Teacher Class Preview -->
                            <div id="teacher-preview" class="teacher-preview mb-6 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-indigo-400 rounded-lg">
                                <div class="flex items-start gap-4">
                                    <div id="teacher-avatar" class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-xl flex items-center justify-center text-white font-bold shadow-lg flex-shrink-0">
                                        <!-- Avatar or initials will be inserted here -->
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <h3 id="teacher-class-name" class="text-lg font-bold text-gray-800"></h3>
                                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                                <i class="fas fa-check-circle"></i> APPROVED
                                            </span>
                                        </div>
                                        <div class="space-y-1">
                                            <p class="text-sm text-gray-700">
                                                <i class="fas fa-user-tie text-indigo-500 mr-2"></i>
                                                <span class="font-semibold">Teacher:</span> <span id="teacher-name"></span>
                                            </p>
                                            <p class="text-sm text-gray-700">
                                                <i class="fas fa-book text-indigo-500 mr-2"></i>
                                                <span class="font-semibold">Subject:</span> <span id="teacher-subject"></span>
                                            </p>
                                            <p id="teacher-description-wrapper" class="text-sm text-gray-600" style="display: none;">
                                                <i class="fas fa-info-circle text-indigo-500 mr-2"></i>
                                                <span id="teacher-description"></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3 pt-3 border-t border-indigo-200">
                                    <p class="text-xs text-indigo-600 flex items-center gap-2">
                                        <i class="fas fa-lightbulb"></i>
                                        Your new class will be created under this teacher class
                                    </p>
                                </div>
                            </div>

                            <!-- Class Name Field -->
                            <div class="space-y-2">
                                <div class="flex justify-between items-center">
                                    <label for="name" class="block text-sm font-semibold text-gray-800">Nama Kelas</label>
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-semibold">Wajib</span>
                                </div>
                                <div class="relative">
                                    <i class="fas fa-chalkboard-teacher absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    <input type="text"
                                           class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg text-base transition-all duration-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 focus:outline-none @error('name') border-red-500 @enderror"
                                           id="name" name="name" value="{{ old('name') }}" required
                                           placeholder="Masukkan nama kelas mentoring">
                                </div>
                                @error('name')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description Field -->
                            <div class="space-y-2">
                                <div class="flex justify-between items-center">
                                    <label for="description" class="block text-sm font-semibold text-gray-800">Deskripsi Kelas</label>
                                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-semibold">Opsional</span>
                                </div>
                                <div class="relative">
                                    <i class="fas fa-align-left absolute left-4 top-5 text-gray-400"></i>
                                    <textarea class="w-full pl-12 pr-4 py-4 border border-gray-300 rounded-lg text-base min-h-32 transition-all duration-300 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 focus:outline-none @error('description') border-red-500 @enderror"
                                              id="description" name="description" rows="4"
                                              placeholder="Jelaskan tujuan pembelajaran, topik yang akan dibahas, dan pendekatan mentoring yang akan digunakan">{{ old('description') }}</textarea>
                                </div>
                                @error('description')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Form Actions -->
                            <div class="flex flex-col md:flex-row gap-4 pt-6 border-t border-gray-200">
                                <button type="submit"
                                        class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-btn-gradient text-white border-0 rounded-lg font-semibold cursor-pointer transition-all duration-300 hover:-translate-y-0.5">
                                    <i class="fas fa-plus-circle"></i> Create Class
                                </button>
                                <a href="{{ route('classes.my') }}"
                                   class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white text-gray-700 border border-gray-300 rounded-lg font-medium no-underline transition-all duration-300 hover:bg-gray-50 hover:-translate-y-0.5">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for teacher class preview -->
    <script>
        function showTeacherPreview() {
            const select = document.getElementById('teacher_class_id');
            const preview = document.getElementById('teacher-preview');
            const selectedOption = select.options[select.selectedIndex];

            if (select.value === '') {
                preview.classList.remove('show');
                return;
            }

            // Get data from selected option
            const teacherName = selectedOption.getAttribute('data-teacher');
            const subject = selectedOption.getAttribute('data-subject');
            const description = selectedOption.getAttribute('data-description');
            const avatar = selectedOption.getAttribute('data-avatar');
            const className = selectedOption.text.split(' - ')[0]; // Get class name before teacher name

            // Update preview content
            document.getElementById('teacher-class-name').textContent = className;
            document.getElementById('teacher-name').textContent = teacherName;
            document.getElementById('teacher-subject').textContent = subject;

            // Handle description
            const descWrapper = document.getElementById('teacher-description-wrapper');
            const descElement = document.getElementById('teacher-description');
            if (description && description.trim() !== '') {
                descElement.textContent = description;
                descWrapper.style.display = 'block';
            } else {
                descWrapper.style.display = 'none';
            }

            // Handle avatar
            const avatarElement = document.getElementById('teacher-avatar');
            if (avatar && avatar.trim() !== '') {
                avatarElement.innerHTML = `<img src="${avatar}" alt="${teacherName}" class="w-full h-full rounded-xl object-cover">`;
            } else {
                // Generate initials
                const initials = teacherName.split(' ').map(word => word.charAt(0)).join('').substring(0, 2).toUpperCase();
                avatarElement.innerHTML = initials;
            }

            // Show preview with animation
            preview.classList.add('show');
        }

        // Show preview on page load if there's a selected value (for old input)
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('teacher_class_id');
            if (select.value !== '') {
                showTeacherPreview();
            }
        });
    </script>

    <!-- Additional responsive styles -->
    <style>
        @media (max-width: 768px) {
            .creation-header {
                text-align: center;
            }
        }
    </style>
@endsection
