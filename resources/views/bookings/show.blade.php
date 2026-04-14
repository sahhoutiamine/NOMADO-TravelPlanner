<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Détails du Voyage: ') }} {{ $booking->city->name ?? 'Destination' }}, {{ $booking->city->country->name ?? '' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Left Column -->
                <div class="md:col-span-2 space-y-6">

                    <!-- City / Country Box -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="h-48 bg-cover bg-center" style="background-image: url('{{ $booking->city->image ?? 'https://images.unsplash.com/photo-1488646953014-c8c32bc611ee?ixlib=rb-4.0.3' }}');"></div>
                        <div class="p-6">
                            <span class="uppercase tracking-widest text-xs font-bold text-blue-500">
                                {{ $booking->trip_type }} • {{ $booking->city->country->name ?? '' }}
                            </span>
                            <h3 class="text-2xl font-bold text-gray-900 mt-1">
                                🌍 Ville Recommandée : {{ $booking->city->name }}
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">
                                📍 {{ $booking->city->country->name ?? '' }}
                            </p>
                            <p class="text-gray-600 mt-2">{{ $booking->city->description }}</p>
                        </div>
                    </div>

                    {{-- Hotel Box --}}
                    <a href="{{ route('hotels.show', $booking->hotel->id) }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col sm:flex-row hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group block">
                        <div class="sm:w-1/3 bg-cover bg-center h-48 sm:h-auto group-hover:scale-105 transition-transform duration-500 overflow-hidden" style="background-image: url('{{ $booking->hotel->image ?? 'https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3' }}');"></div>
                        <div class="p-6 sm:w-2/3">
                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors">🏨 Hôtel Recommandé : {{ $booking->hotel->name }}</h3>
                            <p class="text-sm font-medium text-blue-600 mb-2">📍 {{ $booking->hotel->city->name ?? $booking->city->name }}</p>
                            <p class="text-gray-600 mt-2">{{ $booking->hotel->description }}</p>
                            <div class="mt-4 flex items-center justify-between">
                                <p class="inline-block bg-gray-100 rounded-lg px-3 py-1 text-sm font-semibold text-gray-700">
                                    Prix par nuit : {{ number_format($booking->hotel->price_per_night, 2) }} €
                                </p>
                                <span class="text-blue-600 text-sm font-black flex items-center gap-1">Voir détails →</span>
                            </div>
                        </div>
                    </a>

                    <!-- Places to Visit -->
                    @if($booking->city->places->isNotEmpty())
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">🗺️ À Visiter à {{ $booking->city->name }}</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($booking->city->places as $place)
                            <div class="block rounded-lg overflow-hidden border hover:shadow-md transition duration-200 hover:border-blue-500 group relative">
                                <!-- Main Link to Details -->
                                <a href="{{ route('places.show', $place->id) }}" class="absolute inset-0 z-10" aria-label="Voir les détails de {{ $place->name }}"></a>
                                
                                @if($place->image)
                                <div class="h-32 bg-cover bg-center group-hover:scale-105 transition-transform duration-500" style="background-image: url('{{ $place->image }}');"></div>
                                @endif
                                <div class="p-3 relative z-20 bg-white">
                                    <h4 class="font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $place->name }}</h4>
                                    @if($place->description)
                                    <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $place->description }}</p>
                                    @endif
                                    <div class="mt-2 flex items-center justify-between">
                                        @if($place->localisation)
                                        <a href="https://www.google.com/maps?q={{ urlencode($place->localisation) }}" target="_blank" class="text-[10px] text-green-600 font-bold flex items-center hover:underline relative z-30" onclick="event.stopPropagation()">
                                            <span class="mr-1">🗺️</span> Map
                                        </a>
                                        @endif
                                        <span class="text-[10px] font-black text-blue-600 uppercase tracking-tighter">Voir détails →</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                </div>

                <!-- Right Column: Budget Summary + Actions -->
                <div class="space-y-6">
                    <div class="bg-white shadow-sm sm:rounded-lg p-6 border-t-4 border-blue-500">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Répartition du Budget</h3>
                        <ul class="text-sm text-gray-600 space-y-3">
                            <li class="flex justify-between border-b pb-2">
                                <span>✈️ Vols estimés (30%)</span>
                                <span class="font-medium text-gray-900">{{ number_format($booking->flight_budget, 2) }} €</span>
                            </li>
                            <li class="flex justify-between border-b pb-2">
                                <span>🏨 Hébergement total</span>
                                <span class="font-medium text-gray-900">{{ number_format($booking->hotel_budget, 2) }} €</span>
                            </li>
                            <li class="flex justify-between border-b pb-2">
                                <span>🏃 Activités (20%)</span>
                                <span class="font-medium text-gray-900">{{ number_format($booking->activities_budget, 2) }} €</span>
                            </li>
                            <li class="flex justify-between border-b pb-2">
                                <span>🛍️ Divers (10%)</span>
                                <span class="font-medium text-gray-900">{{ number_format($booking->misc_budget, 2) }} €</span>
                            </li>
                        </ul>
                        <div class="mt-4 pt-4 border-t flex justify-between items-center">
                            <span class="text-gray-900 font-bold">Total Séjour</span>
                            <span class="text-2xl font-black text-blue-600">{{ number_format($booking->total_price, 2) }} €</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-2 italic text-center">Pour {{ $booking->duration }} nuits, {{ $booking->passengers }} pers.</p>
                    </div>

                    <!-- Actions -->
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        @if($booking->status === 'pending')
                            <div class="text-center mb-4">
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">En attente de paiement</span>
                            </div>
                            <form action="{{ route('bookings.pay', $booking->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-bold text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                    ✅ PAYER MAINTENANT
                                </button>
                            </form>
                            <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" class="mt-3">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?');" class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                    🗑️ Supprimer cette suggestion
                                </button>
                            </form>
                        @else
                            <div class="text-center py-4 bg-green-50 border border-green-200 rounded-lg">
                                <span class="text-green-600 text-4xl mb-2 block">🎉</span>
                                <h4 class="font-bold text-xl text-green-800">Voyage Confirmé</h4>
                                <p class="text-green-600 text-sm mt-1">Votre paiement a bien été reçu.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('bookings.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                    &larr; Retour à mes voyages
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
