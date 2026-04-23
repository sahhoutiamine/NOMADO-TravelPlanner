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
                    <p class="text-2xl font-bold text-white/80">{{ $booking->city->country->name ?? 'Europe' }}</p>
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

            @if($booking->status === 'pending')
            <!-- Hotel Selection -->
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

                <div class="hotel-scroll flex gap-6 pb-6" id="hotels-container">
                    @foreach($booking->city->hotels as $hotel)
                        <div class="hotel-card glass-card p-4 rounded-xl border border-white/50 hover:shadow-2xl w-72 flex-shrink-0 transition-all duration-300 relative group {{ $booking->hotel_id === $hotel->id ? 'selected' : '' }}"
                            onclick="selectHotel({{ $hotel->id }})" data-hotel-id="{{ $hotel->id }}" data-hotel-price="{{ $hotel->price_per_night }}">
                            
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
                                <div class="flex items-center gap-2 mb-4">
                                    <span class="text-primary-600 font-black text-xl">€{{ number_format($hotel->price_per_night) }}</span>
                                    <span class="text-slate-400 text-xs font-bold uppercase italic">/ night</span>
                                </div>
                                
                                <a class="inline-flex items-center gap-2 text-primary-600 font-black text-xs uppercase tracking-widest hover:text-primary-700 transition-all relative z-30" 
                                   href="{{ route('hotels.show', $hotel->id) }}?booking_id={{ $booking->id }}" 
                                   onclick="event.stopPropagation()">
                                    View Details <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Flight Selection -->
            <div class="glass-card p-8 rounded-xl border border-white/50 shadow-xl">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-2xl font-black text-slate-900 tracking-tight">Available Flights</h3>
                        <p class="text-slate-500 text-sm font-medium mt-1">Based on your destination and departure</p>
                    </div>
                </div>

                <div class="space-y-4" id="flights-container">
                    @foreach($flights as $flight)
                        <div class="flight-option glass-card p-6 rounded-xl border border-white/50 hover:shadow-xl transition-all duration-300 {{ $booking->flight_airline === $flight['airline'] ? 'border-primary-500 bg-primary-50/10' : '' }}">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-slate-900 rounded-full flex items-center justify-center text-white">
                                        <span class="material-symbols-outlined">flight_takeoff</span>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-900 text-lg">{{ $flight['airline'] }}</h4>
                                        <p class="text-slate-500 text-sm font-medium flex items-center gap-1">
                                            <span class="material-symbols-outlined text-xs">schedule</span> {{ $flight['duration'] }}
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="flex flex-wrap gap-3">
                                    @foreach($flight['classes'] as $key => $class)
                                        <button type="button" 
                                            class="flight-class-btn px-4 py-3 rounded-lg border-2 border-slate-100 hover:border-primary-300 transition-all text-left min-w-[140px] {{ ($booking->flight_airline === $flight['airline'] && $booking->flight_class === $key) ? 'border-primary-600 bg-primary-50' : 'bg-white' }}"
                                            onclick="selectFlight('{{ $flight['airline'] }}', '{{ $flight['duration'] }}', '{{ $key }}', {{ $class['price'] }}, this)">
                                            <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">{{ $class['label'] }}</div>
                                            <div class="font-bold text-slate-900">€{{ number_format($class['price']) }}</div>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            @endif

            <!-- Display Accommodation Section (after selections or always if paid) -->
            @if($booking->status !== 'pending')
            <div class="glass-card p-8 rounded-xl flex flex-col sm:flex-row gap-8 items-center border border-white/50 shadow-xl group hover:shadow-2xl transition-all duration-500">
                <div class="relative w-full sm:w-64 h-44 rounded-lg overflow-hidden shrink-0 shadow-lg">
                    <img src="{{ $booking->hotel->image ?? 'https://images.unsplash.com/photo-1566073171639-3f8b3f5e4c4b' }}" 
                         alt="{{ $booking->hotel->name }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                </div>
                <div class="flex-1 text-center sm:text-left">
                    <h4 class="text-2xl font-black text-slate-900 mb-1 tracking-tight">{{ $booking->hotel->name }}</h4>
                    <p class="text-slate-400 font-bold text-sm mb-6 uppercase tracking-widest italic">Luxury Stay &middot; {{ $booking->city->name }}</p>
                    <a class="inline-flex items-center gap-2 text-primary-600 font-black text-sm hover:text-primary-700 transition-all hover:translate-x-1" href="{{ route('hotels.show', $booking->hotel->id) }}">
                        View Details <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            </div>
            @endif

            <!-- Attractions Grid -->
            <div class="space-y-6">
                <h3 class="text-2xl font-black text-slate-900 tracking-tight ml-2">Must-Visit Spots</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" id="places-grid">
                    @foreach($booking->city->places->sortBy('min_price') as $place)
                    <div class="place-card glass-card p-5 rounded-xl flex gap-5 border border-white/50 hover:shadow-lg transition-all group relative {{ $booking->status === 'pending' ? 'cursor-pointer' : '' }}">
                        @if($booking->status === 'pending')
                        <input type="checkbox" class="place-checkbox absolute top-4 right-4 w-5 h-5 cursor-pointer z-20"
                            data-place-id="{{ $place->id }}"
                            data-place-price="{{ $place->min_price }}"
                            {{ in_array($place->id, array_filter(explode(',', $booking->selected_place_ids ?? ''))) ? 'checked' : '' }}
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
                    @endforeach
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: Budget & Actions Sidebar -->
        <div class="lg:col-span-1">
            <div class="sticky top-28 space-y-6 animate-slide-left">
                <div class="glass-card p-10 rounded-xl shadow-2xl border border-white relative overflow-hidden">
                    <div class="absolute -top-20 -right-20 w-64 h-64 bg-primary-200/30 blur-[80px] rounded-full pointer-events-none"></div>

                    <h3 class="text-2xl font-black text-slate-900 tracking-tight mb-8 relative z-10">Trip Summary</h3>

                    <div class="mb-10 relative z-10">
                        <div class="text-xs font-bold text-slate-400 uppercase tracking-[0.2em] mb-2">Total Amount</div>
                        <div class="text-5xl font-black text-slate-900 tracking-tighter">&euro;<span class="count-total" id="total-amount" data-target="{{ $booking->total_price }}">0</span></div>
                        <div class="text-[11px] font-black text-slate-400 mt-4 uppercase tracking-[0.15em] flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">schedule</span>
                            {{ $booking->duration }} Nights &middot; {{ $booking->passengers }} Travelers
                        </div>
                    </div>

                    <!-- Progress Bars -->
                    <div class="space-y-7 mb-12 relative z-10">
                        <div>
                            <div class="flex justify-between items-center text-sm mb-3 font-bold">
                                <span class="text-slate-800">Flight</span>
                                <span class="text-slate-400 italic">&euro;<span class="flight-cost-display" id="flight-cost" data-target="{{ $booking->flight_budget }}">0</span></span>
                            </div>
                            <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                @php $flightPerc = $booking->total_price > 0 ? ($booking->flight_budget / $booking->total_price) * 100 : 0; @endphp
                                <div class="h-full bg-blue-500 rounded-full budget-progress" id="flight-bar" data-width="{{ $flightPerc }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between items-center text-sm mb-3 font-bold">
                                <span class="text-slate-800">Accommodation</span>
                                <span class="text-slate-400 italic">&euro;<span class="hotel-cost-display" id="hotel-cost" data-target="{{ $booking->hotel_budget }}">0</span></span>
                            </div>
                            <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                @php $hotelPerc = $booking->total_price > 0 ? ($booking->hotel_budget / $booking->total_price) * 100 : 0; @endphp
                                <div class="h-full bg-indigo-500 rounded-full budget-progress" id="hotel-bar" data-width="{{ $hotelPerc }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between items-center text-sm mb-3 font-bold">
                                <span class="text-slate-800">Experiences</span>
                                <span class="text-slate-400 italic">&euro;<span class="activities-cost-display" id="activities-cost" data-target="{{ $booking->activities_budget }}">0</span></span>
                            </div>
                            <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                @php $actPerc = $booking->total_price > 0 ? ($booking->activities_budget / $booking->total_price) * 100 : 0; @endphp
                                <div class="h-full bg-primary-500 rounded-full budget-progress" id="activities-bar" data-width="{{ $actPerc }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between items-center text-sm mb-3 font-bold">
                                <span class="text-slate-800">Miscellaneous</span>
                                <span class="text-slate-400 italic">&euro;<span class="misc-cost-display" id="misc-cost" data-target="{{ $booking->misc_budget }}">0</span></span>
                            </div>
                            <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                @php $miscPerc = $booking->total_price > 0 ? ($booking->misc_budget / $booking->total_price) * 100 : 0; @endphp
                                <div class="h-full bg-slate-400 rounded-full budget-progress" id="misc-bar" data-width="{{ $miscPerc }}%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="relative z-10 space-y-4">
                        @if($booking->status === 'pending')
                            <form id="selections-form" action="{{ route('bookings.update', $booking->id) }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="hotel_id" id="form-hotel-id" value="{{ $booking->hotel_id }}">
                                <input type="hidden" name="include_hotel" id="form-include-hotel" value="{{ $booking->include_hotel ? '1' : '0' }}">
                                <input type="hidden" name="selected_place_ids" id="form-selected-places" value="{{ $booking->selected_place_ids }}">
                                <input type="hidden" name="airline" id="form-airline" value="{{ $booking->flight_airline }}">
                                <input type="hidden" name="flight_duration" id="form-flight-duration" value="{{ $booking->flight_duration }}">
                                <input type="hidden" name="flight_class" id="form-flight-class" value="{{ $booking->flight_class }}">
                                <input type="hidden" name="flight_price" id="form-flight-price" value="{{ $booking->flight_price }}">

                                <button type="submit" class="w-full py-5 bg-gradient-primary text-white font-black text-lg rounded-lg shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-3 active:scale-95 group relative overflow-hidden">
                                    <div class="absolute inset-0 bg-primary-700 opacity-0 group-hover:opacity-10 transition-opacity"></div>
                                    <span class="relative z-10 flex items-center justify-center gap-3">
                                        Save Selections <span class="material-symbols-outlined">save</span>
                                    </span>
                                </button>
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
    const budgetTotal = {{ $booking->budget_total }};
    const duration = {{ $booking->duration }};
    const passengers = {{ $booking->passengers }};

    function selectHotel(hotelId) {
        const container = document.getElementById('hotels-container');
        container.querySelectorAll('.hotel-card').forEach(card => {
            card.classList.remove('selected');
        });
        event.currentTarget.classList.add('selected');
        document.getElementById('form-hotel-id').value = hotelId;
        updateTrip();
    }

    function selectFlight(airline, durationStr, className, price, btn) {
        // Update hidden fields
        document.getElementById('form-airline').value = airline;
        document.getElementById('form-flight-duration').value = durationStr;
        document.getElementById('form-flight-class').value = className;
        document.getElementById('form-flight-price').value = price;

        // Visual updates
        document.querySelectorAll('.flight-class-btn').forEach(b => {
            b.classList.remove('border-primary-600', 'bg-primary-50');
            b.classList.add('bg-white');
        });
        btn.classList.add('border-primary-600', 'bg-primary-50');
        btn.classList.remove('bg-white');

        document.querySelectorAll('.flight-option').forEach(opt => opt.classList.remove('border-primary-500', 'bg-primary-50/10'));
        btn.closest('.flight-option').classList.add('border-primary-500', 'bg-primary-50/10');

        updateTrip();
    }

    function updateTrip() {
        const includeHotelCheckbox = document.querySelector('.hotel-toggle');
        const includeHotel = includeHotelCheckbox ? includeHotelCheckbox.checked : true;

        // Get selected hotel
        const selectedHotelCard = document.querySelector('#hotels-container .hotel-card.selected');
        const hotelPricePerNight = selectedHotelCard ? parseFloat(selectedHotelCard.dataset.hotelPrice) : 0;

        // Get selected places
        const selectedPlaces = Array.from(document.querySelectorAll('.place-checkbox:checked'));
        const selectedPlaceIds = selectedPlaces.map(p => p.dataset.placeId).join(',');
        const placesCost = selectedPlaces.reduce((sum, p) => sum + (parseFloat(p.dataset.placePrice) * passengers), 0);

        // Get selected flight
        const flightPrice = parseFloat(document.getElementById('form-flight-price').value) || 0;
        const flightCost = flightPrice * passengers;

        // Calculate budgets
        const hotelCost = includeHotel ? (hotelPricePerNight * duration * passengers) : 0;
        const remaining = budgetTotal - hotelCost - flightCost;
        const miscBudget = remaining * 0.20;
        const activitiesBudget = remaining * 0.80;

        // Update form values
        document.getElementById('form-include-hotel').value = includeHotel ? '1' : '0';
        document.getElementById('form-selected-places').value = selectedPlaceIds;

        // Update display values with animation
        animateNumber(document.getElementById('total-amount'), budgetTotal);
        animateNumber(document.getElementById('hotel-cost'), Math.round(hotelCost));
        animateNumber(document.getElementById('flight-cost'), Math.round(flightCost));
        animateNumber(document.getElementById('activities-cost'), Math.round(activitiesBudget));
        animateNumber(document.getElementById('misc-cost'), Math.round(miscBudget));

        // Update progress bars
        const totalForPerc = budgetTotal > 0 ? budgetTotal : 1;
        document.getElementById('hotel-bar').style.width = ((hotelCost / totalForPerc) * 100) + '%';
        document.getElementById('flight-bar').style.width = ((flightCost / totalForPerc) * 100) + '%';
        document.getElementById('activities-bar').style.width = ((activitiesBudget / totalForPerc) * 100) + '%';
        document.getElementById('misc-bar').style.width = ((miscBudget / totalForPerc) * 100) + '%';
    }

    function animateNumber(el, target) {
        if (!el) return;

        let current = 0;
        const duration = 600;
        const startTime = performance.now();

        function update(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const easedProgress = 1 - Math.pow(1 - progress, 3);
            const value = Math.floor(easedProgress * target);

            el.textContent = value.toLocaleString();

            if (progress < 1) {
                requestAnimationFrame(update);
            } else {
                el.textContent = target.toLocaleString();
            }
        }
        requestAnimationFrame(update);
    }

    function animateNumbers() {
        document.querySelectorAll('[data-target]').forEach(el => {
            const target = parseInt(el.getAttribute('data-target'));
            if (isNaN(target)) return;
            animateNumber(el, target);
        });
    }

    function animateProgress() {
        document.querySelectorAll('.budget-progress').forEach(bar => {
            const width = bar.getAttribute('data-width');
            bar.style.width = '0';
            setTimeout(() => {
                bar.style.width = width;
            }, 50);
        });
    }

    // Handle form submission for selections
    document.getElementById('selections-form')?.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        fetch('{{ route("bookings.update", $booking->id) }}', {
            method: 'PUT',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message and update display
                alert('Selections saved successfully!');
                location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
    });

    document.addEventListener('DOMContentLoaded', () => {
        animateNumbers();
        animateProgress();
        @if($booking->status === 'pending')
            updateTrip();
        @endif
    });
</script>
@endsection
