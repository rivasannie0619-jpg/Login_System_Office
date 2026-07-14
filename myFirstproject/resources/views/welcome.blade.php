<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Guestly - Visitor Log</title>
        
        <!-- Premium Google Font -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
            }
            /* High-tech fluid mesh animation */
            @keyframes morph {
                0% { border-radius: 42% 58% 70% 30% / 45% 45% 55% 55%; transform: translate(0px, 0px) rotate(0deg); }
                50% { border-radius: 70% 30% 52% 48% / 60% 40% 60% 40%; transform: translate(40px, -60px) rotate(180deg); }
                100% { border-radius: 42% 58% 70% 30% / 45% 45% 55% 55%; transform: translate(0px, 0px) rotate(360deg); }
            }
            .animate-blob {
                animation: morph 20s linear infinite;
            }
            /* Subtle Tech Grid pattern background */
            .bg-grid {
                background-size: 30px 30px;
                background-image: linear-gradient(to right, rgba(99, 102, 241, 0.03) 1px, transparent 1px),
                                  linear-gradient(to bottom, rgba(99, 102, 241, 0.03) 1px, transparent 1px);
            }
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col justify-between selection:bg-indigo-500 selection:text-white relative overflow-hidden bg-grid">
        
        <!-- Decorative Glow System -->
        <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[800px] h-[800px] bg-gradient-to-tr from-indigo-400/20 via-purple-300/20 to-pink-300/10 rounded-full blur-[140px] -z-10 animate-blob"></div>
        <div class="absolute -bottom-20 -right-20 w-[400px] h-[400px] bg-sky-200/20 rounded-full blur-[100px] -z-10"></div>

        <!-- Header -->
        <header class="w-full bg-white/40 backdrop-blur-md sticky top-0 z-50 border-b border-slate-200/40">
            <div class="max-w-5xl mx-auto px-8 h-20 flex items-center justify-between">
                
                <!-- Brand / Logo -->
                <div class="flex items-center gap-3 group cursor-pointer">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-violet-600 flex items-center justify-center transition-all duration-500 group-hover:scale-110 group-hover:rotate-6 shadow-lg shadow-indigo-200">
                        <!-- Classy Minimalist SVG Icon -->
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"></path>
                        </svg>
                    </div>
                    <span class="text-base font-extrabold tracking-tight text-slate-900 group-hover:text-indigo-600 transition-colors duration-300">
                        Guestly
                    </span>
                </div>

                <!-- Nav links with scale and lift -->
                @if (Route::has('login'))
                    <nav class="flex items-center gap-6">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-xs font-bold uppercase tracking-wider text-slate-600 hover:text-indigo-600 transition-all duration-300">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-slate-900 transition-all duration-300">
                                Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-xs font-bold uppercase tracking-wider text-white bg-indigo-600 hover:bg-indigo-500 px-6 py-3 rounded-full shadow-md shadow-indigo-100 hover:shadow-xl hover:shadow-indigo-200 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col justify-center items-center px-6 py-12">
            <div class="max-w-xl w-full text-center space-y-10">
                
                <!-- Exciting Interactive Badge -->
                <div class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full bg-white/80 border border-indigo-100/80 text-[11px] font-extrabold tracking-wider text-indigo-600 uppercase mx-auto shadow-sm backdrop-blur-sm cursor-default hover:border-indigo-300 hover:scale-105 transition-all duration-300">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-600"></span>
                    </span>
                    Live Tracking Active
                </div>

                <!-- Premium Typography with Multi-color Gradient -->
                <div class="space-y-4">
                    <h1 class="text-4xl sm:text-6xl font-extrabold tracking-tight text-slate-900 leading-[1.1]">
                        Seamless & Secure <br />
                        <span class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 bg-clip-text text-transparent drop-shadow-sm">Visitor Management</span>
                    </h1>
                    <p class="text-sm sm:text-base text-slate-400 max-w-sm mx-auto leading-relaxed font-medium">
                        Ditch the paper. Seamlessly log your entry and exit with a single click.
                    </p>
                </div>

                <!-- Glassmorphism Kiosk Card (Premium Glow-up) -->
                <div class="mx-auto max-w-xs p-8 bg-white/70 backdrop-blur-xl border border-white rounded-[2.5rem] shadow-[0_10px_40px_rgba(0,0,0,0.02)] hover:shadow-[0_20px_60px_rgba(99,102,241,0.18)] hover:border-indigo-200/60 hover:-translate-y-2 transition-all duration-500 group cursor-default relative overflow-hidden">
                    <!-- Invisible top corner glow decoration on hover -->
                    <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-indigo-500/10 to-transparent rounded-bl-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <div class="flex items-center justify-between border-b border-slate-100 pb-5 mb-5">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Status</span>
                        <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50/80 border border-emerald-100 px-3 py-1 rounded-full flex items-center gap-1.5 shadow-sm">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Online
                        </span>
                    </div>
                    
                    <div class="text-left space-y-1.5 relative z-10">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Date & Time</span>
                        <p class="text-lg font-black text-slate-800 transition-colors duration-300 group-hover:text-indigo-600 tracking-tight">
                            {{ date('l, F d, Y') }}
                        </p>
                    </div>
                </div>

            </div>
        </main>

        <!-- Footer -->
        <footer class="w-full text-center py-8 border-t border-slate-200/40 bg-white/20 backdrop-blur-md">
            <div class="max-w-5xl mx-auto px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-[10px] font-bold tracking-wider text-slate-400 uppercase">
                <span>&copy; {{ date('Y') }} Guestly</span>
                <span class="text-indigo-600/70 tracking-widest">Elevating Lobby Experiences</span>
            </div>
        </footer>

    </body>
</html>