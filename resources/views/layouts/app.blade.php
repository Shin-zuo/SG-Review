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
    </script>
</body>
</html>