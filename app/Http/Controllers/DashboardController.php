<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'pageTitle' => 'Dashboard'
        ];

        return view('pages.dashboard.dashboard-page', ['data' => $data]);
    }
}
