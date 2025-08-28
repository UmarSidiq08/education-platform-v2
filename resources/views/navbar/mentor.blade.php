@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100">
        <!-- Hero Section -->
        <div class="relative bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-700 text-white py-16 overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0" style="background-image: radial-gradient(circle at 25% 25%, white 2px, transparent 2px), radial-gradient(circle at 75% 75%, white 2px, transparent 2px); background-size: 50px 50px;"></div>
            </div>

            <div class="container mx-auto px-4 text-center relative">
                <div class="max-w-4xl mx-auto">
                    <h1 class="text-5xl md:text-6xl font-bold mb-6 bg-gradient-to-r from-white via-blue-100 to-purple-100 bg-clip-text text-transparent">
                        Daftar Mentor Ahli
                    </h1>
                    <p class="text-xl md:text-2xl text-blue-100 max-w-3xl mx-auto leading-relaxed mb-8">
                        Belajar dari para profesional yang berpengalaman dan siap membimbing perjalanan belajar Anda menuju kesuksesan
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <div class="bg-white/20 backdrop-blur-sm rounded-full px-8 py-4 border border-white/30 shadow-lg">
                            <span class="text-lg font-medium flex items-center">
                                <svg class="w-5 h-5 mr-2 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                {{ $mentors->count() }} mentor berpengalaman
                            </span>
                        </div>
                        <div class="bg-green-500/20 backdrop-blur-sm rounded-full px-8 py-4 border border-green-400/30 shadow-lg">
                            <span class="text-lg font-medium flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Terverifikasi & Terpercaya
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 py-16">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Temukan Mentor Terbaik
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Pilih dari berbagai mentor ahli yang siap membantu Anda mencapai tujuan pembelajaran
                </p>
            </div>

            <!-- Mentors Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 max-w-7xl mx-auto">
                @foreach ($mentors as $mentor)
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden border border-gray-100 hover:border-blue-200 h-[420px] flex flex-col">

                        <!-- Photo Section - Reduced Height -->
                        <div class="relative overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200 h-36 flex-shrink-0">
                            <img src="{{ $mentor->getAvatarUrlAttribute() }}"
                                alt="{{ $mentor->name }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent"></div>

                            <!-- Verification Badge -->
                            @if($mentor->is_verified)
                                <div class="absolute top-2 right-2">
                                    <div class="bg-green-500 text-white text-xs px-2 py-1 rounded-full flex items-center shadow-lg">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Terverifikasi
                                    </div>
                                </div>
                            @endif

                            <!-- Online Status Indicator -->
                 
                        </div>

                        <!-- Content Section - Compact -->
                        <div class="p-4 flex-1 flex flex-col">
                            <!-- Header - Reduced Height -->
                            <div class="text-center mb-3">
                                <h2 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors mb-1 line-clamp-1">
                                    {{ $mentor->name }}
                                </h2>

                                <!-- Expertise/Keahlian -->
                                @if($mentor->expertise)
                                    <p class="text-blue-600 font-medium text-xs bg-blue-50 px-2 py-1 rounded-full inline-block">
                                        {{ Str::limit($mentor->expertise, 20) }}
                                    </p>
                                @endif
                            </div>

                            <!-- Teacher Classes Info - Compact -->
                            <div class="mb-3 text-center">
                                @if($mentor->approvedTeacherClasses && $mentor->approvedTeacherClasses->count() > 0)
                                    @php
                                        $firstTeacherClass = $mentor->approvedTeacherClasses->first();
                                        $totalTeacherClasses = $mentor->approvedTeacherClasses->count();
                                    @endphp

                                    <div class="text-xs text-gray-600">
                                        <div class="flex items-center justify-center bg-gray-50 rounded-lg px-2 py-1 mb-1">
                                            <svg class="w-3 h-3 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            <span class="font-medium">{{ Str::limit($firstTeacherClass->teacher->name, 15) }}</span>
                                        </div>
                                        <div class="text-blue-600 font-medium">
                                            {{ Str::limit($firstTeacherClass->subject ?: $firstTeacherClass->name, 20) }}
                                            @if($totalTeacherClasses > 1)
                                                <span class="text-blue-500"> +{{ $totalTeacherClasses - 1 }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="bg-purple-50 text-purple-700 font-medium text-xs px-3 py-1 rounded-full border border-purple-200">
                                        Mentor Mandiri
                                    </div>
                                @endif
                            </div>

                            <!-- Rating - Compact -->
                            <div class="mb-3 flex items-center justify-center">
                                @if($mentor->rating > 0)
                                    <div class="flex items-center space-x-1">
                                        <div class="flex text-yellow-400">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $mentor->full_stars)
                                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                    </svg>
                                                @elseif($i == $mentor->full_stars + 1 && $mentor->has_half_star)
                                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                                        <defs>
                                                            <linearGradient id="half-star-{{ $mentor->id }}">
                                                                <stop offset="50%" stop-color="currentColor"/>
                                                                <stop offset="50%" stop-color="#e5e7eb"/>
                                                            </linearGradient>
                                                        </defs>
                                                        <path fill="url(#half-star-{{ $mentor->id }})" d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                    </svg>
                                                @else
                                                    <svg class="w-3 h-3 fill-current text-gray-300" viewBox="0 0 20 20">
                                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                    </svg>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="text-xs font-semibold text-gray-700">{{ number_format($mentor->rating, 1) }}</span>
                                    </div>
                                @else
                                    <span class="text-gray-400 text-xs">Belum ada rating</span>
                                @endif
                            </div>

                            <!-- Stats Section - Compact -->
                            <div class="mb-3">
                                <div class="grid grid-cols-2 gap-2">
                                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-2 text-center border border-blue-100">
                                        <div class="flex items-center justify-center space-x-1 text-blue-600">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            <span class="font-bold text-sm">{{ $mentor->mentorClasses->count() }}</span>
                                        </div>
                                        <p class="text-xs text-blue-600 font-medium">Kelas</p>
                                    </div>

                                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg p-2 text-center border border-green-100">
                                        <div class="flex items-center justify-center space-x-1 text-green-600">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                            </svg>
                                            <span class="font-bold text-sm">{{ $mentor->total_students ?: 0 }}</span>
                                        </div>
                                        <p class="text-xs text-green-600 font-medium">Siswa</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Bio/Description - Compact -->


                            <!-- CTA Button - Smaller -->
                            <div class="mt-auto">
                                <a href="{{ route('mentor.show', $mentor->id) }}"
                                    class="w-full inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white font-medium rounded-lg hover:from-blue-700 hover:via-indigo-700 hover:to-purple-700 transform hover:scale-[1.02] transition-all duration-300 shadow-lg hover:shadow-xl group relative overflow-hidden text-sm">
                                    <div class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                                    <span class="relative">Lihat Profil</span>
                                    <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform relative" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Empty State -->
            @if($mentors->isEmpty())
                <div class="text-center py-20">
                    <div class="max-w-md mx-auto">
                        <div class="bg-gradient-to-br from-blue-100 to-purple-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Belum Ada Mentor</h3>
                        <p class="text-gray-600 text-lg">Saat ini belum ada mentor yang tersedia. Silakan cek kembali nanti!</p>
                        <div class="mt-6">
                            <button class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                                Refresh Halaman
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection
