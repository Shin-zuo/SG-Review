<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LaravelChartService;

class AnalyticsController extends Controller
{
    protected LaravelChartService $chartService;

    public function __construct(LaravelChartService $chartService)
    {
        $this->chartService = $chartService;
    }

    /**
     * Display the dedicated Analytics and Leaderboard page.
     */
    public function index(Request $request)
    {
        $year = $request->input('year') ? (int) $request->input('year') : null;
        $analyticsData = $this->chartService->getAnalyticsData($year);

        return view('pages.analytics', compact('analyticsData'));
    }
}
