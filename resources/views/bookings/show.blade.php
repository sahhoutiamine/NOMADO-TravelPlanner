@extends('layouts.app')

@section('content')
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.85);
        border: 1px solid rgba(255, 255, 255, 0.4);
    }
    .text-gradient {
        background: linear-gradient(to right, #0284c7, #6366f1);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .bg-gradient-primary {
        background: linear-gradient(135deg, #0284c7, #6366f1);
    }
    @keyframes slideRight {
        from { transform: translateX(-30px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideLeft {
        from { transform: translateX(30px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    .animate-slide-right {
        animation: slideRight 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    .animate-slide-left {
        animation: slideLeft 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    .budget-progress {
        width: 0;
        transition: width 1s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .hotel-scroll {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scroll-behavior: smooth;
    }
    .hotel-scroll::-webkit-scrollbar {
        height: 6px;
    }
    .hotel-scroll::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }
    .hotel-scroll::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    .hotel-card {
        flex-shrink: 0;
        min-w-max;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .hotel-card.selected {
        border-color: #0284c7;
        background: rgba(2, 132, 199, 0.05);
        box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
    }
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 26px;
    }
    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: 0.3s;
        border-radius: 26px;
    }
    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.3s;
        border-radius: 50%;
    }
    input:checked + .toggle-slider {
        background-color: #0284c7;
    }
    input:checked + .toggle-slider:before {
        transform: translateX(24px);
    }
    .place-checkbox {
        cursor: pointer;
    }
    .place-card {
        transition: all 0.3s ease;
    }
    .place-card label {
        cursor: pointer;
    }
    .flight-card {
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .flight-details-expand {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.5s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.4s ease;
        opacity: 0;
    }
    .flight-card.expanded .flight-details-expand {
        max-height: 500px;
        opacity: 1;
    }
    .flight-card.expanded {
        border-color: #0284c7;
        box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1);
    }
    .flight-class-option {
        transform: translateY(10px);
        opacity: 0;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .flight-card.expanded .flight-class-option {
        transform: translateY(0);
        opacity: 1;
    }
    .flight-card.expanded .flight-class-option:nth-child(1) { transition-delay: 0.1s; }
    .flight-card.expanded .flight-class-option:nth-child(2) { transition-delay: 0.2s; }
    .flight-card.expanded .flight-class-option:nth-child(3) { transition-delay: 0.3s; }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    .shake {
        animation: shake 0.2s ease-in-out 0s 2;
    }
    .budget-over {
        color: #ef4444 !important;
    }
</style>

<div class="flex-grow pt-32 pb-24 px-4 md:px-8 max-w-7xl mx-auto relative min-h-screen">
    <!-- Atmospheric Background Elements -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-1/4 -right-1/4 w-[800px] h-[800px] bg-primary-200/10 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-1/4 -left-1/4 w-[600px] h-[600px] bg-indigo-200/10 rounded-full blur-[100px]"></div>
    </div>

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 gap-6 relative z-10">
        <div class="animate-slide-right">
            <a class="flex items-center gap-2 text-primary-600 font-bold text-sm mb-4 hover:text-primary-700 transition-colors" href="{{ route('bookings.index') }}">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Back to My Trips
            </a>
            <h1 class="text-4xl md:text-5xl font-black tracking-tighter mb-2 text-slate-900">Trip <span class="text-gradient">#NOM-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span></h1>
            <p class="text-slate-500 text-lg font-medium">Booked on {{ $booking->created_at->format('M d, Y') }}</p>
        </div>
        
        <div class="animate-slide-left">
            <span class="px-6 py-2.5 rounded-lg text-xs font-black uppercase tracking-widest flex items-center gap-2 {{ $booking->status === 'paid' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-amber-50 text-amber-600 border border-amber-100' }}">
                <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">{{ $booking->status === 'paid' ? 'verified' : 'pending' }}</span>
                {{ $booking->status === 'paid' ? 'Confirmed' : 'Payment Pending' }}
            </span>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-10 animate-slide-right">
        <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-6 py-4 rounded-[1.5rem] flex items-center gap-3 font-bold text-sm shadow-sm shadow-emerald-100/50">
            <span class="material-symbols-outlined">check_circle</span>
            {{ session('success') }}
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- LEFT COLUMN: Destination Details -->
        <div class="lg:col-span-2 space-y-10 animate-slide-right">
            <!-- Hero Card -->
            <div class="relative rounded-xl overflow-hidden bg-slate-50 shadow-2xl border border-white/50 aspect-video group">
                <img src="{{ $booking->city->image ?? 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?q=80&w=1200' }}" 
                     alt="{{ $booking->city->name }}" class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-10 w-full">
                    <span class="px-4 py-1.5 bg-white/20 rounded-full text-[10px] font-black uppercase tracking-[0.2em] border border-white/30 mb-4 inline-block text-white">
                        {{ strtoupper($booking->trip_type ?? 'Adventure') }} TRIP
                    </span>
                    <h2 class="text-6xl font-black text-white tracking-tighter">{{ $booking->city->name }}</h2>
                    <div class="flex items-center gap-3 text-white/80 text-2xl font-bold">
                        <span>{{ $booking->city->country->name ?? 'Europe' }}</span>
                        @if($booking->departure_date)
                            <span class="w-2 h-2 rounded-full bg-white/40"></span>
                            <span class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-xl text-white">calendar_today</span>
                                @if($booking->status === 'pending')
                                    <input type="date" id="departure-date-input" 
                                           class="bg-white/10 border border-white/20 text-white font-bold text-lg rounded-lg px-3 py-1 focus:ring-2 focus:ring-white/50 outline-none backdrop-blur-sm"
                                           value="{{ $booking->departure_date->format('Y-m-d') }}"
                                           min="{{ date('Y-m-d', strtotime('tomorrow')) }}"
                                           onchange="updateTrip()">
                                @else
                                    <span class="text-white">{{ $booking->departure_date->format('M d, Y') }}</span>
                                @endif
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="glass-card p-10 rounded-xl border border-white/50 shadow-xl">
                <h3 class="text-2xl font-black mb-4 text-slate-900 tracking-tight">The Experience</h3>
                <div class="relative">
                    <p id="booking-description" class="text-slate-600 leading-relaxed text-lg font-medium italic line-clamp-2 transition-all duration-500">
                        "{{ $booking->city->description }}"
                    </p>
                    <button onclick="toggleBookingDescription('booking-description', this)" class="mt-4 text-primary-600 font-black text-xs uppercase tracking-[0.2em] hover:text-primary-700 transition-colors flex items-center gap-2">
                        See More <span class="material-symbols-outlined text-sm transition-transform">expand_more</span>
                    </button>
                </div>

                <script>
                    function toggleBookingDescription(id, btn) {
                        const el = document.getElementById(id);
                        if (el.classList.contains('line-clamp-2')) {
                            el.classList.remove('line-clamp-2');
                            btn.innerHTML = `See Less <span class="material-symbols-outlined text-sm rotate-180">expand_more</span>`;
                        } else {
                            el.classList.add('line-clamp-2');
                            btn.innerHTML = `See More <span class="material-symbols-outlined text-sm">expand_more</span>`;
                        }
                    }
                </script>
            </div>

            <!-- Accommodation Section -->
            @if($booking->status === 'pending')
            <div class="glass-card p-8 rounded-xl border border-white/50 shadow-xl">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-2xl font-black text-slate-900 tracking-tight">Accommodation</h3>
                        <p class="text-slate-500 text-sm font-medium mt-1">Select your preferred stay</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" class="hotel-toggle" {{ $booking->include_hotel ? 'checked' : '' }} onchange="updateTrip()">
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                <div class="hotel-scroll flex gap-6 pb-6 overflow-x-auto" id="hotels-container">
                    @foreach($booking->city->hotels as $hotel)
                        @php
                            $pivot = $booking->hotels->where('id', $hotel->id)->first()?->pivot;
                            $isSelected = (bool)$pivot;
                            $checkIn = $pivot?->check_in_date ?? '';
                            $checkOut = $pivot?->check_out_date ?? '';
                        @endphp
                        <div class="hotel-card glass-card p-4 rounded-xl border border-white/50 hover:shadow-2xl w-72 flex-shrink-0 transition-all duration-300 relative group {{ $isSelected ? 'selected' : '' }}"
                            onclick="toggleHotel({{ $hotel->id }})" data-hotel-id="{{ $hotel->id }}" data-hotel-price="{{ $hotel->price_per_night }}">
                            
                            <div class="absolute top-4 right-4 z-20">
                                <div class="w-6 h-6 rounded-full bg-white border-2 border-slate-200 flex items-center justify-center transition-all group-[.selected]:bg-primary-600 group-[.selected]:border-primary-600">
                                    <span class="material-symbols-outlined text-white text-xs scale-0 transition-transform group-[.selected]:scale-100">check</span>
                                </div>
                            </div>

                            <div class="w-full h-44 rounded-lg overflow-hidden mb-4 relative">
                                <img src="{{ $hotel->image }}" alt="{{ $hotel->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                <div class="absolute bottom-2 left-2 px-2 py-1 bg-black/50 backdrop-blur-md rounded text-[10px] font-bold text-white uppercase tracking-widest">
                                    {{ $hotel->getTypeLabel() }}
                                </div>
                            </div>
                            
                            <div class="px-1">
                                <h4 class="font-bold text-slate-900 text-lg truncate mb-1 tracking-tight">{{ $hotel->name }}</h4>
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-primary-600 font-black text-xl">€{{ number_format($hotel->price_per_night) }}</span>
                                    <span class="text-slate-400 text-xs font-bold uppercase italic">/ night</span>
                                </div>
                                
                                @if($booking->status === 'pending')
                                <div class="mt-4 pt-4 border-t border-slate-100 hotel-config {{ $isSelected ? '' : 'opacity-40 pointer-events-none' }} transition-opacity duration-300" id="hotel-config-{{ $hotel->id }}">
                                    <div class="grid grid-cols-2 gap-3">
                                        <div class="flex flex-col gap-1">
                                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Check-in</label>
                                            <input type="date" class="hotel-date-input bg-slate-50 border-none text-[10px] font-bold text-slate-600 p-1 rounded focus:ring-1 focus:ring-primary-500" 
                                                   data-hotel-id="{{ $hotel->id }}" value="{{ $checkIn }}" onchange="updateTrip()" onclick="event.stopPropagation()">
                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Check-out</label>
                                            <input type="date" class="hotel-checkout-input bg-slate-50 border-none text-[10px] font-bold text-slate-600 p-1 rounded focus:ring-1 focus:ring-primary-500" 
                                                   data-hotel-id="{{ $hotel->id }}" value="{{ $checkOut }}" onchange="updateTrip()" onclick="event.stopPropagation()">
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <div class="mt-4">
                                    <a class="inline-flex items-center gap-2 text-primary-600 font-black text-[10px] uppercase tracking-widest hover:text-primary-700 transition-all relative z-30" 
                                       href="{{ route('hotels.show', $hotel->id) }}?booking_id={{ $booking->id }}" 
                                       onclick="event.stopPropagation()">
                                        View Details <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="space-y-6">
                @foreach($booking->hotels as $hotel)
                <div class="glass-card p-8 rounded-xl flex flex-col sm:flex-row gap-8 items-center border border-white/50 shadow-xl group hover:shadow-2xl transition-all duration-500">
                    <div class="relative w-full sm:w-64 h-44 rounded-lg overflow-hidden shrink-0 shadow-lg">
                        <img src="{{ $hotel->image }}" 
                             alt="{{ $hotel->name }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>
                    <div class="flex-1 w-full text-center sm:text-left">
                        <span class="px-3 py-1 bg-primary-50 text-primary-700 text-[10px] font-black uppercase tracking-widest rounded-full border border-primary-100 mb-3 inline-block">
                            {{ $hotel->getTypeLabel() }}
                        </span>
                        <h4 class="text-3xl font-black text-slate-900 tracking-tight mb-2">{{ $hotel->name }}</h4>
                        <div class="flex flex-wrap justify-center sm:justify-start gap-4 mt-4">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary-600">calendar_today</span>
                                <div class="flex flex-col">
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none">Check-in</span>
                                    <span class="text-sm font-bold text-slate-700">{{ $hotel->pivot->check_in_date ? \Carbon\Carbon::parse($hotel->pivot->check_in_date)->format('M d, Y') : 'TBD' }}</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-indigo-600">logout</span>
                                <div class="flex flex-col">
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none">Check-out</span>
                                    <span class="text-sm font-bold text-slate-700">{{ $hotel->pivot->check_out_date ? \Carbon\Carbon::parse($hotel->pivot->check_out_date)->format('M d, Y') : 'TBD' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <!-- Attractions Grid -->
            <div class="space-y-6">
                <h3 class="text-2xl font-black text-slate-900 tracking-tight ml-2">Must-Visit Spots</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" id="places-grid">
                    @foreach($booking->city->places->sortBy('min_price') as $place)
                    @php
                        $isSelected = in_array($place->id, array_filter(explode(',', $booking->selected_place_ids ?? '')));
                        $visitDate = $booking->places->find($place->id)?->pivot?->visit_date;
                    @endphp
                    <div class="place-card glass-card p-5 rounded-xl flex flex-col gap-4 border border-white/50 hover:shadow-lg transition-all group relative {{ $booking->status === 'pending' ? 'cursor-pointer' : '' }}">
                        <div class="flex gap-5">
                            @if($booking->status === 'pending')
                            <input type="checkbox" class="place-checkbox absolute top-4 right-4 w-5 h-5 cursor-pointer z-20"
                                data-place-id="{{ $place->id }}"
                                data-place-price="{{ $place->min_price }}"
                                {{ $isSelected ? 'checked' : '' }}
                                onchange="updateTrip()">
                            @endif
                            
                            <div class="w-24 h-24 rounded-lg overflow-hidden shrink-0 shadow-sm">
                                <img src="{{ $place->image }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <div class="flex-1 flex flex-col justify-between min-w-0">
                                <div>
                                    <h4 class="font-bold text-slate-900 truncate tracking-tight pr-8">{{ $place->name }}</h4>
                                    <p class="text-xs text-slate-500 mt-1 line-clamp-2 leading-relaxed">{{ $place->description }}</p>
                                </div>
                                <div class="flex items-center justify-between mt-3">
                                    <a class="text-[10px] font-black text-primary-600 uppercase tracking-widest flex items-center gap-1 hover:text-primary-700 w-fit relative z-30" href="{{ route('places.show', $place->id) }}?booking_id={{ $booking->id }}">
                                        Explore <span class="material-symbols-outlined text-[12px]">arrow_forward</span>
                                    </a>
                                    <span class="px-3 py-1 bg-primary-50 text-primary-600 font-black text-xs rounded-full border border-primary-100">
                                        €{{ number_format($place->min_price) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        @if($isSelected || $booking->status === 'pending')
                        <div class="mt-2 pt-4 border-t border-slate-100 flex items-center justify-between {{ !$isSelected && $booking->status === 'pending' ? 'opacity-40 pointer-events-none' : '' }} transition-opacity duration-300" id="date-container-{{ $place->id }}">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm text-slate-400">calendar_month</span>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Visit Date</span>
                            </div>
                            @if($booking->status === 'pending')
                                @php
                                    $minVisitDate = $booking->departure_date ? $booking->departure_date->copy()->addDays(2)->format('Y-m-d') : '';
                                @endphp
                                <input type="date" 
                                       class="place-date-input bg-slate-50 border-none text-[11px] font-bold text-slate-600 p-1 rounded focus:ring-1 focus:ring-primary-500" 
                                       data-place-id="{{ $place->id }}"
                                       value="{{ $visitDate }}"
                                       min="{{ $minVisitDate }}"
                                       onchange="updateTrip()">
                            @else
                                <span class="text-[11px] font-bold text-slate-600">{{ $visitDate ? \Carbon\Carbon::parse($visitDate)->format('M d, Y') : 'Not scheduled' }}</span>
                            @endif
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

            @if($booking->status === 'pending')
            <!-- Flight Selection -->
            <div class="space-y-6">
                <div class="flex items-center justify-between ml-2">
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight">Available Flights</h3>
                    <div class="flex items-center gap-2 text-slate-400 text-xs font-bold uppercase tracking-widest">
                        <span class="material-symbols-outlined text-sm">flight</span>
                        Best Matches
                    </div>
                </div>

                <div class="space-y-4" id="flights-container">
                    @foreach($flights as $index => $flight)
                        <div class="flight-card glass-card rounded-xl border border-white/50 hover:border-primary-300 transition-all overflow-hidden {{ $booking->flight_airline === $flight['airline'] ? 'expanded border-primary-500' : '' }}" 
                             id="flight-card-{{ $index }}">
                            <!-- Main Row -->
                            <div class="p-6 cursor-pointer flex flex-col md:flex-row items-center gap-8" 
                                 onclick="toggleFlightExpansion({{ $index }})">
                                
                                <!-- Airline -->
                                <div class="w-full md:w-48 flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-primary-600 shadow-inner">
                                        <span class="material-symbols-outlined">airline_stops</span>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-900 leading-tight">{{ $flight['airline'] }}</h4>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">Certified Carrier</p>
                                    </div>
                                </div>

                                <!-- Journey -->
                                <div class="flex-1 flex items-center justify-center gap-10">
                                    <div class="text-center">
                                        <div class="text-xl font-black text-slate-900 leading-none mb-1">{{ strtoupper(substr($flight['start_city'], 0, 3)) }}</div>
                                        <div class="text-[10px] font-bold text-slate-400 uppercase">{{ $flight['start_city'] }}</div>
                                    </div>

                                    <div class="flex-1 max-w-[150px] relative">
                                        <div class="absolute inset-0 flex items-center">
                                            <div class="w-full border-t-2 border-dashed border-slate-200"></div>
                                        </div>
                                        <div class="relative flex justify-center">
                                            <div class="bg-white px-2 text-[10px] font-black text-primary-500 uppercase tracking-widest flex items-center gap-1">
                                                <span class="material-symbols-outlined text-xs">schedule</span> {{ $flight['duration'] }}
                                            </div>
                                        </div>
                                        <div class="absolute -right-1 top-1/2 -translate-y-1/2">
                                            <span class="material-symbols-outlined text-primary-500 text-sm rotate-90">flight</span>
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <div class="text-xl font-black text-slate-900 leading-none mb-1">{{ strtoupper(substr($flight['end_city'], 0, 3)) }}</div>
                                        <div class="text-[10px] font-bold text-slate-400 uppercase">{{ $flight['end_city'] }}</div>
                                    </div>
                                </div>

                                <!-- Pricing Info -->
                                <div class="flex items-center gap-6">
                                    <div class="text-right">
                                        <div class="text-[10px] font-bold text-slate-400 uppercase mb-1">Starting from</div>
                                        <div class="text-2xl font-black text-primary-600">€{{ number_format($flight['base_price'] * 0.8) }}</div>
                                    </div>
                                    <button class="w-10 h-10 rounded-full border border-slate-200 flex items-center justify-center text-slate-400 hover:text-primary-600 transition-colors">
                                        <span class="material-symbols-outlined expand-icon transition-transform {{ $booking->flight_airline === $flight['airline'] ? 'rotate-180' : '' }}">expand_more</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Expandable Classes -->
                            <div class="flight-details-expand bg-slate-50/50 border-t border-slate-100">
                                <div class="p-6">
                                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Choose your experience</p>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        @foreach($flight['classes'] as $key => $class)
                                            <div class="flight-class-option relative cursor-pointer group"
                                                 onclick="selectFlight(event, '{{ $flight['airline'] }}', '{{ $flight['duration'] }}', '{{ $key }}', {{ $class['price'] }}, this)">
                                                <div class="p-4 rounded-xl border-2 transition-all duration-300 {{ ($booking->flight_airline === $flight['airline'] && $booking->flight_class === $key) ? 'border-primary-600 bg-white shadow-lg scale-105' : 'border-slate-100 bg-white/50 hover:border-primary-200 hover:scale-105' }}">
                                                    <div class="flex items-start justify-between mb-3">
                                                        <span class="text-[10px] font-black uppercase tracking-widest {{ ($booking->flight_airline === $flight['airline'] && $booking->flight_class === $key) ? 'text-primary-600' : 'text-slate-400' }}">
                                                            {{ $class['label'] }}
                                                        </span>
                                                        <div class="w-4 h-4 rounded-full border-2 border-slate-200 flex items-center justify-center transition-all {{ ($booking->flight_airline === $flight['airline'] && $booking->flight_class === $key) ? 'bg-primary-600 border-primary-600' : '' }}">
                                                            <div class="w-1.5 h-1.5 rounded-full bg-white scale-0 transition-transform {{ ($booking->flight_airline === $flight['airline'] && $booking->flight_class === $key) ? 'scale-100' : '' }}"></div>
                                                        </div>
                                                    </div>
                                                    <div class="text-xl font-black text-slate-900 mb-1">€{{ number_format($class['price']) }}</div>
                                                    <div class="text-[10px] text-slate-400 font-bold italic">Round trip per person</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- RIGHT COLUMN: Budget & Actions Sidebar -->
        <div class="lg:col-span-1">
            <div class="sticky top-28 space-y-6 animate-slide-left">
                <div class="glass-card p-10 rounded-xl shadow-2xl border border-white relative overflow-hidden">
                    <div class="absolute -top-20 -right-20 w-64 h-64 bg-primary-200/30 blur-[80px] rounded-full pointer-events-none"></div>

                    <h3 class="text-2xl font-black text-slate-900 tracking-tight mb-8 relative z-10">Trip Summary</h3>

                    @if($booking->status === 'pending')
                    <div class="mb-10 relative z-10">
                        <div class="flex justify-between items-end mb-2">
                            <div class="text-xs font-bold text-slate-400 uppercase tracking-[0.2em]">Live Total Cost</div>
                            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Limit: €<span id="budget-limit-display">{{ number_format($booking->budget_total) }}</span></div>
                        </div>
                        <div class="text-5xl font-black text-slate-900 tracking-tighter transition-colors duration-300" id="total-amount-container">
                            &euro;<span class="count-total" id="total-amount">0</span>
                        </div>
                        
                        <div id="budget-warning" class="mt-4 p-3 bg-red-50 border border-red-100 rounded-lg text-red-600 text-[10px] font-bold uppercase tracking-widest hidden animate-pulse">
                            Budget Limit Exceeded!
                        </div>

                        <div id="budget-increment-view" class="mt-4 hidden animate-slide-up">
                            <div class="flex items-center gap-2">
                                <div class="relative flex-1">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-xs">€</span>
                                    <input type="number" id="budget-add-input" 
                                           class="w-full pl-7 pr-3 py-2 bg-slate-50 border-2 border-slate-200 rounded-lg text-sm font-bold focus:border-primary-500 focus:outline-none transition-all" 
                                           placeholder="Amount to add">
                                </div>
                                <button onclick="applyBudgetIncrease()" class="px-4 py-2 bg-primary-600 text-white rounded-lg font-black text-[10px] uppercase tracking-widest hover:bg-primary-700 transition-all">
                                    Add
                                </button>
                                <button onclick="toggleBudgetIncrease(false)" class="p-2 text-slate-400 hover:text-slate-600">
                                    <span class="material-symbols-outlined text-sm">close</span>
                                </button>
                            </div>
                        </div>

                        <button id="increase-budget-btn" onclick="toggleBudgetIncrease(true)" class="mt-4 w-full py-2 border-2 border-dashed border-slate-200 rounded-lg text-[10px] font-black text-slate-400 uppercase tracking-widest hover:border-primary-400 hover:text-primary-600 transition-all flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-sm">add_circle</span> Increase My Budget
                        </button>

                        <div class="text-[11px] font-black text-slate-400 mt-6 uppercase tracking-[0.15em] flex items-center gap-2 border-t border-slate-100 pt-4">
                            <span class="material-symbols-outlined text-sm">schedule</span>
                            {{ $booking->duration }} Nights &middot; {{ $booking->passengers }} Travelers
                        </div>
                    </div>
                    @else
                    <div class="mb-10 relative z-10 border-t border-slate-100 pt-6">
                        <div class="text-xs font-bold text-slate-400 uppercase tracking-[0.2em] mb-1">Total Amount Paid</div>
                        <div class="text-6xl font-black text-slate-900 tracking-tighter mb-6">
                            &euro;<span id="final-amount-paid" data-target="{{ $booking->budget_total }}">0</span>
                        </div>
                        <div class="text-[11px] font-black text-slate-400 mt-6 uppercase tracking-[0.15em] flex flex-wrap items-center gap-y-2 gap-x-4 border-t border-slate-100 pt-4">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">schedule</span>
                                {{ $booking->duration }} Nights &middot; {{ $booking->passengers }} Travelers
                            </div>
                            @if($booking->departure_date)
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">calendar_month</span>
                                {{ $booking->departure_date->format('M d, Y') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    @if($booking->status === 'pending')
                    <!-- Progress Bars -->
                    <div class="space-y-6 mb-12 relative z-10">
                        <!-- Flight -->
                        <div>
                            <div class="flex justify-between items-center text-[10px] mb-2 font-black uppercase tracking-widest">
                                <span class="text-slate-500">Flight</span>
                                <span class="text-slate-900">&euro;<span id="flight-cost-display">0</span></span>
                            </div>
                            <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-blue-500 rounded-full budget-progress transition-all duration-500" id="flight-bar" style="width: 0%"></div>
                            </div>
                        </div>

                        <!-- Accommodation -->
                        <div>
                            <div class="flex justify-between items-center text-[10px] mb-2 font-black uppercase tracking-widest">
                                <span class="text-slate-500">Accommodation</span>
                                <span class="text-slate-900">&euro;<span id="hotel-cost-display">0</span></span>
                            </div>
                            <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-indigo-500 rounded-full budget-progress transition-all duration-500" id="hotel-bar" style="width: 0%"></div>
                            </div>
                        </div>

                        <!-- Places & Activities -->
                        <div>
                            <div class="flex justify-between items-center text-[10px] mb-2 font-black uppercase tracking-widest">
                                <span class="text-slate-500">Places & Activities</span>
                                <span class="text-slate-900">&euro;<span id="places-cost-display">0</span></span>
                            </div>
                            <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-emerald-500 rounded-full budget-progress transition-all duration-500" id="places-bar" style="width: 0%"></div>
                            </div>
                        </div>

                        <!-- Experiences -->
                        <div>
                            <div class="flex justify-between items-center text-[10px] mb-2 font-black uppercase tracking-widest">
                                <span class="text-slate-500">Experiences</span>
                                <span class="text-slate-900">&euro;<span id="activities-cost-display">0</span></span>
                            </div>
                            <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-primary-500 rounded-full budget-progress transition-all duration-500" id="activities-bar" style="width: 0%"></div>
                            </div>
                        </div>

                        <!-- Miscellaneous -->
                        <div>
                            <div class="flex justify-between items-center text-[10px] mb-2 font-black uppercase tracking-widest">
                                <span class="text-slate-500">Miscellaneous</span>
                                <span class="text-slate-900">&euro;<span id="misc-cost-display">0</span></span>
                            </div>
                            <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-slate-400 rounded-full budget-progress transition-all duration-500" id="misc-bar" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Actions -->
                    <div class="relative z-10 space-y-4">
                        @if($booking->status === 'pending')
                            <div class="flex items-center justify-between px-2 mb-2">
                                <div id="save-status" class="text-[10px] font-black uppercase tracking-widest text-slate-400 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-xs">check_circle</span>
                                    Selections Saved
                                </div>
                            </div>

                            <form id="selections-form" action="{{ route('bookings.update', $booking->id) }}" method="POST" class="hidden">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="selected_hotels" id="form-selected-hotels" value="">
                                <input type="hidden" name="include_hotel" id="form-include-hotel" value="{{ $booking->include_hotel ? '1' : '0' }}">
                                <input type="hidden" name="selected_place_ids" id="form-selected-places" value="{{ $booking->selected_place_ids }}">
                                <input type="hidden" name="place_dates" id="form-place-dates" value="">
                                <input type="hidden" name="airline" id="form-airline" value="{{ $booking->flight_airline }}">
                                <input type="hidden" name="flight_duration" id="form-flight-duration" value="{{ $booking->flight_duration }}">
                                <input type="hidden" name="flight_class" id="form-flight-class" value="{{ $booking->flight_class }}">
                                <input type="hidden" name="flight_budget" id="form-flight-price" value="{{ $booking->flight_airline ? ($booking->passengers > 0 ? $booking->flight_budget / $booking->passengers : 0) : 0 }}">
                                <input type="hidden" name="budget_total" id="form-budget-total" value="{{ $booking->budget_total }}">
                                <input type="hidden" name="departure_date" id="form-departure-date" value="{{ $booking->departure_date ? $booking->departure_date->format('Y-m-d') : '' }}">
                            </form>
                        @endif

                        <a href="{{ route('bookings.plan', $booking->id) }}" class="w-full py-5 bg-primary-600 text-white font-black text-lg rounded-lg shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-3 active:scale-95 group relative overflow-hidden">
                            <div class="absolute inset-0 bg-primary-700 opacity-0 group-hover:opacity-10 transition-opacity"></div>
                            <span class="relative z-10 flex items-center justify-center gap-3">
                                View Trip Plan <span class="material-symbols-outlined">route</span>
                            </span>
                        </a>
                        @if($booking->status === 'pending')
                            <a href="{{ route('payment.show', $booking->id) }}" class="w-full py-5 bg-slate-950 text-white font-black text-xl rounded-lg shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-3 active:scale-95 group relative overflow-hidden">
                                <div class="absolute inset-0 bg-primary-600 opacity-0 group-hover:opacity-10 transition-opacity"></div>
                                <span class="relative z-10 flex items-center justify-center gap-3">
                                    Secure Payment <span class="material-symbols-outlined">payments</span>
                                </span>
                            </a>
                            <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure you want to cancel this booking?');" class="w-full py-3 text-red-500 font-bold text-xs uppercase tracking-widest hover:bg-red-50 rounded-xl transition-colors">
                                    Cancel Booking
                                </button>
                            </form>
                        @else
                            <div class="py-6 bg-emerald-50 rounded-[1.5rem] border border-emerald-100 text-center">
                                <span class="material-symbols-outlined text-emerald-500 text-4xl mb-2" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                <p class="text-emerald-900 font-black text-lg">Transaction Complete</p>
                                <p class="text-emerald-600/70 text-xs font-bold uppercase tracking-widest mt-1">Journey Confirmed</p>
                            </div>
                            <a href="{{ route('payment.ticket', $booking->id) }}" class="w-full py-5 bg-slate-950 text-white font-black text-xl rounded-lg shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-3 active:scale-95 group relative overflow-hidden">
                                <div class="absolute inset-0 bg-primary-600 opacity-0 group-hover:opacity-10 transition-opacity"></div>
                                <span class="relative z-10 flex items-center justify-center gap-3">
                                    View & Print Ticket <span class="material-symbols-outlined">confirmation_number</span>
                                </span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let budgetLimit = {{ $booking->budget_total }};
    const duration = {{ $booking->duration }};
    const passengers = {{ $booking->passengers }};

    // Minimum budgets for Experiences and Misc
    const MIN_EXPERIENCES = 150 * passengers; 
    const MIN_MISC = 50 * passengers;

    function toggleHotel(hotelId) {
        const card = document.querySelector(`.hotel-card[data-hotel-id="${hotelId}"]`);
        if (!card) return;
        
        const isSelected = card.classList.toggle('selected');
        const config = document.getElementById(`hotel-config-${hotelId}`);
        
        if (config) {
            if (isSelected) {
                config.classList.remove('opacity-40', 'pointer-events-none');
            } else {
                config.classList.add('opacity-40', 'pointer-events-none');
            }
        }
        
        updateTrip();
    }

    function toggleFlightExpansion(index) {
        const card = document.getElementById(`flight-card-${index}`);
        const icon = card.querySelector('.expand-icon');
        
        const isExpanded = card.classList.contains('expanded');
        
        // Close others
        document.querySelectorAll('.flight-card').forEach(c => {
            if (c !== card) {
                c.classList.remove('expanded');
                c.querySelector('.expand-icon')?.classList.remove('rotate-180');
            }
        });

        if (isExpanded) {
            card.classList.remove('expanded');
            icon.classList.remove('rotate-180');
        } else {
            card.classList.add('expanded');
            icon.classList.add('rotate-180');
        }
    }

    function selectFlight(e, airline, durationStr, className, price, element) {
        if (e) e.stopPropagation();

        const airlineInput = document.getElementById('form-airline');
        const classInput = document.getElementById('form-flight-class');
        
        const isCurrentlySelected = (airlineInput.value === airline && classInput.value === className);

        if (isCurrentlySelected) {
            // Deselect everything
            airlineInput.value = '';
            document.getElementById('form-flight-duration').value = '';
            classInput.value = '';
            document.getElementById('form-flight-price').value = 0;

            // Remove visual selection from all options
            document.querySelectorAll('.flight-class-option .p-4').forEach(b => {
                b.classList.remove('border-primary-600', 'bg-white', 'shadow-lg', 'scale-105');
                b.classList.add('border-slate-100', 'bg-white/50');
                const label = b.querySelector('.text-\\[10px\\]');
                if (label) { label.classList.remove('text-primary-600'); label.classList.add('text-slate-400'); }
                const circle = b.querySelector('.w-4');
                if (circle) circle.classList.remove('bg-primary-600', 'border-primary-600');
                const dot = b.querySelector('.w-1\\.5');
                if (dot) dot.classList.remove('scale-100');
            });

            // Remove the highlighted border from all flight cards
            document.querySelectorAll('.flight-card').forEach(card => {
                card.classList.remove('border-primary-500');
            });
        } else {
            // Select new flight
            airlineInput.value = airline;
            document.getElementById('form-flight-duration').value = durationStr;
            classInput.value = className;
            document.getElementById('form-flight-price').value = price;

            // Clear previous visual selections
            document.querySelectorAll('.flight-class-option .p-4').forEach(b => {
                b.classList.remove('border-primary-600', 'bg-white', 'shadow-lg', 'scale-105');
                b.classList.add('border-slate-100', 'bg-white/50');
                const label = b.querySelector('.text-\\[10px\\]');
                if (label) { label.classList.remove('text-primary-600'); label.classList.add('text-slate-400'); }
                const circle = b.querySelector('.w-4');
                if (circle) circle.classList.remove('bg-primary-600', 'border-primary-600');
                const dot = b.querySelector('.w-1\\.5');
                if (dot) dot.classList.remove('scale-100');
            });

            // Apply visual selection to current option
            const activeBox = element.querySelector('.p-4');
            activeBox.classList.add('border-primary-600', 'bg-white', 'shadow-lg', 'scale-105');
            activeBox.classList.remove('border-slate-100', 'bg-white/50');
            const activeLabel = activeBox.querySelector('.text-\\[10px\\]');
            if (activeLabel) { activeLabel.classList.add('text-primary-600'); activeLabel.classList.remove('text-slate-400'); }
            const activeCircle = activeBox.querySelector('.w-4');
            if (activeCircle) activeCircle.classList.add('bg-primary-600', 'border-primary-600');
            const activeDot = activeBox.querySelector('.w-1\\.5');
            if (activeDot) activeDot.classList.add('scale-100');
            
            // Highlight the current flight card
            document.querySelectorAll('.flight-card').forEach(card => {
                card.classList.remove('border-primary-500');
            });
            const card = element.closest('.flight-card');
            if (card) card.classList.add('border-primary-500');
        }

        updateTrip();
    }

    function updateTrip() {
        const includeHotelCheckbox = document.querySelector('.hotel-toggle');
        const includeHotel = includeHotelCheckbox ? includeHotelCheckbox.checked : true;

        // Handle Departure Date
        const departureDateInput = document.getElementById('departure-date-input');
        const tripDuration = parseInt("{{ $booking->duration }}");
        let tripEndDate = null;
        let minHotelCheckIn = null;
        let minPlaceVisit = null;

        if (departureDateInput && departureDateInput.value) {
            const d = new Date(departureDateInput.value);
            
            // Trip End Date
            tripEndDate = new Date(d);
            tripEndDate.setDate(tripEndDate.getDate() + tripDuration);
            
            // First hotel starts at least 1 day after departure
            const hMin = new Date(d);
            hMin.setDate(hMin.getDate() + 1);
            minHotelCheckIn = hMin;

            // Places start at least 2 days after departure
            const pMin = new Date(d);
            pMin.setDate(pMin.getDate() + 2);
            minPlaceVisit = pMin;

            // Apply constraints to place inputs
            const maxDateStr = tripEndDate.toISOString().split('T')[0];
            const minPlaceStr = minPlaceVisit.toISOString().split('T')[0];
            
            document.querySelectorAll('.place-date-input').forEach(di => {
                di.min = minPlaceStr;
                di.max = maxDateStr;
                if (di.value && di.value < minPlaceStr) di.value = minPlaceStr;
                if (di.value && di.value > maxDateStr) di.value = maxDateStr;
            });
        }

        // 1. Accommodation Cost (Starts at 0)
        let hotelCost = 0;
        const selectedHotels = [];
        const hotelCards = document.querySelectorAll('.hotel-card.selected');
        let currentMinCheckIn = minHotelCheckIn;

        hotelCards.forEach((card) => {
            const hotelId = card.dataset.hotelId;
            const price = parseFloat(card.dataset.hotelPrice);
            const dateInput = document.querySelector(`.hotel-date-input[data-hotel-id="${hotelId}"]`);
            const checkoutInput = document.querySelector(`.hotel-checkout-input[data-hotel-id="${hotelId}"]`);
            
            if (!dateInput || !checkoutInput || !tripEndDate) return;

            // --- CHECK-IN constraints ---
            const minStr = currentMinCheckIn.toISOString().split('T')[0];
            // Check-in can be at most 1 day before trip end (need at least 1 night)
            const maxCheckInDate = new Date(tripEndDate);
            maxCheckInDate.setDate(maxCheckInDate.getDate() - 1);
            const maxCheckInStr = maxCheckInDate.toISOString().split('T')[0];

            dateInput.min = minStr;
            dateInput.max = maxCheckInStr;

            let checkIn = dateInput.value;
            if (!checkIn || checkIn < minStr) {
                checkIn = minStr;
                dateInput.value = checkIn;
            }
            if (checkIn > maxCheckInStr) {
                checkIn = maxCheckInStr;
                dateInput.value = checkIn;
            }

            // --- CHECK-OUT constraints ---
            const checkInObj = new Date(checkIn);
            const minCheckOut = new Date(checkInObj);
            minCheckOut.setDate(minCheckOut.getDate() + 1); // At least 1 night
            const minCheckOutStr = minCheckOut.toISOString().split('T')[0];
            const maxCheckOutStr = tripEndDate.toISOString().split('T')[0];

            checkoutInput.min = minCheckOutStr;
            checkoutInput.max = maxCheckOutStr;

            let checkOut = checkoutInput.value;
            if (!checkOut || checkOut < minCheckOutStr) {
                checkOut = minCheckOutStr;
                checkoutInput.value = checkOut;
            }
            if (checkOut > maxCheckOutStr) {
                checkOut = maxCheckOutStr;
                checkoutInput.value = checkOut;
            }

            // Calculate nights
            const checkOutObj = new Date(checkOut);
            const nights = Math.max(1, Math.floor((checkOutObj - checkInObj) / (1000 * 60 * 60 * 24)));

            // Update min for next hotel — next hotel check-in starts at this hotel's check-out
            currentMinCheckIn = checkOutObj;

            selectedHotels.push({
                id: hotelId,
                check_in: checkIn,
                check_out: checkOut
            });

            hotelCost += price * nights * passengers;
        });

        if (!includeHotel) hotelCost = 0;

        // 2. Flight Cost (Starts at 0)
        const flightPrice = parseFloat(document.getElementById('form-flight-price').value) || 0;
        const flightCost = flightPrice * passengers;

        // 3. Places & Activities Cost (Starts at 0)
        const selectedPlaces = Array.from(document.querySelectorAll('.place-checkbox:checked'));
        const selectedPlaceIds = selectedPlaces.map(p => p.dataset.placeId).join(',');
        const placesCost = selectedPlaces.reduce((sum, p) => sum + (parseFloat(p.dataset.placePrice) * passengers), 0);

        // Handle dates and container visibility
        const placeDates = {};
        document.querySelectorAll('.place-checkbox').forEach(cb => {
            const id = cb.dataset.placeId;
            const container = document.getElementById(`date-container-${id}`);
            const dateInput = document.querySelector(`.place-date-input[data-place-id="${id}"]`);
            
            if (cb.checked) {
                if (container) container.classList.remove('opacity-40', 'pointer-events-none');
                if (dateInput && dateInput.value) {
                    placeDates[id] = dateInput.value;
                }
            } else {
                if (container) container.classList.add('opacity-40', 'pointer-events-none');
            }
        });

        // 4. Experiences & Miscellaneous (Minimum base)
        let experiencesBudget = MIN_EXPERIENCES;
        let miscBudget = MIN_MISC;

        // Current real spent
        const realSpent = hotelCost + flightCost + placesCost;
        
        // Distribution of leftovers if within initial budget
        const totalCalculated = realSpent + experiencesBudget + miscBudget;
        
        if (totalCalculated < budgetLimit) {
            const leftover = budgetLimit - totalCalculated;
            experiencesBudget += leftover * 0.7;
            miscBudget += leftover * 0.3;
        }

        const finalTotal = realSpent + experiencesBudget + miscBudget;

        // Update Form
        document.getElementById('form-include-hotel').value = includeHotel ? '1' : '0';
        document.getElementById('form-selected-hotels').value = JSON.stringify(selectedHotels);
        document.getElementById('form-selected-places').value = selectedPlaceIds;
        document.getElementById('form-place-dates').value = JSON.stringify(placeDates);

        // Update Display
        animateNumber(document.getElementById('total-amount'), Math.round(finalTotal));
        document.getElementById('flight-cost-display').textContent = Math.round(flightCost).toLocaleString();
        document.getElementById('hotel-cost-display').textContent = Math.round(hotelCost).toLocaleString();
        document.getElementById('places-cost-display').textContent = Math.round(placesCost).toLocaleString();
        document.getElementById('activities-cost-display').textContent = Math.round(experiencesBudget).toLocaleString();
        document.getElementById('misc-cost-display').textContent = Math.round(miscBudget).toLocaleString();

        // Update Progress Bars
        const max = Math.max(finalTotal, budgetLimit);
        document.getElementById('flight-bar').style.width = ((flightCost / max) * 100) + '%';
        document.getElementById('hotel-bar').style.width = ((hotelCost / max) * 100) + '%';
        document.getElementById('places-bar').style.width = ((placesCost / max) * 100) + '%';
        document.getElementById('activities-bar').style.width = ((experiencesBudget / max) * 100) + '%';
        document.getElementById('misc-bar').style.width = ((miscBudget / max) * 100) + '%';

        // Budget Over Logic
        const container = document.getElementById('total-amount-container');
        const warning = document.getElementById('budget-warning');
        
        if (finalTotal > budgetLimit) {
            container.classList.add('budget-over', 'shake');
            warning.classList.remove('hidden');
            setTimeout(() => container.classList.remove('shake'), 500);
        } else {
            container.classList.remove('budget-over');
            warning.classList.add('hidden');
        }

        // Trigger Auto-Save
        autoSave();
    }

    let saveTimeout;
    function autoSave() {
        const status = document.getElementById('save-status');
        if (!status) return;

        status.innerHTML = `<span class="material-symbols-outlined text-xs animate-spin">sync</span> Saving...`;
        status.classList.remove('text-emerald-500');
        status.classList.add('text-slate-400');

        clearTimeout(saveTimeout);
        saveTimeout = setTimeout(() => {
            const form = document.getElementById('selections-form');
            const formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(async response => {
                const data = await response.json();
                if (response.ok && data.success) {
                    status.innerHTML = `<span class="material-symbols-outlined text-xs">check_circle</span> Selections Saved`;
                    status.classList.remove('text-slate-400');
                    status.classList.add('text-emerald-500');
                } else {
                    throw new Error(data.error || 'Validation Error');
                }
            })
            .catch(error => {
                console.error('Save Error:', error);
                status.innerHTML = `<span class="material-symbols-outlined text-xs">error</span> ${error.message || 'Save Failed'}`;
                status.classList.remove('text-slate-400');
                status.classList.add('text-red-500');
            });
        }, 800); // Debounce for 800ms
    }

    function toggleBudgetIncrease(show) {
        const btn = document.getElementById('increase-budget-btn');
        const view = document.getElementById('budget-increment-view');
        const input = document.getElementById('budget-add-input');
        
        if (show) {
            btn.classList.add('hidden');
            view.classList.remove('hidden');
            input.focus();
        } else {
            btn.classList.remove('hidden');
            view.classList.add('hidden');
            input.value = '';
        }
    }

    function applyBudgetIncrease() {
        const input = document.getElementById('budget-add-input');
        const extra = parseFloat(input.value);
        
        if (extra && !isNaN(extra) && extra > 0) {
            budgetLimit += extra;
            document.getElementById('budget-limit-display').textContent = Math.round(budgetLimit).toLocaleString();
            document.getElementById('form-budget-total').value = budgetLimit; // Update hidden form
            updateTrip();
            toggleBudgetIncrease(false);
            
            // Success flash
            const limitDisplay = document.getElementById('budget-limit-display').parentElement;
            limitDisplay.classList.add('text-primary-600', 'scale-110');
            setTimeout(() => limitDisplay.classList.remove('text-primary-600', 'scale-110'), 1000);
        }
    }

    function increaseBudget() {
        // Redundant - replaced by inline toggle
    }

    function animateNumber(el, target) {
        if (!el) return;
        const current = parseInt(el.textContent.replace(/,/g, '')) || 0;
        const duration = 600;
        const startTime = performance.now();

        function update(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const easedProgress = 1 - Math.pow(1 - progress, 3);
            const value = Math.floor(current + easedProgress * (target - current));
            el.textContent = value.toLocaleString();
            if (progress < 1) requestAnimationFrame(update);
            else el.textContent = target.toLocaleString();
        }
        requestAnimationFrame(update);
    }

    // Remove redundant submit listener
    document.addEventListener('DOMContentLoaded', () => {
        @if($booking->status === 'pending')
            updateTrip();
        @else
            const finalAmountEl = document.getElementById('final-amount-paid');
            if (finalAmountEl) {
                animateNumber(finalAmountEl, parseInt(finalAmountEl.dataset.target));
            }
        @endif
    });
</script>
@endsection
