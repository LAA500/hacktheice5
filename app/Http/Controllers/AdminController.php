<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $products_count = Product::all()->count();
        $orders_count = Order::all()->count();
        $users_count = User::all()->count();

        return view('admin.dashboard', compact('products_count', 'orders_count', 'users_count'));
    }
}
