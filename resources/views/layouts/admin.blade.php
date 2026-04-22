<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nomado Admin - Orchestrator</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <!-- Tailwind -->
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
                            600: '#0284c7',
                            700: '#0369a1',
                        },
                        slate: {
                            950: '#020617',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .glass-sidebar {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }
        .sidebar-link-active {
            background: #0284c7;
            color: white !important;
            box-shadow: 0 10px 25px -5px rgba(2, 132, 199, 0.4);
        }
        .text-gradient {
            background: linear-gradient(to right, #0284c7, #6366f1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        @keyframes slideRight {
            from { transform: translateX(-30px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .animate-slide-right {
            animation: slideRight 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .animate-slide-up {
            animation: slideUp 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        * { -ms-overflow-style: none; scrollbar-width: none; }
        *::-webkit-scrollbar { display: none; }
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-900 antialiased font-sans flex min-h-screen">

    <!-- Atmospheric Background for Admin -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute -top-[10%] -right-[10%] w-[600px] h-[600px] bg-primary-100/30 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-[10%] left-[20%] w-[500px] h-[500px] bg-indigo-50/20 rounded-full blur-[80px]"></div>
    </div>

    <!-- Sidebar -->
    <aside class="w-80 glass-sidebar text-white shrink-0 flex flex-col fixed inset-y-0 left-0 z-50 shadow-2xl">
        <div class="p-10">
            <div class="flex items-center gap-4 group">
                <div class="w-12 h-12 rounded-xl bg-slate-950 flex items-center justify-center shadow-2xl shadow-primary-500/10 group-hover:scale-110 transition-transform duration-500">
                    <span class="material-symbols-outlined text-white text-2xl" style="font-variation-settings: 'FILL' 1;">shield_person</span>
                </div>
                <div class="flex flex-col">
                    <span class="font-black text-2xl tracking-tighter leading-none">Nomado</span>
                    <span class="text-[10px] font-black uppercase tracking-[0.3em] text-primary-400 mt-1">Orchestrator</span>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-6 space-y-2 overflow-y-auto pt-4">
            <p class="px-5 text-[10px] font-black uppercase tracking-[0.25em] text-slate-500 mb-6 flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-primary-500"></span>
                Strategic Control
            </p>
            
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-5 py-4 rounded-xl text-sm font-black uppercase tracking-widest transition-all hover:bg-white/5 group {{ Route::is('admin.dashboard') ? 'sidebar-link-active' : 'text-slate-400' }}">
                <span class="material-symbols-outlined text-xl {{ Route::is('admin.dashboard') ? '' : 'group-hover:text-primary-400' }}">dashboard</span>
                Dashboard
            </a>

            <a href="{{ route('admin.bookings.index') }}" class="flex items-center gap-4 px-5 py-4 rounded-xl text-sm font-black uppercase tracking-widest transition-all hover:bg-white/5 group {{ Route::is('admin.bookings.*') ? 'sidebar-link-active' : 'text-slate-400' }}">
                <span class="material-symbols-outlined text-xl {{ Route::is('admin.bookings.*') ? '' : 'group-hover:text-primary-400' }}">confirmation_number</span>
                Reservations
            </a>

            <div class="pt-10 pb-4">
                <p class="px-5 text-[10px] font-black uppercase tracking-[0.25em] text-slate-500 mb-6 flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                    World Builder
                </p>
            </div>

            <a href="{{ route('admin.countries.index') }}" class="flex items-center gap-4 px-5 py-4 rounded-xl text-sm font-black uppercase tracking-widest transition-all hover:bg-white/5 group {{ Route::is('admin.countries.*') ? 'sidebar-link-active' : 'text-slate-400' }}">
                <span class="material-symbols-outlined text-xl {{ Route::is('admin.countries.*') ? '' : 'group-hover:text-primary-400' }}">public</span>
                Territories
            </a>

            <a href="{{ route('admin.cities.index') }}" class="flex items-center gap-4 px-5 py-4 rounded-xl text-sm font-black uppercase tracking-widest transition-all hover:bg-white/5 group {{ Route::is('admin.cities.*') ? 'sidebar-link-active' : 'text-slate-400' }}">
                <span class="material-symbols-outlined text-xl {{ Route::is('admin.cities.*') ? '' : 'group-hover:text-primary-400' }}">location_city</span>
                Destinations
            </a>

            <div class="pt-10 pb-4">
                <p class="px-5 text-[10px] font-black uppercase tracking-[0.25em] text-slate-500 mb-6 flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    Experience Ops
                </p>
            </div>

            <a href="{{ route('admin.hotels.index') }}" class="flex items-center gap-4 px-5 py-4 rounded-xl text-sm font-black uppercase tracking-widest transition-all hover:bg-white/5 group {{ Route::is('admin.hotels.*') ? 'sidebar-link-active' : 'text-slate-400' }}">
                <span class="material-symbols-outlined text-xl {{ Route::is('admin.hotels.*') ? '' : 'group-hover:text-primary-400' }}">hotel</span>
                Sanctuaries
            </a>

            <a href="{{ route('admin.places.index') }}" class="flex items-center gap-4 px-5 py-4 rounded-xl text-sm font-black uppercase tracking-widest transition-all hover:bg-white/5 group {{ Route::is('admin.places.*') ? 'sidebar-link-active' : 'text-slate-400' }}">
                <span class="material-symbols-outlined text-xl {{ Route::is('admin.places.*') ? '' : 'group-hover:text-primary-400' }}">explore</span>
                Landmarks
            </a>

            <div class="pt-10 pb-4">
                <p class="px-5 text-[10px] font-black uppercase tracking-[0.25em] text-slate-500 mb-6 flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                    Personnel
                </p>
            </div>

            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-4 px-5 py-4 rounded-xl text-sm font-black uppercase tracking-widest transition-all hover:bg-white/5 group {{ Route::is('admin.users.*') ? 'sidebar-link-active' : 'text-slate-400' }}">
                <span class="material-symbols-outlined text-xl {{ Route::is('admin.users.*') ? '' : 'group-hover:text-primary-400' }}">group</span>
                Explorers
            </a>
        </nav>

        <div class="p-8 mt-auto border-t border-white/5">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-between px-6 py-4 rounded-xl text-sm font-black uppercase tracking-widest text-red-400 hover:bg-red-500/10 transition-all border border-red-500/20">
                    Logout
                    <span class="material-symbols-outlined text-xl">logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="ml-80 flex-1 p-12 relative z-10">
        <header class="flex items-center justify-between mb-16 animate-slide-right">
            <div>
                <h2 class="text-xs font-black uppercase tracking-[0.3em] text-primary-600 mb-2 italic">
                    @yield('category', 'Administration')
                </h2>
                <h1 class="text-5xl font-black text-slate-950 tracking-tighter">
                    @yield('title', 'Control Center')
                </h1>
            </div>
            
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-6 p-2 bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-lg transition-all group pr-8">
                <div class="w-14 h-14 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-primary-50 group-hover:text-primary-600 transition-all overflow-hidden border border-slate-100">
                    <span class="material-symbols-outlined text-3xl">account_circle</span>
                </div>
                <div class="text-right">
                    <p class="text-[11px] font-black uppercase tracking-widest text-primary-600 leading-none mb-1.5">{{ auth()->user()->role ?? 'ADMIN' }}</p>
                    <p class="text-sm font-black text-slate-950 group-hover:text-primary-600 transition-colors uppercase tracking-tight">{{ auth()->user()->name }}</p>
                </div>
            </a>
        </header>

        <section class="animate-slide-up">
            @yield('content')
        </section>
    </main>

</body>
</html>
