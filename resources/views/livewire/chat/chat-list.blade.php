<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Pesan</h1>
            <p class="text-gray-600">Kelola percakapan Anda dengan mentor dan siswa</p>
        </div>

        <!-- Conversations List -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            @if(empty($conversations))
                <div class="p-8 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class=w"w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a8.959 8.959 0 01-2.4-.32l-4.6 1.92 1.92-4.6A8.959 8.959 0 013 12c0-4.418 3.582-8 8-8s8 3.582 8 8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada percakapan</h3>
                    <p class="text-gray-500 mb-4">Mulai percakapan dengan mentor atau siswa</p>
                    <a href="{{ route('mentor.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Cari Mentor
                    </a>
                </div>
            @else
                <div class="divide-y divide-gray-200">
                    @foreach($conversations as $conversation)
                        <a href="{{ route('chat.room', $conversation['id']) }}" 
                           class="block p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center space-x-4">
                                <!-- Avatar -->
                                <div class="relative">
                                    <img src="{{ $conversation['other_user']['avatar'] ? asset('storage/' . $conversation['other_user']['avatar']) : 'https://ui-avatars.com/api/?name=' . urlencode($conversation['other_user']['name']) }}" 
                                         alt="{{ $conversation['other_user']['name'] }}" 
                                         class="w-12 h-12 rounded-full object-cover">
                                    @if($conversation['unread_count'] > 0)
                                        <div class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">
                                            {{ $conversation['unread_count'] > 9 ? '9+' : $conversation['unread_count'] }}
                                        </div>
                                    @endif
                                </div>

                                <!-- Conversation Info -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-sm font-medium text-gray-900 truncate">
                                            {{ $conversation['other_user']['name'] }}
                                        </h3>
                                        @if($conversation['last_message_at'])
                                            <p class="text-xs text-gray-500">
                                                {{ \Carbon\Carbon::parse($conversation['last_message_at'])->diffForHumans() }}
                                            </p>
                                        @endif
                                    </div>
                                    
                                    <div class="flex items-center justify-between mt-1">
                                        <p class="text-sm text-gray-600 truncate">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $conversation['other_user']['role'] === 'mentor' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                                {{ $conversation['other_user']['role'] === 'mentor' ? 'Mentor' : 'Siswa' }}
                                            </span>
                                        </p>
                                        @if($conversation['latest_message'])
                                            <p class="text-sm text-gray-500 truncate ml-2">
                                                @if($conversation['latest_message']['sender_id'] === auth()->id())
                                                    <span class="text-gray-400">Anda: </span>
                                                @endif
                                                {{ Str::limit($conversation['latest_message']['body'], 30) }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Arrow -->
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
