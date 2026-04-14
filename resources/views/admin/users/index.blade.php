@extends('layouts.admin')

@section('category', 'Administration')
@section('title', 'Staff & Travelers')

@section('content')
<div class="mb-8 flex justify-end">
    <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-6 py-3 bg-slate-900 text-white font-black rounded-2xl shadow-xl shadow-slate-900/20 hover:bg-primary-600 transition-all hover:-translate-y-1 group">
        <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
        Provision New Account
    </a>
</div>

@if(session('success'))
    <div class="mb-8 bg-green-50 border border-green-100 text-green-700 px-6 py-4 rounded-2xl flex items-center gap-3 fade-in">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span class="font-bold">{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div class="mb-8 bg-red-50 border border-red-100 text-red-700 px-6 py-4 rounded-2xl flex items-center gap-3 fade-in">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span class="font-bold">{{ session('error') }}</span>
    </div>
@endif

<div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 overflow-hidden border border-white">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100">
                    <th class="px-8 py-6">Personal Profile</th>
                    <th class="px-8 py-6">Access Level</th>
                    <th class="px-8 py-6">Registration Date</th>
                    <th class="px-8 py-6 text-right">Access Controls</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($users as $user)
                    <tr class="group hover:bg-slate-50 transition-all">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-400 group-hover:bg-primary-500 group-hover:text-white transition-all shadow-sm">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-base font-black text-slate-900 leading-none mb-1">{{ $user->name }}</p>
                                    <p class="text-xs text-slate-400 font-medium">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest {{ $user->role === 'admin' ? 'bg-red-50 text-red-600 border border-red-100' : 'bg-green-50 text-green-600 border border-green-100' }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-sm font-bold text-slate-500">{{ $user->created_at->format('M d, Y') }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center justify-end gap-3 transition-opacity duration-300">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="p-2 text-slate-400 hover:text-primary-600 transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                @if(auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Revoke all access for this entity?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-red-500 transition-all">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
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
