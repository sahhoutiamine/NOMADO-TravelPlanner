@extends('layouts.admin')

@section('category', 'Operational Intelligence')
@section('title', auth()->user()->isTravlerAdmin() ? 'Traveler Curation' : 'Admin Dashboard')

@section('content')
<!-- Header Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12 text-white">
    @if(auth()->user()->isAdmin())
    <!-- Stat Card: Users -->
    <div class="group relative overflow-hidden bg-slate-950 p-8 rounded-xl shadow-2xl hover:translate-y-[-4px] transition-all duration-500 border border-white/5">
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-1000"></div>
        <div class="relative z-10 flex flex-col justify-between h-full">
            <div class="flex justify-between items-start mb-6">
                <div class="w-14 h-14 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center border border-white/20">
                    <span class="material-symbols-outlined text-3xl">group</span>
                </div>
                <span class="text-[9px] font-black uppercase tracking-[0.2em] bg-white/20 px-3 py-1.5 rounded-lg backdrop-blur-md">Active Base</span>
            </div>
            <div>
                <p class="text-xs font-black text-indigo-100 uppercase tracking-widest mb-1 opacity-70">Total Explorers</p>
                <h3 class="text-5xl font-black tracking-tighter">{{ number_format($stats['total_users'] ?? 0) }}</h3>
            </div>
        </div>
    </div>

    <!-- Stat Card: Bookings -->
    <div class="group relative overflow-hidden bg-primary-600 p-8 rounded-xl shadow-2xl hover:translate-y-[-4px] transition-all duration-500">
        <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-1000"></div>
        <div class="relative z-10 flex flex-col justify-between h-full">
            <div class="flex justify-between items-start mb-6">
                <div class="w-14 h-14 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center border border-white/20">
                    <span class="material-symbols-outlined text-3xl">confirmation_number</span>
                </div>
                <span class="text-[9px] font-black uppercase tracking-[0.2em] bg-white/20 px-3 py-1.5 rounded-lg backdrop-blur-md">Journeys</span>
            </div>
            <div>
                <p class="text-xs font-black text-sky-100 uppercase tracking-widest mb-1 opacity-70">Total Bookings</p>
                <h3 class="text-5xl font-black tracking-tighter">{{ number_format($stats['total_bookings'] ?? 0) }}</h3>
            </div>
        </div>
    </div>

    <!-- Stat Card: Revenue -->
    <div class="group relative overflow-hidden bg-emerald-600 p-8 rounded-xl shadow-2xl hover:translate-y-[-4px] transition-all duration-500">
        <div class="absolute -top-10 -left-10 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-1000"></div>
        <div class="relative z-10 flex flex-col justify-between h-full">
            <div class="flex justify-between items-start mb-6">
                <div class="w-14 h-14 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center border border-white/20">
                    <span class="material-symbols-outlined text-3xl">payments</span>
                </div>
                <span class="text-[9px] font-black uppercase tracking-[0.2em] bg-white/20 px-3 py-1.5 rounded-lg backdrop-blur-md">Capital</span>
            </div>
            <div>
                <p class="text-xs font-black text-emerald-100 uppercase tracking-widest mb-1 opacity-70">Total Revenue</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-4xl font-black tracking-tighter">{{ number_format($stats['total_revenue'] ?? 0, 0) }}</h3>
                    <span class="text-xl font-bold opacity-60">€</span>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Stat Card: Geographical -->
    <div class="group relative overflow-hidden bg-slate-950 p-8 rounded-xl shadow-2xl hover:translate-y-[-4px] transition-all duration-500 border border-white/5">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-primary-600/10 blur-[100px] pointer-events-none"></div>
        <div class="relative z-10 flex flex-col justify-between h-full">
            <div class="flex justify-between items-start mb-6">
                <div class="w-14 h-14 rounded-xl bg-white/5 backdrop-blur-md flex items-center justify-center border border-white/10">
                    <span class="material-symbols-outlined text-3xl text-primary-400">language</span>
                </div>
                <span class="text-[9px] font-black uppercase tracking-[0.2em] bg-white/10 px-3 py-1.5 rounded-lg">Destinations</span>
            </div>
            <div>
                <p class="text-xs font-black text-slate-500 uppercase tracking-widest mb-2 opacity-70 italic">World Coverage</p>
                <div class="flex items-center gap-3">
                    <div class="flex flex-col">
                        <span class="text-3xl font-black text-white leading-none">{{ $stats['total_cities'] }}</span>
                        <span class="text-[8px] font-black uppercase tracking-tighter text-slate-500 italic mt-1">Cities</span>
                    </div>
                    <div class="w-px h-8 bg-slate-800"></div>
                    <div class="flex flex-col">
                        <span class="text-3xl font-black text-white leading-none">{{ $stats['total_countries'] }}</span>
                        <span class="text-[8px] font-black uppercase tracking-tighter text-slate-500 italic mt-1">Nations</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(auth()->user()->isAdmin())
<div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
    <!-- Recent Bookings Table -->
    <div class="lg:col-span-2 glass-card rounded-xl shadow-2xl p-10 border border-white overflow-hidden relative">
        <div class="absolute top-0 right-0 w-32 h-32 bg-primary-100/20 blur-3xl rounded-full"></div>
        
        <div class="flex items-center justify-between mb-10 relative z-10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-slate-900 rounded-lg flex items-center justify-center text-white">
                    <span class="material-symbols-outlined text-xl">list_alt</span>
                </div>
                <h3 class="text-2xl font-black tracking-tight text-slate-900">Recent Stream</h3>
            </div>
            <a href="{{ route('admin.bookings.index') }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-primary-600 hover:text-indigo-600 transition-colors flex items-center gap-2">
                Audit Trail <span class="material-symbols-outlined text-xs">arrow_forward</span>
            </a>
        </div>

        <div class="overflow-x-auto relative z-10">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                        <th class="pb-6">Explorer</th>
                        <th class="pb-6">Destination</th>
                        <th class="pb-6">Volume</th>
                        <th class="pb-6">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($latest_bookings as $booking)
                        <tr class="group hover:bg-slate-50/50 transition-all">
                            <td class="py-6 pr-4">
                                <p class="text-sm font-black text-slate-900 leading-none mb-1">{{ $booking->user->name }}</p>
                                <p class="text-[10px] text-slate-400 font-bold italic">{{ $booking->user->email }}</p>
                            </td>
                            <td class="py-6 pr-4">
                                <p class="text-sm font-black text-slate-700 leading-none mb-1 capitalize">{{ $booking->city->name ?? 'Unknown' }}</p>
                                <p class="text-[10px] text-primary-600 font-black uppercase tracking-widest italic">{{ $booking->trip_type }}</p>
                            </td>
                            <td class="py-6 pr-4">
                                <span class="font-black text-slate-950">&euro;{{ number_format($booking->budget_total, 0) }}</span>
                            </td>
                            <td class="py-6">
                                <span class="px-4 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest flex items-center gap-2 w-fit {{ $booking->status === 'paid' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-amber-50 text-amber-600 border border-amber-100' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $booking->status === 'paid' ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                                    {{ $booking->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-20 text-center">
                                <span class="material-symbols-outlined text-4xl text-slate-200 mb-2">inbox</span>
                                <p class="text-slate-400 text-xs font-black uppercase tracking-widest">No Recent Activity</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Users -->
    <div class="glass-card rounded-xl shadow-2xl p-10 border border-white">
        <div class="flex items-center gap-3 mb-10">
            <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center text-white">
                <span class="material-symbols-outlined text-xl">person_add</span>
            </div>
            <h3 class="text-2xl font-black tracking-tight text-slate-900">New Onboard</h3>
        </div>

        <div class="space-y-8">
            @forelse($recent_users as $user)
                <div class="flex items-center gap-5 group">
                    <div class="w-14 h-14 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-300 group-hover:bg-primary-600 group-hover:text-white group-hover:scale-105 transition-all duration-500 overflow-hidden shadow-sm">
                        <span class="material-symbols-outlined text-3xl">account_circle</span>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-black text-slate-900 leading-none mb-1 group-hover:text-primary-600 transition-colors uppercase tracking-tight">{{ $user->name }}</p>
                        <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest italic">{{ $user->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="w-2 h-2 rounded-full bg-emerald-400 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </div>
            @empty
                <p class="text-center text-slate-300 py-10 italic">No recent explorers.</p>
            @endforelse
        </div>

        <div class="mt-12 pt-10 border-t border-slate-100">
            <a href="{{ route('admin.users.index') }}" class="flex items-center justify-center gap-2 w-full py-5 bg-slate-950 text-white hover:bg-primary-600 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] transition-all shadow-xl hover:shadow-primary-500/20 active:scale-95 group">
                Command Users
                <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">manage_accounts</span>
            </a>
        </div>
    </div>
</div>
@endif

@if(auth()->user()->isTravlerAdmin())
<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-12">
    <div class="glass-card p-10 rounded-2xl border border-white shadow-xl relative overflow-hidden">
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-primary-100/20 blur-3xl rounded-full"></div>
        <h3 class="text-2xl font-black text-slate-900 mb-6 flex items-center gap-3">
            <span class="material-symbols-outlined text-primary-600">public</span>
            Territory Management
        </h3>
        <p class="text-slate-500 mb-8 font-medium">Manage global nations and their distinct regional hubs.</p>
        <div class="flex gap-4">
            <a href="{{ route('admin.countries.index') }}" class="px-6 py-3 bg-slate-900 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-primary-600 transition-all">Nations</a>
            <a href="{{ route('admin.cities.index') }}" class="px-6 py-3 bg-white border border-slate-200 text-slate-900 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-50 transition-all">Cities</a>
        </div>
    </div>
    
    <div class="glass-card p-10 rounded-2xl border border-white shadow-xl relative overflow-hidden">
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-emerald-100/20 blur-3xl rounded-full"></div>
        <h3 class="text-2xl font-black text-slate-900 mb-6 flex items-center gap-3">
            <span class="material-symbols-outlined text-emerald-600">explore</span>
            Experience Curation
        </h3>
        <p class="text-slate-500 mb-8 font-medium">Establish landmarks and luxury sanctuaries for travelers.</p>
        <div class="flex gap-4">
            <a href="{{ route('admin.places.index') }}" class="px-6 py-3 bg-slate-900 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-emerald-600 transition-all">Landmarks</a>
            <a href="{{ route('admin.hotels.index') }}" class="px-6 py-3 bg-white border border-slate-200 text-slate-900 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-slate-50 transition-all">Sanctuaries</a>
        </div>
    </div>
</div>
@endif
@endsection
