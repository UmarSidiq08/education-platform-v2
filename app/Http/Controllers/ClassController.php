<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ClassController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Tampilkan semua classes
    public function index()
    {
        try {
            $classes = ClassModel::with('mentor')->latest()->get();
            return view('classes.index', compact('classes'));
        } catch (\Exception $e) {
            // Debug: tampilkan error
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    // Tampilkan classes milik mentor/guru yang login
    public function my()
    {
        // Cek apakah user adalah mentor atau guru
        // if (!Auth::user()->isMentor() && !Auth::user()->isGuru()) {
        //     return redirect()->route('classes.index')
        //         ->with('error', 'Only mentors and teachers can create classes.');
        // }

        $classes = ClassModel::where('mentor_id', Auth::id())->latest()->get();
        return view('classes.my', compact('classes'));
    }

    // Form create class
    public function create()
    {
        Log::info('Create method called');
        return view('classes.create');
    }


    // Store class baru
    public function store(Request $request)
    {
        // // Cek role
        // if (!Auth::user()->isMentor() && !Auth::user()->isGuru()) {
        //     return redirect()->route('classes.index')
        //         ->with('error', 'Only mentors and teachers can create classes.');
        // }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000'
        ]);

        ClassModel::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'mentor_id' => Auth::id(),
        ]);

        return redirect()->route('classes.my')
            ->with('success', 'Class created successfully!');
    }

    // Show detail class
    public function show($id)
    {
        $class = ClassModel::with('mentor')->findOrFail($id);
        return view('classes.show', compact('class'));
    }

    // Form edit class
    public function edit($id)
    {
        $class = ClassModel::where('mentor_id', Auth::id())->findOrFail($id);
        return view('classes.edit', compact('class'));
    }

    // Update class
    public function update(Request $request, $id)
    {
        $class = ClassModel::where('mentor_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000'
        ]);

        $class->update($validated);

        return redirect()->route('classes.my')
            ->with('success', 'Class updated successfully!');
    }

    // Delete class
    public function destroy($id)
    {
        $class = ClassModel::where('mentor_id', Auth::id())->findOrFail($id);
        $class->delete();

        return redirect()->route('classes.my')
            ->with('success', 'Class deleted successfully!');
    }

    // UPDATED: Method learn dengan logika completion 80%
    public function learn($id)
    {
        $class = ClassModel::with([
            'materials' => function ($query) {
                $query->orderBy('created_at', 'asc');
            },
            'materials.quizzes' => function ($query) {
                $query->where('is_active', true);
            }
        ])->findOrFail($id);

        // UPDATED: Hitung progress berdasarkan completion 80%
        $totalMaterials = $class->materials->count();
        $completedMaterials = 0;
        $progressPercentage = 0;

        if ($totalMaterials > 0) {
            foreach ($class->materials as $material) {
                $activeQuiz = $material->quizzes->where('is_active', true)->first();

                // UPDATED: Material dianggap selesai jika ada quiz dan user mencapai ≥80%
                if ($activeQuiz && $activeQuiz->isCompletedByUser(auth()->id())) {
                    $completedMaterials++;
                }
                // Jika tidak ada quiz aktif, material dianggap bisa diselesaikan tanpa syarat khusus
                // (opsional: Anda bisa ubah logika ini sesuai kebutuhan)
            }

            $progressPercentage = round(($completedMaterials / $totalMaterials) * 100);
        }

        // Cek role dan kepemilikan kelas
        if (auth()->user()->role === 'siswa') {
            return view('classes.learn', [
                'class' => $class,
                'isMentorOwner' => false,
                'totalMaterials' => $totalMaterials,
                'completedMaterials' => $completedMaterials,
                'progressPercentage' => $progressPercentage
            ]);
        }

        if (auth()->user()->role === 'mentor') {
            if ($class->mentor_id === auth()->id()) {
                return view('classes.learn', [
                    'class' => $class,
                    'isMentorOwner' => true,
                    'totalMaterials' => $totalMaterials,
                    'completedMaterials' => $completedMaterials,
                    'progressPercentage' => $progressPercentage
                ]);
            } else {
                return view('classes.learn', [
                    'class' => $class,
                    'isMentorOwner' => false,
                    'totalMaterials' => $totalMaterials,
                    'completedMaterials' => $completedMaterials,
                    'progressPercentage' => $progressPercentage
                ]);
            }
        }

        abort(403, 'Unauthorized action.');
    }
}
