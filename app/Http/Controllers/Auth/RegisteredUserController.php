<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MentorRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
// Update method store di RegisteredUserController.php existing

public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'role' => 'required|in:siswa,mentor',
        'teacher_class_id' => 'required_if:role,mentor|exists:teacher_classes,id'
    ]);

    $isVerified = $request->role === 'mentor' ? false : true;

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        'is_verified' => $isVerified,
    ]);

    $user->assignRole($request->role);

    // Jika mentor, buat request otomatis
    if ($request->role === 'mentor' && $request->teacher_class_id) {
        MentorRequest::create([
            'mentor_id' => $user->id,
            'teacher_class_id' => $request->teacher_class_id,
            'status' => 'pending',
            'requested_at' => now()
        ]);
    }

    event(new Registered($user));

    return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan login.');
}
}
