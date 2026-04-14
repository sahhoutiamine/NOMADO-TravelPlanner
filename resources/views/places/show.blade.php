<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-900 leading-tight">
            📍 {{ $place->name }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Back Button --}}
            <a href="{{ route('places.index') }}" class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-blue-600 transition-colors mb-8 group">
                <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Retour aux destinations
            </a>

            {{-- Hero Section --}}
            <div class="relative h-[500px] rounded-3xl overflow-hidden shadow-2xl mb-12 transform transition-all duration-700 hover:shadow-blue-200/50">
                <img src="{{ $place->image }}" alt="{{ $place->name }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent flex flex-col justify-end p-8 md:p-16">
                    <div class="flex flex-wrap items-center gap-4 mb-6">
                        @if($place->city->country)
                            <span class="bg-blue-600 text-white text-xs font-black px-5 py-2 rounded-full uppercase tracking-widest shadow-lg">
                                🌍 {{ $place->city->country->name }}
                            </span>
                        @endif
                        <span class="bg-white/20 backdrop-blur-md text-white text-xs font-bold px-5 py-2 rounded-full border border-white/30 uppercase tracking-wider">
                            🏙️ {{ $place->city->name }}
                        </span>
                        <span class="bg-amber-400 text-amber-900 text-xs font-black px-5 py-2 rounded-full uppercase tracking-widest shadow-lg">
                            ⭐ {{ number_format($place->rating ?? 4.8, 1) }}
                        </span>
                    </div>
                    <h1 class="text-white text-5xl md:text-7xl font-black mb-4 leading-tight drop-shadow-2xl">{{ $place->name }}</h1>
                    <p class="text-white/80 text-lg md:text-xl font-medium max-w-3xl italic line-clamp-2">
                        "{{ $place->description }}"
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                {{-- Main Content Column --}}
                <div class="lg:col-span-2 space-y-10">
                    
                    {{-- About Section --}}
                    <div class="bg-white rounded-3xl shadow-sm p-10 border border-gray-100">
                        <h2 class="text-3xl font-black text-gray-900 mb-6 flex items-center gap-4">
                            <span class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </span>
                            À propos du lieu
                        </h2>
                        <div class="prose prose-blue max-w-none text-gray-600 text-lg leading-relaxed">
                            {{ $place->description }}
                        </div>
                    </div>

                    {{-- Localisation Map Section --}}
                    @if($place->localisation)
                    <div class="bg-white rounded-3xl shadow-sm overflow-hidden border border-gray-100">
                        <div class="p-10 pb-6">
                            <h2 class="text-3xl font-black text-gray-900 mb-2 flex items-center gap-4">
                                <span class="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center text-green-600 text-xl">
                                    🗺️
                                </span>
                                Localisation
                            </h2>
                            <p class="text-gray-500 ml-16 font-medium">Coordonnées géographiques: {{ $place->localisation }}</p>
                        </div>

                        {{-- Map --}}
                        @php
                            [$lat, $lng] = array_map('trim', explode(',', $place->localisation));
                        @endphp
                        <div class="mx-10 mb-8 rounded-3xl overflow-hidden border border-gray-100 shadow-inner h-[400px]">
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

                        <div class="px-10 pb-10">
                            <a href="https://www.google.com/maps?q={{ urlencode($place->localisation) }}" target="_blank"
                               class="w-full flex items-center justify-center gap-4 py-5 px-8 bg-green-500 hover:bg-green-600 text-white font-black rounded-2xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1 text-lg uppercase tracking-widest">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Ouvrir dans Google Maps
                            </a>
                        </div>
                    </div>
                    @endif

                    {{-- Nearby Hotels --}}
                    <div class="space-y-6">
                        <h2 class="text-2xl font-black text-gray-900 flex items-center gap-3">
                            <span class="text-blue-600">🏨</span> Hébergements à {{ $place->city->name }}
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($place->city->hotels->take(4) as $hotel)
                                <a href="{{ route('hotels.show', $hotel->id) }}" class="group flex bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all border border-gray-100">
                                    <div class="w-32 h-32 shrink-0">
                                        <img src="{{ $hotel->image }}" alt="{{ $hotel->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    </div>
                                    <div class="p-4 flex flex-col justify-center overflow-hidden">
                                        <h4 class="font-black text-gray-900 truncate group-hover:text-blue-600 transition-colors">{{ $hotel->name }}</h4>
                                        <p class="text-blue-600 font-bold text-sm">{{ number_format($hotel->price_per_night, 0) }} € / nuit</p>
                                        <span class="text-xs text-gray-400 mt-1">📍 {{ $hotel->city->name }}</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Sidebar Column --}}
                <div class="space-y-8">
                    
                    {{-- Weather Section (Meteo) --}}
                    <div class="bg-gradient-to-br from-blue-500 to-indigo-700 rounded-3xl shadow-xl p-8 text-white overflow-hidden relative group">
                        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:bg-white/20 transition-all"></div>
                        
                        <h3 class="text-xl font-black mb-6 flex items-center gap-3 relative">
                            <span>🌤️</span> Méteo à {{ $place->city->name }}
                        </h3>

                        <div id="weather-container" class="relative">
                            <div class="animate-pulse flex flex-col items-center py-6">
                                <div class="h-12 w-12 bg-white/20 rounded-full mb-4"></div>
                                <div class="h-4 w-24 bg-white/20 rounded mb-2"></div>
                                <div class="h-8 w-16 bg-white/20 rounded"></div>
                            </div>
                        </div>

                        <p class="text-xs text-white/60 mt-4 italic text-center">Données en temps réel via wttr.in</p>
                    </div>

                    {{-- City Info Card --}}
                    <div class="bg-white rounded-3xl shadow-sm p-8 border border-gray-100">
                        <h3 class="text-lg font-black text-gray-900 mb-6 flex items-center gap-3">
                            <span class="text-purple-600 text-xl">ℹ️</span> Infos Destination
                        </h3>
                        <div class="space-y-5">
                            <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-2xl">
                                <span class="text-2xl">🌍</span>
                                <div>
                                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Pays</p>
                                    <p class="font-black text-gray-900">{{ $place->city->country->name }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-2xl">
                                <span class="text-2xl">🏙️</span>
                                <div>
                                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Ville</p>
                                    <p class="font-black text-gray-900">{{ $place->city->name }}</p>
                                </div>
                            </div>
                            @if($place->city->trip_type)
                            <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-2xl border-l-4 border-blue-500">
                                <span class="text-2xl">✨</span>
                                <div>
                                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Style de voyage</p>
                                    <p class="font-black text-blue-600 capitalize">{{ $place->city->trip_type }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Call to Action Card --}}
                    <div class="bg-gray-900 rounded-3xl shadow-xl p-8 text-white">
                        <h3 class="text-xl font-black mb-4">Prêt à partir ?</h3>
                        <p class="text-gray-400 text-sm mb-6 leading-relaxed">Générez un itinéraire personnalisé incluant {{ $place->name }} en quelques clics.</p>
                        <a href="{{ route('trip.index') }}" class="w-full flex items-center justify-center gap-3 py-4 px-6 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-2xl shadow-lg hover:shadow-blue-500/30 transition-all transform hover:-translate-y-1 text-sm uppercase tracking-widest">
                            🚀 Créer mon voyage
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Weather Script --}}
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
                    const desc = current.lang_fr ? current.lang_fr[0].value : current.weatherDesc[0].value;
                    const humidity = current.humidity;
                    const wind = current.windspeedKmph;

                    weatherContainer.innerHTML = `
                        <div class="flex flex-col items-center py-4 text-center">
                            <div class="text-6xl mb-4 drop-shadow-lg">${getWeatherEmoji(current.weatherCode)}</div>
                            <div class="text-5xl font-black mb-1">${temp}°C</div>
                            <div class="text-lg font-bold text-white/90 mb-6 uppercase tracking-wider">${desc}</div>
                            
                            <div class="grid grid-cols-2 gap-4 w-full">
                                <div class="bg-white/10 backdrop-blur-sm p-3 rounded-2xl border border-white/10">
                                    <p class="text-[10px] text-white/60 font-black uppercase tracking-widest mb-1">Humidité</p>
                                    <p class="font-black text-sm">${humidity}%</p>
                                </div>
                                <div class="bg-white/10 backdrop-blur-sm p-3 rounded-2xl border border-white/10">
                                    <p class="text-[10px] text-white/60 font-black uppercase tracking-widest mb-1">Vent</p>
                                    <p class="font-black text-sm">${wind} km/h</p>
                                </div>
                            </div>
                        </div>
                    `;
                })
                .catch(error => {
                    console.error('Weather error:', error);
                    weatherContainer.innerHTML = `
                        <div class="text-center py-8">
                            <p class="text-white/60 italic">Données météo non disponibles</p>
                        </div>
                    `;
                });

            function getWeatherEmoji(code) {
                const codes = {
                    '113': '☀️', // Clear/Sunny
                    '116': '⛅', // Partly cloudy
                    '119': '☁️', // Cloudy
                    '122': '☁️', // Overcast
                    '143': '🌫️', // Mist
                    '176': '🌦️', // Patchy rain possible
                    '179': '🌨️', // Patchy snow possible
                    '182': '🌨️', // Patchy sleet possible
                    '185': '🌨️', // Patchy freezing drizzle possible
                    '200': '⛈️', // Thundery outbreaks possible
                    '227': '🌬️', // Blowing snow
                    '230': '❄️', // Blizzard
                    '248': '🌫️', // Fog
                    '260': '🌫️', // Freezing fog
                    '263': '🌦️', // Patchy light drizzle
                    '266': '🌦️', // Light drizzle
                    '281': '🌧️', // Freezing drizzle
                    '284': '🌧️', // Heavy freezing drizzle
                    '293': '🌦️', // Patchy light rain
                    '296': '🌧️', // Light rain
                    '299': '🌧️', // Moderate rain at times
                    '302': '🌧️', // Moderate rain
                    '305': '🌧️', // Heavy rain at times
                    '308': '🌧️', // Heavy rain
                };
                return codes[code] || '🌡️';
            }
        });
    </script>
</x-app-layout>
