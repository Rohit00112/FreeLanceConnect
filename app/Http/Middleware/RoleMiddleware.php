<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (Auth::check() && in_array(Auth::user()->role->value, $roles)) {
            return $next($request);
        }
        return redirect('/')->with('toast.error', 'Unauthorized'); // Redirect if unauthorized
    }
}
