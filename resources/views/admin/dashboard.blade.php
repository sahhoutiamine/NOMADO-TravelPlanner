@extends('layouts.admin')

@section('category', 'Overview')
@section('title', 'Admin Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10 text-white">
    <!-- Stat Card: Users -->
    <div class="bg-gradient-to-br from-indigo-600 to-indigo-800 p-6 rounded-[2rem] shadow-xl shadow-indigo-500/20">
        <div class="flex justify-between items-start mb-4">
            <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center border border-white/10">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <span class="text-[10px] font-black uppercase tracking-widest bg-white/10 px-2 py-1 rounded-lg">Users</span>
        </div>
        <p class="text-xs font-bold text-indigo-200">Total Travelers</p>
        <h3 class="text-4xl font-black tracking-tighter">{{ number_format($stats['total_users']) }}</h3>
    </div>

    <!-- Stat Card: Bookings -->
    <div class="bg-gradient-to-br from-primary-500 to-primary-700 p-6 rounded-[2rem] shadow-xl shadow-primary-500/20">
        <div class="flex justify-between items-start mb-4">
            <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center border border-white/10">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
            <span class="text-[10px] font-black uppercase tracking-widest bg-white/10 px-2 py-1 rounded-lg">Trips</span>
        </div>
        <p class="text-xs font-bold text-primary-100">Total Bookings</p>
        <h3 class="text-4xl font-black tracking-tighter">{{ number_format($stats['total_bookings']) }}</h3>
    </div>

    <!-- Stat Card: Revenue -->
    <div class="bg-gradient-to-br from-emerald-500 to-emerald-700 p-6 rounded-[2rem] shadow-xl shadow-emerald-500/20">
        <div class="flex justify-between items-start mb-4">
            <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center border border-white/10">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <span class="text-[10px] font-black uppercase tracking-widest bg-white/10 px-2 py-1 rounded-lg">Revenue</span>
        </div>
        <p class="text-xs font-bold text-emerald-100">Total Earnings</p>
        <h3 class="text-4xl font-black tracking-tighter">{{ number_format($stats['total_revenue'], 2) }} €</h3>
    </div>

    <!-- Stat Card: Geographical -->
    <div class="bg-gradient-to-br from-slate-700 to-slate-900 p-6 rounded-[2rem] shadow-xl shadow-slate-900/20">
        <div class="flex justify-between items-start mb-4">
            <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center border border-white/10">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <span class="text-[10px] font-black uppercase tracking-widest bg-white/10 px-2 py-1 rounded-lg">Destinations</span>
        </div>
        <p class="text-xs font-bold text-slate-400">Cities & Countries</p>
        <h3 class="text-4xl font-black tracking-tighter">{{ $stats['total_cities'] }} / {{ $stats['total_countries'] }}</h3>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Recent Bookings Table -->
    <div class="lg:col-span-2 bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 p-8 border border-white">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-2xl font-black tracking-tight text-slate-800">Latest Bookings</h3>
            <a href="{{ route('admin.bookings.index') }}" class="text-xs font-black uppercase tracking-widest text-primary-600 hover:underline">View All &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-xs font-black text-slate-400 uppercase tracking-widest">
                        <th class="pb-4">User</th>
                        <th class="pb-4">Destination</th>
                        <th class="pb-4">Price</th>
                        <th class="pb-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($latest_bookings as $booking)
                        <tr class="group hover:bg-slate-50 transition-colors">
                            <td class="py-4">
                                <p class="text-sm font-bold text-slate-900">{{ $booking->user->name }}</p>
                                <p class="text-[10px] text-slate-400">{{ $booking->user->email }}</p>
                            </td>
                            <td class="py-4">
                                <p class="text-sm font-bold text-slate-700">{{ $booking->city->name ?? 'N/A' }}</p>
                                <p class="text-[10px] text-slate-400 italic">{{ $booking->trip_type }}</p>
                            </td>
                            <td class="py-4 font-black text-slate-900">{{ number_format($booking->total_price, 2) }} €</td>
                            <td class="py-4">
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-tighter {{ $booking->status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ $booking->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-10 text-center text-slate-400">No recent bookings.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Users -->
    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 p-8 border border-white">
        <h3 class="text-2xl font-black tracking-tight text-slate-800 mb-8">New Travelers</h3>
        <div class="space-y-6">
            @forelse($recent_users as $user)
                <div class="flex items-center gap-4 group">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-400 group-hover:bg-primary-500 group-hover:text-white transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-black text-slate-900 leading-none mb-1 group-hover:text-primary-600 transition-colors">{{ $user->name }}</p>
                        <p class="text-[10px] text-slate-400 uppercase tracking-widest font-bold">{{ $user->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            @empty
                <p class="text-center text-slate-400 py-4 italic">No recent users.</p>
            @endforelse
        </div>
        <div class="mt-10 pt-8 border-t border-slate-50">
            <a href="{{ route('admin.users.index') }}" class="block w-full text-center py-4 bg-slate-50 hover:bg-slate-100 text-slate-600 rounded-2xl text-xs font-black uppercase tracking-widest transition-all">
                Handle All Users
            </a>
        </div>
    </div>
</div>
@endsection
