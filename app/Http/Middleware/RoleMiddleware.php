<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (auth()->user()->role !== $role) {
            return redirect()->back()->withErrors('Anda tidak dapat mengakses halaman ini'); // Jika role tidak sesuai
        }

        return $next($request);
    }
}
