<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class InjectToko
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->role == 'kasir' && $user->market_id) {
            $slugMarket = $user->market->slug;

            // Jika slug_market dari URL berbeda dengan slug market user, redirect ke URL yang benar
            if ($request->route('slug_market') !== $slugMarket) {
                return redirect()->route('kasir.dashboard', ['slug_market' => $slugMarket]);
            }
        }
        return $next($request);
    }
}
