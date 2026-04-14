@extends('layouts.admin')

@section('category', 'Destinations')
@section('title', 'Refine Country')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 p-10 border border-white fade-in">
        <form action="{{ route('admin.countries.update', $country->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PATCH')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label for="name" class="block text-xs font-black uppercase tracking-widest text-slate-400">Country Designation</label>
                    <input type="text" name="name" id="name" required value="{{ old('name', $country->name) }}"
                           class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-lg font-bold text-slate-900 focus:ring-4 focus:ring-primary-500/10 transition-all">
                    <x-input-error :messages="$errors->get('name')" />
                </div>

                <div class="space-y-2">
                    <label for="image" class="block text-xs font-black uppercase tracking-widest text-slate-400">Media URL</label>
                    <input type="url" name="image" id="image" value="{{ old('image', $country->image) }}"
                           class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-lg font-bold text-slate-900 focus:ring-4 focus:ring-primary-500/10 transition-all">
                    <x-input-error :messages="$errors->get('image')" />
                </div>
            </div>

            <div class="space-y-2">
                <label for="description" class="block text-xs font-black uppercase tracking-widest text-slate-400">Philosophical Narrative</label>
                <textarea name="description" id="description" rows="5"
                          class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-lg font-medium text-slate-900 focus:ring-4 focus:ring-primary-500/10 transition-all">{{ old('description', $country->description) }}</textarea>
                <x-input-error :messages="$errors->get('description')" />
            </div>

            <div class="pt-6 flex justify-end gap-4">
                <a href="{{ route('admin.countries.index') }}" class="px-8 py-4 text-slate-400 font-black uppercase tracking-widest text-xs hover:text-slate-600 transition-colors">Discard Changes</a>
                <button type="submit" class="px-10 py-4 bg-slate-900 text-white rounded-2xl font-black shadow-xl shadow-slate-900/20 hover:bg-primary-600 transition-all hover:-translate-y-1">
                    Commence Refinement
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
