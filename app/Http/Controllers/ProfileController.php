<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('public.profile.index', compact('user'));
    }

    public function orders()
    {
        $orders = Auth::user()->orders;

        return view('public.profile.orders', compact('orders'));
    }

    public function favorites()
    {
        return view('public.profile.favorites');
    }

    public function addresses()
    {
        return view('public.profile.addresses');
    }
}
