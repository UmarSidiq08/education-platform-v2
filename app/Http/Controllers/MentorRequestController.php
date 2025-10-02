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
        // Tambahkan validasi untuk request_origin
        $validated = $request->validate([
            'teacher_class_id' => 'required|exists:teacher_classes,id',
            'request_origin' => 'nullable|string' // Validasi baru
        ]);

        MentorRequest::create([
            'mentor_id' => auth()->id(),
            'teacher_class_id' => $validated['teacher_class_id'],
            'status' => 'pending',
            'requested_at' => now(),
            // Simpan nilai request_origin dari form
            'request_origin' => $validated['request_origin'] ?? 'class_page',
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

            // Cek asal request. Ini adalah logika baru yang membedakan
            if ($mentorRequest->request_origin === 'registration') {
                $user = $mentorRequest->mentor;
                if ($user) {
                    // Logika ini hanya akan dijalankan jika request berasal dari registrasi
                    $user->syncRoles(['siswa']);
                    $user->is_verified = true;
                    $user->role = 'siswa';
                    $user->save();
                }
                return back()->with('success', 'Request mentor ditolak dan role user diubah menjadi siswa.');
            }

            // Jika request tidak berasal dari registrasi, hanya tolak request tanpa mengubah role
            return back()->with('success', 'Request mentor ditolak.');
        } catch (\Exception $e) {
            Log::error('Reject Mentor Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menolak mentor.');
        }
    }




    // Untuk guru lihat pending requests di TeacherClass mereka
    public function pendingRequests()
    {
        $requests = MentorRequest::with(['mentor', 'teacherClass'])
            ->whereHas('teacherClass', function ($q) {
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
        // if ($teacherClass->teacher_id !== auth()->id()) {
        //     abort(403, 'Unauthorized access to this teacher class.');
        // }

        $requests = MentorRequest::with(['mentor', 'teacherClass'])
            ->where('teacher_class_id', $teacherClass->id)
            ->latest()
            ->paginate(10);

        return view('mentor-requests.by-class', compact('requests', 'teacherClass'));
    }
}
