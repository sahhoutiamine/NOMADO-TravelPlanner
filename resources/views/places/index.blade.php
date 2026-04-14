<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-900 leading-tight">
            🌍 {{ __('Explorer les Destinations') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Filter Section -->
            <div class="mb-10 bg-white p-6 rounded-2xl shadow-sm">
                <form action="{{ route('places.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Rechercher un lieu</label>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               class="w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 transition-all text-gray-900"
                               placeholder="Ex: Tour Eiffel, Kyoto...">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Par Pays</label>
                        <select name="country_id" class="w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 transition-all text-gray-900">
                            <option value="">Tous les pays</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}" {{ request('country_id') == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full py-2.5 px-6 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                            🔍 Appliquer les filtres
                        </button>
                    </div>
                </form>
            </div>

            <!-- Places Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @forelse($places as $place)
                    <div class="group bg-white rounded-3xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 flex flex-col h-full border border-gray-100 relative">
                        <!-- Clickable Area -->
                        <a href="{{ route('places.show', $place->id) }}" class="absolute inset-0 z-10" aria-label="Voir les détails de {{ $place->name }}"></a>
                        
                        <!-- Image Container -->
                        <div class="relative h-60 overflow-hidden">
                            <img src="{{ $place->image }}" alt="{{ $place->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-md px-3 py-1 rounded-full text-xs font-black text-blue-600 shadow-sm uppercase tracking-widest z-20">
                                {{ $place->city->country->name ?? 'Destination' }}
                            </div>
                            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/60 to-transparent p-4">
                                <p class="text-white font-bold text-xl drop-shadow-md">{{ $place->name }}</p>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6 flex-grow flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-4 relative z-20">
                                    <span class="flex items-center text-amber-500 font-bold">
                                        ⭐ {{ number_format($place->rating ?? 4.5, 1) }}
                                    </span>
                                    @if($place->localisation)
                                        <a href="https://www.google.com/maps?q={{ urlencode($place->localisation) }}" target="_blank" class="text-gray-400 hover:text-green-600 text-xs font-medium bg-gray-50 px-2.5 py-1 rounded-lg transition-all hover:bg-green-50" title="Voir sur Google Maps">
                                            📍 {{ $place->city->name ?? 'Voir Map' }}
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-xs font-medium bg-gray-50 px-2.5 py-1 rounded-lg">
                                            📍 {{ $place->city->name ?? '' }}
                                        </span>
                                    @endif
                                </div>
                                <p class="text-gray-600 text-sm line-clamp-2 leading-relaxed mb-6 italic">
                                    "{{ $place->description }}"
                                </p>
                            </div>
                            
                            <div class="flex items-center justify-between pt-4 border-t border-gray-50 relative z-20">
                                <div class="text-xs text-gray-500 font-bold uppercase tracking-wider">
                                    🏨 {{ $place->city->hotels->count() }} Hôtels
                                </div>
                                <div class="flex items-center gap-3">
                                    @if($place->localisation)
                                        <a href="https://www.google.com/maps?q={{ urlencode($place->localisation) }}" target="_blank" class="text-sm font-black text-green-600 hover:text-green-800 transition-colors" title="Voir sur Google Maps">
                                            🗺️
                                        </a>
                                    @endif
                                    <span class="inline-flex items-center text-sm font-black text-blue-600 group-hover:text-blue-800 transition-colors uppercase tracking-tight">
                                        Voir Détails &rarr;
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center bg-white rounded-3xl shadow-sm border border-dashed border-gray-200">
                        <span class="text-6xl mb-4 block">🏝️</span>
                        <h4 class="text-xl font-bold text-gray-900">Aucun lieu ne correspond à votre recherche.</h4>
                        <p class="text-gray-500 mt-2">Essayez de modifier vos filtres ou de rechercher un autre mot-clé.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $places->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
