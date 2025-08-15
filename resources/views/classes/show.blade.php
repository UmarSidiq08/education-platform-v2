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

    .class-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        overflow: hidden;
        border: none;
    }

    .class-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
    }

    .class-title {
        font-size: 2.2rem;
        font-weight: 700;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .header-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 1rem;
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
    }

    .btn-back:hover {
        background: #f8f9ff;
        color: #5a67d8;
        transform: translateY(-1px);
    }

    .btn-edit {
        background: #ffd700;
        color: #744210;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-edit:hover {
        background: #ffed4e;
        color: #744210;
        transform: translateY(-1px);
    }

    .btn-delete {
        background: #ef4444;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-delete:hover {
        background: #dc2626;
        transform: translateY(-1px);
    }

    .class-content {
        padding: 2.5rem;
    }

    .content-section {
        background: #f8fafc;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        border-left: 4px solid #667eea;
    }

    .section-title {
        color: #2d3748;
        font-weight: 600;
        font-size: 1.3rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-icon {
        width: 35px;
        height: 35px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    .description-text {
        font-size: 1.1rem;
        line-height: 1.7;
        color: #4a5568;
        margin: 0;
    }

    .no-description {
        text-align: center;
        padding: 3rem;
        color: #a0aec0;
        font-style: italic;
    }

    .action-section {
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        margin-bottom: 2rem;
    }

    .action-icon {
        font-size: 3rem;
        color: #667eea;
        margin-bottom: 1rem;
    }

    .action-title {
        color: #2d3748;
        font-weight: 600;
        font-size: 1.4rem;
        margin-bottom: 0.5rem;
    }

    .action-subtitle {
        color: #718096;
        margin-bottom: 1.5rem;
    }

    .btn-learn {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        color: white;
        border: none;
        padding: 15px 35px;
        border-radius: 10px;
        font-size: 1.1rem;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-learn:hover {
        background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(72, 187, 120, 0.4);
    }

    .management-section {
        background: #f7fafc;
        border: 2px dashed #cbd5e0;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .management-buttons {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .btn-add-material {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-add-material:hover {
        background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
        color: white;
        transform: translateY(-1px);
    }

    .btn-view-material {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-view-material:hover {
        background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
        color: white;
        transform: translateY(-1px);
    }

    /* New Horizontal Info Style */
    .info-footer {
        background: #f8fafc;
        padding: 2rem;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        margin-top: 2rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 1rem;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .info-icon {
        width: 35px;
        height: 35px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .info-content {
        flex: 1;
    }

    .info-label {
        font-size: 0.85rem;
        color: #718096;
        font-weight: 500;
        margin: 0 0 4px 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-text {
        font-size: 1rem;
        color: #2d3748;
        font-weight: 600;
        margin: 0;
    }

    @media (max-width: 768px) {
        .header-buttons {
            justify-content: center;
        }

        .management-buttons {
            flex-direction: column;
            align-items: center;
        }

        .btn-add-material,
        .btn-view-material {
            width: 100%;
            text-align: center;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="main-container">
    <div class="row">
        <div class="col-12">
            <div class="class-card">
                <!-- Header Section -->
                <div class="class-header">
                    <h1 class="class-title">{{ $class->name }}</h1>
                    <div class="header-buttons">
                        <a href="{{ route('classes.index') }}" class="btn-back">
                            <i class="fas fa-arrow-left me-2"></i>Back to Classes
                        </a>
                        @if($class->mentor_id === auth()->id())
                            <a href="{{ route('classes.edit', $class->id) }}" class="btn-edit">
                                <i class="fas fa-edit me-2"></i>Edit Class
                            </a>
                            <form action="{{ route('classes.destroy', $class->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete"
                                        onclick="return confirm('Are you sure you want to delete this class?')">
                                    <i class="fas fa-trash me-2"></i>Delete Class
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Content Section -->
                <div class="class-content">
                    <!-- Description Section -->
                    <div class="content-section">
                        <h3 class="section-title">
                            <div class="section-icon">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            Class Description
                        </h3>
                        @if($class->description)
                            <p class="description-text">{{ $class->description }}</p>
                        @else
                            <div class="no-description">
                                <i class="fas fa-file-alt" style="font-size: 2rem; margin-bottom: 1rem;"></i>
                                <p>No description provided for this class.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Student Learning Section -->
                    @if(auth()->user()->role === 'siswa' || auth()->user()->role === 'mentor' && $class->mentor_id !== auth()->id())
                        <div class="action-section">
                            <div class="action-icon">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <h3 class="action-title">Ready to Learn?</h3>
                            <p class="action-subtitle">Start your learning journey with this class</p>
                            <a href="{{ route('classes.learn', $class->id) }}" class="btn-learn">
                                <i class="fas fa-book-open me-2"></i>Mulai Belajar
                            </a>
                        </div>
                    @endif

                    <!-- Mentor Management Section -->
                    @if($class->mentor_id === auth()->id())
                        <div class="management-section">
                            <h3 class="section-title">
                                <div class="section-icon">
                                    <i class="fas fa-cogs"></i>
                                </div>
                                Class Management
                            </h3>
                            <p class="text-center text-muted mb-3">Manage your class materials and content</p>
                            <div class="management-buttons">
                                <a href="{{ route('materials.create', [$class->id]) }}" class="btn-add-material">
                                    <i class="fas fa-plus me-2"></i>Tambah Materi
                                </a>
                                <a href="{{ route('classes.learn', $class->id) }}" class="btn-view-material">
                                    <i class="fas fa-eye me-2"></i>Lihat Materi
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Info Footer - Horizontal Layout -->
                    <div class="info-footer">
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </div>
                                <div class="info-content">
                                    <p class="info-label">Mentor</p>
                                    <p class="info-text">{{ $class->mentor->name ?? 'Unknown' }}</p>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-calendar-plus"></i>
                                </div>
                                <div class="info-content">
                                    <p class="info-label">Created</p>
                                    <p class="info-text">{{ $class->created_at->format('j M Y') }}</p>
                                </div>
                            </div>
                            

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="info-content">
                                    <p class="info-label">Last Updated</p>
                                    <p class="info-text">{{ $class->updated_at->format('j M Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
