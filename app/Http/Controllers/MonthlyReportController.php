<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MonthlyReportController extends Controller
{
    public function index()
    {
        $data = [
            'pageTitle' => 'Monthly Report',
        ];
        return view('pages.monthly-report.monthly-report-page', ['data' => $data]);
    }

    public function drawChartData()
    {
    }

    public function exportCsv()
    {
    }
}
