<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    // Menampilkan form tambah materi
    public function create(ClassModel $class)
    {
        if ($class->mentor_id !== auth()->id()) {
            abort(403);
        }

        return view('materials.create', compact('class'));
    }

    // Menyimpan materi baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'class_id' => 'required|exists:classes,id',
            'is_published' => 'boolean',
            'video' => 'nullable|mimes:mp4,mov,avi|max:102400',
            'video_url' => 'nullable|url',
            'video_thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Authorization
        $class = ClassModel::findOrFail($validated['class_id']);
        if ($class->mentor_id !== auth()->id()) {
            abort(403);
        }

        // Handle uploads
        $materialData = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'content' => $validated['content'],
            'class_id' => $validated['class_id'],
            'is_published' => $validated['is_published'] ?? false,
        ];

        // Video File
        if ($request->hasFile('video')) {
            $materialData['video_path'] = $request->file('video')
                ->store('public/materials/videos'); // Tambah 'public/'
            $materialData['video_path'] = str_replace('public/', '', $materialData['video_path']); // Simpan tanpa 'public/'
        }

        if ($request->filled('video_url')) {
            $materialData['video_url'] = $validated['video_url'];
        }

        if ($request->hasFile('video_thumbnail')) {
            $path = $request->file('video_thumbnail')
                ->store('public/materials/thumbnails');
            $materialData['video_thumbnail'] = str_replace('public/', '', $path);
        }

        $material = Material::create($materialData);

        return redirect()->route('classes.show', $class->id)
            ->with('success', 'Materi berhasil dibuat!');
    }
    // Menampilkan detail materi
    public function show(Material $material)
    {
        return view('materials.show', compact('material'));
    }

    // Form edit materi
    public function edit(Material $material)
    {
        if ($material->class->mentor_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('materials.edit', compact('material'));
    }

    // Update materi
    public function update(Request $request, Material $material)
    {
        if ($material->class->mentor_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'is_published' => 'boolean',
            'video' => 'nullable|mimes:mp4,mov,avi,wmv,flv,webm|max:102400',
            'video_url' => 'nullable|url',
            'remove_video' => 'nullable|boolean',
        ]);

        $materialData = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'content' => $request->input('content'),
            'is_published' => $validated['is_published'] ?? false,
        ];

        // Handle video removal
        if ($request->has('remove_video') && $request->remove_video) {
            if ($material->video_path && Storage::disk('public')->exists($material->video_path)) {
                Storage::disk('public')->delete($material->video_path);
            }
            $materialData['video_path'] = null;
            $materialData['video_url'] = null;
        }

        // Handle new video upload
        if ($request->hasFile('video')) {
            // Delete old video if exists
            if ($material->video_path && Storage::disk('public')->exists($material->video_path)) {
                Storage::disk('public')->delete($material->video_path);
            }

            $videoPath = $request->file('video')->store('materials/videos', 'public');
            $materialData['video_path'] = $videoPath;
            $materialData['video_url'] = null; // Clear video URL if uploading file
        }

        // Handle video URL
        if ($request->filled('video_url') && !$request->hasFile('video')) {
            $materialData['video_url'] = $this->processVideoUrl($validated['video_url']);
            // Don't remove video_path here, let user explicitly remove it
        }

        $material->update($materialData);

        return redirect()->route('classes.show', $material->class_id)
            ->with('success', 'Materi berhasil diperbarui!');
    }

    // Hapus materiii
    public function destroy(Material $material)
    {
        if ($material->class->mentor_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete associated video file
        if ($material->video_path && Storage::disk('public')->exists($material->video_path)) {
            Storage::disk('public')->delete($material->video_path);
        }

        $material->delete();

        return redirect()->route('classes.show', $material->class_id)
            ->with('success', 'Materi berhasil dihapus!');
    }

    /**
     * Process video URL to get embed URL
     */
    private function processVideoUrl($url)
    {
        // YouTube URL processing
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }

        // Vimeo URL processing
        if (preg_match('/vimeo\.com\/(\d+)/', $url, $matches)) {
            return 'https://player.vimeo.com/video/' . $matches[1];
        }

        // Return original URL if not recognized
        return $url;
        
    }
}
