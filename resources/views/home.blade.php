@extends('layouts.app')

@section('content')
<div class="w-full min-h-screen pt-20 pb-20 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto w-full">
        <!-- Header -->
        <div class="text-center mb-12 animate-on-scroll fade-in">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4 tracking-tight">
                Generate Your <span class="text-primary-600">Perfect Trip</span>
            </h1>
            <p class="text-lg text-gray-500 max-w-2xl mx-auto">
                Tell us about your dream journey and our AI will create personalized itineraries just for you
            </p>
        </div>

        <!-- Main Form Card -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 md:p-10 animate-on-scroll slide-in-up">
            <form id="trip-generator-form" class="space-y-8">
                <!-- Travel Type Selection -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">What's your travel style?</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        @php
                            $travelTypes = [
                                ['name' => 'Adventure', 'value' => 'adventure'],
                                ['name' => 'Culture', 'value' => 'culture'],
                                ['name' => 'Beach', 'value' => 'beach'],
                                ['name' => 'Luxury', 'value' => 'luxury'],
                            ];
                        @endphp

                        @foreach($travelTypes as $index => $type)
                        <label class="relative cursor-pointer animate-on-scroll fade-in" style="animation-delay: {{ 0.05 * ($index + 1) }}s;">
                            <input type="radio" name="travel_type" value="{{ $type['value'] }}" class="peer sr-only" {{ $loop->first ? 'checked' : '' }}>
                            <div class="peer-checked:border-primary-600 peer-checked:bg-primary-50 peer-checked:text-primary-700 peer-checked:font-semibold border border-gray-200 bg-white text-gray-600 rounded-xl py-4 px-4 transition-all hover:border-primary-400 hover:bg-primary-50 flex items-center justify-center text-center text-sm font-medium travel-type-btn">
                                {{ $type['name'] }}
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Budget Input -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Budget per person</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 font-semibold text-sm">EUR</span>
                        <input type="number" id="budget" name="budget" placeholder="2000" min="500" max="50000" step="100" required
                            class="w-full pl-14 pr-6 py-3 bg-white border border-gray-200 rounded-xl text-gray-900 text-base font-medium focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-colors placeholder:text-gray-400"
                            value="2000">
                    </div>
                    <div class="mt-2 flex items-center justify-between">
                        <div class="flex gap-2">
                            <button type="button" class="budget-preset px-3 py-1 rounded-lg text-xs font-semibold text-gray-500 border border-gray-200 hover:border-primary-400 hover:text-primary-600 hover:bg-primary-50 transition-all budget-scale" data-value="1000">1K</button>
                            <button type="button" class="budget-preset px-3 py-1 rounded-lg text-xs font-semibold text-gray-500 border border-gray-200 hover:border-primary-400 hover:text-primary-600 hover:bg-primary-50 transition-all budget-scale" data-value="2000">2K</button>
                            <button type="button" class="budget-preset px-3 py-1 rounded-lg text-xs font-semibold text-gray-500 border border-gray-200 hover:border-primary-400 hover:text-primary-600 hover:bg-primary-50 transition-all budget-scale" data-value="5000">5K</button>
                            <button type="button" class="budget-preset px-3 py-1 rounded-lg text-xs font-semibold text-gray-500 border border-gray-200 hover:border-primary-400 hover:text-primary-600 hover:bg-primary-50 transition-all budget-scale" data-value="10000">10K</button>
                        </div>
                        <span class="text-xs text-gray-400">
                            <span id="budget-display">2,000</span> EUR total
                        </span>
                    </div>
                </div>

                <!-- Duration Slider -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Trip duration</label>
                    <div class="flex items-center gap-6">
                        <input type="range" id="duration" name="duration" min="3" max="30" value="7"
                            class="flex-grow h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-primary-600">
                        <div class="flex items-center gap-1.5">
                            <span id="duration-display" class="text-2xl font-bold text-gray-900 min-w-[2rem] text-right">7</span>
                            <span class="text-gray-400 font-medium text-sm">days</span>
                        </div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-400 mt-1">
                        <span>Weekend</span>
                        <span>Perfect</span>
                        <span>Extended</span>
                    </div>
                </div>

                <!-- Number of Travelers -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Number of travelers</label>
                    <div class="flex gap-3">
                        @for($i = 1; $i <= 5; $i++)
                        <label class="cursor-pointer">
                            <input type="radio" name="passengers" value="{{ $i }}" class="peer sr-only" {{ $i === 1 ? 'checked' : '' }}>
                            <div class="w-12 h-12 flex items-center justify-center rounded-xl border border-gray-200 peer-checked:border-primary-600 peer-checked:bg-primary-50 peer-checked:text-primary-700 hover:border-primary-400 transition-all font-semibold text-gray-600 text-sm">
                                {{ $i }}
                            </div>
                        </label>
                        @endfor
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-gray-100">
                    <button type="submit" id="submit-btn" class="w-full py-4 bg-gray-900 text-white rounded-xl font-semibold text-base hover:bg-primary-600 transition-colors flex items-center justify-center gap-2 submit-shimmer">
                        <span id="btn-text">Generate My Trips</span>
                        <svg id="btn-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        <svg id="btn-spinner" class="w-5 h-5 animate-spin hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </button>
                </div>
            </form>

            <!-- Loading State (hidden by default) -->
            <div id="loading-state" class="hidden flex-col items-center justify-center space-y-6 py-16">
                <!-- Spinner -->
                <div class="w-12 h-12">
                    <svg class="w-full h-full animate-spin text-gray-300" viewBox="0 0 24 24" fill="none">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>

                <!-- Loading Text -->
                <div class="text-center">
                    <p class="text-lg font-semibold text-gray-900 mb-1">Scanning destinations...</p>
                    <p id="loading-message" class="text-gray-500 text-sm">Analyzing your preferences</p>
                </div>

                <!-- Progress Bar -->
                <div class="w-full max-w-xs h-1.5 bg-gray-100 rounded-full overflow-hidden">
                    <div id="loading-progress" class="h-full bg-primary-600 rounded-full transition-all duration-300" style="width: 0%;"></div>
                </div>
            </div>
        </div>

        <!-- Trust Badges -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 animate-on-scroll slide-in-up" style="animation-delay: 0.1s;">
                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1">Secure & Private</h3>
                <p class="text-sm text-gray-500">Your data is encrypted end-to-end</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 animate-on-scroll slide-in-up" style="animation-delay: 0.2s;">
                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1">Lightning Fast</h3>
                <p class="text-sm text-gray-500">Results in seconds, not hours</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 animate-on-scroll slide-in-up" style="animation-delay: 0.3s;">
                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-1">AI-Powered</h3>
                <p class="text-sm text-gray-500">Smart matching with 1000+ options</p>
            </div>
        </div>
    </div>
</div>

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
    const loadingProgress = document.getElementById('loading-progress');

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
        budgetDisplay.textContent = value.toLocaleString();
    });

    // Budget presets with scale animation
    document.querySelectorAll('.budget-preset').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const value = btn.getAttribute('data-value');
            budgetInput.value = value;
            budgetDisplay.textContent = parseInt(value).toLocaleString();
            btn.style.animation = 'budgetScale 0.3s ease-out';
            setTimeout(() => {
                btn.style.animation = '';
            }, 300);
        });
    });

    // Duration slider
    durationInput.addEventListener('input', (e) => {
        durationDisplay.textContent = e.target.value;
    });

    // Form submission
    form.addEventListener('submit', (e) => {
        e.preventDefault();

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        // Hide form, show loading
        form.style.display = 'none';
        loadingState.classList.remove('hidden');
        loadingState.classList.add('flex');

        // Animate progress
        let progress = 0;
        const progressInterval = setInterval(() => {
            progress += 2;
            if (progress > 95) clearInterval(progressInterval);
            loadingProgress.style.width = progress + '%';
        }, 100);

        // Cycle loading messages
        let messageIndex = 0;
        const messageInterval = setInterval(() => {
            messageIndex = (messageIndex + 1) % loadingMessages.length;
            loadingMessage.textContent = loadingMessages[messageIndex];
        }, 800);

        // Redirect after delay
        setTimeout(() => {
            clearInterval(messageInterval);
            clearInterval(progressInterval);
            loadingProgress.style.width = '100%';
            const formData = new FormData(form);
            const params = new URLSearchParams(formData).toString();
            window.location.href = `/results?${params}`;
        }, 5000);
    });

    // Travel type selection styling
    document.querySelectorAll('.travel-type-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            this.style.animation = 'travelTypeScale 0.3s ease-out';
            setTimeout(() => {
                this.style.animation = '';
            }, 300);
        });
    });
</script>

<style>
    @keyframes budgetScale {
        0% { transform: scale(1); }
        50% { transform: scale(0.95); }
        100% { transform: scale(1.05); }
    }

    @keyframes travelTypeScale {
        0% { transform: scale(1); }
        50% { transform: scale(0.95); }
        100% { transform: scale(1.05); }
    }

    @keyframes shimmerButton {
        0% { background-position: -1000px 0; }
        100% { background-position: 1000px 0; }
    }

    .submit-shimmer {
        position: relative;
        overflow: hidden;
    }

    .submit-shimmer:hover {
        background-image: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.3) 50%, transparent 100%);
        background-size: 200% 100%;
        animation: shimmerButton 0.8s ease-in-out;
    }

    @media (prefers-reduced-motion: reduce) {
        .budget-preset, .travel-type-btn, .submit-shimmer:hover {
            animation: none !important;
        }
    }
</style>
@endsection
