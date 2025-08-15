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
                        <span class="text-sm font-medium">✨ Choose from {{ count($mentors ?? []) }} expert mentors</span>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="container mx-auto px-4 py-16">
            @php
                $mentors = [
                    (object) [
                        'id' => 1,
                        'name' => 'John Doe',
                        'expertise' => 'Web Development',
                        'specialties' => ['React', 'Node.js', 'TypeScript'],
                        'rating' => 4.8,
                        'students' => 245,
                        'photo' => 'https://via.placeholder.com/400x400/4F46E5/FFFFFF?text=JD',
                        'description' =>
                            'Expert in modern web technologies and frameworks with over 10 years of teaching experience. Specialized in building scalable applications.',
                        'badge' => 'Top Mentor',
                        'badgeColor' => 'bg-gradient-to-r from-yellow-400 to-orange-400',
                    ],
                    (object) [
                        'id' => 2,
                        'name' => 'Jane Smith',
                        'expertise' => 'UI/UX Design',
                        'specialties' => ['Figma', 'Design Systems', 'User Research'],
                        'rating' => 4.6,
                        'students' => 189,
                        'photo' => 'https://via.placeholder.com/400x400/EC4899/FFFFFF?text=JS',
                        'description' =>
                            'Specialist in creating intuitive user interfaces and enhancing user experience. Former design lead at top tech companies.',
                        'badge' => 'Design Expert',
                        'badgeColor' => 'bg-gradient-to-r from-pink-400 to-rose-400',
                    ],
                    (object) [
                        'id' => 3,
                        'name' => 'Michael Lee',
                        'expertise' => 'Data Science',
                        'specialties' => ['Python', 'Machine Learning', 'TensorFlow'],
                        'rating' => 4.9,
                        'students' => 312,
                        'photo' => 'https://via.placeholder.com/400x400/059669/FFFFFF?text=ML',
                        'description' =>
                            'Data scientist passionate about machine learning and AI-driven solutions. PhD in Computer Science with industry experience.',
                        'badge' => 'AI Specialist',
                        'badgeColor' => 'bg-gradient-to-r from-emerald-400 to-teal-400',
                    ],
                ];
            @endphp

            <!-- Mentors Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8 max-w-7xl mx-auto">
                @foreach ($mentors as $mentor)
                    <div
                        class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden border border-gray-100">
                        <!-- Badge -->
                        <div class="absolute top-4 left-4 z-10">
                            <span
                                class="{{ $mentor->badgeColor }} text-white text-xs font-semibold px-3 py-1 rounded-full shadow-lg">
                                {{ $mentor->badge }}
                            </span>
                        </div>

                        <!-- Photo Section -->
                        <div class="relative overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200">
                            <img src="{{ $mentor->photo }}" alt="{{ $mentor->name }}"
                                class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent">
                            </div>
                        </div>

                        <!-- Content Section -->
                        <div class="p-6 space-y-4">
                            <!-- Header -->
                            <div>
                                <h2 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                    {{ $mentor->name }}
                                </h2>
                                <p class="text-blue-600 font-medium text-sm">{{ $mentor->expertise }}</p>
                            </div>

                            <!-- Specialties Tags -->
                            <div class="flex flex-wrap gap-2">
                                @foreach ($mentor->specialties as $specialty)
                                    <span class="bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded-lg border">
                                        {{ $specialty }}
                                    </span>
                                @endforeach
                            </div>

                            <!-- Stats Row -->
                            <div class="flex items-center justify-between text-sm text-gray-600">
                                <!-- Rating -->
                                <div class="flex items-center space-x-1">
                                    <div class="flex">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= floor($mentor->rating))
                                                <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                    <path
                                                        d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                                </svg>
                                            @elseif ($i - $mentor->rating < 1 && $i - $mentor->rating > 0)
                                                <svg class="w-4 h-4" viewBox="0 0 20 20">
                                                    <defs>
                                                        <linearGradient id="half-{{ $mentor->id }}">
                                                            <stop offset="50%" stop-color="#FBBF24" />
                                                            <stop offset="50%" stop-color="#E5E7EB" />
                                                        </linearGradient>
                                                    </defs>
                                                    <path fill="url(#half-{{ $mentor->id }})"
                                                        d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20">
                                                    <path
                                                        d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="font-medium text-gray-900">{{ $mentor->rating }}</span>
                                </div>

                                <!-- Students Count -->
                                <div class="flex items-center space-x-1">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                    </svg>
                                    <span>{{ $mentor->students }} students</span>
                                </div>
                            </div>

                            <!-- Description -->
                            <p class="text-gray-600 text-sm leading-relaxed">{{ $mentor->description }}</p>

                            <!-- CTA Button -->
                            <div class="pt-2">
                                <a href="{{ route('mentor.profile', $mentor->id) }}"
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

            <!-- Call to Action Section -->
            <div class="mt-20 text-center">
                <div class="bg-white rounded-2xl shadow-xl p-8 max-w-2xl mx-auto border border-gray-100">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Ready to Start Learning?</h3>
                    <p class="text-gray-600 mb-6">Join thousands of students who have already transformed their careers with
                        our expert mentors.</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="#"
                            class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-8 py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                            Browse All Mentors
                        </a>
                        <a href="#"
                            class="border-2 border-gray-300 text-gray-700 px-8 py-3 rounded-xl font-semibold hover:border-blue-600 hover:text-blue-600 transition-all duration-200">
                            Learn More
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.tailwindcss.com"></script>

    @include('layout.footer')
@endsection
