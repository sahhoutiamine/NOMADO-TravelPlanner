@php
    $layout = auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.app';
@endphp

@extends($layout)

@section('category', 'Settings')
@section('title', 'Your Profile')

@section('content')
<div class="min-h-screen {{ auth()->user()->role === 'admin' ? '' : 'py-12 md:py-24 bg-[#f8fafc]' }}">
    <div class="{{ auth()->user()->role === 'admin' ? '' : 'max-w-5xl mx-auto px-4 sm:px-6 lg:px-8' }}">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            
            <!-- Left: Identity Card -->
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 p-8 border border-white relative overflow-hidden text-center group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary-100 rounded-full blur-3xl -mr-16 -mt-16 opacity-40"></div>
                    
                    <div class="relative inline-block mb-6">
                        <div class="w-32 h-32 rounded-[2rem] bg-slate-100 flex items-center justify-center text-slate-400 text-5xl font-black border-4 border-white shadow-xl transition-transform group-hover:rotate-6">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-primary-600 rounded-xl border-4 border-white flex items-center justify-center text-white shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                    </div>

                    <h2 class="text-2xl font-black text-slate-900 tracking-tight leading-none mb-2">{{ auth()->user()->name }}</h2>
                    <p class="text-sm font-bold text-primary-600 uppercase tracking-[0.2em] mb-6">{{ auth()->user()->role }} Account</p>
                    
                    <div class="pt-6 border-t border-slate-50 flex items-center justify-center gap-8">
                        <div>
                            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Joined</p>
                            <p class="text-sm font-bold text-slate-700">{{ auth()->user()->created_at->format('M Y') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white shadow-2xl shadow-slate-900/30">
                    <h3 class="text-lg font-black tracking-tight mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 4.946-2.397 9.126-6 11.751A11.954 11.954 0 0110 18.056c-3.603-2.625-6-6.805-6-11.751 0-.68.056-1.35.166-2.001zm8.834 4.001a1 1 0 10-2 0v3a1 1 0 102 0V9z" clip-rule="evenodd"></path></svg>
                        Security Status
                    </h3>
                    <p class="text-xs text-slate-400 leading-relaxed font-medium">Your account is currently secured with standard authentication. We recommend updating your security sequence periodically.</p>
                </div>
            </div>

            <!-- Right: Forms -->
            <div class="lg:col-span-8 space-y-10">
                
                @if (session('status') === 'profile-updated')
                    <div class="bg-green-50 border border-green-100 text-green-700 px-6 py-4 rounded-2xl flex items-center gap-3 fade-in">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span class="font-bold tracking-tight">System Refinement Complete: Profile Updated</span>
                    </div>
                @endif

                <!-- Personal Intel -->
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 p-10 border border-white fade-in">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-10 h-10 rounded-xl bg-primary-100 flex items-center justify-center text-primary-600 shadow-sm border border-primary-200/50">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-slate-800 tracking-tight">Identity Details</h3>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">General Account Settings</p>
                        </div>
                    </div>

                    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                        @csrf
                        @method('patch')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="name" class="block text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Full Designation</label>
                                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required
                                       class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-lg font-bold text-slate-900 focus:ring-4 focus:ring-primary-500/10 transition-all">
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div class="space-y-2">
                                <label for="email" class="block text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Security Email</label>
                                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                                       class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-lg font-bold text-slate-900 focus:ring-4 focus:ring-primary-500/10 transition-all">
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>
                        </div>

                        <div class="pt-4 flex justify-end">
                            <button type="submit" class="px-8 py-4 bg-slate-900 text-white rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-primary-600 transition-all hover:-translate-y-1 shadow-xl shadow-slate-900/20">
                                Apply Changes
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Security Sequence -->
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 p-10 border border-white fade-in" style="animation-delay: 0.2s;">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-600 shadow-sm border border-indigo-200/50">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-slate-800 tracking-tight">Security Sequence</h3>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Authentication Management</p>
                        </div>
                    </div>

                    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                        @csrf
                        @method('put')

                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label for="update_password_current_password" class="block text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Current Sequence</label>
                                <input id="update_password_current_password" name="current_password" type="password"
                                       class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-lg font-bold text-slate-900 focus:ring-4 focus:ring-primary-500/10 transition-all">
                                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label for="update_password_password" class="block text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">New Sequence</label>
                                    <input id="update_password_password" name="password" type="password"
                                           class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-lg font-bold text-slate-900 focus:ring-4 focus:ring-primary-500/10 transition-all">
                                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                                </div>

                                <div class="space-y-2">
                                    <label for="update_password_password_confirmation" class="block text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Verify Sequence</label>
                                    <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                                           class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-lg font-bold text-slate-900 focus:ring-4 focus:ring-primary-500/10 transition-all">
                                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 flex justify-end">
                            <button type="submit" class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-indigo-700 transition-all hover:-translate-y-1 shadow-xl shadow-indigo-500/20">
                                Update Sequence
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Danger Zone -->
                <div class="bg-red-50/50 rounded-[2.5rem] p-10 border border-red-100 fade-in" style="animation-delay: 0.4s;">
                    <h4 class="text-red-800 font-black tracking-tight text-xl mb-4">Termination Zone</h4>
                    <p class="text-red-600/80 text-sm font-medium mb-8 max-w-xl">Deleting your account will permanently scrub your travel history, bookings, and identification from our global servers. This action is irreversible.</p>
                    
                    <x-danger-button
                        x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                        class="px-8 py-4 !bg-red-600 !rounded-2xl !font-black !text-xs !uppercase !tracking-[0.2em] shadow-xl shadow-red-500/20 hover:!bg-red-700 transition-all"
                    >
                        Delete Operations Account
                    </x-danger-button>
                </div>
            </div>
        </div>
    </div>
</div>

<x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
    <form method="post" action="{{ route('profile.destroy') }}" class="p-10">
        @csrf
        @method('delete')

        <h2 class="text-3xl font-black text-slate-900 tracking-tighter mb-4">Final Account Scrub</h2>
        <p class="text-slate-500 leading-relaxed font-light mb-8 italic">Please enter your security sequence to confirm you wish to permanently terminate your Nomado account.</p>

        <div class="space-y-4 mb-10">
            <label for="password" class="block text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Verification Sequence</label>
            <input id="password" name="password" type="password" placeholder="Sequence..."
                   class="w-full bg-slate-50 border-none rounded-2xl py-4 px-6 text-lg font-bold text-slate-900 focus:ring-4 focus:ring-red-500/10 transition-all">
            <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end gap-6">
            <button type="button" x-on:click="$dispatch('close')" class="font-black text-xs uppercase tracking-widest text-slate-400 hover:text-slate-600 transition-colors">Abort Termination</button>
            <button type="submit" class="px-8 py-4 bg-red-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl shadow-red-500/20 hover:bg-red-700 transition-all">Confirm Termination</button>
        </div>
    </form>
</x-modal>

<style>
    .fade-in {
        animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
        transform: translateY(20px);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection
