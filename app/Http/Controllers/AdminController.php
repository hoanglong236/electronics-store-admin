<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\AdminService;
use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use stdClass;

class AdminController extends Controller
{
    private $adminService;

    public function __construct()
    {
        $this->adminService = new AdminService();
    }

    public function index()
    {
        return view('pages.login', ['pageTitle' => 'Login']);
    }

    public function loginHandler(Request $request)
    {
        $loginDTO = new stdClass;

        $loginDTO->email = $request->post('email');
        $loginDTO->password = $request->post('password');

        if ($this->adminService->login($loginDTO)) {
            return redirect()->action([DashboardController::class, 'index']);
        }

        Session::flash('error_mess', 'Please enter valid login details');
        return redirect()->action([AdminController::class, 'index']);
    }

    public function logout(Request $request)
    {
        $this->adminService->logout();

        Session::flash('success_mess', 'Logout successfully');
        return redirect()->action([AdminController::class, 'index']);
    }

    public function register()
    {
        return view('pages.register', ['pageTitle' => 'Register']);
    }

    public function registerHandler(Request $request)
    {
        $registerDTO = new stdClass;

        $registerDTO->email = $request->post('email');
        $registerDTO->password = $request->post('password');
        $registerDTO->fullName = $request->post('fullName');
        $registerDTO->phone = $request->post('phone');

        $this->adminService->register($registerDTO);

        Session::flash('success_mess', 'Register successfully');
        return redirect()->action([AdminController::class, 'index']);
    }
}
