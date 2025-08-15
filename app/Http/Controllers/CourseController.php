<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Material;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display the specified course
     */
    public function show($id)
    {
        $course = ClassModel::with(['materials', 'mentor'])->findOrFail($id);
        $user = Auth::user();

        // Check if current user is the mentor of this course
        $isMentor = $user && $user->role === 'mentor' && $course->mentor_id === $user->id;

        return view('courses.show', compact('course', 'isMentor'));
    }

    /**
     * Show learning page for students
     */
    public function learn($id)
    {
        $course = ClassModel::with(['materials' => function($query) {
            $query->orderBy('order', 'asc');
        }, 'mentor'])->findOrFail($id);

        $user = Auth::user();

        // Only allow students and mentors to access learning page
        if (!$user || ($user->role !== 'siswa' && $user->role !== 'mentor')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk belajar di kelas ini.');
        }

        return view('courses.learn', compact('course'));
    }

    /**
     * Show form to add new material
     */
    public function addMaterial($courseId)
    {
        $course = ClassModel::findOrFail($courseId);
        $user = Auth::user();

        // Check if user is mentor and owns this course
        if (!$user || $user->role !== 'mentor' || $course->mentor_id !== $user->id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menambah materi di kelas ini.');
        }

        return view('materials.create', compact('course'));
    }

    /**
     * Store new material
     */
    public function storeMaterial(Request $request, $courseId)
    {
        $course = ClassModel::findOrFail($courseId);
        $user = Auth::user();

        // Check if user is mentor and owns this course
        if (!$user || $user->role !== 'mentor' || $course->mentor_id !== $user->id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menambah materi di kelas ini.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:text,video,document',
            'file' => 'nullable|file|mimes:pdf,doc,docx,mp4,avi,mov|max:50240', // 50MB max
        ]);

        $material = new Material();
        $material->course_id = $courseId;
        $material->title = $request->title;
        $material->content = $request->input('content');
        $material->type = $request->type;
        $material->order = Material::where('course_id', $courseId)->count() + 1;

        // Handle file upload if exists
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/materials'), $filename);
            $material->file_path = 'uploads/materials/' . $filename;
        }

        $material->save();

        return redirect()->route('courses.show', $courseId)
                         ->with('success', 'Materi berhasil ditambahkan!');
    }
}
