<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nomado Admin - Control Center</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
                        admin: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                        },
                        primary: {
                            500: '#0ea5e9',
                            600: '#0284c7',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .sidebar-link-active {
            background-color: #0ea5e9;
            color: white;
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }
        .fade-in { animation: fadeIn 0.3s ease-out; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-[#f1f5f9] text-slate-800 antialiased font-sans flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-72 bg-admin-900 text-white shrink-0 flex flex-col fixed inset-y-0 left-0 z-50">
        <div class="p-8">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-primary-500/30">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </div>
                <span class="font-black text-2xl tracking-tighter">Nomado <span class="text-primary-400">Admin</span></span>
            </div>
        </div>

        <nav class="flex-1 px-4 space-y-1 overflow-y-auto">
            <p class="px-4 text-[10px] font-black uppercase tracking-widest text-admin-500 mb-4">Core Overview</p>
            
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold transition-all hover:bg-admin-800 {{ Route::is('admin.dashboard') ? 'sidebar-link-active' : 'text-admin-400' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                Dashboard
            </a>

            <a href="{{ route('admin.bookings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold transition-all hover:bg-admin-800 {{ Route::is('admin.bookings.*') ? 'sidebar-link-active' : 'text-admin-400' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                Bookings
            </a>

            <div class="pt-8 pb-4">
                <p class="px-4 text-[10px] font-black uppercase tracking-widest text-admin-500 mb-4">Geographical Data</p>
            </div>

            <a href="{{ route('admin.countries.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold transition-all hover:bg-admin-800 {{ Route::is('admin.countries.*') ? 'sidebar-link-active' : 'text-admin-400' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Countries
            </a>

            <a href="{{ route('admin.cities.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold transition-all hover:bg-admin-800 {{ Route::is('admin.cities.*') ? 'sidebar-link-active' : 'text-admin-400' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                Cities
            </a>

            <div class="pt-8 pb-4">
                <p class="px-4 text-[10px] font-black uppercase tracking-widest text-admin-500 mb-4">Content Management</p>
            </div>

            <a href="{{ route('admin.hotels.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold transition-all hover:bg-admin-800 {{ Route::is('admin.hotels.*') ? 'sidebar-link-active' : 'text-admin-400' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                Hotels
            </a>

            <a href="{{ route('admin.places.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold transition-all hover:bg-admin-800 {{ Route::is('admin.places.*') ? 'sidebar-link-active' : 'text-admin-400' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Places
            </a>

            <div class="pt-8 pb-4">
                <p class="px-4 text-[10px] font-black uppercase tracking-widest text-admin-500 mb-4">User Administration</p>
            </div>

            <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold transition-all hover:bg-admin-800 {{ Route::is('admin.users.*') ? 'sidebar-link-active' : 'text-admin-400' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Users
            </a>
        </nav>

        <div class="p-4 border-t border-admin-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold text-red-400 hover:bg-red-500/10 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="ml-72 flex-1 p-8">
        <header class="flex items-center justify-between mb-10">
            <div>
                <h2 class="text-xs font-black uppercase tracking-[0.2em] text-admin-400 mb-1">
                    @yield('category', 'Administration')
                </h2>
                <h1 class="text-4xl font-black text-admin-900 tracking-tighter">
                    @yield('title', 'Control Center')
                </h1>
            </div>
            
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-6 hover:opacity-80 transition-all group">
                <div class="text-right">
                    <p class="text-xs font-black text-admin-900 leading-none mb-1 group-hover:text-primary-600 transition-colors">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] font-bold text-primary-600 uppercase tracking-widest">{{ auth()->user()->role }}</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-white shadow-sm border border-slate-200 flex items-center justify-center text-admin-400 group-hover:border-primary-200 group-hover:bg-primary-50 transition-all">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
            </a>
        </header>

        <section class="fade-in">
            @yield('content')
        </section>
    </main>

</body>
</html>
