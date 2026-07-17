<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LaravelChartService;

class DashboardController extends Controller
{
    protected LaravelChartService $chartService;

    public function __construct(LaravelChartService $chartService)
    {
        $this->chartService = $chartService;
    }

    /**
     * Display the rich analytics and metrics dashboard.
     */
    public function index()
    {
        $dashboardData = $this->chartService->getDashboardData();

        return view('pages.dashboard', compact('dashboardData'));
    }
}
