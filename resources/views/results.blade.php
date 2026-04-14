@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#f8fafc] py-12 md:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Premium Header -->
        <div class="relative mb-16 fade-in text-center md:text-left">
            <div class="inline-flex items-center space-x-2 bg-white/80 backdrop-blur-sm border border-primary-100 px-4 py-2 rounded-full text-primary-600 text-xs font-bold uppercase tracking-widest mb-6 shadow-sm">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-primary-500"></span>
                </span>
                <span>Optimal Matches Found</span>
            </div>
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-8">
                <div>
                    <h1 class="text-4xl md:text-6xl font-black text-slate-900 tracking-tight leading-tight">
                        Your Tailored <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-indigo-600">Journey</span>
                    </h1>
                    <p class="mt-4 text-lg text-slate-600 font-light max-w-2xl">
                        We've analyzed your preferences and curated {{ count($trips) }} exclusive itineraries that perfectly align with your budget of <span class="font-bold text-slate-900">{{ number_format($budgetTotal, 2) }} €</span>.
                    </p>
                </div>
                <div>
                     <a href="{{ route('trip.index') }}" class="inline-flex items-center px-6 py-3 border border-slate-200 bg-white text-slate-700 font-bold rounded-2xl hover:bg-slate-50 transition-all hover:shadow-md group">
                        <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Refine Search
                    </a>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('error'))
            <div class="mb-8 bg-red-50 border border-red-100 text-red-700 px-6 py-4 rounded-2xl flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        <div class="space-y-16">
            @foreach($trips as $index => $trip)
            <div class="relative group fade-in" style="animation-delay: {{ $index * 0.15 }}s;">
                <!-- Decorative background blob -->
                <div class="absolute -inset-4 bg-gradient-to-r from-primary-50 to-indigo-50 rounded-[2.5rem] opacity-0 group-hover:opacity-100 transition-opacity duration-500 -z-10"></div>
                
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    <!-- Left: visual card (8 cols) -->
                    <div class="lg:col-span-8">
                        <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 overflow-hidden border border-slate-100 hover:shadow-2xl hover:shadow-primary-100/40 transition-all duration-500">
                            <!-- Main Destination Image -->
                            <div class="relative h-[28rem] overflow-hidden">
                                <img src="{{ $trip['city']->image ?? 'https://images.unsplash.com/photo-1499856871958-5b9627545d1a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200' }}" alt="{{ $trip['city']->name }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                                
                                <div class="absolute top-6 left-6 flex gap-2">
                                     <span class="bg-white/95 backdrop-blur px-4 py-2 rounded-xl text-xs font-black text-slate-900 shadow-lg flex items-center">
                                        <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                                        OPTION {{ $index + 1 }}
                                    </span>
                                    <span class="bg-primary-600/90 backdrop-blur px-4 py-2 rounded-xl text-xs font-bold text-white shadow-lg uppercase tracking-tight">
                                        {{ $trip['trip_type'] }}
                                    </span>
                                </div>

                                <div class="absolute bottom-8 left-8 text-white">
                                    <h3 class="text-4xl md:text-5xl font-black tracking-tight mb-2">{{ $trip['city']->name }}</h3>
                                    <div class="flex items-center text-white/90 font-medium">
                                        <svg class="w-5 h-5 mr-1.5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                        {{ $trip['city']->country->name ?? 'Global Destination' }}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-8">
                                <div class="flex flex-col md:flex-row gap-8">
                                    <!-- City Text -->
                                    <div class="md:w-1/2">
                                        <h4 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-3 text-center md:text-left">The Experience</h4>
                                        <p class="text-slate-600 leading-relaxed font-light text-lg">
                                            {{ $trip['city']->description }}
                                        </p>
                                        <div class="mt-6 flex flex-wrap gap-2">
                                            @foreach($trip['city']->places->take(4) as $place)
                                                <span class="bg-slate-50 border border-slate-100 text-slate-600 text-[10px] px-3 py-1.5 rounded-lg font-bold hover:bg-primary-50 hover:text-primary-700 hover:border-primary-100 transition-colors cursor-default">
                                                    {{ $place->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Hotel Detail -->
                                    <div class="md:w-1/2 bg-slate-50 rounded-2xl p-6 border border-slate-100">
                                        <h4 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-4">Luxury Accommodation</h4>
                                        <div class="flex items-start gap-4">
                                            <div class="w-20 h-20 rounded-xl overflow-hidden shrink-0 shadow-md">
                                                <img src="{{ $trip['hotel']->image ?? 'https://images.unsplash.com/photo-1566073171639-4d8b8890cb51' }}" class="w-full h-full object-cover">
                                            </div>
                                            <div>
                                                <h5 class="text-lg font-bold text-slate-900 group-hover:text-primary-600 transition-colors">{{ $trip['hotel']->name }}</h5>
                                                <div class="flex items-center text-amber-500 text-xs mt-1 font-bold">
                                                    <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                                    <span class="ml-1 text-slate-600">4.9 Rare Find</span>
                                                </div>
                                                <p class="text-xs text-slate-500 mt-2 line-clamp-2 leading-relaxed">{{ $trip['hotel']->description }}</p>
                                            </div>
                                        </div>
                                        <div class="mt-4 pt-4 border-t border-slate-200 flex justify-between items-center">
                                            <span class="text-xs font-bold text-slate-400">Total Accommodation</span>
                                            <span class="text-xl font-black text-slate-900">{{ number_format($trip['hotel_budget'], 2) }} €</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Summary Sidebar (4 cols) -->
                    <div class="lg:col-span-4 lg:sticky lg:top-24">
                        <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 p-8 border border-white relative overflow-hidden">
                            <!-- Background accent -->
                            <div class="absolute top-0 right-0 w-32 h-32 bg-primary-50 rounded-full blur-3xl -mr-16 -mt-16 opacity-50"></div>
                            
                            <h3 class="text-2xl font-black text-slate-900 mb-8 relative flex items-center">
                                <span class="w-10 h-10 rounded-xl bg-primary-100 flex items-center justify-center text-primary-600 mr-3 shadow-sm border border-primary-200">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                                </span>
                                Répartition
                            </h3>
                            
                            <div class="space-y-5 mb-10">
                                <div class="group/item">
                                    <div class="flex justify-between items-center text-sm font-bold text-slate-400 uppercase tracking-tighter mb-1.5">
                                        <span>Stay</span>
                                        <span class="text-slate-900">{{ number_format($trip['hotel_budget'], 2) }} €</span>
                                    </div>
                                    <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-primary-500 rounded-full transition-all duration-1000 delay-500" style="width: {{ ($trip['hotel_budget'] / $trip['total_price']) * 100 }}%"></div>
                                    </div>
                                </div>

                                <div class="group/item">
                                    <div class="flex justify-between items-center text-sm font-bold text-slate-400 uppercase tracking-tighter mb-1.5">
                                        <span>Activities</span>
                                        <span class="text-slate-900">{{ number_format($trip['activities_budget'], 2) }} €</span>
                                    </div>
                                    <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-indigo-500 rounded-full transition-all duration-1000 delay-700" style="width: {{ ($trip['activities_budget'] / $trip['total_price']) * 100 }}%"></div>
                                    </div>
                                </div>

                                <div class="group/item">
                                    <div class="flex justify-between items-center text-sm font-bold text-slate-400 uppercase tracking-tighter mb-1.5">
                                        <span>Miscellaneous</span>
                                        <span class="text-slate-900">{{ number_format($trip['misc_budget'], 2) }} €</span>
                                    </div>
                                    <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-cyan-500 rounded-full transition-all duration-1000 delay-900" style="width: {{ ($trip['misc_budget'] / $trip['total_price']) * 100 }}%"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="py-6 px-6 bg-slate-900 rounded-[1.5rem] mb-8 text-white transform group-hover:scale-[1.02] transition-transform duration-500 shadow-2xl shadow-slate-900/20">
                                <div class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1 text-center">Total All Inclusive</div>
                                <div class="text-4xl font-black text-center tracking-tighter">{{ number_format($trip['total_price'], 2) }} €</div>
                                <div class="text-[10px] text-slate-500 text-center mt-2 font-medium">For {{ $trip['duration'] }} days • {{ $trip['passengers'] }} people</div>
                            </div>

                            <form action="{{ route('trip.confirm') }}" method="POST">
                                @csrf
                                <input type="hidden" name="city_id" value="{{ $trip['city']->id }}">
                                <input type="hidden" name="hotel_id" value="{{ $trip['hotel']->id }}">
                                <input type="hidden" name="duration" value="{{ $trip['duration'] }}">
                                <input type="hidden" name="passengers" value="{{ $trip['passengers'] }}">
                                <input type="hidden" name="budget_total" value="{{ $trip['budget_total'] }}">
                                <input type="hidden" name="hotel_budget" value="{{ $trip['hotel_budget'] }}">
                                <input type="hidden" name="activities_budget" value="{{ $trip['activities_budget'] }}">
                                <input type="hidden" name="misc_budget" value="{{ $trip['misc_budget'] }}">
                                <input type="hidden" name="total_price" value="{{ $trip['total_price'] }}">
                                <input type="hidden" name="trip_type" value="{{ $trip['trip_type'] }}">

                                <button type="submit" class="w-full py-5 bg-gradient-to-r from-primary-600 to-indigo-600 text-white rounded-2xl font-black text-lg shadow-xl shadow-primary-500/30 hover:shadow-primary-500/50 hover:-translate-y-1 transition-all flex items-center justify-center group/btn">
                                    Confirm This Trip
                                    <svg class="w-6 h-6 ml-2 transform group-hover/btn:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                </button>
                            </form>
                            
                            <p class="mt-4 text-[10px] text-slate-400 text-center uppercase font-bold tracking-widest">
                                <svg class="w-3 h-3 inline mr-1 mb-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                                Secure Booking • No Hidden Fees
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Helpful Footer -->
        <div class="mt-24 text-center">
            <p class="text-slate-400 text-sm font-medium">Need something more specific?</p>
            <a href="{{ route('trip.index') }}" class="text-primary-600 font-bold hover:underline mt-2 inline-block">Contact our support team &rarr;</a>
        </div>
    </div>
</div>

<style>
    .fade-in {
        animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
        transform: translateY(20px);
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Custom scroll behavior for sticky */
    html {
        scroll-behavior: smooth;
    }
    
    .tracking-tighter { letter-spacing: -0.05em; }
    .tracking-tight { letter-spacing: -0.025em; }
</style>
@endsection
