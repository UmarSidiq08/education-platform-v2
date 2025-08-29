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
                <p class="text-lg text-gray-600 max-w-2xl mx-auto mb-8">
                    Pilih dari berbagai mentor ahli yang siap membantu Anda mencapai tujuan pembelajaran
                </p>

                <!-- Search and Filter Section -->
                <div class="max-w-4xl mx-auto mb-8">
                    <div class="flex flex-col md:flex-row gap-4 items-stretch md:items-center">
                        <!-- Search Box -->
                        <div class="flex-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text"
                                   id="mentorSearch"
                                   placeholder="Cari mentor berdasarkan nama..."
                                   class="w-full pl-10 pr-12 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-0 transition-colors duration-300 bg-white shadow-sm text-gray-900 placeholder-gray-500">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <div id="searchLoader" class="hidden mr-2">
                                    <svg class="w-4 h-4 text-blue-500 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                                <button id="clearSearch" class="hidden text-gray-400 hover:text-gray-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Teacher/Admin Filter -->
                        <div class="relative md:w-72">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                </svg>
                            </div>
                            <select id="teacherFilter" class="w-full pl-10 pr-10 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-0 transition-colors duration-300 bg-white shadow-sm text-gray-900 appearance-none">
                                <option value="">Semua Guru/Admin</option>
                            
                                @php
                                    $teachers = collect();
                                    foreach($mentors as $mentor) {
                                        if($mentor->approvedTeacherClasses && $mentor->approvedTeacherClasses->count() > 0) {
                                            foreach($mentor->approvedTeacherClasses as $teacherClass) {
                                                if($teacherClass->teacher && !$teachers->contains('id', $teacherClass->teacher->id)) {
                                                    $teachers->push($teacherClass->teacher);
                                                }
                                            }
                                        }
                                    }
                                    $teachers = $teachers->sortBy('name');
                                @endphp
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Clear All Filters Button -->
                        <button id="clearAllFilters" class="hidden md:px-4 px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors duration-300 border-2 border-gray-200 font-medium">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Reset Filter
                            </span>
                        </button>
                    </div>
                </div>

                <!-- Active Filters Display -->
                <div id="activeFilters" class="hidden max-w-4xl mx-auto mb-4">
                    <div class="flex flex-wrap gap-2 justify-center">
                        <div id="searchFilter" class="hidden bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium flex items-center">
                            <span class="mr-2">Pencarian: "<span id="activeSearchTerm"></span>"</span>
                            <button class="hover:text-blue-600" onclick="clearSearchFilter()">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <div id="teacherFilterDisplay" class="hidden bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium flex items-center">
                            <span class="mr-2">Guru: <span id="activeTeacherName"></span></span>
                            <button class="hover:text-green-600" onclick="clearTeacherFilter()">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Search Results Info -->
                <div id="searchInfo" class="text-sm text-gray-600 mb-4 hidden">
                    <span id="searchResultText"></span>
                </div>
            </div>

            <!-- Mentors Grid -->
            <div id="mentorsGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 max-w-7xl mx-auto">
                @foreach ($mentors as $mentor)
                    <div class="mentor-card group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden border border-gray-100 hover:border-blue-200"
                         data-mentor-name="{{ strtolower($mentor->name) }}"
                         data-mentor-expertise="{{ strtolower($mentor->expertise ?? '') }}"
                         data-teacher-ids="@if($mentor->approvedTeacherClasses && $mentor->approvedTeacherClasses->count() > 0){{ $mentor->approvedTeacherClasses->pluck('teacher.id')->implode(',') }}@else independent @endif">

                        <!-- Photo Section -->
                        <div class="relative overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200 h-32">
                            @if($mentor->getAvatarUrlAttribute() && $mentor->getAvatarUrlAttribute() != '')
                                <img src="{{ $mentor->getAvatarUrlAttribute() }}"
                                    alt="{{ $mentor->name }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <!-- Fallback placeholder (initially hidden) -->
                                <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center group-hover:scale-110 transition-transform duration-500" style="display: none;">
                                    <div class="text-white text-center">
                                        <svg class="w-12 h-12 mx-auto mb-1 opacity-80" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                        </svg>
                                        <p class="text-xs font-medium opacity-90">{{ strtoupper(substr($mentor->name, 0, 2)) }}</p>
                                    </div>
                                </div>
                            @else
                                <!-- Default placeholder -->
                                <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center group-hover:scale-110 transition-transform duration-500">
                                    <div class="text-white text-center">
                                        <svg class="w-12 h-12 mx-auto mb-1 opacity-80" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                        </svg>
                                        <p class="text-xs font-medium opacity-90">{{ strtoupper(substr($mentor->name, 0, 2)) }}</p>
                                    </div>
                                </div>
                            @endif
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
                        </div>

                        <!-- Content Section -->
                        <div class="p-4 space-y-3">
                            <!-- Header -->
                            <div class="text-center">
                                <h2 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors line-clamp-1">
                                    {{ $mentor->name }}
                                </h2>

                                <!-- Expertise/Keahlian -->
                                @if($mentor->expertise)
                                    <p class="text-blue-600 font-medium text-xs bg-blue-50 px-2 py-1 rounded-full inline-block mt-1">
                                        {{ Str::limit($mentor->expertise, 20) }}
                                    </p>
                                @endif
                            </div>

                            <!-- Teacher Classes Info -->
                            <div class="text-center">
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
                                    <div class="bg-purple-50 text-purple-700 font-medium text-xs px-3 py-1 rounded-full border border-purple-200 inline-block">
                                        Mentor Mandiri
                                    </div>
                                @endif
                            </div>

                            <!-- Stats Section -->
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

                            <!-- CTA Button -->
                            <a href="{{ route('mentor.show', $mentor->id) }}"
                                class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white font-medium rounded-lg hover:from-blue-700 hover:via-indigo-700 hover:to-purple-700 transform hover:scale-[1.02] transition-all duration-300 shadow-lg hover:shadow-xl group relative overflow-hidden text-sm">
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
                @endforeach
            </div>

            <!-- No Search Results -->
            <div id="noSearchResults" class="text-center py-20 hidden">
                <div class="max-w-md mx-auto">
                    <div class="bg-gradient-to-br from-orange-100 to-red-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Mentor Tidak Ditemukan</h3>
                    <p class="text-gray-600 text-lg mb-4">Tidak ada mentor yang sesuai dengan kriteria pencarian dan filter yang dipilih</p>
                    <button id="clearSearchBtn" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                        Reset Semua Filter
                    </button>
                </div>
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
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
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
        .mentor-card.hidden {
            display: none;
        }
        .mentor-card {
            opacity: 1;
            transform: scale(1);
            transition: all 0.3s ease;
        }
        .mentor-card.searching {
            opacity: 0;
            transform: scale(0.95);
        }
        .mentor-card.found {
            opacity: 1;
            transform: scale(1);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('mentorSearch');
            const teacherFilter = document.getElementById('teacherFilter');
            const searchLoader = document.getElementById('searchLoader');
            const clearSearch = document.getElementById('clearSearch');
            const clearAllFilters = document.getElementById('clearAllFilters');
            const searchInfo = document.getElementById('searchInfo');
            const searchResultText = document.getElementById('searchResultText');
            const noSearchResults = document.getElementById('noSearchResults');
            const clearSearchBtn = document.getElementById('clearSearchBtn');
            const mentorsGrid = document.getElementById('mentorsGrid');
            const emptyState = mentorsGrid.nextElementSibling;
            const mentorCards = document.querySelectorAll('.mentor-card');

            // Active filters elements
            const activeFilters = document.getElementById('activeFilters');
            const searchFilter = document.getElementById('searchFilter');
            const teacherFilterDisplay = document.getElementById('teacherFilterDisplay');
            const activeSearchTerm = document.getElementById('activeSearchTerm');
            const activeTeacherName = document.getElementById('activeTeacherName');

            let searchTimeout;

            function updateActiveFilters() {
                const searchQuery = searchInput.value.trim();
                const selectedTeacher = teacherFilter.value;
                let hasActiveFilters = false;

                // Show/hide search filter
                if (searchQuery) {
                    activeSearchTerm.textContent = searchQuery;
                    searchFilter.classList.remove('hidden');
                    hasActiveFilters = true;
                } else {
                    searchFilter.classList.add('hidden');
                }

                // Show/hide teacher filter
                if (selectedTeacher) {
                    const selectedOption = teacherFilter.querySelector(`option[value="${selectedTeacher}"]`);
                    activeTeacherName.textContent = selectedOption ? selectedOption.textContent : selectedTeacher;
                    teacherFilterDisplay.classList.remove('hidden');
                    hasActiveFilters = true;
                } else {
                    teacherFilterDisplay.classList.add('hidden');
                }

                // Show/hide active filters container
                if (hasActiveFilters) {
                    activeFilters.classList.remove('hidden');
                    clearAllFilters.classList.remove('hidden');
                } else {
                    activeFilters.classList.add('hidden');
                    clearAllFilters.classList.add('hidden');
                }
            }

            function performSearch() {
                const searchQuery = searchInput.value.toLowerCase().trim();
                const selectedTeacher = teacherFilter.value;
                let visibleCount = 0;

                // Show loading
                searchLoader.classList.remove('hidden');

                // Add searching class to all cards
                mentorCards.forEach(card => {
                    card.classList.add('searching');
                });

                setTimeout(() => {
                    mentorCards.forEach(card => {
                        const mentorName = card.getAttribute('data-mentor-name');
                        const mentorExpertise = card.getAttribute('data-mentor-expertise');
                        const teacherIds = card.getAttribute('data-teacher-ids');

                        // Check search criteria
                        let matchesSearch = true;
                        if (searchQuery) {
                            matchesSearch = mentorName.includes(searchQuery) || mentorExpertise.includes(searchQuery);
                        }

                        // Check teacher filter
                        let matchesTeacher = true;
                        if (selectedTeacher) {
                            if (selectedTeacher === 'independent') {
                                matchesTeacher = teacherIds === 'independent';
                            } else {
                                const teacherIdsArray = teacherIds.split(',');
                                matchesTeacher = teacherIdsArray.includes(selectedTeacher);
                            }
                        }

                        // Show/hide card based on both criteria
                        if (matchesSearch && matchesTeacher) {
                            card.classList.remove('hidden', 'searching');
                            card.classList.add('found');
                            visibleCount++;
                        } else {
                            card.classList.add('hidden');
                            card.classList.remove('found');
                        }
                    });

                    // Hide loading
                    searchLoader.classList.add('hidden');

                    // Update search info and show/hide elements
                    if (!searchQuery && !selectedTeacher) {
                        searchInfo.classList.add('hidden');
                        noSearchResults.classList.add('hidden');
                        emptyState.style.display = mentorCards.length === 0 ? 'block' : 'none';
                        clearSearch.classList.add('hidden');
                    } else {
                        if (visibleCount > 0) {
                            let resultText = `Menampilkan ${visibleCount} mentor`;
                            if (searchQuery) {
                                resultText += ` untuk "${searchInput.value}"`;
                            }
                            if (selectedTeacher) {
                                const selectedOption = teacherFilter.querySelector(`option[value="${selectedTeacher}"]`);
                                const teacherName = selectedOption ? selectedOption.textContent : selectedTeacher;
                                resultText += ` dengan filter guru: ${teacherName}`;
                            }

                            searchResultText.textContent = resultText;
                            searchInfo.classList.remove('hidden');
                            noSearchResults.classList.add('hidden');
                        } else {
                            searchInfo.classList.add('hidden');
                            noSearchResults.classList.remove('hidden');
                        }
                        emptyState.style.display = 'none';

                        if (searchQuery) {
                            clearSearch.classList.remove('hidden');
                        } else {
                            clearSearch.classList.add('hidden');
                        }
                    }

                    // Update active filters display
                    updateActiveFilters();
                }, 300);
            }

            // Search input handler
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    performSearch();
                }, 300);
            });

            // Teacher filter handler
            teacherFilter.addEventListener('change', function() {
                performSearch();
            });

            // Clear search handlers
            clearSearch.addEventListener('click', function() {
                searchInput.value = '';
                performSearch();
                searchInput.focus();
            });

            clearSearchBtn.addEventListener('click', function() {
                searchInput.value = '';
                teacherFilter.value = '';
                performSearch();
                searchInput.focus();
            });

            clearAllFilters.addEventListener('click', function() {
                searchInput.value = '';
                teacherFilter.value = '';
                performSearch();
                searchInput.focus();
            });

            // Enter key handler
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    clearTimeout(searchTimeout);
                    performSearch();
                }
            });

            // ESC key to clear search
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    this.value = '';
                    performSearch();
                    this.blur();
                }
            });

            // Individual filter clear functions (called from HTML)
            window.clearSearchFilter = function() {
                searchInput.value = '';
                performSearch();
                searchInput.focus();
            };

            window.clearTeacherFilter = function() {
                teacherFilter.value = '';
                performSearch();
            };
        });
    </script>
@endsection
