@extends('layouts.admin')

@section('category', 'Administration')
@section('title', 'Refine Identity')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 p-10 border border-white fade-in">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PATCH')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label for="name" class="block text-xs font-black uppercase tracking-widest text-slate-400">Full Handle</label>
                    <input type="text" name="name" id="name" required value="{{ old('name', $user->name) }}"
                           class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-lg font-bold text-slate-900 focus:ring-4 focus:ring-primary-500/10 transition-all">
                    <x-input-error :messages="$errors->get('name')" />
                </div>

                <div class="space-y-2">
                    <label for="email" class="block text-xs font-black uppercase tracking-widest text-slate-400">Security Email</label>
                    <input type="email" name="email" id="email" required value="{{ old('email', $user->email) }}"
                           class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-lg font-bold text-slate-900 focus:ring-4 focus:ring-primary-500/10 transition-all">
                    <x-input-error :messages="$errors->get('email')" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label for="role" class="block text-xs font-black uppercase tracking-widest text-slate-400">Clearance Level</label>
                    <select name="role" id="role" required class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-lg font-bold text-slate-900 focus:ring-4 focus:ring-primary-500/10 transition-all appearance-none cursor-pointer">
                        <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>Standard Traveler (User)</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Platform Strategist (Admin)</option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" />
                </div>
                
                <div class="flex items-center pt-6 px-4">
                    <p class="text-xs text-slate-400 leading-relaxed italic">Modifying clearance level affects this entity's operational capacity immediately.</p>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-100">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-6">Security Override (Leave blank to keep current sequence)</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label for="password" class="block text-xs font-black uppercase tracking-widest text-slate-400">New Sequence</label>
                        <input type="password" name="password" id="password"
                               class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-lg font-bold text-slate-900 focus:ring-4 focus:ring-primary-500/10 transition-all">
                        <x-input-error :messages="$errors->get('password')" />
                    </div>

                    <div class="space-y-2">
                        <label for="password_confirmation" class="block text-xs font-black uppercase tracking-widest text-slate-400">Confirm New Sequence</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-lg font-bold text-slate-900 focus:ring-4 focus:ring-primary-500/10 transition-all">
                    </div>
                </div>
            </div>

            <div class="pt-6 flex justify-end gap-4 border-t border-slate-50">
                <a href="{{ route('admin.users.index') }}" class="px-8 py-4 text-slate-400 font-black uppercase tracking-widest text-xs hover:text-slate-600 transition-colors">Discard Revisions</a>
                <button type="submit" class="px-10 py-4 bg-primary-600 text-white rounded-2xl font-black shadow-xl shadow-primary-500/20 hover:bg-primary-700 transition-all hover:-translate-y-1">
                    Apply Operational Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
