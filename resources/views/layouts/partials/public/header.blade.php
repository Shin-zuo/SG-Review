<nav id="navbar" class="fixed w-full top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-200/50 transition-transform duration-300 transform translate-y-0">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
        <a href="{{ route('home') }}" class="text-2xl font-extrabold text-blue-700 tracking-tight flex items-center gap-2">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"/><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0v6"/></svg>
            SG-Review
        </a>
        <div class="hidden md:flex space-x-8 text-sm font-semibold text-slate-600">
            <a href="{{ route('home') }}#reviewers" class="hover:text-blue-600 transition-colors">Our Reviewers</a>
            <a href="{{ route('home') }}#features" class="hover:text-blue-600 transition-colors">Why Us</a>
            <a href="{{ route('contact') }}" class="hover:text-blue-600 transition-colors">Contact Us</a>
        </div>
        <a href="{{ route('home') }}#reviewers" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-full font-semibold transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
            Get Started
        </a>
    </div>
</nav>