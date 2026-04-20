@extends('layouts.app')

@section('content')
<div class="min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Back Button -->
        <a href="{{ request('booking_id') ? route('bookings.show', request('booking_id')) : route('places.index') }}" class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-gray-900 transition-colors mb-8 group">
            <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to Destinations
        </a>

        <!-- Hero Section -->
        <div class="relative h-[480px] rounded-2xl overflow-hidden shadow-sm border border-gray-200 mb-10">
            <img src="{{ $place->image }}" alt="{{ $place->name }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent flex flex-col justify-end p-8 md:p-12">
                <div class="flex flex-wrap items-center gap-3 mb-4">
                    @if($place->city->country)
                        <span class="bg-primary-600 text-white text-xs font-bold px-4 py-1.5 rounded-lg uppercase tracking-wider">
                            {{ $place->city->country->name }}
                        </span>
                    @endif
                    <span class="bg-white/20 text-white text-xs font-semibold px-4 py-1.5 rounded-lg border border-white/30 uppercase tracking-wider">
                        {{ $place->city->name }}
                    </span>
                    <span class="bg-amber-400 text-amber-900 text-xs font-bold px-3 py-1.5 rounded-lg flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 fill-amber-900" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        {{ number_format($place->rating ?? 4.8, 1) }}
                    </span>
                </div>
                <h1 class="text-white text-4xl md:text-5xl font-bold mb-3 leading-tight drop-shadow-lg">{{ $place->name }}</h1>
                <p class="text-white/80 text-base font-medium max-w-3xl line-clamp-2">
                    {{ $place->description }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Main Content Column -->
            <div class="lg:col-span-2 space-y-8">

                <!-- About Section -->
                <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-3">
                        <span class="w-10 h-10 bg-primary-50 rounded-lg flex items-center justify-center text-primary-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </span>
                        About this place
                    </h2>
                    <p class="text-gray-600 leading-relaxed">
                        {{ $place->description }}
                    </p>
                </div>

                <!-- Location Map Section -->
                @if($place->localisation)
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-200">
                    <div class="p-8 pb-4">
                        <h2 class="text-xl font-bold text-gray-900 mb-1 flex items-center gap-3">
                            <span class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            </span>
                            Location
                        </h2>
                        <p class="text-gray-500 text-sm ml-[52px]">{{ $place->localisation }}</p>
                    </div>

                    <!-- Map -->
                    @php
                        [$lat, $lng] = array_map('trim', explode(',', $place->localisation));
                    @endphp
                    <div class="mx-8 mb-6 rounded-lg overflow-hidden border border-gray-100" style="height: 400px;">
                        <iframe
                            width="100%"
                            height="100%"
                            frameborder="0"
                            style="border:0"
                            allowfullscreen
                            loading="lazy"
                            src="https://maps.google.com/maps?q={{ $lat }},{{ $lng }}&z=14&output=embed">
                        </iframe>
                    </div>

                    <div class="px-8 pb-8">
                        <a href="https://www.google.com/maps?q={{ urlencode($place->localisation) }}" target="_blank"
                           class="w-full flex items-center justify-center gap-2 py-3 px-6 bg-gray-900 hover:bg-gray-800 text-white font-semibold rounded-xl transition-colors text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            Open in Google Maps
                        </a>
                    </div>
                </div>
                @endif

                <!-- Nearby Hotels -->
                <div class="space-y-5">
                    <h2 class="text-xl font-bold text-gray-900">Hotels in {{ $place->city->name }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($place->city->hotels->take(4) as $hotel)
                            <a href="{{ route('hotels.show', $hotel->id) }}" class="group flex bg-white rounded-xl overflow-hidden border border-gray-200 shadow-sm hover:shadow-md transition-all">
                                <div class="w-24 h-24 shrink-0">
                                    <img src="{{ $hotel->image }}" alt="{{ $hotel->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                </div>
                                <div class="p-4 flex flex-col justify-center overflow-hidden">
                                    <h4 class="font-bold text-gray-900 truncate group-hover:text-primary-600 transition-colors text-sm">{{ $hotel->name }}</h4>
                                    <p class="text-primary-600 font-semibold text-sm">{{ number_format($hotel->price_per_night, 0) }} &euro; / night</p>
                                    <span class="text-xs text-gray-500 mt-0.5">{{ $hotel->city->name }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Sidebar Column -->
            <div class="space-y-6">

                <!-- Weather Section -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-200">
                    <h3 class="text-base font-bold text-gray-900 mb-5 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/></svg>
                        Weather in {{ $place->city->name }}
                    </h3>

                    <div id="weather-container">
                        <div class="animate-pulse flex flex-col items-center py-6">
                            <div class="h-10 w-10 bg-gray-100 rounded-full mb-3"></div>
                            <div class="h-4 w-20 bg-gray-100 rounded mb-2"></div>
                            <div class="h-6 w-12 bg-gray-100 rounded"></div>
                        </div>
                    </div>

                    <p class="text-xs text-gray-400 mt-4 text-center">Real-time data via wttr.in</p>
                </div>

                <!-- City Info Card -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-200">
                    <h3 class="text-base font-bold text-gray-900 mb-5">Destination Info</h3>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                            <svg class="w-4 h-4 text-gray-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <div>
                                <p class="text-xs text-gray-400 font-semibold uppercase">Country</p>
                                <p class="font-semibold text-gray-900 text-sm">{{ $place->city->country->name }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                            <svg class="w-4 h-4 text-gray-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            <div>
                                <p class="text-xs text-gray-400 font-semibold uppercase">City</p>
                                <p class="font-semibold text-gray-900 text-sm">{{ $place->city->name }}</p>
                            </div>
                        </div>
                        @if($place->city->trip_type)
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg border-l-4 border-primary-600">
                            <svg class="w-4 h-4 text-gray-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            <div>
                                <p class="text-xs text-gray-400 font-semibold uppercase">Trip Style</p>
                                <p class="font-semibold text-primary-600 capitalize text-sm">{{ $place->city->trip_type }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Call to Action Card -->
                <div class="bg-gray-900 rounded-2xl shadow-sm p-6 text-white">
                    <h3 class="text-base font-bold mb-2">Ready to go?</h3>
                    <p class="text-gray-400 text-sm mb-5 leading-relaxed">Generate a custom itinerary including {{ $place->name }} in seconds.</p>
                    <a href="{{ route('trip.index') }}" class="w-full flex items-center justify-center gap-2 py-3 px-6 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-xl transition-colors text-sm">
                        Create my trip
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Weather Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cityName = "{{ $place->city->name }}";
        const weatherContainer = document.getElementById('weather-container');

        // Using wttr.in JSON API
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
                        <div class="text-3xl font-bold text-gray-900 mb-1">${temp}°C</div>
                        <div class="text-sm font-semibold text-gray-600 mb-4 uppercase tracking-wider">${desc}</div>

                        <div class="grid grid-cols-2 gap-3 w-full">
                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">Humidity</p>
                                <p class="font-bold text-gray-900 text-sm">${humidity}%</p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">Wind</p>
                                <p class="font-bold text-gray-900 text-sm">${wind} km/h</p>
                            </div>
                        </div>
                    </div>
                `;
            })
            .catch(error => {
                console.error('Weather error:', error);
                weatherContainer.innerHTML = `
                    <div class="text-center py-6">
                        <p class="text-gray-400 text-sm">Weather data unavailable</p>
                    </div>
                `;
            });
    });
</script>
@endsection
