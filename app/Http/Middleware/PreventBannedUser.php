<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PreventBannedUser
{
    public function handle(Request $request, Closure $next): mixed
    {
        if ($request->user() && $request->user()->isBanned()) {
            auth()->logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Akun Anda telah dinonaktifkan. Hubungi support.']);
        }

        return $next($request);
    }
}
