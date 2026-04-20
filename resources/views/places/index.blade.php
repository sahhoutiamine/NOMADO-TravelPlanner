@extends('layouts.app')

@section('content')
<div class="min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Page Header -->
        <div class="mb-8 animate-on-scroll fade-in">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Destinations</h1>
        </div>

        <!-- Filter Section -->
        <div class="mb-10 bg-white rounded-2xl border border-gray-200 shadow-sm p-6 animate-on-scroll fade-in">
            <form action="{{ route('places.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-colors bg-white placeholder:text-gray-400"
                           placeholder="e.g. Eiffel Tower, Kyoto...">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Filter by Country</label>
                    <select name="country_id" class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-colors bg-white">
                        <option value="">All countries</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}" {{ request('country_id') == $country->id ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full py-3 px-6 bg-gray-900 hover:bg-primary-600 text-white font-semibold rounded-xl transition-colors text-sm">
                        Apply
                    </button>
                </div>
            </form>
        </div>

        <!-- Places Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($places as $index => $place)
                <div class="group bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-sm hover:shadow-md transition-shadow flex flex-col h-full relative animate-on-scroll slide-in-up" style="animation-delay: {{ (0.05 * ($index + 1) > 0.4) ? '0.4s' : 0.05 * ($index + 1) }}s;">
                    <!-- Clickable Area -->
                    <a href="{{ route('places.show', $place->id) }}" class="absolute inset-0 z-10" aria-label="View details of {{ $place->name }}"></a>

                    <!-- Image Container -->
                    <div class="relative h-52 overflow-hidden">
                        <img src="{{ $place->image }}" alt="{{ $place->name }}" class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-700">
                        <div class="absolute top-3 right-3 bg-white text-gray-700 text-xs font-semibold px-3 py-1 rounded-lg shadow-sm z-20 country-badge">
                            {{ $place->city->country->name ?? 'Destination' }}
                        </div>
                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/60 to-transparent p-4">
                            <p class="text-white font-bold text-lg drop-shadow-md">{{ $place->name }}</p>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-5 flex-grow flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-3 relative z-20">
                                <span class="flex items-center text-amber-500 font-semibold text-sm gap-1">
                                    <svg class="w-4 h-4 fill-amber-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    {{ number_format($place->rating ?? 4.5, 1) }}
                                </span>
                                <span class="flex items-center text-gray-400 text-xs font-medium gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                    {{ $place->city->name ?? '' }}
                                </span>
                            </div>
                            <p class="text-gray-500 text-sm line-clamp-2 leading-relaxed mb-4">
                                {{ $place->description }}
                            </p>
                        </div>

                        <div class="flex items-center justify-between pt-3 border-t border-gray-100 relative z-20">
                            <div class="flex items-center text-xs text-gray-400 font-medium gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                {{ $place->city->hotels->count() }} Hotels
                            </div>
                            <div class="flex items-center gap-3">
                                @if($place->localisation)
                                    <a href="https://www.google.com/maps?q={{ urlencode($place->localisation) }}" target="_blank" class="text-gray-400 hover:text-primary-600 transition-colors" title="Open in Google Maps">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                @endif
                                <span class="text-primary-600 font-semibold text-sm">View Details</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center bg-white rounded-2xl border border-gray-200 shadow-sm animate-on-scroll fade-in">
                    <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4 floating-empty-icon">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                    </div>
                    <h4 class="text-lg font-bold text-gray-900">No destinations found</h4>
                    <p class="text-gray-500 mt-1 text-sm">Try adjusting your filters</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $places->links() }}
        </div>

    </div>
</div>

<style>
    .country-badge {
        animation: slideFromRight 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
    }

    .group:hover .country-badge {
        animation: slideFromRight 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes slideFromRight {
        from {
            opacity: 0;
            transform: translateX(20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .floating-empty-icon {
        animation: floatingIcon 3s ease-in-out infinite;
    }

    @keyframes floatingIcon {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    .group-hover\:scale-108:hover {
        transform: scale(1.08);
    }

    /* Enhanced scale for cards on hover */
    .group:hover img {
        transform: scale(1.08);
    }

    @media (prefers-reduced-motion: reduce) {
        .country-badge, .floating-empty-icon, .group:hover img {
            animation: none;
            transform: none;
            opacity: 1;
        }
    }
</style>
@endsection
