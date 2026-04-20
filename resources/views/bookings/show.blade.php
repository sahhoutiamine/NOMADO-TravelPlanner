@extends('layouts.app')

@section('content')
<div class="min-h-screen py-12 md:py-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Context Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-6 animate-on-scroll fade-in">
            <div class="flex items-center gap-4">
                <a href="{{ route('bookings.index') }}" class="w-10 h-10 rounded-lg bg-white border border-gray-200 flex items-center justify-center text-gray-500 hover:text-primary-600 transition-all hover:shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Booking #NOM-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</h1>
                    <p class="text-gray-500 text-sm">{{ $booking->created_at->format('M d, Y') }}</p>
                </div>
            </div>

            <span class="px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-wider w-fit {{ $booking->status === 'paid' ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-amber-100 text-amber-700 border border-amber-200' }}">
                {{ $booking->status === 'paid' ? 'Confirmed' : 'Payment Pending' }}
            </span>
        </div>

        @if(session('success'))
            <div class="mb-8 bg-green-50 border border-green-100 text-green-700 px-5 py-4 rounded-xl flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-medium text-sm">{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Main Content (8 cols) -->
            <div class="lg:col-span-8 space-y-8">

                <!-- Hero Card -->
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-200 animate-on-scroll">
                    <div class="h-72 relative overflow-hidden ken-burns-container">
                        <img src="{{ $booking->city->image ?? 'https://images.unsplash.com/photo-1488646953014-c8c32bc611ee' }}" class="w-full h-full object-cover ken-burns-image">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                        <div class="absolute bottom-6 left-6">
                            <span class="bg-primary-600 text-white text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded-lg mb-2 inline-block">Recommended Destination</span>
                            <h2 class="text-3xl md:text-4xl font-bold text-white tracking-tight">{{ $booking->city->name }}</h2>
                            <p class="text-white/80 font-medium mt-1 flex items-center text-sm">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                                {{ $booking->city->country->name ?? 'International' }}
                            </p>
                        </div>
                    </div>
                    <div class="p-8">
                        <p class="text-gray-600 leading-relaxed italic">"{{ $booking->city->description }}"</p>
                    </div>
                </div>

                <!-- Accommodation Section -->
                <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-200 animate-on-scroll slide-in-left">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-primary-50 flex items-center justify-center text-primary-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Accommodation</h3>
                        </div>
                        <a href="{{ route('hotels.show', $booking->hotel->id) }}" class="text-primary-600 font-semibold text-sm hover:underline flex items-center gap-1">
                            Full Profile <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>

                    <div class="flex flex-col md:flex-row gap-6 items-start">
                        <div class="w-full md:w-2/5 aspect-[4/3] rounded-xl overflow-hidden border border-gray-100">
                            <img src="{{ $booking->hotel->image ?? 'https://images.unsplash.com/photo-1566073771259-6a8506099945' }}" class="w-full h-full object-cover">
                        </div>
                        <div class="w-full md:w-3/5">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="flex text-amber-400">
                                    @for($i = 0; $i < 5; $i++)
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    @endfor
                                </div>
                                <span class="bg-amber-50 text-amber-700 text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded border border-amber-100">Top Rated</span>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-3">{{ $booking->hotel->name }}</h4>
                            <p class="text-gray-500 leading-relaxed mb-5 text-sm">{{ $booking->hotel->description }}</p>

                            <div class="grid grid-cols-2 gap-3">
                                <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-0.5">Per Night</p>
                                    <p class="text-lg font-bold text-gray-900">{{ number_format($booking->hotel->price_per_night, 2) }} &euro;</p>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-0.5">Total Stay</p>
                                    <p class="text-lg font-bold text-primary-600">{{ number_format($booking->hotel_budget, 2) }} &euro;</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Points of Interest -->
                <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-200 animate-on-scroll">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-lg bg-primary-50 flex items-center justify-center text-primary-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Attractions</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($booking->city->places as $index => $place)
                            <div class="group/place bg-white rounded-xl p-4 border border-gray-200 hover:shadow-md hover:border-primary-200 transition-all flex gap-4 animate-on-scroll fade-in" style="animation-delay: {{ 0.05 * ($index + 1) }}s;">
                                <div class="w-20 h-20 rounded-lg overflow-hidden shrink-0 border border-gray-100">
                                    <img src="{{ $place->image }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex flex-col justify-center min-w-0">
                                    <h4 class="font-bold text-gray-900 group-hover/place:text-primary-600 transition-colors truncate">{{ $place->name }}</h4>
                                    <p class="text-xs text-gray-500 mt-0.5 line-clamp-2">{{ $place->description }}</p>
                                    <a href="{{ route('places.show', $place->id) }}?booking_id={{ $booking->id }}" class="text-[10px] font-bold text-primary-600 uppercase tracking-wider mt-1.5 hover:underline">Explore More</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- Sidebar Summary (4 cols) -->
            <div class="lg:col-span-4 space-y-6 animate-on-scroll slide-in-right">

                <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-200 lg:sticky lg:top-24">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <span class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center text-gray-600 mr-3 border border-gray-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </span>
                        Budget
                    </h3>

                    <div class="space-y-5 mb-8">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Accommodation</p>
                                <p class="text-[10px] text-gray-400">Total duration stay</p>
                            </div>
                            <span class="text-base font-bold text-gray-900">{{ number_format($booking->hotel_budget, 2) }} &euro;</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Experience Fund</p>
                                <p class="text-[10px] text-gray-400">Suggested for activities</p>
                            </div>
                            <span class="text-base font-bold text-gray-900">{{ number_format($booking->activities_budget, 2) }} &euro;</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Miscellaneous</p>
                                <p class="text-[10px] text-gray-400">Backup and daily needs</p>
                            </div>
                            <span class="text-base font-bold text-gray-900">{{ number_format($booking->misc_budget, 2) }} &euro;</span>
                        </div>
                    </div>

                    <!-- Grand Total -->
                    <div class="bg-gray-900 rounded-xl py-4 px-6 text-center mb-6">
                        <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Grand Total</div>
                        <div class="text-3xl font-bold text-white"><span class="trip-total" data-target="{{ $booking->total_price }}">0</span>€</div>
                        <p class="text-[10px] text-gray-400 mt-1.5 font-medium uppercase tracking-wider">All Taxes & Fees Included</p>
                    </div>

                    <!-- Actions -->
                    <div class="space-y-3">
                        @if($booking->status === 'pending')
                            <form action="{{ route('bookings.pay', $booking->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-xl font-semibold text-sm transition-colors flex items-center justify-center gap-2 submit-shimmer">
                                    Secure Payment
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                </button>
                            </form>
                            <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Archive this booking?');" class="w-full py-2.5 text-gray-500 text-xs font-bold uppercase tracking-wider hover:text-red-500 transition-colors border border-gray-200 rounded-lg hover:border-red-200">
                                    Archive
                                </button>
                            </form>
                        @else
                            <div class="py-5 bg-green-50 rounded-xl border border-green-200 text-center booking-confirmed-box">
                                <svg class="w-7 h-7 text-green-600 mx-auto mb-2 checkmark-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="text-green-700 font-semibold">Booking Confirmed</p>
                                <p class="text-gray-500 text-xs mt-1">Your journey is reserved</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<style>
    .ken-burns-container {
        overflow: hidden;
    }

    .ken-burns-image {
        animation: kenBurns 8s ease-in-out infinite;
        transform-origin: center;
    }

    @keyframes kenBurns {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
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

    .booking-confirmed-box {
        animation: slideInConfirm 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes slideInConfirm {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .checkmark-icon {
        animation: checkmarkDraw 0.6s ease-out forwards;
        stroke-dasharray: 60;
        stroke-dashoffset: 60;
    }

    @keyframes checkmarkDraw {
        to {
            stroke-dashoffset: 0;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .ken-burns-image, .submit-shimmer:hover, .booking-confirmed-box, .checkmark-icon {
            animation: none;
            transform: none;
            stroke-dashoffset: 0;
            opacity: 1;
        }
    }
</style>

<script>
    // Animate grand total numbers on load
    setTimeout(() => {
        const totalEl = document.querySelector('.trip-total');
        if (totalEl) {
            const target = parseInt(totalEl.getAttribute('data-target'));
            let current = 0;
            const increment = target / 40;
            const interval = setInterval(() => {
                current += increment;
                if (current > target) {
                    totalEl.textContent = target.toLocaleString();
                    clearInterval(interval);
                } else {
                    totalEl.textContent = Math.floor(current).toLocaleString();
                }
            }, 20);
        }
    }, 300);
</script>
@endsection
