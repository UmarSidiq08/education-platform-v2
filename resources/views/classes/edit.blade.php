@extends('layouts.app')

@section('content')
<div class="class-edit-container">
    <div class="edit-header">
        <div class="header-content">
            <h1 class="edit-title">Edit Learning Space</h1>
            <p class="edit-subtitle">Update your classroom information</p>
        </div>
        <div class="header-decoration">
            <div class="deco-circle deco-1"></div>
            <div class="deco-circle deco-2"></div>
            <div class="deco-circle deco-3"></div>
        </div>
    </div>

    <div class="edit-card-container">
        <div class="edit-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="card-title">Class Details</h2>
                        <p class="card-subtitle">Update the information below</p>
                    </div>
                    <a href="{{ route('classes.my') }}" class="btn-back">
                        <i class="fas fa-arrow-left"></i> My Classes
                    </a>
                </div>
            </div>

            <div class="card-body">
                @if($errors->any())
                    <div class="alert-message">
                        <div class="alert-icon">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <div class="alert-content">
                            <h4>Oops! There's an issue</h4>
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <form action="{{ route('classes.update', $class->id) }}" method="POST" class="edit-form">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <div class="form-header">
                            <label for="name" class="form-label">Class Name</label>
                            <span class="required-badge">Required</span>
                        </div>
                        <div class="input-with-icon">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $class->name) }}"
                                   placeholder="e.g. Advanced Mathematics 2023"
                                   required>
                        </div>
                        @error('name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="form-header">
                            <label for="description" class="form-label">Class Description</label>
                            <span class="optional-badge">Optional</span>
                        </div>
                        <div class="textarea-with-icon">
                            <i class="fas fa-align-left"></i>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description"
                                      name="description"
                                      rows="4"
                                      placeholder="Describe what students will learn in this class...">{{ old('description', $class->description) }}</textarea>
                        </div>
                        @error('description')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                        <div class="form-hint">
                            <i class="fas fa-lightbulb"></i> Tip: Include key topics and learning objectives
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-update">
                            <i class="fas fa-save"></i> Update Class
                        </button>
                        <a href="{{ route('classes.my') }}" class="btn-cancel">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Base Styles */
    .class-edit-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1rem;
        font-family: 'Figtree', sans-serif;
    }

    /* Header Section */
    .edit-header {
        position: relative;
        margin-bottom: 3rem;
        padding: 2rem;
        background: linear-gradient(135deg, #4a6cf7 0%, #2541b2 100%);
        border-radius: 16px;
        color: white;
        overflow: hidden;
    }

    .header-content {
        position: relative;
        z-index: 2;
    }

    .edit-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .edit-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
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
    .edit-card-container {
        position: relative;
        margin-top: -50px;
        z-index: 10;
    }

    .edit-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .card-header {
        padding: 1.5rem 2rem;
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
        padding: 2rem;
    }

    /* Alert Message */
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

    /* Form Styles */
    .edit-form {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

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

    .input-with-icon, .textarea-with-icon {
        position: relative;
    }

    .input-with-icon i, .textarea-with-icon i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #a0aec0;
    }

    .textarea-with-icon i {
        top: 1.25rem;
        transform: none;
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
        border-color: #4a6cf7;
        box-shadow: 0 0 0 3px rgba(74, 108, 247, 0.2);
        outline: none;
    }

    textarea.form-control {
        min-height: 120px;
        padding-top: 1rem;
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

    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e2e8f0;
    }

    .btn-update {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, #4a6cf7 0%, #2541b2 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(74, 108, 247, 0.4);
    }

    .btn-cancel {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
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
    @media (max-width: 768px) {
        .edit-header {
            padding: 1.5rem;
            text-align: center;
        }

        .edit-title {
            font-size: 2rem;
        }

        .edit-card-container {
            margin-top: -30px;
        }

        .card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn-update, .btn-cancel {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add character counter for description
        const description = document.getElementById('description');
        if (description) {
            const counter = document.createElement('div');
            counter.className = 'form-hint';
            counter.innerHTML = '<span id="char-count">0</span>/500 characters';
            description.parentNode.insertBefore(counter, description.nextSibling.nextSibling);

            description.addEventListener('input', function() {
                document.getElementById('char-count').textContent = this.value.length;
            });

            // Initialize counter
            document.getElementById('char-count').textContent = description.value.length;
        }

        // Enhanced focus effects
        const inputs = document.querySelectorAll('.form-control');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentNode.querySelector('i').style.color = '#4a6cf7';
            });

            input.addEventListener('blur', function() {
                this.parentNode.querySelector('i').style.color = '#a0aec0';
            });
        });
    });
</script>

@endsection
