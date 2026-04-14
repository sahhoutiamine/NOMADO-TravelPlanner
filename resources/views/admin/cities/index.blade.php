@extends('layouts.admin')

@section('category', 'Geographical Data')
@section('title', 'City Management')

@section('content')
<div class="mb-8 flex justify-end">
    <a href="{{ route('admin.cities.create') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-black rounded-2xl shadow-xl shadow-indigo-500/20 hover:bg-indigo-700 transition-all hover:-translate-y-1 group">
        <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        New City Outpost
    </a>
</div>

@if(session('success'))
    <div class="mb-8 bg-green-50 border border-green-100 text-green-700 px-6 py-4 rounded-2xl flex items-center gap-3 fade-in">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span class="font-bold">{{ session('success') }}</span>
    </div>
@endif

<div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 overflow-hidden border border-white">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">
                    <th class="px-8 py-6">City Identity</th>
                    <th class="px-8 py-6">Sovereign Parent</th>
                    <th class="px-8 py-6 text-right">Administrative Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($cities as $city)
                    <tr class="group hover:bg-slate-50 transition-all">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl border border-slate-100 overflow-hidden shadow-sm shrink-0">
                                    <img src="{{ $city->image ?? 'https://via.placeholder.com/150' }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="text-base font-black text-slate-900 leading-none mb-1">{{ $city->name }}</p>
                                    <p class="text-xs text-slate-400 font-medium">Est. Population: N/A</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold uppercase tracking-widest">
                                {{ $city->country->name ?? 'None' }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.cities.edit', $city->id) }}" class="p-2 text-slate-400 hover:text-indigo-600 transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                <form action="{{ route('admin.cities.destroy', $city->id) }}" method="POST" onsubmit="return confirm('Obliterate this city outpost?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-red-500 transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-8 py-20 text-center text-slate-300 font-bold italic tracking-widest uppercase text-xs">The world lacks urban centers here.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
