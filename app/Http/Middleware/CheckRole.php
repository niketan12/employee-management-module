<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $roles)
    {
        $user = $request->user();

        if (! $user || ! collect(explode('|', $roles))->contains(fn ($role) => $user->hasRole($role))) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
