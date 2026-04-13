<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-900 leading-tight">
            📍 {{ $place->name }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Place Hero Section -->
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden mb-12 transform hover:shadow-2xl transition-all h-[550px] relative">
                <img src="{{ $place->image }}" alt="{{ $place->name }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent flex flex-col justify-end p-10 md:p-16">
                    <div class="flex items-center space-x-3 mb-4">
                        <span class="bg-blue-600 text-white px-4 py-1.5 rounded-full text-xs font-black tracking-widest uppercase shadow-lg">{{ $place->country->name }}</span>
                        <span class="bg-amber-100 text-amber-800 px-4 py-1.5 rounded-full text-sm font-bold shadow-md">⭐ {{ number_format($place->rating, 1) }} (Global Rating)</span>
                    </div>
                    <h1 class="text-white text-5xl md:text-7xl font-black mb-6 leading-tight drop-shadow-2xl">{{ $place->name }}</h1>
                    <div class="flex flex-col md:flex-row md:items-center text-white/90 text-xl font-bold italic max-w-4xl space-x-0 md:space-x-8">
                        <span class="bg-white/10 backdrop-blur-md px-6 py-3 rounded-2xl border border-white/20 mb-4 md:mb-0">📍 Situé à : {{ $place->city }}</span>
                        <p class="leading-relaxed drop-shadow-md text-white/80">"{{ $place->description }}"</p>
                    </div>
                </div>
            </div>

            <!-- Hotels Section -->
            <div class="flex items-center justify-between mb-8 border-b border-gray-200 pb-6">
                <h2 class="text-4xl font-black text-gray-900 leading-tight">🏨 Hébergements Recommandés à proximité</h2>
                <span class="text-sm font-bold text-blue-600 bg-blue-50 px-5 py-2 rounded-2xl uppercase tracking-widest">{{ $place->hotels->count() }} Hôtels Disponibles</span>
            </div>

            @if($place->hotels->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-10">
                    @foreach($place->hotels as $hotel)
                        <div class="group bg-white rounded-3xl overflow-hidden shadow-md flex flex-col hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-3 h-full border border-gray-100">
                            <!-- Image -->
                            <div class="relative h-64 overflow-hidden">
                                <img src="{{ $hotel->image }}" alt="{{ $hotel->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute bottom-4 left-4 bg-white/90 backdrop-blur-sm px-4 py-1 rounded-xl text-lg font-black text-blue-600 shadow-md">
                                    {{ number_format($hotel->price_per_night, 0) }} € <span class="text-xs font-bold text-gray-400">/ Nuit</span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-8 flex-grow flex flex-col">
                                <h3 class="text-2xl font-black text-gray-900 mb-2 truncate group-hover:text-blue-600 transition-colors">{{ $hotel->name }}</h3>
                                <p class="text-sm font-bold text-gray-400 mb-6 uppercase tracking-widest flex items-center">
                                    <span class="mr-2">🗺️</span> {{ $hotel->location }}
                                </p>
                                <p class="text-gray-600 text-sm leading-relaxed line-clamp-3 mb-8 italic">
                                    "{{ $hotel->description }}"
                                </p>
                                
                                <div class="mt-auto pt-6 border-t border-gray-50 flex items-center justify-between">
                                    <div class="flex items-center gap-1.5 text-xs text-amber-500 font-black tracking-wide uppercase">
                                        ✨ Recommandé pour {{ $place->name }}
                                    </div>
                                    <a href="{{ route('trip.index') }}" class="px-6 py-2.5 bg-gray-900 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-blue-600 transition-all transform hover:scale-105 shadow-md">
                                        Réserver
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="py-24 text-center bg-white rounded-3xl shadow-lg border-2 border-dashed border-gray-200">
                    <span class="text-7xl mb-6 block">🏙️</span>
                    <h3 class="text-2xl font-black text-gray-900">Aucun hôtel n'a encore été ajouté ici.</h3>
                    <p class="text-gray-500 mt-2 text-lg">Nos experts explorent actuellement cette région pour dénicher les meilleurs séjours.</p>
                </div>
            @endif

            <div class="mt-16 flex justify-center">
                <a href="{{ route('places.index') }}" class="inline-flex items-center px-10 py-4 bg-white border-2 border-gray-200 rounded-2xl font-black text-gray-700 hover:border-blue-600 hover:text-blue-600 transition-all shadow-sm hover:shadow-xl uppercase tracking-widest">
                    &larr; Revenir à la navigation des lieux
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
