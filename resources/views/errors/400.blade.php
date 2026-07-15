@extends('layouts.app')

@section('title', '400 Bad Request | SG-Review')

@section('content')
<section class="pt-32 pb-24 md:pt-40 md:pb-32 bg-slate-50 relative min-h-screen flex items-center justify-center">
    <div class="container mx-auto px-6 max-w-2xl relative z-10">
        
        <div class="bg-white rounded-3xl p-8 md:p-12 shadow-2xl border border-slate-200 text-center relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-3 bg-gradient-to-r from-amber-500 via-red-500 to-indigo-600"></div>

            <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-6 ring-8 ring-red-50 font-black text-2xl">
                ⚠️
            </div>

            <h1 class="text-3xl font-black text-slate-900 mb-3">Missing OAuth Authorization Code</h1>
            <p class="text-slate-600 text-sm max-w-lg mx-auto mb-6">
                {{ $message ?? 'The request is missing the required authorization parameter from Google.' }}
            </p>

            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 text-left text-xs text-amber-900 mb-8 leading-relaxed">
                <strong class="font-bold block mb-1">How to properly generate your Refresh Token:</strong>
                <ol class="list-decimal pl-4 space-y-1">
                    <li>Do not access `/auth/google/callback` directly in your browser address bar.</li>
                    <li>First visit <a href="{{ route('google.auth') }}" class="underline font-bold text-blue-700">http://localhost:8090/admin/google/auth</a> while logged in as admin.</li>
                    <li>Select your Google account on Google's consent screen and click <strong>Continue/Allow</strong>.</li>
                    <li>Google will automatically redirect you back to this callback page with the correct <code class="bg-amber-100 px-1 rounded font-mono">?code=...</code> parameter attached.</li>
                </ol>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('google.auth') }}" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-8 rounded-xl transition-all shadow-lg text-sm">
                    Start Google Authorization Now
                </a>
                <a href="{{ route('dashboard') }}" class="w-full sm:w-auto bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-3.5 px-8 rounded-xl transition-all text-sm border border-slate-300">
                    Back to Dashboard
                </a>
            </div>
        </div>

    </div>
</section>
@endsection
