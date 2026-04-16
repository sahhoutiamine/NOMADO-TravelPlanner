@extends('layouts.app')

@section('content')
<div class="relative w-full overflow-hidden min-h-screen pt-20 pb-20 px-4 sm:px-6 lg:px-8">
    <!-- Background Elements -->
    <div class="absolute inset-0 -z-10 overflow-hidden">
        <div class="absolute top-20 right-20 w-96 h-96 bg-coral-500/10 rounded-full blur-3xl animate-drift-slow"></div>
        <div class="absolute bottom-40 left-10 w-80 h-80 bg-amber-500/10 rounded-full blur-3xl animate-drift-fast"></div>
    </div>

    <div class="max-w-4xl mx-auto w-full">
        <!-- Header -->
        <div class="text-center mb-16 animate-on-scroll slide-in-up">
            <h1 class="text-5xl md:text-6xl font-display font-black text-white mb-6">
                Generate Your <span class="gradient-text">Perfect Trip</span>
            </h1>
            <p class="text-xl text-gray-400 max-w-2xl mx-auto font-jakarta">
                Tell us about your dream journey and our AI will create personalized itineraries just for you
            </p>
        </div>

        <!-- Main Form Card -->
        <div class="relative group animate-on-scroll fade-in" style="animation-delay: 0.1s;">
            <!-- Animated border gradient -->
            <div class="absolute -inset-1 bg-gradient-to-r from-coral-500 via-amber-500 to-coral-500 rounded-3xl opacity-50 blur-lg group-hover:opacity-100 transition-all duration-500 animate-shimmer" style="background-size: 200% 100%;"></div>

            <!-- Main Card -->
            <div class="relative glass-dark rounded-3xl p-8 md:p-12 backdrop-blur-xl">
                <form id="trip-generator-form" class="space-y-10">
                    <!-- Travel Type Selection -->
                    <div>
                        <label class="block text-xl font-jakarta font-bold text-white mb-6">What's your travel vibe?</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @php
                                $travelTypes = [
                                    ['name' => 'Adventure', 'icon' => '🏔️', 'value' => 'adventure', 'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=400'],
                                    ['name' => 'Luxury', 'icon' => '✨', 'value' => 'luxury', 'image' => 'https://images.unsplash.com/photo-1566073171639-3f8b3f5e4c4b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=400'],
                                    ['name' => 'Culture', 'icon' => '🏛️', 'value' => 'culture', 'image' => 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=400'],
                                    ['name' => 'Beach', 'icon' => '🏖️', 'value' => 'beach', 'image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=400'],
                                ];
                            @endphp

                            @foreach($travelTypes as $type)
                            <label class="relative cursor-pointer group/card">
                                <input type="radio" name="travel_type" value="{{ $type['value'] }}" class="peer sr-only" {{ $loop->first ? 'checked' : '' }}>

                                <!-- Card Background -->
                                <div class="relative overflow-hidden rounded-2xl h-32 md:h-40 border-2 border-white/20 peer-checked:border-coral-500 transition-all duration-300 group-hover/card:border-white/40">
                                    <img src="{{ $type['image'] }}" alt="{{ $type['name'] }}" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>

                                    <!-- Content Overlay -->
                                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                                        <span class="text-4xl mb-2">{{ $type['icon'] }}</span>
                                        <span class="text-sm font-jakarta font-bold text-white text-center">{{ $type['name'] }}</span>
                                    </div>

                                    <!-- Hover Indicator -->
                                    <div class="absolute top-2 right-2 w-6 h-6 rounded-full border-2 border-white/40 peer-checked:border-coral-500 peer-checked:bg-coral-500 transition-all duration-300"></div>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Budget Input -->
                    <div>
                        <label class="block text-lg font-jakarta font-bold text-white mb-4">Budget per person</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-coral-400 font-jakarta font-bold text-lg">€</span>
                            <input type="number" id="budget" name="budget" placeholder="2000" min="500" max="50000" step="100" required
                                class="w-full pl-10 pr-6 py-4 bg-white/5 border-2 border-white/20 hover:border-white/40 focus:border-coral-500 rounded-xl text-white font-jakarta text-lg font-bold focus:outline-none focus:ring-4 focus:ring-coral-500/20 transition-all duration-300"
                                value="2000">
                            <span class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 font-jakarta text-sm">Per person</span>
                        </div>
                        <div class="mt-3 flex items-center justify-between">
                            <div class="flex gap-2">
                                <button type="button" class="budget-preset px-3 py-1 rounded text-xs font-jakarta font-semibold text-gray-300 border border-white/20 hover:border-coral-500 hover:text-coral-400 transition-all" data-value="1000">€1K</button>
                                <button type="button" class="budget-preset px-3 py-1 rounded text-xs font-jakarta font-semibold text-gray-300 border border-white/20 hover:border-coral-500 hover:text-coral-400 transition-all" data-value="2000">€2K</button>
                                <button type="button" class="budget-preset px-3 py-1 rounded text-xs font-jakarta font-semibold text-gray-300 border border-white/20 hover:border-coral-500 hover:text-coral-400 transition-all" data-value="5000">€5K</button>
                                <button type="button" class="budget-preset px-3 py-1 rounded text-xs font-jakarta font-semibold text-gray-300 border border-white/20 hover:border-coral-500 hover:text-coral-400 transition-all" data-value="10000">€10K</button>
                            </div>
                            <span class="text-xs text-gray-400 font-jakarta">
                                <span id="budget-display">€2,000</span> total
                            </span>
                        </div>
                    </div>

                    <!-- Duration Slider -->
                    <div>
                        <label class="block text-lg font-jakarta font-bold text-white mb-4">Trip duration</label>
                        <div class="flex items-center gap-6">
                            <input type="range" id="duration" name="duration" min="3" max="30" value="7"
                                class="flex-grow h-2 bg-white/10 rounded-lg appearance-none cursor-pointer slider"
                                style="background: linear-gradient(to right, #FF6B35 0%, #FF6B35 calc((7-3)/(30-3)*100%), rgba(255,255,255,0.1) calc((7-3)/(30-3)*100%), rgba(255,255,255,0.1) 100%);">
                            <div class="flex items-center gap-2">
                                <span id="duration-display" class="text-3xl font-display font-black gradient-text min-w-16">7</span>
                                <span class="text-gray-400 font-jakarta font-semibold">days</span>
                            </div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500 font-jakarta mt-2">
                            <span>Weekend</span>
                            <span>Perfect</span>
                            <span>Extended</span>
                        </div>
                    </div>

                    <!-- Number of Travelers -->
                    <div>
                        <label class="block text-lg font-jakarta font-bold text-white mb-4">Number of travelers</label>
                        <div class="flex gap-3">
                            @for($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer group/travelers">
                                <input type="radio" name="passengers" value="{{ $i }}" class="peer sr-only" {{ $i === 1 ? 'checked' : '' }}>
                                <div class="w-12 h-12 flex items-center justify-center rounded-xl border-2 border-white/20 peer-checked:border-coral-500 peer-checked:bg-coral-500/20 group-hover/travelers:border-coral-400 transition-all duration-300 font-jakarta font-bold text-white">
                                    {{ $i }}
                                </div>
                            </label>
                            @endfor
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6">
                        <button type="submit" id="submit-btn" class="w-full relative overflow-hidden group">
                            <!-- Shimmer Background -->
                            <div class="absolute inset-0 bg-gradient-to-r from-coral-500 to-amber-500 rounded-2xl"></div>
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent animate-shimmer" style="background-size: 200% 100%;"></div>

                            <!-- Button Content -->
                            <div class="relative flex items-center justify-center gap-3 py-5 px-8 rounded-2xl font-jakarta font-bold text-lg text-navy-900 group-hover:gap-4 transition-all duration-300">
                                <span id="btn-text">Generate My Trips</span>
                                <svg id="btn-icon" class="w-6 h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                <svg id="btn-spinner" class="w-6 h-6 animate-spin hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            </div>
                        </button>
                    </div>

                    <!-- Info Text -->
                    <p class="text-center text-sm text-gray-400 font-jakarta">
                        <span class="inline-flex items-center gap-1 mb-1">
                            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                            AI generation in progress
                        </span>
                        <br>
                        Typical time: 30-60 seconds
                    </p>
                </form>

                <!-- Loading State (hidden by default) -->
                <div id="loading-state" class="hidden flex flex-col items-center justify-center space-y-8 py-12">
                    <!-- Animated Globe -->
                    <div class="relative w-32 h-32">
                        <svg class="w-full h-full animate-spin" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="50" cy="50" r="45" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="2"/>
                            <path d="M 50 10 A 40 40 0 0 1 80 80" fill="none" stroke="url(#gradient)" stroke-width="3" stroke-linecap="round"/>
                            <defs>
                                <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#FF6B35;stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:#F59E0B;stop-opacity:1" />
                                </linearGradient>
                            </defs>
                            <!-- Pulsing dot -->
                            <circle cx="50" cy="50" r="3" fill="#FF6B35">
                                <animate attributeName="r" values="3;8;3" dur="2s" repeatCount="indefinite"/>
                                <animate attributeName="opacity" values="1;0.3;1" dur="2s" repeatCount="indefinite"/>
                            </circle>
                        </svg>
                    </div>

                    <!-- Loading Text -->
                    <div class="text-center">
                        <p class="text-2xl font-display font-black gradient-text mb-2">Scanning the globe...</p>
                        <p id="loading-message" class="text-gray-400 font-jakarta">Analyzing your preferences</p>
                    </div>

                    <!-- Progress Bar -->
                    <div class="w-full max-w-xs h-2 bg-white/10 rounded-full overflow-hidden">
                        <div id="loading-progress" class="h-full bg-gradient-to-r from-coral-500 to-amber-500 rounded-full" style="width: 0%; animation: loading-progress 4s ease-in-out forwards;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trust Badges -->
        <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-6 text-center animate-on-scroll fade-in" style="animation-delay: 0.3s;">
            <div class="glass rounded-2xl p-6">
                <div class="text-3xl mb-2">🛡️</div>
                <h3 class="font-jakarta font-bold text-white mb-1">Secure & Private</h3>
                <p class="text-sm text-gray-400">Your data is encrypted end-to-end</p>
            </div>
            <div class="glass rounded-2xl p-6">
                <div class="text-3xl mb-2">⚡</div>
                <h3 class="font-jakarta font-bold text-white mb-1">Lightning Fast</h3>
                <p class="text-sm text-gray-400">Results in seconds, not hours</p>
            </div>
            <div class="glass rounded-2xl p-6">
                <div class="text-3xl mb-2">💯</div>
                <h3 class="font-jakarta font-bold text-white mb-1">AI-Powered</h3>
                <p class="text-sm text-gray-400">Smart matching with 1000+ options</p>
            </div>
        </div>
    </div>
</div>

<style>
    .slider::-webkit-slider-thumb {
        appearance: none;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: linear-gradient(135deg, #FF6B35 0%, #F59E0B 100%);
        cursor: pointer;
        border: 2px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 0 15px rgba(255, 107, 53, 0.5);
        transition: all 0.3s ease;
    }

    .slider::-webkit-slider-thumb:hover {
        transform: scale(1.2);
        box-shadow: 0 0 25px rgba(255, 107, 53, 0.8);
    }

    .slider::-moz-range-thumb {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: linear-gradient(135deg, #FF6B35 0%, #F59E0B 100%);
        cursor: pointer;
        border: 2px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 0 15px rgba(255, 107, 53, 0.5);
        transition: all 0.3s ease;
    }

    .slider::-moz-range-thumb:hover {
        transform: scale(1.2);
        box-shadow: 0 0 25px rgba(255, 107, 53, 0.8);
    }

    @keyframes loading-progress {
        0% { width: 0%; }
        50% { width: 80%; }
        100% { width: 100%; }
    }

    .hide {
        display: none !important;
    }

    .animate-on-scroll {
        opacity: 0;
        animation-fill-mode: forwards;
    }

    .slide-in-up {
        animation: slideInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .fade-in {
        animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
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

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
</style>

<script>
    const form = document.getElementById('trip-generator-form');
    const budgetInput = document.getElementById('budget');
    const durationInput = document.getElementById('duration');
    const budgetDisplay = document.getElementById('budget-display');
    const durationDisplay = document.getElementById('duration-display');
    const submitBtn = document.getElementById('submit-btn');
    const btnText = document.getElementById('btn-text');
    const btnIcon = document.getElementById('btn-icon');
    const btnSpinner = document.getElementById('btn-spinner');
    const loadingState = document.getElementById('loading-state');
    const loadingMessage = document.getElementById('loading-message');

    const loadingMessages = [
        'Analyzing your preferences...',
        'Searching 250+ destinations...',
        'Evaluating 1000+ hotels...',
        'Calculating best routes...',
        'Personalizing your trips...',
        'Finalizing itineraries...'
    ];

    // Budget formatting
    budgetInput.addEventListener('input', (e) => {
        const value = parseInt(e.target.value) || 0;
        budgetDisplay.textContent = '€' + value.toLocaleString();
    });

    // Budget presets
    document.querySelectorAll('.budget-preset').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const value = btn.getAttribute('data-value');
            budgetInput.value = value;
            budgetDisplay.textContent = '€' + parseInt(value).toLocaleString();
        });
    });

    // Duration slider
    durationInput.addEventListener('input', (e) => {
        const value = e.target.value;
        durationDisplay.textContent = value;
        const percent = ((value - 3) / (30 - 3)) * 100;
        durationInput.style.background = `linear-gradient(to right, #FF6B35 0%, #FF6B35 ${percent}%, rgba(255,255,255,0.1) ${percent}%, rgba(255,255,255,0.1) 100%)`;
    });

    // Form submission
    form.addEventListener('submit', (e) => {
        e.preventDefault();

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        // Hide form, show loading
        form.classList.add('hide');
        loadingState.classList.remove('hide');
        loadingState.classList.add('flex');

        // Cycle loading messages
        let messageIndex = 0;
        const messageInterval = setInterval(() => {
            messageIndex = (messageIndex + 1) % loadingMessages.length;
            loadingMessage.textContent = loadingMessages[messageIndex];
        }, 800);

        // Simulate API call
        setTimeout(() => {
            clearInterval(messageInterval);
            const formData = new FormData(form);
            const params = new URLSearchParams(formData).toString();
            window.location.href = `/results?${params}`;
        }, 5000);
    });
</script>
@endsection
