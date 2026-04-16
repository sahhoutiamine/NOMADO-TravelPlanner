<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nomado - AI Travel Planner</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Clash+Display:wght@700;900&family=Plus+Jakarta+Sans:wght@400;500;700&family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Scripts/Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'display': ['Clash Display', 'sans-serif'],
                        'sans': ['Inter', 'sans-serif'],
                        'jakarta': ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        'navy': {
                            50: '#E8EAED',
                            100: '#D1D5DB',
                            200: '#A3ABB7',
                            300: '#6F7A8D',
                            400: '#3B4563',
                            500: '#07153A',
                            600: '#0A0F1E',
                            700: '#050A11',
                            800: '#02050A',
                            900: '#000000',
                        },
                        'coral': {
                            400: '#FF7A4D',
                            500: '#FF6B35',
                            600: '#E55A24',
                        },
                        'amber': {
                            400: '#FFC857',
                            500: '#F59E0B',
                            600: '#D97706',
                        },
                        'cream': '#FFFAF0',
                    },
                    boxShadow: {
                        'glow-coral': '0 0 30px rgba(255, 107, 53, 0.3)',
                        'glow-navy': '0 0 30px rgba(10, 15, 30, 0.3)',
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'shimmer': 'shimmer 2s ease-in-out infinite',
                        'glow': 'glow 2s ease-in-out infinite',
                        'drift-slow': 'drift-slow 20s ease-in-out infinite',
                        'drift-fast': 'drift-fast 15s ease-in-out infinite',
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

        body {
            background: linear-gradient(135deg, #0A0F1E 0%, #050A11 100%);
            color: #E8EAED;
        }

        /* Glassmorphism */
        .glass {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .glass-dark {
            background: rgba(10, 15, 30, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-40px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(40px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes shimmer {
            0%, 100% {
                background-position: 200% center;
            }
            50% {
                background-position: -200% center;
            }
        }

        @keyframes glow {
            0%, 100% {
                box-shadow: 0 0 20px rgba(255, 107, 53, 0.5);
            }
            50% {
                box-shadow: 0 0 30px rgba(255, 107, 53, 0.8);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes drift-slow {
            0% {
                transform: translateX(0px) translateY(0px);
            }
            33% {
                transform: translateX(30px) translateY(-30px);
            }
            66% {
                transform: translateX(-20px) translateY(20px);
            }
            100% {
                transform: translateX(0px) translateY(0px);
            }
        }

        @keyframes drift-fast {
            0% {
                transform: translateX(0px) translateY(0px);
            }
            33% {
                transform: translateX(-40px) translateY(30px);
            }
            66% {
                transform: translateX(30px) translateY(-30px);
            }
            100% {
                transform: translateX(0px) translateY(0px);
            }
        }

        @keyframes typewriter {
            0% {
                width: 0;
            }
            100% {
                width: 100%;
            }
        }

        @keyframes checkmarkDraw {
            0% {
                stroke-dashoffset: 50;
            }
            100% {
                stroke-dashoffset: 0;
            }
        }

        .fade-in {
            animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .slide-in-up {
            animation: slideInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .slide-in-left {
            animation: slideInLeft 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .slide-in-right {
            animation: slideInRight 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        /* Selection color */
        ::selection {
            background: #FF6B35;
            color: #0A0F1E;
        }

        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        ::-webkit-scrollbar-thumb {
            background: #FF6B35;
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #F59E0B;
        }

        /* Button base styles */
        .btn-primary {
            background: linear-gradient(135deg, #FF6B35 0%, #F59E0B 100%);
            color: #0A0F1E;
            font-weight: 700;
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(255, 107, 53, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(255, 107, 53, 0.5);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: #E8EAED;
            border: 1px solid rgba(255, 255, 255, 0.2);
            font-weight: 600;
            border-radius: 12px;
            padding: 10px 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
        }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #FF6B35 0%, #F59E0B 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Input styles */
        input, textarea, select {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #E8EAED;
            border-radius: 8px;
            padding: 10px 16px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        input:focus, textarea:focus, select:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.12);
            border-color: #FF6B35;
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.2);
        }

        input::placeholder {
            color: rgba(232, 234, 237, 0.5);
        }

        /* Links */
        a {
            color: #FF6B35;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #F59E0B;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased min-h-screen flex flex-col font-sans">
    <!-- Navbar -->
    <nav id="navbar" class="fixed w-full z-50 transition-all duration-500 border-b border-transparent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-coral-500 to-amber-500 flex items-center justify-center shadow-lg shadow-coral-500/30">
                        <svg class="w-6 h-6 text-navy-900" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/></svg>
                    </div>
                    <span class="font-display font-black text-xl tracking-tight text-white">Nomado</span>
                </div>

                <!-- Links -->
                <div class="hidden md:flex space-x-1 items-center">
                    <a href="{{ route('trip.index') }}" class="px-4 py-2 text-sm font-jakarta font-semibold text-gray-300 hover:text-coral-400 transition-colors {{ Route::is('trip.*') ? 'text-coral-400' : '' }}">Generator</a>
                    <a href="{{ route('bookings.index') }}" class="px-4 py-2 text-sm font-jakarta font-semibold text-gray-300 hover:text-coral-400 transition-colors {{ Route::is('bookings.*') ? 'text-coral-400' : '' }}">My Trips</a>
                    @auth
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 text-sm font-jakarta font-semibold text-gray-300 hover:text-coral-400 transition-colors {{ Route::is('admin.*') ? 'text-coral-400' : '' }}">Admin</a>
                        @endif
                    @endauth
                </div>

                <!-- Auth Links -->
                <div class="flex items-center gap-4">
                    @auth
                        <div class="flex items-center gap-3">
                            <div class="text-right hidden sm:block">
                                <p class="text-xs font-jakarta font-semibold text-gray-400 leading-none">Traveler</p>
                                <p class="text-sm font-jakarta font-bold text-white group-hover:text-coral-400 transition-colors leading-none">{{ auth()->user()->name }}</p>
                            </div>
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-coral-500/20 to-amber-500/20 flex items-center justify-center border border-coral-500/30">
                                <svg class="w-6 h-6 text-coral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="btn-secondary text-xs">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn-secondary text-sm">Sign In</a>
                        <a href="{{ route('register') }}" class="btn-primary text-sm">Join Nomado</a>
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
    <footer class="border-t border-white/10 mt-auto">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-8">
                <!-- Brand -->
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-coral-500 to-amber-500 flex items-center justify-center">
                            <svg class="w-4 h-4 text-navy-900" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/></svg>
                        </div>
                        <span class="font-display font-black text-lg">Nomado</span>
                    </div>
                    <p class="text-sm text-gray-400">Your perfect journey, generated in seconds.</p>
                </div>

                <!-- Links -->
                <div>
                    <h4 class="font-jakarta font-bold mb-4 text-white">Product</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('trip.index') }}" class="text-sm text-gray-400 hover:text-coral-400">Generator</a></li>
                        <li><a href="{{ route('bookings.index') }}" class="text-sm text-gray-400 hover:text-coral-400">My Trips</a></li>
                    </ul>
                </div>

                <!-- Company -->
                <div>
                    <h4 class="font-jakarta font-bold mb-4 text-white">Company</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-sm text-gray-400 hover:text-coral-400">About</a></li>
                        <li><a href="#" class="text-sm text-gray-400 hover:text-coral-400">Blog</a></li>
                        <li><a href="#" class="text-sm text-gray-400 hover:text-coral-400">Contact</a></li>
                    </ul>
                </div>

                <!-- Legal -->
                <div>
                    <h4 class="font-jakarta font-bold mb-4 text-white">Legal</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-sm text-gray-400 hover:text-coral-400">Privacy</a></li>
                        <li><a href="#" class="text-sm text-gray-400 hover:text-coral-400">Terms</a></li>
                        <li><a href="#" class="text-sm text-gray-400 hover:text-coral-400">Cookies</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-400 text-sm">© 2026 Nomado Travel Planner. All rights reserved.</p>
                <div class="flex gap-6">
                    <a href="#" class="text-gray-400 hover:text-coral-400 transition-colors">Twitter</a>
                    <a href="#" class="text-gray-400 hover:text-coral-400 transition-colors">Instagram</a>
                    <a href="#" class="text-gray-400 hover:text-coral-400 transition-colors">LinkedIn</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Navbar scroll effect -->
    <script>
        const navbar = document.getElementById('navbar');
        let lastScrollY = 0;

        window.addEventListener('scroll', () => {
            lastScrollY = window.scrollY;

            if (lastScrollY > 50) {
                navbar.classList.add('glass');
                navbar.classList.remove('border-transparent');
                navbar.style.borderBottomColor = 'rgba(255, 255, 255, 0.1)';
            } else {
                navbar.classList.remove('glass');
                navbar.classList.add('border-transparent');
            }
        });

        // Intersection Observer for scroll-triggered animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('opacity-100');
                    entry.target.classList.remove('opacity-0');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe all elements with animate-on-scroll class
        document.querySelectorAll('.animate-on-scroll').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>
</html>
