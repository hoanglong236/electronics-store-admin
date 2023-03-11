<?php

namespace App\Services;

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class AdminService
{
    public function login($loginProperties) {
        return Auth::guard('admin')->attempt($loginProperties);
    }

    public function logout() {
        Auth::logout();
        Session::invalidate();
    }

    public function register($registerProperties)
    {
        $admin = new Admin();

        $admin->email = $registerProperties['email'];
        $admin->password = Hash::make($registerProperties['password']);
        $admin->name = $registerProperties['name'];

        $admin->save();
    }
}
