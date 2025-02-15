<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $type): Response
    {
        if ($request->user() instanceof ("App\Models\User\\" . ucfirst($type))) {
            return $next($request);
        }

        if ($request->user() instanceof ("App\Models\Library\\" . ucfirst($type))) {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}
