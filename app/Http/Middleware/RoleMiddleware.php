<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request                 $request
     * @param  \Closure                                  $next
     * @param  string[]                                  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Pastikan user sudah login
        if (! Auth::check()) {
            abort(403, 'Unauthorized');
        }

        // Jika tidak ada role yang diberikan pada middleware,
        // berarti cukup uji bahwa user terautentikasi (boleh lanjut)
        if (count($roles) === 0) {
            return $next($request);
        }

        // Cek apakah role user termasuk salah satu role yang diizinkan
        $userRole = Auth::user()->role;

        if (! in_array($userRole, $roles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
