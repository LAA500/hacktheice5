<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserService
{
    public function create($data = [])
    {
        $data['password'] = Hash::make(uniqid());

        $user = User::create($data);

        return $user;
    }

    public function update(User $user, $data)
    {
        $user->update($data);

        return $user;
    }
}
