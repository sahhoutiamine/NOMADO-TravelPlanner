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
            @if(request('booking_id'))
            <a class="flex items-center gap-2 text-primary-600 font-bold text-sm mb-4 hover:text-primary-700 transition-colors" href="{{ route('bookings.show', request('booking_id')) }}">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Back to Booking
            </a>
            @else
            <a class="flex items-center gap-2 text-primary-600 font-bold text-sm mb-4 hover:text-primary-700 transition-colors" href="{{ url()->previous() }}">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Back
            </a>
            @endif
            <h1 class="text-4xl md:text-5xl font-black tracking-tighter mb-2 text-slate-900">{{ $place->name }}</h1>
            <div class="flex items-center gap-2 text-slate-500 font-bold text-sm uppercase tracking-widest">
                <span class="material-symbols-outlined text-sm text-primary-600">location_on</span>
                {{ $place->city->name }}{{ $place->city->country ? ', ' . $place->city->country->name : '' }}
            </div>
        </div>
        
        <div class="animate-slide-left">
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- LEFT COLUMN: Place Content -->
        <div class="lg:col-span-2 space-y-10 animate-slide-right">
            <!-- Hero Card -->
            <div class="relative rounded-xl overflow-hidden bg-slate-50 shadow-2xl border border-white/50 aspect-video group">
                <img src="{{ $place->image }}" alt="{{ $place->name }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                <div class="absolute bottom-10 left-10">
                    <span class="px-4 py-1.5 bg-white/20 rounded-full text-[10px] font-black uppercase tracking-[0.2em] border border-white/30 mb-2 inline-block text-white backdrop-blur-sm">
                        TOP DESTINATION
                    </span>
                </div>
            </div>

            <!-- About The Place -->
            <div class="glass-card p-10 rounded-xl border border-white/50 shadow-xl relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-indigo-100/20 blur-3xl rounded-full"></div>
                <h3 class="text-2xl font-black mb-6 text-slate-900 tracking-tight flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary-600">explore</span>
                    Cultural Heritage
                </h3>
                <div class="relative">
                    <p id="place-description" class="text-slate-600 leading-relaxed text-lg font-medium italic line-clamp-2 transition-all duration-500">
                        "{{ $place->description }}"
                    </p>
                    <button onclick="toggleDescription('place-description', this)" class="mt-4 text-primary-600 font-black text-xs uppercase tracking-[0.2em] hover:text-primary-700 transition-colors flex items-center gap-2">
                        See More <span class="material-symbols-outlined text-sm transition-transform">expand_more</span>
                    </button>
                </div>

                <script>
                    function toggleDescription(id, btn) {
                        const el = document.getElementById(id);
                        const icon = btn.querySelector('.material-symbols-outlined');
                        
                        if (el.classList.contains('line-clamp-2')) {
                            el.classList.remove('line-clamp-2');
                            btn.innerHTML = `See Less <span class="material-symbols-outlined text-sm rotate-180">expand_more</span>`;
                        } else {
                            el.classList.add('line-clamp-2');
                            btn.innerHTML = `See More <span class="material-symbols-outlined text-sm">expand_more</span>`;
                        }
                    }
                </script>
                <div class="mt-8 grid grid-cols-2 gap-4">
                    <div class="p-4 bg-slate-50 rounded-lg border border-slate-100 flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary-600">history_edu</span>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Type</p>
                            <p class="font-bold text-slate-900 text-sm italic">Historical Landmark</p>
                        </div>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-lg border border-slate-100 flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary-600">schedule</span>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Visit Time</p>
                            <p class="font-bold text-slate-900 text-sm italic">2-3 Hours Recommended</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Location Map -->
            @if($place->localisation)
            <div class="glass-card rounded-xl overflow-hidden border border-white/50 shadow-xl">
                <div class="p-8 pb-4">
                    <h3 class="text-2xl font-black text-slate-900 mb-1 tracking-tight flex items-center gap-3">
                        <span class="material-symbols-outlined text-slate-400">near_me</span>
                        Geographical Context
                    </h3>
                    <p class="text-slate-500 font-bold text-xs uppercase tracking-widest ml-9 italic">{{ $place->localisation }}</p>
                </div>

                @php
                    [$lat, $lng] = array_map('trim', explode(',', $place->localisation));
                @endphp
                <div class="mx-8 mb-8 h-[400px] rounded-lg overflow-hidden border border-slate-200 relative grayscale hover:grayscale-0 transition-all duration-700 shadow-inner">
                    <iframe width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen loading="lazy"
                            src="https://maps.google.com/maps?q={{ $lat }},{{ $lng }}&z=15&output=embed">
                    </iframe>
                    <div class="absolute bottom-6 right-6">
                        <a href="https://www.google.com/maps?q={{ urlencode($place->localisation) }}" target="_blank"
                           class="bg-white/90 backdrop-blur-md px-6 py-3 rounded-lg border border-white shadow-xl flex items-center gap-2 text-slate-900 font-black text-sm hover:bg-white transition-all">
                            <span class="material-symbols-outlined text-blue-600">directions</span>
                            Navigate
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Nearby Hotels -->
            <div class="space-y-6">
                <h3 class="text-2xl font-black text-slate-900 tracking-tight ml-2">Luxury Stays Nearby</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($place->city->hotels->take(4) as $hotel)
                    <a href="{{ route('hotels.show', $hotel->id) }}" class="glass-card p-4 rounded-[1.5rem] flex gap-5 border border-white/50 hover:shadow-lg transition-all group">
                        <div class="w-20 h-20 rounded-lg overflow-hidden shrink-0 shadow-sm">
                            <img src="{{ $hotel->image }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="flex flex-col justify-center min-w-0">
                            <h4 class="font-bold text-slate-900 truncate tracking-tight group-hover:text-primary-600 transition-colors">{{ $hotel->name }}</h4>
                            <p class="text-xs font-black text-primary-600 mt-1 uppercase tracking-widest">&euro;{{ number_format($hotel->price_per_night, 0) }} / Nt</p>
                            <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-1 italic">{{ $hotel->city->name }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: Weather & City Info -->
        <div class="lg:col-span-1">
            <div class="sticky top-28 space-y-6 animate-slide-left">
                <!-- Weather Card -->
                <div class="glass-card p-10 rounded-xl shadow-2xl border border-white relative overflow-hidden">
                    <div class="absolute -top-20 -right-20 w-64 h-64 bg-primary-200/20 blur-[80px] rounded-full pointer-events-none"></div>

                    <h3 class="text-2xl font-black text-slate-900 tracking-tight mb-8 relative z-10 flex items-center gap-2">
                        <span class="material-symbols-outlined text-slate-400">cloud</span>
                        Atmosphere
                    </h3>

                    <div id="weather-container" class="relative z-10">
                        <div class="animate-pulse flex flex-col items-center py-6">
                            <div class="h-10 w-10 bg-slate-100 rounded-full mb-3"></div>
                            <div class="h-4 w-24 bg-slate-100 rounded mb-2"></div>
                            <div class="h-8 w-16 bg-slate-100 rounded"></div>
                        </div>
                    </div>

                    <div class="mt-10 pt-10 border-t border-slate-100/50 text-center relative z-10">
                        <p class="text-sm font-black text-slate-400 uppercase tracking-widest italic attribution-text">Climate data provided by wttr.in</p>
                    </div>
                </div>

                <!-- Destination Digest -->
                <div class="glass-card p-8 rounded-xl border border-white shadow-xl">
                    <h4 class="text-lg font-black text-slate-900 tracking-tight mb-6">Destination Digest</h4>
                    <div class="space-y-4">
                        <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-lg border border-slate-100">
                            <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center text-primary-600">
                                <span class="material-symbols-outlined text-lg">public</span>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Territory</p>
                                <p class="font-black text-slate-900 tracking-tight italic">{{ $place->city->country->name }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-lg border border-slate-100">
                            <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center text-indigo-600">
                                <span class="material-symbols-outlined text-lg">apartment</span>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Main City</p>
                                <p class="font-black text-slate-900 tracking-tight italic">{{ $place->city->name }}</p>
                            </div>
                        </div>
                        @if($place->city->trip_type)
                        <div class="flex items-center gap-4 p-4 bg-primary-600 rounded-lg shadow-lg shadow-primary-200">
                            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center text-white">
                                <span class="material-symbols-outlined text-lg">auto_awesome</span>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-white/70 uppercase tracking-widest">Nomado Profile</p>
                                <p class="font-black text-white tracking-tight italic capitalize">{{ $place->city->trip_type }} Trip</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cityName = "{{ $place->city->name }}";
        const weatherContainer = document.getElementById('weather-container');

        fetch(`https://wttr.in/${cityName}?format=j1`)
            .then(response => response.json())
            .then(data => {
                const current = data.current_condition[0];
                const temp = current.temp_C;
                const desc = current.weatherDesc[0].value;
                const humidity = current.humidity;
                const wind = current.windspeedKmph;

                weatherContainer.innerHTML = `
                    <div class="flex flex-col items-center py-4 text-center">
                        <div class="text-8xl font-black text-slate-900 tracking-tighter mb-4">${temp}&nbsp;<span class="text-4xl text-slate-300 font-bold">°C</span></div>
                        <div class="text-lg font-black text-slate-400 uppercase tracking-[0.2em] mb-12 italic">${desc}</div>

                        <div class="grid grid-cols-2 gap-6 w-full">
                            <div class="bg-slate-50 p-6 rounded-lg border border-slate-100 flex flex-col items-center">
                                <span class="material-symbols-outlined text-primary-600 mb-3 text-2xl">water_drop</span>
                                <p class="text-xs text-slate-400 font-black uppercase tracking-widest mb-2">Humidity</p>
                                <p class="font-black text-slate-900 text-2xl">${humidity}%</p>
                            </div>
                            <div class="bg-slate-50 p-6 rounded-lg border border-slate-100 flex flex-col items-center">
                                <span class="material-symbols-outlined text-primary-600 mb-3 text-2xl">air</span>
                                <p class="text-xs text-slate-400 font-black uppercase tracking-widest mb-2">Wind Speed</p>
                                <p class="font-black text-slate-900 text-2xl">${wind} <span class="text-xs">km/h</span></p>
                            </div>
                        </div>
                    </div>
                `;
            })
            .catch(error => {
                weatherContainer.innerHTML = `
                    <div class="text-center py-6">
                        <p class="text-slate-400 text-sm font-bold uppercase italic">Data Sync Offline</p>
                    </div>
                `;
            });
    });
</script>
<style>
    .attribution-text {
        font-size: 11px !important;
    }
</style>
@endsection
