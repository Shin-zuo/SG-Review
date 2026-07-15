@extends('layouts.app')

@section('title', 'Official Ambassador & Agent Registration | SG-Review')

@section('content')
    <div class="pt-32 pb-24 md:pt-40 min-h-screen bg-slate-50/60 relative overflow-hidden">
        {{-- Background ambient glow --}}
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[400px] bg-gradient-to-tr from-blue-600/10 via-indigo-600/10 to-transparent rounded-full blur-3xl pointer-events-none"></div>

        <div class="container mx-auto px-6 max-w-6xl relative z-10">
            
            {{-- Header section --}}
            <div class="reveal opacity-0 translate-y-8 transition-all duration-700 ease-out text-center mb-16">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 text-blue-700 font-bold text-xs uppercase tracking-wider mb-4 border border-blue-200 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                    Official Partnership Program
                </div>
                <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight mb-4">
                    Join Our Growing Ambassador Network
                </h1>
                <p class="text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
                    Empower aspiring PRC topnotchers across the Philippines while earning a lucrative <span class="font-bold text-blue-600">10% direct commission</span> on every successful enrollment.
                </p>
            </div>

            <div class="grid md:grid-cols-12 gap-8 bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-200/80 overflow-hidden">
                
                {{-- Left Column: Program Highlights & Commission Info --}}
                <div class="reveal opacity-0 translate-y-8 transition-all duration-700 delay-100 ease-out md:col-span-5 bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 p-8 md:p-12 text-white relative flex flex-col justify-between">
                    <div class="absolute -bottom-24 -right-24 w-72 h-72 bg-blue-500 rounded-full blur-3xl opacity-30 pointer-events-none"></div>
                    <div class="absolute top-0 right-0 w-48 h-48 bg-indigo-500 rounded-full blur-2xl opacity-20 pointer-events-none"></div>

                    <div class="relative z-10 space-y-8">
                        <div>
                            <span class="text-blue-400 font-extrabold tracking-widest uppercase text-xs">Why Partner With Us?</span>
                            <h3 class="text-2xl md:text-3xl font-black mt-2 leading-tight">Turn Your Network Into Earning Power.</h3>
                        </div>
                        
                        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/15">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 rounded-xl bg-blue-500/20 flex items-center justify-center text-blue-400 font-bold text-lg">
                                    💰
                                </div>
                                <div>
                                    <h4 class="font-black text-lg text-white">10% Direct Commission</h4>
                                    <p class="text-xs text-blue-200 font-medium">On every course enrolled with your code</p>
                                </div>
                            </div>
                            <p class="text-sm text-slate-300 mt-3 leading-relaxed">
                                Earn substantial, reliable payouts every time a student registers using your unique referral code. Whether you refer 5 students or 500, your 10% rate is guaranteed!
                            </p>
                        </div>

                        <div class="space-y-5">
                            <div class="flex items-start gap-4">
                                <div class="w-6 h-6 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400 mt-0.5 shrink-0">✓</div>
                                <div>
                                    <h4 class="font-bold text-sm">Personalized Referral Code</h4>
                                    <p class="text-xs text-slate-400 mt-1">Customize your own memorable promo code during registration or let our system generate an official one instantly.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-6 h-6 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400 mt-0.5 shrink-0">✓</div>
                                <div>
                                    <h4 class="font-bold text-sm">Automated Welcome Kit</h4>
                                    <p class="text-xs text-slate-400 mt-1">Receive an immediate email with your ambassador credentials, referral code, and partnership guide upon submission.</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-6 h-6 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400 mt-0.5 shrink-0">✓</div>
                                <div>
                                    <h4 class="font-bold text-sm">High-Yield Review Materials</h4>
                                    <p class="text-xs text-slate-400 mt-1">You are promoting industry-leading PRC board exam materials engineered for first-try passing.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="relative z-10 pt-8 mt-8 border-t border-white/10 text-xs text-slate-400">
                        Got questions? Contact our partnership desk at <a href="mailto:sgwebwork2025@gmail.com" class="text-blue-400 underline hover:text-blue-300">sgwebwork2025@gmail.com</a>
                    </div>
                </div>

                {{-- Right Column: Registration Form --}}
                <div class="reveal opacity-0 translate-y-8 transition-all duration-700 delay-200 ease-out md:col-span-7 p-8 md:p-12">
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-slate-900">Ambassador Registration Form</h3>
                        <p class="text-slate-500 text-sm mt-1">Fill out your details below. Your referral code and partnership credentials will be sent directly to your email.</p>
                    </div>

                    {{-- Success Alert --}}
                    @if(session('success'))
                        <div class="mb-8 p-6 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-start gap-4">
                            <div class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold text-lg shrink-0">✓</div>
                            <div>
                                <h4 class="font-bold text-emerald-900 text-base">Registration Successful!</h4>
                                <p class="text-emerald-700 text-sm mt-1 leading-relaxed">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Error Alert --}}
                    @if ($errors->any())
                        <div class="mb-8 p-6 bg-red-50 border border-red-200 rounded-2xl">
                            <div class="flex items-center gap-2 text-red-800 font-bold text-sm mb-2">
                                <svg class="w-5 h-5 text-red-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                Please correct the following errors:
                            </div>
                            <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('agents.register.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Full Name <span class="text-red-500">*</span></label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                    placeholder="e.g. Juan Dela Cruz"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-none transition-all text-slate-800 text-sm bg-slate-50/50 focus:bg-white font-medium">
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-bold text-slate-700 mb-2">Email Address <span class="text-red-500">*</span></label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                    placeholder="e.g. juan@example.com"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-none transition-all text-slate-800 text-sm bg-slate-50/50 focus:bg-white font-medium">
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="phone_number" class="block text-sm font-bold text-slate-700 mb-2">Contact Number <span class="text-red-500">*</span></label>
                                <input type="number" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required
                                    placeholder="e.g. 0917 123 4567"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-none transition-all text-slate-800 text-sm bg-slate-50/50 focus:bg-white font-medium">
                            </div>

                            <div>
                                <label for="facebook_link" class="block text-sm font-bold text-slate-700 mb-2">
                                    Facebook Profile Link <span class="text-slate-400 font-normal text-xs">(Optional)</span>
                                </label>
                                <input type="text" id="facebook_link" name="facebook_link" value="{{ old('facebook_link') }}"
                                    placeholder="e.g. https://facebook.com/juandelacruz"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-none transition-all text-slate-800 text-sm bg-slate-50/50 focus:bg-white font-medium">
                            </div>
                        </div>

                        <div class="pt-2">
                            <label for="agent_code" class="block text-sm font-bold text-slate-700 mb-1">
                                Customize Referral Code <span class="text-slate-400 font-normal text-xs">(Optional)</span>
                            </label>
                            <div class="relative">
                                <input type="text" id="agent_code" name="agent_code" value="{{ old('agent_code') }}" uppercase
                                    placeholder="e.g. JUAN-PRC2026"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-none transition-all text-slate-800 text-sm bg-slate-50/50 focus:bg-white font-bold tracking-wide uppercase">
                            </div>
                            <p class="text-xs text-slate-500 mt-2 flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Leave blank and our system will automatically generate an official unique referral code for you upon submission!</span>
                            </p>
                        </div>

                        <div class="pt-4 border-t border-slate-100">
                            <button type="submit"
                                class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-extrabold py-4 px-8 rounded-xl shadow-lg shadow-blue-600/30 hover:shadow-blue-600/50 hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center justify-center gap-2 cursor-pointer">
                                <span>Complete Ambassador Registration</span>
                                <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>
                    </form>

                    <div class="mt-8 text-center">
                        <a href="{{ route('home') }}#agent" class="text-xs text-slate-400 hover:text-slate-600 underline font-medium">
                            ← Back to Home Page
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
