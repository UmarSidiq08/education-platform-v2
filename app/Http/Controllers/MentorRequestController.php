<?php

namespace App\Http\Controllers;

use App\Models\MentorRequest;
use App\Models\TeacherClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MentorRequestController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacher_class_id' => 'required|exists:teacher_classes,id'
        ]);

        MentorRequest::create([
            'mentor_id' => auth()->id(),
            'teacher_class_id' => $validated['teacher_class_id'],
            'status' => 'pending',
            'requested_at' => now()
        ]);

        return back()->with('success', 'Request berhasil dikirim ke guru!');
    }

    public function approve(MentorRequest $mentorRequest)
    {
        if ($mentorRequest->teacherClass->teacher_id !== auth()->id()) {
            abort(403);
        }

        $mentorRequest->approve();

        // Update user mentor menjadi verified
        $mentorRequest->mentor->update(['is_verified' => true]);

        return back()->with('success', 'Mentor berhasil disetujui!');
    }

public function reject(MentorRequest $mentorRequest)
{
    if ($mentorRequest->teacherClass->teacher_id !== auth()->id()) {
        abort(403);
    }

    try {
        // Tolak request
        $mentorRequest->reject();

        $user = $mentorRequest->mentor; // <- ganti user jadi mentor
        if ($user) {
            // Sinkron role Spatie langsung
            $user->syncRoles(['siswa']);

            // Update field tambahan
            $user->is_verified = true;
            $user->role = 'siswa'; // opsional
            $user->save();
        }

        return back()->with('success', 'Request mentor ditolak dan user diubah menjadi siswa.');
    } catch (\Exception $e) {
        Log::error('Reject Mentor Error: '.$e->getMessage());
        return back()->with('error', 'Terjadi kesalahan saat menolak mentor.');
    }
}




    // Untuk guru lihat pending requests di TeacherClass mereka
    public function pendingRequests()
    {
        $requests = MentorRequest::with(['mentor', 'teacherClass'])
            ->whereHas('teacherClass', function($q) {
                $q->where('teacher_id', auth()->id());
            })
            ->pending()
            ->latest()
            ->get();

        return view('mentor-requests.pending', compact('requests'));
    }

    // Method baru untuk melihat request berdasarkan teacher class
    public function byClass(TeacherClass $teacherClass)
    {
        // Pastikan hanya teacher yang memiliki class ini yang bisa mengakses
        if ($teacherClass->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this teacher class.');
        }

        $requests = MentorRequest::with(['mentor', 'teacherClass'])
            ->where('teacher_class_id', $teacherClass->id)
            ->latest()
            ->paginate(10);

        return view('mentor-requests.by-class', compact('requests', 'teacherClass'));
    }
}
