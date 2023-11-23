<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartActRequest;
use Illuminate\Http\Request;
use App\Facades\Cart;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware(
            \App\Http\Middleware\CheckCartStock::class,
        )->only('stock_check');
    }

    public function index()
    {
        return view('public.cart');
    }

    public function act(CartActRequest $request, $act)
    {
        $productId = $request->input('uuid');

        match ($act) {
            'add' => Cart::store($productId),
            'recalc' => Cart::updateQuantity($request->index, $request->type),
            'remove' =>  Cart::remove($request->index),
            'clear' => Cart::clearCart(),
        };

        return Cart::instance();
    }

    public function stock_check(Request $request)
    {
        return new JsonResponse([
            'success' => true,
        ]);
    }
}
