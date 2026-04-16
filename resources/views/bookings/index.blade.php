@extends('layouts.app')

@section('content')
<div class="relative w-full overflow-hidden min-h-screen pt-20 pb-20 px-4 sm:px-6 lg:px-8">
    <!-- Background Elements -->
    <div class="absolute inset-0 -z-10 overflow-hidden">
        <div class="absolute top-20 right-20 w-96 h-96 bg-coral-500/10 rounded-full blur-3xl animate-drift-slow"></div>
        <div class="absolute bottom-40 left-10 w-80 h-80 bg-amber-500/10 rounded-full blur-3xl animate-drift-fast"></div>
    </div>

    <div class="max-w-7xl mx-auto w-full">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-16 animate-on-scroll slide-in-up">
            <div>
                <h1 class="text-5xl md:text-6xl font-display font-black text-white mb-4">
                    Your <span class="gradient-text">Collection</span>
                </h1>
                <p class="text-lg text-gray-400 max-w-2xl font-jakarta">
                    A gallery of your past explorations and upcoming adventures curated by Nomado.
                </p>
            </div>

            @auth
            <a href="{{ route('trip.index') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-coral-500 to-amber-500 text-navy-900 font-jakarta font-bold rounded-xl hover:shadow-lg hover:shadow-coral-500/50 hover:-translate-y-1 transition-all group overflow-hidden relative">
                <span class="relative z-10 flex items-center gap-2">
                    <svg class="w-5 h-5 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    New Journey
                </span>
            </a>
            @endauth
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-10 glass rounded-2xl p-6 flex items-center gap-4 animate-on-scroll fade-in border border-green-500/20">
            <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="text-green-400 font-jakarta font-semibold">{{ session('success') }}</span>
        </div>
        @endif

        <!-- Empty State -->
        @if($bookings->isEmpty())
        <div class="text-center py-24 animate-on-scroll fade-in">
            <div class="glass rounded-3xl p-16 border border-white/10 max-w-2xl mx-auto">
                <div class="w-32 h-32 bg-gradient-to-br from-coral-500/20 to-amber-500/20 rounded-3xl flex items-center justify-center text-coral-400 mx-auto mb-8">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                </div>
                <h3 class="text-3xl font-display font-black text-white mb-3">Your Gallery is Empty</h3>
                <p class="text-gray-400 font-jakarta mb-8 text-lg">Ready to discover your next favorite place? Generate your first personalized trip now.</p>
                <a href="{{ route('trip.index') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-coral-500 to-amber-500 text-navy-900 font-jakarta font-bold rounded-xl hover:shadow-lg hover:shadow-coral-500/50 transition-all group">
                    <span class="flex items-center gap-2">
                        Launch Generator
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </span>
                </a>
            </div>
        </div>

        @else
        <!-- Bookings Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($bookings as $index => $booking)
            <div class="group glass-dark rounded-2xl overflow-hidden shadow-2xl hover:shadow-2xl hover:shadow-coral-500/30 transition-all duration-500 transform hover:-translate-y-2 hover:scale-105 animate-on-scroll slide-in-up border border-white/10 h-full flex flex-col" style="animation-delay: {{ $index * 0.1 }}s;">
                <!-- Image Header with Film Strip Effect -->
                <div class="relative h-64 overflow-hidden">
                    <!-- Status Badge -->
                    <div class="absolute top-4 right-4 z-10">
                        @if($booking->status === 'paid')
                        <div class="bg-green-500/90 backdrop-blur px-4 py-2 rounded-full flex items-center gap-2 animate-pulse-slow">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="stroke-dasharray: 24; stroke-dashoffset: 0; animation: checkmarkDraw 0.6s ease-out forwards;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-xs font-jakarta font-black text-white uppercase tracking-wide">Confirmed</span>
                        </div>
                        @else
                        <div class="bg-amber-500/90 backdrop-blur px-4 py-2 rounded-full flex items-center gap-2 animate-pulse">
                            <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                            <span class="text-xs font-jakarta font-black text-white uppercase tracking-wide">Pending</span>
                        </div>
                        @endif
                    </div>

                    <!-- Image with Parallax -->
                    <img src="{{ $booking->city->image ?? 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&h=400' }}" alt="{{ $booking->city->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-navy-900/90 via-navy-900/40 to-transparent"></div>

                    <!-- Overlay Content -->
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white z-10">
                        <p class="text-xs font-jakarta font-bold uppercase tracking-[0.15em] text-coral-400 mb-2 opacity-90">{{ $booking->trip_type }} Trip</p>
                        <h3 class="text-3xl font-display font-black tracking-tight">{{ $booking->city->name }}</h3>
                    </div>
                </div>

                <!-- Card Content -->
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <!-- Details Grid -->
                    <div class="mb-8 space-y-4">
                        <div class="flex items-center gap-6">
                            <!-- Duration -->
                            <div class="flex-1">
                                <p class="text-xs font-jakarta font-bold uppercase tracking-widest text-gray-500 mb-1">Duration</p>
                                <p class="text-white font-jakarta font-bold flex items-center text-lg">
                                    <svg class="w-5 h-5 mr-2 text-coral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $booking->duration }} Nights
                                </p>
                            </div>

                            <div class="w-px h-12 bg-white/10"></div>

                            <!-- Passengers -->
                            <div class="flex-1">
                                <p class="text-xs font-jakarta font-bold uppercase tracking-widest text-gray-500 mb-1">Passengers</p>
                                <p class="text-white font-jakarta font-bold flex items-center text-lg">
                                    <svg class="w-5 h-5 mr-2 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    {{ $booking->passengers }}
                                </p>
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="flex items-center gap-2 text-gray-300 font-jakarta">
                            <svg class="w-4 h-4 text-coral-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            <span class="text-sm">{{ $booking->city->country->name ?? 'Global' }}</span>
                        </div>
                    </div>

                    <!-- Bottom Section -->
                    <div class="border-t border-white/10 pt-6 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-jakarta font-bold uppercase tracking-widest text-gray-500 mb-1">Total Budget</p>
                            <div class="text-2xl font-display font-black gradient-text">
                                €{{ number_format($booking->total_price, 2) }}
                            </div>
                        </div>
                        <a href="{{ route('bookings.show', $booking->id) }}" class="w-12 h-12 rounded-xl bg-gradient-to-br from-coral-500/20 to-amber-500/20 border border-coral-500/30 flex items-center justify-center text-coral-400 hover:bg-coral-500 hover:text-white hover:border-coral-500 transition-all transform hover:rotate-45 duration-300 group/arrow">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </a>
                    </div>
                </div>

                <!-- Shimmer effect on hover -->
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-1000 pointer-events-none animate-shimmer" style="background-size: 200% 100%;"></div>
            </div>
            @endforeach
        </div>

        <!-- Pagination if needed -->
        @if(method_exists($bookings, 'links'))
        <div class="mt-16 flex justify-center">
            {{ $bookings->links() }}
        </div>
        @endif
        @endif
    </div>
</div>

<style>
    @keyframes checkmarkDraw {
        from {
            stroke-dashoffset: 24;
        }
        to {
            stroke-dashoffset: 0;
        }
    }

    @keyframes pulse-slow {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.7;
        }
    }

    .animate-pulse-slow {
        animation: pulse-slow 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
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
@endsection
