@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#fdfdfd] py-12 md:py-24 flex items-center justify-center relative overflow-hidden">
    <!-- Abstract background elements -->
    <div class="absolute top-0 left-0 w-96 h-96 bg-primary-100 rounded-full blur-3xl -ml-40 -mt-40 opacity-40"></div>
    <div class="absolute bottom-0 right-0 w-[30rem] h-[30rem] bg-indigo-100 rounded-full blur-[100px] -mr-60 -mb-60 opacity-40"></div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 w-full relative z-10">
        <div class="text-center mb-16 fade-in">
            <div class="inline-flex items-center space-x-2 bg-primary-100 text-primary-700 px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-[0.2em] mb-6 shadow-sm border border-primary-200/50">
                AI Powered Planner
            </div>
            <h1 class="text-4xl md:text-7xl font-black text-slate-900 tracking-tighter leading-tight mb-6">
                Start Your Next <span class="block text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-indigo-600">Adventure.</span>
            </h1>
            <p class="text-slate-500 text-lg md:text-xl font-light max-w-2xl mx-auto">
                Define your vision, set your budget, and let our engine craft the perfect escape tailored just for you.
            </p>
        </div>

        <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-2xl shadow-slate-200/60 p-8 md:p-12 border border-white fade-in" style="animation-delay: 0.2s;">
            <form action="{{ route('trip.generate') }}" method="POST" class="space-y-10">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-10">
                    <!-- Trip Type -->
                    <div class="group">
                        <label for="trip_type" class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-3 group-focus-within:text-primary-600 transition-colors">Experience Type</label>
                        <div class="relative">
                            <select id="trip_type" name="trip_type" required class="w-full bg-slate-50 border-none rounded-2xl py-5 px-6 text-lg font-bold text-slate-900 focus:ring-4 focus:ring-primary-500/10 transition-all appearance-none cursor-pointer">
                                <option value="" disabled selected>Select Atmosphere...</option>
                                <option value="adventure">🏔️ Adventure & Thrills</option>
                                <option value="culture">🏛️ Arts & Culture</option>
                                <option value="beach">🏖️ Sun & Relaxation</option>
                                <option value="romantic">💍 Pure Romance</option>
                                <option value="nature">🌿 Nature Escape</option>
                                <option value="shopping">🛍️ Luxury Shopping</option>
                            </select>
                            <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('trip_type')" class="mt-2" />
                    </div>

                    <!-- Budget -->
                    <div class="group">
                        <label for="budget" class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-3 group-focus-within:text-primary-600 transition-colors">Total Budget (€)</label>
                        <div class="relative">
                            <input id="budget" type="number" name="budget" min="100" required placeholder="e.g. 2500" 
                                   class="w-full bg-slate-50 border-none rounded-2xl py-5 px-6 text-2xl font-black text-slate-900 focus:ring-4 focus:ring-primary-500/10 transition-all placeholder:text-slate-300">
                            <div class="absolute inset-y-0 right-6 flex items-center pointer-events-none text-slate-400 font-black text-xl">
                                €
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('budget')" class="mt-2" />
                    </div>

                    <!-- Duration -->
                    <div class="group">
                        <label for="duration" class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-3 group-focus-within:text-primary-600 transition-colors">Stay Duration (Nights)</label>
                        <div class="relative">
                            <input id="duration" type="number" name="duration" min="1" required placeholder="e.g. 7" 
                                   class="w-full bg-slate-50 border-none rounded-2xl py-5 px-6 text-2xl font-black text-slate-900 focus:ring-4 focus:ring-primary-500/10 transition-all placeholder:text-slate-300">
                            <div class="absolute inset-y-0 right-6 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                    </div>

                    <!-- Passengers -->
                    <div class="group">
                        <label for="passengers" class="block text-[11px] font-black uppercase tracking-widest text-slate-400 mb-3 group-focus-within:text-primary-600 transition-colors">Travelers</label>
                        <div class="relative">
                            <input id="passengers" type="number" name="passengers" min="1" required placeholder="e.g. 2" 
                                   class="w-full bg-slate-50 border-none rounded-2xl py-5 px-6 text-2xl font-black text-slate-900 focus:ring-4 focus:ring-primary-500/10 transition-all placeholder:text-slate-300">
                             <div class="absolute inset-y-0 right-6 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('passengers')" class="mt-2" />
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-50">
                    <button type="submit" class="w-full py-6 bg-slate-900 text-white rounded-[1.5rem] font-black text-xl shadow-2xl shadow-slate-900/20 hover:bg-primary-600 hover:-translate-y-1 transition-all active:scale-95 flex items-center justify-center group overflow-hidden relative">
                        <span class="relative z-10">Generate My Journey</span>
                        <div class="absolute inset-0 bg-gradient-to-r from-primary-600 to-indigo-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <svg class="w-6 h-6 ml-3 relative z-10 group-hover:translate-x-3 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </button>
                    <p class="text-center text-slate-400 text-xs mt-6 font-medium uppercase tracking-[0.2em]">Crafted by Nomado Intelligience</p>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .fade-in {
        animation: fadeIn 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
        transform: translateY(30px);
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .tracking-tighter { letter-spacing: -0.05em; }
    .tracking-tight { letter-spacing: -0.025em; }
</style>
@endsection
