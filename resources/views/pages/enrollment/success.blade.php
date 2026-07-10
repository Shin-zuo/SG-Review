@extends('layouts.app')

@section('title', 'Enrollment Confirmed | SG-Review')

@section('content')
<section class="pt-32 pb-24 md:pt-40 md:pb-32 bg-slate-50 relative min-h-screen flex items-center justify-center">
    {{-- Decorative Background Elements --}}
    <div class="absolute top-24 left-1/2 -translate-x-1/2 w-full max-w-7xl h-96 bg-gradient-to-tr from-emerald-500/10 via-blue-500/10 to-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="container mx-auto px-6 max-w-3xl relative z-10">
        
        {{-- Reviewer Alert Banner --}}
        <div class="mb-8 bg-blue-900 text-blue-100 rounded-2xl p-4 shadow-md flex items-start gap-3 border border-blue-700">
            <span class="text-xl shrink-0 mt-0.5">💡</span>
            <div class="text-xs leading-relaxed">
                <strong class="font-black text-white uppercase tracking-wider">Reviewer Notice — Mockup Flow:</strong><br>
                You are currently reviewing the simulated mockup confirmation screen. Xendit Payment redirection and Google Classroom auto-invite API execution have been bypassed during this review phase as requested.
            </div>
        </div>

        {{-- Main Confirmation Card --}}
        <div class="bg-white rounded-3xl p-8 md:p-12 shadow-2xl border border-slate-200 text-center relative overflow-hidden">
            
            {{-- Top Accent Bar --}}
            <div class="absolute top-0 left-0 right-0 h-3 bg-gradient-to-r from-emerald-500 via-blue-600 to-indigo-600"></div>

            {{-- Animated Checkmark Icon --}}
            <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner ring-8 ring-emerald-50 animate-bounce">
                <svg class="w-10 h-10 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <span class="inline-block px-3.5 py-1 rounded-full text-xs font-black uppercase tracking-widest bg-emerald-50 text-emerald-700 mb-3 border border-emerald-200">
                Enrollment Successful
            </span>

            <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight mb-2">Welcome to {{ $mockData['course_acronym'] ?? 'SG-Review' }}!</h1>
            <p class="text-slate-500 text-sm md:text-base max-w-md mx-auto mb-8">
                We have registered your enrollment under <strong class="text-slate-800">{{ $mockData['student_name'] ?? 'Student' }}</strong> (<span class="text-blue-600 font-semibold">{{ $mockData['student_email'] ?? 'email@example.com' }}</span>).
            </p>

            {{-- Receipt Box --}}
            <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200 text-left mb-8 space-y-4 text-sm">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-slate-200/80 gap-1">
                    <span class="text-slate-500 font-medium">Reference ID</span>
                    <span class="font-mono font-bold text-slate-800 text-xs bg-white px-2.5 py-1 rounded border border-slate-200">
                        {{ $mockData['reference_id'] ?? 'REF-MOCKUP-2026' }}
                    </span>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-slate-200/80 gap-1">
                    <span class="text-slate-500 font-medium">Enrolled Program</span>
                    <span class="font-bold text-slate-900">{{ $mockData['course_title'] ?? 'Reviewer Course' }}</span>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-slate-200/80 gap-1">
                    <span class="text-slate-500 font-medium">Selected Plan</span>
                    <span class="font-bold text-blue-600 bg-blue-50 px-2.5 py-0.5 rounded-full text-xs">
                        {{ $mockData['plan_type'] ?? 'Premium Access' }}
                    </span>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-slate-200/80 gap-1">
                    <span class="text-slate-500 font-medium">School / Branch</span>
                    <span class="font-semibold text-slate-700">{{ $mockData['school_name'] ?? 'Sample Campus' }}</span>
                </div>

                @if(!empty($mockData['referral_code']))
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3 border-b border-slate-200/80 gap-1">
                    <span class="text-slate-500 font-medium">Referral Code</span>
                    <span class="font-mono font-bold text-indigo-700 bg-indigo-50 px-2.5 py-0.5 rounded-full text-xs uppercase">
                        {{ $mockData['referral_code'] }}
                    </span>
                </div>
                @endif

                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                    <span class="text-slate-500 font-medium">Amount & Channel</span>
                    <span class="font-bold text-slate-900">
                        ₱{{ number_format($mockData['amount'] ?? 0, 2) }} 
                        <span class="text-xs text-slate-400 font-normal">({{ $mockData['payment_channel'] ?? 'FREE_TRIAL' }})</span>
                    </span>
                </div>
            </div>

            {{-- Google Classroom & Actions Box --}}
            <div class="space-y-4">
                <div class="bg-blue-50/80 border-2 border-blue-200 rounded-2xl p-6 text-left">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center font-bold text-sm shrink-0">
                            G
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-base">Google Classroom Access</h4>
                            <p class="text-xs text-slate-500">Your mock Classroom invite code / destination is ready below:</p>
                        </div>
                    </div>
                    
                    <div class="mt-4 flex flex-col sm:flex-row items-center gap-3">
                        <input type="text" readonly value="{{ $mockData['google_classroom_id'] ?? 'https://classroom.google.com/c/sample-invite' }}" class="w-full font-mono text-xs bg-white px-3.5 py-2.5 rounded-xl border border-slate-300 text-slate-700 outline-none select-all">
                        <a href="{{ str_starts_with($mockData['google_classroom_id'] ?? '', 'http') ? $mockData['google_classroom_id'] : 'https://classroom.google.com' }}" target="_blank" rel="noopener noreferrer" class="w-full sm:w-auto shrink-0 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs px-5 py-3 rounded-xl transition-all shadow-md text-center block">
                            Join Classroom
                        </a>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <a href="{{ route('courses') }}" class="flex-1 bg-slate-900 hover:bg-slate-800 text-white font-bold py-3.5 px-6 rounded-xl transition-all text-sm shadow-lg text-center">
                        Explore Other Courses
                    </a>
                    @if(!empty($mockData['enrollment_link']))
                    <a href="{{ $mockData['enrollment_link'] }}" target="_blank" rel="noopener noreferrer" class="flex-1 bg-white hover:bg-slate-50 text-slate-700 font-bold py-3.5 px-6 rounded-xl border border-slate-300 transition-all text-sm text-center">
                        View Backup Google Form
                    </a>
                    @endif
                </div>
            </div>

        </div>

    </div>
</section>
@endsection
