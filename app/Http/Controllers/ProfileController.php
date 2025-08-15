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

    /**
     * Update profil user (versi Laravel Breeze default).
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Handle skills - convert array to JSON if needed
        $validatedData = $request->validated();
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

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::delete('public/' . $user->avatar);
            }
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
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
    }

    /**
     * Upload avatar saja.
     */
    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        // Delete old avatar if exists
        if ($user->avatar) {
            Storage::delete('public/' . $user->avatar);
        }

        // Store new avatar
        $avatarPath = $request->file('avatar')->store('avatars', 'public');
        $user->update(['avatar' => $avatarPath]);

        Activity::create([
            'user_id' => $user->id,
            'action' => 'Updated profile picture',
            'type' => 'info'
        ]);

        return response()->json([
            'success' => true,
            'avatar_url' => Storage::url($avatarPath)
        ]);
    }
}

