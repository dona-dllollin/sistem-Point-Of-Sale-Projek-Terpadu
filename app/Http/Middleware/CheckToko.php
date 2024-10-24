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
        $slugMarket = session('slug_market'); // Ambil slug dari session

        // Cari toko berdasarkan slug yang tersimpan di session
        $market = Market::where('slug', $slugMarket)->first();

        if ($user->role === 'kasir' && $user->market_id !== $market->id) {
            return redirect()->route('kasir.dashboard')->with('error', 'Anda tidak berhak mengakses toko cabang ini.');
        }
        return $next($request);
    }
}
