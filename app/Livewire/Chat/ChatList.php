<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ChatList extends Component
{
    public $conversations = [];
    public $totalUnreadCount = 0;

    public function mount()
    {
        $this->loadConversations();
    }

    public function loadConversations()
    {
        $this->conversations = Conversation::forUser(Auth::id())
            ->with(['mentor', 'student', 'latestMessage.sender'])
            ->orderBy('last_message_at', 'desc')
            ->get()
            ->map(function ($conversation) {
                $otherUser = $conversation->getOtherUser(Auth::id());
                $unreadCount = $conversation->unreadMessagesCount(Auth::id());
                
                return [
                    'id' => $conversation->id,
                    'other_user' => $otherUser,
                    'latest_message' => $conversation->latestMessage,
                    'unread_count' => $unreadCount,
                    'last_message_at' => $conversation->last_message_at,
                ];
            })
            ->toArray();

        $this->totalUnreadCount = collect($this->conversations)->sum('unread_count');
    }

    #[On('conversation-updated')]
    public function refreshConversations()
    {
        $this->loadConversations();
    }

    public function render()
    {
        return view('livewire.chat.chat-list');
    }
}
