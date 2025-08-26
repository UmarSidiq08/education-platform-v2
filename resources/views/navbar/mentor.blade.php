@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-700 text-white py-16">
            <div class="container mx-auto px-4 text-center">
                <h1 class="text-5xl font-bold mb-4 bg-gradient-to-r from-white to-blue-100 bg-clip-text text-transparent">
                    Meet Our Expert Mentors
                </h1>
                <p class="text-xl text-blue-100 max-w-2xl mx-auto">
                    Learn from industry professionals who are passionate about sharing their knowledge and helping you grow
                </p>
                <div class="mt-8 flex justify-center">
                    <div class="bg-white/20 backdrop-blur-sm rounded-full px-6 py-3 border border-white/30">
                        <span class="text-sm font-medium">✨ Choose from {{ $mentors->count() }} expert mentors</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 py-16">
            <!-- Mentors Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8 max-w-7xl mx-auto">
                @foreach ($mentors as $mentor)
                    <div
                        class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden border border-gray-100">

                        <!-- Badge -->
                        @if(!empty($mentor->badge))
                            <div class="absolute top-4 left-4 z-10">
                                <span
                                    class="{{ $mentor->badgeColor ?? 'bg-gray-400' }} text-white text-xs font-semibold px-3 py-1 rounded-full shadow-lg">
                                    {{ $mentor->badge }}
                                </span>
                            </div>
                        @endif

                        <!-- Photo Section -->
                        <div class="relative overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200">
                            <img src="{{ $mentor->avatar ? asset('storage/' . $mentor->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($mentor->name) }}"
                                alt="{{ $mentor->name }}"
                                class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent"></div>
                        </div>

                        <!-- Content Section -->
                        <div class="p-6 space-y-4">
                            <!-- Header -->
                            <div>
                                <h2 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                    {{ $mentor->name }}
                                </h2>
                                <p class="text-blue-600 font-medium text-sm">{{ $mentor->expertise ?? 'Not specified' }}</p>
                            </div>

                            <!-- Specialties Tags -->
                            @if(!empty($mentor->specialties))
                                <div class="flex flex-wrap gap-2">
                                    @foreach (explode(',', $mentor->specialties) as $specialty)
                                        <span class="bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded-lg border">
                                            {{ trim($specialty) }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Students Count -->
                            @if(!empty($mentor->students))
                                <div class="flex items-center space-x-1 text-sm text-gray-600">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                    </svg>
                                    <span>{{ $mentor->students }} students</span>
                                </div>
                            @endif

                            <!-- Description -->
                            <p class="text-gray-600 text-sm leading-relaxed">
                                {{ $mentor->description ?? 'No description available.' }}
                            </p>

                            <!-- CTA Button -->
                            <div class="pt-2">
                                <a href="{{ route('mentor.show', $mentor->id) }}"
                                    class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-indigo-700 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl group">
                                    <span>View Profile</span>
                                    <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none"
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
        </div>
    </div>
@endsection
