<header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-6 z-10">
    <div class="flex items-center gap-4">
        <button id="mobileSidebarToggle" class="md:hidden text-slate-500 hover:text-blue-600 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
        
        <h2 class="text-xl font-bold text-slate-800">@yield('header_title', 'Dashboard')</h2>
    </div>

    <div class="flex items-center gap-4">
        <div class="flex items-center gap-3 cursor-pointer hover:bg-slate-50 py-1 px-2 rounded-lg transition-colors border border-transparent hover:border-slate-200">
            <div class="w-9 h-9 rounded-full bg-blue-50 text-blue-700 flex items-center justify-center font-bold border border-blue-200">
                A
            </div>
            <div class="hidden sm:block text-left">
                <p class="text-sm font-bold text-slate-700 leading-tight">Admin</p>
                <p class="text-xs text-slate-500 leading-tight">sgwebwork2025...</p>
            </div>
            <svg class="w-4 h-4 text-slate-400 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </div>
    </div>
</header>