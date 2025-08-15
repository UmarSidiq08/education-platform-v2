@extends('layouts.app')

@section('content')
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 15px;
        }

        .learning-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: none;
        }

        .learning-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
        }

        .learning-title {
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .btn-back {
            background: white;
            color: #667eea;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            margin-top: 1rem;
        }

        .btn-back:hover {
            background: #f8f9ff;
            color: #5a67d8;
            transform: translateY(-1px);
        }

        .learning-content {
            padding: 2rem;
        }

        .materials-grid {
            display: grid;
            gap: 1.5rem;
        }

        .material-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.25rem;
            transition: all 0.3s ease;
            border-left: 4px solid #667eea;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .material-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border-left-color: #48bb78;
        }

        .material-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1.25rem;
        }

        .material-info {
            flex: 1;
        }

        .material-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #2d3748;
            margin: 0 0 0.5rem 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .material-icon {
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            flex-shrink: 0;
        }

        .material-description {
            color: #4a5568;
            line-height: 1.6;
            margin: 0 0 0.75rem 0;
            font-size: 1rem;
        }

        .material-meta {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #718096;
            font-size: 0.9rem;
        }

        .material-actions {
            display: flex;
            flex-direction: row;
            gap: 8px;
            align-items: center;
            flex-shrink: 0;
            flex-wrap: wrap;
        }

        .btn-edit {
            background: #ffd700;
            color: #744210;
            border: none;
            padding: 8px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            min-width: 36px;
        }

        .btn-edit:hover {
            background: #ffed4e;
            color: #744210;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(255, 215, 0, 0.3);
        }

        .btn-delete {
            background: #ef4444;
            color: white;
            border: none;
            padding: 8px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            text-align: center;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            min-width: 36px;
        }

        .btn-delete:hover {
            background: #dc2626;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
        }

        .btn-quiz {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            white-space: nowrap;
        }

        .btn-quiz:hover {
            background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
            color: white;
            transform: translateY(-1px);
        }

        .btn-study {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-align: center;
            white-space: nowrap;
        }

        .btn-study:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: #f8fafc;
            border-radius: 12px;
            border: 2px dashed #cbd5e0;
        }

        .empty-icon {
            font-size: 4rem;
            color: #a0aec0;
            margin-bottom: 1.5rem;
        }

        .empty-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 0.5rem;
        }

        .empty-text {
            color: #718096;
            font-size: 1.1rem;
        }

        .stats-bar {
            background: #f8fafc;
            padding: 1.25rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            border: 1px solid #e2e8f0;
        }

        .stats-content {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #4a5568;
            font-weight: 600;
        }

        .stat-icon {
            width: 30px;
            height: 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .material-header {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }

            .material-actions {
                width: 100%;
                justify-content: flex-start;
            }

            .stats-content {
                flex-direction: column;
                gap: 1rem;
            }

            .learning-content {
                padding: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .material-actions {
                justify-content: center;
                width: 100%;
            }

            .btn-edit,
            .btn-delete {
                width: 40px;
                height: 40px;
                min-width: 40px;
            }

            .btn-quiz,
            .btn-study {
                width: auto;
                min-width: 120px;
                padding: 10px 16px;
            }

            .material-card {
                padding: 1rem;
            }

            .learning-content {
                padding: 1rem;
            }
        }
    </style>

    <div class="main-container">
        <div class="row">
            <div class="col-12">
                <div class="learning-card">
                    <!-- Header Section -->
                    <div class="learning-header">
                        <h1 class="learning-title">
                            <i class="fas fa-graduation-cap me-3"></i>Belajar: {{ $class->name }}
                        </h1>
                        <a href="{{ route('classes.show', $class->id) }}" class="btn-back">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Detail Kelas
                        </a>
                    </div>

                    <!-- Content Section -->
                    <div class="learning-content">
                        @if ($class->materials->count() > 0)
                            <!-- Stats Bar -->
                            <div class="stats-bar">
                                <div class="stats-content">
                                    <div class="stat-item">
                                        <div class="stat-icon">
                                            <i class="fas fa-book"></i>
                                        </div>
                                        <span>{{ $class->materials->count() }} Materi Tersedia</span>
                                    </div>
                                    <div class="stat-item">
                                        <div class="stat-icon">
                                            <i class="fas fa-user-tie"></i>
                                        </div>
                                        <span>Mentor: {{ $class->mentor->name ?? 'Unknown' }}</span>
                                    </div>
                                    <div class="stat-item">
                                        <div class="stat-icon">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <span>Terakhir Update: {{ $class->updated_at->format('d M Y') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Materials Grid -->
                            <div class="materials-grid">
                                @foreach ($class->materials as $index => $material)
                                    <div class="material-card">
                                        <div class="material-header">
                                            <div class="material-info">
                                                <h3 class="material-title">
                                                    <div class="material-icon">
                                                        {{ $index + 1 }}
                                                    </div>
                                                    {{ $material->title }}
                                                </h3>

                                                @if ($material->description)
                                                    <p class="material-description">{{ $material->description }}</p>
                                                @endif

                                                <div class="material-meta">
                                                    <i class="fas fa-calendar-alt"></i>
                                                    <span>Dibuat: {{ $material->created_at->format('d M Y H:i') }}</span>
                                                </div>
                                            </div>

                                            <div class="material-actions">
                                                @if (auth()->id() === $class->mentor_id && auth()->user()->role === 'mentor')
                                                    <a href="{{ route('materials.show', $material) }}"
                                                        class="btn btn-success">
                                                        <i class="fas fa-book-open me-2"></i>Buka Materi
                                                    </a>
                                                    <a href="{{ route('materials.edit', $material->id) }}" class="btn-edit"
                                                        title="Edit Materi">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('materials.destroy', $material->id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Yakin mau hapus materi ini?');">
                                                        @csrf
                                                        
                                                        @method('DELETE')
                                                        <button class="btn-delete" title="Hapus Materi">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                    <a href="#" class="btn-quiz">
                                                        <i class="fas fa-question-circle me-1"></i>Tambah Kuis
                                                    </a>
                                                @else
                                                    <a href="{{ route('materials.show', $material->id) }}"
                                                        class="btn-study">
                                                        <i class="fas fa-play me-1"></i>Pelajari
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <!-- Empty State -->
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-book-open"></i>
                                </div>
                                <h3 class="empty-title">Belum Ada Materi</h3>
                                <p class="empty-text">Belum ada materi yang tersedia untuk kelas ini. Silakan tunggu mentor
                                    menambahkan materi pembelajaran.</p>

                                @if (auth()->id() === $class->mentor_id && auth()->user()->role === 'mentor')
                                    <div class="mt-3">
                                        <a href="{{ route('materials.create', [$class->id]) }}" class="btn-study">
                                            <i class="fas fa-plus me-2"></i>Tambah Materi Pertama
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
