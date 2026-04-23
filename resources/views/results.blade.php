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

                            <form action="{{ route('trip.confirm') }}" method="POST" id="confirm-form-{{ $index }}">
                                @csrf
                                <input type="hidden" name="city_id" value="{{ $trip['city']->id }}" class="city-id-{{ $index }}">
                                <input type="hidden" name="hotel_id" value="{{ $trip['hotel']->id }}" class="hotel-id-{{ $index }}">
                                <input type="hidden" name="duration" value="{{ $trip['duration'] }}" class="duration-{{ $index }}">
                                <input type="hidden" name="passengers" value="{{ $trip['passengers'] }}" class="passengers-{{ $index }}">
                                <input type="hidden" name="budget_total" value="{{ $trip['budget_total'] }}" class="budget-total-{{ $index }}">
                                <input type="hidden" name="hotel_budget" value="{{ $trip['hotel_budget'] }}" class="hotel-budget-{{ $index }}">
                                <input type="hidden" name="flight_budget" value="{{ $trip['flight_budget'] }}" class="flight-budget-{{ $index }}">
                                <input type="hidden" name="activities_budget" value="{{ $trip['activities_budget'] }}" class="activities-budget-{{ $index }}">
                                <input type="hidden" name="misc_budget" value="{{ $trip['misc_budget'] }}" class="misc-budget-{{ $index }}">
                                <input type="hidden" name="total_price" value="{{ $trip['total_price'] }}" class="total-price-{{ $index }}">
                                <input type="hidden" name="trip_type" value="{{ $trip['trip_type'] }}" class="trip-type-{{ $index }}">
                                <input type="hidden" name="departure_city_id" value="{{ $departure_city_id }}" class="departure-city-id-{{ $index }}">

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

            animateNumbers(index);
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


        document.addEventListener('DOMContentLoaded', () => {
            animateNumbers(0);
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
