<?php

namespace App\Services;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class AdminService
{
    public function login($loginProperties) {
        $admin = Admin::where('email', $loginProperties['email'])->first();

        if (is_null($admin)) {
            return false;
        }
        if (!Hash::check($loginProperties['password'], $admin->password)) {
            return false;
        }

        Session::put('ADMIN_LOGIN', true);
        Session::put('ADMIN_ID', $admin->id);
        Session::put('ADMIN_NAME', $admin->name);

        Log::info("User ". $admin->id . " logged in successfully.");
        return true;
    }

    public function logout() {
        Session::forget('ADMIN_LOGIN');
        Session::forget('ADMIN_ID');
        Session::forget('ADMIN_NAME');
    }

    public function register($registerProperties)
    {
        $admin = new Admin();

        $admin->email = $registerProperties['email'];
        $admin->password = Hash::make($registerProperties['password']);
        $admin->name = $registerProperties['name'];
        $admin->phone = $registerProperties['phone'];

        $admin->save();
    }
}
