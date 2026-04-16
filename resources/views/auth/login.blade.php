<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign In - Nomado</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Clash+Display:wght@700;900&family=Plus+Jakarta+Sans:wght@400;500;700&family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
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
                            600: '#0A0F1E',
                            900: '#000000',
                        },
                        'coral': {
                            500: '#FF6B35',
                        },
                        'amber': {
                            500: '#F59E0B',
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

        body {
            background: linear-gradient(135deg, #0A0F1E 0%, #050A11 100%);
            color: #E8EAED;
        }

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

        .gradient-text {
            background: linear-gradient(135deg, #FF6B35 0%, #F59E0B 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        input, textarea, select {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #E8EAED;
            border-radius: 8px;
            padding: 12px 16px;
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

        .btn-primary {
            background: linear-gradient(135deg, #FF6B35 0%, #F59E0B 100%);
            color: #0A0F1E;
            font-weight: 700;
            border: none;
            border-radius: 8px;
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
            border-radius: 8px;
            padding: 10px 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .slideshow-image {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            animation: imageSlide 8s ease-in-out infinite;
        }

        .slideshow-image:nth-child(2) {
            animation-delay: 2.7s;
        }

        .slideshow-image:nth-child(3) {
            animation-delay: 5.4s;
        }

        @keyframes imageSlide {
            0%, 5% {
                opacity: 1;
            }
            25%, 100% {
                opacity: 0;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-in {
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }
    </style>
</head>
<body class="antialiased min-h-screen flex items-center justify-center font-sans">
    <div class="absolute inset-0 -z-10">
        <div class="absolute top-20 right-20 w-96 h-96 bg-coral-500/10 rounded-full blur-3xl animate-drift-slow"></div>
        <div class="absolute bottom-40 left-10 w-80 h-80 bg-amber-500/10 rounded-full blur-3xl animate-drift-fast"></div>
    </div>

    <div class="w-full max-w-6xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-0 items-stretch min-h-screen lg:min-h-auto">
            <!-- Left: Slideshow -->
            <div class="hidden lg:flex relative overflow-hidden rounded-l-3xl">
                <div class="absolute inset-0 bg-gradient-to-t from-navy-900/80 via-navy-900/40 to-transparent z-10"></div>

                <!-- Slideshow Container -->
                <div class="absolute inset-0 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&h=1000" alt="Mountain Adventure" class="slideshow-image">
                    <img src="https://images.unsplash.com/photo-1488646953014-85cb44e25828?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&h=1000" alt="Cultural Journey" class="slideshow-image">
                    <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&h=1000" alt="Beach Relaxation" class="slideshow-image">
                </div>

                <!-- Content Overlay -->
                <div class="relative z-20 flex flex-col justify-between w-full p-12">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-coral-500 to-amber-500 flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-navy-900" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/></svg>
                        </div>
                        <span class="text-2xl font-display font-black text-white">Nomado</span>
                    </div>

                    <div>
                        <h2 class="text-4xl md:text-5xl font-display font-black text-white mb-4 leading-tight">
                            Your Perfect Trip, <span class="gradient-text">Generated</span>
                        </h2>
                        <p class="text-lg text-gray-300 font-jakarta leading-relaxed">
                            Join thousands of travelers discovering personalized itineraries crafted by AI. Adventure awaits at every corner.
                        </p>
                    </div>

                    <div class="flex gap-3">
                        <div class="w-3 h-3 rounded-full bg-coral-500 opacity-100"></div>
                        <div class="w-3 h-3 rounded-full bg-coral-500 opacity-30"></div>
                        <div class="w-3 h-3 rounded-full bg-coral-500 opacity-30"></div>
                    </div>
                </div>
            </div>

            <!-- Right: Login Form -->
            <div class="glass-dark lg:rounded-r-3xl p-8 md:p-12 flex flex-col justify-center rounded-3xl lg:rounded-none min-h-screen lg:min-h-auto">
                <div class="animate-in w-full max-w-md mx-auto">
                    <!-- Header -->
                    <div class="mb-10">
                        <h1 class="text-4xl font-display font-black text-white mb-2">Welcome Back</h1>
                        <p class="text-gray-400 font-jakarta">Sign in to continue your journey</p>
                    </div>

                    <!-- Form -->
                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-jakarta font-semibold text-white mb-2">Email Address</label>
                            <input id="email" type="email" name="email" placeholder="you@example.com" value="{{ old('email') }}" required autofocus autocomplete="username" class="w-full">
                            @error('email')
                            <p class="mt-2 text-xs text-coral-500 font-jakarta">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-jakarta font-semibold text-white mb-2">Password</label>
                            <input id="password" type="password" name="password" placeholder="••••••••" required autocomplete="current-password" class="w-full">
                            @error('password')
                            <p class="mt-2 text-xs text-coral-500 font-jakarta">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="flex items-center">
                            <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-white/20 bg-white/5 text-coral-500 focus:ring-coral-500">
                            <label for="remember_me" class="ml-3 text-sm text-gray-400 font-jakarta">Remember me</label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full btn-primary text-lg font-jakarta font-bold py-3 rounded-lg mt-8">
                            Sign In
                        </button>
                    </form>

                    <!-- Divider -->
                    <div class="relative my-8">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-white/10"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-3 bg-navy-600 text-gray-400 font-jakarta text-xs">OR</span>
                        </div>
                    </div>

                    <!-- Links -->
                    <div class="space-y-3">
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="block w-full btn-secondary text-center font-jakarta font-semibold">
                            Forgot Password?
                        </a>
                        @endif

                        <p class="text-center text-gray-400 font-jakarta text-sm">
                            Don't have an account?
                            <a href="{{ route('register') }}" class="text-coral-500 font-bold hover:text-amber-500 transition-colors">Sign up</a>
                        </p>
                    </div>

                    <!-- Session Status -->
                    @if ($errors->any())
                    <div class="mt-6 glass border border-coral-500/30 rounded-lg p-4">
                        <p class="text-sm text-coral-400 font-jakarta font-semibold">Unable to sign in. Please check your credentials and try again.</p>
                    </div>
                    @endif
                </div>

                <!-- Logo for Mobile -->
                <div class="lg:hidden flex items-center gap-2 mt-12 pt-8 border-t border-white/10">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-coral-500 to-amber-500 flex items-center justify-center">
                        <svg class="w-4 h-4 text-navy-900" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/></svg>
                    </div>
                    <span class="font-display font-black text-lg">Nomado</span>
                </div>
            </div>
        </div>
    </div>

    <style>
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

        .animate-drift-slow {
            animation: drift-slow 20s ease-in-out infinite;
        }

        .animate-drift-fast {
            animation: drift-fast 15s ease-in-out infinite;
        }
    </style>
</body>
</html>
