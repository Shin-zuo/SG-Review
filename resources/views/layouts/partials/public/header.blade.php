<nav id="navbar" class="fixed w-full top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-200/50 transition-transform duration-300 transform translate-y-0">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center relative z-20">
        
        <a href="{{ route('home') }}" class="text-2xl font-extrabold text-blue-700 tracking-tight flex items-center gap-2">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"/><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0v6"/></svg>
            SG-Review
        </a>

        <div class="hidden md:flex space-x-8 text-sm font-semibold text-slate-600">
            <a href="{{ route('home') }}#reviewers" class="hover:text-blue-600 transition-colors">Our Reviewers</a>
            <a href="{{ route('home') }}#features" class="hover:text-blue-600 transition-colors">Why Us</a>
            <a href="{{ route('contact') }}" class="hover:text-blue-600 transition-colors">Contact Us</a>
        </div>

        <a href="{{ route('home') }}#reviewers" class="hidden md:inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-full font-semibold transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
            Get Started
        </a>

        <button id="mobileMenuBtn" class="md:hidden flex items-center p-2 text-slate-600 hover:text-blue-600 focus:outline-none transition-colors" aria-label="Toggle mobile menu">
            <svg id="menuIcon" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
            <svg id="closeIcon" class="w-7 h-7 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <div id="mobileMenu" class="hidden md:hidden absolute top-full left-0 w-full bg-white border-b border-slate-200 shadow-xl transition-all duration-300 origin-top">
        <div class="flex flex-col px-6 py-6 space-y-6 text-center">
            <a href="{{ route('home') }}#reviewers" class="mobile-link text-lg text-slate-700 font-bold hover:text-blue-600 transition-colors">Our Reviewers</a>
            <a href="{{ route('home') }}#features" class="mobile-link text-lg text-slate-700 font-bold hover:text-blue-600 transition-colors">Why Us</a>
            <a href="{{ route('contact') }}" class="mobile-link text-lg text-slate-700 font-bold hover:text-blue-600 transition-colors">Contact Us</a>
            
            <div class="pt-4 border-t border-slate-100">
                <a href="{{ route('home') }}#reviewers" class="mobile-link w-full inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-4 rounded-xl font-bold transition-all shadow-md">
                    Get Started
                </a>
            </div>
        </div>
    </div>
</nav>