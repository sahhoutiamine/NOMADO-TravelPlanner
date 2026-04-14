@extends('layouts.admin')

@section('category', 'Geographical Data')
@section('title', 'Found New City')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 p-10 border border-white fade-in">
        <form action="{{ route('admin.cities.store') }}" method="POST" class="space-y-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label for="name" class="block text-xs font-black uppercase tracking-widest text-slate-400">City Nomenclature</label>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}" placeholder="e.g. Lyon"
                           class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-lg font-bold text-slate-900 focus:ring-4 focus:ring-primary-500/10 transition-all">
                    <x-input-error :messages="$errors->get('name')" />
                </div>

                <div class="space-y-2">
                    <label for="country_id" class="block text-xs font-black uppercase tracking-widest text-slate-400">Sovereign Parent</label>
                    <select name="country_id" id="country_id" required class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-lg font-bold text-slate-900 focus:ring-4 focus:ring-primary-500/10 transition-all appearance-none cursor-pointer">
                        <option value="" disabled selected>Identify Territory...</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('country_id')" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label for="image" class="block text-xs font-black uppercase tracking-widest text-slate-400">Lanscape View (URL)</label>
                    <input type="url" name="image" id="image" value="{{ old('image') }}" placeholder="https://..."
                           class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-lg font-bold text-slate-900 focus:ring-4 focus:ring-primary-500/10 transition-all">
                    <x-input-error :messages="$errors->get('image')" />
                </div>
                
                <div class="space-y-2">
                    <label for="description" class="block text-xs font-black uppercase tracking-widest text-slate-400">Urban Essence</label>
                    <textarea name="description" id="description" rows="2" placeholder="Brief capture of the skyline..."
                              class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-lg font-medium text-slate-900 focus:ring-4 focus:ring-primary-500/10 transition-all">{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" />
                </div>
            </div>

            <div class="pt-6 flex justify-end gap-4 border-t border-slate-50">
                <a href="{{ route('admin.cities.index') }}" class="px-8 py-4 text-slate-400 font-black uppercase tracking-widest text-xs hover:text-slate-600 transition-colors">Recall Scout</a>
                <button type="submit" class="px-10 py-4 bg-indigo-600 text-white rounded-2xl font-black shadow-xl shadow-indigo-500/20 hover:bg-indigo-700 transition-all hover:-translate-y-1">
                    Establish Outpost
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
