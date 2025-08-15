@extends('layouts.app')

@section('content')
    <div class="material-creation-container">
        <div class="creation-header">
            <div class="header-content">
                <h1 class="creation-title">Edit Learning Material</h1>
                <p class="creation-subtitle">Update your educational content</p>
                <div class="material-badge">{{ $material->title }}</div>
            </div>
            <div class="header-decoration">
                <div class="deco-circle deco-1"></div>
                <div class="deco-circle deco-2"></div>
                <div class="deco-circle deco-3"></div>
            </div>
        </div>

        <div class="creation-card-container">
            <div class="creation-card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="card-title">Update Material Details</h2>
                            <p class="card-subtitle">Modify your learning content</p>
                        </div>
                        <a href="{{ route('materials.show', $material) }}" class="btn-back">
                            <i class="fas fa-arrow-left"></i> Back to Material
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Error & Success Messages -->
                    @if ($errors->any())
                        <div class="alert-message">
                            <div class="alert-icon">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <div class="alert-content">
                                <h4>Please fix the following issues:</h4>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="success-message">
                            <div class="success-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="success-content">
                                <h4>Success!</h4>
                                <p>{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('materials.update', $material) }}" method="POST" enctype="multipart/form-data" id="materialForm" class="creation-form">
                        @csrf
                        @method('PUT')

                        <div class="form-layout">
                            <!-- Left Column - Main Content -->
                            <div class="main-content">
                                <!-- Title -->
                                <div class="form-group">
                                    <div class="form-header">
                                        <label for="title" class="form-label">Material Title</label>
                                        <span class="required-badge">Required</span>
                                    </div>
                                    <div class="input-with-icon">
                                        <i class="fas fa-heading"></i>
                                        <input type="text"
                                               class="form-control @error('title') is-invalid @enderror"
                                               id="title"
                                               name="title"
                                               value="{{ old('title', $material->title) }}"
                                               required
                                               placeholder="Enter an engaging material title">
                                    </div>
                                    @error('title')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <div class="form-header">
                                        <label for="description" class="form-label">Short Description</label>
                                        <span class="optional-badge">Optional</span>
                                    </div>
                                    <div class="textarea-with-icon">
                                        <i class="fas fa-align-left"></i>
                                        <textarea class="form-control @error('description') is-invalid @enderror"
                                                  id="description"
                                                  name="description"
                                                  rows="3"
                                                  placeholder="Provide a brief description of this material...">{{ old('description', $material->description) }}</textarea>
                                    </div>
                                    @error('description')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Content -->
                                <div class="form-group">
                                    <div class="form-header">
                                        <label for="content" class="form-label">Material Content</label>
                                        <span class="required-badge">Required</span>
                                    </div>
                                    <div class="textarea-with-icon content-textarea">
                                        <i class="fas fa-file-text"></i>
                                        <textarea class="form-control @error('content') is-invalid @enderror"
                                                  id="content"
                                                  name="content"
                                                  rows="12"
                                                  required
                                                  placeholder="Write your material content here...">{{ old('content', $material->content) }}</textarea>
                                    </div>
                                    @error('content')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                    <div class="form-hint">
                                        <i class="fas fa-lightbulb"></i> Tip: Use clear headings and examples to make content engaging
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column - Media & Settings -->
                            <div class="sidebar-content">
                                <!-- Current Video Display -->
                                @if($material->hasVideo())
                                    <div class="settings-card current-video-card">
                                        <div class="settings-header">
                                            <i class="fas fa-play-circle"></i>
                                            <h3>Current Video</h3>
                                        </div>
                                        
                                        <div class="settings-body">
                                            @if($material->getVideoType() === 'file')
                                                <div class="video-container">
                                                    <video controls class="current-video">
                                                        <source src="{{ $material->video_url_for_display }}" type="video/mp4">
                                                    </video>
                                                </div>
                                                <div class="video-info">
                                                    <small class="video-filename">{{ basename($material->video_path) }}</small>
                                                </div>
                                            @else
                                                <div class="video-url-display">
                                                    <i class="fas fa-external-link-alt"></i>
                                                    <div class="url-content">
                                                        <strong>Video URL:</strong>
                                                        <a href="{{ $material->video_url }}" target="_blank" class="video-link">
                                                            {{ Str::limit($material->video_url, 40) }}
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="remove-option">
                                                <div class="custom-checkbox danger">
                                                    <input type="checkbox" class="checkbox-input" id="remove_video" name="remove_video" value="1">
                                                    <label class="checkbox-label" for="remove_video">
                                                        <div class="checkbox-content">
                                                            <strong>Remove this video</strong>
                                                            <small>This will delete the current video</small>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Video Section -->
                                <div class="settings-card video-card">
                                    <div class="settings-header">
                                        <i class="fas fa-video"></i>
                                        <h3>{{ $material->hasVideo() ? 'Replace Video' : 'Add Video' }}</h3>
                                    </div>
                                    <div class="settings-body">
                                        <!-- Video Upload Option -->
                                        <div class="form-group">
                                            <label class="form-label-small">Upload Video File</label>
                                            <div class="file-upload-area">
                                                <input type="file"
                                                       class="form-control-file @error('video') is-invalid @enderror"
                                                       id="video"
                                                       name="video"
                                                       accept="video/*"
                                                       onchange="handleVideoUpload(this)">
                                                <div class="file-upload-text">
                                                    <i class="fas fa-cloud-upload-alt"></i>
                                                    <span>Choose video file</span>
                                                </div>
                                            </div>
                                            <div class="form-hint-small">
                                                Format: MP4, MOV, AVI, WMV, FLV, WebM<br>
                                                Maximum: 100MB
                                            </div>
                                            @error('video')
                                                <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="divider">
                                            <span>OR</span>
                                        </div>

                                        <!-- Video URL Option -->
                                        <div class="form-group">
                                            <label for="video_url" class="form-label-small">Online Video Link</label>
                                            <div class="input-with-icon-small">
                                                <i class="fas fa-link"></i>
                                                <input type="url"
                                                       class="form-control @error('video_url') is-invalid @enderror"
                                                       id="video_url"
                                                       name="video_url"
                                                       value="{{ old('video_url', $material->video_url) }}"
                                                       placeholder="https://youtube.com/watch?v=..."
                                                       onchange="handleVideoUrl(this)">
                                            </div>
                                            <div class="form-hint-small">
                                                Supports YouTube , Vimeo, etc.
                                            </div>
                                            @error('video_url')
                                                <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Video Preview -->
                                        <div id="videoPreview" class="video-preview d-none">
                                            <div class="preview-content">
                                                <i class="fas fa-check-circle"></i>
                                                <strong>New video selected:</strong>
                                                <div id="videoInfo"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Publishing Settings -->
                                <div class="settings-card publish-card">
                                    <div class="settings-header">
                                        <i class="fas fa-cog"></i>
                                        <h3>Publishing Settings</h3>
                                    </div>
                                    <div class="settings-body">
                                        <div class="publish-option">
                                            <input type="hidden" name="is_published" value="0">
                                            <div class="custom-checkbox">
                                                <input type="checkbox"
                                                       class="checkbox-input @error('is_published') is-invalid @enderror"
                                                       id="is_published"
                                                       name="is_published"
                                                       value="1"
                                                       {{ old('is_published', $material->is_published) ? 'checked' : '' }}>
                                                <label class="checkbox-label" for="is_published">
                                                    <div class="checkbox-content">
                                                        <strong>Publish Material</strong>
                                                        <small>Material will be visible to students</small>
                                                    </div>
                                                </label>
                                            </div>
                                            @error('is_published')
                                                <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="form-actions">
                                    <button type="submit" class="btn-update">
                                        <i class="fas fa-save"></i> Update Material
                                    </button>
                                    <a href="{{ route('materials.show', $material) }}" class="btn-cancel">
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

    <!-- JavaScript for enhanced UX -->
    <script>
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
                videoPreview.classList.remove('d-none');

                // Clear video URL if file is selected
                videoUrlInput.value = '';
            } else {
                videoPreview.classList.add('d-none');
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
                videoPreview.classList.remove('d-none');

                // Clear file input if URL is entered
                videoFileInput.value = '';
            } else {
                videoPreview.classList.add('d-none');
            }
        }

        // Handle remove video checkbox
        document.getElementById('remove_video')?.addEventListener('change', function() {
            const videoInput = document.getElementById('video');
            const videoUrlInput = document.getElementById('video_url');
            const currentVideoCard = document.querySelector('.current-video-card');

            if (this.checked) {
                videoInput.disabled = true;
                videoUrlInput.disabled = true;
                videoInput.value = '';
                videoUrlInput.value = '';
                document.getElementById('videoPreview').classList.add('d-none');

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
            const content = document.getElementById('content').value.trim();

            if (!title || !content) {
                e.preventDefault();
                alert('Title and content are required!');
                return false;
            }
        });

        // Auto-resize textarea
        document.getElementById('content').addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    </script>

    <style>
        /* Base Styles */
        .material-creation-container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 2rem 2rem;
            font-family: 'Figtree', sans-serif;
        }

        /* Header Section */
        .creation-header {
            position: relative;
            margin-bottom: 3rem;
            padding: 2rem;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            border-radius: 16px;
            color: white;
            overflow: hidden;
        }

        .header-content {
            position: relative;
            z-index: 2;
        }

        .creation-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .creation-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 1rem;
        }

        .material-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .header-decoration {
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .deco-circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }

        .deco-1 {
            width: 200px;
            height: 200px;
            top: -50px;
            right: -50px;
        }

        .deco-2 {
            width: 150px;
            height: 150px;
            top: 50%;
            right: 100px;
        }

        .deco-3 {
            width: 100px;
            height: 100px;
            bottom: -30px;
            right: 200px;
        }

        /* Card Container */
        .creation-card-container {
            position: relative;
            margin-top: -50px;
            z-index: 10;
        }

        .creation-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-header {
            padding: 2rem 4rem;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 0.25rem;
        }

        .card-subtitle {
            font-size: 0.9rem;
            color: #718096;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            color: #4a5568;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background: #edf2f7;
            transform: translateY(-2px);
        }

        /* Card Body */
        .card-body {
            padding: 3rem 4rem;
        }

        /* Alert Messages */
        .alert-message {
            display: flex;
            gap: 1rem;
            padding: 1rem;
            background: #fff5f5;
            border-left: 4px solid #fc8181;
            border-radius: 4px;
            margin-bottom: 1.5rem;
        }

        .alert-icon {
            color: #e53e3e;
            font-size: 1.2rem;
        }

        .alert-content h4 {
            font-size: 1rem;
            color: #e53e3e;
            margin-bottom: 0.5rem;
        }

        .alert-content ul {
            margin: 0;
            padding-left: 1.2rem;
            color: #e53e3e;
        }

        .success-message {
            display: flex;
            gap: 1rem;
            padding: 1rem;
            background: #f0fff4;
            border-left: 4px solid #68d391;
            border-radius: 4px;
            margin-bottom: 1.5rem;
        }

        .success-icon {
            color: #38a169;
            font-size: 1.2rem;
        }

        .success-content h4 {
            font-size: 1rem;
            color: #38a169;
            margin-bottom: 0.25rem;
        }

        .success-content p {
            color: #38a169;
            margin: 0;
        }

        /* Form Layout */
        .creation-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .form-layout {
            display: grid;
            grid-template-columns: 1fr 450px;
            gap: 4rem;
        }

        .main-content {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .sidebar-content {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        /* Form Groups */
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form-label {
            font-weight: 600;
            color: #2d3748;
            font-size: 0.95rem;
        }

        .form-label-small {
            font-weight: 600;
            color: #2d3748;
            font-size: 0.85rem;
        }

        .required-badge {
            background: #fed7d7;
            color: #e53e3e;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .optional-badge {
            background: #ebf8ff;
            color: #3182ce;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Input Styles */
        .input-with-icon,
        .textarea-with-icon,
        .input-with-icon-small {
            position: relative;
        }

        .input-with-icon i,
        .textarea-with-icon i,
        .input-with-icon-small i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            z-index: 2;
        }

        .textarea-with-icon i {
            top: 1.25rem;
            transform: none;
        }

        .content-textarea i {
            top: 1rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.2);
            outline: none;
        }

        textarea.form-control {
            min-height: 120px;
            padding-top: 1rem;
            resize: vertical;
        }

        #content {
            min-height: 300px;
        }

        .error-message {
            color: #e53e3e;
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }

        .form-hint {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            color: #718096;
            margin-top: 0.5rem;
        }

        .form-hint i {
            color: #f6ad55;
        }

        .form-hint-small {
            font-size: 0.8rem;
            color: #718096;
            margin-top: 0.25rem;
        }

        /* Settings Cards */
        .settings-card {
            background: #f7fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .settings-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            background: white;
            border-bottom: 1px solid #e2e8f0;
        }

        .settings-header i {
            color: #4f46e5;
            font-size: 1.1rem;
        }

        .current-video-card .settings-header i {
            color: #f59e0b;
        }

        .video-card .settings-header i {
            color: #06b6d4;
        }

        .publish-card .settings-header i {
            color: #10b981;
        }

        .settings-header h3 {
            font-size: 1rem;
            font-weight: 600;
            color: #2d3748;
            margin: 0;
        }

        .settings-body {
            padding: 1rem;
        }

        /* Current Video Styles */
        .video-container {
            position: relative;
            width: 100%;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 0.75rem;
        }

        .current-video {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .video-info {
            margin-bottom: 1rem;
        }

        .video-filename {
            color: #718096;
            background: #edf2f7;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-family: 'Monaco', 'Consolas', monospace;
        }

        .video-url-display {
            display: flex;
            gap: 0.75rem;
            padding: 1rem;
            background: #e6fffa;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .video-url-display i {
            color: #0891b2;
            margin-top: 0.2rem;
        }

        .url-content strong {
            display: block;
            color: #0f766e;
            margin-bottom: 0.25rem;
        }

        .video-link {
            color: #0891b2;
            text-decoration: none;
            word-break: break-all;
        }

        .video-link:hover {
            text-decoration: underline;
        }

        .remove-option {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
        }

        /* File Upload */
        .file-upload-area {
            position: relative;
            border: 2px dashed #cbd5e0;
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .file-upload-area:hover {
            border-color: #f59e0b;
            background: #f7fafc;
        }

        .form-control-file {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .file-upload-text {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            color: #718096;
        }

        .file-upload-text i {
            font-size: 1.5rem;
            color: #f59e0b;
        }

        /* Divider */
        .divider {
            text-align: center;
            position: relative;
            margin: 1rem 0;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e2e8f0;
        }

        .divider span {
            background: #f7fafc;
            padding: 0 0.75rem;
            color: #718096;
            font-size: 0.8rem;
            font-weight: 500;
        }

        /* Video Preview */
        .video-preview {
            margin-top: 1rem;
            padding: 0.75rem;
            background: #e6fffa;
            border-radius: 6px;
        }

        .preview-content {
            font-size: 0.85rem;
            color: #285e61;
        }

        .preview-content i {
            color: #38b2ac;
            margin-right: 0.5rem;
        }

        /* Custom Checkbox */
        .custom-checkbox {
            position: relative;
        }

        .checkbox-input {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .checkbox-label {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            cursor: pointer;
            padding: 0.75rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .checkbox-label::before {
            content: '';
            width: 20px;
            height: 20px;
            border: 2px solid #cbd5e0;
            border-radius: 4px;
            flex-shrink: 0;
            transition: all 0.3s ease;
            margin-top: 0.1rem;
        }

        .checkbox-input:checked + .checkbox-label::before {
            background: #10b981;
            border-color: #10b981;
        }

        .checkbox-input:checked + .checkbox-label::after {
            content: '✓';
            position: absolute;
            left: 0.85rem;
            top: 0.85rem;
            color: white;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .checkbox-label:hover {
            background: #f0fff4;
        }

        .checkbox-content strong {
            display: block;
            color: #2d3748;
            margin-bottom: 0.25rem;
        }

        .checkbox-content small {
            color: #718096;
        }

        /* Action Buttons */
        .form-actions {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .btn-update {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(245, 158, 11, 0.4);
        }

        .btn-cancel {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            padding: 0.75rem 1.5rem;
            background: white;
            color: #4a5568;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background: #f7fafc;
            transform: translateY(-2px);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .form-layout {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .sidebar-content {
                order: -1;
            }
        }

        @media (max-width: 768px) {
            .material-creation-container {
                padding: 1rem;
            }

            .creation-header {
                padding: 1.5rem;
                text-align: center;
            }

            .creation-title {
                font-size: 2rem;
            }

            .creation-card-container {
                margin-top: -30px;
            }

            .card-header .d-flex {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .card-body {
                padding: 1.5rem;
            }

            .card-header {
                padding: 1.5rem;
            }

            .settings-card {
                margin-bottom: 1rem;
            }
        }
    </style>
@endsection
