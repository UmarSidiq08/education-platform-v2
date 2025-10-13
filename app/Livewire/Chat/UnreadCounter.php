<?php

namespace App\Livewire\Chat;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class UnreadCounter extends Component
{
    public $unreadCount = 0;

    public function mount()
    {
        $this->updateUnreadCount();
    }

    public function updateUnreadCount()
    {
        $user = Auth::user();
        
        $this->unreadCount = Message::whereHas('conversation', function ($query) use ($user) {
            $query->where('mentor_id', $user->id)->orWhere('student_id', $user->id);
        })
        ->where('sender_id', '!=', $user->id)
        ->whereNull('read_at')
        ->count();
    }

    #[On('conversation-updated')]
    #[On('message-sent')]
    #[On('messages-read')]
    public function refreshCount()
    {
        $this->updateUnreadCount();
    }

    public function render()
    {
        return view('livewire.chat.unread-counter');
    }
}
