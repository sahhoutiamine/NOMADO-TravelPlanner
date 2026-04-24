@extends('layouts.admin')

@section('category', 'Logistics Infrastructure')
@section('title', 'Global Records')

@section('content')
<div class="glass-card rounded-xl shadow-2xl overflow-hidden border border-white relative">
    <div class="absolute top-0 left-0 w-64 h-64 bg-indigo-100/10 blur-[100px] pointer-events-none"></div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] border-b border-slate-100">
                    <th class="px-10 py-8">Reference & Identity</th>
                    <th class="px-10 py-8">Destination Node</th>
                    <th class="px-10 py-8">Volume</th>
                    <th class="px-10 py-8">Flow Status</th>
                    <th class="px-10 py-8 text-right">Operations</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($bookings as $booking)
                    <tr class="group hover:bg-white/40 transition-all duration-300">
                        <td class="px-10 py-8">
                            <div class="flex items-center gap-6">
                                <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-slate-900 group-hover:text-white transition-all font-black text-xs shadow-sm">
                                    #{{ str_pad($booking->id, 3, '0', STR_PAD_LEFT) }}
                                </div>
                                <div class="flex flex-col">
                                    <p class="text-sm font-black text-slate-950 leading-none mb-1.5 uppercase tracking-tight">{{ $booking->user->name }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest italic">{{ $booking->created_at->format('d M — H:i') }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-8">
                            <p class="text-sm font-black text-slate-700 leading-none mb-1.5 capitalize tracking-tight">{{ $booking->city->name ?? 'Global' }}</p>
                            <p class="text-[10px] text-primary-600 font-black uppercase tracking-widest italic">{{ $booking->trip_type ?? 'Adventure' }} Edition</p>
                        </td>
                        <td class="px-10 py-8 font-black text-slate-950">
                            &euro;{{ number_format($booking->budget_total, 0) }}
                        </td>
                        <td class="px-10 py-8">
                            <span class="px-4 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest flex items-center gap-2 w-fit {{ $booking->status === 'paid' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-amber-50 text-amber-600 border border-amber-100' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $booking->status === 'paid' ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                                {{ $booking->status }}
                            </span>
                        </td>
                        <td class="px-10 py-8 text-right">
                            <a href="{{ route('bookings.show', $booking->id) }}" class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 hover:text-primary-600 transition-colors group/btn">
                                Intelligence <span class="material-symbols-outlined text-sm group-hover/btn:translate-x-1 transition-transform">insights</span>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-10 py-32 text-center">
                            <span class="material-symbols-outlined text-5xl text-slate-200 mb-4 scale-150 block">history_toggle_off</span>
                            <p class="text-slate-400 text-xs font-black uppercase tracking-[0.3em] italic">The record stream is currently dormant.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
