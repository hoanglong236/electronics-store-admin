<?php

namespace App\Services;

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class AdminService
{
    public function login($loginProperties)
    {
        return Auth::guard('admin')->attempt($loginProperties);
    }

    public function logout()
    {
        Auth::logout();
        Session::invalidate();
        Session::regenerateToken();
    }

    public function register($registerProperties)
    {
        Admin::create([
            'email' => $registerProperties['email'],
            'password' => Hash::make($registerProperties['password']),
            'name' => $registerProperties['name'],
        ]);
    }
}
