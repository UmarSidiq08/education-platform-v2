@extends('layouts.app')

@section('content')
<style>
    /* My Classes Container */
    .my-classes-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: calc(100vh - 80px);
        padding: 40px 20px;
        margin: -20px -15px 0 -15px;
    }

    .my-classes-content {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Page Header */
    .my-classes-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 40px;
        flex-wrap: wrap;
        gap: 20px;
    }

    .header-text {
        flex: 1;
        min-width: 300px;
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: white;
        margin-bottom: 10px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    }

    .page-subtitle {
        font-size: 1.1rem;
        color: rgba(255, 255, 255, 0.9);
        max-width: 500px;
    }

    .header-actions {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .header-btn {
        padding: 12px 25px;
        border-radius: 25px;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }

    .btn-outline-light {
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
    }

    .btn-outline-light:hover {
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.5);
        transform: translateY(-2px);
    }

    .btn-success {
        background: rgba(40, 167, 69, 0.9);
        border: 2px solid #28a745;
        color: white;
    }

    .btn-success:hover {
        background: rgba(40, 167, 69, 1);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
    }

    /* Alert Styles */
    .custom-alert {
        border-radius: 15px;
        border: none;
        backdrop-filter: blur(10px);
        margin-bottom: 30px;
        padding: 15px 20px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .alert-success {
        background: rgba(40, 167, 69, 0.9);
        color: white;
    }

    .alert-info {
        background: rgba(23, 162, 184, 0.9);
        color: white;
    }

    .alert-icon {
        font-size: 1.5rem;
    }

    .alert-content {
        flex: 1;
    }

    .btn-close-white {
        filter: brightness(0) invert(1);
    }

    /* Classes Grid */
    .classes-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }

    /* Class Card */
    .class-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .class-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .class-card-header {
        padding: 25px 25px 15px;
        position: relative;
    }

    .class-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 10px;
        line-height: 1.3;
    }

    .class-description {
        color: #4a5568;
        line-height: 1.5;
        margin-bottom: 15px;
        flex-grow: 1;
    }

    .class-meta {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #718096;
        font-size: 0.9rem;
        margin-top: 15px;
    }

    .class-card-footer {
        padding: 15px 25px;
        background: rgba(102, 126, 234, 0.05);
        border-top: 1px solid rgba(102, 126, 234, 0.1);
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .class-action-btn {
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .btn-view {
        background: linear-gradient(45deg, #667eea, #764ba2);
        color: white;
        border: none;
    }

    .btn-view:hover {
        background: linear-gradient(45deg, #5a6fd1, #6740a0);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-edit {
        background: rgba(255, 193, 7, 0.1);
        color: #d97706;
        border: 1px solid rgba(255, 193, 7, 0.3);
    }

    .btn-edit:hover {
        background: rgba(255, 193, 7, 0.2);
        color: #b45309;
        transform: translateY(-2px);
    }

    .btn-delete {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .btn-delete:hover {
        background: rgba(239, 68, 68, 0.2);
        color: #b91c1c;
        transform: translateY(-2px);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 20px;
        backdrop-filter: blur(10px);
        max-width: 800px;
        margin: 0 auto;
    }

    .empty-icon {
        font-size: 4rem;
        color: #667eea;
        margin-bottom: 20px;
    }

    .empty-title {
        font-size: 1.8rem;
        color: #2d3748;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .empty-text {
        color: #4a5568;
        margin-bottom: 25px;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }

    .empty-action {
        background: linear-gradient(45deg, #667eea, #764ba2);
        color: white;
        padding: 12px 30px;
        border-radius: 25px;
        font-weight: 500;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
    }

    .empty-action:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        color: white;
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .classes-grid {
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .my-classes-container {
            padding: 30px 15px;
        }

        .page-title {
            font-size: 2rem;
        }

        .header-actions {
            width: 100%;
            justify-content: flex-start;
        }

        .classes-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 576px) {
        .my-classes-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .header-actions {
            flex-direction: column;
            width: 100%;
        }

        .header-btn {
            width: 100%;
            justify-content: center;
        }

        .class-card-footer {
            flex-direction: column;
        }

        .class-action-btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="my-classes-container">
    <div class="my-classes-content">
        <div class="my-classes-header">
            <div class="header-text">
                <h1 class="page-title">My Classes</h1>
                <p class="page-subtitle">Manage all the classes you've created and track your teaching progress</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('classes.index') }}" class="header-btn btn-outline-light">
                    <i class="fas fa-list me-1"></i> All Classes
                </a>
                <a href="{{ route('classes.create') }}" class="header-btn btn-success">
                    <i class="fas fa-plus me-1"></i> New Class
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="custom-alert alert-success">
                <i class="fas fa-check-circle alert-icon"></i>
                <div class="alert-content">{{ session('success') }}</div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($classes->isEmpty())
            <div class="empty-state">
                <i class="fas fa-chalkboard-teacher empty-icon"></i>
                <h3 class="empty-title">No Classes Created Yet</h3>
                <p class="empty-text">Start sharing your knowledge by creating your first class. Design engaging content and help students learn effectively.</p>
                <a href="{{ route('classes.create') }}" class="empty-action">
                    <i class="fas fa-plus me-2"></i> Create First Class
                </a>
            </div>
        @else
            <div class="classes-grid">
                @foreach($classes as $class)
                    <div class="class-card">
                        <div class="class-card-header">
                            <h3 class="class-title">{{ $class->name }}</h3>
                            @if($class->description)
                                <p class="class-description">
                                    {{ Str::limit($class->description, 150) }}
                                </p>
                            @endif
                            <div class="class-meta">
                                <i class="fas fa-calendar"></i>
                                <span>Created {{ $class->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                        <div class="class-card-footer">
                            <a href="{{ route('classes.show', $class->id) }}" class="class-action-btn btn-view">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <a href="{{ route('classes.edit', $class->id) }}" class="class-action-btn btn-edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('classes.destroy', $class->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="class-action-btn btn-delete" onclick="return confirm('Are you sure you want to delete this class?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<script>
    // Animation for cards when they come into view
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.class-card');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, index * 100);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = `all 0.5s ease ${index * 0.1}s`;
            observer.observe(card);
        });

        // Enhanced hover effects for buttons
        document.querySelectorAll('.class-action-btn').forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            btn.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
    
</script>
@endsection
