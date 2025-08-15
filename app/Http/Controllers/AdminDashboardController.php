<?php

namespace App\Http\Controllers;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {

        // Total semua user
        $totalUser = User::count();

        // Total berdasarkan role (Spatie)
        $totalSiswa = User::role('siswa')->count();
        $totalMentor = User::role('mentor')
        ->where('is_verified', true)
        ->count();
        $totalAdmin  = User::role('guru')->count();

        return view('admin.dashboard', compact(
            'totalUser',
            'totalSiswa',
            'totalMentor',
            'totalAdmin'
        ));
    }
}
