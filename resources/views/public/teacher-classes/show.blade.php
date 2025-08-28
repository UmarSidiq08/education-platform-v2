@extends('layouts.app')

@section('title', $teacherClass->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li><a href="{{ route('public.teacher-classes.index') }}" class="hover:text-blue-600">Mata Pelajaran</a></li>
            <li><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
            <li class="text-gray-900 font-medium">{{ $teacherClass->name }}</li>
        </ol>
    </nav>

    <!-- Header Section dengan Foto Profil Guru -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 px-6 py-8 text-white">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex-1">
                    <div class="flex items-center mb-2">
                        @if($teacherClass->subject)
                            <span class="bg-white bg-opacity-20 text-xs font-medium px-3 py-1 rounded-full mr-3">
                                {{ $teacherClass->subject }}
                            </span>
                        @endif
                        <span class="text-sm opacity-90">{{ $teacherClass->created_at->format('d M Y') }}</span>
                    </div>
                    <h1 class="text-3xl font-bold mb-2">{{ $teacherClass->name }}</h1>

                    <!-- PERUBAHAN: Tambah foto profil guru di header -->
                    <div class="flex items-center mt-4">
                        <div class="relative w-10 h-10 mr-3 flex-shrink-0">
                            <img src="{{ $teacherClass->teacher && $teacherClass->teacher->avatar ? asset('storage/' . $teacherClass->teacher->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($teacherClass->teacher->name) . '&background=ffffff&color=3B82F6&size=40' }}"
                                alt="{{ $teacherClass->teacher->name }}"
                                class="w-full h-full rounded-full object-cover border-2 border-white/30"
                                loading="lazy"
                                onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($teacherClass->teacher->name) }}&background=ffffff&color=3B82F6&size=40'">
                        </div>
                        <p class="text-blue-100">Oleh {{ $teacherClass->teacher->name }}</p>
                    </div>
                </div>
                <div class="mt-4 md:mt-0 text-right">
                    <div class="text-2xl font-bold">{{ $mentors->count() }}</div>
                    <div class="text-blue-100">Mentor Approved</div>
                </div>
            </div>
        </div>

        @if($teacherClass->description)
        <div class="p-6">
            <h3 class="text-lg font-semibold mb-3">Deskripsi</h3>
            <p class="text-gray-600 leading-relaxed">{{ $teacherClass->description }}</p>
        </div>
        @endif
    </div>

    <!-- Mentors Section dengan Foto Profil -->
    @if($mentors->count() > 0)
        <div class="mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Daftar Mentor</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($mentors as $mentor)
                    @php
                        // Check if mentor has classes (simplified check)
                        $hasClasses = isset($mentor->classes) && $mentor->classes->count() > 0;
                    @endphp

                    <div class="bg-white rounded-lg shadow-sm p-6 hover:shadow-md transition-shadow">
                        <!-- PERUBAHAN: Mentor Avatar dengan foto profil dari storage -->
                        <div class="flex items-center mb-4">
                            <div class="relative w-12 h-12 mr-4 flex-shrink-0">
                                <img src="{{ $mentor->avatar ? asset('storage/' . $mentor->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($mentor->name) . '&background=3B82F6&color=ffffff&size=48' }}"
                                    alt="{{ $mentor->name }}"
                                    class="w-full h-full rounded-full object-cover border-2 border-gray-200 hover:border-blue-300 transition-colors"
                                    loading="lazy"
                                    onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($mentor->name) }}&background=6B7280&color=ffffff&size=48'">

                                <!-- Status indicator (online/offline) -->
                                <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-green-400 border-2 border-white rounded-full"></div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $mentor->name }}</h3>
                                <p class="text-sm text-gray-500">
                                    Approved {{ $mentor->pivot->approved_at ? \Carbon\Carbon::parse($mentor->pivot->approved_at)->format('M Y') : 'Belum diketahui' }}
                                </p>
                            </div>
                        </div>

                        <!-- Status & Action -->
                        <div class="border-t pt-4">
                            @if($hasClasses)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Ada Kelas
                                        </span>
                                        @if(isset($mentor->classes_count))
                                            <span class="ml-2 text-sm text-gray-600">{{ $mentor->classes_count }} kelas</span>
                                        @endif
                                    </div>
                                    @if(Route::has('public.teacher-classes.mentor-classes'))
                                        <a href="{{ route('public.teacher-classes.mentor-classes', [$teacherClass, $mentor]) }}"
                                           class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                            Lihat Kelas →
                                        </a>
                                    @endif
                                </div>
                            @else
                                <div class="text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 mb-3">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        Belum Ada Kelas
                                    </span>
                                    <p class="text-gray-600 text-xs">
                                        Mentor belum membuat kelas untuk mata pelajaran ini
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-sm p-12 text-center">
            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 48 48">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M34 40h10v-4a6 6 0 00-10.712-3.714M34 40H14m20 0v-4a9.971 9.971 0 00-.712-3.714M14 40H4v-4a6 6 0 0110.713-3.714M14 40v-4c0-1.313.253-2.566.713-3.714m0 0A9.971 9.971 0 0124 34c4.75 0 8.971 2.99 10.287 7.286"></path>
            </svg>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Mentor</h3>
            <p class="text-gray-600 mb-6">Mata pelajaran ini belum memiliki mentor yang approved.</p>
            <a href="{{ route('public.teacher-classes.index') }}"
               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                Kembali ke Daftar Mata Pelajaran
            </a>
        </div>
    @endif

    <!-- PERUBAHAN: Teacher Info Section dengan foto profil yang lebih besar -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold mb-4">Informasi Pengajar</h3>
        <div class="flex items-center">
            <div class="relative w-16 h-16 mr-4 flex-shrink-0">
                <img src="{{ $teacherClass->teacher->avatar ? asset('storage/' . $teacherClass->teacher->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($teacherClass->teacher->name) . '&background=3B82F6&color=ffffff&size=64' }}"
                    alt="{{ $teacherClass->teacher->name }}"
                    class="w-full h-full rounded-full object-cover border-3 border-gray-200 hover:border-blue-300 transition-colors shadow-md"
                    loading="lazy"
                    onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($teacherClass->teacher->name) }}&background=6B7280&color=ffffff&size=64'">

                <!-- Badge atau indicator untuk guru -->
                <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-blue-500 border-2 border-white rounded-full flex items-center justify-center">
                    <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="flex-1">
                <h4 class="font-semibold text-gray-900">{{ $teacherClass->teacher->name }}</h4>
                <p class="text-gray-600">Pengajar Mata Pelajaran</p>
                <p class="text-sm text-gray-500 mt-1">
                    Bergabung sejak {{ $teacherClass->teacher->created_at->format('M Y') }}
                </p>

                <!-- Optional: Tambah info tambahan jika ada -->
                @if($teacherClass->teacher->email)
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        {{ $teacherClass->teacher->email }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
