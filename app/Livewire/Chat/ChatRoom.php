<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class ChatRoom extends Component
{
    use WithFileUploads;

    public Conversation $conversation;
    public $messageBody = '';
    public $attachment;
    public $messages = [];
    public $otherUser;

    public function mount(Conversation $conversation)
    {
        $this->conversation = $conversation;
        
        // Check if user is authorized to access this conversation
        if ($conversation->mentor_id !== Auth::id() && $conversation->student_id !== Auth::id()) {
            abort(403, 'Unauthorized access to conversation');
        }

        // Get the other user in the conversation
        $this->otherUser = $conversation->getOtherUser(Auth::id());

        $this->loadMessages();
        $this->markMessagesAsRead();
    }

    public function loadMessages()
    {
        $this->messages = $this->conversation->messages()
            ->with('sender')
            ->orderBy('sent_at')
            ->get()
            ->toArray();
    }

    public function sendMessage()
    {
        $this->validate([
            'messageBody' => 'required|string|max:1000',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx|max:10240',
        ]);

        $attachmentPath = null;
        if ($this->attachment) {
            $attachmentPath = $this->attachment->store('chat-attachments', 'public');
        }

        $message = Message::create([
            'conversation_id' => $this->conversation->id,
            'sender_id' => Auth::id(),
            'body' => $this->messageBody,
            'attachment_path' => $attachmentPath,
            'sent_at' => now(),
        ]);

        // Update conversation's last message time
        $this->conversation->update([
            'last_message_at' => now(),
        ]);

        // Load the sender relationship
        $message->load('sender');

        // Reset form
        $this->messageBody = '';
        $this->attachment = null;

        // Reload messages
        $this->loadMessages();

        // Dispatch event to other users in the same conversation
        $this->dispatch('message-sent', [
            'conversationId' => $this->conversation->id,
            'message' => $message->toArray(),
        ]);

        // Dispatch to update conversation list
        $this->dispatch('conversation-updated');

        // Scroll to bottom
        $this->dispatch('scroll-to-bottom');
    }

    #[On('message-sent')]
    public function onMessageSent($data)
    {
        // Only update if it's for this conversation and not from current user
        if ($data['conversationId'] == $this->conversation->id && 
            $data['message']['sender_id'] != Auth::id()) {
            $this->loadMessages();
            $this->markMessagesAsRead();
            $this->dispatch('scroll-to-bottom');
        }
    }

    #[On('refresh-messages')]
    public function refreshMessages()
    {
        $this->loadMessages();
    }

    public function markMessagesAsRead()
    {
        $messageIds = Message::where('conversation_id', $this->conversation->id)
            ->where('sender_id', '!=', Auth::id())
            ->whereNull('read_at')
            ->pluck('id')
            ->toArray();

        if (!empty($messageIds)) {
            Message::whereIn('id', $messageIds)->update(['read_at' => now()]);
            
            // Dispatch read status update to other users
            $this->dispatch('messages-read', [
                'conversationId' => $this->conversation->id,
                'messageIds' => $messageIds,
            ]);

            // Update conversation list
            $this->dispatch('conversation-updated');
        }
    }

    #[On('messages-read')]
    public function onMessagesRead($data)
    {
        // Only update if it's for this conversation
        if ($data['conversationId'] == $this->conversation->id) {
            $this->loadMessages();
        }
    }

    public function render()
    {
        return view('livewire.chat.chat-room');
    }
}
