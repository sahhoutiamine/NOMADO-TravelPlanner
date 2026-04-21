<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Join Nomado - Create Account</title>
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
        .animate-fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }
    </style>
</head>
<body class="bg-white text-slate-900 font-sans min-h-screen flex selection:bg-primary-100 selection:text-primary-900">
    <div class="flex w-full min-h-screen relative overflow-hidden">
        <!-- Left Half: Atmospheric Identity -->
        <div class="hidden lg:flex w-1/2 relative flex-col justify-between p-16 overflow-hidden bg-slate-50 border-r border-slate-100">
            <!-- Decorative Gradients -->
            <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-primary-200/20 rounded-full blur-[100px] pointer-events-none"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-emerald-100/30 rounded-full blur-[100px] pointer-events-none"></div>
            
            <div class="relative z-10">
                <a class="inline-flex items-center gap-2" href="/">
                    <span class="material-symbols-outlined text-primary-600 text-3xl" style="font-variation-settings: 'FILL' 1;">explore</span>
                    <span class="font-black text-2xl tracking-tighter text-slate-900">Nomado</span>
                </a>
            </div>

            <div class="relative z-10 max-w-lg mb-24 animate-fade-in">
                <h1 class="font-black text-6xl leading-[1.1] tracking-tighter mb-6 text-slate-900">
                    Start your<br/>
                    <span class="gradient-text">journey today.</span>
                </h1>
                <p class="text-lg text-slate-500 font-medium leading-relaxed">
                    Join thousands of travelers who use Nomado to discover hidden gems and create unforgettable memories effortlessly.
                </p>
            </div>

            <!-- Floating Glass Cards -->
            <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/4 w-[120%] h-[80%] pointer-events-none flex flex-col gap-6 opacity-90">
                <div class="flex gap-6 translate-x-12">
                    <div class="glass-panel rounded-3xl w-64 h-80 overflow-hidden relative shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?q=80&w=1000&auto=format&fit=crop" alt="Bali" class="absolute inset-0 w-full h-full object-cover">
                        <div class="absolute bottom-0 left-0 p-6 w-full bg-gradient-to-t from-black/80 to-transparent">
                            <h3 class="font-bold text-xl text-white">Bali, ID</h3>
                            <p class="text-sm text-slate-200 mt-1">7 Days Adventure</p>
                        </div>
                    </div>
                    <div class="glass-panel rounded-3xl w-72 h-48 overflow-hidden relative mt-16 shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?q=80&w=1000&auto=format&fit=crop" alt="Tokyo" class="absolute inset-0 w-full h-full object-cover">
                        <div class="absolute bottom-0 left-0 p-6 w-full bg-gradient-to-t from-black/80 to-transparent">
                            <h3 class="font-bold text-xl text-white">Shibuya, JP</h3>
                            <p class="text-sm text-slate-200 mt-1">Cyberpunk Vibes</p>
                        </div>
                    </div>
                </div>
                <div class="flex gap-6 -translate-x-8">
                    <div class="glass-panel rounded-3xl w-80 h-56 overflow-hidden relative shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1533105079780-92b9be482077?q=80&w=1000&auto=format&fit=crop" alt="Santorini" class="absolute inset-0 w-full h-full object-cover">
                        <div class="absolute bottom-0 left-0 p-6 w-full bg-gradient-to-t from-black/80 to-transparent">
                            <h3 class="font-bold text-xl text-white">Santorini, GR</h3>
                            <p class="text-sm text-slate-200 mt-1">Romantic Getaway</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Half: Transactional Focus -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-24 bg-white z-20">
            <div class="w-full max-w-md">
                <!-- Mobile Header -->
                <div class="lg:hidden mb-12 text-center">
                    <a class="inline-flex items-center gap-2 justify-center mb-6" href="/">
                        <span class="material-symbols-outlined text-primary-600 text-3xl" style="font-variation-settings: 'FILL' 1;">explore</span>
                        <span class="font-black text-3xl tracking-tighter text-slate-900">Nomado</span>
                    </a>
                    <h2 class="font-bold text-3xl text-slate-900">Create Account</h2>
                </div>

                <div class="hidden lg:block mb-8">
                    <h2 class="font-black text-4xl text-slate-900 tracking-tight">Join Nomado</h2>
                    <p class="text-slate-500 mt-2 text-lg">Start your adventure in seconds.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <!-- Name Input -->
                    <div class="space-y-1.5">
                        <label class="font-semibold text-sm text-slate-700 block" for="name">Full Name</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <span class="material-symbols-outlined text-[20px]">person</span>
                            </span>
                            <input class="w-full bg-slate-50 border border-slate-100 rounded-xl py-3.5 pl-12 pr-4 text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all text-base outline-none @error('name') border-red-300 @enderror" 
                                   id="name" type="text" name="name" value="{{ old('name') }}" placeholder="John Doe" required autofocus />
                        </div>
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Email Input -->
                    <div class="space-y-1.5">
                        <label class="font-semibold text-sm text-slate-700 block" for="email">Email Address</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <span class="material-symbols-outlined text-[20px]">mail</span>
                            </span>
                            <input class="w-full bg-slate-50 border border-slate-100 rounded-xl py-3.5 pl-12 pr-4 text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all text-base outline-none @error('email') border-red-300 @enderror" 
                                   id="email" type="email" name="email" value="{{ old('email') }}" placeholder="hello@nomado.ai" required />
                        </div>
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="space-y-1.5">
                        <label class="font-semibold text-sm text-slate-700 block" for="password">Password</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <span class="material-symbols-outlined text-[20px]">lock</span>
                            </span>
                            <input class="w-full bg-slate-50 border border-slate-100 rounded-xl py-3.5 pl-12 pr-4 text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all text-base outline-none @error('password') border-red-300 @enderror" 
                                   id="password" type="password" name="password" placeholder="Min. 8 characters" required autocomplete="new-password" />
                        </div>
                        <!-- Strength Bar -->
                        <div class="flex gap-1 mt-2">
                            <div id="strength-1" class="h-1 flex-1 rounded-full bg-slate-100 transition-colors"></div>
                            <div id="strength-2" class="h-1 flex-1 rounded-full bg-slate-100 transition-colors"></div>
                            <div id="strength-3" class="h-1 flex-1 rounded-full bg-slate-100 transition-colors"></div>
                        </div>
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-1.5">
                        <label class="font-semibold text-sm text-slate-700 block" for="password_confirmation">Confirm Password</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                <span class="material-symbols-outlined text-[20px]">shield</span>
                            </span>
                            <input class="w-full bg-slate-50 border border-slate-100 rounded-xl py-3.5 pl-12 pr-4 text-slate-900 placeholder:text-slate-400 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-all text-base outline-none" 
                                   id="password_confirmation" type="password" name="password_confirmation" placeholder="••••••••" required autocomplete="new-password" />
                        </div>
                    </div>

                    <!-- Terms -->
                    <div class="flex items-start pt-2">
                        <input class="h-5 w-5 rounded bg-slate-50 border-slate-200 text-primary-600 focus:ring-primary-500/30 mt-0.5" 
                               id="terms" name="terms" type="checkbox" required />
                        <label class="ml-3 block text-xs text-slate-500 leading-relaxed" for="terms">
                            I agree to the <a href="#" class="text-primary-600 font-bold hover:underline">Terms</a> and <a href="#" class="text-primary-600 font-bold hover:underline">Privacy Policy</a>
                        </label>
                    </div>

                    <!-- Actions -->
                    <div class="pt-4">
                        <button class="w-full flex justify-center items-center py-4 px-4 rounded-xl text-white font-bold text-lg bg-gradient-primary hover:opacity-90 transition-opacity ambient-glow shadow-lg shadow-primary-500/20" type="submit">
                            Create Account
                            <span class="material-symbols-outlined ml-2 text-[20px]">person_add</span>
                        </button>
                    </div>

                    <!-- Alternate Auth -->
                    <div class="mt-8 pt-6 border-t border-slate-100 text-center">
                        <p class="text-slate-500 text-sm">
                            Already have an account? 
                            <a class="font-bold text-primary-600 hover:text-primary-700 transition-colors ml-1" href="{{ route('login') }}">Sign In</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const s1 = document.getElementById('strength-1');
        const s2 = document.getElementById('strength-2');
        const s3 = document.getElementById('strength-3');

        passwordInput.addEventListener('input', (e) => {
            const password = e.target.value;
            let strength = 0;
            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;

            s1.className = 'h-1 flex-1 rounded-full bg-slate-100 transition-colors';
            s2.className = 'h-1 flex-1 rounded-full bg-slate-100 transition-colors';
            s3.className = 'h-1 flex-1 rounded-full bg-slate-100 transition-colors';

            if (strength >= 1) s1.className = 'h-1 flex-1 rounded-full bg-red-400';
            if (strength >= 2) s2.className = 'h-1 flex-1 rounded-full bg-amber-400';
            if (strength >= 3) s3.className = 'h-1 flex-1 rounded-full bg-emerald-400';
        });
    </script>
</body>
</html>
