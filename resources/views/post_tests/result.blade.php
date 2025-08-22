@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-check-circle me-2"></i>Hasil Post Test
                    </h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h3>{{ $postTest->title }}</h3>
                        <p class="text-muted">{{ $postTest->description }}</p>
                    </div>

                    <div class="result-summary text-center mb-4">
                        @if($attempt->isPassed())
                            <div class="alert alert-success">
                                <i class="fas fa-trophy fa-3x mb-3"></i>
                                <h4>Selamat! Anda Lulus</h4>
                                <h2 class="display-4 fw-bold">{{ $attempt->score }}/{{ $postTest->getTotalPointsAttribute() }}</h2>
                                <p>Nilai: {{ $attempt->getPercentageAttribute() }}%</p>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                <h4>Anda Belum Lulus</h4>
                                <h2 class="display-4 fw-bold">{{ $attempt->score }}/{{ $postTest->getTotalPointsAttribute() }}</h2>
                                <p>Nilai: {{ $attempt->getPercentageAttribute() }}%</p>
                                <p>Nilai minimal kelulusan: {{ $postTest->passing_score }}%</p>
                            </div>
                        @endif
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h6>Jawaban Benar</h6>
                                    <h3 class="text-success">{{ $attempt->correct_answers }}/{{ $attempt->total_questions }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h6>Waktu Pengerjaan</h6>
                                    <h3>{{ $attempt->getDurationAttribute() }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('classes.show', $class->id) }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Kelas
                        </a>

                        @if(auth()->user()->role === 'mentor')
                            <a href="{{ route('post_tests.show', $postTest) }}" class="btn btn-info">
                                <i class="fas fa-eye me-2"></i>Lihat Detail Post Test
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
