<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Nomado</title>
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
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .gradient-text {
            background: linear-gradient(to right, #0284c7, #6366f1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .bg-gradient-primary {
            background: linear-gradient(135deg, #0284c7, #6366f1);
        }
        .ambient-glow {
            box-shadow: 0 0 40px rgba(2, 132, 199, 0.1);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes slowZoom {
            from { transform: scale(1); }
            to { transform: scale(1.1); }
        }
        .animate-fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }
        .animate-slow-zoom {
            animation: slowZoom 20s linear infinite alternate;
        }
        .text-glow {
            text-shadow: 0 0 15px rgba(255, 255, 255, 0.4);
        }
        .glass-panel-premium {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        .input-premium {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .input-premium:focus {
            background: #ffffff;
            border-color: #0ea5e9;
            box-shadow: 0 0 0 5px rgba(14, 165, 233, 0.1);
            transform: translateY(-1px);
        }
    </style>
</head>
<body class="bg-white text-slate-900 font-sans min-h-screen flex selection:bg-primary-100 selection:text-primary-900">
    <div class="flex w-full min-h-screen relative overflow-hidden">
        <!-- Left Half: Atmospheric Identity -->
        <div class="hidden lg:flex w-1/2 relative flex-col justify-between p-16 overflow-hidden bg-slate-900">
            <!-- Background Image -->
            <div class="absolute inset-0 z-0 overflow-hidden">
                <img src="/images/auth-bg.png" alt="Travel Background" class="w-full h-full object-cover opacity-60 animate-slow-zoom">
                <div class="absolute inset-0 bg-gradient-to-br from-slate-900/60 via-transparent to-slate-900/80"></div>
            </div>
            
            <div class="relative z-10">
                <a class="inline-flex items-center gap-2" href="/">
                    <span class="material-symbols-outlined text-white text-3xl" style="font-variation-settings: 'FILL' 1;">explore</span>
                    <span class="font-black text-2xl tracking-tighter text-white">Nomado</span>
                </a>
            </div>

            <div class="relative z-10 max-w-lg mb-24 animate-fade-in">
                <div class="glass-panel-premium p-12 rounded-[3rem]">
                    <h1 class="font-black text-6xl leading-[1.1] tracking-tighter mb-6 text-white text-glow">
                        Your next great<br/>
                        <span class="text-primary-400">adventure awaits.</span>
                    </h1>
                    <p class="text-xl text-slate-100 font-medium leading-relaxed opacity-90">
                        AI-powered itineraries, seamless booking, and bespoke recommendations tailored to your unique travel style.
                    </p>
                </div>
            </div>

            <!-- Floating Glass Cards (Subtle hints of destinations) -->
            <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/4 w-[120%] h-[80%] pointer-events-none flex flex-col gap-6 opacity-40">
                <div class="flex gap-6 translate-x-12">
                    <div class="glass-panel rounded-3xl w-64 h-80 overflow-hidden relative shadow-2xl scale-90 blur-[1px]">
                        <img src="https://images.unsplash.com/photo-1502602898657-3e91760cbb34?q=80&w=1000&auto=format&fit=crop" alt="Paris" class="absolute inset-0 w-full h-full object-cover">
                    </div>
                    <div class="glass-panel rounded-3xl w-72 h-48 overflow-hidden relative mt-16 shadow-2xl scale-90 blur-[2px]">
                        <img src="https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?q=80&w=1000&auto=format&fit=crop" alt="Tokyo" class="absolute inset-0 w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Half: Transactional Focus -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-24 bg-white z-20">
            <div class="w-full max-w-md">
                <!-- Mobile Header -->
                <div class="lg:hidden mb-12 text-center bg-slate-50 p-8 rounded-[2rem] border border-slate-100 shadow-sm">
                    <a class="inline-flex items-center gap-2 justify-center mb-6" href="/">
                        <span class="material-symbols-outlined text-primary-600 text-3xl" style="font-variation-settings: 'FILL' 1;">explore</span>
                        <span class="font-black text-3xl tracking-tighter text-slate-900">Nomado</span>
                    </a>
                    <h2 class="font-bold text-3xl text-slate-900">Welcome back.</h2>
                </div>

                <div class="hidden lg:block mb-12">
                    <h2 class="font-black text-4xl text-slate-900 tracking-tight">Log In</h2>
                    <p class="text-slate-500 mt-2 text-lg">Enter your details to access your trips.</p>
                </div>

                <!-- Session Status / Errors -->
                @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-100 text-red-600 px-4 py-3 rounded-xl text-sm font-medium">
                    Invalid credentials. Please try again.
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Input -->
                    <div class="space-y-2">
                        <label class="font-semibold text-sm text-slate-700 block" for="email">Email Address</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 flex items-center">
                                <span class="material-symbols-outlined text-[20px]">mail</span>
                            </span>
                            <input class="w-full input-premium rounded-xl py-4 pl-12 pr-4 text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all text-base outline-none @error('email') border-red-300 @enderror" 
                                   id="email" type="email" name="email" value="{{ old('email') }}" placeholder="hello@nomado.ai" required autofocus />
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <label class="font-semibold text-sm text-slate-700 block" for="password">Password</label>
                            @if (Route::has('password.request'))
                                <a class="font-semibold text-sm text-primary-600 hover:text-primary-700 transition-colors" href="{{ route('password.request') }}">Forgot?</a>
                            @endif
                        </div>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 flex items-center">
                                <span class="material-symbols-outlined text-[20px]">lock</span>
                            </span>
                            <input class="w-full input-premium rounded-xl py-4 pl-12 pr-4 text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all text-base outline-none @error('password') border-red-300 @enderror" 
                                   id="password" type="password" name="password" placeholder="••••••••" required autocomplete="current-password" />
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input class="h-5 w-5 rounded bg-slate-50 border-slate-200 text-primary-600 focus:ring-primary-500/30" 
                               id="remember_me" name="remember" type="checkbox" />
                        <label class="ml-3 block text-sm text-slate-500" for="remember_me">
                            Remember me
                        </label>
                    </div>

                    <!-- Actions -->
                    <div class="pt-4">
                        <button class="w-full flex justify-center items-center py-4 px-4 rounded-xl text-white font-bold text-lg bg-gradient-primary hover:opacity-90 transition-opacity ambient-glow shadow-lg shadow-primary-500/20" type="submit">
                            Log In
                            <span class="material-symbols-outlined ml-2 text-[20px]">arrow_forward</span>
                        </button>
                    </div>

                    <!-- Alternate Auth -->
                    <div class="mt-8 pt-8 border-t border-slate-100 text-center">
                        <p class="text-slate-500 text-sm">
                            Don't have an account? 
                            <a class="font-bold text-primary-600 hover:text-primary-700 transition-colors ml-1" href="{{ route('register') }}">Create Account</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
