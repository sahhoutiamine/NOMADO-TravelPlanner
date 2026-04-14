<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nomado - Generative Travel Planner</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Scripts/Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        .fade-in {
            animation: fadeIn 0.4s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col font-sans selection:bg-primary-500 selection:text-white">
    <!-- Navbar -->
    <nav class="fixed w-full z-50 glass border-b border-white/40 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex-shrink-0 flex items-center gap-2">
                    <!-- Logo Icon -->
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-primary-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-primary-500/30">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    </div>
                    <span class="font-bold text-xl tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-slate-600">Nomado</span>
                </div>
                <!-- Links -->
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="{{ route('trip.index') }}" class="text-slate-600 hover:text-primary-600 font-bold text-sm uppercase tracking-widest transition-colors {{ Route::is('trip.*') ? 'text-primary-600' : '' }}">Generator</a>
                    <a href="{{ route('places.index') }}" class="text-slate-600 hover:text-primary-600 font-bold text-sm uppercase tracking-widest transition-colors {{ Route::is('places.*') ? 'text-primary-600' : '' }}">Destinations</a>
                    <a href="{{ route('bookings.index') }}" class="text-slate-600 hover:text-primary-600 font-bold text-sm uppercase tracking-widest transition-colors {{ Route::is('bookings.*') ? 'text-primary-600' : '' }}">My Trips</a>
                </div>

                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 pr-4 border-r border-slate-200 hover:opacity-80 transition-opacity group">
                            <div class="text-right hidden sm:block">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Traveler</p>
                                <p class="text-xs font-black text-slate-900 leading-none group-hover:text-primary-600 transition-colors">{{ auth()->user()->name }}</p>
                            </div>
                            <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 border border-slate-200 group-hover:border-primary-200 group-hover:bg-primary-50 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-xs font-black text-red-500 uppercase tracking-widest hover:text-red-700 transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-black text-slate-700 hover:text-primary-600 uppercase tracking-widest transition-colors">Sign in</a>
                        <a href="{{ route('register') }}" class="px-6 py-2.5 bg-slate-900 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-primary-600 transition-all shadow-lg shadow-slate-900/10">Join Nomado</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow pt-16">
        @yield('content')
        {{ $slot ?? '' }}
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 mt-auto">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-slate-500 text-sm">© 2026 Nomado Travel Planner. All rights reserved.</p>
            <div class="flex gap-4">
                <a href="#" class="text-slate-400 hover:text-slate-600 transition-colors">Twitter</a>
                <a href="#" class="text-slate-400 hover:text-slate-600 transition-colors">GitHub</a>
            </div>
        </div>
    </footer>
</body>
</html>
