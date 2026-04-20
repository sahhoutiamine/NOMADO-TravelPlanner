@extends('layouts.app')

@section('content')
<div class="min-h-screen py-12 md:py-20 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto w-full">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12 animate-on-scroll fade-in">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight mb-2">My Trips</h1>
                <p class="text-gray-500">A collection of your past explorations and upcoming adventures.</p>
            </div>

            @auth
            <a href="{{ route('trip.index') }}" class="inline-flex items-center px-5 py-2.5 bg-gray-900 hover:bg-primary-600 text-white font-semibold text-sm rounded-xl transition-colors gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                New Journey
            </a>
            @endauth
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-8 bg-green-50 border border-green-100 text-green-700 px-5 py-4 rounded-xl flex items-center gap-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-medium text-sm">{{ session('success') }}</span>
        </div>
        @endif

        <!-- Empty State -->
        @if($bookings->isEmpty())
        <div class="text-center py-20">
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-16 max-w-lg mx-auto animate-on-scroll fade-in">
                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-6 floating-icon">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">No trips yet</h3>
                <p class="text-gray-500 mb-8">Start planning your first adventure</p>
                <a href="{{ route('trip.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-900 hover:bg-primary-600 text-white font-semibold rounded-xl transition-colors gap-2">
                    Launch Generator
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>

        @else
        <!-- Bookings Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($bookings as $index => $booking)
            <div class="bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1 h-full flex flex-col animate-on-scroll slide-in-up" style="animation-delay: {{ 0.1 * ($index + 1) }}s;">
                <!-- Image Header -->
                <div class="relative h-52 overflow-hidden">
                    <!-- Status Badge -->
                    <div class="absolute top-4 right-4 z-10">
                        @if($booking->status === 'paid')
                        <span class="bg-green-100 text-green-700 border border-green-200 px-3 py-1.5 rounded-lg flex items-center gap-1.5 text-xs font-bold status-badge-confirmed">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Confirmed
                        </span>
                        @else
                        <span class="bg-amber-100 text-amber-700 border border-amber-200 px-3 py-1.5 rounded-lg flex items-center gap-1.5 text-xs font-bold status-badge-pending">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 status-dot"></span>
                            Pending
                        </span>
                        @endif
                    </div>

                    <!-- Image -->
                    <img src="{{ $booking->city->image ?? 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&h=400' }}" alt="{{ $booking->city->name }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>

                    <!-- Overlay Content -->
                    <div class="absolute bottom-0 left-0 right-0 p-5 text-white z-10">
                        <p class="text-xs font-semibold uppercase tracking-wider text-white/70 mb-1">{{ $booking->trip_type }} Trip</p>
                        <h3 class="text-2xl font-bold tracking-tight">{{ $booking->city->name }}</h3>
                    </div>
                </div>

                <!-- Card Content -->
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <!-- Details -->
                    <div class="mb-5 space-y-3">
                        <div class="flex items-center gap-4">
                            <div class="flex-1">
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-400 mb-0.5">Duration</p>
                                <p class="text-gray-900 font-semibold flex items-center text-sm">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $booking->duration }} Nights
                                </p>
                            </div>

                            <div class="w-px h-10 bg-gray-100"></div>

                            <div class="flex-1">
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-400 mb-0.5">Travelers</p>
                                <p class="text-gray-900 font-semibold flex items-center text-sm">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    {{ $booking->passengers }}
                                </p>
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="flex items-center gap-2 text-gray-500 text-sm">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            {{ $booking->city->country->name ?? 'Global' }}
                        </div>
                    </div>

                    <!-- Bottom Section -->
                    <div class="border-t border-gray-100 pt-4 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-400 mb-0.5">Total Budget</p>
                            <div class="text-xl font-bold text-gray-900">
                                &euro;{{ number_format($booking->total_price, 2) }}
                            </div>
                        </div>
                        <a href="{{ route('bookings.show', $booking->id) }}" class="w-10 h-10 rounded-xl bg-gray-100 border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-primary-600 hover:text-white hover:border-primary-600 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination if needed -->
        @if(method_exists($bookings, 'links'))
        <div class="mt-12 flex justify-center">
            {{ $bookings->links() }}
        </div>
        @endif
        @endif
    </div>
</div>

<style>
    .floating-icon {
        animation: floatingEmptyState 3s ease-in-out infinite;
    }

    @keyframes floatingEmptyState {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    .status-badge-confirmed {
        box-shadow: 0 0 20px rgba(34, 197, 94, 0.3);
    }

    .status-dot {
        display: inline-block;
        animation: blinkPending 1.5s ease-in-out infinite;
    }

    @keyframes blinkPending {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.4; }
    }

    @media (prefers-reduced-motion: reduce) {
        .floating-icon, .status-dot {
            animation: none;
            transform: none;
            opacity: 1;
        }
    }
</style>
@endsection
