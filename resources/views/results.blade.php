@extends('layouts.app')

@section('content')
<div class="w-full min-h-screen pt-12 pb-20 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto w-full">
        <!-- Header -->
        <div class="mb-12 animate-on-scroll fade-in">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
                <div>
                    <p class="text-sm font-semibold text-primary-600 mb-2">Premium Matches Found</p>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Your Perfect Journey</h1>
                    <p class="text-gray-500">
                        We've curated 3 exclusive itineraries matching your budget of
                        <span class="font-semibold text-gray-900">&euro;{{ number_format($budgetTotal ?? 2000, 2) }}</span>
                    </p>
                </div>

                <a href="{{ route('trip.index') }}" class="inline-flex items-center px-5 py-2.5 bg-white border border-gray-200 rounded-xl font-semibold text-sm text-gray-700 hover:bg-gray-50 transition-colors group">
                    <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Generator
                </a>
            </div>

            <!-- Trip Comparison Toggle -->
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-400">Compare trips:</span>
                <div class="flex gap-1.5">
                    <button class="comparison-btn active px-4 py-2 rounded-lg font-semibold text-sm transition-all" data-index="0">Trip 1</button>
                    <button class="comparison-btn px-4 py-2 rounded-lg font-semibold text-sm transition-all" data-index="1">Trip 2</button>
                    <button class="comparison-btn px-4 py-2 rounded-lg font-semibold text-sm transition-all" data-index="2">Trip 3</button>
                </div>
            </div>
        </div>

        <!-- Trip Cards -->
        <div class="space-y-12">
            @foreach($trips as $index => $trip)
            <div class="trip-card" data-index="{{ $index }}" style="transition: opacity 0.5s ease, transform 0.5s ease;">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                    <!-- Left: Destination Card (2 cols) -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-sm h-full">
                            <!-- Image -->
                            <div class="relative h-72 overflow-hidden">
                                <img src="{{ $trip['city']->image ?? 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&h=600' }}" alt="{{ $trip['city']->name }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>

                                <!-- Option Badge & Trip Type -->
                                <div class="absolute top-5 left-5 flex gap-2 items-center z-10">
                                    <span class="bg-white text-gray-900 text-xs font-bold px-3 py-1.5 rounded-lg uppercase tracking-wide">Option {{ $index + 1 }}</span>
                                    <span class="bg-primary-600 text-white text-xs font-semibold px-3 py-1.5 rounded-lg uppercase tracking-wide">{{ $trip['trip_type'] }}</span>
                                </div>

                                <!-- Destination Name Overlay -->
                                <div class="absolute bottom-6 left-6 text-white z-10">
                                    <h3 class="text-4xl font-bold tracking-tight mb-1">{{ $trip['city']->name }}</h3>
                                    <div class="flex items-center text-white/80 text-sm">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                        {{ $trip['city']->country->name ?? 'Global' }}
                                    </div>
                                </div>
                            </div>

                            <!-- Card Details -->
                            <div class="p-8">
                                <div class="mb-6">
                                    <h4 class="text-xs font-semibold uppercase tracking-wide text-primary-600 mb-2">Experience</h4>
                                    <p class="text-gray-600 leading-relaxed mb-4">{{ $trip['city']->description }}</p>

                                    <!-- Highlights -->
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($trip['city']->places->take(5) as $place)
                                        <span class="bg-gray-100 text-gray-600 px-3 py-1.5 rounded-lg text-xs font-medium">
                                            {{ $place->name }}
                                        </span>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Hotel Card -->
                                <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                                    <h4 class="text-xs font-semibold uppercase tracking-wide text-gray-500 mb-3">Accommodation</h4>
                                    <div class="flex gap-4">
                                        <div class="w-20 h-20 rounded-lg overflow-hidden shrink-0 border border-gray-200">
                                            <img src="{{ $trip['hotel']->image ?? 'https://images.unsplash.com/photo-1566073171639-3f8b3f5e4c4b?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&h=200' }}" alt="{{ $trip['hotel']->name }}" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex-1">
                                            <h5 class="font-semibold text-gray-900 mb-1">{{ $trip['hotel']->name }}</h5>
                                            <div class="flex items-center gap-0.5 mb-1.5">
                                                @for($i = 0; $i < 5; $i++)
                                                <svg class="w-3.5 h-3.5 fill-amber-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                                @endfor
                                            </div>
                                            <p class="text-xs text-gray-500 line-clamp-2">{{ $trip['hotel']->description }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Budget Summary (1 col - sticky) -->
                    <div class="lg:sticky lg:top-24 h-fit">
                        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 overflow-hidden relative">
                            <!-- Title -->
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                                <span class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center mr-3 border border-gray-200">
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                </span>
                                Budget Breakdown
                            </h3>

                            <!-- Budget Items -->
                            <div class="space-y-5 mb-8">
                                <!-- Accommodation -->
                                <div>
                                    <div class="flex justify-between items-center mb-1.5">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-500">Accommodation</span>
                                        <span class="text-sm font-bold text-gray-900">&euro;{{ number_format($trip['hotel_budget'] ?? 800, 2) }}</span>
                                    </div>
                                    <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-primary-500 rounded-full budget-bar" style="animation-delay: {{ 0.2 * ($index + 1) }}s;" data-width="{{ (($trip['hotel_budget'] ?? 800) / ($trip['total_price'] ?? 2000)) * 100 }}%"></div>
                                    </div>
                                </div>

                                <!-- Activities -->
                                <div>
                                    <div class="flex justify-between items-center mb-1.5">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-500">Activities</span>
                                        <span class="text-sm font-bold text-gray-900">&euro;{{ number_format($trip['activities_budget'] ?? 400, 2) }}</span>
                                    </div>
                                    <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-amber-400 rounded-full budget-bar" style="animation-delay: {{ 0.2 * ($index + 1) + 0.1 }}s;" data-width="{{ (($trip['activities_budget'] ?? 400) / ($trip['total_price'] ?? 2000)) * 100 }}%"></div>
                                    </div>
                                </div>

                                <!-- Miscellaneous -->
                                <div>
                                    <div class="flex justify-between items-center mb-1.5">
                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-500">Miscellaneous</span>
                                        <span class="text-sm font-bold text-gray-900">&euro;{{ number_format($trip['misc_budget'] ?? 200, 2) }}</span>
                                    </div>
                                    <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-gray-400 rounded-full budget-bar" style="animation-delay: {{ 0.2 * ($index + 1) + 0.2 }}s;" data-width="{{ (($trip['misc_budget'] ?? 200) / ($trip['total_price'] ?? 2000)) * 100 }}%"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Price Card -->
                            <div class="bg-gray-900 rounded-xl p-6 mb-6 text-center">
                                <div class="text-xs font-semibold uppercase tracking-wide text-gray-400 mb-1">Total All Inclusive</div>
                                <div class="text-3xl font-bold text-white mb-1"><span class="trip-total" data-target="{{ $trip['total_price'] ?? 2000 }}">0</span>€</div>
                                <div class="text-xs text-gray-400">
                                    {{ $trip['duration'] ?? 7 }} days &middot; {{ $trip['passengers'] ?? 1 }} {{ ($trip['passengers'] ?? 1) == 1 ? 'person' : 'people' }}
                                </div>
                            </div>

                            <!-- Best Value Badge -->
                            @if($index === 0)
                            <div class="absolute top-4 right-4 bg-green-100 text-green-700 border border-green-200 px-3 py-1 rounded-lg text-xs font-bold pulse-badge">
                                Best Value
                            </div>
                            @endif

                            <!-- Action Button -->
                            <form action="{{ route('trip.confirm') }}" method="POST">
                                @csrf
                                <input type="hidden" name="city_id" value="{{ $trip['city']->id ?? 1 }}">
                                <input type="hidden" name="hotel_id" value="{{ $trip['hotel']->id ?? 1 }}">
                                <input type="hidden" name="duration" value="{{ $trip['duration'] ?? 7 }}">
                                <input type="hidden" name="passengers" value="{{ $trip['passengers'] ?? 1 }}">
                                <input type="hidden" name="budget_total" value="{{ $trip['budget_total'] ?? 2000 }}">
                                <input type="hidden" name="hotel_budget" value="{{ $trip['hotel_budget'] ?? 800 }}">
                                <input type="hidden" name="activities_budget" value="{{ $trip['activities_budget'] ?? 400 }}">
                                <input type="hidden" name="misc_budget" value="{{ $trip['misc_budget'] ?? 200 }}">
                                <input type="hidden" name="total_price" value="{{ $trip['total_price'] ?? 2000 }}">
                                <input type="hidden" name="trip_type" value="{{ $trip['trip_type'] ?? 'adventure' }}">

                                <button type="submit" class="w-full bg-gray-900 hover:bg-primary-600 text-white font-semibold text-base py-4 rounded-xl transition-colors flex items-center justify-center gap-2 submit-shimmer">
                                    Confirm This Trip
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                </button>
                            </form>

                            <!-- Security Badge -->
                            <div class="mt-3 text-center text-xs text-gray-400 flex items-center justify-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                                Secure &middot; No Hidden Fees
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Footer CTA -->
        <div class="mt-16 text-center">
            <p class="text-gray-400 mb-4">Need something different?</p>
            <a href="{{ route('trip.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-900 hover:bg-primary-600 text-white font-semibold rounded-xl transition-colors">
                Create New Search
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            </a>
        </div>
    </div>
</div>

<style>
    .comparison-btn {
        background: white;
        color: #6b7280;
        border: 1px solid #e5e7eb;
    }

    .comparison-btn.active {
        background: #111827;
        color: #ffffff;
        border-color: #111827;
    }

    .budget-bar {
        width: 0;
        animation: expandBar 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
    }

    @keyframes expandBar {
        from {
            width: 0 !important;
        }
        to {
            width: var(--data-width, 50%) !important;
        }
    }

    .pulse-badge {
        animation: pulseBadge 2s ease-in-out infinite;
    }

    @keyframes pulseBadge {
        0%, 100% {
            opacity: 1;
            transform: scale(1);
        }
        50% {
            opacity: 0.8;
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

    @media (prefers-reduced-motion: reduce) {
        .budget-bar, .pulse-badge, .submit-shimmer:hover {
            animation: none !important;
            width: var(--data-width, 50%);
            opacity: 1;
            transform: none;
        }
    }
</style>

<script>
    // Set data width on budget bars
    document.querySelectorAll('.budget-bar').forEach(bar => {
        const width = bar.getAttribute('data-width');
        bar.style.setProperty('--data-width', width);
    });

    // Comparison toggle
    document.querySelectorAll('.comparison-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const index = btn.getAttribute('data-index');

            // Update active button
            document.querySelectorAll('.comparison-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            // Show/hide trip cards with smooth transition
            document.querySelectorAll('.trip-card').forEach((card, i) => {
                if (i.toString() === index) {
                    card.style.display = 'block';
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 10);
                } else {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 500);
                }
            });
        });
    });

    // Initialize all cards — show first only
    document.querySelectorAll('.trip-card').forEach((card, i) => {
        if (i !== 0) {
            card.style.display = 'none';
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
        }
    });

    // Animate trip total numbers on load
    setTimeout(() => {
        document.querySelectorAll('.trip-total').forEach(el => {
            const target = parseInt(el.getAttribute('data-target'));
            let current = 0;
            const increment = target / 40;
            const interval = setInterval(() => {
                current += increment;
                if (current > target) {
                    el.textContent = target.toLocaleString();
                    clearInterval(interval);
                } else {
                    el.textContent = Math.floor(current).toLocaleString();
                }
            }, 20);
        });
    }, 300);
</script>
@endsection
