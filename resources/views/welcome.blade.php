@extends('layouts.app')

@section('content')
<div class="relative w-full overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 -z-10 overflow-hidden">
        <!-- Gradient background -->
        <div class="absolute inset-0 bg-gradient-to-br from-navy-600 via-navy-700 to-navy-900"></div>

        <!-- Floating orbs -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-coral-500/20 rounded-full blur-3xl animate-drift-slow"></div>
        <div class="absolute top-40 right-20 w-96 h-96 bg-amber-500/15 rounded-full blur-3xl animate-drift-fast"></div>
        <div class="absolute bottom-20 left-1/3 w-80 h-80 bg-blue-500/10 rounded-full blur-3xl animate-drift-slow" style="animation-delay: 2s;"></div>

        <!-- Grid pattern -->
        <div class="absolute inset-0 opacity-5" style="background-image: url('data:image/svg+xml,<svg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"><g fill=\"none\" fill-rule=\"evenodd\"><g fill=\"%23ffffff\" fill-opacity=\"0.1\"><path d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/></g></g></svg>'); background-size: 30px 30px;"></div>
    </div>

    <!-- ===== HERO SECTION ===== -->
    <section class="relative min-h-screen flex items-center justify-center pt-20 pb-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto w-full">
            <!-- Hero Content -->
            <div class="text-center mb-20 animate-on-scroll slide-in-up">
                <!-- Badge -->
                <div class="inline-block mb-8">
                    <div class="glass px-6 py-2 rounded-full flex items-center gap-2 justify-center">
                        <span class="flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full bg-coral-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-coral-500"></span>
                        </span>
                        <span class="text-sm font-jakarta font-semibold bg-gradient-text">AI-Powered Travel Generation</span>
                    </div>
                </div>

                <!-- Main Heading -->
                <h1 class="text-5xl md:text-7xl font-display font-black tracking-tight mb-8 leading-tight text-white">
                    Your perfect trip,
                    <br />
                    <span class="gradient-text">generated in seconds</span>
                </h1>

                <!-- Typewriter Tagline -->
                <div class="mb-12 h-12 flex items-center justify-center">
                    <div class="text-xl md:text-2xl font-jakarta font-semibold text-gray-300">
                        For <span id="typewriter-text" class="text-coral-400"></span>
                    </div>
                </div>

                <!-- Description -->
                <p class="text-lg md:text-xl text-gray-400 max-w-3xl mx-auto mb-12 leading-relaxed font-jakarta">
                    Tell our AI engine what moves you—adventure, luxury, culture, or romance—and get a complete, personalized itinerary with destination, hotel, flights, and budget breakdown in moments. No endless searching. Pure inspiration.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center md:justify-center">
                    @auth
                        <a href="{{ route('trip.index') }}" class="btn-primary text-lg px-10 py-4 flex items-center gap-2 group animate-glow">
                            <span>Launch Generator</span>
                            <svg class="w-6 h-6 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn-primary text-lg px-10 py-4 flex items-center gap-2 group animate-glow">
                            <span>Start Exploring</span>
                            <svg class="w-6 h-6 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </a>
                        <a href="{{ route('login') }}" class="btn-secondary text-lg px-10 py-4">
                            Sign In
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Floating Destination Cards -->
            <div class="relative h-96 md:h-[500px] flex items-center justify-center animate-on-scroll">
                <!-- Card 1 - Top Left -->
                <div class="absolute top-0 left-0 md:top-10 md:left-20 w-48 md:w-56 h-64 md:h-72 rounded-3xl overflow-hidden shadow-2xl transform hover:scale-105 transition-transform duration-500 animate-float" style="animation-delay: 0s;">
                    <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=600" alt="Mountain Adventure" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent flex items-end p-6">
                        <div>
                            <p class="text-xs font-jakarta font-semibold text-coral-400 uppercase tracking-wider mb-1">Adventure</p>
                            <h3 class="text-2xl font-display font-black text-white">Swiss Alps</h3>
                        </div>
                    </div>
                </div>

                <!-- Card 2 - Center -->
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-56 md:w-64 h-72 md:h-80 rounded-3xl overflow-hidden shadow-2xl shadow-coral-500/30 transform hover:scale-105 transition-transform duration-500 z-10 animate-float" style="animation-delay: 0.5s;">
                    <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=550&h=700" alt="Cultural Journey" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent flex items-end p-6">
                        <div>
                            <p class="text-xs font-jakarta font-semibold text-amber-400 uppercase tracking-wider mb-1">Culture</p>
                            <h3 class="text-3xl font-display font-black text-white">Tokyo</h3>
                        </div>
                    </div>
                </div>

                <!-- Card 3 - Bottom Right -->
                <div class="absolute bottom-0 right-0 md:bottom-10 md:right-20 w-48 md:w-56 h-64 md:h-72 rounded-3xl overflow-hidden shadow-2xl transform hover:scale-105 transition-transform duration-500 animate-float" style="animation-delay: 1s;">
                    <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=600" alt="Beach Relaxation" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent flex items-end p-6">
                        <div>
                            <p class="text-xs font-jakarta font-semibold text-blue-400 uppercase tracking-wider mb-1">Relaxation</p>
                            <h3 class="text-2xl font-display font-black text-white">Maldives</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== HOW IT WORKS ===== -->
    <section class="relative py-24 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <!-- Section Header -->
            <div class="text-center mb-20 animate-on-scroll fade-in">
                <h2 class="text-4xl md:text-5xl font-display font-black text-white mb-6">How It Works</h2>
                <p class="text-lg text-gray-400 max-w-2xl mx-auto">Three simple steps to your dream vacation</p>
            </div>

            <!-- Steps Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- Step 1 -->
                <div class="group animate-on-scroll slide-in-up" style="animation-delay: 0.1s;">
                    <div class="mb-8 relative h-20 w-20">
                        <div class="absolute inset-0 bg-gradient-to-br from-coral-500 to-amber-500 rounded-2xl transform group-hover:scale-110 transition-transform duration-500"></div>
                        <div class="absolute inset-1 bg-navy-600 rounded-xl flex items-center justify-center">
                            <span class="text-3xl font-display font-black text-coral-400">1</span>
                        </div>
                    </div>
                    <h3 class="text-2xl font-jakarta font-bold text-white mb-3">Tell Us Your Vibe</h3>
                    <p class="text-gray-400 leading-relaxed">Choose your travel style—adventure, luxury, culture, or relaxation—set your budget and duration, and let's get started.</p>
                    <div class="mt-6 flex gap-2">
                        <div class="w-2 h-2 rounded-full bg-coral-500"></div>
                        <div class="w-2 h-2 rounded-full bg-coral-500/40"></div>
                        <div class="w-2 h-2 rounded-full bg-coral-500/20"></div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="group animate-on-scroll slide-in-up" style="animation-delay: 0.2s;">
                    <div class="mb-8 relative h-20 w-20">
                        <div class="absolute inset-0 bg-gradient-to-br from-coral-500 to-amber-500 rounded-2xl transform group-hover:scale-110 transition-transform duration-500"></div>
                        <div class="absolute inset-1 bg-navy-600 rounded-xl flex items-center justify-center">
                            <span class="text-3xl font-display font-black text-coral-400">2</span>
                        </div>
                    </div>
                    <h3 class="text-2xl font-jakarta font-bold text-white mb-3">AI Analyzes & Creates</h3>
                    <p class="text-gray-400 leading-relaxed">Our intelligent engine analyzes thousands of options and curates 3 personalized itineraries with handpicked destinations, hotels, and flights.</p>
                    <div class="mt-6 flex gap-2">
                        <div class="w-2 h-2 rounded-full bg-coral-500"></div>
                        <div class="w-2 h-2 rounded-full bg-coral-500"></div>
                        <div class="w-2 h-2 rounded-full bg-coral-500/20"></div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="group animate-on-scroll slide-in-up" style="animation-delay: 0.3s;">
                    <div class="mb-8 relative h-20 w-20">
                        <div class="absolute inset-0 bg-gradient-to-br from-coral-500 to-amber-500 rounded-2xl transform group-hover:scale-110 transition-transform duration-500"></div>
                        <div class="absolute inset-1 bg-navy-600 rounded-xl flex items-center justify-center">
                            <span class="text-3xl font-display font-black text-coral-400">3</span>
                        </div>
                    </div>
                    <h3 class="text-2xl font-jakarta font-bold text-white mb-3">Confirm & Go</h3>
                    <p class="text-gray-400 leading-relaxed">Review your options, pick your favorite, and confirm your booking. Your complete itinerary is ready for your adventure.</p>
                    <div class="mt-6 flex gap-2">
                        <div class="w-2 h-2 rounded-full bg-coral-500"></div>
                        <div class="w-2 h-2 rounded-full bg-coral-500"></div>
                        <div class="w-2 h-2 rounded-full bg-coral-500"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== STATS SECTION ===== -->
    <section class="relative py-24 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <div class="glass rounded-3xl p-12 md:p-16">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-12 text-center">
                    <!-- Stat 1 -->
                    <div class="animate-on-scroll fade-in" style="animation-delay: 0.1s;">
                        <div class="text-5xl md:text-6xl font-display font-black gradient-text mb-2">
                            <span class="stat-counter" data-target="250">0</span>+
                        </div>
                        <p class="text-gray-400 font-jakarta">Destinations Covered</p>
                    </div>

                    <!-- Stat 2 -->
                    <div class="animate-on-scroll fade-in" style="animation-delay: 0.2s;">
                        <div class="text-5xl md:text-6xl font-display font-black gradient-text mb-2">
                            <span class="stat-counter" data-target="1200">0</span>+
                        </div>
                        <p class="text-gray-400 font-jakarta">Luxury Hotels</p>
                    </div>

                    <!-- Stat 3 -->
                    <div class="animate-on-scroll fade-in" style="animation-delay: 0.3s;">
                        <div class="text-5xl md:text-6xl font-display font-black gradient-text mb-2">
                            <span class="stat-counter" data-target="50000">0</span>+
                        </div>
                        <p class="text-gray-400 font-jakarta">Trips Generated</p>
                    </div>

                    <!-- Stat 4 -->
                    <div class="animate-on-scroll fade-in" style="animation-delay: 0.4s;">
                        <div class="text-5xl md:text-6xl font-display font-black gradient-text mb-2">
                            <span class="stat-counter" data-target="98">0</span>%
                        </div>
                        <p class="text-gray-400 font-jakarta">User Satisfaction</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== FEATURES SECTION ===== -->
    <section class="relative py-24 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-20 animate-on-scroll fade-in">
                <h2 class="text-4xl md:text-5xl font-display font-black text-white mb-6">Why Choose Nomado</h2>
                <p class="text-lg text-gray-400 max-w-2xl mx-auto">Everything you need for the perfect trip, powered by AI</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="group glass rounded-2xl p-8 hover:bg-white/12 transition-all duration-500 animate-on-scroll slide-in-up" style="animation-delay: 0.1s;">
                    <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-coral-500 to-amber-500 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-navy-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-xl font-jakarta font-bold text-white mb-2">Lightning Fast</h3>
                    <p class="text-gray-400 text-sm">Get your personalized itinerary in seconds, not hours.</p>
                </div>

                <!-- Feature 2 -->
                <div class="group glass rounded-2xl p-8 hover:bg-white/12 transition-all duration-500 animate-on-scroll slide-in-up" style="animation-delay: 0.2s;">
                    <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-coral-500 to-amber-500 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-navy-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-jakarta font-bold text-white mb-2">Budget-Friendly</h3>
                    <p class="text-gray-400 text-sm">Full transparency with no hidden fees. Know exactly what you're paying for.</p>
                </div>

                <!-- Feature 3 -->
                <div class="group glass rounded-2xl p-8 hover:bg-white/12 transition-all duration-500 animate-on-scroll slide-in-up" style="animation-delay: 0.3s;">
                    <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-coral-500 to-amber-500 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-navy-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-jakarta font-bold text-white mb-2">Fully Personalized</h3>
                    <p class="text-gray-400 text-sm">AI learns your preferences and creates trips tailored just for you.</p>
                </div>

                <!-- Feature 4 -->
                <div class="group glass rounded-2xl p-8 hover:bg-white/12 transition-all duration-500 animate-on-scroll slide-in-up" style="animation-delay: 0.4s;">
                    <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-coral-500 to-amber-500 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-navy-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-jakarta font-bold text-white mb-2">Expert Curation</h3>
                    <p class="text-gray-400 text-sm">Hand-picked hotels and destinations from verified, top-rated providers.</p>
                </div>

                <!-- Feature 5 -->
                <div class="group glass rounded-2xl p-8 hover:bg-white/12 transition-all duration-500 animate-on-scroll slide-in-up" style="animation-delay: 0.5s;">
                    <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-coral-500 to-amber-500 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-navy-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <h3 class="text-xl font-jakarta font-bold text-white mb-2">Secure Booking</h3>
                    <p class="text-gray-400 text-sm">Your data is encrypted and secure. Travel with peace of mind.</p>
                </div>

                <!-- Feature 6 -->
                <div class="group glass rounded-2xl p-8 hover:bg-white/12 transition-all duration-500 animate-on-scroll slide-in-up" style="animation-delay: 0.6s;">
                    <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-coral-500 to-amber-500 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-navy-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-jakarta font-bold text-white mb-2">24/7 Support</h3>
                    <p class="text-gray-400 text-sm">Our team is always here to help you with any questions or changes.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CTA SECTION ===== -->
    <section class="relative py-24 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="glass rounded-3xl p-12 md:p-20 text-center overflow-hidden relative animate-on-scroll fade-in">
                <div class="absolute top-0 right-0 w-96 h-96 bg-coral-500/10 rounded-full blur-3xl -mr-40 -mt-40"></div>
                <div class="relative z-10">
                    <h2 class="text-4xl md:text-5xl font-display font-black text-white mb-6">Ready to Explore?</h2>
                    <p class="text-lg text-gray-300 mb-10 max-w-2xl mx-auto">Join thousands of travelers who've discovered their perfect journey with Nomado.</p>

                    @auth
                        <a href="{{ route('trip.index') }}" class="btn-primary text-lg px-12 py-4 inline-block animate-glow">
                            Generate Your Trip Now
                        </a>
                    @else
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('register') }}" class="btn-primary text-lg px-12 py-4 inline-block animate-glow">
                                Get Started Free
                            </a>
                            <a href="{{ route('login') }}" class="btn-secondary text-lg px-12 py-4 inline-block">
                                Sign In
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    // Typewriter effect
    const typewriterText = document.getElementById('typewriter-text');
    const phrases = ['Adventure', 'Luxury', 'Culture', 'Romance', 'Exploration'];
    let phrasesIndex = 0;
    let charIndex = 0;
    let isDeleting = false;

    function typewriter() {
        const currentPhrase = phrases[phrasesIndex];

        if (!isDeleting && charIndex < currentPhrase.length) {
            typewriterText.textContent += currentPhrase[charIndex];
            charIndex++;
            setTimeout(typewriter, 80);
        } else if (isDeleting && charIndex > 0) {
            typewriterText.textContent = currentPhrase.substring(0, charIndex - 1);
            charIndex--;
            setTimeout(typewriter, 50);
        } else if (!isDeleting && charIndex === currentPhrase.length) {
            isDeleting = true;
            setTimeout(typewriter, 2000);
        } else if (isDeleting && charIndex === 0) {
            isDeleting = false;
            phrasesIndex = (phrasesIndex + 1) % phrases.length;
            setTimeout(typewriter, 500);
        }
    }

    typewriter();

    // Animated counters
    const observerOptions = {
        threshold: 0.3,
        rootMargin: '0px'
    };

    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const target = parseInt(counter.getAttribute('data-target'));
                const duration = 2000;
                const increment = target / (duration / 50);

                let current = 0;
                const updateCounter = () => {
                    current += increment;
                    if (current < target) {
                        counter.textContent = Math.floor(current);
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.textContent = target;
                    }
                };

                updateCounter();
                counterObserver.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('.stat-counter').forEach(el => {
        counterObserver.observe(el);
    });
</script>

<style>
    .animate-on-scroll {
        opacity: 0;
        animation-fill-mode: forwards;
    }

    .animate-on-scroll.scroll-visible {
        animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .animate-on-scroll.slide-in-up {
        animation: none;
    }

    .animate-on-scroll.slide-in-up.scroll-visible {
        animation: slideInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .animate-on-scroll.slide-in-left {
        animation: none;
    }

    .animate-on-scroll.slide-in-left.scroll-visible {
        animation: slideInLeft 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .animate-on-scroll.slide-in-right {
        animation: none;
    }

    .animate-on-scroll.slide-in-right.scroll-visible {
        animation: slideInRight 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .animate-on-scroll.fade-in {
        animation: none;
    }

    .animate-on-scroll.fade-in.scroll-visible {
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

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .animate-on-scroll {
            animation: none !important;
            opacity: 1;
        }
    }
</style>
@endsection
