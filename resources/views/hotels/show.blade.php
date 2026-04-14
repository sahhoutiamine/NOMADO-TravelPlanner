<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-900 leading-tight">
            🏨 {{ $hotel->name }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            {{-- Back Button --}}
            <a href="{{ url()->previous() }}" class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-blue-600 transition-colors mb-8 group">
                <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Retour
            </a>

            {{-- Hero Image --}}
            <div class="relative h-[480px] rounded-3xl overflow-hidden shadow-2xl mb-10">
                <img src="{{ $hotel->image }}" alt="{{ $hotel->name }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent flex flex-col justify-end p-10">
                    {{-- Type Badge --}}
                    <div class="flex flex-wrap items-center gap-3 mb-4">
                        @if($hotel->type)
                            <span class="bg-blue-600 text-white text-xs font-black px-4 py-1.5 rounded-full uppercase tracking-widest shadow-lg">
                                {{ $hotel->getTypeLabel() }}
                            </span>
                        @endif
                        @if($hotel->city)
                            <span class="bg-white/20 backdrop-blur text-white text-xs font-bold px-4 py-1.5 rounded-full border border-white/30">
                                📍 {{ $hotel->city->name }}{{ $hotel->city->country ? ', ' . $hotel->city->country->name : '' }}
                            </span>
                        @endif
                    </div>
                    <h1 class="text-white text-5xl font-black leading-tight drop-shadow-2xl mb-3">{{ $hotel->name }}</h1>
                    <p class="text-white/80 text-xl font-semibold">
                        À partir de <span class="text-white font-black text-3xl">{{ number_format($hotel->price_per_night, 0) }} €</span>
                        <span class="text-white/60 text-base font-normal"> / nuit</span>
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Main Content --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- Description --}}
                    <div class="bg-white rounded-3xl shadow-md p-8">
                        <h2 class="text-2xl font-black text-gray-900 mb-4 flex items-center gap-3">
                            <span class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </span>
                            À propos de cet hôtel
                        </h2>
                        <p class="text-gray-600 leading-relaxed text-lg">{{ $hotel->description }}</p>
                    </div>

                    {{-- Location Map Section --}}
                    @if($hotel->localisation)
                    <div class="bg-white rounded-3xl shadow-md overflow-hidden">
                        <div class="p-8 pb-4">
                            <h2 class="text-2xl font-black text-gray-900 mb-1 flex items-center gap-3">
                                <span class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center text-green-600">
                                    🗺️
                                </span>
                                Localisation
                            </h2>
                            <p class="text-gray-500 text-sm ml-14">Coordonnées : {{ $hotel->localisation }}</p>
                        </div>

                        {{-- Embedded Google Maps iframe --}}
                        @php
                            [$lat, $lng] = array_map('trim', explode(',', $hotel->localisation));
                        @endphp
                        <div class="relative mx-8 mb-6 rounded-2xl overflow-hidden border border-gray-100 shadow-sm" style="height: 320px;">
                            <iframe
                                width="100%"
                                height="100%"
                                frameborder="0"
                                style="border:0"
                                allowfullscreen
                                loading="lazy"
                                src="https://maps.google.com/maps?q={{ $lat }},{{ $lng }}&z=15&output=embed">
                            </iframe>
                        </div>

                        <div class="px-8 pb-8">
                            <a href="https://www.google.com/maps?q={{ urlencode($hotel->localisation) }}" target="_blank"
                               class="w-full flex items-center justify-center gap-3 py-4 px-6 bg-green-500 hover:bg-green-600 text-white font-black rounded-2xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 text-base uppercase tracking-wider">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Ouvrir dans Google Maps
                            </a>
                        </div>
                    </div>
                    @endif

                </div>

                {{-- Sidebar: Contact & Booking --}}
                <div class="space-y-6">

                    {{-- Price Card --}}
                    <div class="bg-white rounded-3xl shadow-md p-6 border-t-4 border-blue-500">
                        <p class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-1">Prix par nuit</p>
                        <p class="text-4xl font-black text-blue-600 mb-1">{{ number_format($hotel->price_per_night, 0) }} €</p>
                        <p class="text-sm text-gray-400">Taxes non incluses</p>

                        <a href="{{ route('trip.index') }}" class="mt-6 w-full flex items-center justify-center gap-2 py-3.5 px-6 bg-gray-900 hover:bg-blue-600 text-white font-black rounded-2xl shadow-md hover:shadow-xl transition-all transform hover:-translate-y-0.5 text-sm uppercase tracking-wider">
                            ✈️ Générer un voyage ici
                        </a>
                    </div>

                    {{-- Contact Card --}}
                    <div class="bg-white rounded-3xl shadow-md p-6">
                        <h3 class="text-lg font-black text-gray-900 mb-5 flex items-center gap-2">
                            <span class="text-purple-600">📞</span> Contacter l'hôtel
                        </h3>

                        <div class="space-y-3">
                            {{-- Call Button --}}
                            @if($hotel->contact_number)
                            <a href="tel:{{ $hotel->contact_number }}"
                               class="flex items-center gap-4 w-full py-3.5 px-5 bg-blue-50 hover:bg-blue-100 border border-blue-200 hover:border-blue-400 text-blue-700 font-bold rounded-2xl transition-all group">
                                <span class="w-10 h-10 bg-blue-100 group-hover:bg-blue-200 rounded-xl flex items-center justify-center text-blue-600 shrink-0 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                </span>
                                <div class="text-left overflow-hidden">
                                    <p class="text-xs text-blue-500 font-semibold uppercase tracking-wider">Appeler</p>
                                    <p class="text-sm font-black text-blue-900 truncate">{{ $hotel->contact_number }}</p>
                                </div>
                            </a>
                            @endif

                            {{-- Email Button --}}
                            @if($hotel->email)
                            <a href="https://mail.google.com/mail/?view=cm&to={{ $hotel->email }}&su=Demande%20de%20r%C3%A9servation%20-%20{{ urlencode($hotel->name) }}&body=Bonjour%2C%0A%0AJe%20souhaite%20obtenir%20des%20informations%20sur%20une%20r%C3%A9servation%20dans%20votre%20%C3%A9tablissement."
                               target="_blank"
                               class="flex items-center gap-4 w-full py-3.5 px-5 bg-red-50 hover:bg-red-100 border border-red-200 hover:border-red-400 text-red-700 font-bold rounded-2xl transition-all group">
                                <span class="w-10 h-10 bg-red-100 group-hover:bg-red-200 rounded-xl flex items-center justify-center text-red-600 shrink-0 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </span>
                                <div class="text-left overflow-hidden">
                                    <p class="text-xs text-red-500 font-semibold uppercase tracking-wider">Envoyer un e-mail</p>
                                    <p class="text-sm font-black text-red-900 truncate">{{ $hotel->email }}</p>
                                </div>
                            </a>
                            @endif
                        </div>
                    </div>

                    {{-- Info Card --}}
                    <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-3xl shadow-xl p-6 text-white">
                        <h3 class="font-black text-lg mb-4">📍 Location</h3>
                        <div class="space-y-2 text-white/90 text-sm font-medium">
                            @if($hotel->city)
                                <p>🏙️ <span class="font-bold">{{ $hotel->city->name }}</span></p>
                                @if($hotel->city->country)
                                    <p>🌍 <span class="font-bold">{{ $hotel->city->country->name }}</span></p>
                                @endif
                            @endif
                            @if($hotel->localisation)
                                <p class="mt-3 text-xs text-white/70 bg-white/10 px-3 py-2 rounded-xl font-mono">{{ $hotel->localisation }}</p>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
