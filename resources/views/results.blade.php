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
        <div class="mb-16 animate-on-scroll slide-in-up">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-8">
                <div>
                    <div class="inline-flex items-center gap-2 glass px-4 py-2 rounded-full mb-6">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                        </span>
                        <span class="text-sm font-jakarta font-semibold gradient-text">Premium Matches Found</span>
                    </div>
                    <h1 class="text-5xl md:text-6xl font-display font-black text-white mb-4">
                        Your <span class="gradient-text">Perfect Journey</span>
                    </h1>
                    <p class="text-lg text-gray-400 max-w-2xl font-jakarta">
                        We've curated 3 exclusive itineraries matching your budget of
                        <span class="font-bold text-coral-400">€{{ number_format($budgetTotal ?? 2000, 2) }}</span>
                    </p>
                </div>

                <a href="{{ route('trip.index') }}" class="inline-flex items-center px-6 py-3 glass rounded-xl font-jakarta font-bold text-white hover:bg-white/12 transition-all group">
                    <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Generator
                </a>
            </div>

            <!-- Trip Comparison Toggle -->
            <div class="flex items-center gap-4 justify-center md:justify-start">
                <span class="text-sm font-jakarta text-gray-400">Compare trips:</span>
                <div class="flex gap-2">
                    <button class="comparison-btn active px-4 py-2 rounded-lg font-jakarta font-semibold text-sm transition-all" data-index="0">Trip 1</button>
                    <button class="comparison-btn px-4 py-2 rounded-lg font-jakarta font-semibold text-sm transition-all" data-index="1">Trip 2</button>
                    <button class="comparison-btn px-4 py-2 rounded-lg font-jakarta font-semibold text-sm transition-all" data-index="2">Trip 3</button>
                </div>
            </div>
        </div>

        <!-- Trip Cards -->
        <div class="space-y-16">
            @foreach($trips as $index => $trip)
            <div class="trip-card group fade-in" data-index="{{ $index }}" style="animation-delay: {{ $index * 0.15 }}s;">
                <!-- Decorative background blob -->
                <div class="absolute -inset-4 bg-gradient-to-r from-coral-500/10 to-amber-500/10 rounded-[2rem] opacity-0 group-hover:opacity-100 transition-opacity duration-500 -z-10"></div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                    <!-- Left: Destination Card (2 cols) -->
                    <div class="lg:col-span-2">
                        <div class="relative group/card glass-dark rounded-3xl overflow-hidden shadow-2xl transition-all duration-500 h-full" style="perspective: 1000px;">
                            <!-- Parallax Image -->
                            <div class="relative h-80 overflow-hidden group-hover/card:scale-105 transition-transform duration-500">
                                <img src="{{ $trip['city']->image ?? 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&h=600' }}" alt="{{ $trip['city']->name }}" class="w-full h-full object-cover group-hover/card:scale-110 transition-transform duration-1000">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

                                <!-- Option Badge & Trip Type -->
                                <div class="absolute top-6 left-6 flex gap-3 items-center z-10">
                                    <div class="glass px-4 py-2 rounded-xl flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full bg-green-500 animate-pulse"></span>
                                        <span class="text-xs font-jakarta font-black text-white uppercase tracking-wide">Option {{ $index + 1 }}</span>
                                    </div>
                                    <div class="bg-coral-500/90 backdrop-blur px-4 py-2 rounded-xl">
                                        <span class="text-xs font-jakarta font-bold text-white uppercase tracking-widest">{{ $trip['trip_type'] }}</span>
                                    </div>
                                </div>

                                <!-- Match Score Badge -->
                                <div class="absolute top-6 right-6 glass px-4 py-2 rounded-xl flex items-center gap-2 z-10">
                                    <div class="text-center">
                                        <div class="text-lg font-jakarta font-black gradient-text">{{ 92 + $index }}%</div>
                                        <div class="text-[10px] text-gray-300 font-jakarta">Match</div>
                                    </div>
                                </div>

                                <!-- Destination Name Overlay -->
                                <div class="absolute bottom-8 left-8 text-white z-10">
                                    <h3 class="text-5xl md:text-6xl font-display font-black tracking-tight mb-2">{{ $trip['city']->name }}</h3>
                                    <div class="flex items-center text-gray-300 font-jakarta text-lg">
                                        <svg class="w-5 h-5 mr-2 text-coral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                        {{ $trip['city']->country->name ?? 'Global' }}
                                    </div>
                                </div>
                            </div>

                            <!-- Card Details -->
                            <div class="p-8">
                                <!-- Description & Experiences -->
                                <div class="mb-8">
                                    <h4 class="text-xs font-jakarta font-bold uppercase tracking-widest text-coral-400 mb-3">Experience</h4>
                                    <p class="text-gray-300 leading-relaxed font-jakarta text-lg mb-6">
                                        {{ $trip['city']->description }}
                                    </p>

                                    <!-- Highlights -->
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($trip['city']->places->take(5) as $place)
                                        <span class="glass px-3 py-1.5 rounded-lg text-xs font-jakarta font-semibold text-gray-300 hover:bg-coral-500/20 hover:text-coral-400 transition-all cursor-default">
                                            {{ $place->name }}
                                        </span>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Hotel Card -->
                                <div class="glass rounded-2xl p-6 border border-white/20">
                                    <h4 class="text-xs font-jakarta font-bold uppercase tracking-widest text-amber-400 mb-4">Luxury Accommodation</h4>
                                    <div class="flex gap-4">
                                        <div class="w-24 h-24 rounded-xl overflow-hidden shadow-lg shrink-0">
                                            <img src="{{ $trip['hotel']->image ?? 'https://images.unsplash.com/photo-1566073171639-3f8b3f5e4c4b?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&h=200' }}" alt="{{ $trip['hotel']->name }}" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex-1">
                                            <h5 class="text-lg font-jakarta font-bold text-white mb-2">{{ $trip['hotel']->name }}</h5>
                                            <div class="flex items-center gap-1 mb-2">
                                                @for($i = 0; $i < 5; $i++)
                                                <svg class="w-4 h-4 fill-amber-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                                @endfor
                                            </div>
                                            <p class="text-xs text-gray-400 font-jakarta line-clamp-2">{{ $trip['hotel']->description }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Budget Summary (1 col - sticky) -->
                    <div class="lg:sticky lg:top-24 h-fit">
                        <div class="glass-dark rounded-3xl p-8 border border-white/20 overflow-hidden relative">
                            <!-- Accent background -->
                            <div class="absolute top-0 right-0 w-40 h-40 bg-coral-500/10 rounded-full blur-3xl -mr-20 -mt-20"></div>

                            <div class="relative z-10">
                                <!-- Title -->
                                <h3 class="text-2xl font-display font-black text-white mb-8 flex items-center">
                                    <span class="w-10 h-10 rounded-lg bg-gradient-to-br from-coral-500 to-amber-500 flex items-center justify-center mr-3 shadow-lg">
                                        <svg class="w-6 h-6 text-navy-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                    </span>
                                    Budget Breakdown
                                </h3>

                                <!-- Budget Items -->
                                <div class="space-y-6 mb-10">
                                    <!-- Accommodation -->
                                    <div class="group/item">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-xs font-jakarta font-bold uppercase tracking-widest text-gray-400">Accommodation</span>
                                            <span class="text-sm font-jakarta font-bold text-coral-400">€{{ number_format($trip['hotel_budget'] ?? 800, 2) }}</span>
                                        </div>
                                        <div class="h-2.5 bg-white/10 rounded-full overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-coral-500 to-coral-400 rounded-full transition-all duration-1000 delay-300" style="width: {{ (($trip['hotel_budget'] ?? 800) / ($trip['total_price'] ?? 2000)) * 100 }}%; animation: slideIn 1s ease-out 0.3s forwards;"></div>
                                        </div>
                                    </div>

                                    <!-- Activities -->
                                    <div class="group/item">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-xs font-jakarta font-bold uppercase tracking-widest text-gray-400">Activities</span>
                                            <span class="text-sm font-jakarta font-bold text-amber-400">€{{ number_format($trip['activities_budget'] ?? 400, 2) }}</span>
                                        </div>
                                        <div class="h-2.5 bg-white/10 rounded-full overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-amber-500 to-amber-400 rounded-full transition-all duration-1000 delay-500" style="width: {{ (($trip['activities_budget'] ?? 400) / ($trip['total_price'] ?? 2000)) * 100 }}%;"></div>
                                        </div>
                                    </div>

                                    <!-- Miscellaneous -->
                                    <div class="group/item">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-xs font-jakarta font-bold uppercase tracking-widest text-gray-400">Miscellaneous</span>
                                            <span class="text-sm font-jakarta font-bold text-blue-400">€{{ number_format($trip['misc_budget'] ?? 200, 2) }}</span>
                                        </div>
                                        <div class="h-2.5 bg-white/10 rounded-full overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-blue-500 to-blue-400 rounded-full transition-all duration-1000 delay-700" style="width: {{ (($trip['misc_budget'] ?? 200) / ($trip['total_price'] ?? 2000)) * 100 }}%;"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total Price Card -->
                                <div class="bg-gradient-to-br from-coral-500/20 to-amber-500/20 border border-coral-500/30 rounded-2xl p-6 mb-8">
                                    <div class="text-xs font-jakarta font-bold uppercase tracking-widest text-gray-400 mb-2">Total Price (All Inclusive)</div>
                                    <div class="text-4xl font-display font-black gradient-text mb-2">€{{ number_format($trip['total_price'] ?? 2000, 2) }}</div>
                                    <div class="text-xs text-gray-400 font-jakarta">
                                        {{ $trip['duration'] ?? 7 }} days • {{ $trip['passengers'] ?? 1 }} {{ $trip['passengers'] ?? 1 == 1 ? 'person' : 'people' }}
                                    </div>
                                </div>

                                <!-- Best Value Badge -->
                                @if($index === 0)
                                <div class="absolute top-4 right-4 bg-gradient-to-r from-green-500 to-emerald-500 text-white px-3 py-1 rounded-full text-xs font-jakarta font-bold animate-pulse">
                                    🏆 Best Value
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

                                    <button type="submit" class="w-full bg-gradient-to-r from-coral-500 to-amber-500 text-navy-900 font-jakarta font-bold text-lg py-4 rounded-xl hover:shadow-lg hover:shadow-coral-500/50 hover:-translate-y-1 transition-all duration-300 group/btn flex items-center justify-center">
                                        <span>Confirm This Trip</span>
                                        <svg class="w-6 h-6 ml-2 group-hover/btn:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                    </button>
                                </form>

                                <!-- Security Badge -->
                                <div class="mt-4 text-center text-xs text-gray-500 font-jakarta flex items-center justify-center gap-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                                    Secure • No Hidden Fees
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Footer CTA -->
        <div class="mt-24 text-center animate-on-scroll fade-in">
            <p class="text-gray-400 text-lg font-jakarta mb-4">Need something different?</p>
            <a href="{{ route('trip.index') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-coral-500 to-amber-500 text-navy-900 font-jakarta font-bold rounded-xl hover:shadow-lg hover:shadow-coral-500/50 transition-all">
                Create New Search
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            </a>
        </div>
    </div>
</div>

<style>
    @keyframes slideIn {
        from {
            width: 0;
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .fade-in {
        animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
    }

    .slide-in-up {
        animation: slideInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
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

    .comparison-btn {
        background: rgba(255, 255, 255, 0.08);
        color: rgba(232, 234, 237, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.15);
    }

    .comparison-btn.active {
        background: linear-gradient(135deg, #FF6B35 0%, #F59E0B 100%);
        color: #0A0F1E;
        border-color: transparent;
    }

    .trip-card {
        position: relative;
    }

    /* 3D Tilt Effect on Hover */
    .group/card {
        transform-style: preserve-3d;
    }

    .group/card:hover {
        transform: perspective(1000px) rotateX(var(--rotateX, 0deg)) rotateY(var(--rotateY, 0deg));
    }
</style>

<script>
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
                    }, 300);
                }
            });
        });
    });

    // Initialize all cards as visible initially
    document.querySelectorAll('.trip-card').forEach((card, i) => {
        if (i !== 0) {
            card.style.display = 'none';
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
        }
        card.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
    });

    // 3D Tilt effect on mouse move
    document.querySelectorAll('.group/card').forEach(card => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const rotateY = (x - rect.width / 2) / rect.width * 5;
            const rotateX = (rect.height / 2 - y) / rect.height * 5;

            card.style.setProperty('--rotateX', `${rotateX}deg`);
            card.style.setProperty('--rotateY', `${rotateY}deg`);
        });

        card.addEventListener('mouseleave', () => {
            card.style.setProperty('--rotateX', '0deg');
            card.style.setProperty('--rotateY', '0deg');
        });
    });
</script>
@endsection
