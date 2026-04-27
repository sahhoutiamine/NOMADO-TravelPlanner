@extends('layouts.admin')

@section('category', 'Content Management')
@section('title', 'Refine Property')

@section('content')
<div class="max-w-5xl">
    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 p-10 border border-white fade-in">
        <form action="{{ route('admin.hotels.update', $hotel->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PATCH')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label for="name" class="block text-xs font-black uppercase tracking-widest text-slate-400">Property Name</label>
                    <input type="text" name="name" id="name" required value="{{ old('name', $hotel->name) }}"
                           class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-lg font-bold text-slate-900 focus:ring-4 focus:ring-primary-500/10 transition-all">
                    <x-input-error :messages="$errors->get('name')" />
                </div>

                <div class="space-y-2">
                    <label for="city_id" class="block text-xs font-black uppercase tracking-widest text-slate-400">Urban Locale</label>
                    <select name="city_id" id="city_id" required class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-lg font-bold text-slate-900 focus:ring-4 focus:ring-primary-500/10 transition-all appearance-none cursor-pointer">
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" {{ old('city_id', $hotel->city_id) == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('city_id')" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label for="type" class="block text-xs font-black uppercase tracking-widest text-slate-400">Property Tiers</label>
                    <select name="type" id="type" required class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-lg font-bold text-slate-900 focus:ring-4 focus:ring-primary-500/10 transition-all appearance-none cursor-pointer">
                        <option value="economy" {{ old('type', $hotel->type) == 'economy' ? 'selected' : '' }}>Economy</option>
                        <option value="mid_range" {{ old('type', $hotel->type) == 'mid_range' ? 'selected' : '' }}>Mid Range</option>
                        <option value="luxury" {{ old('type', $hotel->type) == 'luxury' ? 'selected' : '' }}>Luxury Elite</option>
                    </select>
                    <x-input-error :messages="$errors->get('type')" />
                </div>

                <div class="space-y-2">
                    <label for="price_per_night" class="block text-xs font-black uppercase tracking-widest text-slate-400">Base Nightly Rate (€)</label>
                    <input type="number" step="0.01" name="price_per_night" id="price_per_night" required value="{{ old('price_per_night', $hotel->price_per_night) }}"
                           class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-2xl font-black text-slate-900 focus:ring-4 focus:ring-primary-500/10 transition-all">
                    <x-input-error :messages="$errors->get('price_per_night')" />
                </div>
            </div>

            <div class="space-y-3">
                <label class="block text-xs font-black uppercase tracking-widest text-slate-400">Master Asset</label>
                @include('admin.partials.image-upload', ['currentImage' => $hotel->image])
            </div>

            <div class="space-y-2">
                <label for="description" class="block text-xs font-black uppercase tracking-widest text-slate-400">Hospitality Vision</label>
                <textarea name="description" id="description" rows="3"
                          class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-lg font-medium text-slate-900 focus:ring-4 focus:ring-primary-500/10 transition-all">{{ old('description', $hotel->description) }}</textarea>
                <x-input-error :messages="$errors->get('description')" />
            </div>

            <div class="pt-6 flex justify-end gap-4 border-t border-slate-50">
                <a href="{{ route('admin.hotels.index') }}" class="px-8 py-4 text-slate-400 font-black uppercase tracking-widest text-xs hover:text-slate-600 transition-colors">Discard Revisions</a>
                <button type="submit" class="px-10 py-4 bg-indigo-600 text-white rounded-2xl font-black shadow-xl shadow-indigo-500/20 hover:bg-indigo-700 transition-all hover:-translate-y-1">
                    Apply Operational Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
