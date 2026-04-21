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
            <a class="flex items-center gap-2 text-primary-600 font-bold text-sm mb-4 hover:text-primary-700 transition-colors" href="{{ url()->previous() }}">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Back
            </a>
            <h1 class="text-4xl md:text-5xl font-black tracking-tighter mb-2 text-slate-900">{{ $hotel->name }}</h1>
            <div class="flex items-center gap-2 text-slate-500 font-bold text-sm uppercase tracking-widest">
                <span class="material-symbols-outlined text-sm text-primary-600">location_on</span>
                {{ $hotel->city->name }}{{ $hotel->city->country ? ', ' . $hotel->city->country->name : '' }}
            </div>
        </div>
        
        <div class="animate-slide-left">
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- LEFT COLUMN: Hotel Showcase -->
        <div class="lg:col-span-2 space-y-10 animate-slide-right">
            <!-- Hero Card -->
            <div class="relative rounded-xl overflow-hidden bg-slate-50 shadow-2xl border border-white/50 aspect-video group">
                <img src="{{ $hotel->image }}" alt="{{ $hotel->name }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
            </div>

            <!-- About The Hotel -->
            <div class="glass-card p-10 rounded-xl border border-white/50 shadow-xl relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-primary-100/20 blur-3xl rounded-full"></div>
                <h3 class="text-2xl font-black mb-6 text-slate-900 tracking-tight flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary-600">info</span>
                    About The Residence
                </h3>
                <p class="text-slate-600 leading-relaxed text-lg font-medium italic">
                    "{{ $hotel->description }}"
                </p>
                <div class="mt-8 grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div class="flex flex-col items-center p-4 bg-slate-50 rounded-lg border border-slate-100">
                        <span class="material-symbols-outlined text-primary-600 mb-2">wifi</span>
                        <span class="text-[10px] font-black uppercase text-slate-400">Free Wifi</span>
                    </div>
                    <div class="flex flex-col items-center p-4 bg-slate-50 rounded-lg border border-slate-100">
                        <span class="material-symbols-outlined text-primary-600 mb-2">pool</span>
                        <span class="text-[10px] font-black uppercase text-slate-400">Pool Area</span>
                    </div>
                    <div class="flex flex-col items-center p-4 bg-slate-50 rounded-lg border border-slate-100">
                        <span class="material-symbols-outlined text-primary-600 mb-2">restaurant</span>
                        <span class="text-[10px] font-black uppercase text-slate-400">Gourmet</span>
                    </div>
                    <div class="flex flex-col items-center p-4 bg-slate-50 rounded-lg border border-slate-100">
                        <span class="material-symbols-outlined text-primary-600 mb-2">spa</span>
                        <span class="text-[10px] font-black uppercase text-slate-400">Wellness</span>
                    </div>
                </div>
            </div>

            <!-- Location Map Section -->
            @if($hotel->localisation)
            <div class="glass-card rounded-xl overflow-hidden border border-white/50 shadow-xl">
                <div class="p-8 pb-4">
                    <h3 class="text-2xl font-black text-slate-900 mb-1 tracking-tight flex items-center gap-3">
                        <span class="material-symbols-outlined text-slate-400">map</span>
                        World-Class Connectivity
                    </h3>
                    <p class="text-slate-500 font-bold text-xs uppercase tracking-widest ml-9 italic">{{ $hotel->localisation }}</p>
                </div>

                @php
                    [$lat, $lng] = array_map('trim', explode(',', $hotel->localisation));
                @endphp
                <div class="mx-8 mb-8 h-[400px] rounded-lg overflow-hidden border border-slate-200 relative grayscale hover:grayscale-0 transition-all duration-700 shadow-inner">
                    <iframe width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen loading="lazy"
                            src="https://maps.google.com/maps?q={{ $lat }},{{ $lng }}&z=15&output=embed">
                    </iframe>
                    <div class="absolute bottom-6 right-6">
                        <a href="https://www.google.com/maps?q={{ urlencode($hotel->localisation) }}" target="_blank"
                           class="bg-white/90 backdrop-blur-md px-6 py-3 rounded-lg border border-white shadow-xl flex items-center gap-2 text-slate-900 font-black text-sm hover:bg-white transition-all">
                            <span class="material-symbols-outlined text-blue-600">directions</span>
                            Get Directions
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- RIGHT COLUMN: Pricing & Contact -->
        <div class="lg:col-span-1">
            <div class="sticky top-28 space-y-6 animate-slide-left">
                <!-- Pricing Card -->
                <div class="glass-card p-10 rounded-xl shadow-2xl border border-white relative overflow-hidden">
                    <div class="absolute -top-20 -right-20 w-64 h-64 bg-primary-200/30 blur-[80px] rounded-full pointer-events-none"></div>

                    <div class="mb-10 relative z-10 text-center">
                        <div class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">Live Availability</div>
                        <div class="text-6xl font-black text-slate-900 tracking-tighter flex items-center justify-center">
                            <span class="text-3xl font-bold text-slate-300 mr-1">&euro;</span>{{ number_format($hotel->price_per_night, 0) }}
                        </div>
                        <p class="text-xs font-black text-slate-400 uppercase tracking-widest mt-4">Per Room &middot; Per Night</p>
                    </div>

                    <div class="relative z-10 space-y-4">
                        <p class="text-center text-[10px] text-slate-400 font-bold uppercase tracking-widest italic">Includes complimentary breakfast</p>
                    </div>
                </div>

                <!-- Contact Panel -->
                <div class="glass-card p-8 rounded-xl border border-white shadow-xl">
                    <h4 class="text-lg font-black text-slate-900 tracking-tight mb-6">Concierge Desk</h4>
                    
                    <div class="space-y-4">
                        @if($hotel->contact_number)
                        <a href="tel:{{ $hotel->contact_number }}" class="flex items-center gap-4 p-4 bg-slate-50 rounded-lg border border-slate-100 hover:border-primary-200 hover:bg-primary-50 transition-all group">
                            <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-primary-600 shrink-0">
                                <span class="material-symbols-outlined">call</span>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Call Guest Services</p>
                                <p class="font-black text-slate-900 truncate tracking-tight">{{ $hotel->contact_number }}</p>
                            </div>
                        </a>
                        @endif

                        @if($hotel->email)
                        <a href="mailto:{{ $hotel->email }}" class="flex items-center gap-4 p-4 bg-slate-50 rounded-lg border border-slate-100 hover:border-indigo-200 hover:bg-indigo-50 transition-all group">
                            <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-indigo-600 shrink-0">
                                <span class="material-symbols-outlined">mail</span>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Send Inquiry</p>
                                <p class="font-black text-slate-900 truncate tracking-tight">{{ $hotel->email }}</p>
                            </div>
                        </a>
                        @endif
                    </div>
                </div>

                <!-- City Overview -->
                <div class="glass-card p-8 rounded-xl border border-white shadow-xl">
                    <h4 class="text-lg font-black text-slate-900 tracking-tight mb-6">Explore the Area</h4>
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-lg overflow-hidden shadow-md">
                            <img src="{{ $hotel->city->image }}" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Destination</p>
                            <h5 class="font-black text-slate-900 tracking-tight">{{ $hotel->city->name }}</h5>
                            <a href="#" class="text-[10px] font-black text-primary-600 hover:text-primary-700 transition-colors uppercase tracking-[0.2em] mt-1 inline-block">View City Guide</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
