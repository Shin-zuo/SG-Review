<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SG-Review | Premier Board Exam Reviewers')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased selection:bg-blue-600 selection:text-white flex flex-col min-h-screen">

    @include('layouts.partials.public.header')

    <main class="flex-grow">
        @yield('content')
    </main>

    @include('layouts.partials.public.footer')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const navbar = document.getElementById('navbar');
            let lastScrollY = window.scrollY;

            window.addEventListener('scroll', () => {
                if (window.scrollY > lastScrollY && window.scrollY > 80) {
                    navbar.classList.add('-translate-y-full'); 
                } else {
                    navbar.classList.remove('-translate-y-full'); 
                }
                lastScrollY = window.scrollY;
            }, { passive: true }); 

            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.15 
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.remove('opacity-0', 'translate-y-8');
                        entry.target.classList.add('opacity-100', 'translate-y-0');
                        observer.unobserve(entry.target); 
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.reveal').forEach((element) => {
                observer.observe(element);
            });
        });

//hamburger menu
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const mobileMenu = document.getElementById('mobileMenu');
            const menuIcon = document.getElementById('menuIcon');
            const closeIcon = document.getElementById('closeIcon');
            const mobileLinks = document.querySelectorAll('.mobile-link');

            if (mobileMenuBtn && mobileMenu) {
                const toggleMenu = () => {
                    mobileMenu.classList.toggle('hidden');
                    menuIcon.classList.toggle('hidden');
                    closeIcon.classList.toggle('hidden');
                    
                    // Optional: Give the nav a solid white background when open so it doesn't clash with scrolling content
                    if (!mobileMenu.classList.contains('hidden')) {
                        navbar.classList.add('bg-white');
                        navbar.classList.remove('bg-white/80', 'backdrop-blur-md');
                    } else {
                        navbar.classList.remove('bg-white');
                        navbar.classList.add('bg-white/80', 'backdrop-blur-md');
                    }
                };

                mobileMenuBtn.addEventListener('click', toggleMenu);

                // Auto-close menu when a link is clicked
                mobileLinks.forEach(link => {
                    link.addEventListener('click', () => {
                        if (!mobileMenu.classList.contains('hidden')) {
                            toggleMenu();
                        }
                    });
                });
            }
    </script>
</body>
</html>