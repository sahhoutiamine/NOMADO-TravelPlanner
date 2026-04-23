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

        .trip-toggle-btn.active {
            background-color: #0284c7;
            color: white;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }

        @keyframes slideRight {
            from {
                transform: translateX(-30px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideLeft {
            from {
                transform: translateX(30px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
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

        .place-checkbox {
            cursor: pointer;
        }

        .place-card {
            transition: all 0.3s ease;
        }

        .place-card label {
            cursor: pointer;
        }

        .warning-box {
            animation: slideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes slideUp {
            from {
                transform: translateY(10px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
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
            ring: 2px;
            ring-color: #0284c7;
            box-shadow: 0 0 0 2px white, 0 0 0 4px #0284c7;
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
                <a class="flex items-center gap-2 text-primary-600 font-bold text-sm mb-4 hover:text-primary-700 transition-colors"
                    href="{{ route('trip.index') }}">
                    <span class="material-symbols-outlined text-sm">arrow_back</span>
                    Back to Generator
                </a>
                <h1 class="text-5xl md:text-6xl font-black tracking-tighter mb-2 text-slate-900">Your Perfect <span
                        class="text-gradient">Journey</span></h1>
                <p class="text-slate-500 text-lg font-medium">Choose from 3 incredible options for your
                    €{{ number_format($budgetTotal ?? 2000) }} budget.</p>
            </div>
            <!-- Trip Toggles -->
            <div class="flex bg-white p-1.5 rounded-lg border border-slate-200 shadow-sm relative z-10 animate-slide-left">
                @foreach($trips as $index => $trip)
                    <button
                        class="trip-toggle-btn px-6 py-2.5 rounded-xl font-bold text-sm transition-all duration-300 {{ $index === 0 ? 'active' : 'text-slate-500 hover:text-slate-900' }}"
                        onclick="showTrip({{ $index }})" id="btn-trip-{{ $index }}">
                        Trip {{ $index + 1 }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- 2-Column Layout -->
        @foreach($trips as $index => $trip)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 trip-content {{ $index === 0 ? '' : 'hidden' }}"
                id="trip-{{ $index }}">
                <!-- LEFT COLUMN (2/3): Destination -->
                <div class="lg:col-span-2 space-y-8 animate-slide-right">
                    <!-- Destination Hero Card -->
                    <div
                        class="relative rounded-xl overflow-hidden bg-slate-50 shadow-2xl border border-white/50 aspect-video group">
                        <img src="{{ $trip['city']->image ?? 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?q=80&w=1200&auto=format&fit=crop' }}"
                            alt="{{ $trip['city']->name }}"
                            class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-10 w-full">
                            <div class="flex justify-between items-end text-white">
                                <div>
                                    <span
                                        class="px-4 py-1.5 bg-white/20 rounded-full text-[10px] font-black uppercase tracking-[0.2em] border border-white/30 mb-4 inline-block">
                                        {{ strtoupper($trip['trip_type']) }} IMMERSION
                                    </span>
                                    <h2 class="text-6xl font-black text-white tracking-tighter">{{ $trip['city']->name }}</h2>
                                    <p class="text-2xl font-bold text-white/80">{{ $trip['city']->country->name ?? 'Europe' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="glass-card p-10 rounded-xl border border-white/50 shadow-xl">
                        <h3 class="text-2xl font-black mb-4 text-slate-900">The Experience</h3>
                        <div class="relative">
                            <p id="trip-desc-{{ $index }}" class="text-slate-600 leading-relaxed text-lg font-medium italic line-clamp-2 transition-all duration-500">
                                "{{ $trip['city']->description }}"
                            </p>
                            <button onclick="toggleExperience('trip-desc-{{ $index }}', this)" class="mt-4 text-primary-600 font-black text-xs uppercase tracking-[0.2em] hover:text-primary-700 transition-colors flex items-center gap-2">
                                See More <span class="material-symbols-outlined text-sm transition-transform">expand_more</span>
                            </button>
                        </div>

                        <div class="flex flex-wrap gap-2 mt-6">
                            @foreach($trip['city']->places->take(5) as $place)
                                <span
                                    class="bg-primary-50 text-primary-700 px-4 py-2 rounded-xl text-xs font-bold border border-primary-100">
                                    {{ $place->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <!-- Hotel Selection -->
                    <div class="glass-card p-8 rounded-xl border border-white/50 shadow-xl">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-2xl font-black text-slate-900">Accommodation</h3>
                            <label class="toggle-switch">
                                <input type="checkbox" class="hotel-toggle" data-trip="{{ $index }}" checked onchange="updateTrip({{ $index }})">
                                <span class="toggle-slider"></span>
                            </label>
                        </div>

                        <div class="hotel-scroll flex gap-4 pb-2" id="hotels-container-{{ $index }}">
                            @foreach($trip['city']->hotels as $hotel)
                                <div class="hotel-card glass-card p-4 rounded-lg border border-white/50 hover:shadow-lg w-56 {{ $loop->first ? 'selected' : '' }}"
                                    onclick="selectHotel({{ $index }}, {{ $hotel->id }})" data-hotel-id="{{ $hotel->id }}" data-hotel-price="{{ $hotel->price_per_night }}">
                                    <div class="w-full h-32 rounded-md overflow-hidden mb-3">
                                        <img src="{{ $hotel->image }}" alt="{{ $hotel->name }}" class="w-full h-full object-cover">
                                    </div>
                                    <h4 class="font-bold text-slate-900 text-sm truncate">{{ $hotel->name }}</h4>
                                    <span class="text-xs text-slate-500">{{ $hotel->getTypeLabel() }}</span>
                                    <p class="text-primary-600 font-black text-lg mt-2">€{{ number_format($hotel->price_per_night) }}/night</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Places Selection -->
                    <div class="glass-card p-8 rounded-xl border border-white/50 shadow-xl">
                        <h3 class="text-2xl font-black text-slate-900 mb-6">Must-Visit Places</h3>
                        <div id="places-warning-{{ $index }}" class="mb-6"></div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" id="places-grid-{{ $index }}">
                            @forelse($trip['city']->places->sortBy('min_price') as $place)
                                <div class="place-card glass-card p-5 rounded-[1.5rem] border border-white/50 hover:shadow-lg transition-all">
                                    <label class="flex items-start gap-4 cursor-pointer">
                                        <input type="checkbox" class="place-checkbox mt-1 w-5 h-5 cursor-pointer"
                                            data-trip="{{ $index }}" data-place-id="{{ $place->id }}"
                                            data-place-price="{{ $place->min_price }}"
                                            onchange="updateTrip({{ $index }})">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-start justify-between gap-2">
                                                <div>
                                                    <h4 class="font-bold text-slate-900 text-sm">{{ $place->name }}</h4>
                                                    <p class="text-xs text-slate-500 mt-1 line-clamp-2 leading-relaxed">{{ $place->description }}</p>
                                                </div>
                                                <span class="text-primary-600 font-black text-sm whitespace-nowrap">€{{ number_format($place->min_price) }}</span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            @empty
                                <p class="text-slate-400 col-span-2">No places available in this city</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN (1/3): Sticky Budget Sidebar -->
                <div class="lg:col-span-1">
                    <div class="sticky top-28 space-y-6 animate-slide-left">
                        <div class="glass-card p-10 rounded-xl shadow-2xl border border-white relative overflow-hidden">
                            <!-- Glow effect -->
                            <div
                                class="absolute -top-20 -right-20 w-64 h-64 bg-primary-200/30 blur-[80px] rounded-full pointer-events-none">
                            </div>

                            <div class="flex justify-between items-start mb-10 relative z-10">
                                <h3 class="text-2xl font-black text-slate-900 tracking-tight">Trip Budget</h3>
                                @if($index === 0)
                                    <span
                                        class="px-4 py-1.5 bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-wider rounded-full border border-emerald-100 flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-[12px]"
                                            style="font-variation-settings: 'FILL' 1;">eco</span> Best Value
                                    </span>
                                @endif
                            </div>

                            <div class="mb-10 relative z-10">
                                <div class="text-xs font-bold text-slate-400 uppercase tracking-[0.2em] mb-2">Total Budget</div>
                                <div class="text-5xl font-black text-slate-900 tracking-tighter">€<span class="count-total-{{ $index }}"
                                        data-target="{{ $trip['total_price'] }}">0</span></div>
                            </div>

                            <!-- Progress Bars -->
                            <div class="space-y-7 mb-12 relative z-10">
                                <!-- Hotel -->
                                <div class="hotel-bar-{{ $index }}">
                                    <div class="flex justify-between items-center text-sm mb-3">
                                        <span class="font-bold text-slate-800">Accommodation</span>
                                        <span class="text-slate-400 font-bold italic">€<span class="hotel-cost-display-{{ $index }}">{{ number_format($trip['hotel']->price_per_night * $trip['duration'] * $trip['passengers']) }}</span></span>
                                    </div>
                                    <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-indigo-500 rounded-full budget-progress-{{ $index }}"
                                            data-width="{{ ($trip['hotel_budget'] / $trip['total_price']) * 100 }}%"></div>
                                    </div>
                                </div>

                                <!-- Places/Activities -->
                                <div>
                                    <div class="flex justify-between items-center text-sm mb-3">
                                        <span class="font-bold text-slate-800">Places & Activities</span>
                                        <span class="text-slate-400 font-bold italic">€<span class="places-cost-display-{{ $index }}">0</span></span>
                                    </div>
                                    <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-emerald-500 rounded-full budget-progress-places-{{ $index }}"
                                            style="width: 0%"></div>
                                    </div>
                                </div>

                                <!-- Flights -->
                                <div>
                                    <div class="flex justify-between items-center text-sm mb-3">
                                        <span class="font-bold text-slate-800">Flights</span>
                                        <span class="text-slate-400 font-bold italic">€<span class="flight-cost-display-{{ $index }}">{{ number_format($trip['flight_budget']) }}</span></span>
                                    </div>
                                    <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-sky-500 rounded-full budget-progress-flight-{{ $index }}"
                                            data-width="{{ ($trip['flight_budget'] / $trip['total_price']) * 100 }}%"></div>
                                    </div>
                                </div>

                                <!-- Miscellaneous -->
                                <div>
                                    <div class="flex justify-between items-center text-sm mb-3">
                                        <span class="font-bold text-slate-800">Miscellaneous</span>
                                        <span class="text-slate-400 font-bold italic">€<span class="misc-cost-display-{{ $index }}">{{ number_format($trip['misc_budget']) }}</span></span>
                                    </div>
                                    <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-slate-400 rounded-full budget-progress-misc-{{ $index }}"
                                            data-width="{{ ($trip['misc_budget'] / $trip['total_price']) * 100 }}%"></div>
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('trip.confirm') }}" method="POST" id="confirm-form-{{ $index }}">
                                @csrf
                                <input type="hidden" name="city_id" value="{{ $trip['city']->id }}" class="city-id-{{ $index }}">
                                <input type="hidden" name="hotel_id" value="{{ $trip['hotel']->id }}" class="hotel-id-{{ $index }}">
                                <input type="hidden" name="duration" value="{{ $trip['duration'] }}" class="duration-{{ $index }}">
                                <input type="hidden" name="passengers" value="{{ $trip['passengers'] }}" class="passengers-{{ $index }}">
                                <input type="hidden" name="budget_total" value="{{ $trip['budget_total'] }}" class="budget-total-{{ $index }}">
                                <input type="hidden" name="hotel_budget" value="{{ $trip['hotel_budget'] }}" class="hotel-budget-{{ $index }}">
                                <input type="hidden" name="flight_budget" value="{{ $trip['flight_budget'] }}" class="flight-budget-{{ $index }}">
                                <input type="hidden" name="activities_budget" value="0" class="activities-budget-{{ $index }}">
                                <input type="hidden" name="misc_budget" value="{{ $trip['misc_budget'] }}" class="misc-budget-{{ $index }}">
                                <input type="hidden" name="total_price" value="{{ $trip['total_price'] }}" class="total-price-{{ $index }}">
                                <input type="hidden" name="trip_type" value="{{ $trip['trip_type'] }}" class="trip-type-{{ $index }}">
                                <input type="hidden" name="departure_city_id" value="{{ $departure_city_id }}" class="departure-city-id-{{ $index }}">
                                <input type="hidden" name="selected_place_ids" value="" class="selected-place-ids-{{ $index }}">
                                <input type="hidden" name="include_hotel" value="1" class="include-hotel-{{ $index }}">

                                <button type="submit"
                                    class="w-full py-5 bg-slate-950 text-white font-black text-xl rounded-lg shadow-lg hover:shadow-xl transition-all relative overflow-hidden group">
                                    <div class="absolute inset-0 bg-primary-600 opacity-0 group-hover:opacity-10 transition-opacity"></div>
                                    <span class="relative z-10 flex items-center justify-center gap-3">
                                        Confirm This Trip <span class="material-symbols-outlined">check_circle</span>
                                    </span>
                                </button>
                            </form>
                        </div>
                        <div class="text-center">
                            <a class="text-xs font-black uppercase tracking-widest text-slate-400 hover:text-primary-600 transition-colors"
                                href="{{ route('trip.index') }}">
                                Need something different? Reset & Search
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <script>
        function showTrip(index) {
            document.querySelectorAll('.trip-content').forEach(trip => {
                trip.classList.add('hidden');
            });

            const selectedTrip = document.getElementById('trip-' + index);
            selectedTrip.classList.remove('hidden');

            document.querySelectorAll('.trip-toggle-btn').forEach(btn => {
                btn.classList.remove('active');
                btn.classList.add('text-slate-500', 'hover:text-slate-900');
            });
            const activeBtn = document.getElementById('btn-trip-' + index);
            activeBtn.classList.add('active');
            activeBtn.classList.remove('text-slate-500', 'hover:text-slate-900');

            animateProgress(index);
            animateNumbers(index);
        }

        function selectHotel(tripIndex, hotelId) {
            const container = document.getElementById(`hotels-container-${tripIndex}`);
            container.querySelectorAll('.hotel-card').forEach(card => {
                card.classList.remove('selected');
            });
            event.currentTarget.classList.add('selected');

            document.querySelector(`.hotel-id-${tripIndex}`).value = hotelId;
            updateTrip(tripIndex);
        }

        function updateTrip(tripIndex) {
            const budgetTotal = parseFloat(document.querySelector(`.budget-total-${tripIndex}`).value);
            const duration = parseInt(document.querySelector(`.duration-${tripIndex}`).value);
            const passengers = parseInt(document.querySelector(`.passengers-${tripIndex}`).value);
            const includeHotelCheckbox = document.querySelector(`.hotel-toggle[data-trip="${tripIndex}"]`);
            const includeHotel = includeHotelCheckbox.checked ? 1 : 0;

            // Get selected hotel
            const selectedHotelCard = document.querySelector(`#hotels-container-${tripIndex} .hotel-card.selected`);
            const hotelPricePerNight = selectedHotelCard ? parseFloat(selectedHotelCard.dataset.hotelPrice) : 0;

            // Get selected places
            const selectedPlaces = Array.from(document.querySelectorAll(`.place-checkbox[data-trip="${tripIndex}"]:checked`));
            const selectedPlaceIds = selectedPlaces.map(p => p.dataset.placeId).join(',');
            const placesCost = selectedPlaces.reduce((sum, p) => sum + (parseFloat(p.dataset.placePrice) * passengers), 0);

            // Calculate budgets
            const hotelCost = includeHotel ? (hotelPricePerNight * duration * passengers) : 0;
            const remaining = budgetTotal - hotelCost;
            const flightBudget = remaining * 0.30;
            const miscBudget = remaining * 0.20;
            const activitiesBudget = remaining * 0.50;

            // Update form values
            document.querySelector(`.selected-place-ids-${tripIndex}`).value = selectedPlaceIds;
            document.querySelector(`.include-hotel-${tripIndex}`).value = includeHotel;
            document.querySelector(`.hotel-budget-${tripIndex}`).value = hotelCost.toFixed(2);
            document.querySelector(`.flight-budget-${tripIndex}`).value = flightBudget.toFixed(2);
            document.querySelector(`.activities-budget-${tripIndex}`).value = activitiesBudget.toFixed(2);
            document.querySelector(`.misc-budget-${tripIndex}`).value = miscBudget.toFixed(2);

            // Update display values with animation
            animateNumber(document.querySelector(`.count-total-${tripIndex}`), Math.round(budgetTotal));
            animateNumber(document.querySelector(`.hotel-cost-display-${tripIndex}`), Math.round(hotelCost));
            animateNumber(document.querySelector(`.places-cost-display-${tripIndex}`), Math.round(placesCost));
            animateNumber(document.querySelector(`.flight-cost-display-${tripIndex}`), Math.round(flightBudget));
            animateNumber(document.querySelector(`.misc-cost-display-${tripIndex}`), Math.round(miscBudget));

            // Update progress bars
            const totalForPerc = budgetTotal > 0 ? budgetTotal : 1;
            document.querySelector(`.budget-progress-${tripIndex}`).style.width = ((hotelCost / totalForPerc) * 100) + '%';
            document.querySelector(`.budget-progress-places-${tripIndex}`).style.width = ((placesCost / totalForPerc) * 100) + '%';
            document.querySelector(`.budget-progress-flight-${tripIndex}`).style.width = ((flightBudget / totalForPerc) * 100) + '%';
            document.querySelector(`.budget-progress-misc-${tripIndex}`).style.width = ((miscBudget / totalForPerc) * 100) + '%';

            // Show/hide hotel bar
            const hotelBar = document.querySelector(`.hotel-bar-${tripIndex}`);
            if (includeHotel) {
                hotelBar.style.display = 'block';
            } else {
                hotelBar.style.display = 'none';
            }

            // Update warning
            if (placesCost > activitiesBudget) {
                const excess = placesCost - activitiesBudget;
                document.getElementById(`places-warning-${tripIndex}`).innerHTML = `
                    <div class="warning-box bg-amber-50 border border-amber-200 rounded-lg p-4 flex gap-3">
                        <span class="material-symbols-outlined text-amber-600 shrink-0">warning</span>
                        <div class="text-sm text-amber-700 font-bold">
                            Places cost exceeds activities budget by <strong>€${Math.round(excess)}</strong>
                        </div>
                    </div>
                `;
            } else {
                document.getElementById(`places-warning-${tripIndex}`).innerHTML = '';
            }
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

        function animateNumbers(tripIndex) {
            document.querySelectorAll(`.count-total-${tripIndex}`).forEach(el => {
                const target = parseInt(el.getAttribute('data-target'));
                if (isNaN(target)) return;
                animateNumber(el, target);
            });
        }

        function animateProgress(tripIndex) {
            document.querySelectorAll(`.budget-progress-${tripIndex}, .budget-progress-places-${tripIndex}, .budget-progress-flight-${tripIndex}, .budget-progress-misc-${tripIndex}`).forEach(bar => {
                const width = bar.getAttribute('data-width');
                if (width) {
                    bar.style.width = '0';
                    setTimeout(() => {
                        bar.style.width = width;
                    }, 30);
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            animateProgress(0);
            animateNumbers(0);
            updateTrip(0);
        });

        function toggleExperience(id, btn) {
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
@endsection
