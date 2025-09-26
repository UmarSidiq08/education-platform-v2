<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Display chat list
     */
    public function index()
    {
        return view('chat.index');
    }

    /**
     * Show specific chat room
     */
    public function room(Conversation $conversation)
    {
        // Check if user is authorized to access this conversation
        if ($conversation->mentor_id !== Auth::id() && $conversation->student_id !== Auth::id()) {
            abort(403, 'Unauthorized access to conversation');
        }

        return view('chat.room', compact('conversation'));
    }

    /**
     * Start a new conversation with a mentor
     */
    public function startConversation(Request $request)
    {
        $request->validate([
            'mentor_id' => 'required|exists:users,id',
        ]);

        $user = Auth::user();
        $mentorId = $request->mentor_id;

        // Check if mentor exists and has mentor role
        $mentor = User::where('id', $mentorId)->where('role', 'mentor')->first();
        if (!$mentor) {
            return redirect()->back()->with('error', 'Mentor tidak ditemukan.');
        }

        // Check if conversation already exists
        $conversation = Conversation::where(function ($query) use ($user, $mentorId) {
            $query->where('mentor_id', $mentorId)->where('student_id', $user->id);
        })->orWhere(function ($query) use ($user, $mentorId) {
            $query->where('mentor_id', $user->id)->where('student_id', $mentorId);
        })->first();

        // Create new conversation if doesn't exist
        if (!$conversation) {
            $conversation = Conversation::create([
                'mentor_id' => $user->role === 'mentor' ? $user->id : $mentorId,
                'student_id' => $user->role === 'mentor' ? $mentorId : $user->id,
                'last_message_at' => now(),
            ]);
        }

        return redirect()->route('chat.room', $conversation);
    }

    /**
     * Get unread message count for user
     */
    public function getUnreadCount()
    {
        $user = Auth::user();
        
        $unreadCount = \App\Models\Message::whereHas('conversation', function ($query) use ($user) {
            $query->forUser($user->id);
        })
        ->where('sender_id', '!=', $user->id)
        ->whereNull('read_at')
        ->count();

        return response()->json(['unread_count' => $unreadCount]);
    }
}
