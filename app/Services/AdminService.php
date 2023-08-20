<?php

namespace App\Services;

use App\Repositories\IAdminRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminService
{
    private $adminRepository;

    public function __construct(IAdminRepository $iAdminRepository)
    {
        $this->adminRepository = $iAdminRepository;
    }

    public function login(array $loginProps)
    {
        return Auth::guard('admin')->attempt($loginProps);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        Session::invalidate();
        Session::regenerateToken();
    }

    public function register(array $registerProps)
    {
        $registerProps['password'] = Hash::make($registerProps['password']);
        $this->adminRepository->create($registerProps);
    }
}
