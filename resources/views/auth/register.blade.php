<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create Account - Nomado</title>
    <meta name="description" content="Create your Nomado account and start planning personalized AI-generated trips.">
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

        #strength-1, #strength-2, #strength-3 {
            transition: all 0.3s ease, width 0.4s ease;
        }

        @media (prefers-reduced-motion: reduce) {
            .page-fade-in, body, input:focus, button[type="submit"]:hover {
                animation: none;
                background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #bae6fd 100%);
            }
        }
    </style>
</head>
<body class="antialiased min-h-screen flex items-center justify-center font-sans bg-white px-4 py-8">
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
                <h1 class="text-2xl font-bold text-gray-900">Create your account</h1>
                <p class="text-sm text-gray-500 mt-1">Start planning your perfect trip</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="text-sm font-medium text-gray-700 mb-1.5 block">Full Name</label>
                    <input id="name" type="text" name="name" placeholder="John Doe" value="{{ old('name') }}" required autofocus autocomplete="name"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-colors bg-white placeholder:text-gray-400">
                    @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="text-sm font-medium text-gray-700 mb-1.5 block">Email Address</label>
                    <input id="email" type="email" name="email" placeholder="you@example.com" value="{{ old('email') }}" required autocomplete="username"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-colors bg-white placeholder:text-gray-400">
                    @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="text-sm font-medium text-gray-700 mb-1.5 block">Password</label>
                    <input id="password" type="password" name="password" placeholder="Min. 8 characters" required autocomplete="new-password"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-colors bg-white placeholder:text-gray-400">
                    <!-- Password Strength Bar -->
                    <div class="mt-2 flex gap-1">
                        <div id="strength-1" class="h-1.5 flex-1 rounded-full bg-gray-100 transition-colors"></div>
                        <div id="strength-2" class="h-1.5 flex-1 rounded-full bg-gray-100 transition-colors"></div>
                        <div id="strength-3" class="h-1.5 flex-1 rounded-full bg-gray-100 transition-colors"></div>
                    </div>
                    <p class="mt-1.5 text-xs text-gray-400">Must contain uppercase, lowercase, and numbers</p>
                    @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="text-sm font-medium text-gray-700 mb-1.5 block">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Re-enter your password" required autocomplete="new-password"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-colors bg-white placeholder:text-gray-400">
                    @error('password_confirmation')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Terms -->
                <div class="flex items-start">
                    <input id="terms" type="checkbox" name="terms" class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500 mt-0.5" required>
                    <label for="terms" class="ml-2.5 text-xs text-gray-500 leading-relaxed">
                        I agree to the <a href="#" class="text-primary-600 hover:underline">Terms of Service</a> and <a href="#" class="text-primary-600 hover:underline">Privacy Policy</a>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-gray-900 hover:bg-primary-600 text-white font-semibold py-3 rounded-xl transition-colors">
                    Create Account
                </button>
            </form>
        </div>

        <!-- Sign In Link -->
        <p class="text-center text-sm text-gray-500 mt-6">
            Already have an account?
            <a href="{{ route('login') }}" class="text-primary-600 font-semibold hover:underline">Sign in</a>
        </p>
    </div>

    <script>
        // Password strength indicator
        const passwordInput = document.getElementById('password');
        const s1 = document.getElementById('strength-1');
        const s2 = document.getElementById('strength-2');
        const s3 = document.getElementById('strength-3');

        passwordInput.addEventListener('input', (e) => {
            const password = e.target.value;
            let strength = 0;

            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^a-zA-Z0-9]/.test(password)) strength++;

            // Reset
            s1.className = 'h-1.5 flex-1 rounded-full bg-gray-100 transition-colors';
            s2.className = 'h-1.5 flex-1 rounded-full bg-gray-100 transition-colors';
            s3.className = 'h-1.5 flex-1 rounded-full bg-gray-100 transition-colors';

            if (password.length === 0) return;

            if (strength <= 2) {
                s1.className = 'h-1.5 flex-1 rounded-full bg-red-400 transition-colors';
            } else if (strength <= 3) {
                s1.className = 'h-1.5 flex-1 rounded-full bg-amber-400 transition-colors';
                s2.className = 'h-1.5 flex-1 rounded-full bg-amber-400 transition-colors';
            } else {
                s1.className = 'h-1.5 flex-1 rounded-full bg-green-400 transition-colors';
                s2.className = 'h-1.5 flex-1 rounded-full bg-green-400 transition-colors';
                s3.className = 'h-1.5 flex-1 rounded-full bg-green-400 transition-colors';
            }
        });
    </script>
</body>
</html>
