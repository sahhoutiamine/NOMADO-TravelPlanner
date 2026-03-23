<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Générer Un Voyage') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900">
                    
                    @if(session('error'))
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <div class="text-center mb-10">
                        <h1 class="text-3xl font-extrabold text-blue-600 mb-2">Créez le voyage de vos rêves</h1>
                        <p class="text-gray-500">Laissez notre système générer un voyage sur mesure en fonction de vos envies et de votre budget.</p>
                    </div>

                    <form action="{{ route('trip.generate') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Type de voyage -->
                            <div>
                                <label for="trip_type" class="block font-medium text-sm text-gray-700">Type de voyage</label>
                                <select id="trip_type" name="trip_type" required class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="" disabled selected>Choisissez un type...</option>
                                    <option value="adventure">Aventure</option>
                                    <option value="culture">Culture</option>
                                    <option value="beach">Plage</option>
                                    <option value="romantic">Romantique</option>
                                    <option value="nature">Nature</option>
                                    <option value="shopping">Shopping</option>
                                </select>
                                <x-input-error :messages="$errors->get('trip_type')" class="mt-2" />
                            </div>

                            <!-- Budget -->
                            <div>
                                <label for="budget" class="block font-medium text-sm text-gray-700">Budget total (€)</label>
                                <input id="budget" type="number" name="budget" min="100" required placeholder="ex: 2000" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <x-input-error :messages="$errors->get('budget')" class="mt-2" />
                            </div>

                            <!-- Durée -->
                            <div>
                                <label for="duration" class="block font-medium text-sm text-gray-700">Durée du séjour (jours)</label>
                                <input id="duration" type="number" name="duration" min="1" required placeholder="ex: 7" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                            </div>

                            <!-- Passagers -->
                            <div>
                                <label for="passengers" class="block font-medium text-sm text-gray-700">Nombre de passagers</label>
                                <input id="passengers" type="number" name="passengers" min="1" required placeholder="ex: 2" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <x-input-error :messages="$errors->get('passengers')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-3 bg-blue-600 border border-transparent rounded-lg font-semibold text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150 transform hover:scale-105">
                                Générer mon voyage !
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
