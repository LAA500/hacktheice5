<?php

namespace App\Http\Middleware;

use App\Facades\Cart;
use Closure;
use Illuminate\Http\Request;

class RedirectIfCartIsEmpty
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Cart::cartIsEmpty()) {
            return redirect()->route('cart');
        }

        return $next($request);
    }
}
