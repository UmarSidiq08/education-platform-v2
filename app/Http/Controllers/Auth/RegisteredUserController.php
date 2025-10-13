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
     public function store(Request $request): RedirectResponse
    {
        // Validasi dasar untuk semua role
        $validationRules = [
            'name' => 'required|string|min:3|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:siswa,mentor,guru',
        ];

        // Tambahkan validasi teacher_class_id hanya jika role adalah mentor
        if ($request->role === 'mentor') {
            $validationRules['teacher_class_id'] = 'required|exists:teacher_classes,id';
        }

        $request->validate($validationRules, [
            'name.required' => 'Nama wajib diisi.',
            'name.min' => 'Nama minimal 3 karakter.',
            'name.unique' => 'Nama sudah digunakan, silakan pilih yang lain.',
            'teacher_class_id.required' => 'Pilih kelas guru untuk mendaftar sebagai mentor.',
            'teacher_class_id.exists' => 'Kelas guru yang dipilih tidak valid.',
        ]);

        // Tentukan status verifikasi berdasarkan role
        $isVerified = match($request->role) {
            'guru' => true,      // Guru langsung verified
            'siswa' => true,     // Siswa langsung verified
            'mentor' => false,   // Mentor perlu verifikasi
            default => false
        };

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_verified' => $isVerified,
        ]);

        // Assign role menggunakan Spatie Permission
        $user->assignRole($request->role);

        // Jika mentor, buat request otomatis
        if ($request->role === 'mentor' && $request->teacher_class_id) {
            MentorRequest::create([
                'mentor_id' => $user->id,
                'teacher_class_id' => $request->teacher_class_id,
                'status' => 'pending',
                'requested_at' => now(),
                'request_origin' => 'registration', // Ini penambahan baris baru
            ]);
        }

        event(new Registered($user));

        // Redirect dengan pesan sesuai role
        $message = match($request->role) {
            'guru' => 'Pendaftaran berhasil! Akun guru Anda sudah aktif. Silakan login.',
            'siswa' => 'Pendaftaran berhasil! Silakan login untuk mulai belajar.',
            'mentor' => 'Pendaftaran berhasil! Akun mentor Anda menunggu verifikasi admin.',
            default => 'Pendaftaran berhasil! Silakan login.'
        };

        return redirect()->route('login')->with('success', $message);
    }

    /**
     * Check name availability
     */
    public function checkName(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255'
        ]);

        $exists = User::where('name', $request->name)->exists();

        return response()->json([
            'available' => !$exists,
            'message' => $exists ? 'Nama sudah digunakan' : 'Nama tersedia'
        ]);
    }
}
