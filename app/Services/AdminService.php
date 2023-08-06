<?php

namespace App\Services;

use App\Repositories\IAdminRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminService
{
    private $adminRepository;

    public function __construct(IAdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function login(array $loginProperties)
    {
        return Auth::guard('admin')->attempt($loginProperties);
    }

    public function logout()
    {
        Auth::logout();
        Session::invalidate();
        Session::regenerateToken();
    }

    public function register(array $registerProperties)
    {
        $registerProperties['password'] = Hash::make($registerProperties['password']);
        $this->adminRepository->create($registerProperties);
    }
}
