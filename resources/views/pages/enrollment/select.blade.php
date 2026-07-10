@extends('layouts.app')

@section('title', 'Enroll in ' . $course->acronym . ' | SG-Review')

@section('content')
<section class="pt-32 pb-24 md:pt-40 md:pb-32 bg-slate-50 relative min-h-screen">
    {{-- Decorative Background Elements --}}
    <div class="absolute top-20 left-1/2 -translate-x-1/2 w-full max-w-7xl h-96 bg-gradient-to-tr from-blue-500/10 via-indigo-500/10 to-purple-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="container mx-auto px-6 max-w-6xl relative z-10">
        
        {{-- Navigation & Header --}}
        <div class="mb-8 flex items-center justify-between flex-wrap gap-4">
            <a href="{{ route('courses') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-600 hover:text-blue-600 transition-colors bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Available Programs
            </a>
            
            <div class="inline-flex items-center gap-2 bg-amber-100 border border-amber-300 text-amber-800 text-xs font-bold px-3 py-1.5 rounded-full">
                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                Mockup Preview Flow (Google Classroom & Xendit Disabled)
            </div>
        </div>

        {{-- Hero Summary Card --}}
        <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-3xl p-8 md:p-10 text-white shadow-2xl mb-12 relative overflow-hidden border border-slate-800">
            <div class="absolute right-0 top-0 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 relative z-10">
                <div class="max-w-2xl">
                    @if($course->badge)
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-blue-500 text-white mb-4">
                            {{ $course->badge }}
                        </span>
                    @endif
                    <h1 class="text-3xl md:text-4xl font-black tracking-tight mb-3">{{ $course->title }}</h1>
                    <p class="text-slate-300 text-sm md:text-base leading-relaxed">{{ $course->description }}</p>
                </div>
                
                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/15 text-center shrink-0 min-w-[200px]">
                    <span class="block text-xs uppercase tracking-wider text-slate-300 font-semibold mb-1">Standard Tuition</span>
                    <div class="text-3xl font-black text-white">₱{{ number_format($course->price, 0) }}</div>
                    <span class="block text-[11px] text-blue-300 font-medium mt-1">One-time / Full Season</span>
                </div>
            </div>
        </div>

        {{-- Plan Toggle Section --}}
        <div class="text-center mb-10">
            <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 mb-2">Select Your Enrollment Option</h2>
            <p class="text-slate-500 max-w-xl mx-auto text-sm">Choose between our risk-free 7-day trial or full comprehensive season access below.</p>
            
            <div class="inline-flex bg-slate-200/80 p-1.5 rounded-2xl mt-6 border border-slate-300/50 shadow-inner">
                <button type="button" id="tabFreeBtn" onclick="switchPlan('free')" class="px-6 py-3 rounded-xl font-bold text-sm transition-all duration-300 cursor-pointer text-slate-600 hover:text-slate-900">
                    Free Trial (7 Days)
                </button>
                <button type="button" id="tabPremiumBtn" onclick="switchPlan('premium')" class="px-6 py-3 rounded-xl font-bold text-sm transition-all duration-300 cursor-pointer bg-blue-600 text-white shadow-lg shadow-blue-600/30">
                    Premium Reviewer Access ⭐
                </button>
            </div>
        </div>

        {{-- Plan Cards & Forms Container --}}
        <div class="grid lg:grid-cols-12 gap-8 items-start">
            
            {{-- LEFT COLUMN: Plan Comparison Info (5 Cols) --}}
            <div class="lg:col-span-5 space-y-6">
                
                {{-- Free Trial Info Box --}}
                <div id="freeInfoCard" class="bg-white rounded-3xl p-7 border-2 border-slate-200 shadow-sm transition-all hidden">
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700">Option 1</span>
                        <span class="text-2xl font-black text-slate-900">₱0 <span class="text-xs font-normal text-slate-400">/ 7 days</span></span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">7-Day Free Trial</h3>
                    <p class="text-slate-500 text-sm mb-6 leading-relaxed">Perfect for checking out module layouts, sample lessons, and diagnostic quizzes risk-free.</p>
                    
                    <ul class="space-y-3.5 text-sm font-medium text-slate-700 border-t border-slate-100 pt-6">
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            Access to Module 1 Introductory Lessons
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            Sample Diagnostic Drill Questions
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            Telegram Community Forum Read-only
                        </li>
                        <li class="flex items-center gap-3 text-slate-400">
                            <svg class="w-5 h-5 text-slate-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            No Mock Board Exam Access
                        </li>
                        <li class="flex items-center gap-3 text-slate-400">
                            <svg class="w-5 h-5 text-slate-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            No Live Coaching / Zoom Q&A
                        </li>
                    </ul>
                </div>

                {{-- Premium Info Box --}}
                <div id="premiumInfoCard" class="bg-gradient-to-b from-blue-600 to-indigo-700 rounded-3xl p-7 text-white shadow-xl relative overflow-hidden transition-all">
                    <div class="absolute -right-6 -bottom-6 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3 py-1 rounded-full text-xs font-black bg-white text-blue-700 uppercase tracking-wider shadow-sm">Recommended</span>
                        <span class="text-2xl font-black">₱{{ number_format($course->price, 0) }}</span>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Full Premium Access</h3>
                    <p class="text-blue-100 text-sm mb-6 leading-relaxed">The complete, all-inclusive reviewer program designed to help you top and pass the board exam.</p>
                    
                    <ul class="space-y-3.5 text-sm font-medium text-white border-t border-white/15 pt-6">
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-emerald-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            Full Access to All {{ $course->modules->count() }} Modules & Lessons
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-emerald-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            Timed Mock Board Exams with Automated Grading
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-emerald-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            Downloadable PDF Notes & Flashcards
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-emerald-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            Direct Google Classroom Auto-Invitation
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-emerald-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            Live Zoom Mentoring & VIP Chat Access
                        </li>
                    </ul>
                </div>

                {{-- System Maintenance Box --}}
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 text-xs text-amber-800">
                    <div class="font-bold mb-1 flex items-center gap-1.5 text-amber-900">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        System Backup Option
                    </div>
                    If you experience payment gateway disruptions or network issues, you can also enroll directly via our <a href="{{ $course->enrollment_link }}" target="_blank" rel="noopener noreferrer" class="font-bold underline text-amber-900 hover:text-amber-700">Official Google Form Backup Link</a>.
                </div>

            </div>

            {{-- RIGHT COLUMN: Registration Form (7 Cols) --}}
            <div class="lg:col-span-7 bg-white rounded-3xl p-8 md:p-10 border border-slate-200 shadow-xl">
                
                {{-- Form Title --}}
                <div class="mb-8 pb-6 border-b border-slate-100">
                    <h3 id="formHeading" class="text-2xl font-extrabold text-slate-900">Student Enrollment Form</h3>
                    <p id="formSubheading" class="text-sm text-slate-500 mt-1">Please fill in your authentic student information to proceed with Premium Access.</p>
                </div>

                {{-- FORM 1: Free Trial Form --}}
                <form id="freeForm" action="{{ route('enroll.free', $course->id) }}" method="POST" class="space-y-6 hidden">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="student_name" required placeholder="e.g., Maria Santos" value="{{ old('student_name') }}" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">Email Address <span class="text-red-500">*</span></label>
                            <input type="email" name="student_email" required placeholder="maria.santos@gmail.com" value="{{ old('student_email') }}" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition-all">
                            <p class="text-[11px] text-slate-400">Make sure this is active for Google Classroom.</p>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">Mobile Number <span class="text-red-500">*</span></label>
                            <input type="text" name="student_phone" required placeholder="e.g., 09171234567" value="{{ old('student_phone') }}" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">School / Branch / Campus <span class="text-red-500">*</span></label>
                            <input type="text" name="school_name" required placeholder="e.g., UP Diliman / Cebu Branch" value="{{ old('school_name') }}" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition-all">
                        </div>
                    </div>

                    <div class="space-y-2 border-t border-slate-100 pt-5">
                        <div class="flex items-center justify-between">
                            <label class="block text-sm font-bold text-slate-700">Referral / Promo Code <span class="text-slate-400 font-normal">(Optional)</span></label>
                            <span class="text-[11px] font-bold text-blue-600 bg-blue-50 px-2.5 py-0.5 rounded-md uppercase tracking-wide border border-blue-100">Referral System</span>
                        </div>
                        <input type="text" name="referral_code" placeholder="e.g. AGENT-2026 or REF-1234" value="{{ old('referral_code') }}" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition-all uppercase font-mono tracking-wider">
                        <p class="text-[11px] text-slate-400">If you were referred by an ambassador or agent, enter their code here.</p>
                    </div>

                    <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200">
                        <div class="flex items-start gap-3">
                            <input type="checkbox" id="termsFree" required class="mt-1 w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500">
                            <label for="termsFree" class="text-xs text-slate-600 leading-normal">
                                I confirm that all details provided above are accurate and I agree to the 7-day trial terms of SG-Review.
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-extrabold py-4 rounded-2xl shadow-xl transition-all hover:-translate-y-0.5 text-base flex items-center justify-center gap-2 cursor-pointer">
                        <span>Activate 7-Day Free Trial Now</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>

                {{-- FORM 2: Premium Access Form --}}
                <form id="premiumForm" action="{{ route('enroll.premium', $course->id) }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="student_name" required placeholder="e.g., Maria Santos" value="{{ old('student_name') }}" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">Email Address (Google Classroom) <span class="text-red-500">*</span></label>
                            <input type="email" name="student_email" required placeholder="maria.santos@gmail.com" value="{{ old('student_email') }}" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition-all">
                            <p class="text-[11px] text-blue-600 font-semibold">Required: Google Classroom invite will be linked here.</p>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">Mobile Number <span class="text-red-500">*</span></label>
                            <input type="text" name="student_phone" required placeholder="e.g., 09171234567" value="{{ old('student_phone') }}" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">School / Branch / Campus <span class="text-red-500">*</span></label>
                            <input type="text" name="school_name" required placeholder="e.g., UP Diliman / Cebu Branch" value="{{ old('school_name') }}" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition-all">
                        </div>
                    </div>

                    <div class="space-y-2 border-t border-slate-100 pt-5">
                        <div class="flex items-center justify-between">
                            <label class="block text-sm font-bold text-slate-700">Referral / Promo Code <span class="text-slate-400 font-normal">(Optional)</span></label>
                            <span class="text-[11px] font-bold text-blue-600 bg-blue-50 px-2.5 py-0.5 rounded-md uppercase tracking-wide border border-blue-100">Referral System</span>
                        </div>
                        <input type="text" name="referral_code" placeholder="e.g. AGENT-2026 or REF-1234" value="{{ old('referral_code') }}" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition-all uppercase font-mono tracking-wider">
                        <p class="text-[11px] text-slate-400">If you were referred by an ambassador or agent, enter their code here.</p>
                    </div>

                    {{-- Mock Payment Channel Selection --}}
                    <div class="border-t border-slate-100 pt-6">
                        <label class="block text-sm font-bold text-slate-700 mb-3">Select Mock Payment Method (Simulated Checkout)</label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            <label class="cursor-pointer">
                                <input type="radio" name="payment_channel" value="GCASH" checked class="peer sr-only">
                                <div class="p-3 rounded-xl border-2 border-slate-200 peer-checked:border-blue-600 peer-checked:bg-blue-50/50 text-center transition-all">
                                    <span class="block font-black text-sm text-blue-600">GCash</span>
                                    <span class="block text-[10px] text-slate-400">E-Wallet</span>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="payment_channel" value="MAYA" class="peer sr-only">
                                <div class="p-3 rounded-xl border-2 border-slate-200 peer-checked:border-blue-600 peer-checked:bg-blue-50/50 text-center transition-all">
                                    <span class="block font-black text-sm text-emerald-600">Maya</span>
                                    <span class="block text-[10px] text-slate-400">E-Wallet</span>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="payment_channel" value="CREDIT_CARD" class="peer sr-only">
                                <div class="p-3 rounded-xl border-2 border-slate-200 peer-checked:border-blue-600 peer-checked:bg-blue-50/50 text-center transition-all">
                                    <span class="block font-black text-sm text-slate-800">Card / QR Ph</span>
                                    <span class="block text-[10px] text-slate-400">InstaPay</span>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="payment_channel" value="BANK_TRANSFER" class="peer sr-only">
                                <div class="p-3 rounded-xl border-2 border-slate-200 peer-checked:border-blue-600 peer-checked:bg-blue-50/50 text-center transition-all">
                                    <span class="block font-black text-sm text-indigo-600">Bank Transfer</span>
                                    <span class="block text-[10px] text-slate-400">BDO/BPI/Union</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="bg-blue-50/60 rounded-2xl p-5 border border-blue-200">
                        <div class="flex items-center justify-between text-sm font-bold text-slate-800 mb-2">
                            <span>Amount to Pay (Mockup):</span>
                            <span class="text-xl text-blue-600">₱{{ number_format($course->price, 0) }}</span>
                        </div>
                        <div class="flex items-start gap-3 mt-3 border-t border-blue-100 pt-3">
                            <input type="checkbox" id="termsPremium" required class="mt-1 w-4 h-4 text-blue-600 rounded border-slate-300 focus:ring-blue-500">
                            <label for="termsPremium" class="text-xs text-slate-600 leading-normal">
                                I confirm that all information provided is accurate and agree to proceed with mock checkout verification.
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-extrabold py-4 rounded-2xl shadow-xl shadow-blue-600/30 transition-all hover:-translate-y-0.5 text-base flex items-center justify-center gap-2 cursor-pointer">
                        <span>Proceed to Mock Checkout (₱{{ number_format($course->price, 0) }})</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>

            </div>

        </div>

    </div>
</section>

<script>
    function switchPlan(plan) {
        const tabFreeBtn      = document.getElementById('tabFreeBtn');
        const tabPremiumBtn   = document.getElementById('tabPremiumBtn');
        const freeInfoCard    = document.getElementById('freeInfoCard');
        const premiumInfoCard = document.getElementById('premiumInfoCard');
        const freeForm        = document.getElementById('freeForm');
        const premiumForm     = document.getElementById('premiumForm');
        const formHeading     = document.getElementById('formHeading');
        const formSubheading  = document.getElementById('formSubheading');

        if (plan === 'free') {
            tabFreeBtn.className = 'px-6 py-3 rounded-xl font-bold text-sm transition-all duration-300 cursor-pointer bg-slate-900 text-white shadow-lg';
            tabPremiumBtn.className = 'px-6 py-3 rounded-xl font-bold text-sm transition-all duration-300 cursor-pointer text-slate-600 hover:text-slate-900';
            
            freeInfoCard.classList.remove('hidden');
            premiumInfoCard.classList.add('hidden');
            freeForm.classList.remove('hidden');
            premiumForm.classList.add('hidden');

            formHeading.textContent = '7-Day Free Trial Activation';
            formSubheading.textContent = 'Enter your details below to activate immediate access to Module 1 without entering payment details.';
        } else {
            tabPremiumBtn.className = 'px-6 py-3 rounded-xl font-bold text-sm transition-all duration-300 cursor-pointer bg-blue-600 text-white shadow-lg shadow-blue-600/30';
            tabFreeBtn.className = 'px-6 py-3 rounded-xl font-bold text-sm transition-all duration-300 cursor-pointer text-slate-600 hover:text-slate-900';
            
            premiumInfoCard.classList.remove('hidden');
            freeInfoCard.classList.add('hidden');
            premiumForm.classList.remove('hidden');
            freeForm.classList.add('hidden');

            formHeading.textContent = 'Student Enrollment Form';
            formSubheading.textContent = 'Please fill in your authentic student information to proceed with Premium Access.';
        }
    }
</script>
@endsection
