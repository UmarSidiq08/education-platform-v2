<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('chat.index') }}" 
                       class="inline-flex items-center text-gray-500 hover:text-gray-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                    <div class="flex items-center space-x-3">
                        <img src="{{ $otherUser->avatar ? asset('storage/' . $otherUser->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($otherUser->name) }}" 
                             alt="{{ $otherUser->name }}" 
                             class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <h1 class="text-xl font-bold text-gray-900">{{ $otherUser->name }}</h1>
                            <p class="text-sm text-gray-500">
                                @if($otherUser->role === 'mentor')
                                    Mentor
                                @else
                                    Siswa
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="flex items-center space-x-1 text-sm text-green-600">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        <span>Online</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden" style="height: 600px;">
            <div class="flex h-full">
                <!-- Chat Area -->
                <div class="flex-1 flex flex-col">
                    <!-- Messages Container -->
                    <div class="flex-1 overflow-y-auto p-4 space-y-4" id="messagesContainer" wire:poll.3s="refreshMessages">
                        @foreach($messages as $message)
                            <div class="flex {{ $message['sender_id'] === auth()->id() ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-xs lg:max-w-md">
                                    @if($message['sender_id'] !== auth()->id())
                                        <div class="flex items-start space-x-2">
                                            <img src="{{ $message['sender']['avatar'] ? asset('storage/' . $message['sender']['avatar']) : 'https://ui-avatars.com/api/?name=' . urlencode($message['sender']['name']) }}" 
                                                 alt="{{ $message['sender']['name'] }}" 
                                                 class="w-8 h-8 rounded-full object-cover">
                                            <div>
                                                <div class="bg-gray-100 rounded-lg px-4 py-2">
                                                    <p class="text-gray-900">{{ $message['body'] }}</p>
                                                    @if($message['attachment_path'])
                                                        <div class="mt-2">
                                                            <a href="{{ asset('storage/' . $message['attachment_path']) }}" 
                                                               target="_blank" 
                                                               class="inline-flex items-center text-blue-600 hover:text-blue-800">
                                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                                                </svg>
                                                                {{ basename($message['attachment_path']) }}
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    {{ \Carbon\Carbon::parse($message['sent_at'])->format('H:i') }}
                                                    @if($message['read_at'])
                                                        <span class="text-blue-500">✓✓</span>
                                                    @else
                                                        <span class="text-gray-400">✓</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex items-start space-x-2 justify-end">
                                            <div>
                                                <div class="bg-blue-600 text-white rounded-lg px-4 py-2">
                                                    <p>{{ $message['body'] }}</p>
                                                    @if($message['attachment_path'])
                                                        <div class="mt-2">
                                                            <a href="{{ asset('storage/' . $message['attachment_path']) }}" 
                                                               target="_blank" 
                                                               class="inline-flex items-center text-blue-200 hover:text-white">
                                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                                                </svg>
                                                                {{ basename($message['attachment_path']) }}
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>
                                                <p class="text-xs text-gray-500 mt-1 text-right">
                                                    {{ \Carbon\Carbon::parse($message['sent_at'])->format('H:i') }}
                                                    @if($message['read_at'])
                                                        <span class="text-blue-500">✓✓</span>
                                                    @else
                                                        <span class="text-gray-400">✓</span>
                                                    @endif
                                                </p>
                                            </div>
                                            <img src="{{ $message['sender']['avatar'] ? asset('storage/' . $message['sender']['avatar']) : 'https://ui-avatars.com/api/?name=' . urlencode($message['sender']['name']) }}" 
                                                 alt="{{ $message['sender']['name'] }}" 
                                                 class="w-8 h-8 rounded-full object-cover">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Message Input -->
                    <div class="border-t border-gray-200 p-4">
                        <form wire:submit="sendMessage" class="flex items-end space-x-2">
                            <div class="flex-1">
                                <!-- File Upload Preview -->
                                @if($attachment)
                                    <div class="mb-2 p-2 bg-gray-50 rounded-lg flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                            </svg>
                                            <span class="text-sm text-gray-700">{{ $attachment->getClientOriginalName() }}</span>
                                        </div>
                                        <button type="button" wire:click="$set('attachment', null)" class="text-red-500 hover:text-red-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                @endif

                                <!-- Message Input -->
                                <div class="flex items-end space-x-2">
                                    <div class="flex-1 relative">
                                        <textarea 
                                            wire:model="messageBody"
                                            placeholder="Ketik pesan..."
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                                            rows="1"
                                            style="min-height: 40px; max-height: 120px;"
                                            wire:keydown.enter.prevent="sendMessage"
                                        ></textarea>
                                    </div>
                                    
                                    <!-- File Upload Button -->
                                    <label class="cursor-pointer p-2 text-gray-500 hover:text-gray-700 transition-colors">
                                        <input type="file" wire:model="attachment" class="hidden" accept="image/*,.pdf,.doc,.docx">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                        </svg>
                                    </label>

                                    <!-- Send Button -->
                                    <button 
                                        type="submit"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                        wire:loading.attr="disabled"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Auto-scroll script -->
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('scroll-to-bottom', () => {
                const container = document.getElementById('messagesContainer');
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            });
        });

        // Auto-scroll on page load
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('messagesContainer');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        });
    </script>
</div>
