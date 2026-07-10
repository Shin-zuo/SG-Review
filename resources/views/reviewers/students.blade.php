@extends('layouts.app')

@section('title', 'Enrolled Students & Reviewers Management | SG-Review')

@section('content')
<section class="pt-32 pb-24 md:pt-40 md:pb-32 bg-slate-50 min-h-screen">
    <div class="container mx-auto px-6 max-w-7xl">
        
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-8 gap-4">
            <div>
                <span class="px-3 py-1 rounded-full text-xs font-black bg-blue-100 text-blue-700 uppercase tracking-wider">Admin Management</span>
                <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mt-2">Enrolled Students Database</h1>
                <p class="text-slate-500 text-sm mt-1">Review student enrollments across all programs and check Xendit/Google Classroom status.</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('reviewers') }}" class="px-5 py-2.5 rounded-xl font-bold text-sm bg-white border border-slate-200 text-slate-700 hover:bg-slate-100 transition-all shadow-sm">
                    Manage Courses
                </a>
                <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-xl font-bold text-sm bg-blue-600 text-white hover:bg-blue-700 transition-all shadow-md">
                    Dashboard
                </a>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-200 text-xs font-black uppercase tracking-wider text-slate-500">
                            <th class="py-4 px-6">Reference ID</th>
                            <th class="py-4 px-6">Student Info</th>
                            <th class="py-4 px-6">Course / Branch</th>
                            <th class="py-4 px-6">Plan & Amount</th>
                            <th class="py-4 px-6">Status</th>
                            <th class="py-4 px-6">Enrolled Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($students as $student)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-4 px-6 font-mono text-xs text-slate-500">
                                    {{ Str::limit($student->reference_id, 13) }}
                                </td>
                                <td class="py-4 px-6">
                                    <div class="font-bold text-slate-900">{{ $student->student_name }}</div>
                                    <div class="text-xs text-blue-600">{{ $student->student_email }}</div>
                                    <div class="text-xs text-slate-400">{{ $student->student_phone }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="inline-block font-semibold text-slate-800 bg-slate-100 px-2.5 py-1 rounded-lg text-xs mb-1">
                                        {{ $student->course->acronym ?? ($student->course->title ?? 'Course #' . $student->course_id) }}
                                    </span>
                                    <div class="text-xs text-slate-500">{{ $student->school_name }}</div>
                                    @if($student->referral_code)
                                        <div class="mt-1 inline-flex items-center gap-1 font-mono text-[10px] uppercase font-bold text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded border border-indigo-100">
                                            <span>🎁 {{ $student->referral_code }}</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <span class="font-bold {{ $student->plan_type === 'premium' ? 'text-indigo-600' : 'text-slate-600' }} capitalize">
                                        {{ str_replace('_', ' ', $student->plan_type) }}
                                    </span>
                                    <div class="text-xs font-extrabold text-slate-900">₱{{ number_format($student->amount, 2) }}</div>
                                    @if($student->payment_channel)
                                        <div class="text-[10px] uppercase text-slate-400">{{ $student->payment_channel }}</div>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    @if($student->status === 'paid' || $student->status === 'active')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            {{ ucfirst($student->status) }}
                                        </span>
                                    @elseif($student->status === 'pending')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                            Pending
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                                            {{ ucfirst($student->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-xs text-slate-500">
                                    {{ $student->created_at ? $student->created_at->format('M d, Y h:i A') : 'N/A' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colSpan="6" class="py-16 text-center">
                                    <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="text-base font-bold text-slate-800 mb-1">No Enrolled Students Found</h4>
                                    <p class="text-xs text-slate-500">Once students complete the enrollment mockup or real payment, they will show up here.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($students->hasPages())
                <div class="p-6 border-t border-slate-100 bg-slate-50/50">
                    {{ $students->links() }}
                </div>
            @endif
        </div>

    </div>
</section>
@endsection
