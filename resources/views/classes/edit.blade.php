@extends('layouts.app')

@section('content')
    <style>
        /* Custom gradient classes untuk Tailwind */
        .bg-edit-gradient {
            background: linear-gradient(135deg, #4a6cf7 0%, #2541b2 100%);
        }
        .bg-btn-gradient {
            background: linear-gradient(135deg, #4a6cf7 0%, #2541b2 100%);
        }
        .bg-btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(74, 108, 247, 0.4);
        }
        .deco-circle {
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }
        .focus-blue:focus {
            border-color: #4a6cf7;
            box-shadow: 0 0 0 3px rgba(74, 108, 247, 0.2);
        }
    </style>

    <div class="max-w-6xl mx-auto p-4 md:p-8 font-sans">
        <!-- Header Section -->
        <div class="relative mb-12 p-6 md:p-8 bg-edit-gradient rounded-2xl text-white overflow-hidden">
            <div class="relative z-10">
                <h1 class="text-3xl md:text-4xl font-extrabold mb-2">Edit Learning Space</h1>
                <p class="text-lg opacity-90">Update your classroom information</p>
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
                            <p class="text-sm text-gray-600">Update the information below</p>
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
                    @if($errors->any())
                        <div class="flex gap-4 p-4 bg-red-50 border-l-4 border-red-400 rounded mb-6">
                            <div class="text-red-500 text-lg">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-base font-semibold text-red-700 mb-2">Oops! There's an issue</h4>
                                <ul class="text-red-700 list-disc pl-5 space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <!-- Form -->
                    <form action="{{ route('classes.update', $class->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Class Name Field -->
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <label for="name" class="block text-sm font-semibold text-gray-800">Class Name</label>
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-semibold">Required</span>
                            </div>
                            <div class="relative">
                                <i class="fas fa-chalkboard-teacher absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 icon-focus"></i>
                                <input type="text"
                                       class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg text-base transition-all duration-300 focus-blue focus:outline-none @error('name') border-red-500 @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name', $class->name) }}"
                                       placeholder="e.g. Advanced Mathematics 2023"
                                       required>
                            </div>
                            @error('name')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description Field -->
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <label for="description" class="block text-sm font-semibold text-gray-800">Class Description</label>
                                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-semibold">Optional</span>
                            </div>
                            <div class="relative">
                                <i class="fas fa-align-left absolute left-4 top-5 text-gray-400 icon-focus"></i>
                                <textarea class="w-full pl-12 pr-4 py-4 border border-gray-300 rounded-lg text-base min-h-32 transition-all duration-300 focus-blue focus:outline-none @error('description') border-red-500 @enderror"
                                          id="description"
                                          name="description"
                                          rows="4"
                                          placeholder="Describe what students will learn in this class...">{{ old('description', $class->description) }}</textarea>
                            </div>
                            @error('description')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                            <div class="flex items-center gap-2 text-sm text-gray-600 mt-2">
                                <i class="fas fa-lightbulb text-yellow-500"></i>
                                <span>Tip: Include key topics and learning objectives</span>
                            </div>
                            <!-- Character counter will be inserted here by JavaScript -->
                        </div>

                        <!-- Form Actions -->
                        <div class="flex flex-col md:flex-row gap-4 pt-6 border-t border-gray-200">
                            <button type="submit"
                                    class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-btn-gradient text-white border-0 rounded-lg font-semibold cursor-pointer transition-all duration-300 hover:-translate-y-0.5">
                                <i class="fas fa-save"></i> Update Class
                            </button>
                            <a href="{{ route('classes.my') }}"
                               class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white text-gray-700 border border-gray-300 rounded-lg font-medium no-underline transition-all duration-300 hover:bg-gray-50 hover:-translate-y-0.5">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional responsive styles -->
    <style>
        @media (max-width: 768px) {
            .edit-header {
                text-align: center;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add character counter for description
            const description = document.getElementById('description');
            if (description) {
                const counter = document.createElement('div');
                counter.className = 'flex items-center gap-2 text-sm text-gray-600 mt-2';
                counter.innerHTML = '<span id="char-count">0</span>/500 characters';

                // Find the hint element and insert counter after it
                const hintElement = description.parentNode.parentNode.querySelector('.flex.items-center.gap-2.text-sm.text-gray-600');
                if (hintElement) {
                    hintElement.parentNode.insertBefore(counter, hintElement.nextSibling);
                }

                description.addEventListener('input', function() {
                    const charCount = document.getElementById('char-count');
                    if (charCount) {
                        charCount.textContent = this.value.length;
                        // Change color based on character count
                        if (this.value.length > 450) {
                            charCount.className = 'text-red-600 font-semibold';
                        } else if (this.value.length > 400) {
                            charCount.className = 'text-yellow-600 font-semibold';
                        } else {
                            charCount.className = '';
                        }
                    }
                });

                // Initialize counter
                const charCount = document.getElementById('char-count');
                if (charCount) {
                    charCount.textContent = description.value.length;
                }
            }

            // Enhanced focus effects for icons
            const inputs = document.querySelectorAll('.focus-blue');
            inputs.forEach(input => {
                const icon = input.parentNode.querySelector('.icon-focus');

                input.addEventListener('focus', function() {
                    if (icon) {
                        icon.style.color = '#4a6cf7';
                        icon.style.transition = 'color 0.3s ease';
                    }
                });

                input.addEventListener('blur', function() {
                    if (icon) {
                        icon.style.color = '#a0aec0';
                        icon.style.transition = 'color 0.3s ease';
                    }
                });
            });

            // Auto-resize textarea
            const textarea = document.getElementById('description');
            if (textarea) {
                textarea.addEventListener('input', function() {
                    this.style.height = 'auto';
                    this.style.height = Math.max(128, this.scrollHeight) + 'px';
                });

                // Initialize height
                textarea.style.height = Math.max(128, textarea.scrollHeight) + 'px';
            }
        });
    </script>

@endsection
