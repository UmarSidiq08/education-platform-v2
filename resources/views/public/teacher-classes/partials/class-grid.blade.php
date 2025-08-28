@if($teacherClasses->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($teacherClasses as $teacherClass)
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
                <!-- Header dengan gradient -->
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-4 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-medium bg-white bg-opacity-20 px-2 py-1 rounded-full">
                            {{ $teacherClass->subject ?? 'Umum' }}
                        </span>
                        <div class="flex items-center text-xs">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $teacherClass->approved_mentors_count }} Mentor
                        </div>
                    </div>
                    <h3 class="font-bold text-lg truncate" title="{{ $teacherClass->name }}">
                        {{ $teacherClass->name }}
                    </h3>
                </div>

                <!-- Content -->
                <div class="p-4">
                    <!-- Teacher Info dengan Foto Profil -->
                    <div class="flex items-center mb-3">
                        <!-- PERUBAHAN: Ganti SVG icon dengan foto profil -->
                        <div class="relative w-10 h-10 mr-3 flex-shrink-0">
                            <img src="{{ $teacherClass->teacher && $teacherClass->teacher->avatar ? asset('storage/' . $teacherClass->teacher->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($teacherClass->teacher->name ?? 'Teacher') . '&background=3B82F6&color=ffffff&size=40' }}"
                                alt="{{ $teacherClass->teacher->name ?? 'Teacher' }}"
                                class="w-full h-full rounded-full object-cover border-2 border-gray-200 transition-transform hover:scale-105"
                                loading="lazy"
                                onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($teacherClass->teacher->name ?? 'Teacher') }}&background=6B7280&color=ffffff&size=40'">

                            <!-- Optional: Status indicator (online/offline) -->
                            <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-400 border-2 border-white rounded-full"></div>
                        </div>

                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-900 truncate">{{ $teacherClass->teacher->name }}</p>
                            <p class="text-sm text-gray-500">eMaster</p>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($teacherClass->description)
                        <p class="text-sm text-gray-600 mb-4 line-clamp-3">
                            {{ Str::limit($teacherClass->description, 100) }}
                        </p>
                    @endif

                    <!-- Stats -->
                    <div class="flex justify-between items-center text-sm text-gray-500 mb-4">
                        <span>
                            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                            </svg>
                            {{ $teacherClass->approved_mentors_count }} Mentor
                        </span>
                        <span>
                            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $teacherClass->created_at->format('M Y') }}
                        </span>
                    </div>

                    <!-- Action Button -->
                    <a href="{{ route('public.teacher-classes.show', $teacherClass) }}"
                       class="w-full bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 text-center inline-block">
                        Lihat Detail & Mentor
                    </a>
                </div>

                <!-- Status Indicator -->
                @if($teacherClass->approved_mentors_count > 0)
                    <div class="bg-green-50 border-t border-green-200 px-4 py-2">
                        <span class="text-green-600 text-xs font-medium">
                            ✓ Tersedia Mentor
                        </span>
                    </div>
                @else
                    <div class="bg-yellow-50 border-t border-yellow-200 px-4 py-2">
                        <span class="text-yellow-600 text-xs font-medium">
                            ⏳ Menunggu Mentor
                        </span>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@else
    <div class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 48 48">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M34 40h10v-4a6 6 0 00-10.712-3.714M34 40H14m20 0v-4a9.971 9.971 0 00-.712-3.714M14 40H4v-4a6 6 0 0110.713-3.714M14 40v-4c0-1.313.253-2.566.713-3.714m0 0A9.971 9.971 0 0124 34c4.75 0 8.971 2.99 10.287 7.286"></path>
        </svg>
        <h3 class="mt-4 text-lg font-medium text-gray-900">Tidak ada mata pelajaran ditemukan</h3>
        <p class="mt-2 text-sm text-gray-500">
            @if(request('q'))
                Coba gunakan kata kunci yang berbeda untuk pencarian.
            @else
                Belum ada mata pelajaran yang tersedia saat ini.
            @endif
        </p>
        @if(request('q'))
            <a href="{{ route('public.teacher-classes.index') }}" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                Lihat Semua Mata Pelajaran
            </a>
        @endif
    </div>
@endif
