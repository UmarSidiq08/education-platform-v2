@extends('layouts.app')
@section('content')

<style>
    /* Classes Tab Styles */
    .classes-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: calc(100vh - 80px);
        padding: 40px 20px;
        margin: -20px -15px 0 -15px; /* Remove container padding */
    }

    .classes-content {
        max-width: 1200px;
        margin: 0 auto;
    }

    .page-header {
        text-align: center;
        margin-bottom: 50px;
    }


    .page-title {
        font-size: 3rem;
        font-weight: 700;
        color: white;
        margin-bottom: 15px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }

    .page-subtitle {
        font-size: 1.2rem;
        color: rgba(255, 255, 255, 0.9);
        max-width: 600px;
        margin: 0 auto 30px;
    }

    .header-actions {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 30px;
        flex-wrap: wrap;
    }

    .header-btn {
        padding: 12px 25px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 25px;
        color: white;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.1);
    }

    .header-btn:hover {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
        border-color: rgba(255, 255, 255, 0.5);
    }

    .header-btn.btn-success {
        background: rgba(40, 167, 69, 0.8);
        border-color: #28a745;
    }

    .header-btn.btn-success:hover {
        background: rgba(40, 167, 69, 1);
        border-color: #28a745;
    }

    /* Alert Styles */
    .alert {
        border-radius: 15px;
        border: none;
        backdrop-filter: blur(10px);
        margin-bottom: 30px;
    }

    .alert-success {
        background: rgba(40, 167, 69, 0.9);
        color: white;
    }

    .alert-danger {
        background: rgba(220, 53, 69, 0.9);
        color: white;
    }

    .alert-info {
        background: rgba(23, 162, 184, 0.9);
        color: white;
    }

    /* Classes Grid */
    .classes-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 30px;
        margin-bottom: 50px;
    }

    .class-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        position: relative;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .class-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(45deg, #667eea, #764ba2);
    }

    .class-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .class-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 15px;
    }

    .class-description {
        color: #666;
        line-height: 1.6;
        margin-bottom: 20px;
        flex-grow: 1;
    }

    .class-mentor {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        padding: 15px;
        background: rgba(102, 126, 234, 0.05);
        border-radius: 12px;
    }

    .mentor-avatar {
        width: 40px;
        height: 40px;
        background: linear-gradient(45deg, #667eea, #764ba2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        text-transform: uppercase;
    }

    .mentor-info h4 {
        font-size: 0.9rem;
        font-weight: 600;
        color: #333;
        margin: 0;
    }

    .mentor-info p {
        font-size: 0.8rem;
        color: #666;
        margin: 0;
    }

    .class-date {
        font-size: 0.85rem;
        color: #999;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .view-details-btn {
        background: linear-gradient(45deg, #667eea, #764ba2);
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 25px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        text-align: center;
        transition: all 0.3s ease;
        width: 100%;
    }

    .view-details-btn:hover {
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .no-classes {
        text-align: center;
        padding: 60px 20px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 20px;
        backdrop-filter: blur(10px);
    }

    .no-classes i {
        font-size: 4rem;
        color: #667eea;
        margin-bottom: 20px;
    }

    .no-classes h3 {
        color: #333;
        margin-bottom: 15px;
    }

    .no-classes p {
        color: #666;
        margin-bottom: 25px;
    }

    /* Tombol khusus untuk no-classes yang lebih kecil dan rapi */
    .create-first-btn {
        background: linear-gradient(45deg, #667eea, #764ba2) !important;
        color: white !important;
        border: none !important;
        padding: 12px 30px !important;
        border-radius: 25px !important;
        font-weight: 600 !important;
        text-decoration: none !important;
        display: inline-block !important;
        text-align: center !important;
        transition: all 0.3s ease !important;
        font-size: 0.95rem !important;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3) !important;
        width: auto !important;
        max-width: 200px !important;
        white-space: nowrap !important;
    }

    .create-first-btn:hover {
        color: white;
        text-decoration: none;
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        background: linear-gradient(45deg, #5a6fd8, #6a42a0);
    }

    .create-first-btn:active {
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .classes-container {
            margin: -20px -15px 0 -15px;
            padding: 20px 15px;
        }

        .page-title {
            font-size: 2rem;
        }

        .classes-grid {
            grid-template-columns: 1fr;
        }

        .header-actions {
            flex-direction: column;
            align-items: center;
        }

        .header-btn {
            width: 200px;
            text-align: center;
        }

        .create-first-btn {
            padding: 10px 25px;
            font-size: 0.9rem;
        }
    }
</style>

<div class="classes-container">
    <div class="classes-content">
        <div class="page-header">
            <h1 class="page-title">All Classes</h1>
            <p class="page-subtitle">Discover amazing classes from expert mentors and enhance your skills with our comprehensive learning platform.</p>

            @if(auth()->user()->isMentor())
                <div class="header-actions">
                    <a href="{{ route('classes.my') }}" class="header-btn">
                        <i class="fas fa-chalkboard-teacher me-2"></i>My Classes
                    </a>
                    <a href="{{ route('classes.create') }}" class="header-btn btn-success">
                        <i class="fas fa-plus me-2"></i>Create New Class
                    </a>
                </div>
            @endif
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($classes->isEmpty())
            <div class="no-classes">
                <i class="fas fa-graduation-cap"></i>
                <h3>No Classes Available</h3>
                <p>There are no classes available at the moment. Check back later or create your first class!</p>
                @if(auth()->user()->isMentor())
                    <a href="{{ route('classes.create') }}" class="create-first-btn">
                        Create First Class
                    </a>
                @endif
            </div>
        @else
            <div class="classes-grid">
                @foreach($classes as $class)
                    <div class="class-card">
                        <h3 class="class-title">{{ $class->name }}</h3>

                        @if($class->description)
                            <p class="class-description">
                                {{ Str::limit($class->description, 150) }}
                            </p>
                        @endif

                        <div class="class-date">
                            <i class="fas fa-calendar"></i>
                            Created {{ $class->created_at->format('d M Y') }}
                        </div>

                        <div class="class-mentor">
                            <div class="mentor-avatar">
                                {{ strtoupper(substr($class->mentor->name ?? 'U', 0, 2)) }}
                            </div>
                            <div class="mentor-info">
                                <h4>{{ $class->mentor->name ?? 'Unknown Mentor' }}</h4>
                                <p>Class Instructor</p>
                            </div>
                        </div>

                        <a href="{{ route('classes.show', $class->id) }}" class="view-details-btn">
                            <i class="fas fa-eye me-2"></i>View Details
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<script>
    // Add scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, index * 100);
            }
        });
    }, observerOptions);

    // Apply scroll animations to class cards
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.class-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'all 0.6s ease';
            observer.observe(card);
        });
    });

    // Enhanced button hover effects
    document.querySelectorAll('.view-details-btn').forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px) scale(1.02)';
        });

        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Enhanced button hover effects untuk create-first-btn
    document.querySelectorAll('.create-first-btn').forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px) scale(1.05)';
        });

        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
</script>
@endsection
