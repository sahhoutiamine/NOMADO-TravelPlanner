@extends('layouts.admin')

@section('category', 'Points of Interest')
@section('title', 'Benchmark Landmark')

@section('content')
<div class="max-w-5xl">
    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 p-10 border border-white fade-in">
        <form action="{{ route('admin.places.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="col-span-2 space-y-2">
                    <label for="name" class="block text-xs font-black uppercase tracking-widest text-slate-400">Landmark Name</label>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="e.g. Eiffel Tower"
                           class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-lg font-bold text-slate-900 focus:ring-4 focus:ring-primary-500/10 transition-all">
                    <x-input-error :messages="$errors->get('name')" />
                </div>

                <div class="space-y-2">
                    <label for="city_id" class="block text-xs font-black uppercase tracking-widest text-slate-400">Located In</label>
                    <select name="city_id" id="city_id" required class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-lg font-bold text-slate-900 focus:ring-4 focus:ring-primary-500/10 transition-all appearance-none cursor-pointer">
                        <option value="" disabled selected>Select Hub...</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('city_id')" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label for="min_price" class="block text-xs font-black uppercase tracking-widest text-slate-400">Place Price (€)</label>
                    <input type="number" step="0.01" name="min_price" id="min_price" min="0" value="{{ old('min_price', 150.00) }}"
                           class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-lg font-bold text-slate-900 focus:ring-4 focus:ring-primary-500/10 transition-all">
                    <x-input-error :messages="$errors->get('min_price')" />
                </div>

                <div class="space-y-2">
                    <label for="localisation" class="block text-xs font-black uppercase tracking-widest text-slate-400">GPS/Map String</label>
                    <input type="text" name="localisation" id="localisation" value="{{ old('localisation') }}" placeholder="Coordinates or Address"
                           class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-lg font-bold text-slate-900 focus:ring-4 focus:ring-primary-500/10 transition-all">
                    <x-input-error :messages="$errors->get('localisation')" />
                </div>
            </div>

            <div class="space-y-3">
                <label class="block text-xs font-black uppercase tracking-widest text-slate-400">Hero Image</label>
                @include('admin.partials.image-upload', ['currentImage' => null])
            </div>

            <div class="space-y-2">
                <label for="description" class="block text-xs font-black uppercase tracking-widest text-slate-400">Experiential Summary</label>
                <textarea name="description" id="description" rows="2" placeholder="Sensory details of the location..."
                          class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-lg font-medium text-slate-900 focus:ring-4 focus:ring-primary-500/10 transition-all">{{ old('description') }}</textarea>
                <x-input-error :messages="$errors->get('description')" />
            </div>

            <div class="pt-6 flex justify-end gap-4 border-t border-slate-50">
                <a href="{{ route('admin.places.index') }}" class="px-8 py-4 text-slate-400 font-black uppercase tracking-widest text-xs hover:text-slate-600 transition-colors">Recall Scout</a>
                <button type="submit" class="px-10 py-4 bg-primary-600 text-white rounded-2xl font-black shadow-xl shadow-primary-500/20 hover:bg-primary-700 transition-all hover:-translate-y-1">
                    Establish Landmark
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
