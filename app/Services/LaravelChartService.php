<?php

namespace App\Services;

use App\Models\Agent;
use App\Models\Course;
use App\Models\Students;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaravelChartService
{
    /**
     * Get comprehensive metrics, chart configurations, and recent tables for the Dashboard.
     */
    public function getDashboardData(): array
    {
        // 1. Core Metrics & Summary Cards
        $totalStudents = Students::count();
        $paidStudents = Students::where('is_paid', true)->count();
        $freeTrialStudents = Students::where('plan_type', 'free_trial')->count();
        $upgradedStudents = Students::where('status', 'upgraded')->count();
        
        $totalAgents = Agent::count();
        $totalReferrals = Students::whereNotNull('referral_code')->where('referral_code', '!=', '')->count();
        
        $totalCourses = Course::count();
        $totalRevenue = (float) Students::where('is_paid', true)->sum('amount');

        // 2. Chart: Monthly Growth (Enrollments & Revenue for current year)
        $currentYear = Carbon::now()->year;
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $monthlyEnrollments = array_fill(1, 12, 0);
        $monthlyRevenue = array_fill(1, 12, 0.0);

        $enrollmentsQuery = Students::selectRaw('EXTRACT(MONTH FROM created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $currentYear)
            ->groupByRaw('EXTRACT(MONTH FROM created_at)')
            ->get();

        foreach ($enrollmentsQuery as $row) {
            $m = (int) $row->month;
            if ($m >= 1 && $m <= 12) {
                $monthlyEnrollments[$m] = (int) $row->total;
            }
        }

        $revenueQuery = Students::selectRaw('EXTRACT(MONTH FROM paid_at) as month, SUM(amount) as total')
            ->where('is_paid', true)
            ->whereYear('paid_at', $currentYear)
            ->groupByRaw('EXTRACT(MONTH FROM paid_at)')
            ->get();

        foreach ($revenueQuery as $row) {
            $m = (int) $row->month;
            if ($m >= 1 && $m <= 12) {
                $monthlyRevenue[$m] = (float) $row->total;
            }
        }

        // 3. Chart: Course Share Distribution
        $courses = Course::withCount('students')->get();
        $courseShareLabels = [];
        $courseShareSeries = [];
        $courseColors = ['#06B6D4', '#10B981', '#3B82F6', '#8B5CF6', '#F59E0B', '#EC4899'];
        
        foreach ($courses as $index => $c) {
            $courseShareLabels[] = $c->acronym ?: $c->title;
            $courseShareSeries[] = (int) $c->students_count;
        }

        // 4. Chart: Plan Status Distribution
        $planStatusSeries = [
            $paidStudents,
            $upgradedStudents,
            Students::where('plan_type', 'free_trial')->where('status', '!=', 'upgraded')->where('status', '!=', 'expired')->count(),
            Students::where('status', 'expired')->count()
        ];
        $planStatusLabels = ['Paid Premium', 'Converted / Upgraded', 'Active Free Trial', 'Expired Trial'];

        // 5. Recent Tables
        $recentStudents = Students::with(['course', 'agent'])
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        $recentAgents = Agent::with('referrals.course')
            ->withCount('referrals')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return [
            'metrics' => [
                'total_students' => $totalStudents,
                'paid_students' => $paidStudents,
                'free_trial_students' => $freeTrialStudents,
                'upgraded_students' => $upgradedStudents,
                'total_agents' => $totalAgents,
                'total_referrals' => $totalReferrals,
                'total_courses' => $totalCourses,
                'total_revenue' => $totalRevenue,
            ],
            'charts' => [
                'monthly_growth' => [
                    'labels' => $months,
                    'enrollments' => array_values($monthlyEnrollments),
                    'revenue' => array_values($monthlyRevenue),
                ],
                'course_share' => [
                    'labels' => $courseShareLabels,
                    'series' => $courseShareSeries,
                    'colors' => array_slice($courseColors, 0, max(count($courseShareLabels), 1)),
                ],
                'plan_status' => [
                    'labels' => $planStatusLabels,
                    'series' => $planStatusSeries,
                    'colors' => ['#10B981', '#3B82F6', '#F59E0B', '#EF4444'],
                ],
            ],
            'tables' => [
                'recent_students' => $recentStudents,
                'recent_agents' => $recentAgents,
            ],
        ];
    }

    /**
     * Get advanced analytics reports, agent leaderboard, conversion rates, and course enrollment filters.
     */
    public function getAnalyticsData(?int $selectedYear = null): array
    {
        $nowYear = Carbon::now()->year;
        $targetYear = ($selectedYear && $selectedYear >= 2020 && $selectedYear <= $nowYear + 5) ? $selectedYear : $nowYear;
        
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $years = [$nowYear - 2, $nowYear - 1, $nowYear, $nowYear + 1];

        // Discover distinct reporting years in database
        $dbYears = Students::selectRaw('EXTRACT(YEAR FROM created_at) as year')
            ->distinct()
            ->pluck('year')
            ->filter()
            ->map(fn($y) => (int) $y)
            ->toArray();
        $availableYears = array_unique(array_merge([$nowYear - 2, $nowYear - 1, $nowYear, $nowYear + 1], $dbYears));
        rsort($availableYears);

        // 1. Agent Leaderboard (Ranked by Total Revenue & Referrals for targetYear)
        $agents = Agent::with(['referrals' => function ($q) use ($targetYear) {
            $q->whereYear('created_at', $targetYear);
        }])->get();

        $leaderboard = $agents->map(function ($agent) {
            $referralsCount = $agent->referrals->count();
            $paidReferrals = $agent->referrals->where('is_paid', true)->count();
            $totalRevenue = (float) $agent->referrals->where('is_paid', true)->sum('amount');
            $conversionRate = $referralsCount > 0 ? round(($paidReferrals / $referralsCount) * 100, 1) : 0;

            return [
                'id' => $agent->id,
                'name' => $agent->name,
                'code' => $agent->agent_code,
                'email' => $agent->email,
                'referrals_count' => $referralsCount,
                'paid_referrals' => $paidReferrals,
                'total_revenue' => $totalRevenue,
                'conversion_rate' => $conversionRate,
                'created_at' => $agent->created_at ? $agent->created_at->format('M d, Y') : 'N/A',
            ];
        })->sortByDesc('total_revenue')->values();

        // Assign rank
        $leaderboard = $leaderboard->map(function ($item, $key) {
            $item['rank'] = $key + 1;
            return $item;
        });

        // 2. Conversion Rate Analytics for targetYear
        $totalStudentsCount = Students::whereYear('created_at', $targetYear)->count();
        $premiumStudents = Students::whereYear('created_at', $targetYear)->where(function ($query) {
            $query->where('plan_type', 'premium')
                  ->orWhere('status', 'paid')
                  ->orWhere('status', 'upgraded');
        })->count();
        
        $nonUpgradedStudents = Students::whereYear('created_at', $targetYear)->where(function ($query) {
            $query->where('status', 'expired')
                  ->orWhere(function ($q) {
                      $q->where('plan_type', 'free_trial')
                        ->where('status', '!=', 'upgraded')
                        ->where('status', '!=', 'paid');
                  });
        })->count();

        $conversionPercentage = $totalStudentsCount > 0 ? round(($premiumStudents / $totalStudentsCount) * 100, 1) : 0.0;

        // 3. Course Enrollees Report with Dynamic Filters (Per Month for targetYear & Per Year across courses)
        $coursesList = Course::select('id', 'title', 'acronym')->get();
        $courseEnrollmentsFilter = [
            'courses' => $coursesList,
            'monthly' => [],
            'yearly' => [],
        ];

        // Overall monthly for all courses combined in targetYear
        $allMonthlySeries = array_fill(1, 12, 0);
        $allEnrollmentsQuery = Students::selectRaw('EXTRACT(MONTH FROM created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $targetYear)
            ->groupByRaw('EXTRACT(MONTH FROM created_at)')
            ->get();
        foreach ($allEnrollmentsQuery as $r) {
            $m = (int) $r->month;
            if ($m >= 1 && $m <= 12) $allMonthlySeries[$m] = (int) $r->total;
        }
        $courseEnrollmentsFilter['monthly']['all'] = [
            'labels' => $months,
            'series' => array_values($allMonthlySeries),
            'title' => 'All Courses Combined (' . $targetYear . ')',
        ];

        // Per course monthly in targetYear
        foreach ($coursesList as $c) {
            $cMonthlySeries = array_fill(1, 12, 0);
            $cEnrollmentsQuery = Students::where('course_id', $c->id)
                ->selectRaw('EXTRACT(MONTH FROM created_at) as month, COUNT(*) as total')
                ->whereYear('created_at', $targetYear)
                ->groupByRaw('EXTRACT(MONTH FROM created_at)')
                ->get();
            foreach ($cEnrollmentsQuery as $r) {
                $m = (int) $r->month;
                if ($m >= 1 && $m <= 12) $cMonthlySeries[$m] = (int) $r->total;
            }
            $courseEnrollmentsFilter['monthly']["course_{$c->id}"] = [
                'labels' => $months,
                'series' => array_values($cMonthlySeries),
                'title' => ($c->acronym ?: $c->title) . ' Monthly Enrollees (' . $targetYear . ')',
            ];
        }

        // Overall yearly for all courses combined
        $allYearlySeries = [];
        foreach ($years as $y) {
            $allYearlySeries[] = Students::whereYear('created_at', $y)->count();
        }
        $courseEnrollmentsFilter['yearly']['all'] = [
            'labels' => array_map('strval', $years),
            'series' => $allYearlySeries,
            'title' => 'All Courses Combined (Year-over-Year)',
        ];

        // Per course yearly
        foreach ($coursesList as $c) {
            $cYearlySeries = [];
            foreach ($years as $y) {
                $cYearlySeries[] = Students::where('course_id', $c->id)->whereYear('created_at', $y)->count();
            }
            $courseEnrollmentsFilter['yearly']["course_{$c->id}"] = [
                'labels' => array_map('strval', $years),
                'series' => $cYearlySeries,
                'title' => ($c->acronym ?: $c->title) . ' Yearly Enrollees',
            ];
        }

        // 4. Broader Monthly Sales & Revenue Report for targetYear
        $monthlySalesRevenue = array_fill(1, 12, 0.0);
        $monthlyPaidTransactions = array_fill(1, 12, 0);
        
        $salesQuery = Students::selectRaw('EXTRACT(MONTH FROM paid_at) as month, SUM(amount) as rev, COUNT(*) as trans')
            ->where('is_paid', true)
            ->whereYear('paid_at', $targetYear)
            ->groupByRaw('EXTRACT(MONTH FROM paid_at)')
            ->get();

        foreach ($salesQuery as $r) {
            $m = (int) $r->month;
            if ($m >= 1 && $m <= 12) {
                $monthlySalesRevenue[$m] = (float) $r->rev;
                $monthlyPaidTransactions[$m] = (int) $r->trans;
            }
        }

        // 5. Freestyle Reports for targetYear
        // 5a. Payment Channels Distribution
        $channels = Students::where('is_paid', true)
            ->whereYear('paid_at', $targetYear)
            ->whereNotNull('payment_channel')
            ->where('payment_channel', '!=', '')
            ->selectRaw('payment_channel, COUNT(*) as count')
            ->groupBy('payment_channel')
            ->get();
        
        $channelLabels = [];
        $channelSeries = [];
        foreach ($channels as $ch) {
            $channelLabels[] = strtoupper($ch->payment_channel);
            $channelSeries[] = (int) $ch->count;
        }
        if (empty($channelLabels)) {
            $channelLabels = ['GCASH', 'MAYA', 'BANK_TRANSFER'];
            $channelSeries = [0, 0, 0];
        }

        // 5b. Extension Requests Analytics in targetYear
        $extensionStatuses = [
            'Approved' => Students::whereYear('created_at', $targetYear)->where('extension_status', 'approved')->count(),
            'Pending' => Students::whereYear('created_at', $targetYear)->where('extension_status', 'pending')->count(),
            'Rejected' => Students::whereYear('created_at', $targetYear)->where('extension_status', 'rejected')->count(),
            'No Request' => Students::whereYear('created_at', $targetYear)->where(function($q) {
                $q->whereNull('extension_status')->orWhere('extension_status', '');
            })->count(),
        ];

        // 5c. Day of Week Enrollment Distribution in targetYear
        $daysOfWeek = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $daySeries = array_fill(0, 7, 0);
        
        $dayQuery = Students::whereYear('created_at', $targetYear)
            ->selectRaw('EXTRACT(DOW FROM created_at) as dow, COUNT(*) as total')
            ->groupByRaw('EXTRACT(DOW FROM created_at)')
            ->get();
            
        foreach ($dayQuery as $r) {
            // PostgreSQL DOW: 0 = Sunday, 1 = Monday ... 6 = Saturday
            $dow = (int) $r->dow;
            $idx = $dow === 0 ? 6 : $dow - 1;
            $daySeries[$idx] = (int) $r->total;
        }

        return [
            'selected_year' => $targetYear,
            'available_years' => array_values($availableYears),
            'leaderboard' => $leaderboard,
            'conversion' => [
                'percentage' => $conversionPercentage,
                'premium_count' => $premiumStudents,
                'non_upgraded_count' => $nonUpgradedStudents,
                'total_count' => $totalStudentsCount,
                'chart_labels' => ['Upgraded to Premium', 'Did Not Upgrade / Expired'],
                'chart_series' => [$premiumStudents, $nonUpgradedStudents],
                'chart_colors' => ['#10B981', '#F43F5E'],
            ],
            'course_enrollments' => $courseEnrollmentsFilter,
            'monthly_sales' => [
                'labels' => $months,
                'revenue' => array_values($monthlySalesRevenue),
                'transactions' => array_values($monthlyPaidTransactions),
            ],
            'freestyle' => [
                'payment_channels' => [
                    'labels' => $channelLabels,
                    'series' => $channelSeries,
                    'colors' => ['#3B82F6', '#10B981', '#8B5CF6', '#F59E0B', '#06B6D4'],
                ],
                'extensions' => [
                    'labels' => array_keys($extensionStatuses),
                    'series' => array_values($extensionStatuses),
                    'colors' => ['#10B981', '#F59E0B', '#EF4444', '#64748B'],
                ],
                'enrollment_days' => [
                    'labels' => $daysOfWeek,
                    'series' => $daySeries,
                ],
            ],
        ];
    }
}
