@extends('layouts.app')

@section('content')
<div class="min-h-screen py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Back Button -->
        <a href="{{ url()->previous() }}" class="inline-flex items-center text-sm font-semibold text-gray-500 hover:text-gray-900 transition-colors mb-8 group">
            <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back
        </a>

        <!-- Hero Image -->
        <div class="relative h-[420px] rounded-2xl overflow-hidden shadow-sm border border-gray-200 mb-10">
            <img src="{{ $hotel->image }}" alt="{{ $hotel->name }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent flex flex-col justify-end p-10">
                <!-- Badges -->
                <div class="flex flex-wrap items-center gap-3 mb-4">
                    @if($hotel->type)
                        <span class="bg-primary-600 text-white text-xs font-bold px-4 py-1.5 rounded-lg uppercase tracking-wider">
                            {{ $hotel->getTypeLabel() }}
                        </span>
                    @endif
                    @if($hotel->city)
                        <span class="bg-white/20 text-white text-xs font-semibold px-4 py-1.5 rounded-lg border border-white/30">
                            {{ $hotel->city->name }}{{ $hotel->city->country ? ', ' . $hotel->city->country->name : '' }}
                        </span>
                    @endif
                </div>
                <h1 class="text-white text-4xl font-bold leading-tight drop-shadow-lg mb-2">{{ $hotel->name }}</h1>
                <p class="text-white/80 text-base font-medium">
                    From <span class="text-white font-bold text-xl">{{ number_format($hotel->price_per_night, 0) }} &euro;</span>
                    <span class="text-white/60 text-sm"> per night</span>
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">

                <!-- Description -->
                <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-3">
                        <span class="w-10 h-10 bg-primary-50 rounded-lg flex items-center justify-center text-primary-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </span>
                        About
                    </h2>
                    <p class="text-gray-600 leading-relaxed">{{ $hotel->description }}</p>
                </div>

                <!-- Location Map Section -->
                @if($hotel->localisation)
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-200">
                    <div class="p-8 pb-4">
                        <h2 class="text-xl font-bold text-gray-900 mb-1 flex items-center gap-3">
                            <span class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            </span>
                            Location
                        </h2>
                        <p class="text-gray-500 text-sm ml-[52px]">{{ $hotel->localisation }}</p>
                    </div>

                    <!-- Google Maps iframe -->
                    @php
                        [$lat, $lng] = array_map('trim', explode(',', $hotel->localisation));
                    @endphp
                    <div class="relative mx-8 mb-6 rounded-lg overflow-hidden border border-gray-100" style="height: 320px;">
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
                           class="w-full flex items-center justify-center gap-2 py-3 px-6 bg-gray-900 hover:bg-gray-800 text-white font-semibold rounded-xl transition-colors text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            Open in Google Maps
                        </a>
                    </div>
                </div>
                @endif

            </div>

            <!-- Sidebar: Contact & Booking -->
            <div class="space-y-6">

                <!-- Price Card -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-200">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Price per night</p>
                    <p class="text-3xl font-bold text-primary-600 mb-1">{{ number_format($hotel->price_per_night, 0) }} &euro;</p>
                    <p class="text-sm text-gray-500">Taxes not included</p>

                    <a href="{{ route('trip.index') }}" class="mt-5 w-full flex items-center justify-center gap-2 py-3 px-6 bg-gray-900 hover:bg-primary-600 text-white font-semibold rounded-xl transition-colors text-sm">
                        Generate a trip
                    </a>
                </div>

                <!-- Contact Card -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-200">
                    <h3 class="text-base font-bold text-gray-900 mb-4">Contact Hotel</h3>

                    <div class="space-y-3">
                        <!-- Call Button -->
                        @if($hotel->contact_number)
                        <a href="tel:{{ $hotel->contact_number }}"
                           class="flex items-center gap-3 w-full py-3 px-4 bg-gray-50 hover:bg-gray-100 border border-gray-200 text-gray-700 font-medium rounded-xl transition-all group">
                            <span class="w-9 h-9 bg-gray-100 group-hover:bg-gray-200 rounded-lg flex items-center justify-center text-gray-600 shrink-0 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </span>
                            <div class="text-left overflow-hidden">
                                <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Call</p>
                                <p class="text-sm font-bold text-gray-900 truncate">{{ $hotel->contact_number }}</p>
                            </div>
                        </a>
                        @endif

                        <!-- Email Button -->
                        @if($hotel->email)
                        <a href="mailto:{{ $hotel->email }}"
                           class="flex items-center gap-3 w-full py-3 px-4 bg-gray-50 hover:bg-gray-100 border border-gray-200 text-gray-700 font-medium rounded-xl transition-all group">
                            <span class="w-9 h-9 bg-gray-100 group-hover:bg-gray-200 rounded-lg flex items-center justify-center text-gray-600 shrink-0 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </span>
                            <div class="text-left overflow-hidden">
                                <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Email</p>
                                <p class="text-sm font-bold text-gray-900 truncate">{{ $hotel->email }}</p>
                            </div>
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Location Info Card -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-200">
                    <h3 class="font-bold text-base mb-4 text-gray-900">Location Info</h3>
                    <div class="space-y-3 text-sm">
                        @if($hotel->city)
                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                                <svg class="w-4 h-4 text-gray-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                <div>
                                    <p class="text-xs text-gray-400 font-semibold uppercase">City</p>
                                    <p class="font-semibold text-gray-900">{{ $hotel->city->name }}</p>
                                </div>
                            </div>
                            @if($hotel->city->country)
                                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                                    <svg class="w-4 h-4 text-gray-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <div>
                                        <p class="text-xs text-gray-400 font-semibold uppercase">Country</p>
                                        <p class="font-semibold text-gray-900">{{ $hotel->city->country->name }}</p>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
