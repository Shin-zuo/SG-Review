@extends('layouts.app')

@section('title', '500 Server Error | SG-Review')

@section('content')
<section class="pt-32 pb-24 md:pt-40 md:pb-32 bg-slate-50 relative min-h-screen flex items-center justify-center">
    <div class="container mx-auto px-6 max-w-2xl relative z-10">
        
        <div class="bg-white rounded-3xl p-8 md:p-12 shadow-2xl border border-slate-200 text-center relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-3 bg-gradient-to-r from-red-600 to-amber-600"></div>

            <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-6 ring-8 ring-red-50 font-black text-2xl">
                ❌
            </div>

            <h1 class="text-3xl font-black text-slate-900 mb-3">Google OAuth Token Exchange Failed</h1>
            <p class="text-slate-600 text-sm max-w-lg mx-auto mb-6 font-mono break-all bg-red-50 p-4 rounded-xl border border-red-200">
                {{ $message ?? 'An unexpected error occurred while exchanging the OAuth code.' }}
            </p>

            <div class="bg-slate-900 text-left rounded-2xl p-5 text-xs text-slate-300 mb-8 leading-relaxed space-y-2 border border-slate-800">
                <strong class="font-bold text-white block">Check the following common causes:</strong>
                <ul class="list-disc pl-4 space-y-1">
                    <li>Double check that <code class="text-emerald-400 font-mono">GOOGLE_CLASSROOM_CLIENT_ID</code> and <code class="text-emerald-400 font-mono">GOOGLE_CLASSROOM_CLIENT_SECRET</code> in `.env` match your Google Cloud Console exactly.</li>
                    <li>Verify that <code class="text-emerald-400 font-mono">http://localhost:8090/auth/google/callback</code> is explicitly added under <strong>Authorized redirect URIs</strong> in your Google Cloud Console.</li>
                    <li>Make sure the authorization code was not already used or expired (codes expire after 5 minutes).</li>
                </ul>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('google.auth') }}" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-8 rounded-xl transition-all shadow-lg text-sm">
                    Try Again (/admin/google/auth)
                </a>
                <a href="{{ route('dashboard') }}" class="w-full sm:w-auto bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-3.5 px-8 rounded-xl transition-all text-sm border border-slate-300">
                    Back to Dashboard
                </a>
            </div>
        </div>

    </div>
</section>
@endsection
