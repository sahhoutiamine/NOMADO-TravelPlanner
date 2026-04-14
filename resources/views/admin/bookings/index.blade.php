@extends('layouts.admin')

@section('category', 'Operational Center')
@section('title', 'Global Booking Register')

@section('content')
<div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 overflow-hidden border border-white">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">
                    <th class="px-8 py-6">Reference & User</th>
                    <th class="px-8 py-6">Destination Hub</th>
                    <th class="px-8 py-6">Financial Value</th>
                    <th class="px-8 py-6">Status</th>
                    <th class="px-8 py-6 text-right">Details</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($bookings as $booking)
                    <tr class="group hover:bg-slate-50 transition-all">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-primary-500 group-hover:text-white transition-all font-black text-xs">
                                    #{{ $booking->id }}
                                </div>
                                <div>
                                    <p class="text-sm font-black text-slate-900 leading-none mb-1">{{ $booking->user->name }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $booking->created_at->format('M d, H:i') }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <p class="text-sm font-bold text-slate-700">{{ $booking->city->name ?? 'N/A' }}</p>
                            <p class="text-[10px] text-slate-400 italic">{{ $booking->city->country->name ?? 'Global' }}</p>
                        </td>
                        <td class="px-8 py-6 font-black text-slate-900">
                            {{ number_format($booking->total_price, 2) }} €
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-tighter {{ $booking->status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ $booking->status }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <a href="{{ route('bookings.show', $booking->id) }}" class="inline-flex items-center text-xs font-black uppercase tracking-widest text-primary-600 hover:text-primary-800 transition-colors">
                                Review &rarr;
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-8 py-20 text-center text-slate-300 font-bold italic tracking-widest uppercase text-xs">The registry is currently void of expeditions.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
