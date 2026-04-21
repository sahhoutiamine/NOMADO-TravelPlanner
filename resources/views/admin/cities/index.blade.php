@extends('layouts.admin')

@section('category', 'Urban Networks')
@section('title', 'City Infrastructure')

@section('content')
<div class="mb-10 flex justify-end">
    <a href="{{ route('admin.cities.create') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-indigo-600 text-white font-black rounded-xl shadow-2xl hover:bg-slate-900 transition-all hover:translate-y-[-2px] group active:scale-95">
        <span class="material-symbols-outlined text-xl group-hover:rotate-90 transition-transform">location_city</span>
        Establish Outpost
    </a>
</div>

@if(session('success'))
    <div class="mb-10 animate-slide-up">
        <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-6 py-5 rounded-xl flex items-center gap-3 font-bold text-sm shadow-sm shadow-emerald-100/30">
            <span class="material-symbols-outlined">check_circle</span>
            {{ session('success') }}
        </div>
    </div>
@endif

<div class="glass-card rounded-xl shadow-2xl overflow-hidden border border-white relative">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] border-b border-slate-100">
                    <th class="px-10 py-8">City Model</th>
                    <th class="px-10 py-8">Regional Authority</th>
                    <th class="px-10 py-8 text-right">Governing Controls</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($cities as $city)
                    <tr class="group hover:bg-white/40 transition-all duration-300">
                        <td class="px-10 py-8">
                            <div class="flex items-center gap-6">
                                <div class="w-14 h-14 rounded-xl border border-slate-100 overflow-hidden shadow-sm shrink-0 group-hover:scale-110 transition-transform duration-500">
                                    <img src="{{ $city->image ?? 'https://via.placeholder.com/150' }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="text-base font-black text-slate-950 leading-none mb-1.5 uppercase tracking-tight">{{ $city->name }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest italic">Operational Unit #{{ $city->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-8">
                            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-lg bg-slate-100 text-slate-600 text-[9px] font-black uppercase tracking-widest border border-slate-200">
                                <span class="material-symbols-outlined text-xs">flag</span>
                                {{ $city->country->name ?? 'Neutral' }}
                            </span>
                        </td>
                        <td class="px-10 py-8 text-right">
                            <div class="flex items-center justify-end gap-3 transition-all duration-300">
                                <a href="{{ route('admin.cities.edit', $city->id) }}" class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" title="Adjust Parameters">
                                    <span class="material-symbols-outlined text-xl">tune</span>
                                </a>
                                <form action="{{ route('admin.cities.destroy', $city->id) }}" method="POST" onsubmit="return confirm('Obliterate this city outpost?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all" title="Decommission">
                                        <span class="material-symbols-outlined text-xl">delete_forever</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-10 py-32 text-center">
                            <span class="material-symbols-outlined text-5xl mb-4 scale-150 block opacity-20 text-slate-300">domain_disabled</span>
                            <p class="text-slate-400 text-xs font-black uppercase tracking-[0.3em] font-italic">No urban centers detected in current sector.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
