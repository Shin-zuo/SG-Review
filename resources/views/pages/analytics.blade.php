@extends('layouts.admin')

@section('title', 'Analytics & Leaderboard | SG-Review')
@section('header_title', 'Performance Analytics & Leaderboard')

@section('content')
<div class="space-y-10 animate-fade-in pb-12" x-data="analyticsController()">
    
    <!-- 1. Top Banner / Title -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-slate-200/80 pb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-800 tracking-tight">System Performance & Analytics</h1>
            <p class="text-slate-500 text-sm mt-1">Comprehensive intelligence on student conversion rates, course enrollment velocity, and ambassador leaderboard standings.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-slate-900 text-white text-xs font-bold shadow-sm border border-slate-800">
                <svg class="w-4 h-4 text-blue-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                <label for="reportingYearSelect" class="text-slate-300 font-medium">Reporting Year:</label>
                <select id="reportingYearSelect" 
                        onchange="window.location.href = '{{ route('analytics') }}?year=' + this.value" 
                        class="bg-slate-800 hover:bg-slate-700 text-blue-400 font-black border border-slate-700 rounded-lg px-2.5 py-1 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer transition-colors">
                    @foreach($analyticsData['available_years'] as $yr)
                        <option value="{{ $yr }}" {{ $analyticsData['selected_year'] == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- 2. Top Performer Ambassador Leaderboard Section -->
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <span class="text-xs font-black uppercase tracking-wider text-amber-600 bg-amber-50 px-2.5 py-1 rounded-md border border-amber-200">Affiliate Champions</span>
                <h2 class="text-xl sm:text-2xl font-black text-slate-800 mt-2">Ambassador Leaderboard & Referrals</h2>
            </div>
            <a href="{{ route('agents') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1">
                Manage Ambassadors <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>

        <!-- Top 3 Podium Cards -->
        @php
            $topThree = $analyticsData['leaderboard']->take(3);
            $medals = [
                1 => ['emoji' => '🥇', 'label' => 'Rank #1 Champion', 'bg' => 'from-amber-500/10 via-amber-500/5 to-white border-amber-300 shadow-amber-500/10', 'text' => 'text-amber-600'],
                2 => ['emoji' => '🥈', 'label' => 'Rank #2 Silver', 'bg' => 'from-slate-300/20 via-slate-100/10 to-white border-slate-300 shadow-slate-400/10', 'text' => 'text-slate-600'],
                3 => ['emoji' => '🥉', 'label' => 'Rank #3 Bronze', 'bg' => 'from-orange-500/10 via-orange-500/5 to-white border-orange-300 shadow-orange-500/10', 'text' => 'text-orange-600'],
            ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach([2, 1, 3] as $rankNum)
                @php $agent = $topThree->firstWhere('rank', $rankNum); @endphp
                @if($agent)
                <div class="bg-gradient-to-b {{ $medals[$rankNum]['bg'] }} bg-white rounded-3xl p-6 border shadow-xl flex flex-col justify-between relative overflow-hidden transition-all transform hover:-translate-y-1 {{ $rankNum === 1 ? 'md:-translate-y-3 border-2 ring-4 ring-amber-400/20' : '' }}">
                    @if($rankNum === 1)
                        <div class="absolute top-0 right-0 bg-gradient-to-l from-amber-500 to-amber-400 text-white font-black text-[10px] uppercase tracking-widest px-3 py-1 rounded-bl-xl shadow-sm">
                            🏆 Top Performer
                        </div>
                    @endif
                    <div>
                        <div class="flex items-center gap-3">
                            <span class="text-3xl">{{ $medals[$rankNum]['emoji'] }}</span>
                            <div>
                                <span class="text-[11px] font-black uppercase tracking-wider {{ $medals[$rankNum]['text'] }}">{{ $medals[$rankNum]['label'] }}</span>
                                <h3 class="font-black text-slate-800 text-lg truncate">{{ $agent['name'] }}</h3>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center justify-between gap-2 border-t border-b border-slate-200/60 py-3">
                            <div>
                                <p class="text-[11px] font-semibold text-slate-400 uppercase">Agent Code</p>
                                <span class="font-mono font-bold text-xs bg-slate-900 text-white px-2 py-0.5 rounded">{{ $agent['code'] }}</span>
                            </div>
                            <div class="text-right">
                                <p class="text-[11px] font-semibold text-slate-400 uppercase">Conversion</p>
                                <span class="font-bold text-xs text-emerald-600">{{ $agent['conversion_rate'] }}%</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-500">Total Referrals</p>
                            <p class="text-xl font-black text-slate-800">{{ $agent['referrals_count'] }} <span class="text-xs font-normal text-slate-400">clients</span></p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-slate-500">Revenue Generated</p>
                            <p class="text-xl font-black text-blue-600">₱{{ number_format($agent['total_revenue']) }}</p>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>

        <!-- Full Leaderboard Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-base">Complete Ambassador Rankings</h3>
                <span class="text-xs font-semibold text-slate-500">Sorted by total revenue contribution</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/40 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                            <th class="py-3 px-6 w-16">Rank</th>
                            <th class="py-3 px-4">Ambassador / Agent</th>
                            <th class="py-3 px-4">Agent Code</th>
                            <th class="py-3 px-4 text-center">Total Referrals</th>
                            <th class="py-3 px-4 text-center">Paid Conversions</th>
                            <th class="py-3 px-4">Conversion Rate</th>
                            <th class="py-3 px-6 text-right">Total Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($analyticsData['leaderboard'] as $agent)
                        <tr class="hover:bg-slate-50/80 transition-colors {{ $agent['rank'] <= 3 ? 'bg-amber-50/10 font-semibold' : '' }}">
                            <td class="py-3.5 px-6 font-black text-slate-600">
                                @if($agent['rank'] === 1) 🥇 #1
                                @elseif($agent['rank'] === 2) 🥈 #2
                                @elseif($agent['rank'] === 3) 🥉 #3
                                @else #{{ $agent['rank'] }}
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 font-bold text-xs flex items-center justify-center">
                                        {{ substr($agent['name'], 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800">{{ $agent['name'] }}</p>
                                        <p class="text-xs text-slate-400 font-normal">{{ $agent['email'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="font-mono text-xs font-bold px-2.5 py-1 rounded bg-slate-100 text-slate-800 border border-slate-200">
                                    {{ $agent['code'] }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center font-bold text-slate-700">
                                {{ $agent['referrals_count'] }}
                            </td>
                            <td class="py-3.5 px-4 text-center font-bold text-emerald-600">
                                {{ $agent['paid_referrals'] }}
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-24 bg-slate-100 h-2 rounded-full overflow-hidden">
                                        <div class="bg-gradient-to-r from-blue-500 to-emerald-500 h-2 rounded-full" style="width: {{ $agent['conversion_rate'] }}%"></div>
                                    </div>
                                    <span class="text-xs font-bold text-slate-700">{{ $agent['conversion_rate'] }}%</span>
                                </div>
                            </td>
                            <td class="py-3.5 px-6 text-right font-black text-slate-800">
                                ₱{{ number_format($agent['total_revenue'], 2) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400 text-sm">No ambassadors registered yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 3. Free Trial to Premium Conversion Analysis -->
    <div class="space-y-6">
        <div>
            <span class="text-xs font-black uppercase tracking-wider text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-200">Subscription Transition</span>
            <h2 class="text-xl sm:text-2xl font-black text-slate-800 mt-2">Free Trial to Premium Conversion Rate</h2>
            <p class="text-xs text-slate-500 mt-0.5">Tracking how effectively student trials transition into full paying premium memberships.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Card: Big Gauge / Percentage Summary -->
            <div class="bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 rounded-3xl p-6 text-white shadow-xl border border-slate-800 flex flex-col justify-between relative overflow-hidden">
                <div class="absolute -right-10 -top-10 w-44 h-44 bg-emerald-500/10 rounded-full blur-2xl"></div>
                <div>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                        Key Conversion Metric
                    </span>
                    <h3 class="text-5xl sm:text-6xl font-black tracking-tight text-white mt-6">
                        {{ $analyticsData['conversion']['percentage'] }}<span class="text-3xl text-emerald-400 font-bold">%</span>
                    </h3>
                    <p class="text-sm font-semibold text-slate-300 mt-2">Of total enrolled students have upgraded to Premium Access</p>
                </div>
                
                <div class="mt-8 pt-6 border-t border-slate-800 grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-slate-400">Upgraded Premium</p>
                        <p class="text-2xl font-black text-emerald-400">{{ number_format($analyticsData['conversion']['premium_count']) }} <span class="text-xs font-normal text-slate-400">students</span></p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400">Trial / Not Upgraded</p>
                        <p class="text-2xl font-black text-rose-400">{{ number_format($analyticsData['conversion']['non_upgraded_count']) }} <span class="text-xs font-normal text-slate-400">students</span></p>
                    </div>
                </div>
            </div>

            <!-- Right 2 Cols: Interactive Donut/Bar Chart Breakdown -->
            <div class="lg:col-span-2 bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80 flex flex-col">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-slate-800">Enrollment Transition Breakdown</h3>
                    <span class="text-xs font-bold text-slate-400">Total Enrollees: {{ number_format($analyticsData['conversion']['total_count']) }}</span>
                </div>
                <div id="conversionChart" class="w-full flex-1 min-h-[260px] flex items-center justify-center"></div>
            </div>
        </div>
    </div>

    <!-- 4. Dynamic Course Enrollees Report (Per Month & Per Year with Interactive Filters) -->
    <div class="space-y-6" id="courseFilterSection">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
            <div>
                <span class="text-xs font-black uppercase tracking-wider text-blue-600 bg-blue-50 px-2.5 py-1 rounded-md border border-blue-200">Course Intelligence</span>
                <h2 class="text-xl sm:text-2xl font-black text-slate-800 mt-2">Enrollees Per Month & Year Report</h2>
                <p class="text-xs text-slate-500 mt-0.5">Filter by any specific review course or toggle between monthly trajectory and year-over-year trends.</p>
            </div>

            <!-- Interactive Filters (Alpine.js controlled) -->
            <div class="flex flex-wrap items-center gap-3 bg-slate-100 p-1.5 rounded-2xl border border-slate-200">
                <!-- Timeframe Toggle (Monthly vs Yearly) -->
                <div class="flex items-center bg-white rounded-xl p-1 shadow-sm border border-slate-200/60">
                    <button type="button" @click="timeframe = 'monthly'; updateCourseChart()"
                            :class="timeframe === 'monthly' ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' : 'text-slate-600 hover:text-slate-900'"
                            class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all">
                        Monthly View
                    </button>
                    <button type="button" @click="timeframe = 'yearly'; updateCourseChart()"
                            :class="timeframe === 'yearly' ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' : 'text-slate-600 hover:text-slate-900'"
                            class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all">
                        Yearly View
                    </button>
                </div>

                <!-- Course Selection Dropdown / Pills -->
                <select x-model="selectedCourse" @change="updateCourseChart()" class="bg-white border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-3.5 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="all">📊 All Courses Combined</option>
                    @foreach($analyticsData['course_enrollments']['courses'] as $c)
                        <option value="course_{{ $c->id }}">🎓 {{ $c->acronym ?: $c->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-800" x-text="currentChartTitle">Enrollees Trend</h3>
                    <p class="text-xs text-slate-400">Interactive live filtering without page refresh</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-blue-50 text-blue-700 text-xs font-bold">
                        <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                        <span x-text="timeframe === 'monthly' ? 'Monthly Registrations' : 'Annual Registrations'"></span>
                    </span>
                </div>
            </div>
            <div id="dynamicCourseChart" class="w-full min-h-[360px]"></div>
        </div>
    </div>

    <!-- 5. Broader Monthly Sales & Revenue Graph -->
    <div class="space-y-6">
        <div>
            <span class="text-xs font-black uppercase tracking-wider text-purple-600 bg-purple-50 px-2.5 py-1 rounded-md border border-purple-200">Financial Growth</span>
            <h2 class="text-xl sm:text-2xl font-black text-slate-800 mt-2">Comprehensive Monthly Sales & Revenue</h2>
            <p class="text-xs text-slate-500 mt-0.5">Total financial volume generated across all payment methods month by month.</p>
        </div>

        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200/80">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Monthly Revenue Trajectory (₱)</h3>
                    <p class="text-xs text-slate-400">Verified successful checkout invoices</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right sm:text-left">
                        <p class="text-[11px] font-bold uppercase text-slate-400">Total Year-to-Date Revenue</p>
                        <p class="text-xl font-black text-purple-600">₱{{ number_format(array_sum($analyticsData['monthly_sales']['revenue']), 2) }}</p>
                    </div>
                </div>
            </div>
            <div id="monthlySalesChart" class="w-full min-h-[350px]"></div>
        </div>
    </div>

    <!-- 6. Freestyle Executive Intelligence (Registration Days Breakdown) -->
    <div class="space-y-6">
        <div>
            <span class="text-xs font-black uppercase tracking-wider text-cyan-600 bg-cyan-50 px-2.5 py-1 rounded-md border border-cyan-200">Freestyle Insights</span>
            <h2 class="text-xl sm:text-2xl font-black text-slate-800 mt-2">Enrollment Velocity & Registration Days</h2>
            <p class="text-xs text-slate-500 mt-0.5">Specialized analytics covering student registration frequency across the days of the week.</p>
        </div>

        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200/80 flex flex-col">
            <div class="mb-6">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    Enrollment Busiest Days of the Week
                </h3>
                <p class="text-xs text-slate-400">When during the week students register most frequently</p>
            </div>
            <div id="enrollmentDaysChart" class="w-full min-h-[320px]"></div>
        </div>
    </div>
</div>

<!-- Alpine.js & ApexCharts Logic for Analytics -->
<script>
    function analyticsController() {
        return {
            timeframe: 'monthly',
            selectedCourse: 'all',
            currentChartTitle: 'All Courses Combined (Monthly Enrollees)',
            chartInstance: null,
            courseData: @json($analyticsData['course_enrollments']),

            init() {
                this.$nextTick(() => {
                    this.renderCourseChart();
                    this.renderConversionChart();
                    this.renderMonthlySalesChart();
                    this.renderFreestyleCharts();
                });
            },

            renderCourseChart() {
                const dataset = this.courseData[this.timeframe][this.selectedCourse] || this.courseData['monthly']['all'];
                this.currentChartTitle = dataset.title;

                const options = {
                    series: [{
                        name: 'Enrollees',
                        data: dataset.series
                    }],
                    chart: {
                        type: this.timeframe === 'monthly' ? 'area' : 'bar',
                        height: 360,
                        fontFamily: 'inherit',
                        toolbar: { show: false },
                        animations: { enabled: true, speed: 600 }
                    },
                    colors: ['#06B6D4'],
                    dataLabels: {
                        enabled: this.timeframe === 'yearly',
                        style: { colors: ['#0E7490'], fontWeight: 700 }
                    },
                    stroke: {
                        curve: 'smooth',
                        width: 3
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.55,
                            opacityTo: 0.05,
                            stops: [0, 90, 100]
                        }
                    },
                    grid: { borderColor: '#F1F5F9', strokeDashArray: 4 },
                    xaxis: {
                        categories: dataset.labels,
                        labels: { style: { colors: '#64748B', fontWeight: 600 } },
                        axisBorder: { show: false },
                        axisTicks: { show: false }
                    },
                    yaxis: {
                        title: { text: 'Enrolled Students', style: { color: '#0E7490', fontWeight: 700 } },
                        labels: { style: { colors: '#64748B', fontWeight: 600 } }
                    },
                    tooltip: {
                        theme: 'light',
                        y: { formatter: function(val) { return val + " Students"; } }
                    }
                };

                const el = document.querySelector("#dynamicCourseChart");
                if (el) {
                    this.chartInstance = new ApexCharts(el, options);
                    this.chartInstance.render();
                }
            },

            updateCourseChart() {
                const dataset = this.courseData[this.timeframe][this.selectedCourse] || this.courseData['monthly']['all'];
                this.currentChartTitle = dataset.title;

                if (this.chartInstance) {
                    this.chartInstance.updateOptions({
                        chart: { type: this.timeframe === 'monthly' ? 'area' : 'bar' },
                        xaxis: { categories: dataset.labels },
                        dataLabels: { enabled: this.timeframe === 'yearly' },
                        series: [{ name: 'Enrollees', data: dataset.series }]
                    });
                }
            },

            renderConversionChart() {
                const conv = @json($analyticsData['conversion']);
                const options = {
                    series: conv.chart_series,
                    labels: conv.chart_labels,
                    chart: {
                        type: 'pie',
                        height: 260,
                        fontFamily: 'inherit',
                    },
                    colors: conv.chart_colors,
                    dataLabels: {
                        enabled: true,
                        formatter: function (val) { return Math.round(val) + "%"; }
                    },
                    legend: {
                        position: 'bottom',
                        horizontalAlign: 'center',
                        fontSize: '12px',
                        fontWeight: 600
                    },
                    stroke: { width: 2, colors: ['#fff'] }
                };

                new ApexCharts(document.querySelector("#conversionChart"), options).render();
            },

            renderMonthlySalesChart() {
                const sales = @json($analyticsData['monthly_sales']);
                const options = {
                    series: [{
                        name: 'Revenue (₱)',
                        data: sales.revenue
                    }],
                    chart: {
                        type: 'bar',
                        height: 350,
                        fontFamily: 'inherit',
                        toolbar: { show: false }
                    },
                    colors: ['#8B5CF6'],
                    plotOptions: {
                        bar: {
                            borderRadius: 8,
                            columnWidth: '45%',
                            distributed: false,
                        }
                    },
                    dataLabels: { enabled: false },
                    grid: { borderColor: '#F1F5F9', strokeDashArray: 4 },
                    xaxis: {
                        categories: sales.labels,
                        labels: { style: { colors: '#64748B', fontWeight: 600 } },
                        axisBorder: { show: false }
                    },
                    yaxis: {
                        title: { text: 'Total Sales (₱)', style: { color: '#8B5CF6', fontWeight: 700 } },
                        labels: {
                            style: { colors: '#64748B', fontWeight: 600 },
                            formatter: function (val) { return '₱' + val.toLocaleString(); }
                        }
                    },
                    tooltip: {
                        theme: 'light',
                        y: { formatter: function (y) { return '₱' + y.toLocaleString(); } }
                    }
                };

                new ApexCharts(document.querySelector("#monthlySalesChart"), options).render();
            },

            renderFreestyleCharts() {
                // Enrollment Days of Week
                const days = @json($analyticsData['freestyle']['enrollment_days']);
                const dayOpts = {
                    series: [{ name: 'Enrollees', data: days.series }],
                    chart: { type: 'bar', height: 320, fontFamily: 'inherit', toolbar: { show: false } },
                    colors: ['#10B981'],
                    plotOptions: { bar: { borderRadius: 6, horizontal: false, columnWidth: '45%' } },
                    dataLabels: { enabled: true, style: { fontSize: '12px', colors: ['#fff'] } },
                    xaxis: { categories: days.labels, labels: { style: { colors: '#64748B', fontWeight: 600 } } },
                    yaxis: { show: false },
                    grid: { show: false }
                };
                new ApexCharts(document.querySelector("#enrollmentDaysChart"), dayOpts).render();
            }
        };
    }
</script>
@endsection
