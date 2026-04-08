<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in | SG-Review</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0e1217] text-slate-300 font-sans antialiased min-h-screen flex flex-col items-center justify-center p-6 selection:bg-blue-500/30">

    <div class="w-full max-w-md">
        
        <div class="flex justify-center mb-8 reveal opacity-0 -translate-y-4 transition-all duration-700 ease-out">
            <a href="{{ route('home') }}" class="text-3xl font-black text-white tracking-tight flex items-center gap-2 hover:opacity-80 transition-opacity">
                <svg class="w-8 h-8 text-blue-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"/><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0v6"/></svg>
                SG-Review
            </a>
        </div>

        <div class="bg-[#161b22] border border-[#30363d] rounded-2xl p-8 shadow-2xl reveal opacity-0 translate-y-4 transition-all duration-700 delay-100 ease-out">
            
            <h2 class="text-2xl font-bold text-[#f0f6fc] mb-2 text-center tracking-tight">Welcome back</h2>
            <p class="text-[#8b949e] text-sm text-center mb-8">Log in to your account to continue</p>

            @if($errors->any())
                <div class="mb-6 p-4 rounded-lg bg-red-500/10 border border-red-500/20 text-red-400 text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login.authenticate') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="username" class="block text-sm font-medium text-[#c9d1d9] mb-2">Username</label>
                    <input type="text" name="username" id="username" required autofocus
                        class="w-full bg-[#0d1117] border border-[#30363d] text-white rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors placeholder-[#484f58]" 
                        placeholder="username">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-sm font-medium text-[#c9d1d9]">Password</label>
                        <a href="#" class="text-sm text-blue-500 hover:text-blue-400 transition-colors">Forgot password?</a>
                    </div>
                    <input type="password" name="password" id="password" required 
                        class="w-full bg-[#0d1117] border border-[#30363d] text-white rounded-xl px-4 py-3 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors placeholder-[#484f58]" 
                        placeholder="••••••••">
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl px-4 py-3.5 transition-all shadow-lg shadow-blue-600/20 hover:shadow-blue-600/40 mt-4 active:scale-[0.98]">
                    Log In
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-[#30363d] flex items-center justify-center gap-2 text-sm text-[#8b949e]">
                <span>Don't have an account?</span>
                <a href="#" class="text-blue-500 hover:text-blue-400 font-semibold transition-colors">Sign up</a>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                document.querySelectorAll('.reveal').forEach((element) => {
                    element.classList.remove('opacity-0', '-translate-y-4', 'translate-y-4');
                });
            }, 50);
        });
    </script>
</body>
</html>