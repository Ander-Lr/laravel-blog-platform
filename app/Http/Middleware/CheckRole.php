<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    //The user must be authenticated or the role must be on the allowed list
    public function handle($request, Closure $next, ...$roles){
        if (!auth()->check() || !in_array(auth()->user()->role, $roles)){
            abort(403);
        }
        // Continue process
        return $next($request);
    }

}
