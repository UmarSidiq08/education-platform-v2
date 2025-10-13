@if($unreadCount > 0)
    <span class="bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold animate-pulse">
        {{ $unreadCount > 99 ? '99+' : $unreadCount }}
    </span>
@endif
