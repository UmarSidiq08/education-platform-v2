<?php

namespace App\Http\Controllers;

use App\Models\TeacherClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PublicTeacherClassController extends Controller
{

    public function index()
    {
        $teacherClasses = TeacherClass::with(['teacher', 'approvedMentors'])
            ->withCount('approvedMentors')
            ->orderBy('name')
            ->paginate(12);

        return view('public.teacher-classes.index', compact('teacherClasses'));
    }

    public function show(TeacherClass $teacherClass)
    {

        $teacherClass->load([
            'teacher',
            'approvedMentors' => function ($query) {
                $query->withPivot(['approved_at']);
            }
        ]);

        // Get implementation classes untuk teacher class ini (optional, untuk counting)
        $implementationClasses = $teacherClass->implementationClasses()
            ->with(['mentor'])
            ->withCount('materials')
            ->orderBy('created_at', 'desc')
            ->get();

        // Group implementation classes by mentor untuk checking
        $classesByMentor = $implementationClasses->groupBy('mentor_id');

        // Prepare mentor data dengan informasi dasar kelas (jika ada)
        $mentors = $teacherClass->approvedMentors->map(function ($mentor) use ($classesByMentor) {
            // Get classes untuk mentor ini (untuk checking purposes)
            $mentorClasses = $classesByMentor->get($mentor->id, collect());

            // Add basic properties
            $mentor->classes = $mentorClasses;
            $mentor->classes_count = $mentorClasses->count();

            return $mentor;
        })->sortByDesc('classes_count'); // Mentor dengan kelas dulu

        return view('public.teacher-classes.show', compact('teacherClass', 'mentors'));
    }


    public function showMentorClasses(TeacherClass $teacherClass, User $mentor)
    {
        // Pastikan mentor ini memang approved untuk teacher class ini
        if (!$teacherClass->hasMentorApproved($mentor->id)) {
            abort(404, 'Mentor tidak ditemukan dalam mata pelajaran ini.');
        }

        $mentorClasses = $teacherClass->implementationClasses()
            ->where('mentor_id', $mentor->id)
            ->with(['materials'])
            ->withCount('materials')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('public.teacher-classes.mentor-classes', compact('teacherClass', 'mentor', 'mentorClasses'));
    }

    /**
     * API untuk search teacher classes
     */
    /**
     * API untuk search teacher classes - Updated untuk realtime search
     */
    /**
 * API untuk search teacher classes - FIXED VERSION
 */
public function search(Request $request)
{
    $query = trim($request->get('q', ''));
    $isAjax = $request->ajax() || $request->get('ajax');

    // Build query dengan proper JOIN untuk orderByRaw
    $teacherClassesQuery = TeacherClass::query()
        ->with(['teacher'])
        ->withCount('approvedMentors')
        ->leftJoin('users as teacher', 'teacher_classes.teacher_id', '=', 'teacher.id'); // ✅ Tambahkan JOIN

    // Apply search filter jika ada query
    if (!empty($query)) {
        $teacherClassesQuery->where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('teacher_classes.name', 'like', "%{$query}%")
                ->orWhere('teacher_classes.subject', 'like', "%{$query}%")
                ->orWhere('teacher.name', 'like', "%{$query}%"); // ✅ Sekarang bisa pakai teacher.name
        });

        // Prioritas hasil pencarian - FIXED
        $teacherClassesQuery->orderByRaw("
            CASE
                WHEN teacher_classes.name LIKE ? THEN 1
                WHEN teacher_classes.subject LIKE ? THEN 2
                WHEN teacher.name LIKE ? THEN 3
                ELSE 4
            END, teacher_classes.name ASC
        ", ["%{$query}%", "%{$query}%", "%{$query}%"])
        ->select('teacher_classes.*'); // ✅ Pilih hanya kolom dari teacher_classes
    } else {
        $teacherClassesQuery->orderBy('teacher_classes.name', 'ASC')
            ->select('teacher_classes.*'); // ✅ Pilih hanya kolom dari teacher_classes
    }

    $teacherClasses = $teacherClassesQuery->paginate(12);
    $teacherClasses->appends(['q' => $query]); // Preserve query in pagination

    // Untuk AJAX request
    if ($isAjax) {
        try {
            $html = view('public.teacher-classes.partials.class-grid', compact('teacherClasses'))->render();
            $pagination = $teacherClasses->links()->render();

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => $pagination,
                'total' => $teacherClasses->total(),
                'count' => $teacherClasses->count(),
                'query' => $query,
                'has_results' => $teacherClasses->count() > 0,
                'message' => $teacherClasses->count() > 0
                    ? "Ditemukan {$teacherClasses->total()} mata pelajaran"
                    : "Tidak ada mata pelajaran yang ditemukan untuk '{$query}'"
            ]);
        } catch (\Exception $e) {
            Log::error('Search error: ' . $e->getMessage()); // ✅ Log error untuk debugging

            return response()->json([
                'success' => false,
                'error' => 'Terjadi kesalahan saat memuat data',
                'message' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    // Untuk request biasa (non-AJAX)
    $subjects = TeacherClass::distinct()
        ->whereNotNull('subject')
        ->pluck('subject')
        ->sort();

    return view('public.teacher-classes.index', compact('teacherClasses', 'query', 'subjects'));
}

    /**
     * Filter teacher classes by subject
     */
    public function filterBySubject(Request $request)
    {
        $subject = $request->get('subject');

        $teacherClasses = TeacherClass::with(['teacher'])
            ->when($subject, function ($query) use ($subject) {
                $query->where('subject', $subject);
            })
            ->withCount('approvedMentors')
            ->orderBy('name')
            ->paginate(12);

        $subjects = TeacherClass::distinct()
            ->whereNotNull('subject')
            ->pluck('subject')
            ->sort();

        return view('public.teacher-classes.index', compact('teacherClasses', 'subjects', 'subject'));
    }
}
