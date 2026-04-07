<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel | SG-Review')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased flex h-screen overflow-hidden">

    <div id="sidebarOverlay" class="fixed inset-0 bg-slate-900/50 z-20 hidden md:hidden backdrop-blur-sm transition-opacity"></div>

    @include('layouts.partials.admin.sidebar')

    <div class="flex-1 flex flex-col overflow-hidden relative w-full">
        
        @include('layouts.partials.admin.header')

        <main class="flex-1 overflow-x-hidden overflow-y-auto p-6">
            @yield('content')
        </main>
        
        @include('layouts.partials.admin.footer')
        
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1. Mobile Sidebar Toggle Logic
            const mobileToggle = document.getElementById('mobileSidebarToggle');
            const closeSidebarBtn = document.getElementById('closeSidebarBtn');
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            
            const toggleSidebar = () => {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            };

            if(mobileToggle && sidebar && overlay) {
                mobileToggle.addEventListener('click', toggleSidebar);
                overlay.addEventListener('click', toggleSidebar);
                if(closeSidebarBtn) closeSidebarBtn.addEventListener('click', toggleSidebar);
            }

            // 2. Global SweetAlert Listener (Tailwind Styled)
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'bg-white text-slate-800 rounded-xl shadow-lg border border-slate-200',
                    title: 'text-slate-800 font-bold',
                }
            });

            @if(session('success'))
                Toast.fire({
                    icon: 'success',
                    title: '{{ session('success') }}'
                });
            @endif

            @if(session('error'))
                Toast.fire({
                    icon: 'error',
                    title: '{{ session('error') }}'
                });
            @endif
        });
    </script>
</body>
</html>