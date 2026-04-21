@extends('layouts.app')

@section('content')
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.85);
        border: 1px solid rgba(255, 255, 255, 0.4);
    }
    .text-gradient {
        background: linear-gradient(to right, #0284c7, #6366f1);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .bg-gradient-primary {
        background: linear-gradient(135deg, #0284c7, #6366f1);
    }
    @keyframes slideUp {
        from { transform: translateY(30px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .animate-slide-up {
        animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    .profile-input {
        transition: all 0.3s ease;
    }
    .profile-input:focus {
        transform: translateY(-2px);
    }
</style>

<div class="flex-grow pt-32 pb-24 px-4 md:px-8 max-w-4xl mx-auto relative min-h-screen">
    <!-- Atmospheric Background Elements -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-1/4 -right-1/4 w-[800px] h-[800px] bg-primary-200/10 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-1/4 -left-1/4 w-[600px] h-[600px] bg-indigo-200/10 rounded-full blur-[100px]"></div>
    </div>

    <!-- Header Section -->
    <div class="mb-16 animate-slide-up relative z-10">
        <div class="inline-flex items-center gap-2 bg-primary-50 px-4 py-2 rounded-lg border border-primary-100 mb-6 font-black text-[10px] text-primary-700 uppercase tracking-widest">
            <span class="material-symbols-outlined text-sm">person</span>
            Member Account
        </div>
        <h1 class="text-5xl md:text-6xl font-black tracking-tighter text-slate-900 mb-4">Account <span class="text-gradient">Settings</span></h1>
        <p class="text-slate-500 font-medium text-lg leading-relaxed italic">Tailor your Nomado profile and secure your journey credentials.</p>
    </div>

    @if (session('status') === 'profile-updated' || session('status') === 'password-updated')
        <div class="mb-12 animate-slide-up relative z-20">
            <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-6 py-5 rounded-xl flex items-center gap-3 font-bold text-sm shadow-sm shadow-emerald-100/30">
                <span class="material-symbols-outlined">check_circle</span>
                {{ session('status') === 'profile-updated' ? 'Profile details synchronized.' : 'Security credentials updated.' }}
            </div>
        </div>
    @endif

    <div class="space-y-10 relative z-10">
        <!-- Profile Information Section -->
        <div class="animate-slide-up" style="animation-delay: 0.1s">
            <div class="glass-card p-10 rounded-xl shadow-2xl border border-white relative overflow-hidden group">
                <div class="absolute -top-20 -right-20 w-64 h-64 bg-primary-200/20 blur-[80px] rounded-full pointer-events-none transition-transform group-hover:scale-150 duration-1000"></div>
                
                <h2 class="text-2xl font-black text-slate-900 tracking-tight mb-8 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary-600">badge</span>
                    Profile Credentials
                </h2>

                <form method="post" action="{{ route('profile.update') }}" class="space-y-8">
                    @csrf
                    @method('patch')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label for="name" class="font-black text-[10px] uppercase tracking-widest text-slate-400 block ml-1">Identity</label>
                            <div class="relative group">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-primary-600 transition-colors">person</span>
                                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus 
                                       class="profile-input w-full bg-slate-50 border border-slate-100 rounded-xl py-4 pl-12 pr-4 text-slate-900 focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 outline-none font-bold italic" placeholder="Your Name">
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div class="space-y-2">
                            <label for="email" class="font-black text-[10px] uppercase tracking-widest text-slate-400 block ml-1">Contact Anchor</label>
                            <div class="relative group">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-primary-600 transition-colors">alternate_email</span>
                                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required 
                                       class="profile-input w-full bg-slate-50 border border-slate-100 rounded-xl py-4 pl-12 pr-4 text-slate-900 focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 outline-none font-bold italic" placeholder="you@domain.com">
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="bg-slate-900 text-white px-10 py-4 rounded-xl font-black text-sm uppercase tracking-widest hover:bg-primary-600 hover:shadow-xl transition-all active:scale-95 flex items-center gap-3 group">
                            Sync Profile
                            <span class="material-symbols-outlined text-base group-hover:translate-x-1 transition-transform">sync_saved_locally</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Security Update Section -->
        <div class="animate-slide-up" style="animation-delay: 0.2s">
            <div class="glass-card p-10 rounded-xl shadow-2xl border border-white relative overflow-hidden group">
                <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-indigo-200/20 blur-[80px] rounded-full pointer-events-none transition-transform group-hover:scale-150 duration-1000"></div>

                <h2 class="text-2xl font-black text-slate-900 tracking-tight mb-8 flex items-center gap-3">
                    <span class="material-symbols-outlined text-indigo-600">security</span>
                    Access Vault
                </h2>

                <form method="post" action="{{ route('password.update') }}" class="space-y-8">
                    @csrf
                    @method('put')

                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label for="update_password_current_password" class="font-black text-[10px] uppercase tracking-widest text-slate-400 block ml-1">Current Key</label>
                            <div class="relative group max-w-md">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-indigo-600 transition-colors">lock_open</span>
                                <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                                       class="profile-input w-full bg-slate-50 border border-slate-100 rounded-xl py-4 pl-12 pr-4 text-slate-900 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none font-bold" placeholder="••••••••">
                            </div>
                            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label for="update_password_password" class="font-black text-[10px] uppercase tracking-widest text-slate-400 block ml-1">New Signature</label>
                                <div class="relative group">
                                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-indigo-600 transition-colors">key</span>
                                    <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                                           class="profile-input w-full bg-slate-50 border border-slate-100 rounded-xl py-4 pl-12 pr-4 text-slate-900 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none font-bold" placeholder="Min. 8 characters">
                                </div>
                                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                            </div>

                            <div class="space-y-2">
                                <label for="update_password_password_confirmation" class="font-black text-[10px] uppercase tracking-widest text-slate-400 block ml-1">Confirm Signature</label>
                                <div class="relative group">
                                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-indigo-600 transition-colors">task_alt</span>
                                    <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                                           class="profile-input w-full bg-slate-50 border border-slate-100 rounded-xl py-4 pl-12 pr-4 text-slate-900 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none font-bold" placeholder="Match new signature">
                                </div>
                                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="bg-indigo-600 text-white px-10 py-4 rounded-xl font-black text-sm uppercase tracking-widest hover:bg-slate-900 hover:shadow-xl transition-all active:scale-95 flex items-center gap-3 group">
                            Rotate Keys
                            <span class="material-symbols-outlined text-base">encrypted</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="animate-slide-up" style="animation-delay: 0.3s">
            <div class="p-10 rounded-xl border border-red-100 bg-red-50/30 flex flex-col md:flex-row justify-between items-center gap-6">
                <div>
                    <h2 class="text-xl font-black text-red-600 tracking-tight flex items-center gap-2">
                        <span class="material-symbols-outlined">warning</span>
                        Terminate Exploration
                    </h2>
                    <p class="text-slate-500 text-sm font-medium mt-1">Permanently erase your Nomado history and digital footprint.</p>
                </div>

                <x-danger-button
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                    class="px-8 py-4 bg-red-600 text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-red-700 transition-all shadow-lg shadow-red-200"
                >
                    Erase Account
                </x-danger-button>
            </div>
        </div>
    </div>
</div>

<x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
    <form method="post" action="{{ route('profile.destroy') }}" class="p-10 bg-white rounded-xl shadow-2xl border border-red-50">
        @csrf
        @method('delete')

        <div class="w-16 h-16 bg-red-50 rounded-lg flex items-center justify-center text-red-600 mb-8">
            <span class="material-symbols-outlined text-4xl">delete_forever</span>
        </div>

        <h2 class="text-3xl font-black text-slate-900 tracking-tighter mb-4">Final Confirmation</h2>
        <p class="text-slate-500 font-medium leading-relaxed mb-8 italic">
            "Once deleted, your bespoke journeys and data will be permanently erased. Please provide your security key to finalize the termination."
        </p>

        <div class="mb-10">
            <label for="password" class="sr-only">Password</label>
            <div class="relative group">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-red-500">lock</span>
                <input id="password" name="password" type="password" placeholder="Confirm your signature"
                       class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-4 pl-12 text-slate-900 focus:ring-4 focus:ring-red-500/10 focus:border-red-500 outline-none font-bold">
            </div>
            <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end gap-6">
            <button type="button" x-on:click="$dispatch('close')" class="font-black text-xs uppercase tracking-widest text-slate-400 hover:text-slate-900 transition-colors">
                Abort
            </button>
            <button type="submit" class="px-8 py-4 bg-red-600 text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-red-700 transition-all active:scale-95">
                Confirm Erasure
            </button>
        </div>
    </form>
</x-modal>
@endsection
