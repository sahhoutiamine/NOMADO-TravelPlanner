@extends('layouts.admin')

@section('category', 'Hospitality Assets')
@section('title', 'Global Sanctuaries')

@section('content')
<div class="mb-10 flex justify-end">
    <a href="{{ route('admin.hotels.create') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-indigo-600 text-white font-black rounded-xl shadow-2xl hover:bg-slate-900 transition-all hover:translate-y-[-2px] group active:scale-95">
        <span class="material-symbols-outlined text-xl group-hover:rotate-90 transition-transform">add_business</span>
        Register Sanctuary
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
                    <th class="px-10 py-8">Asset Signature</th>
                    <th class="px-10 py-8">Station</th>
                    <th class="px-10 py-8">Financial Tier</th>
                    <th class="px-10 py-8 text-right">Ops Control</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($hotels as $hotel)
                    <tr class="group hover:bg-white/40 transition-all duration-300">
                        <td class="px-10 py-8">
                            <div class="flex items-center gap-6">
                                <div class="w-20 h-14 rounded-xl overflow-hidden border border-slate-100 shadow-sm shrink-0 group-hover:scale-105 transition-transform duration-500">
                                    <img src="{{ $hotel->image ?? 'https://via.placeholder.com/150' }}" class="w-full h-full object-cover">
                                </div>
                                <div class="truncate max-w-[280px]">
                                    <p class="text-base font-black text-slate-950 leading-none mb-2 uppercase tracking-tight">{{ $hotel->name }}</p>
                                    <span class="inline-block px-2.5 py-1 rounded bg-indigo-50 text-indigo-500 text-[8px] font-black uppercase tracking-widest border border-indigo-100 italic">{{ $hotel->type }} Class</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-8">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-slate-300 text-base">location_on</span>
                                <span class="text-sm font-black text-slate-700 tracking-tight">{{ $hotel->city->name ?? 'N/A' }}</span>
                            </div>
                        </td>
                        <td class="px-10 py-8">
                            <div class="flex flex-col">
                                <span class="text-lg font-black text-primary-600 tracking-tighter">&euro;{{ number_format($hotel->price_per_night, 0) }}</span>
                                <span class="text-[8px] text-slate-400 font-bold uppercase tracking-widest leading-none">Per Orbit</span>
                            </div>
                        </td>
                        <td class="px-10 py-8 text-right">
                            <div class="flex items-center justify-end gap-3 transition-all duration-300">
                                <a href="{{ route('admin.hotels.edit', $hotel->id) }}" class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all" title="Adjust Parameters">
                                    <span class="material-symbols-outlined text-xl">tune</span>
                                </a>
                                <form action="{{ route('admin.hotels.destroy', $hotel->id) }}" method="POST" onsubmit="return confirm('Evict this property from inventory?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all" title="Liquidate">
                                        <span class="material-symbols-outlined text-xl">delete_forever</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-10 py-32 text-center">
                            <span class="material-symbols-outlined text-5xl mb-4 scale-150 block opacity-20 text-slate-300">hotel_class_off</span>
                            <p class="text-slate-400 text-xs font-black uppercase tracking-[0.3em] font-italic">Global hospitality capacity is zeroed out.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
