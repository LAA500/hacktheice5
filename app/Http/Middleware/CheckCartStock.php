<?php

namespace App\Http\Middleware;

use App\Facades\Cart;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CheckCartStock
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
        foreach (Cart::items() as $cartItem) {
            if ($cartItem->isNotAvailable()) {
                return $this->redirectToCartWithError($cartItem);
            }
        }

        return $next($request);
    }

    private function redirectToCartWithError($cartItem)
    {
        return new JsonResponse([
            'success' => false,
            'message' => trans_choice('system.not_have_enough_quantity_in_stock', $cartItem->product->qty, [
                'name' => $cartItem->product->name,
                'stock' => $cartItem->product->qty,
                'unit' => $cartItem->product->unit,
            ], 'ru'),
        ]);
    }
}
