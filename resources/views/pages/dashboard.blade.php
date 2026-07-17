@extends('layouts.admin')

@section('title', 'Executive Dashboard | SG-Review')
@section('header_title', 'Executive Dashboard')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Top Welcome Banner with Quick Actions -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-blue-950 to-slate-900 p-6 sm:p-8 text-white shadow-xl border border-slate-800">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute right-1/3 -top-20 w-80 h-80 bg-cyan-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-blue-500/20 text-blue-300 border border-blue-500/30 mb-3">
                    <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                    Live Analytics & Insights
                </span>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white">Welcome back, Admin 👋</h1>
                <p class="text-slate-300 text-sm sm:text-base mt-1 max-w-2xl">
                    Here's what's happening with student enrollments, ambassador referrals, and course revenue across your platform today.
                </p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <a href="{{ route('analytics') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-500 hover:to-cyan-500 text-white font-semibold text-sm shadow-lg shadow-blue-500/25 transition-all transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    View Deep Analytics
                </a>
            </div>
        </div>
    </div>

    <!-- 1. Metric Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Card 1: Total Students -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/80 hover:shadow-md transition-all relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="flex items-center justify-between relative z-10">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Students</p>
                <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
            <div class="mt-4 relative z-10">
                <h3 class="text-3xl font-black text-slate-800 tracking-tight">{{ number_format($dashboardData['metrics']['total_students']) }}</h3>
                <div class="mt-2 flex items-center gap-2 text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md w-fit">
                    <span>Active Premium: {{ number_format($dashboardData['metrics']['paid_students'] + $dashboardData['metrics']['upgraded_students']) }}</span>
                </div>
            </div>
        </div>

        <!-- Card 2: Total Ambassadors / Agents -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/80 hover:shadow-md transition-all relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="flex items-center justify-between relative z-10">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Ambassadors / Agents</p>
                <div class="w-10 h-10 rounded-xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
            </div>
            <div class="mt-4 relative z-10">
                <h3 class="text-3xl font-black text-slate-800 tracking-tight">{{ number_format($dashboardData['metrics']['total_agents']) }}</h3>
                <div class="mt-2 flex items-center gap-2 text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-md w-fit">
                    <span>Total Referrals: {{ number_format($dashboardData['metrics']['total_referrals']) }}</span>
                </div>
            </div>
        </div>

        <!-- Card 3: Review Courses -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/80 hover:shadow-md transition-all relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-24 bg-purple-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="flex items-center justify-between relative z-10">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Review Courses</p>
                <div class="w-10 h-10 rounded-xl bg-purple-500/10 text-purple-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
            </div>
            <div class="mt-4 relative z-10">
                <h3 class="text-3xl font-black text-slate-800 tracking-tight">{{ number_format($dashboardData['metrics']['total_courses']) }}</h3>
                <div class="mt-2 flex items-center gap-2 text-xs font-semibold text-purple-600 bg-purple-50 px-2 py-1 rounded-md w-fit">
                    <span>Live Google Classroom Synced</span>
                </div>
            </div>
        </div>

        <!-- Card 4: Total Revenue -->
        <div class="bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 rounded-2xl p-5 shadow-lg border border-slate-800 text-white hover:shadow-xl transition-all relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-28 h-28 bg-amber-500/10 rounded-full blur-xl group-hover:scale-125 transition-transform"></div>
            <div class="flex items-center justify-between relative z-10">
                <p class="text-xs font-bold uppercase tracking-wider text-amber-400">Total Revenue</p>
                <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center font-bold border border-amber-500/30">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div class="mt-4 relative z-10">
                <h3 class="text-3xl font-black text-white tracking-tight">₱{{ number_format($dashboardData['metrics']['total_revenue'], 2) }}</h3>
                <div class="mt-2 flex items-center gap-2 text-xs font-semibold text-amber-300 bg-amber-500/20 px-2 py-1 rounded-md w-fit border border-amber-500/30">
                    <span>Verified Xendit Payments</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Main Visual Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left 2 Cols: Monthly Revenue & Enrollments Trend -->
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-slate-200/80 flex flex-col">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                        Monthly Growth Performance
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Tracking enrollments and revenue over the current year</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-blue-50 text-blue-700 text-xs font-bold border border-blue-100">
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span> Revenue (₱)
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-100">
                        <span class="w-2 h-2 rounded-full bg-emerald-600"></span> Enrollees
                    </span>
                </div>
            </div>
            <div id="monthlyGrowthChart" class="w-full flex-1 min-h-[320px]"></div>
        </div>

        <!-- Right 1 Col: Course Share Donut Chart -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/80 flex flex-col">
            <div class="mb-6">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-cyan-500"></span>
                    Course Share Breakdown
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Student enrollment distribution by course</p>
            </div>
            <div id="courseShareChart" class="w-full flex-1 min-h-[300px] flex items-center justify-center"></div>
        </div>
    </div>

    <!-- 3. Recent Activity & Tables Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Table 1: Most Recent Enrolled Students -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden flex flex-col">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div>
                    <h3 class="font-bold text-slate-800 text-base">Recent Student Enrollees</h3>
                    <p class="text-xs text-slate-500">Latest registrations across all tiers</p>
                </div>
                <a href="{{ route('students') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-600 font-bold text-xs transition-colors">
                    Manage Students
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/30 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                            <th class="py-3 px-4">Student</th>
                            <th class="py-3 px-4">Course</th>
                            <th class="py-3 px-4">Plan</th>
                            <th class="py-3 px-4 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($dashboardData['tables']['recent_students'] as $student)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 font-bold text-xs flex items-center justify-center shrink-0">
                                        {{ substr($student->student_name, 0, 2) }}
                                    </div>
                                    <div class="truncate max-w-[150px] sm:max-w-[200px]">
                                        <p class="font-bold text-slate-800 truncate">{{ $student->student_name }}</p>
                                        <p class="text-[11px] text-slate-400 truncate">{{ $student->student_email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-slate-100 text-slate-700">
                                    {{ $student->course ? ($student->course->acronym ?: substr($student->course->title, 0, 6)) : 'N/A' }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                @if($student->plan_type === 'premium')
                                    <span class="inline-flex items-center gap-1 text-xs font-bold text-amber-600">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        Premium
                                    </span>
                                @else
                                    <span class="text-xs font-medium text-slate-500">Free Trial</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right">
                                @if($student->is_paid || $student->status === 'paid')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">Paid</span>
                                @elseif($student->status === 'upgraded')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-blue-100 text-blue-800">Upgraded</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800">{{ ucfirst($student->status) }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-slate-400 text-sm">No students registered yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Table 2: Most Recent Ambassadors / Agents -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden flex flex-col">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <div>
                    <h3 class="font-bold text-slate-800 text-base">Active Ambassadors & Agents</h3>
                    <p class="text-xs text-slate-500">Referral partners bringing in new students</p>
                </div>
                <a href="{{ route('agents') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-600 font-bold text-xs transition-colors">
                    Manage Agents
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/30 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                            <th class="py-3 px-4">Ambassador</th>
                            <th class="py-3 px-4">Agent Code</th>
                            <th class="py-3 px-4 text-center">Referrals</th>
                            <th class="py-3 px-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($dashboardData['tables']['recent_agents'] as $agent)
                        <tr class="hover:bg-slate-50/80 transition-colors cursor-pointer" onclick='openAgentDetailsModal({{ json_encode($agent) }}, {{ json_encode($agent->referrals ?? []) }})'>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 font-bold text-xs flex items-center justify-center shrink-0">
                                        {{ substr($agent->name, 0, 2) }}
                                    </div>
                                    <div class="truncate max-w-[160px]">
                                        <p class="font-bold text-slate-800 truncate">{{ $agent->name }}</p>
                                        <p class="text-[11px] text-slate-400 truncate">{{ $agent->phone_number ?: $agent->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="font-mono text-xs font-bold px-2 py-1 rounded bg-slate-100 text-slate-800 border border-slate-200">
                                    {{ $agent->agent_code }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                    {{ $agent->referrals_count }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <button type="button" onclick='event.stopPropagation(); openAgentDetailsModal({{ json_encode($agent) }}, {{ json_encode($agent->referrals ?? []) }})' class="text-xs font-bold text-blue-600 hover:text-blue-800 underline cursor-pointer">View details</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-slate-400 text-sm">No agents enrolled yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ApexCharts Script Initialization for Dashboard -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Monthly Growth Dual-Axis Area Chart
        const monthlyOptions = {
            series: [{
                name: 'Revenue (₱)',
                data: @json($dashboardData['charts']['monthly_growth']['revenue'])
            }, {
                name: 'Enrollees',
                data: @json($dashboardData['charts']['monthly_growth']['enrollments'])
            }],
            chart: {
                height: 320,
                type: 'area',
                fontFamily: 'inherit',
                toolbar: { show: false },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800
                }
            },
            colors: ['#3B82F6', '#10B981'],
            dataLabels: { enabled: false },
            stroke: {
                curve: 'smooth',
                width: [3, 3]
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [0, 90, 100]
                }
            },
            grid: {
                borderColor: '#F1F5F9',
                strokeDashArray: 4,
            },
            xaxis: {
                categories: @json($dashboardData['charts']['monthly_growth']['labels']),
                labels: {
                    style: { colors: '#64748B', fontWeight: 600, fontSize: '12px' }
                },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: [{
                title: { text: 'Revenue (₱)', style: { color: '#3B82F6', fontWeight: 700 } },
                labels: {
                    style: { colors: '#64748B', fontWeight: 600 },
                    formatter: function (val) {
                        return '₱' + val.toLocaleString();
                    }
                }
            }, {
                opposite: true,
                title: { text: 'Students', style: { color: '#10B981', fontWeight: 700 } },
                labels: {
                    style: { colors: '#64748B', fontWeight: 600 }
                }
            }],
            tooltip: {
                shared: true,
                intersect: false,
                theme: 'light',
                y: [{
                    formatter: function (y) { return '₱' + y.toLocaleString(); }
                }, {
                    formatter: function (y) { return y + ' Students'; }
                }]
            },
            legend: { show: false }
        };

        const monthlyChart = new ApexCharts(document.querySelector("#monthlyGrowthChart"), monthlyOptions);
        monthlyChart.render();

        // 2. Course Share Donut Chart
        const courseOptions = {
            series: @json($dashboardData['charts']['course_share']['series']),
            labels: @json($dashboardData['charts']['course_share']['labels']),
            chart: {
                type: 'donut',
                height: 300,
                fontFamily: 'inherit',
            },
            colors: @json($dashboardData['charts']['course_share']['colors']),
            dataLabels: {
                enabled: true,
                formatter: function (val) { return Math.round(val) + "%"; }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '72%',
                        labels: {
                            show: true,
                            total: {
                                showAlways: true,
                                show: true,
                                label: 'Total Enrollees',
                                fontSize: '14px',
                                fontWeight: 600,
                                color: '#64748B',
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                }
                            }
                        }
                    }
                }
            },
            legend: {
                position: 'bottom',
                horizontalAlign: 'center',
                fontSize: '13px',
                fontWeight: 600,
                labels: { colors: '#475569' }
            },
            stroke: { width: 0 }
        };

        const courseChart = new ApexCharts(document.querySelector("#courseShareChart"), courseOptions);
        courseChart.render();
    });

    // Agent Details Modal Logic
    function openAgentDetailsModal(agent, referrals) {
        document.getElementById('agentDetailsInitials').textContent = (agent.name || 'AG').substring(0, 2).toUpperCase();
        document.getElementById('agentDetailsName').textContent = agent.name || 'Unknown Ambassador';
        document.getElementById('agentDetailsCodeBadge').innerHTML = `<svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg> Code: ${agent.agent_code || 'N/A'}`;
        
        document.getElementById('agentDetailsEmail').textContent = agent.email || 'N/A';
        document.getElementById('agentDetailsPhone').textContent = agent.phone_number || 'N/A';
        document.getElementById('agentDetailsAddress').textContent = agent.address || 'Online Ambassador';

        const fbContainer = document.getElementById('agentDetailsFacebook');
        if (agent.facebook_link) {
            fbContainer.innerHTML = `<a href="${agent.facebook_link}" target="_blank" class="text-blue-600 hover:underline inline-flex items-center gap-1 font-semibold">Visit Facebook Profile ↗</a>`;
        } else {
            fbContainer.innerHTML = `<span class="text-slate-400 font-medium">Not provided</span>`;
        }

        const refList = referrals || [];
        const totalRef = refList.length || (agent.referrals_count || 0);
        const paidList = refList.filter(c => c.is_paid || c.status === 'paid' || c.status === 'active');
        const totalSales = refList.reduce((acc, c) => {
            const isPaid = c.is_paid || c.status === 'paid' || c.status === 'active';
            return acc + (isPaid ? Number(c.amount || 0) : 0);
        }, 0);
        const commission = totalSales * 0.10;

        document.getElementById('agentDetailsTotalReferrals').textContent = totalRef;
        document.getElementById('agentDetailsPaidReferrals').textContent = paidList.length;
        document.getElementById('agentDetailsCommission').textContent = `₱${commission.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
        document.getElementById('agentDetailsReferralCountBadge').textContent = `${refList.length} total records`;

        const tbody = document.getElementById('agentDetailsReferralsTbody');
        tbody.innerHTML = '';

        if (refList.length === 0) {
            tbody.innerHTML = `<tr><td colspan="4" class="py-6 text-center text-slate-400 text-xs">No students referred by this ambassador yet.</td></tr>`;
        } else {
            refList.forEach(c => {
                const isPaid = c.is_paid || c.status === 'paid' || c.status === 'active';
                const amount = Number(c.amount || 0);
                const courseTitle = c.course ? (c.course.acronym || c.course.title || 'Course') : 'Reviewer';
                const planBadge = c.plan_type === 'premium' ? 'bg-blue-50 text-blue-700' : 'bg-slate-100 text-slate-600';
                const statusBadge = isPaid ? 'text-emerald-600 font-bold' : 'text-amber-600 font-medium';

                const row = document.createElement('tr');
                row.className = 'hover:bg-slate-50/80';
                row.innerHTML = `
                    <td class="py-2.5 px-3.5 font-bold text-slate-800">${c.student_name || 'Anonymous'}</td>
                    <td class="py-2.5 px-3.5 text-slate-600 font-medium">${courseTitle}</td>
                    <td class="py-2.5 px-3.5">
                        <span class="px-1.5 py-0.5 rounded text-[10px] uppercase font-bold ${planBadge}">${c.plan_type || 'Trial'}</span>
                        <span class="ml-1 text-[11px] ${statusBadge}">${c.status || ''}</span>
                    </td>
                    <td class="py-2.5 px-3.5 text-right font-bold ${isPaid ? 'text-emerald-700' : 'text-slate-400'}">₱${amount.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                `;
                tbody.appendChild(row);
            });
        }

        const modal = document.getElementById('agentDetailsModal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    function closeAgentDetailsModal() {
        const modal = document.getElementById('agentDetailsModal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    window.addEventListener('click', function(e) {
        const detailsModal = document.getElementById('agentDetailsModal');
        if (e.target === detailsModal) closeAgentDetailsModal();
    });
</script>

{{-- AGENT DETAILS MODAL --}}
<div id="agentDetailsModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm animate-fade-in">
    <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl border border-slate-200 max-h-[90vh] flex flex-col">
        {{-- Header --}}
        <div class="flex justify-between items-start mb-6 border-b border-slate-100 pb-5">
            <div class="flex items-center gap-4">
                <div id="agentDetailsInitials" class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 font-black text-lg flex items-center justify-center shrink-0 shadow-sm border border-emerald-200"></div>
                <div>
                    <div class="flex items-center gap-2">
                        <h3 id="agentDetailsName" class="text-xl font-bold text-slate-800"></h3>
                        <span class="px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 text-[11px] font-bold border border-blue-100">Ambassador</span>
                    </div>
                    <p id="agentDetailsCodeBadge" class="text-xs font-mono font-bold text-emerald-600 mt-1 flex items-center gap-1.5"></p>
                </div>
            </div>
            <button onclick="closeAgentDetailsModal()" type="button" class="text-slate-400 hover:text-slate-600 text-2xl font-bold cursor-pointer leading-none">×</button>
        </div>

        {{-- Scrollable Content Area --}}
        <div class="overflow-y-auto flex-1 space-y-6 pr-1">
            {{-- Contact Information Grid --}}
            <div class="bg-slate-50/80 rounded-2xl p-4 sm:p-5 border border-slate-200/80 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Email Address</span>
                    <span id="agentDetailsEmail" class="font-semibold text-slate-700 break-all mt-0.5 block"></span>
                </div>
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Contact Number</span>
                    <span id="agentDetailsPhone" class="font-semibold text-slate-700 mt-0.5 block"></span>
                </div>
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Address / Location</span>
                    <span id="agentDetailsAddress" class="font-semibold text-slate-700 mt-0.5 block"></span>
                </div>
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">Facebook Profile</span>
                    <div id="agentDetailsFacebook" class="mt-0.5"></div>
                </div>
            </div>

            {{-- Performance Metrics Cards --}}
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-blue-50/60 rounded-2xl p-4 border border-blue-100 text-center sm:text-left">
                    <span class="text-[11px] font-bold uppercase text-blue-600 block">Total Referrals</span>
                    <h4 id="agentDetailsTotalReferrals" class="text-xl sm:text-2xl font-black text-slate-800 mt-1">0</h4>
                </div>
                <div class="bg-emerald-50/60 rounded-2xl p-4 border border-emerald-100 text-center sm:text-left">
                    <span class="text-[11px] font-bold uppercase text-emerald-600 block">Paid Enrollees</span>
                    <h4 id="agentDetailsPaidReferrals" class="text-xl sm:text-2xl font-black text-emerald-700 mt-1">0</h4>
                </div>
                <div class="bg-amber-50/60 rounded-2xl p-4 border border-amber-100 text-center sm:text-left">
                    <span class="text-[11px] font-bold uppercase text-amber-600 block">10% Commission</span>
                    <h4 id="agentDetailsCommission" class="text-lg sm:text-xl font-black text-amber-600 mt-1">₱0.00</h4>
                </div>
            </div>

            {{-- Mini Table of Referred Students --}}
            <div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3 flex items-center justify-between">
                    <span>Referred Students History</span>
                    <span id="agentDetailsReferralCountBadge" class="text-[11px] font-normal text-slate-400"></span>
                </h4>
                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm max-h-[220px] overflow-y-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-[11px] font-bold text-slate-400 uppercase tracking-wider sticky top-0 bg-slate-50">
                                <th class="py-2.5 px-3.5">Student Name</th>
                                <th class="py-2.5 px-3.5">Course</th>
                                <th class="py-2.5 px-3.5">Plan / Status</th>
                                <th class="py-2.5 px-3.5 text-right">Paid Amount</th>
                            </tr>
                        </thead>
                        <tbody id="agentDetailsReferralsTbody" class="divide-y divide-slate-100">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="pt-5 mt-5 border-t border-slate-100 flex justify-end gap-3">
            <a href="{{ route('agents') }}" class="px-5 py-2.5 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-600 font-bold text-sm cursor-pointer transition">Manage in Agents Page →</a>
            <button onclick="closeAgentDetailsModal()" type="button" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm cursor-pointer transition">Close Details</button>
        </div>
    </div>
</div>
@endsection