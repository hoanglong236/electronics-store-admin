<?php

namespace App\Services;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class AdminService
{
    public function login($loginDTO) {
        $adminEntity = Admin::where('email', $loginDTO->email)->first();

        if (!isset($adminEntity->id)) {
            return false;
        }
        if (Hash::check($loginDTO->password, $adminEntity->password)) {
            Session::put('ADMIN_LOGIN', true);
            Session::put('ADMIN_ID', $adminEntity->id);
            Session::put('ADMIN_NAME', $adminEntity->full_name);

            Log::info("User ". $adminEntity->id . " logged in successfully.");
            return true;
        }
        return false;
    }

    public function logout() {
        Session::forget('ADMIN_LOGIN');
        Session::forget('ADMIN_ID');
        Session::forget('ADMIN_NAME');
    }

    public function register($registerDTO)
    {
        $adminEntity = new Admin();

        $adminEntity->email = $registerDTO->email;
        $adminEntity->password = Hash::make($registerDTO->password);
        $adminEntity->full_name = $registerDTO->fullName;
        $adminEntity->phone = $registerDTO->phone;

        $adminEntity->save();
    }
}
