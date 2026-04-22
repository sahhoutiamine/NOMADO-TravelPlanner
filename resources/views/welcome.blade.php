<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nomado - AI Powered Travel Planner</title>
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
                            600: '#0284c7', // Nomado Blue
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(2, 132, 199, 0.1);
        }
        .text-gradient {
            background: linear-gradient(to right, #0284c7, #6366f1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .bg-gradient-primary {
            background: linear-gradient(135deg, #0284c7, #6366f1);
        }
        .perspective-1000 {
            perspective: 1000px;
        }
        @keyframes pageFadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: pageFadeIn 0.8s ease-out forwards;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased selection:bg-primary-100 selection:text-primary-900 min-h-screen flex flex-col relative overflow-x-hidden">
    <!-- Ambient Background Lighting -->
    <div class="fixed inset-0 pointer-events-none z-[-1] overflow-hidden">
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-primary-200/30 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[60%] h-[60%] bg-indigo-100/40 rounded-full blur-[150px]"></div>
    </div>

    <!-- Top Navigation Bar -->
    <nav class="fixed top-0 w-full z-50 bg-white/70 backdrop-blur-xl border-b border-slate-200/50">
        <div class="flex justify-between items-center px-8 h-20 max-w-7xl mx-auto">
            <!-- Brand -->
            <a class="text-2xl font-black tracking-tighter text-slate-900 flex items-center gap-2 transition-transform scale-95 duration-200 ease-out hover:scale-100" href="/">
                <span class="material-symbols-outlined text-primary-600" style="font-variation-settings: 'FILL' 1;">explore</span>
                Nomado
            </a>

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-slate-600 hover:text-primary-600 transition-colors">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="hidden md:inline-block text-sm font-semibold text-slate-600 hover:text-primary-600 transition-colors">Sign In</a>
                    <a href="{{ route('register') }}" class="bg-slate-950 text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:shadow-[0_4px_20px_rgba(0,0,0,0.1)] transition-all duration-200 scale-95 hover:scale-100">Join Nomado</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow pt-28 pb-20">
        <!-- Hero Section -->
        <section class="max-w-7xl mx-auto px-6 lg:px-8 py-10 lg:py-20 grid lg:grid-cols-2 gap-16 items-center relative z-10">
            <!-- Copy -->
            <div class="flex flex-col gap-8 max-w-2xl animate-fade-in">
                <div class="inline-flex items-center gap-2 bg-primary-50 px-4 py-2 rounded-full border border-primary-100 w-fit">
                    <span class="material-symbols-outlined text-primary-600 text-sm" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
                    <span class="text-xs font-bold text-primary-700 uppercase tracking-widest">Powerful Travel</span>
                </div>
                <h1 class="text-5xl lg:text-7xl font-black tracking-tighter leading-[1.1] text-slate-900">
                    Your perfect trip, <br/>
                    <span class="text-gradient">generated in seconds.</span>
                </h1>
                <p class="text-lg text-slate-600 max-w-xl leading-relaxed">
                    Stop spending hours researching. Our advanced technology crafts bespoke itineraries tailored to your exact vibe, budget, and dreams. Discover the world, effortlessly.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 mt-4">
                    <a href="{{ route('register') }}" class="bg-slate-950 text-white px-8 py-4 rounded-xl font-semibold text-lg flex items-center justify-center gap-2 hover:shadow-[0_8px_30px_rgba(0,0,0,0.1)] transition-all duration-200 group">
                        <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">flight_takeoff</span>
                        Start Planning
                    </a>
                </div>
            </div>

            <!-- Staggered Cards -->
            <div class="relative h-[550px] hidden lg:block perspective-1000">
                <!-- Card 1 -->
                <div class="absolute top-0 right-0 w-72 glass-panel rounded-2xl p-4 shadow-xl transform rotate-2 hover:rotate-0 hover:z-30 hover:scale-105 transition-all duration-500 cursor-pointer">
                    <img src="https://images.unsplash.com/photo-1502602898657-3e91760cbb34?q=80&w=1000&auto=format&fit=crop" alt="Paris" class="w-full h-48 object-cover rounded-xl mb-4">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-xl font-bold text-slate-900">Paris, France</h3>
                        <div class="bg-primary-50 px-2 py-1 rounded text-xs font-bold text-primary-700">3 Days</div>
                    </div>
                    <p class="text-sm text-slate-500">Romantic escape with private Seine cruise.</p>
                </div>
                <!-- Card 2 -->
                <div class="absolute top-32 left-0 w-72 glass-panel rounded-2xl p-4 shadow-xl transform -rotate-3 hover:rotate-0 hover:z-30 hover:scale-105 transition-all duration-500 cursor-pointer z-10">
                    <img src="https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?q=80&w=1000&auto=format&fit=crop" alt="Kyoto" class="w-full h-48 object-cover rounded-xl mb-4">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-xl font-bold text-slate-900">Kyoto, Japan</h3>
                        <div class="bg-primary-50 px-2 py-1 rounded text-xs font-bold text-primary-700">5 Days</div>
                    </div>
                    <p class="text-sm text-slate-500">Cultural deep dive through ancient temples.</p>
                </div>
                <!-- Card 3 -->
                <div class="absolute bottom-0 right-16 w-80 glass-panel rounded-2xl p-4 shadow-2xl transform rotate-1 hover:rotate-0 hover:z-30 hover:scale-105 transition-all duration-500 cursor-pointer z-20">
                    <img src="https://images.unsplash.com/photo-1533105079780-92b9be482077?q=80&w=1000&auto=format&fit=crop" alt="Santorini" class="w-full h-56 object-cover rounded-xl mb-4">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-xl font-bold text-slate-900">Santorini, Greece</h3>
                        <div class="bg-primary-50 px-2 py-1 rounded text-xs font-bold text-primary-700">7 Days</div>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-slate-500 font-medium">
                        <span class="material-symbols-outlined text-sm text-primary-600">verified</span>
                        Recommended Match
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Bar -->
        <section class="max-w-6xl mx-auto px-6 mb-32 relative z-20">
            <div class="glass-panel rounded-[2rem] py-10 px-12 flex flex-col md:flex-row justify-between items-center gap-8 shadow-xl border border-white/50">
                <div class="text-center">
                    <div class="text-4xl font-black text-slate-900 mb-1 text-gradient">250+</div>
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Destinations</div>
                </div>
                <div class="hidden md:block w-px h-12 bg-slate-200"></div>
                <div class="text-center">
                    <div class="text-4xl font-black text-slate-900 mb-1 text-gradient">1.2K</div>
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Curated Hotels</div>
                </div>
                <div class="hidden md:block w-px h-12 bg-slate-200"></div>
                <div class="text-center">
                    <div class="text-4xl font-black text-slate-900 mb-1 text-gradient">50K</div>
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Trips Generated</div>
                </div>
                <div class="hidden md:block w-px h-12 bg-slate-200"></div>
                <div class="text-center">
                    <div class="text-4xl font-black text-slate-900 mb-1 text-gradient">98%</div>
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Satisfaction</div>
                </div>
            </div>
        </section>

        <!-- How It Works Section -->
        <section class="max-w-7xl mx-auto px-6 lg:px-8 py-24 mb-20 bg-white rounded-[3rem] shadow-sm border border-slate-100">
            <div class="text-center mb-20 animate-fade-in">
                <h2 class="text-4xl md:text-5xl font-black text-slate-900 mb-4 tracking-tight">How it works</h2>
                <p class="text-slate-500 max-w-2xl mx-auto text-lg">From dream to reality in three simple steps.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-16 relative">
                <!-- Connector Line (Web) -->
                <div class="hidden md:block absolute top-12 left-[15%] right-[15%] h-[2px] bg-slate-100"></div>
                
                <!-- Step 1 -->
                <div class="flex flex-col items-center text-center relative z-10 group">
                    <div class="w-24 h-24 rounded-[2rem] bg-slate-50 flex items-center justify-center mb-8 border border-slate-100 group-hover:border-primary-300 group-hover:bg-primary-50 transition-all duration-300 transform group-hover:rotate-3 shadow-sm">
                        <span class="material-symbols-outlined text-4xl text-primary-600" style="font-variation-settings: 'FILL' 1;">psychology</span>
                    </div>
                    <div class="bg-primary-50 px-3 py-1 rounded-full text-xs font-bold text-primary-700 mb-4 uppercase tracking-widest">Step 01</div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-4">Tell us your vibe</h3>
                    <p class="text-slate-500 text-base px-4 leading-relaxed">Input your travel style, budget, and duration. Our technology listens to your dreams.</p>
                </div>
                <!-- Step 2 -->
                <div class="flex flex-col items-center text-center relative z-10 group">
                    <div class="w-24 h-24 rounded-[2rem] bg-slate-50 flex items-center justify-center mb-8 border border-slate-100 group-hover:border-indigo-300 group-hover:bg-indigo-50 transition-all duration-300 transform group-hover:-rotate-3 shadow-sm">
                        <span class="material-symbols-outlined text-4xl text-indigo-600" style="font-variation-settings: 'FILL' 1;">magic_button</span>
                    </div>
                    <div class="bg-indigo-50 px-3 py-1 rounded-full text-xs font-bold text-indigo-700 mb-4 uppercase tracking-widest">Step 02</div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-4">Technology Crafts Magic</h3>
                    <p class="text-slate-500 text-base px-4 leading-relaxed">Our engine builds a minute-by-minute itinerary tailored specifically to you.</p>
                </div>
                <!-- Step 3 -->
                <div class="flex flex-col items-center text-center relative z-10 group">
                    <div class="w-24 h-24 rounded-[2rem] bg-slate-50 flex items-center justify-center mb-8 border border-slate-100 group-hover:border-emerald-300 group-hover:bg-emerald-50 transition-all duration-300 transform group-hover:rotate-3 shadow-sm">
                        <span class="material-symbols-outlined text-4xl text-emerald-600" style="font-variation-settings: 'FILL' 1;">luggage</span>
                    </div>
                    <div class="bg-emerald-50 px-3 py-1 rounded-full text-xs font-bold text-emerald-700 mb-4 uppercase tracking-widest">Step 03</div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-4">Pack and Go</h3>
                    <p class="text-slate-500 text-base px-4 leading-relaxed">Review, book, and enjoy your trip. We handle the complexity, you handle the fun.</p>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="w-full py-16 px-8 border-t border-slate-200 bg-white">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-10">
            <div class="text-2xl font-black text-slate-900 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary-600">explore</span>
                Nomado
            </div>
            <div class="flex flex-wrap justify-center gap-8 text-sm font-semibold text-slate-500">
                <a href="#" class="hover:text-primary-600 transition-colors">Privacy</a>
                <a href="#" class="hover:text-primary-600 transition-colors">Terms</a>
                <a href="#" class="hover:text-primary-600 transition-colors">Cookies</a>
                <a href="#" class="hover:text-primary-600 transition-colors">Contact</a>
            </div>
            <div class="text-sm font-medium text-slate-400 tracking-tight">
                © 2026 Nomado Travel Planner. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>
