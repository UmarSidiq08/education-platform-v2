@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-8 py-8 font-sans">
        <!-- Header Section -->
        <div
            class="relative mb-12 p-8 bg-gradient-to-br from-indigo-600 to-purple-700 rounded-2xl text-white overflow-hidden">
            <div class="relative z-10">
                <h1 class="text-4xl font-extrabold mb-2">Create New Learning Material</h1>
                <p class="text-lg opacity-90 mb-4">Design engaging content for your students</p>
                <div class="inline-block px-4 py-2 bg-white bg-opacity-20 rounded-full text-sm font-semibold">
                    {{ $class->name }}
                </div>
            </div>
            <!-- Decorative circles -->
            <div class="absolute top-0 right-0 w-full h-full overflow-hidden pointer-events-none">
                <div class="absolute -top-12 -right-12 w-48 h-48 bg-white bg-opacity-10 rounded-full"></div>
                <div class="absolute top-1/2 right-24 w-36 h-36 bg-white bg-opacity-10 rounded-full"></div>
                <div class="absolute -bottom-8 right-48 w-24 h-24 bg-white bg-opacity-10 rounded-full"></div>
            </div>
        </div>

        <!-- Card Container -->
        <div class="relative -mt-12 z-10">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <!-- Card Header -->
                <div class="px-16 py-8 bg-slate-50 border-b border-slate-200">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-bold text-slate-800 mb-1">Material Details</h2>
                            <p class="text-sm text-slate-600">Create comprehensive learning content</p>
                        </div>
                        <a href="{{ route('classes.show', $class->id) }}"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-lg text-slate-600 font-medium hover:bg-slate-100 hover:-translate-y-0.5 transition-all duration-300">
                            <i class="fas fa-arrow-left"></i> Back to Class
                        </a>
                    </div>
                </div>

                <div class="px-16 py-12">
                    <!-- Error & Success Messages -->
                    @if ($errors->any())
                        <div class="flex gap-4 p-4 mb-6 bg-red-50 border-l-4 border-red-400 rounded">
                            <div class="text-red-500 text-xl">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <div>
                                <h4 class="text-base font-medium text-red-800 mb-2">Please fix the following issues:</h4>
                                <ul class="list-disc list-inside text-red-700 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="flex gap-4 p-4 mb-6 bg-green-50 border-l-4 border-green-400 rounded">
                            <div class="text-green-500 text-xl">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div>
                                <h4 class="text-base font-medium text-green-800 mb-1">Success!</h4>
                                <p class="text-green-700">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('materials.store') }}" method="POST" enctype="multipart/form-data"
                        id="materialForm" class="flex flex-col gap-6">
                        @csrf
                        <input type="hidden" name="class_id" value="{{ $class->id }}">

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-16">
                            <!-- Left Column - Main Content -->
                            <div class="lg:col-span-2 flex flex-col gap-6">
                                <!-- Title -->
                                <div class="flex flex-col gap-2">
                                    <div class="flex justify-between items-center">
                                        <label for="title" class="text-base font-semibold text-slate-800">Material
                                            Title</label>
                                        <span
                                            class="px-2 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded">Required</span>
                                    </div>
                                    <div class="relative">
                                        <i
                                            class="fas fa-heading absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400"></i>
                                        <input type="text"
                                            class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-lg text-base focus:border-indigo-600 focus:ring-3 focus:ring-indigo-200 transition-all duration-300 @error('title') border-red-500 @enderror"
                                            id="title" name="title" value="{{ old('title') }}" required
                                            placeholder="Enter an engaging material title">
                                    </div>
                                    @error('title')
                                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="flex flex-col gap-2">
                                    <div class="flex justify-between items-center">
                                        <label for="description" class="text-base font-semibold text-slate-800">Short
                                            Description</label>
                                        <span
                                            class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded">Optional</span>
                                    </div>
                                    <div class="relative">
                                        <i class="fas fa-align-left absolute left-4 top-5 text-slate-400"></i>
                                        <textarea
                                            class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-lg text-base focus:border-indigo-600 focus:ring-3 focus:ring-indigo-200 transition-all duration-300 resize-vertical @error('description') border-red-500 @enderror"
                                            id="description" name="description" rows="3" placeholder="Provide a brief description of this material...">{{ old('description') }}</textarea>
                                    </div>
                                    @error('description')
                                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Content with Rich Text Editor -->
                                <div class="flex flex-col gap-2">
                                    <div class="flex justify-between items-center">
                                        <label for="content" class="text-base font-semibold text-slate-800">Material
                                            Content</label>
                                        <span
                                            class="px-2 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded">Required</span>
                                    </div>
                                    <div
                                        class="border-2 border-slate-200 rounded-xl overflow-hidden transition-all duration-300 focus-within:border-indigo-600 focus-within:ring-4 focus-within:ring-indigo-200">
                                        <div id="quill-editor" style="height: 400px;">{!! old('content') !!}</div>
                                        <textarea name="content" id="content" class="hidden" required>{{ old('content') }}</textarea>
                                    </div>
                                    @error('content')
                                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                    <div class="flex items-center gap-2 mt-2 text-sm text-slate-600">
                                        <i class="fas fa-lightbulb text-amber-500"></i>
                                        <span>Tip: Use the toolbar above to format your content with headings, bold text,
                                            lists, and more</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column - Media & Settings -->
                            <div class="flex flex-col gap-6">
                                <!-- Video Section -->
                                <div class="bg-slate-50 border border-slate-200 rounded-xl overflow-hidden">
                                    <div class="flex items-center gap-3 px-4 py-3 bg-white border-b border-slate-200">
                                        <i class="fas fa-video text-cyan-600 text-lg"></i>
                                        <h3 class="text-base font-semibold text-slate-800">Video Media</h3>
                                    </div>
                                    <div class="p-4">
                                        <!-- Video Upload Option -->
                                        <div class="mb-4">
                                            <label class="text-sm font-semibold text-slate-800 mb-2 block">Upload Video
                                                File</label>
                                            <div
                                                class="relative border-2 border-dashed border-slate-300 rounded-lg p-4 text-center cursor-pointer hover:border-indigo-600 hover:bg-slate-50 transition-all duration-300">
                                                <input type="file"
                                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer @error('video') border-red-500 @enderror"
                                                    id="video" name="video" accept="video/*"
                                                    onchange="handleVideoUpload(this)">
                                                <div class="flex flex-col items-center gap-2 text-slate-600">
                                                    <i class="fas fa-cloud-upload-alt text-2xl text-indigo-600"></i>
                                                    <span>Choose video file</span>
                                                </div>
                                            </div>
                                            <div class="text-xs text-slate-600 mt-1">
                                                Format: MP4, MOV, AVI, WMV, FLV, WebM<br>
                                                Maximum: 100MB
                                            </div>
                                            @error('video')
                                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="relative text-center my-4">
                                            <div class="absolute inset-0 flex items-center">
                                                <div class="w-full border-t border-slate-200"></div>
                                            </div>
                                            <div class="relative bg-slate-50 px-3">
                                                <span class="text-xs font-medium text-slate-600">OR</span>
                                            </div>
                                        </div>

                                        <!-- Video URL Option -->
                                        <div class="mb-4">
                                            <label for="video_url"
                                                class="text-sm font-semibold text-slate-800 mb-2 block">Online Video
                                                Link</label>
                                            <div class="relative">
                                                <i
                                                    class="fas fa-link absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400"></i>
                                                <input type="url"
                                                    class="w-full pl-10 pr-3 py-2 border border-slate-200 rounded-lg text-sm focus:border-indigo-600 focus:ring-2 focus:ring-indigo-200 transition-all duration-300 @error('video_url') border-red-500 @enderror"
                                                    id="video_url" name="video_url" value="{{ old('video_url') }}"
                                                    placeholder="https://youtube.com/watch?v=..."
                                                    onchange="handleVideoUrl(this)">
                                            </div>
                                            <div class="text-xs text-slate-600 mt-1">
                                                Supports YouTube, Vimeo, etc.
                                            </div>
                                            @error('video_url')
                                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Video Preview -->
                                        <div id="videoPreview" class="hidden mt-4 p-3 bg-teal-50 rounded-lg">
                                            <div class="text-sm text-teal-800">
                                                <i class="fas fa-check-circle text-teal-600 mr-2"></i>
                                                <strong>Video selected:</strong>
                                                <div id="videoInfo"></div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="video_thumbnail"
                                                class="text-sm font-semibold text-slate-800 mb-2 block">Thumbnail
                                                Video</label>
                                            <input type="file"
                                                class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                                                id="video_thumbnail" name="video_thumbnail">
                                            @if (isset($material) && $material->video_thumbnail)
                                                <img src="{{ $material->video_thumbnail_url }}" width="100"
                                                    class="mt-2 rounded-lg">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Publishing Settings -->
                                <div class="bg-slate-50 border border-slate-200 rounded-xl overflow-hidden">
                                    <div class="flex items-center gap-3 px-4 py-3 bg-white border-b border-slate-200">
                                        <i class="fas fa-cog text-emerald-600 text-lg"></i>
                                        <h3 class="text-base font-semibold text-slate-800">Publishing Settings</h3>
                                    </div>
                                    <div class="p-4">
                                        <div>
                                            <input type="hidden" name="is_published" value="0">
                                            <div class="relative">
                                                <input type="checkbox"
                                                    class="absolute opacity-0 w-0 h-0 @error('is_published') border-red-500 @enderror"
                                                    id="is_published" name="is_published" value="1"
                                                    {{ old('is_published', 0) ? 'checked' : '' }}>
                                                <label
                                                    class="flex items-start gap-3 cursor-pointer p-3 rounded-lg hover:bg-green-50 transition-all duration-300"
                                                    for="is_published">
                                                    <div
                                                        class="w-5 h-5 border-2 border-slate-300 rounded mt-0.5 flex-shrink-0 transition-all duration-300 peer-checked:bg-emerald-600 peer-checked:border-emerald-600 relative">
                                                        <i
                                                            class="fas fa-check text-white text-xs absolute top-0.5 left-0.5 opacity-0 peer-checked:opacity-100 transition-opacity duration-300"></i>
                                                    </div>
                                                    <div>
                                                        <strong class="block text-slate-800 mb-1">Publish Material</strong>
                                                        <small class="text-slate-600">Material will be visible to
                                                            students</small>
                                                    </div>
                                                </label>
                                            </div>
                                            @error('is_published')
                                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex flex-col gap-3">
                                    <button type="submit"
                                        class="inline-flex items-center justify-center gap-2 w-full px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-700 text-white font-semibold rounded-lg hover:-translate-y-0.5 hover:shadow-lg hover:shadow-indigo-500/40 transition-all duration-300">
                                        <i class="fas fa-save"></i> Save Material
                                    </button>
                                    <a href="{{ route('classes.show', $class->id) }}"
                                        class="inline-flex items-center justify-center gap-2 w-full px-6 py-3 bg-white text-slate-600 font-medium border border-slate-200 rounded-lg hover:bg-slate-50 hover:-translate-y-0.5 transition-all duration-300 no-underline">
                                        <i class="fas fa-times"></i> Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Loading Modal -->
                <div id="loadingModal"
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                    <div class="bg-white rounded-xl p-8 max-w-md w-full mx-4">
                        <div class="text-center">
                            <!-- Animated spinner -->
                            <div
                                class="w-16 h-16 border-4 border-indigo-100 border-t-indigo-600 rounded-full animate-spin mx-auto mb-4">
                            </div>

                            <h3 class="text-xl font-semibold text-slate-800 mb-2">Uploading Material</h3>
                            <p class="text-slate-600 mb-4">Please wait while we process your video and save the material...
                            </p>

                            <!-- Progress bar -->
                            <div class="w-full bg-slate-200 rounded-full h-2 mb-4">
                                <div id="uploadProgress"
                                    class="bg-indigo-600 h-2 rounded-full transition-all duration-300" style="width: 0%">
                                </div>
                            </div>

                            <p class="text-sm text-slate-500" id="progressText">Initializing...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quill.js CSS & JS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/quill/2.0.2/quill.snow.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quill/2.0.2/quill.min.js"></script>

    <!-- JavaScript for enhanced UX -->
    <script>
        // Initialize Quill Editor
        var quill = new Quill('#quill-editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{
                        'header': [1, 2, 3, 4, 5, 6, false]
                    }],
                    [{
                        'font': []
                    }],
                    [{
                        'size': ['small', false, 'large', 'huge']
                    }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{
                        'color': []
                    }, {
                        'background': []
                    }],
                    [{
                        'script': 'sub'
                    }, {
                        'script': 'super'
                    }],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    [{
                        'indent': '-1'
                    }, {
                        'indent': '+1'
                    }],
                    [{
                        'direction': 'rtl'
                    }],
                    [{
                        'align': []
                    }],
                    ['blockquote', 'code-block'],
                    ['link', 'image', 'video'],
                    ['clean']
                ]
            },
            placeholder: 'Write your material content here. Use the toolbar to format your text...'
        });

        // Debounce function untuk mencegah terlalu banyak update
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Variable untuk track composing state (untuk IME/autocorrect)
        let isComposing = false;

        // Sync Quill content dengan hidden textarea - DENGAN DEBOUNCE
        const syncContent = debounce(function() {
            // Hanya sync jika tidak sedang composing
            if (!isComposing) {
                document.getElementById('content').value = quill.root.innerHTML;
            }
        }, 300); // Wait 300ms setelah user berhenti mengetik

        // Event listener untuk text-change dengan debouncing
        quill.on('text-change', function(delta, oldDelta, source) {
            // Hanya sync jika perubahan dari user, bukan dari API/programmatic
            if (source === 'user') {
                syncContent();
            }
        });

        // Handle composition events (untuk keyboard mobile & IME)
        const editorElement = document.querySelector('#quill-editor .ql-editor');

        if (editorElement) {
            // Compositionstart: user mulai mengetik dengan IME (predictive text, autocorrect, dll)
            editorElement.addEventListener('compositionstart', function() {
                isComposing = true;
            });

            // Compositionend: user selesai dengan IME, text sudah final
            editorElement.addEventListener('compositionend', function() {
                isComposing = false;
                // Force sync setelah composition selesai
                document.getElementById('content').value = quill.root.innerHTML;
            });
        }

        // Set initial content if exists
        const contentTextarea = document.getElementById('content');
        if (contentTextarea && contentTextarea.value) {
            quill.root.innerHTML = contentTextarea.value;
        }

        function handleVideoUpload(input) {
            const videoPreview = document.getElementById('videoPreview');
            const videoInfo = document.getElementById('videoInfo');
            const videoUrlInput = document.getElementById('video_url');

            if (input.files && input.files[0]) {
                const file = input.files[0];
                const fileSize = (file.size / 1024 / 1024).toFixed(2); // Convert to MB

                videoInfo.innerHTML = `
                    <strong>${file.name}</strong><br>
                    <small>Size: ${fileSize} MB</small>
                `;
                videoPreview.classList.remove('hidden');

                // Clear video URL if file is selected
                videoUrlInput.value = '';
            } else {
                videoPreview.classList.add('hidden');
            }
        }

        function handleVideoUrl(input) {
            const videoPreview = document.getElementById('videoPreview');
            const videoInfo = document.getElementById('videoInfo');
            const videoFileInput = document.getElementById('video');

            if (input.value.trim()) {
                videoInfo.innerHTML = `
                    <strong>Video URL:</strong><br>
                    <small>${input.value}</small>
                `;
                videoPreview.classList.remove('hidden');

                // Clear file input if URL is entered
                videoFileInput.value = '';
            } else {
                videoPreview.classList.add('hidden');
            }
        }

        // SINGLE form submission handler - menggabungkan validasi dan loading modal
        document.getElementById('materialForm').addEventListener('submit', function(e) {
            const title = document.getElementById('title').value.trim();
            const content = quill.getText().trim(); // Get text content from Quill

            // Validasi
            if (!title || !content) {
                e.preventDefault();
                alert('Title and content are required!');
                return false;
            }

            // Force sync content sebelum submit (pastikan data terbaru)
            document.getElementById('content').value = quill.root.innerHTML;

            // Show loading modal
            const loadingModal = document.getElementById('loadingModal');
            const progressBar = document.getElementById('uploadProgress');
            const progressText = document.getElementById('progressText');

            loadingModal.classList.remove('hidden');

            // Disable submit button to prevent double submission
            const submitButton = this.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Processing...';

            // Simulate progress if it's a video upload
            const videoInput = document.getElementById('video');

            if (videoInput && videoInput.files && videoInput.files[0]) {
                const file = videoInput.files[0];
                const fileSize = file.size;

                // Simulate progress for large files
                if (fileSize > 10485760) { // 10MB
                    let progress = 0;
                    const interval = setInterval(() => {
                        progress += 5;
                        if (progress <= 95) {
                            progressBar.style.width = progress + '%';
                            progressText.textContent =
                                `Uploading ${Math.round(progress)}% - ${(fileSize * progress / 100 / 1048576).toFixed(1)}MB of ${(fileSize / 1048576).toFixed(1)}MB`;
                        } else {
                            clearInterval(interval);
                        }
                    }, 500);
                } else {
                    progressBar.style.width = '50%';
                    progressText.textContent = "Processing video...";
                }
            } else {
                progressBar.style.width = '50%';
                progressText.textContent = "Saving material...";
            }

            // Form akan continue submit secara normal
            return true;
        });

        // Custom checkbox styling dengan JavaScript
        const publishCheckbox = document.getElementById('is_published');
        if (publishCheckbox) {
            publishCheckbox.addEventListener('change', function() {
                const checkIcon = this.parentElement.querySelector('.fa-check');
                const checkBox = this.parentElement.querySelector('div');

                if (this.checked) {
                    checkBox.classList.add('bg-emerald-600', 'border-emerald-600');
                    checkBox.classList.remove('border-slate-300');
                    checkIcon.classList.remove('opacity-0');
                    checkIcon.classList.add('opacity-100');
                } else {
                    checkBox.classList.remove('bg-emerald-600', 'border-emerald-600');
                    checkBox.classList.add('border-slate-300');
                    checkIcon.classList.add('opacity-0');
                    checkIcon.classList.remove('opacity-100');
                }
            });
        }
    </script>

    <style>
        /* Quill Editor Custom Styling to match Tailwind design */
        .ql-toolbar {
            border: none !important;
            border-bottom: 1px solid #e2e8f0 !important;
            background: #f8fafc;
            padding: 16px !important;
        }

        .ql-container {
            border: none !important;
            font-size: 16px !important;
        }

        .ql-editor {
            padding: 24px !important;
            line-height: 1.6 !important;
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif !important;
        }

        .ql-editor.ql-blank::before {
            color: #94a3b8 !important;
            font-style: normal !important;
        }

        .ql-snow .ql-tooltip {
            z-index: 1000;
        }

        /* Custom focus styles for better UX */
        .ql-snow.ql-toolbar button:hover,
        .ql-snow .ql-toolbar button:hover,
        .ql-snow.ql-toolbar button.ql-active,
        .ql-snow .ql-toolbar button.ql-active {
            color: #4f46e5 !important;
        }

        .ql-snow.ql-toolbar .ql-stroke.ql-fill,
        .ql-snow .ql-toolbar .ql-stroke.ql-fill {
            fill: #4f46e5 !important;
        }

        .ql-snow.ql-toolbar .ql-stroke,
        .ql-snow .ql-toolbar .ql-stroke {
            stroke: #4f46e5 !important;
        }

        /* Hide default checkbox appearance and use custom styling */
        input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
        }

        /* Responsive adjustments */
        @media (max-width: 1024px) {
            .max-w-7xl {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .px-16 {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }

            .py-12 {
                padding-top: 1.5rem;
                padding-bottom: 1.5rem;
            }

            .ql-toolbar {
                padding: 8px !important;
            }

            .ql-editor {
                padding: 16px !important;
            }
        }

        /* Animation for the spinner */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }

        /* Ensure the modal is on top of everything */
        .z-50 {
            z-index: 50;
        }
    </style>
@endsection
