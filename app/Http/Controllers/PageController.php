<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Order;
use App\Models\Shop;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware(\App\Http\Middleware\RedirectIfCartIsEmpty::class)->only('checkout');
    }

    public function index()
    {
        $districts = City::all()->groupBy('district');

        $city = City::query()->where('uuid', session('city.uuid'))->with('shops')->first();

        if (is_null($city)) {
            $city = City::query()->first();
        }

        return view('public.index', compact('districts', 'city'));
    }

    public function shop(Shop $shop)
    {
        return view('public.shop', compact('shop'));
    }

    public function cart()
    {
        return view('public.cart');
    }

    public function documents()
    {
        return view('public.documents');
    }

    public function delivery()
    {
        return view('public.delivery');
    }

    public function checkout()
    {
        return view('public.checkout');
    }

    public function complete(Order $order)
    {
        return view('public.complete', compact('order'));
    }
}
