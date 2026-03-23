<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajouter un Pays') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.countries.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nom</label>
                            <input type="text" name="name" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-gray-900 focus:border-indigo-500 focus:ring-indigo-500">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Type de Voyage</label>
                            <select name="trip_type" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="adventure">Aventure</option>
                                <option value="culture">Culture</option>
                                <option value="beach">Plage</option>
                                <option value="romantic">Romantique</option>
                                <option value="nature">Nature</option>
                                <option value="shopping">Shopping</option>
                            </select>
                            <x-input-error :messages="$errors->get('trip_type')" class="mt-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">URL Image</label>
                            <input type="url" name="image" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-gray-900 focus:border-indigo-500 focus:ring-indigo-500">
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>
                        
                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Sauvegarder
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
