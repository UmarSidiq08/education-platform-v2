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

                <!-- Enhanced Quiz Section -->
                @if ($material->activeQuiz)
                    <div class="quiz-section">
                        <div class="quiz-card">
                            <div class="quiz-header">
                                <div class="quiz-icon">
                                    <i class="fas fa-brain"></i>
                                </div>
                                <div class="quiz-header-content">
                                    <h3 class="quiz-title">{{ $material->activeQuiz->title }}</h3>
                                    @if ($material->activeQuiz->description)
                                        <p class="quiz-description">{{ $material->activeQuiz->description }}</p>
                                    @endif
                                </div>
                                @if (auth()->user()->role === 'siswa' && $quizAttempt)
                                    <div class="quiz-score-badge">
                                        <div class="score-circle">
                                            <span class="score-percentage">{{ $quizAttempt->percentage }}%</span>
                                            <span class="score-label">Skor</span>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="quiz-body">
                                <div class="quiz-stats">
                                    <div class="stat-item">
                                        <div class="stat-icon">
                                            <i class="fas fa-question-circle"></i>
                                        </div>
                                        <div class="stat-content">
                                            <span class="stat-value">{{ $material->activeQuiz->total_questions }}</span>
                                            <span class="stat-label">Soal</span>
                                        </div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="stat-icon">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <div class="stat-content">
                                            <span class="stat-value">{{ $material->activeQuiz->time_limit }}</span>
                                            <span class="stat-label">Menit</span>
                                        </div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="stat-icon">
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <div class="stat-content">
                                            <span class="stat-value">{{ $material->activeQuiz->questions->sum('points') ?? 0 }}</span>
                                            <span class="stat-label">Poin</span>
                                        </div>
                                    </div>
                                </div>

                                @if (auth()->user()->role === 'siswa')
                                    @if ($quizAttempt)
                                        <!-- Sudah mengerjakan - Detail Results -->
                                        <div class="quiz-results">
                                            <div class="results-header">
                                                <h5><i class="fas fa-chart-line me-2"></i>Hasil Quiz Anda</h5>
                                            </div>
                                            <div class="results-grid">
                                                <div class="result-card">
                                                    <div class="result-icon success">
                                                        <i class="fas fa-trophy"></i>
                                                    </div>
                                                    <div class="result-info">
                                                        <span class="result-value">{{ $quizAttempt->score }}</span>
                                                        <span class="result-label">Total Poin</span>
                                                    </div>
                                                </div>
                                                <div class="result-card">
                                                    <div class="result-icon info">
                                                        <i class="fas fa-check-circle"></i>
                                                    </div>
                                                    <div class="result-info">
                                                        <span class="result-value">{{ $quizAttempt->correct_answers }}/{{ $quizAttempt->total_questions }}</span>
                                                        <span class="result-label">Jawaban Benar</span>
                                                    </div>
                                                </div>
                                                <div class="result-card">
                                                    <div class="result-icon {{ $quizAttempt->percentage >= 80 ? 'success' : ($quizAttempt->percentage >= 60 ? 'warning' : 'danger') }}">
                                                        <i class="fas fa-percent"></i>
                                                    </div>
                                                    <div class="result-info">
                                                        <span class="result-value">{{ $quizAttempt->percentage }}%</span>
                                                        <span class="result-label">Persentase</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="quiz-actions">
                                                <a href="{{ route('quizzes.show', $material->activeQuiz) }}" class="btn btn-outline-primary btn-lg">
                                                    <i class="fas fa-eye me-2"></i>Lihat Detail Jawaban
                                                </a>
                                            </div>
                                        </div>
                                    @else
                                        <!-- Belum mengerjakan - Call to Action -->
                                        <div class="quiz-cta">
                                            <div class="cta-content">
                                                <h5>Siap untuk mengerjakan quiz?</h5>
                                                <p>Uji pemahaman Anda tentang materi yang telah dipelajari</p>
                                            </div>
                                            <div class="quiz-actions">
                                                <a href="{{ route('quizzes.show', $material->activeQuiz) }}" class="btn btn-primary btn-lg pulse-animation">
                                                    <i class="fas fa-play me-2"></i>Mulai Quiz Sekarang
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                @endif

                                @if (auth()->user()->role === 'mentor' && auth()->id() === $material->class->mentor_id)
                                    <!-- Mentor Actions -->
                                    <div class="mentor-quiz-actions">
                                        <div class="action-header">
                                            <h5><i class="fas fa-cogs me-2"></i>Kelola Quiz</h5>
                                            <p class="text-muted">Kelola dan pantau quiz untuk materi ini</p>
                                        </div>
                                        <div class="quiz-actions mentor-actions">
                                            <a href="{{ route('quizzes.index', $material) }}" class="btn btn-info btn-lg">
                                                <i class="fas fa-chart-bar me-2"></i>
                                                <span>Lihat Statistik</span>
                                                <small class="d-block">Analisis hasil siswa</small>
                                            </a>
                                            <a href="{{ route('quizzes.create', $material) }}" class="btn btn-warning btn-lg">
                                                <i class="fas fa-edit me-2"></i>
                                                <span>Edit Quiz</span>
                                                <small class="d-block">Ubah soal & pengaturan</small>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @elseif(auth()->user()->role === 'mentor' && auth()->id() === $material->class->mentor_id)
                    <!-- No Quiz - Create New -->
                    <div class="quiz-section">
                        <div class="quiz-empty-state">
                            <div class="empty-state-content">
                                <div class="empty-state-icon">
                                    <i class="fas fa-lightbulb"></i>
                                </div>
                                <h4>Tingkatkan Pembelajaran dengan Quiz</h4>
                                <p>Buat quiz interaktif untuk membantu siswa menguji pemahaman mereka tentang materi ini</p>
                                <div class="empty-state-features">
                                    <div class="feature-item">
                                        <i class="fas fa-check text-success me-2"></i>
                                        <span>Pertanyaan pilihan ganda</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="fas fa-check text-success me-2"></i>
                                        <span>Penilaian otomatis</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="fas fa-check text-success me-2"></i>
                                        <span>Laporan detail</span>
                                    </div>
                                </div>
                                <a href="{{ route('quizzes.create', $material) }}" class="btn btn-primary btn-xl shine-effect">
                                    <i class="fas fa-plus me-2"></i>Buat Quiz Pertama
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
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
            min-width: 0;
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
            margin-bottom: 2rem;
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

        /* Enhanced Quiz Section */
        .quiz-section {
            margin-top: 2rem;
        }

        .quiz-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
            overflow: hidden;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .quiz-card:hover {
            box-shadow: 0 12px 48px rgba(0, 0, 0, 0.15);
            border-color: #667eea;
        }

        .quiz-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 2rem;
            color: white;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .quiz-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(50%, -50%);
        }

        .quiz-icon {
            background: rgba(255, 255, 255, 0.2);
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            flex-shrink: 0;
        }

        .quiz-header-content {
            flex: 1;
        }

        .quiz-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .quiz-description {
            color: rgba(255, 255, 255, 0.9);
            margin: 0;
            font-size: 1rem;
        }

        .quiz-score-badge {
            position: relative;
            z-index: 2;
        }

        .score-circle {
            background: rgba(255, 255, 255, 0.2);
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            border: 3px solid rgba(255, 255, 255, 0.3);
        }

        .score-percentage {
            font-size: 1.25rem;
            font-weight: 800;
            line-height: 1;
        }

        .score-label {
            font-size: 0.7rem;
            opacity: 0.9;
            text-transform: uppercase;
            font-weight: 600;
        }

        .quiz-body {
            padding: 2.5rem;
        }

        .quiz-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.5rem;
            background: #f8f9fa;
            border-radius: 16px;
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            background: #e9ecef;
            transform: translateY(-2px);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .stat-content {
            display: flex;
            flex-direction: column;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #212529;
            line-height: 1;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.85rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Quiz Results */
        .quiz-results {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 16px;
            padding: 2rem;
            border: 1px solid #dee2e6;
        }

        .results-header {
            margin-bottom: 1.5rem;
        }

        .results-header h5 {
            color: #495057;
            font-weight: 600;
            margin: 0;
        }

        .results-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .result-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .result-card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        .result-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: white;
        }

        .result-icon.success {
            background: linear-gradient(135deg, #51cf66 0%, #40c057 100%);
        }

        .result-icon.info {
            background: linear-gradient(135deg, #339af0 0%, #228be6 100%);
        }

        .result-icon.warning {
            background: linear-gradient(135deg, #ffd43b 0%, #fab005 100%);
        }

        .result-icon.danger {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
        }

        .result-info {
            display: flex;
            flex-direction: column;
        }

        .result-value {
            font-size: 1.25rem;
            font-weight: 700;
            color: #212529;
            line-height: 1;
        }

        .result-label {
            color: #6c757d;
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* Quiz Call to Action */
        .quiz-cta {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2.5rem;
            border-radius: 16px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .quiz-cta::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: shimmer 3s ease-in-out infinite;
        }

        @keyframes shimmer {
            0%, 100% {
                transform: rotate(0deg);
            }
            50% {
                transform: rotate(180deg);
            }
        }

        .cta-content {
            position: relative;
            z-index: 2;
            margin-bottom: 2rem;
        }

        .cta-content h5 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .cta-content p {
            color: rgba(255, 255, 255, 0.9);
            margin: 0;
            font-size: 1.1rem;
        }

        /* Mentor Quiz Actions */
        .mentor-quiz-actions {
            background: #f8f9fa;
            padding: 2rem;
            border-radius: 16px;
            border: 1px solid #e9ecef;
        }

        .action-header {
            margin-bottom: 1.5rem;
        }

        .action-header h5 {
            color: #495057;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .action-header p {
            color: #6c757d;
            margin: 0;
            font-size: 0.95rem;
        }

        .mentor-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .mentor-actions .btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 1.5rem 1rem;
            height: auto;
            min-height: 120px;
            justify-content: center;
        }

        .mentor-actions .btn i {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .mentor-actions .btn span {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .mentor-actions .btn small {
            opacity: 0.8;
            font-size: 0.8rem;
        }

        /* Quiz Empty State */
        .quiz-empty-state {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
            border: 2px dashed #dee2e6;
            transition: all 0.3s ease;
        }

        .quiz-empty-state:hover {
            border-color: #667eea;
            box-shadow: 0 12px 48px rgba(102, 126, 234, 0.15);
        }

        .empty-state-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: white;
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
        }

        .empty-state-content h4 {
            color: #212529;
            font-weight: 700;
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }

        .empty-state-content p {
            color: #6c757d;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .empty-state-features {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 2.5rem;
            flex-wrap: wrap;
        }

        .feature-item {
            display: flex;
            align-items: center;
            color: #495057;
            font-weight: 500;
        }

        /* Quiz Actions */
        .quiz-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .quiz-actions .btn {
            position: relative;
            overflow: hidden;
        }

        /* Pulse Animation */
        .pulse-animation {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);
            }
            50% {
                box-shadow: 0 8px 40px rgba(102, 126, 234, 0.6);
            }
            100% {
                box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);
            }
        }

        /* Shine Effect */
        .shine-effect {
            position: relative;
            overflow: hidden;
        }

        .shine-effect::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s;
        }

        .shine-effect:hover::before {
            left: 100%;
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
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            color: white;
        }

        .btn-outline-primary {
            background: transparent;
            color: #667eea;
            border: 2px solid #667eea;
        }

        .btn-outline-primary:hover {
            background: #667eea;
            color: white;
        }

        .btn-info {
            background: linear-gradient(135deg, #339af0 0%, #228be6 100%);
            color: white;
        }

        .btn-info:hover {
            color: white;
        }

        .btn-warning {
            background: linear-gradient(135deg, #ffd43b 0%, #fab005 100%);
            color: #212529;
        }

        .btn-warning:hover {
            color: #212529;
        }

        .btn-danger {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
            color: white;
        }

        .btn-danger:hover {
            color: white;
        }

        .btn-lg {
            padding: 1rem 2rem;
            font-size: 1.1rem;
        }

        .btn-xl {
            padding: 1.25rem 2.5rem;
            font-size: 1.2rem;
            font-weight: 700;
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
            color: white !important;
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

            .quiz-header {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .quiz-body {
                padding: 2rem 1.5rem;
            }

            .quiz-stats {
                grid-template-columns: 1fr;
            }

            .results-grid {
                grid-template-columns: 1fr;
            }

            .mentor-actions {
                grid-template-columns: 1fr;
            }

            .empty-state-features {
                flex-direction: column;
                gap: 1rem;
            }

            .quiz-actions {
                flex-direction: column;
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

            .quiz-header {
                padding: 1.5rem;
            }

            .quiz-body {
                padding: 1.5rem 1rem;
            }

            .quiz-cta {
                padding: 2rem 1.5rem;
            }

            .quiz-empty-state {
                padding: 2rem 1.5rem;
            }

            .info-card .card-header,
            .info-card .card-body {
                padding: 1rem;
            }

            .meta-item {
                padding: 0.4rem 0.8rem;
                font-size: 0.85rem;
            }

            .empty-state-icon {
                width: 80px;
                height: 80px;
                font-size: 2.5rem;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            .page-wrapper {
                background: #1a202c;
            }

            .material-card,
            .info-card,
            .quiz-card,
            .quiz-empty-state {
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

            .stat-item {
                background: #4a5568;
                border-color: #4a5568;
            }

            .quiz-results,
            .mentor-quiz-actions {
                background: #4a5568;
                border-color: #4a5568;
            }

            .result-card {
                background: #2d3748;
                border-color: #4a5568;
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
        .info-card,
        .quiz-card,
        .quiz-empty-state {
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

        .quiz-section {
            animation-delay: 0.4s;
        }

        /* Accessibility improvements */
        .btn:focus,
        .btn:focus-visible {
            outline: 2px solid #667eea;
            outline-offset: 2px;
        }

        .quiz-card:focus-within {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        /* Print styles */
        @media print {
            .quiz-section,
            .sidebar-column,
            .action-buttons {
                display: none;
            }

            .main-container {
                grid-template-columns: 1fr;
                max-width: none;
            }

            .material-card {
                box-shadow: none;
                border: 1px solid #ddd;
            }

            .material-header {
                background: #f8f9fa !important;
                color: #212529 !important;
            }
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

            // Enhanced interactions
            document.addEventListener('DOMContentLoaded', function() {
                // Smooth scroll untuk breadcrumb navigation
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

                // Enhanced button interactions
                const buttons = document.querySelectorAll('.btn');
                buttons.forEach(button => {
                    button.addEventListener('mouseenter', function() {
                        this.style.transform = 'translateY(-2px)';
                    });

                    button.addEventListener('mouseleave', function() {
                        this.style.transform = 'translateY(0)';
                    });

                    button.addEventListener('mousedown', function() {
                        this.style.transform = 'translateY(0) scale(0.98)';
                    });

                    button.addEventListener('mouseup', function() {
                        this.style.transform = 'translateY(-2px) scale(1)';
                    });
                });

                // Progress animation for quiz results
                const resultCards = document.querySelectorAll('.result-card');
                resultCards.forEach((card, index) => {
                    card.style.animationDelay = `${index * 0.1}s`;
                    card.classList.add('fadeIn');
                });
            });
        </script>
    @endpush
@endsection
