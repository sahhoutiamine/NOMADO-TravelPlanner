<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nomado - AI Travel Planner</title>
    <meta name="description" content="Nomado is an AI-powered travel planner that generates complete trips with destinations, hotels, and budget breakdowns tailored to your preferences.">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <!-- Scripts/Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        'primary': {
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
                        },
                        'navy': {
                            600: '#1e293b',
                            700: '#1e1e2e',
                            900: '#0f172a',
                        },
                        'coral': {
                            400: '#fb7185',
                            500: '#f43f5e',
                        },
                    },
                    animation: {
                        'float': 'float 3s ease-in-out infinite',
                        'drift-slow': 'drift 8s ease-in-out infinite',
                        'drift-fast': 'drift 6s ease-in-out infinite',
                        'glow': 'glow 2s ease-in-out infinite',
                        'ping-slow': 'ping 2s cubic-bezier(0, 0, 0.2, 1) infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-12px)' },
                        },
                        drift: {
                            '0%, 100%': { transform: 'translateX(0) translateY(0)' },
                            '25%': { transform: 'translateX(10px) translateY(-10px)' },
                            '50%': { transform: 'translateX(0) translateY(-20px)' },
                            '75%': { transform: 'translateX(-10px) translateY(-10px)' },
                        },
                        glow: {
                            '0%, 100%': { boxShadow: '0 0 20px rgba(244, 63, 94, 0.5)' },
                            '50%': { boxShadow: '0 0 30px rgba(244, 63, 94, 0.8)' },
                        },
                    },
                }
            }
        }
    </script>
    <style>
        * {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        html {
            scroll-behavior: smooth;
        }

        /* Page fade-in animation */
        @keyframes pageFadeIn {
            from {
                opacity: 0;
                transform: translateY(16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .page-fade-in {
            animation: pageFadeIn 0.5s ease-out forwards;
        }

        /* Selection color */
        ::selection {
            background: #0284c7;
            color: #ffffff;
        }

        /* Hide scrollbar */
        * {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        *::-webkit-scrollbar {
            display: none;
        }

        /* Links — reset default */
        a {
            color: inherit;
            text-decoration: none;
        }

        /* Custom classes for animations */
        .glass {
            backdrop-filter: blur(12px);
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .gradient-text {
            background: linear-gradient(to right, #f43f5e, #f59e0b);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(to right, #f43f5e, #f59e0b);
            color: white;
            font-weight: 600;
            border-radius: 0.875rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(244, 63, 94, 0.3);
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            font-weight: 600;
            border-radius: 0.875rem;
            cursor: pointer;
            backdrop-filter: blur(12px);
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .animate-glow {
            animation: glow 2s ease-in-out infinite;
        }

        @media (prefers-reduced-motion: reduce) {
            .animate-float,
            .animate-drift-slow,
            .animate-drift-fast,
            .animate-glow {
                animation: none;
            }
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased min-h-screen flex flex-col font-sans bg-gray-50 text-gray-900">
    <!-- Navbar -->
    <nav id="navbar" class="fixed w-full z-50 bg-white border-b border-gray-200 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex-shrink-0 flex items-center gap-2.5 group transition-transform hover:scale-[1.02] duration-200">
                    <div class="w-9 h-9 rounded-lg bg-primary-600 flex items-center justify-center">
                        <span class="material-symbols-outlined text-white text-xl" style="font-variation-settings: 'FILL' 1;">explore</span>
                    </div>
                    <span class="font-black text-2xl text-gray-900 tracking-tighter">Nomado</span>
                </a>

                <!-- Links -->
                <div class="hidden md:flex space-x-1 items-center">
                    <a href="{{ route('trip.index') }}" class="px-4 py-2 text-sm font-semibold rounded-lg transition-colors {{ Route::is('trip.*') ? 'text-primary-600 bg-primary-50' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">Planner</a>
                    <a href="{{ route('bookings.index') }}" class="px-4 py-2 text-sm font-semibold rounded-lg transition-colors {{ Route::is('bookings.*') ? 'text-primary-600 bg-primary-50' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">My Trips</a>
                    @auth
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 text-sm font-semibold rounded-lg transition-colors {{ Route::is('admin.*') ? 'text-primary-600 bg-primary-50' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">Admin</a>
                        @endif
                    @endauth
                </div>

                <!-- Auth Links -->
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-gray-50 transition-colors group">
                            <div class="text-right hidden sm:block">
                                <p class="text-xs font-medium text-gray-400 leading-none">Traveler</p>
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-primary-600 transition-colors leading-none mt-0.5">{{ auth()->user()->name }}</p>
                            </div>
                            <div class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center border border-gray-200 group-hover:border-primary-200 group-hover:bg-primary-50 transition-colors">
                                <svg class="w-5 h-5 text-gray-500 group-hover:text-primary-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-xs font-semibold text-gray-500 hover:text-gray-900 px-3 py-2 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 hover:text-gray-900 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors">Sign In</a>
                        <a href="{{ route('register') }}" class="text-sm font-semibold text-white bg-gray-900 hover:bg-primary-600 px-4 py-2 rounded-lg transition-colors">Join Nomado</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow pt-16 page-fade-in">
        @yield('content')
        {{ $slot ?? '' }}
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-8">
                <!-- Brand -->
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-primary-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-white text-base" style="font-variation-settings: 'FILL' 1;">explore</span>
                        </div>
                        <span class="font-black text-xl text-gray-900 tracking-tighter">Nomado</span>
                    </div>
                    <p class="text-sm text-gray-500">Your perfect journey, generated in seconds.</p>
                </div>

                <!-- Links -->
                <div>
                    <h4 class="font-semibold mb-4 text-gray-900">Product</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('trip.index') }}" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">Planner</a></li>
                        <li><a href="{{ route('bookings.index') }}" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">My Trips</a></li>
                    </ul>
                </div>

                <!-- Company -->
                <div>
                    <h4 class="font-semibold mb-4 text-gray-900">Company</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">About</a></li>
                        <li><a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">Blog</a></li>
                        <li><a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">Contact</a></li>
                    </ul>
                </div>

                <!-- Legal -->
                <div>
                    <h4 class="font-semibold mb-4 text-gray-900">Legal</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">Privacy</a></li>
                        <li><a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">Terms</a></li>
                        <li><a href="#" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">Cookies</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-400 text-sm">&copy; 2026 Nomado Travel Planner. All rights reserved.</p>
                <div class="flex gap-6">
                    <a href="#" class="text-gray-400 hover:text-primary-600 transition-colors text-sm">Twitter</a>
                    <a href="#" class="text-gray-400 hover:text-primary-600 transition-colors text-sm">Instagram</a>
                    <a href="#" class="text-gray-400 hover:text-primary-600 transition-colors text-sm">LinkedIn</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // IntersectionObserver for scroll-triggered animations
        const observerOptions = {
            threshold: 0.15,
            rootMargin: '0px 0px -50px 0px'
        };

        const scrollObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const element = entry.target;
                    // Add animation classes that trigger based on data attributes
                    if (element.classList.contains('animate-on-scroll')) {
                        element.classList.add('scroll-visible');
                    }
                    scrollObserver.unobserve(element);
                }
            });
        }, observerOptions);

        // Observe all elements with animate-on-scroll class
        document.querySelectorAll('.animate-on-scroll').forEach(el => {
            scrollObserver.observe(el);
        });
    </script>
</body>
</html>
