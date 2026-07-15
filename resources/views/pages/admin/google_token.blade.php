@extends('layouts.app')

@section('title', 'Google Classroom OAuth Token | SG-Review')

@section('content')
<section class="pt-32 pb-24 md:pt-40 md:pb-32 bg-slate-50 relative min-h-screen flex items-center justify-center">
    <div class="container mx-auto px-6 max-w-3xl relative z-10">
        
        <div class="bg-white rounded-3xl p-8 md:p-12 shadow-2xl border border-slate-200 text-center relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-3 bg-gradient-to-r from-blue-600 via-indigo-600 to-emerald-500"></div>

            <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6 ring-8 ring-blue-50 font-black text-2xl">
                G
            </div>

            <h1 class="text-3xl font-black text-slate-900 mb-3">Google Classroom OAuth Authorization Complete!</h1>
            <p class="text-slate-600 text-sm max-w-lg mx-auto mb-8">
                Your application has successfully authenticated with Google Workspace & Classroom API.
            </p>

            @if($refreshToken)
            <div class="bg-slate-900 text-left rounded-2xl p-6 border border-slate-800 shadow-xl mb-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-400">Your Refresh Token (Copy to .env)</span>
                    <button onclick="navigator.clipboard.writeText('{{ $refreshToken }}'); alert('Copied to clipboard!');" class="text-xs bg-slate-800 hover:bg-slate-700 text-white px-3 py-1.5 rounded-lg border border-slate-700 transition-colors">
                        Copy Token
                    </button>
                </div>
                <div class="font-mono text-sm text-blue-300 break-all bg-black/40 p-4 rounded-xl border border-slate-800/80 select-all">
                    {{ $refreshToken }}
                </div>
                <p class="text-xs text-slate-400 mt-3 leading-relaxed">
                    Paste the string above into your <code class="text-white font-mono bg-slate-800 px-1.5 py-0.5 rounded">.env</code> file under <code class="text-emerald-300 font-mono">GOOGLE_CLASSROOM_REFRESH_TOKEN=""</code>. This token never expires unless revoked.
                </p>
            </div>
            @else
            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-6 text-left text-amber-900 mb-6 text-sm">
                <p class="font-bold mb-1">Notice: Refresh Token not returned by Google</p>
                <p class="leading-relaxed text-xs">
                    If this authorization was already granted previously, Google only sends the <code class="bg-amber-100 px-1 rounded">refresh_token</code> during the very first consent. To generate a fresh token, visit your <a href="https://myaccount.google.com/permissions" target="_blank" class="underline font-bold">Google Account Permissions</a>, revoke access for SG-Review, and click authorize again.
                </p>
            </div>
            @endif

            <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('dashboard') }}" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-8 rounded-xl transition-all shadow-lg text-sm">
                    Back to Admin Dashboard
                </a>
                <a href="{{ route('google.auth') }}" class="w-full sm:w-auto bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-3.5 px-8 rounded-xl transition-all text-sm border border-slate-300">
                    Re-Authorize Google
                </a>
            </div>
        </div>

    </div>
</section>
@endsection
