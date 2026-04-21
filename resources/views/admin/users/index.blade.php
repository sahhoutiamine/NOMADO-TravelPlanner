@extends('layouts.admin')

@section('category', 'Personnel Management')
@section('title', 'Staff & Explorers')

@section('content')
<div class="mb-10 flex justify-end">
    <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-slate-950 text-white font-black rounded-xl shadow-2xl hover:bg-primary-600 transition-all hover:translate-y-[-2px] group active:scale-95">
        <span class="material-symbols-outlined text-xl group-hover:rotate-12 transition-transform">person_add</span>
        Provision Account
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

<div class="glass-card rounded-xl shadow-2xl overflow-hidden border border-white">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] border-b border-slate-100">
                    <th class="px-10 py-8">Digital Identity</th>
                    <th class="px-10 py-8">Access Tier</th>
                    <th class="px-10 py-8">Onboard Date</th>
                    <th class="px-10 py-8">Status</th>
                    <th class="px-10 py-8 text-right">Command Controls</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($users as $user)
                    <tr class="group hover:bg-white/40 transition-all duration-300">
                        <td class="px-10 py-8">
                            <div class="flex items-center gap-6">
                                <div class="w-14 h-14 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-300 group-hover:bg-primary-600 group-hover:text-white transition-all duration-500 overflow-hidden shadow-sm">
                                    <span class="material-symbols-outlined text-3xl">account_circle</span>
                                </div>
                                <div class="flex flex-col">
                                    <p class="text-base font-black text-slate-950 leading-none mb-1.5 uppercase tracking-tight">{{ $user->name }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest italic">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-8">
                            <span class="px-4 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest flex items-center gap-2 w-fit {{ $user->role === 'admin' ? 'bg-red-50 text-red-600 border border-red-100' : 'bg-emerald-50 text-emerald-600 border border-emerald-100' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $user->role === 'admin' ? 'bg-red-500' : 'bg-emerald-500' }}"></span>
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-10 py-8">
                            <span class="text-xs font-black text-slate-500 uppercase tracking-tighter">{{ $user->created_at->format('M d, Y') }}</span>
                        </td>
                        <td class="px-10 py-8">
                            <span class="px-4 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest flex items-center gap-2 w-fit {{ $user->is_banned ? 'bg-amber-50 text-amber-600 border border-amber-100' : 'bg-emerald-50 text-emerald-600 border border-emerald-100' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $user->is_banned ? 'bg-amber-500' : 'bg-emerald-500' }}"></span>
                                {{ $user->is_banned ? 'Banned' : 'Active' }}
                            </span>
                        </td>
                        <td class="px-10 py-8">
                            <div class="flex items-center justify-end gap-3 transition-all duration-300">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-all" title="Edit Meta">
                                    <span class="material-symbols-outlined text-xl">edit_square</span>
                                </a>
                                @if(auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.toggle-ban', $user->id) }}" method="POST" onsubmit="return confirm('{{ $user->is_banned ? 'Restore access for this entity?' : 'Banish this entity from the platform?' }}');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="w-10 h-10 flex items-center justify-center text-slate-400 {{ $user->is_banned ? 'hover:text-emerald-500 hover:bg-emerald-50' : 'hover:text-amber-500 hover:bg-amber-50' }} rounded-lg transition-all" title="{{ $user->is_banned ? 'Unban User' : 'Ban User' }}">
                                            <span class="material-symbols-outlined text-xl">{{ $user->is_banned ? 'lock_open' : 'block' }}</span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
