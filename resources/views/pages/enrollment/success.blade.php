@extends('layouts.app')

@section('title', 'Enrollment Confirmed | SG-Review')

@section('content')
<section class="pt-32 pb-24 md:pt-40 md:pb-32 bg-slate-50 relative min-h-screen flex items-center justify-center">
    {{-- Decorative Background Elements --}}
    <div class="absolute top-24 left-1/2 -translate-x-1/2 w-full max-w-7xl h-96 bg-gradient-to-tr from-emerald-500/10 via-blue-500/10 to-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="container mx-auto px-6 max-w-3xl relative z-10">
        
        {{-- System Integration Alert Banner --}}
        @if(str_contains($mockData['status'] ?? '', 'Pending'))
        <div class="mb-8 bg-amber-900 text-amber-100 rounded-2xl p-4 shadow-md flex items-start gap-3 border border-amber-700">
            <span class="text-xl shrink-0 mt-0.5">⏳</span>
            <div class="text-xs leading-relaxed">
                <strong class="font-black text-white uppercase tracking-wider">Payment Verification in Progress:</strong><br>
                We have initiated your Xendit GCash transaction. Once Xendit verifies the payment via our automated webhook (`invoice.paid`), your status will automatically change to <strong class="text-amber-300">Paid</strong> and your Google Classroom invitation will be sent to your email.
            </div>
        </div>
        @else
        <div class="mb-8 bg-emerald-900 text-emerald-100 rounded-2xl p-4 shadow-md flex items-start gap-3 border border-emerald-700">
            <span class="text-xl shrink-0 mt-0.5">🚀</span>
            <div class="text-xs leading-relaxed">
                <strong class="font-black text-white uppercase tracking-wider">System Integrated & Active:</strong><br>
                Your enrollment status is <strong class="text-emerald-300">{{ $mockData['status'] ?? 'Confirmed' }}</strong>. Your automated Google Classroom invitation via OAuth 2.0 has been triggered directly to your registered email address.
            </div>
        </div>
        @endif

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
            <div class="space-y-5">
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50/80 border-2 border-blue-200 rounded-3xl p-6 md:p-7 text-left relative overflow-hidden shadow-sm">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center font-black text-lg shrink-0 shadow-lg shadow-blue-600/20">
                            G
                        </div>
                        <div class="space-y-2">
                            <h4 class="font-black text-slate-900 text-lg">Google Classroom Invitation Sent via Email</h4>
                            <p class="text-sm text-slate-600 leading-relaxed">
                                To protect course security and prevent unauthorized invite link sharing, your official Google Classroom invitation has been dispatched directly to your registered email address (<strong class="text-blue-700 font-bold">{{ $mockData['student_email'] ?? 'your email' }}</strong>) via our Google OAuth 2.0 automated system.
                            </p>
                            <div class="bg-white/90 rounded-xl p-3.5 border border-blue-100/80 flex items-center gap-2.5 text-xs font-semibold text-slate-700 mt-3 shadow-sm">
                                <svg class="w-5 h-5 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span>Please check your email inbox (and Spam/Promotions folder) and click <strong>"Join"</strong> on the official invitation email.</span>
                            </div>
                        </div>
                    </div>
                </div>

                @if(!empty($mockData['enrollment_link']))
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 text-left text-xs text-amber-800 flex flex-col sm:flex-row items-center justify-between gap-3">
                    <div>
                        <strong class="font-bold text-amber-950 block mb-0.5">System Maintenance Backup Form:</strong>
                        <span>Reserved strictly if the automated enrollment system or Xendit payment API experiences an outage.</span>
                    </div>
                    <a href="{{ $mockData['enrollment_link'] }}" target="_blank" rel="noopener noreferrer" class="shrink-0 bg-amber-600 hover:bg-amber-700 text-white font-bold px-4 py-2 rounded-xl transition-all shadow-sm text-xs text-center block">
                        Backup Form
                    </a>
                </div>
                @endif

                <div class="pt-2">
                    <a href="{{ route('courses') }}" class="w-full inline-block bg-slate-900 hover:bg-slate-800 text-white font-bold py-4 px-8 rounded-2xl transition-all text-sm shadow-xl text-center hover:-translate-y-0.5">
                        Explore Other Available Programs
                    </a>
                </div>
            </div>

        </div>

    </div>
</section>
@endsection
