<?php

namespace App\Http\Controllers;

use App\Models\TeacherClass;
use App\Models\ClassModel;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherClassController extends Controller
{
    public function index()
    {
        $teacherClasses = TeacherClass::where('teacher_id', auth()->id())->with('mentorRequests')->get();
        return view('teacher-classes.index', compact('teacherClasses'));
    }

    public function create()
    {
        return view('teacher-classes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'nullable|string|max:255',
            'description' => 'nullable|string'
        ]);

        TeacherClass::create([
            ...$validated,
            'teacher_id' => auth()->id()
        ]);

        return redirect()->route('teacher-classes.index')->with('success', 'TeacherClass berhasil dibuat!');
    }

    public function show(TeacherClass $teacherClass)
    {
        // Pastikan hanya teacher yang memiliki class ini yang bisa mengakses
        if ($teacherClass->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this teacher class.');
        }

        // Load semua relasi yang diperlukan
        $teacherClass->load([
            'mentorRequests.mentor',
            'implementationClasses' => function ($query) {
                $query->with(['mentor', 'materials']);
            }
        ]);

        return view('teacher-classes.show', compact('teacherClass'));
    }
    // Tambahkan method ini ke TeacherClassController.php

    public function edit(TeacherClass $teacherClass)
    {
        // Pastikan hanya teacher yang memiliki class ini yang bisa mengakses
        if ($teacherClass->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this teacher class.');
        }

        return view('teacher-classes.edit', compact('teacherClass'));
    }

    public function update(Request $request, TeacherClass $teacherClass)
    {
        // Pastikan hanya teacher yang memiliki class ini yang bisa mengakses
        if ($teacherClass->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this teacher class.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:2000'
        ]);

        $teacherClass->update($validated);

        return redirect()->route('teacher-classes.index')
            ->with('success', 'Kelas berhasil diperbarui!');
    }

    public function destroy(TeacherClass $teacherClass)
    {
        // Pastikan hanya teacher yang memiliki class ini yang bisa mengakses
        if ($teacherClass->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this teacher class.');
        }

        DB::transaction(function () use ($teacherClass) {
            // Hapus semua implementation classes beserta materials dan quiz
            foreach ($teacherClass->implementationClasses as $implementationClass) {
                // Hapus materials beserta quiz terkait
                foreach ($implementationClass->materials as $material) {
                    $material->quizzes()->delete();
                    $material->delete();
                }

                // Hapus post-tests
                $implementationClass->postTests()->delete();

                // Hapus implementation class
                $implementationClass->delete();
            }

            // Hapus mentor requests terkait
            $teacherClass->mentorRequests()->delete();

            // Hapus teacher class
            $teacherClass->delete();
        });

        return redirect()->route('teacher-classes.index')
            ->with('success', 'Kelas dan semua data terkait berhasil dihapus!');
    }
    public function implementation(TeacherClass $teacherClass)
    {
        // Pastikan hanya teacher yang memiliki class ini yang bisa mengakses
        if ($teacherClass->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this teacher class.');
        }

        // Load implementation classes dengan relasi yang diperlukan
        $teacherClass->load([
            'implementationClasses' => function ($query) {
                $query->with(['mentor', 'materials']);
            }
        ]);

        return view('teacher-classes.implementation', compact('teacherClass'));
    }


    // API untuk dropdown registration
    public function getForDropdown()
    {
        return response()->json(
            TeacherClass::with('teacher:id,name')->get()->map(fn($tc) => [
                'id' => $tc->id,
                'name' => $tc->full_name
            ])
        );
    }
    public function showMentorClass(TeacherClass $teacherClass, ClassModel $class)
    {
        // Validasi: pastikan guru adalah pemilik teacher class
        if ($teacherClass->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this teacher class.');
        }

        // Validasi: pastikan class ini milik teacher class tersebut
        if ($class->teacher_class_id !== $teacherClass->id) {
            abort(404, 'Class not found in this teacher class.');
        }

        // Load relasi yang diperlukan
        $class->load(['mentor', 'materials.quizzes', 'postTests']);

        return view('teacher-classes.mentor-class.show', compact('teacherClass', 'class'));
    }

    /**
     * Form edit mentor class untuk guru
     */
    public function editMentorClass(TeacherClass $teacherClass, ClassModel $class)
    {
        // Validasi: pastikan guru adalah pemilik teacher class
        if ($teacherClass->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this teacher class.');
        }

        // Validasi: pastikan class ini milik teacher class tersebut
        if ($class->teacher_class_id !== $teacherClass->id) {
            abort(404, 'Class not found in this teacher class.');
        }

        return view('teacher-classes.mentor-class.edit', compact('teacherClass', 'class'));
    }

    /**
     * Update mentor class oleh guru
     */
    public function updateMentorClass(Request $request, TeacherClass $teacherClass, ClassModel $class)
    {
        // Validasi: pastikan guru adalah pemilik teacher class
        if ($teacherClass->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this teacher class.');
        }

        // Validasi: pastikan class ini milik teacher class tersebut
        if ($class->teacher_class_id !== $teacherClass->id) {
            abort(404, 'Class not found in this teacher class.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'is_active' => 'boolean'
        ]);

        $class->update($validated);

        return redirect()->route('teacher-classes.mentor-class.show', [$teacherClass, $class])
            ->with('success', 'Class berhasil diupdate!');
    }

    /**
     * Delete mentor class oleh guru
     */
    public function destroyMentorClass(TeacherClass $teacherClass, ClassModel $class)
    {
        // Validasi: pastikan guru adalah pemilik teacher class
        if ($teacherClass->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this teacher class.');
        }

        // Validasi: pastikan class ini milik teacher class tersebut
        if ($class->teacher_class_id !== $teacherClass->id) {
            abort(404, 'Class not found in this teacher class.');
        }

        DB::transaction(function () use ($class) {
            // Hapus materials beserta quiz dan post-test terkait
            foreach ($class->materials as $material) {
                $material->quizzes()->delete();
                $material->delete();
            }

            // Hapus post-tests
            $class->postTests()->delete();

            // Hapus class
            $class->delete();
        });

        return redirect()->route('teacher-classes.implementation', $teacherClass)
            ->with('success', 'Class berhasil dihapus!');
    }

    /**
     * Show material detail untuk guru
     */
    public function showMaterial(TeacherClass $teacherClass, ClassModel $class, Material $material)
    {
        // Validasi: pastikan guru adalah pemilik teacher class
        if ($teacherClass->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this teacher class.');
        }

        // Validasi: pastikan class ini milik teacher class tersebut
        if ($class->teacher_class_id !== $teacherClass->id) {
            abort(404, 'Class not found in this teacher class.');
        }

        // Validasi: pastikan material ini milik class tersebut
        if ($material->class_id !== $class->id) {
            abort(404, 'Material not found in this class.');
        }

        $material->load(['quizzes', 'class.mentor']);

        return view('teacher-classes.mentor-class.material.show', compact('teacherClass', 'class', 'material'));
    }

    /**
     * Edit material untuk guru
     */
    public function editMaterial(TeacherClass $teacherClass, ClassModel $class, Material $material)
    {
        // Validasi: pastikan guru adalah pemilik teacher class
        if ($teacherClass->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this teacher class.');
        }

        // Validasi: pastikan class ini milik teacher class tersebut
        if ($class->teacher_class_id !== $teacherClass->id) {
            abort(404, 'Class not found in this teacher class.');
        }

        // Validasi: pastikan material ini milik class tersebut
        if ($material->class_id !== $class->id) {
            abort(404, 'Material not found in this class.');
        }

        return view('teacher-classes.mentor-class.material.edit', compact('teacherClass', 'class', 'material'));
    }

    /**
     * Update material oleh guru
     */
    public function updateMaterial(Request $request, TeacherClass $teacherClass, ClassModel $class, Material $material)
    {
        // Validasi: pastikan guru adalah pemilik teacher class
        if ($teacherClass->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this teacher class.');
        }

        // Validasi: pastikan class ini milik teacher class tersebut
        if ($class->teacher_class_id !== $teacherClass->id) {
            abort(404, 'Class not found in this teacher class.');
        }

        // Validasi: pastikan material ini milik class tersebut
        if ($material->class_id !== $class->id) {
            abort(404, 'Material not found in this class.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'video_url' => 'nullable|url',
            'is_active' => 'boolean'
        ]);

        $material->update($validated);

        return redirect()->route('teacher-classes.mentor-class.material.show', [$teacherClass, $class, $material])
            ->with('success', 'Material berhasil diupdate!');
    }

    /**
     * Delete material oleh guru
     */
    public function destroyMaterial(TeacherClass $teacherClass, ClassModel $class, Material $material)
    {
        // Validasi: pastikan guru adalah pemilik teacher class
        if ($teacherClass->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this teacher class.');
        }

        // Validasi: pastikan class ini milik teacher class tersebut
        if ($class->teacher_class_id !== $teacherClass->id) {
            abort(404, 'Class not found in this teacher class.');
        }

        // Validasi: pastikan material ini milik class tersebut
        if ($material->class_id !== $class->id) {
            abort(404, 'Material not found in this class.');
        }

        DB::transaction(function () use ($material) {
            // Hapus quiz terkait material
            $material->quizzes()->delete();

            // Hapus material
            $material->delete();
        });

        return redirect()->route('teacher-classes.mentor-class.show', [$teacherClass, $class])
            ->with('success', 'Material berhasil dihapus!');
    }

    /**
     * Toggle status class (active/inactive)
     */
    public function toggleClassStatus(TeacherClass $teacherClass, ClassModel $class)
    {
        // Validasi: pastikan guru adalah pemilik teacher class
        if ($teacherClass->teacher_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this teacher class.');
        }

        // Validasi: pastikan class ini milik teacher class tersebut
        if ($class->teacher_class_id !== $teacherClass->id) {
            abort(404, 'Class not found in this teacher class.');
        }

        $class->update(['is_active' => !$class->is_active]);

        $status = $class->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Class berhasil {$status}!");
    }
}
