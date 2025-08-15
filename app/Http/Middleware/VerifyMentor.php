<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class VerifyMentor
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user->role === 'mentor' && !$user->is_verified) {
            // Arahkan ke halaman khusus pending approval
            return redirect()->route('mentor.waiting');
        }

        return $next($request);
    }
}
