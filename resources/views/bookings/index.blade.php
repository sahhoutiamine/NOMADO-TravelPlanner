<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mes Voyages') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if($bookings->isEmpty())
                        <div class="text-center py-10">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun voyage pour le moment.</h3>
                            <p class="mt-1 text-sm text-gray-500">Commencez par générer un nouveau voyage !</p>
                            <div class="mt-6">
                                <a href="{{ route('trip.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                    Nouveau Voyage
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($bookings as $booking)
                                <div class="bg-white rounded-lg border shadow-sm hover:shadow-md transition duration-200">
                                    <div class="p-5 relative">
                                        <div class="flex justify-between items-center mb-4">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full uppercase tracking-wide {{ $booking->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                {{ $booking->status === 'paid' ? 'Payé' : 'En attente' }}
                                            </span>
                                            <span class="text-xs text-gray-500">{{ $booking->created_at->format('d/m/Y') }}</span>
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-900">{{ ucfirst($booking->place->country->name ?? 'Pays inconnu') }}</h3>
                                        <p class="text-xs text-blue-600 font-semibold mb-1">{{ $booking->place->name }}</p>
                                        <p class="text-sm text-gray-600 mb-4">{{ $booking->duration }} jours • {{ $booking->passengers }} passagers</p>
                                        
                                        <div class="flex justify-between border-t pt-4">
                                            <div class="text-xl font-black text-blue-600">{{ number_format($booking->total_price, 2) }} €</div>
                                            <a href="{{ route('bookings.show', $booking->id) }}" class="text-blue-500 hover:text-blue-700 text-sm font-medium flex items-center">
                                                Voir détails &rarr;
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
