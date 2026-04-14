@extends('layouts.app')

@section('content')
<div class="relative overflow-hidden bg-white min-h-[calc(100vh-64px)] flex flex-col">
    <!-- Background Decor -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-[600px] overflow-hidden -z-10 pointer-events-none">
        <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[80%] rounded-full bg-primary-200/30 blur-[100px]"></div>
        <div class="absolute -top-[10%] -right-[10%] w-[40%] h-[80%] rounded-full bg-indigo-200/30 blur-[100px]"></div>
    </div>

    <div class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-20 md:pt-24 w-full flex flex-col justify-center">
        <div class="text-center max-w-3xl mx-auto mb-12 fade-in">
            <span class="inline-block py-1 px-3 rounded-full bg-primary-50 text-primary-700 text-xs font-bold tracking-wider uppercase mb-5 border border-primary-100 shadow-sm">AI-Powered Travels</span>
            <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight text-slate-900 mb-6 leading-tight">
                Your perfect trip, <br class="hidden md:block" />
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-indigo-600">generated in seconds.</span>
            </h1>
            <p class="text-lg md:text-xl text-slate-600 mb-8 leading-relaxed font-light">
                Tell us what you love, and our intelligent engine will craft a complete, personalized itinerary including destination, top-rated hotels, and flights.
            </p>
        </div>

        <!-- Dynamic Form / Trip Generator -->
        <div class="max-w-3xl mx-auto w-full relative z-10">
            <div class="glass md:rounded-3xl p-6 md:p-10 shadow-2xl shadow-slate-200/60 border border-white fade-in" style="animation-delay: 0.1s;">
                <form id="trip-generator-form" class="space-y-8">
                    <!-- Travel Type Preferences -->
                    <div>
                        <label class="block text-base font-bold text-slate-900 mb-4">What's your vibe?</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach(['Adventure', 'Luxury', 'Relaxation', 'Culture'] as $type)
                            <label class="relative flex cursor-pointer group">
                                <input type="radio" name="travel_type" value="{{ strtolower($type) }}" class="peer sr-only" {{ $loop->first ? 'checked' : '' }}>
                                <div class="w-full text-center py-4 px-3 rounded-2xl border-2 border-slate-100 bg-white group-hover:bg-slate-50 peer-checked:border-primary-500 peer-checked:bg-primary-50 peer-checked:text-primary-700 transition-all duration-200 text-slate-600 font-semibold shadow-sm">
                                    {{ $type }}
                                </div>
                                <div class="absolute inset-0 border-2 border-transparent peer-focus-visible:border-primary-500 rounded-2xl pointer-events-none"></div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Budget Input -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-2">Budget per person ($)</label>
                            <x-input type="number" id="budget" name="budget" placeholder="e.g. 1500" required>
                                <x-slot name="icon">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </x-slot>
                            </x-input>
                        </div>

                        <!-- Duration -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-2">Duration (Days)</label>
                            <x-input type="number" id="duration" name="duration" placeholder="e.g. 7" min="1" max="30" required>
                                <x-slot name="icon">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </x-slot>
                            </x-input>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4 flex flex-col md:flex-row items-center justify-between gap-4">
                        <p class="text-sm text-slate-500 order-2 md:order-1 font-medium"><span class="w-2 h-2 inline-block rounded-full bg-green-500 mr-2 animate-pulse"></span>Live generation</p>
                        <x-button type="submit" variant="accent" class="w-full md:w-auto text-base px-8 py-3.5 group order-1 md:order-2">
                            <span id="btn-text">Generate My Trip</span>
                            <svg id="btn-icon" class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            <!-- Spinner (hidden by default) -->
                            <svg id="btn-spinner" class="ml-2 w-5 h-5 animate-spin hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </x-button>
                    </div>
                </form>

                <!-- Loading State / Skeleton (hidden by default) -->
                <div id="loading-state" class="hidden mt-8 pt-8 border-t border-slate-100 flex-col items-center justify-center space-y-5">
                    <div class="relative w-16 h-16">
                        <div class="absolute inset-0 rounded-full border-4 border-slate-100"></div>
                        <div class="absolute inset-0 rounded-full border-4 border-primary-500 border-t-transparent animate-spin"></div>
                        <div class="absolute inset-0 flex items-center justify-center text-primary-500">
                             <svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="text-slate-900 font-bold text-lg animate-pulse" id="loading-text">Analyzing your preferences...</p>
                        <p class="text-sm text-slate-500 mt-1">Our AI is doing the heavy lifting</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('trip-generator-form');
        const submitBtn = form.querySelector('button[type="submit"]');
        const btnText = document.getElementById('btn-text');
        const btnIcon = document.getElementById('btn-icon');
        const btnSpinner = document.getElementById('btn-spinner');
        const loadingState = document.getElementById('loading-state');
        const loadingText = document.getElementById('loading-text');

        const loadingMessages = [
            'Analyzing your preferences...',
            'Scouring the globe for hidden gems...',
            'Curating premium accommodations...',
            'Optimizing best flight paths...',
            'Finalizing your perfect itinerary...'
        ];

        form.addEventListener('submit', (e) => {
            e.preventDefault();

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            // UI State change
            // Animate form elements out slightly
            const formElements = form.querySelectorAll('div > label, .grid, .pt-4');
            formElements.forEach(el => {
                el.style.opacity = '0.5';
                el.style.pointerEvents = 'none';
            });

            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-90', 'cursor-not-allowed');
            btnText.textContent = 'Generating...';
            btnIcon.classList.add('hidden');
            btnSpinner.classList.remove('hidden');
            
            loadingState.classList.remove('hidden');
            loadingState.classList.add('flex', 'fade-in');

            // Cycle loading texts
            let messageIndex = 0;
            const messageInterval = setInterval(() => {
                messageIndex = (messageIndex + 1) % loadingMessages.length;
                
                // Add a small fade out/in effect to text
                loadingText.style.opacity = '0';
                setTimeout(() => {
                    loadingText.textContent = loadingMessages[messageIndex];
                    loadingText.style.opacity = '1';
                }, 200);

            }, 1200);

            loadingText.style.transition = 'opacity 0.2sease-in-out';

            // Simulate API Call Time
            setTimeout(() => {
                clearInterval(messageInterval);
                const formData = new FormData(form);
                const params = new URLSearchParams(formData).toString();
                
                // Redirect to results page (add /results to web.php route in Laravel)
                window.location.href = `/results?${params}`;
            }, 5500); 
        });
    });
</script>
@endsection
