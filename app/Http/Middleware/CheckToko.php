<?php

namespace App\Http\Middleware;

use App\Models\Market;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckToko
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $tokoId = Market::where('slug', $request->route('slug_market'))->first();

        if ($user->role === 'kasir' && $user->market_id !== $tokoId->id) {
            return redirect()->route('kasir.dashboard')->with('error', 'Anda tidak berhak mengakses toko cabang ini.');
        }
        return $next($request);
    }
}
