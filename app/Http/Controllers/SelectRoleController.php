<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SelectRoleController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('select_role', compact('user'));
    }

    public function set($role = 'customer')
    {
        if (in_array($role, array_keys(User::ROLES))) {
            session(['role' => [
                'label' => array_get(User::ROLES, $role),
                'name' => $role,
            ]]);
        } else {
            return redirect()->back();
        }

        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'supplier' => redirect()->route('admin.dashboard'),
            'dealer' => redirect()->route('admin.dashboard'),
            'customer' => redirect()->route('profile.index'),
        };
    }
}
