<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\AdminService;
use App\Http\Controllers\DashboardController;
use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\AdminRegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Common\Constants;

class AdminController extends Controller
{
    private $adminService;

    public function __construct()
    {
        $this->adminService = new AdminService();
    }

    public function index()
    {
        return view('pages.admin.login', ['pageTitle' => 'Login']);
    }

    public function loginHandler(AdminLoginRequest $adminLoginRequest)
    {
        $loginValidatedProperties = $adminLoginRequest->validated();
        if ($this->adminService->login($loginValidatedProperties)) {
            return redirect()->action([DashboardController::class, 'index']);
        }

        Session::flash(Constants::ACTION_ERROR, Constants::LOGIN_DETAIL_INVALID);
        return redirect()->action([AdminController::class, 'index']);
    }

    public function logout(Request $request)
    {
        $this->adminService->logout();

        Session::flash(Constants::ACTION_SUCCESS, Constants::LOGOUT_SUCCESS);
        return redirect()->action([AdminController::class, 'index']);
    }

    public function register()
    {
        return view('pages.admin.register', ['pageTitle' => 'Register']);
    }

    public function registerHandler(AdminRegisterRequest $adminRegisterRequest)
    {
        $registerValidatedProperties = $adminRegisterRequest->validated();
        $this->adminService->register($registerValidatedProperties);

        Session::flash(Constants::ACTION_SUCCESS, Constants::REGISTER_SUCCESS);
        return redirect()->action([AdminController::class, 'index']);
    }
}
