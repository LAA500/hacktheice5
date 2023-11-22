<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Shop;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $districts = City::all()->groupBy('district');

        $city = City::query()->where('uuid', session('city.uuid'))->with('shops')->first();

        if(is_null($city)) {
            $city = City::query()->first();
        }

        return view('public.index', compact('districts', 'city'));
    }

    public function shop(Shop $shop)
    {
        return view('public.shop', compact('shop'));
    }
}
