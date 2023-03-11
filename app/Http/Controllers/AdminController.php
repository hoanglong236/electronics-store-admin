<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\AdminService;
use App\Http\Controllers\DashboardController;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Session;
use App\Common\Constants;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private $adminService;

    public function __construct()
    {
        $this->adminService = new AdminService();
    }

    public function index(Request $request)
    {
        return view('pages.login', ['pageTitle' => 'Login']);
    }

    public function loginHandler(LoginRequest $loginRequest)
    {
        $loginProperties = $loginRequest->validated();
        $isLoggedIn = $this->adminService->login($loginProperties);

        if ($isLoggedIn) {
            return redirect()->action([DashboardController::class, 'index']);
        } else {
            Session::flash(Constants::ACTION_ERROR, Constants::LOGIN_DETAIL_INVALID);
            return redirect()->action([AdminController::class, 'index'])->withInput();
        }
    }

    public function logout(Request $request)
    {
        $this->adminService->logout();

        Session::flash(Constants::ACTION_SUCCESS, Constants::LOGOUT_SUCCESS);
        return redirect()->action([AdminController::class, 'index']);
    }

    public function register(Request $request)
    {
        return view('pages.register', ['pageTitle' => 'Register']);
    }

    public function registerHandler(RegisterRequest $registerRequest)
    {
        $registerProperties = $registerRequest->validated();
        $this->adminService->register($registerProperties);

        Session::flash(Constants::ACTION_SUCCESS, Constants::REGISTER_SUCCESS);
        return redirect()->action([AdminController::class, 'index']);
    }
}
