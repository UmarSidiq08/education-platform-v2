@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="main-container">
            <!-- Main Content -->
            <div class="content-column">
                <div class="material-card">
                    <!-- Header -->
                    <div class="material-header">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('classes.show', $material->class->id) }}">
                                        <i class="fas fa-arrow-left me-2"></i>{{ $material->class->name }}
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">{{ $material->title }}</li>
                            </ol>
                        </nav>

                        <h1 class="material-title">{{ $material->title }}</h1>

                        <div class="material-meta">
                            <span class="meta-item">
                                <i class="fas fa-calendar text-muted me-1"></i>
                                {{ $material->created_at->format('d M Y') }}
                            </span>
                            <span class="meta-item">
                                <i class="fas fa-user text-muted me-1"></i>
                                {{ $material->class->mentor->name }}
                            </span>
                            @if ($material->is_published)
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle me-1"></i>Published
                                </span>
                            @else
                                <span class="badge bg-warning">
                                    <i class="fas fa-clock me-1"></i>Draft
                                </span>
                            @endif
                        </div>

                        @if ($material->description)
                            <div class="material-description">
                                <p>{{ $material->description }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Video Section -->
                    @if ($material->hasVideo())
                        <div class="video-section">
                            <div class="video-container">
                                @if ($material->getVideoType() === 'file')
                                    <video controls poster="{{ $material->video_thumbnail_url }}" class="video-player">
                                        <source src="{{ $material->video_url_for_display }}" type="video/mp4">
                                        Browser tidak mendukung pemutaran video.
                                    </video>
                                @elseif($material->isVideoEmbeddable())
                                    <div class="embed-thumbnail"
                                        style="background-image: url('{{ $material->video_thumbnail_url }}')"
                                        onclick="playEmbeddedVideo(this)">
                                        <div class="play-button">
                                            <i class="fas fa-play-circle"></i>
                                        </div>
                                        <iframe src="{{ $material->video_url }}" frameborder="0" allowfullscreen
                                            class="video-player" style="display: none">
                                        </iframe>
                                    </div>
                                @else
                                    <div class="external-video">
                                        <div class="external-video-content">
                                            <i class="fas fa-play-circle fa-4x text-primary mb-3"></i>
                                            <h4>Video Eksternal</h4>
                                            <p class="text-muted mb-4">Klik untuk menonton video di platform eksternal</p>
                                            <a href="{{ $material->video_url }}" target="_blank"
                                                class="btn btn-primary btn-lg">
                                                <i class="fas fa-external-link-alt me-2"></i>Tonton Video
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Content Section -->
                    <div class="content-section">
                        <h5 class="content-title">
                            <i class="fas fa-file-text text-primary me-2"></i>Materi Pembelajaran
                        </h5>
                        <div class="content-body">
                            {!! nl2br(e($material->content)) !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="sidebar-column">
                <div class="sidebar-content">
                    <!-- Class Info -->
                    <div class="info-card">
                        <div class="card-header">
                            <h6><i class="fas fa-graduation-cap me-2"></i>Informasi Kelas</h6>
                        </div>
                        <div class="card-body">
                            <div class="class-info">
                                <div class="class-avatar">
                                    {{ substr($material->class->name, 0, 2) }}
                                </div>
                                <div class="class-details">
                                    <h6>{{ $material->class->name }}</h6>
                                    <small class="text-muted">Mentor: {{ $material->class->mentor->name }}</small>
                                </div>
                            </div>
                            @if ($material->class->description)
                                <p class="class-description">{{ $material->class->description }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Material Details -->
                    <div class="info-card">
                        <div class="card-header">
                            <h6><i class="fas fa-info-circle me-2"></i>Detail Materi</h6>
                        </div>
                        <div class="card-body">
                            <div class="detail-row">
                                <span class="detail-label">Status:</span>
                                <span class="detail-value">
                                    @if ($material->is_published)
                                        <span class="badge bg-success">Published</span>
                                    @else
                                        <span class="badge bg-warning">Draft</span>
                                    @endif
                                </span>
                            </div>

                            <div class="detail-row">
                                <span class="detail-label">Dibuat:</span>
                                <span class="detail-value">{{ $material->created_at->format('d M Y, H:i') }}</span>
                            </div>

                            @if ($material->updated_at != $material->created_at)
                                <div class="detail-row">
                                    <span class="detail-label">Diperbarui:</span>
                                    <span class="detail-value">{{ $material->updated_at->format('d M Y, H:i') }}</span>
                                </div>
                            @endif

                            @if ($material->hasVideo())
                                <div class="detail-row">
                                    <span class="detail-label">Media:</span>
                                    <span class="detail-value">
                                        <i class="fas fa-video text-primary me-1"></i>
                                        {{ $material->getVideoType() === 'file' ? 'Video File' : 'Video Online' }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Mentor Actions -->
                    @if (auth()->id() === $material->class->mentor_id)
                        <div class="info-card">
                            <div class="card-header">
                                <h6><i class="fas fa-cogs me-2"></i>Aksi Mentor</h6>
                            </div>
                            <div class="card-body">
                                <div class="action-buttons">
                                    <a href="{{ route('materials.edit', $material) }}" class="btn btn-primary">
                                        <i class="fas fa-edit me-2"></i>Edit Materi
                                    </a>

                                    <form action="{{ route('materials.destroy', $material) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus materi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash me-2"></i>Hapus Materi
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Main Layout */
        .page-wrapper {
            min-height: 100vh;
            background: #f8f9fa;
            padding: 2rem 0;
        }

        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 2rem;
        }

        .content-column {
            min-width: 0; /* Prevents overflow */
            overflow-wrap: break-word;
            word-wrap: break-word;
        }

        .sidebar-column {
            min-width: 0;
        }

        /* Material Card */
        .material-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: all 0.3s ease;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .material-card:hover {
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
        }

        /* Header Section */
        .material-header {
            padding: 2.5rem;
            border-bottom: 1px solid #e9ecef;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .breadcrumb {
            background: none;
            padding: 0;
            margin-bottom: 1.5rem;
        }

        .breadcrumb-item a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s ease;
            font-weight: 500;
        }

        .breadcrumb-item a:hover {
            color: white;
        }

        .breadcrumb-item.active {
            color: rgba(255, 255, 255, 0.9);
        }

        .material-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .material-meta {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .meta-item {
            display: flex;
            align-items: center;
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.9);
            background: rgba(255, 255, 255, 0.1);
            padding: 0.5rem 1rem;
            border-radius: 25px;
            backdrop-filter: blur(10px);
        }

        .meta-item i {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        .material-description {
            background: rgba(255, 255, 255, 0.15);
            padding: 1.5rem;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }

        .material-description p {
            margin: 0;
            color: rgba(255, 255, 255, 0.95);
            line-height: 1.6;
        }

        /* Video Section */
        .video-section {
            padding: 2.5rem;
            background: #000;
        }

        .video-container {
            max-width: 100%;
            margin: 0 auto;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 12px 48px rgba(0, 0, 0, 0.5);
        }

        .video-player {
            width: 100%;
            height: auto;
            aspect-ratio: 16/9;
            display: block;
            border-radius: 16px;
        }

        .embed-thumbnail {
            position: relative;
            width: 100%;
            aspect-ratio: 16/9;
            background-size: cover;
            background-position: center;
            cursor: pointer;
            border-radius: 16px;
            overflow: hidden;
        }

        .embed-thumbnail .play-button {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 5rem;
            color: rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
            filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.3));
        }

        .embed-thumbnail:hover .play-button {
            color: white;
            transform: translate(-50%, -50%) scale(1.1);
        }

        .external-video {
            aspect-ratio: 16/9;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 3rem;
            border-radius: 16px;
        }

        .external-video-content h4 {
            color: white;
            margin-bottom: 0.5rem;
        }

        /* Content Section */
        .content-section {
            padding: 2.5rem;
            overflow-wrap: break-word;
            word-wrap: break-word;
        }

        .content-title {
            margin-bottom: 2rem;
            font-weight: 600;
            color: #495057;
            font-size: 1.25rem;
        }

        .content-body {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #495057;
            word-wrap: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
            max-width: 100%;
        }

        .content-body p {
            margin-bottom: 1.5rem;
            word-wrap: break-word;
            overflow-wrap: break-word;
            max-width: 100%;
        }

        .content-body * {
            max-width: 100%;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        /* Handle long URLs and text */
        .content-body a,
        .content-body code,
        .content-body pre {
            word-break: break-all;
            overflow-wrap: break-word;
            hyphens: none;
        }

        .content-body pre {
            white-space: pre-wrap;
            overflow-x: auto;
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }

        .content-body code {
            background: #f8f9fa;
            padding: 0.2em 0.4em;
            border-radius: 4px;
            font-size: 0.9em;
        }

        /* Sidebar */
        .sidebar-content {
            position: sticky;
            top: 2rem;
            max-height: calc(100vh - 4rem);
            overflow-y: auto;
        }

        .info-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            margin-bottom: 1.5rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .info-card:hover {
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
        }

        .info-card .card-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 1px solid #e9ecef;
            padding: 1.25rem 1.5rem;
        }

        .info-card .card-header h6 {
            margin: 0;
            font-weight: 600;
            color: #495057;
        }

        .info-card .card-body {
            padding: 1.5rem;
        }

        /* Class Info */
        .class-info {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .class-avatar {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
            margin-right: 1rem;
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
        }

        .class-details h6 {
            margin-bottom: 0.25rem;
            color: #212529;
            font-weight: 600;
        }

        .class-description {
            font-size: 0.9rem;
            color: #6c757d;
            margin: 0;
            line-height: 1.6;
        }

        /* Detail Rows */
        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #f1f3f4;
        }

        .detail-row:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: #6c757d;
            font-size: 0.9rem;
        }

        .detail-value {
            color: #495057;
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .action-buttons .btn {
            width: 100%;
        }

        /* Buttons */
        .btn {
            border-radius: 12px;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
        }

        /* Badges */
        .badge {
            font-size: 0.8rem;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 600;
        }

        .bg-success {
            background: linear-gradient(135deg, #51cf66 0%, #40c057 100%) !important;
        }

        .bg-warning {
            background: linear-gradient(135deg, #ffd43b 0%, #fab005 100%) !important;
            color: #212529 !important;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .main-container {
                grid-template-columns: 1fr;
                max-width: 800px;
            }

            .sidebar-content {
                position: static;
                max-height: none;
            }
        }

        @media (max-width: 768px) {
            .page-wrapper {
                padding: 1rem 0;
            }

            .main-container {
                padding: 0 0.75rem;
                gap: 1.5rem;
            }

            .material-header {
                padding: 2rem 1.5rem;
            }

            .material-title {
                font-size: 2rem;
            }

            .material-meta {
                gap: 1rem;
                flex-direction: column;
                align-items: flex-start;
            }

            .content-section,
            .video-section {
                padding: 2rem 1.5rem;
            }

            .info-card .card-body {
                padding: 1.25rem;
            }

            .class-info {
                flex-direction: column;
                text-align: center;
            }

            .class-avatar {
                margin-right: 0;
                margin-bottom: 1rem;
            }

            .detail-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .action-buttons {
                gap: 0.5rem;
            }
        }

        @media (max-width: 480px) {
            .material-header {
                padding: 1.5rem 1rem;
            }

            .material-title {
                font-size: 1.75rem;
            }

            .content-section,
            .video-section {
                padding: 1.5rem 1rem;
            }

            .info-card .card-header,
            .info-card .card-body {
                padding: 1rem;
            }

            .meta-item {
                padding: 0.4rem 0.8rem;
                font-size: 0.85rem;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .page-wrapper {
                background: #1a202c;
            }

            .material-card,
            .info-card {
                background: #2d3748;
                color: #e2e8f0;
            }

            .info-card .card-header {
                background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
                border-color: #4a5568;
            }

            .content-body,
            .detail-value,
            .class-description {
                color: #e2e8f0;
            }

            .detail-row {
                border-color: #4a5568;
            }

            .detail-label {
                color: #a0aec0;
            }
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Loading animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .material-card,
        .info-card {
            animation: fadeIn 0.6s ease-out;
        }

        .info-card:nth-child(2) {
            animation-delay: 0.1s;
        }

        .info-card:nth-child(3) {
            animation-delay: 0.2s;
        }

        .info-card:nth-child(4) {
            animation-delay: 0.3s;
        }
    </style>

    @push('scripts')
        <script>
            function playEmbeddedVideo(element) {
                const iframe = element.querySelector('iframe');
                const playButton = element.querySelector('.play-button');

                playButton.style.display = 'none';
                element.style.backgroundImage = 'none';
                iframe.style.display = 'block';

                // Auto-play untuk YouTube/Vimeo
                if (iframe.src.includes('youtube.com') || iframe.src.includes('vimeo.com')) {
                    iframe.src += "&autoplay=1";
                }
            }

            // Smooth scroll untuk breadcrumb navigation
            document.addEventListener('DOMContentLoaded', function() {
                const breadcrumbLinks = document.querySelectorAll('.breadcrumb-item a');
                breadcrumbLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        if (this.getAttribute('href').startsWith('#')) {
                            e.preventDefault();
                            const target = document.querySelector(this.getAttribute('href'));
                            if (target) {
                                target.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'start'
                                });
                            }
                        }
                    });
                });

                // Lazy loading untuk video thumbnails
                const embedThumbnails = document.querySelectorAll('.embed-thumbnail');
                const imageObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const thumbnail = entry.target;
                            const bgImage = thumbnail.style.backgroundImage;
                            if (bgImage) {
                                const img = new Image();
                                img.onload = () => {
                                    thumbnail.style.backgroundImage = bgImage;
                                };
                                img.src = bgImage.slice(4, -1).replace(/"/g, "");
                            }
                            imageObserver.unobserve(thumbnail);
                        }
                    });
                });

                embedThumbnails.forEach(thumbnail => {
                    imageObserver.observe(thumbnail);
                });
            });
        </script>
        
    @endpush
@endsection
