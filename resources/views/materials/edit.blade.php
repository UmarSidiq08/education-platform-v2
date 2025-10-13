@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8 font-sans">
        <!-- Header Section -->
        <div class="relative mb-8 sm:mb-12 p-4 sm:p-6 lg:p-8 bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl text-white overflow-hidden text-center sm:text-left">
            <div class="relative z-10">
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold mb-2">Edit Learning Material</h1>
                <p class="text-base sm:text-lg opacity-90 mb-4">Update your educational content</p>
                <div class="inline-block py-2 px-4 bg-white bg-opacity-20 rounded-full text-sm font-semibold max-w-xs sm:max-w-sm overflow-hidden text-ellipsis whitespace-nowrap">
                    {{ $material->title }}
                </div>
            </div>

            <!-- Header Decoration - Hidden on mobile -->
            <div class="absolute inset-0 overflow-hidden hidden sm:block">
                <div class="absolute w-32 h-32 sm:w-48 sm:h-48 bg-white bg-opacity-10 rounded-full -top-8 -right-8 sm:-top-12 sm:-right-12"></div>
                <div class="absolute w-24 h-24 sm:w-36 sm:h-36 bg-white bg-opacity-10 rounded-full top-1/2 right-16 sm:right-24"></div>
                <div class="absolute w-16 h-16 sm:w-24 sm:h-24 bg-white bg-opacity-10 rounded-full -bottom-4 right-32 sm:-bottom-8 sm:right-48"></div>
            </div>
        </div>

        <!-- Card Container -->
        <div class="relative -mt-6 sm:-mt-12 z-10">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <!-- Card Header -->
                <div class="px-4 sm:px-8 lg:px-16 py-4 sm:py-6 lg:py-8 bg-gray-50 border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                        <div>
                            <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-1">Update Material Details</h2>
                            <p class="text-sm text-gray-600">Modify your learning content</p>
                        </div>
                        <a href="{{ route('materials.show', $material) }}"
                           class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 hover:-translate-y-0.5 transition-all duration-300 self-start">
                            <i class="fas fa-arrow-left"></i> <span class="hidden sm:inline">Back to Material</span><span class="sm:hidden">Back</span>
                        </a>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="px-4 sm:px-8 lg:px-16 py-6 sm:py-8 lg:py-12">
                    <!-- Error & Success Messages -->
                    @if ($errors->any())
                        <div class="flex gap-3 sm:gap-4 p-3 sm:p-4 mb-4 sm:mb-6 bg-red-50 border-l-4 border-red-400 rounded">
                            <div class="text-red-500 text-lg flex-shrink-0">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-red-700 font-medium mb-2 text-sm sm:text-base">Please fix the following issues:</h4>
                                <ul class="text-red-700 list-disc pl-5 text-sm">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="flex gap-3 sm:gap-4 p-3 sm:p-4 mb-4 sm:mb-6 bg-green-50 border-l-4 border-green-400 rounded">
                            <div class="text-green-600 text-lg flex-shrink-0">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-green-700 font-medium mb-1 text-sm sm:text-base">Success!</h4>
                                <p class="text-green-700 m-0 text-sm">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('materials.update', $material) }}" method="POST" enctype="multipart/form-data"
                          id="materialForm" class="flex flex-col gap-4 sm:gap-6">
                        @csrf
                        @method('PUT')

                        <!-- Form Layout -->
                        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 sm:gap-8 lg:gap-16">
                            <!-- Left Column - Main Content -->
                            <div class="xl:col-span-2 flex flex-col gap-4 sm:gap-6 order-2 xl:order-1">
                                <!-- Title -->
                                <div class="flex flex-col gap-2">
                                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1 sm:gap-0">
                                        <label for="title" class="text-base font-semibold text-slate-800">Material Title</label>
                                        <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded self-start sm:self-center">Required</span>
                                    </div>
                                    <div class="relative">
                                        <i class="fas fa-heading absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400"></i>
                                        <input type="text"
                                               class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-lg text-base focus:border-amber-500 focus:ring-3 focus:ring-amber-200 transition-all duration-300 @error('title') border-red-500 @enderror"
                                               id="title"
                                               name="title"
                                               value="{{ old('title', $material->title) }}"
                                               required
                                               placeholder="Enter an engaging material title">
                                    </div>
                                    @error('title')
                                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="flex flex-col gap-2">
                                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1 sm:gap-0">
                                        <label for="description" class="text-base font-semibold text-slate-800">Short Description</label>
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded self-start sm:self-center">Optional</span>
                                    </div>
                                    <div class="relative">
                                        <i class="fas fa-align-left absolute left-4 top-5 text-slate-400"></i>
                                        <textarea class="w-full pl-10 pr-4 py-3 border border-slate-200 rounded-lg text-base focus:border-amber-500 focus:ring-3 focus:ring-amber-200 transition-all duration-300 resize-vertical @error('description') border-red-500 @enderror"
                                                  id="description"
                                                  name="description"
                                                  rows="3"
                                                  placeholder="Provide a brief description of this material...">{{ old('description', $material->description) }}</textarea>
                                    </div>
                                    @error('description')
                                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Content with Rich Text Editor -->
                                <div class="flex flex-col gap-2">
                                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1 sm:gap-0">
                                        <label for="content" class="text-base font-semibold text-slate-800">Material Content</label>
                                        <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded self-start sm:self-center">Required</span>
                                    </div>
                                    <div class="border-2 border-slate-200 rounded-xl overflow-hidden transition-all duration-300 focus-within:border-amber-500 focus-within:ring-4 focus-within:ring-amber-200">
                                        <div id="quill-editor" style="height: 400px;">{!! old('content', $material->content) !!}</div>
                                        <textarea name="content" id="content" class="hidden" required>{{ old('content', $material->content) }}</textarea>
                                    </div>
                                    @error('content')
                                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                    <div class="flex items-center gap-2 mt-2 text-sm text-slate-600">
                                        <i class="fas fa-lightbulb text-amber-500"></i>
                                        <span>Tip: Use the toolbar above to format your content with headings, bold text, lists, and more</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column - Media & Settings -->
                            <div class="flex flex-col gap-4 sm:gap-6 order-1 xl:order-2">
                                <!-- Current Video Display -->
                                @if($material->hasVideo())
                                    <div class="bg-slate-50 border border-slate-200 rounded-xl overflow-hidden transition-all duration-300" id="currentVideoCard">
                                        <div class="flex items-center gap-3 px-4 py-3 bg-white border-b border-slate-200">
                                            <i class="fas fa-play-circle text-amber-500 text-lg"></i>
                                            <h3 class="text-base font-semibold text-slate-800">Current Video</h3>
                                        </div>

                                        <div class="p-4">
                                            @if($material->getVideoType() === 'file')
                                                <div class="relative w-full rounded-lg overflow-hidden mb-3">
                                                    <video controls class="w-full h-auto rounded-lg">
                                                        <source src="{{ $material->video_url_for_display }}" type="video/mp4">
                                                    </video>
                                                </div>
                                                <div class="mb-4">
                                                    <span class="text-slate-600 bg-slate-200 px-2 py-1 rounded text-sm font-mono">{{ basename($material->video_path) }}</span>
                                                </div>
                                            @else
                                                <div class="flex gap-3 p-4 bg-teal-50 rounded-lg mb-4">
                                                    <i class="fas fa-external-link-alt text-cyan-600 mt-1"></i>
                                                    <div class="flex-1">
                                                        <strong class="block text-teal-800 mb-1">Video URL:</strong>
                                                        <a href="{{ $material->video_url }}" target="_blank"
                                                           class="text-cyan-600 no-underline break-all hover:underline">
                                                            {{ Str::limit($material->video_url, 40) }}
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="mt-4 pt-4 border-t border-slate-200">
                                                <div class="relative">
                                                    <input type="checkbox" class="absolute opacity-0 w-0 h-0" id="remove_video" name="remove_video" value="1">
                                                    <label class="flex items-start gap-3 cursor-pointer p-3 rounded-lg transition-all duration-300 hover:bg-red-50" for="remove_video">
                                                        <div class="w-5 h-5 border-2 border-slate-300 rounded flex-shrink-0 mt-0.5 transition-all duration-300 checkbox-custom"></div>
                                                        <div class="flex-1">
                                                            <strong class="block text-slate-800 mb-1">Remove this video</strong>
                                                            <small class="text-slate-600">This will delete the current video</small>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Video Section -->
                                <div class="bg-slate-50 border border-slate-200 rounded-xl overflow-hidden">
                                    <div class="flex items-center gap-3 px-4 py-3 bg-white border-b border-slate-200">
                                        <i class="fas fa-video text-cyan-600 text-lg"></i>
                                        <h3 class="text-base font-semibold text-slate-800">{{ $material->hasVideo() ? 'Replace Video' : 'Add Video' }} Media</h3>
                                    </div>
                                    <div class="p-4">
                                        <!-- Video Upload Option -->
                                        <div class="mb-4">
                                            <label class="text-sm font-semibold text-slate-800 mb-2 block">Upload Video File</label>
                                            <div class="relative border-2 border-dashed border-slate-300 rounded-lg p-4 text-center cursor-pointer hover:border-amber-600 hover:bg-slate-50 transition-all duration-300">
                                                <input type="file"
                                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer @error('video') border-red-500 @enderror"
                                                    id="video" name="video" accept="video/*"
                                                    onchange="handleVideoUpload(this)">
                                                <div class="flex flex-col items-center gap-2 text-slate-600">
                                                    <i class="fas fa-cloud-upload-alt text-2xl text-amber-600"></i>
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
                                            <label for="video_url" class="text-sm font-semibold text-slate-800 mb-2 block">Online Video Link</label>
                                            <div class="relative">
                                                <i class="fas fa-link absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400"></i>
                                                <input type="url"
                                                    class="w-full pl-10 pr-3 py-2 border border-slate-200 rounded-lg text-sm focus:border-amber-600 focus:ring-2 focus:ring-amber-200 transition-all duration-300 @error('video_url') border-red-500 @enderror"
                                                    id="video_url" name="video_url" value="{{ old('video_url', $material->video_url) }}"
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
                                                <strong>New video selected:</strong>
                                                <div id="videoInfo"></div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="video_thumbnail" class="text-sm font-semibold text-slate-800 mb-2 block">Thumbnail Video</label>
                                            <input type="file" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100"
                                                   id="video_thumbnail" name="video_thumbnail">
                                            @if (isset($material) && $material->video_thumbnail)
                                                <img src="{{ $material->video_thumbnail_url }}" width="100" class="mt-2 rounded-lg">
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
                                                    {{ old('is_published', $material->is_published) ? 'checked' : '' }}>
                                                <label class="flex items-start gap-3 cursor-pointer p-3 rounded-lg hover:bg-green-50 transition-all duration-300" for="is_published">
                                                    <div class="w-5 h-5 border-2 border-slate-300 rounded mt-0.5 flex-shrink-0 transition-all duration-300 peer-checked:bg-emerald-600 peer-checked:border-emerald-600 relative">
                                                        <i class="fas fa-check text-white text-xs absolute top-0.5 left-0.5 opacity-0 peer-checked:opacity-100 transition-opacity duration-300"></i>
                                                    </div>
                                                    <div>
                                                        <strong class="block text-slate-800 mb-1">Publish Material</strong>
                                                        <small class="text-slate-600">Material will be visible to students</small>
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
                                    <button type="submit" class="inline-flex items-center justify-center gap-2 w-full px-6 py-3 bg-gradient-to-r from-amber-500 to-amber-600 text-white font-semibold rounded-lg hover:-translate-y-0.5 hover:shadow-lg hover:shadow-amber-500/40 transition-all duration-300">
                                        <i class="fas fa-save"></i> Update Material
                                    </button>
                                    <a href="{{ route('materials.show', $material) }}" class="inline-flex items-center justify-center gap-2 w-full px-6 py-3 bg-white text-slate-600 font-medium border border-slate-200 rounded-lg hover:bg-slate-50 hover:-translate-y-0.5 transition-all duration-300 no-underline">
                                        <i class="fas fa-times"></i> Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
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
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    [{ 'font': [] }],
                    [{ 'size': ['small', false, 'large', 'huge'] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'script': 'sub'}, { 'script': 'super' }],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                    [{ 'direction': 'rtl' }],
                    [{ 'align': [] }],
                    ['blockquote', 'code-block'],
                    ['link', 'image', 'video'],
                    ['clean']
                ]
            },
            placeholder: 'Write your material content here. Use the toolbar to format your text...'
        });

        // Sync Quill content with hidden textare

        // Set initial content if exists
        if (document.getElementById('content').value) {
            quill.root.innerHTML = document.getElementById('content').value;
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

        // Handle remove video checkbox
        document.getElementById('remove_video')?.addEventListener('change', function() {
            const videoInput = document.getElementById('video');
            const videoUrlInput = document.getElementById('video_url');
            const currentVideoCard = document.getElementById('currentVideoCard');

            if (this.checked) {
                videoInput.disabled = true;
                videoUrlInput.disabled = true;
                videoInput.value = '';
                videoUrlInput.value = '';
                document.getElementById('videoPreview').classList.add('hidden');

                // Visual feedback
                if (currentVideoCard) {
                    currentVideoCard.style.opacity = '0.5';
                    currentVideoCard.style.filter = 'grayscale(100%)';
                }
            } else {
                videoInput.disabled = false;
                videoUrlInput.disabled = false;

                // Remove visual feedback
                if (currentVideoCard) {
                    currentVideoCard.style.opacity = '1';
                    currentVideoCard.style.filter = 'none';
                }
            }
        });

        // Form validation
        document.getElementById('materialForm').addEventListener('submit', function(e) {
            const title = document.getElementById('title').value.trim();
            const content = quill.getText().trim(); // Get text content from Quill

            if (!title || !content) {
                e.preventDefault();
                alert('Title and content are required!');
                return false;
            }

            // Ensure hidden textarea has the latest content
            document.getElementById('content').value = quill.root.innerHTML;
        });

        // Custom checkbox styling with JavaScript
        document.getElementById('is_published').addEventListener('change', function() {
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

        // Custom checkbox styling for remove video
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                const updateCheckbox = () => {
                    const customCheckbox = checkbox.parentNode.querySelector('.checkbox-custom');
                    if (customCheckbox) {
                        if (checkbox.checked) {
                            customCheckbox.classList.add('bg-red-500', 'border-red-500');
                            customCheckbox.classList.remove('border-slate-300');
                            customCheckbox.innerHTML = '<svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>';
                        } else {
                            customCheckbox.classList.remove('bg-red-500', 'border-red-500');
                            customCheckbox.classList.add('border-slate-300');
                            customCheckbox.innerHTML = '';
                        }
                    }
                };

                checkbox.addEventListener('change', updateCheckbox);
                updateCheckbox(); // Initial state
            });
        });
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
            color: #f59e0b !important;
        }

        .ql-snow.ql-toolbar .ql-stroke.ql-fill,
        .ql-snow .ql-toolbar .ql-stroke.ql-fill {
            fill: #f59e0b !important;
        }

        .ql-snow.ql-toolbar .ql-stroke,
        .ql-snow .ql-toolbar .ql-stroke {
            stroke: #f59e0b !important;
        }

        /* Hide default checkbox appearance and use custom styling */
        input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
        }

        .checkbox-custom {
            display: flex;
            align-items: center;
            justify-content: center;
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

        @media (max-width: 768px) {
            .xl\:grid-cols-3 {
                grid-template-columns: 1fr;
            }

            .xl\:col-span-2 {
                grid-column: span 1;
            }

            .xl\:order-1 {
                order: 2;
            }

            .xl\:order-2 {
                order: 1;
            }

            .px-16 {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }

            .py-12 {
                padding-top: 1.5rem;
                padding-bottom: 1.5rem;
            }

            .py-8 {
                padding-top: 1.5rem;
                padding-bottom: 1.5rem;
            }

            .text-4xl {
                font-size: 2rem;
            }

            .-mt-12 {
                margin-top: -2rem;
            }

            .gap-16 {
                gap: 1.5rem;
            }
        }
    </style>
@endsection
