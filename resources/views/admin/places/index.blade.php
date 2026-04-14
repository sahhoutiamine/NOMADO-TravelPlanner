@extends('layouts.admin')

@section('category', 'Points of Interest')
@section('title', 'Place Management')

@section('content')
<div class="mb-8 flex justify-end">
    <a href="{{ route('admin.places.create') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 text-white font-black rounded-2xl shadow-xl shadow-primary-500/20 hover:bg-primary-700 transition-all hover:-translate-y-1 group">
        <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Benchmark New Place
    </a>
</div>

<div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 overflow-hidden border border-white">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">
                    <th class="px-8 py-6">The Landmark</th>
                    <th class="px-8 py-6">City Locale</th>
                    <th class="px-8 py-6">Experience Type</th>
                    <th class="px-8 py-6">Rating</th>
                    <th class="px-8 py-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($places as $place)
                    <tr class="group hover:bg-slate-50 transition-all">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl border border-slate-100 overflow-hidden shadow-sm shrink-0">
                                    <img src="{{ $place->image ?? 'https://via.placeholder.com/150' }}" class="w-full h-full object-cover">
                                </div>
                                <div class="truncate max-w-[200px]">
                                    <p class="text-base font-black text-slate-900 leading-none mb-1">{{ $place->name }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $place->localisation }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-sm font-bold text-slate-600">{{ $place->city->name ?? 'Unknown' }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 bg-primary-50 text-primary-700 rounded-lg text-[10px] font-black uppercase tracking-tighter">
                                {{ $place->trip_type }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-1 text-amber-500 font-black">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                <span>{{ $place->rating }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.places.edit', $place->id) }}" class="p-2 text-slate-400 hover:text-primary-600 transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                <form action="{{ route('admin.places.destroy', $place->id) }}" method="POST" onsubmit="return confirm('Dismantle this landmark?');">
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
                        <td colspan="5" class="px-8 py-20 text-center text-slate-300 font-bold italic uppercase text-xs tracking-widest">No monuments established yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
