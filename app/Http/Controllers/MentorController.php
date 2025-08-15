<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class MentorController extends Controller
{
    public function pending(Request $request)
    {
        if ($request->ajax()) {
            try {
                $mentors = User::where('role', 'mentor')
                    ->where('is_verified', false)
                    ->select(['id', 'name', 'email', 'created_at']);

                return DataTables::of($mentors)
                    ->addColumn('created_at', function ($m) {
                        // Pastikan locale di AppServiceProvider: Carbon::setLocale('id');
                        return $m->created_at->translatedFormat('d F Y H:i'); // contoh: 11 Agustus 2025 14:45
                    })
                    ->addColumn('aksi', function ($m) {
                        $approveBtn = '<form action="' . route('mentor.approve', $m->id) . '" method="POST" style="display:inline">'
                            . csrf_field()
                            . '<button type="submit" class="btn btn-success btn-sm">Setujui</button></form>';

                        $rejectBtn = '<form action="' . route('mentor.reject', $m->id) . '" method="POST" style="display:inline">'
                            . csrf_field()
                            . '<button type="submit" class="btn btn-danger btn-sm">Tolak</button></form>';

                        return $approveBtn . ' ' . $rejectBtn;
                    })
                    ->rawColumns(['aksi'])
                    ->make(true);

            } catch (\Exception $e) {
                Log::error('DataTables Error: ' . $e->getMessage());

                return response()->json([
                    'error' => true,
                    'message' => 'Gagal memuat data mentor'
                ], 500);
            }
        }

        return view('admin.pending');
    }

    public function approve(User $user)
    {
        try {
            if ($user->role !== 'mentor') {
                return response()->json([
                    'success' => false,
                    'message' => 'User bukan mentor.'
                ], 400);
            }

            $user->update(['is_verified' => true]);

            // 🔹 Pastikan role di Spatie juga ada
            if (!$user->hasRole('mentor')) {
                $user->assignRole('mentor');
            }

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Mentor berhasil diverifikasi.'
                ]);
            }

            return back()->with('success', 'Mentor berhasil diverifikasi.');

        } catch (\Exception $e) {
            Log::error('Mentor Approve Error: ' . $e->getMessage());

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat memverifikasi mentor.'
                ], 500);
            }

            return back()->with('error', 'Terjadi kesalahan saat memverifikasi mentor.');
        }
    }

    public function reject(User $user)
    {
        try {
            if ($user->role !== 'mentor') {
                return response()->json([
                    'success' => false,
                    'message' => 'User bukan mentor.'
                ], 400);
            }

            // Hapus role mentor dari Spatie
            if ($user->hasRole('mentor')) {
                $user->removeRole('mentor');
            }

            // Assign role siswa di Spatie
            if (!$user->hasRole('siswa')) {
                $user->assignRole('siswa');
            }

            // Update di tabel users
            $user->update([
                'role' => 'siswa',
                'is_verified' => true
            ]);

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Permintaan mentor ditolak dan diubah menjadi siswa.'
                ]);
            }

            return back()->with('success', 'Permintaan mentor ditolak dan diubah menjadi siswa.');

        } catch (\Exception $e) {
            Log::error('Mentor Reject Error: ' . $e->getMessage());

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menolak mentor.'
                ], 500);
            }

            return back()->with('error', 'Terjadi kesalahan saat menolak mentor.');
        }
    }
}
