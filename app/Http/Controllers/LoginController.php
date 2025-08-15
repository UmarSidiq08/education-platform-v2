<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    protected function authenticated(Request $request, $user)
    {


        if ($user->hasRole('guru')) {
            return redirect()->route('admin.dashboard');
        }

        // Mentor & Siswa sama-sama ke /dashboard
        return redirect()->route('dashboard');
    }

}
