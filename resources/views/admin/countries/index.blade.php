@extends('layouts.admin')

@section('category', 'Global Framework')
@section('title', 'Sovereign Territories')

@section('content')
<div class="mb-10 flex justify-end">
    <a href="{{ route('admin.countries.create') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-primary-600 text-white font-black rounded-xl shadow-2xl hover:bg-slate-900 transition-all hover:translate-y-[-2px] group active:scale-95">
        <span class="material-symbols-outlined text-xl group-hover:rotate-90 transition-transform">public</span>
        Register Territory
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
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] border-b border-slate-100">
                    <th class="px-10 py-8">Geographic Identity</th>
                    <th class="px-10 py-8">Infrastructure Hubs</th>
                    <th class="px-10 py-8 text-right">Command Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($countries as $country)
                    <tr class="group hover:bg-white/40 transition-all duration-300">
                        <td class="px-10 py-8">
                            <div class="flex items-center gap-6">
                                <div class="w-20 h-14 rounded-xl overflow-hidden border border-slate-100 shadow-sm shrink-0 group-hover:scale-105 transition-transform duration-500">
                                    <img src="{{ $country->image ?? 'https://via.placeholder.com/150' }}" class="w-full h-full object-cover">
                                </div>
                                <div class="truncate max-w-sm">
                                    <p class="text-lg font-black text-slate-950 leading-none mb-2 uppercase tracking-tight">{{ $country->name }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest line-clamp-1 italic">{{ $country->description }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-8">
                            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-lg bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase tracking-widest border border-indigo-100">
                                <span class="material-symbols-outlined text-xs">location_city</span>
                                {{ $country->cities->count() }} Linked Nodes
                            </span>
                        </td>
                        <td class="px-10 py-8">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.countries.edit', $country->id) }}" class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-all" title="Modify Meta">
                                    <span class="material-symbols-outlined text-xl">edit</span>
                                </a>
                                <form action="{{ route('admin.countries.destroy', $country->id) }}" method="POST" onsubmit="return confirm('Dismantle this country record? This cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all" title="Dismantle">
                                        <span class="material-symbols-outlined text-xl">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-10 py-32 text-center text-slate-300">
                            <span class="material-symbols-outlined text-5xl mb-4 scale-150 block opacity-20">public_off</span>
                            <p class="font-black uppercase tracking-[0.3em] text-[10px]">No sovereign nations currently registered.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
