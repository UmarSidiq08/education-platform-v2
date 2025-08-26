<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\Activity;

class ProfileController extends Controller
{
    /**
     * Tampilkan form edit profile.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }


      public function show(): View
    {
        return view('user.profile', [
            'user' => Auth::user(),
        ]);
    }
    /**
     * Update profil user (versi Laravel Breeze default).
     */
 public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();

    try {
        // Handle avatar upload first
        if ($request->hasFile('avatar')) {
            $avatarFile = $request->file('avatar');
            
            // Validate file
            if (!$avatarFile->isValid()) {
                return Redirect::route('profile.edit')
                    ->withErrors(['avatar' => 'File avatar tidak valid atau rusak.']);
            }

            // Delete old avatar if exists
            if ($user->avatar) {
                Storage::delete('public/' . $user->avatar);
            }

            // Store new avatar with error handling
            try {
                $avatarPath = $avatarFile->store('avatars', 'public');
                if (!$avatarPath) {
                    throw new \Exception('Gagal menyimpan file avatar');
                }
                $user->avatar = $avatarPath;
            } catch (\Exception $e) {
                \Log::error('Avatar upload failed: ' . $e->getMessage());
                return Redirect::route('profile.edit')
                    ->withErrors(['avatar' => 'Gagal mengupload avatar. Silakan coba lagi.']);
            }
        }

        // Handle other fields
        $validatedData = $request->validated();

        // Remove avatar from validated data since we handled it separately
        unset($validatedData['avatar']);

        // Handle skills - convert array to JSON if needed
        if (isset($validatedData['skills']) && is_array($validatedData['skills'])) {
            $validatedData['skills'] = json_encode($validatedData['skills']);
        }

        $user->fill($validatedData);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Log activity
        Activity::create([
            'user_id' => $user->id,
            'action' => 'Updated profile information',
            'type' => 'info'
        ]);

        return Redirect::route('profile.edit')->with('status', 'profile-updated');

    } catch (\Exception $e) {
        \Log::error('Profile update failed: ' . $e->getMessage());
        return Redirect::route('profile.edit')
            ->withErrors(['general' => 'Terjadi kesalahan saat memperbarui profil. Silakan coba lagi.']);
    }
}

    /**
     * Hapus akun user.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Dashboard profile user.
     */
    public function index(): View
    {
        $user = Auth::user();
        $stats = [
            'projects' => 24,
            'tasks' => 156,
            'hours' => 1245,
            'achievements' => 12
        ];

        $activities = $user->activities()
            ->latest()
            ->limit(10)
            ->get();

        return view('user.profile', compact('user', 'stats', 'activities'));
    }

    /**
     * Update detail profile custom (termasuk avatar).
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:500',
            'skills' => 'nullable|array',
            'skills.*' => 'string|max:50',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = Auth::user();

        try {
            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                $avatarFile = $request->file('avatar');
                
                // Validate file
                if (!$avatarFile->isValid()) {
                    return redirect()->route('profile.index')
                        ->withErrors(['avatar' => 'File avatar tidak valid atau rusak.']);
                }

                // Delete old avatar if exists
                if ($user->avatar) {
                    Storage::delete('public/' . $user->avatar);
                }

                // Store new avatar with error handling
                try {
                    $avatarPath = $avatarFile->store('avatars', 'public');
                    if (!$avatarPath) {
                        throw new \Exception('Gagal menyimpan file avatar');
                    }
                    $user->avatar = $avatarPath;
                } catch (\Exception $e) {
                    \Log::error('Avatar upload failed in updateProfile: ' . $e->getMessage());
                    return redirect()->route('profile.index')
                        ->withErrors(['avatar' => 'Gagal mengupload avatar. Silakan coba lagi.']);
                }
            }

            // Prepare data for update
            $updateData = $request->only(['name', 'email', 'phone', 'location', 'bio']);

            // Handle skills - convert to JSON string
            if ($request->has('skills') && is_array($request->skills)) {
                $updateData['skills'] = json_encode($request->skills);
            } elseif ($request->has('skills') && is_null($request->skills)) {
                $updateData['skills'] = null;
            }

            $user->update($updateData);

            Activity::create([
                'user_id' => $user->id,
                'action' => 'Updated profile information',
                'type' => 'info'
            ]);

            return redirect()->route('profile.index')
                ->with('success', 'Profile berhasil diupdate!');

        } catch (\Exception $e) {
            \Log::error('Profile update failed in updateProfile: ' . $e->getMessage());
            return redirect()->route('profile.index')
                ->withErrors(['general' => 'Terjadi kesalahan saat memperbarui profil. Silakan coba lagi.']);
        }
    }

    /**
     * Upload avatar saja.
     */
    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'avatar.required' => 'File avatar wajib dipilih.',
            'avatar.image' => 'File yang diupload harus berupa gambar.',
            'avatar.mimes' => 'Format gambar yang didukung: JPEG, PNG, JPG, GIF.',
            'avatar.max' => 'Ukuran gambar maksimal 2MB.'
        ]);

        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak terautentikasi'
            ], 401);
        }

        try {
            $avatarFile = $request->file('avatar');
            
            // Validate file
            if (!$avatarFile->isValid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'File avatar tidak valid atau rusak.'
                ], 400);
            }

            // Delete old avatar if exists
            if ($user->avatar) {
                Storage::delete('public/' . $user->avatar);
            }

            // Store new avatar with error handling
            try {
                $avatarPath = $avatarFile->store('avatars', 'public');
                if (!$avatarPath) {
                    throw new \Exception('Gagal menyimpan file avatar');
                }
                
                $user->update(['avatar' => $avatarPath]);

                Activity::create([
                    'user_id' => $user->id,
                    'action' => 'Updated profile picture',
                    'type' => 'info'
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Avatar berhasil diupload!',
                    'avatar_url' => Storage::url($avatarPath)
                ]);

            } catch (\Exception $e) {
                \Log::error('Avatar upload failed in uploadAvatar: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengupload avatar. Silakan coba lagi.'
                ], 500);
            }

        } catch (\Exception $e) {
            \Log::error('Avatar upload process failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengupload avatar.'
            ], 500);
        }
    }
}

