<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign In - Nomado</title>
    <meta name="description" content="Sign in to your Nomado account and start planning your next adventure.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
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
                        },
                    },
                }
            }
        }
    </script>
    <style>
        * { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }

        @keyframes pageFadeIn {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideInUpScale {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.97);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }
            100% {
                background-position: 1000px 0;
            }
        }

        @keyframes focusGlow {
            0%, 100% {
                box-shadow: 0 0 0 0 rgba(14, 165, 233, 0.1);
            }
            50% {
                box-shadow: 0 0 0 8px rgba(14, 165, 233, 0.05);
            }
        }

        .page-fade-in {
            animation: slideInUpScale 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        body {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #bae6fd 100%);
            animation: gradientShift 8s ease infinite;
            background-size: 200% 200%;
        }

        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        input:focus {
            animation: focusGlow 0.6s ease-out;
        }

        button[type="submit"] {
            position: relative;
            overflow: hidden;
            background-image: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.3) 50%, transparent 100%);
            background-size: 200% 100%;
            transition: all 0.3s ease;
        }

        button[type="submit"]:hover {
            animation: shimmer 0.8s ease-in-out infinite;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(2, 132, 199, 0.3);
        }

        @media (prefers-reduced-motion: reduce) {
            .page-fade-in, body, input:focus, button[type="submit"]:hover {
                animation: none;
                background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #bae6fd 100%);
            }
        }
    </style>
</head>
<body class="antialiased min-h-screen flex items-center justify-center font-sans bg-white px-4">
    <div class="w-full max-w-md mx-auto page-fade-in">
        <!-- Logo -->
        <div class="flex items-center justify-center gap-2.5 mb-8">
            <div class="w-9 h-9 rounded-lg bg-primary-600 flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
            </div>
            <span class="font-bold text-xl text-gray-900 tracking-tight">Nomado</span>
        </div>

        <!-- Card -->
        <div class="bg-white border border-gray-200 shadow-sm rounded-2xl p-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Welcome back</h1>
                <p class="text-sm text-gray-500 mt-1">Sign in to your account</p>
            </div>

            <!-- Session Status / Global Error -->
            @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-100 text-red-600 px-4 py-3 rounded-xl text-sm font-medium">
                Unable to sign in. Please check your credentials and try again.
            </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="text-sm font-medium text-gray-700 mb-1.5 block">Email Address</label>
                    <input id="email" type="email" name="email" placeholder="you@example.com" value="{{ old('email') }}" required autofocus autocomplete="username"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-colors bg-white placeholder:text-gray-400">
                    @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="text-sm font-medium text-gray-700">Password</label>
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-primary-600 hover:underline">Forgot password?</a>
                        @endif
                    </div>
                    <input id="password" type="password" name="password" placeholder="Enter your password" required autocomplete="current-password"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-colors bg-white placeholder:text-gray-400">
                    @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                    <label for="remember_me" class="ml-2.5 text-sm text-gray-500">Remember me</label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-gray-900 hover:bg-primary-600 text-white font-semibold py-3 rounded-xl transition-colors">
                    Sign In
                </button>
            </form>
        </div>

        <!-- Sign Up Link -->
        <p class="text-center text-sm text-gray-500 mt-6">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-primary-600 font-semibold hover:underline">Sign up</a>
        </p>
    </div>
</body>
</html>
