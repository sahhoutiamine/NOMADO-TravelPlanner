@extends('layouts.app')

@section('content')
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .text-gradient {
            background: linear-gradient(to right, #0284c7, #6366f1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #0284c7, #6366f1);
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        .animate-float {
            animation: float 5s ease-in-out infinite;
        }

        @keyframes pulse-soft {

            0%,
            100% {
                opacity: 0.2;
                transform: scale(1);
            }

            50% {
                opacity: 0.3;
                transform: scale(1.1);
            }
        }

        .animate-pulse-soft {
            animation: pulse-soft 8s ease-in-out infinite;
        }

        .trip-type-label:hover .icon-box {
            transform: scale(1.1) rotate(5deg);
            background-color: rgba(2, 132, 199, 0.1);
        }
    </style>

    <div class="flex-grow flex items-center justify-center p-6 md:p-12 relative overflow-hidden min-h-screen pt-24">
        <!-- Atmospheric Background Elements -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div
                class="absolute -top-1/4 -right-1/4 w-[800px] h-[800px] bg-primary-200/20 rounded-full blur-[120px] animate-pulse-soft">
            </div>
            <div class="absolute -bottom-1/4 -left-1/4 w-[600px] h-[600px] bg-indigo-200/20 rounded-full blur-[100px] animate-pulse-soft"
                style="animation-delay: 2s;"></div>
        </div>

        <!-- The Planning Card -->
        <div class="relative w-full max-w-4xl glass-card rounded-2xl p-8 md:p-14 shadow-2xl z-10 animate-fade-in border border-white/50">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <div
                    class="inline-flex items-center gap-2 bg-primary-50 px-4 py-2 rounded-full border border-primary-100 mb-6 mx-auto">
                    <span class="material-symbols-outlined text-primary-600 text-sm"
                        style="font-variation-settings: 'FILL' 1;">magic_button</span>
                    <span class="text-xs font-bold text-primary-700 uppercase tracking-widest">Concierge</span>
                </div>
                <h1 class="text-5xl md:text-6xl font-black tracking-tighter text-slate-900 mb-4">Plan your <span
                        class="text-gradient">journey</span></h1>
                <p class="text-slate-500 font-medium text-lg max-w-2xl mx-auto">Define your vibe and budget, and our
                    Concierge will craft a bespoke itinerary tailored just for you.</p>
            </div>

            <form action="{{ route('trip.generate') }}" method="POST" class="space-y-12">
                @csrf

                <!-- Trip Type Grid -->
                <div class="space-y-6">
                    <h2 class="text-2xl font-bold text-slate-900 flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary-600"
                            style="font-variation-settings: 'FILL' 1;">explore</span>
                        What's your vibe?
                    </h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-5">
                        @php
                            $types = [
                                ['value' => 'adventure', 'label' => 'Adventure', 'icon' => 'hiking'],
                                ['value' => 'culture', 'label' => 'Culture', 'icon' => 'museum'],
                                ['value' => 'beach', 'label' => 'Beach', 'icon' => 'beach_access'],
                                ['value' => 'romantic', 'label' => 'Romantic', 'icon' => 'favorite'],
                                ['value' => 'nature', 'label' => 'Nature', 'icon' => 'forest'],
                                ['value' => 'shopping', 'label' => 'Shopping', 'icon' => 'local_mall'],
                            ];
                        @endphp

                        @foreach($types as $type)
                            <label class="cursor-pointer relative group trip-type-label">
                                <input class="peer sr-only" name="trip_type" type="radio" value="{{ $type['value'] }}" required
                                    {{ old('trip_type') == $type['value'] ? 'checked' : '' }} />
                                <div
                                    class="h-32 rounded-xl bg-white/50 border border-slate-100 peer-checked:bg-primary-50 peer-checked:border-primary-500 peer-checked:shadow-lg peer-checked:shadow-primary-500/10 transition-all duration-300 ease-out flex flex-col items-center justify-center gap-3 overflow-hidden group-hover:border-primary-300 group-hover:bg-white shadow-sm">
                                    <div class="icon-box p-3 rounded-2xl transition-all duration-300">
                                        <span
                                            class="material-symbols-outlined text-4xl text-slate-400 group-hover:text-primary-600 peer-checked:text-primary-600 transition-colors">{{ $type['icon'] }}</span>
                                    </div>
                                    <span
                                        class="font-bold text-slate-600 group-hover:text-slate-900 transition-colors">{{ $type['label'] }}</span>
                                    <div class="absolute top-2 right-2 opacity-0 peer-checked:opacity-100 transition-opacity">
                                        <span class="material-symbols-outlined text-primary-600 text-lg">check_circle</span>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    <x-input-error :messages="$errors->get('trip_type')" class="mt-2" />
                </div>

                <!-- Logistics Inputs -->
                <div class="space-y-6">
                    <h2 class="text-2xl font-bold text-slate-900 flex items-center gap-3">
                        <span class="material-symbols-outlined text-indigo-600"
                            style="font-variation-settings: 'FILL' 1;">tune</span>
                        The Logistics
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Budget -->
                        <div class="space-y-2">
                            <label class="font-bold text-xs uppercase tracking-widest text-slate-400 block"
                                for="budget">Budget (EUR)</label>
                            <div class="relative group">
                                <span
                                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary-600 transition-colors">euro_symbol</span>
                                <input
                                    class="w-full bg-slate-50/50 border border-slate-100 rounded-2xl py-4 pl-12 pr-4 text-slate-900 placeholder:text-slate-300 focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all text-lg outline-none font-semibold"
                                    id="budget" name="budget" placeholder="2500" type="number" required
                                    value="{{ old('budget') }}" />
                            </div>
                            <x-input-error :messages="$errors->get('budget')" class="mt-1" />
                        </div>
                        <!-- Duration -->
                        <div class="space-y-2">
                            <label class="font-bold text-xs uppercase tracking-widest text-slate-400 block"
                                for="duration">Duration (nights)</label>
                            <div class="relative group">
                                <span
                                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary-600 transition-colors">bed</span>
                                <input
                                    class="w-full bg-slate-50/50 border border-slate-100 rounded-2xl py-4 pl-12 pr-4 text-slate-900 placeholder:text-slate-300 focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all text-lg outline-none font-semibold"
                                    id="duration" name="duration" placeholder="7" type="number" required
                                    value="{{ old('duration') }}" />
                            </div>
                            <x-input-error :messages="$errors->get('duration')" class="mt-1" />
                        </div>
                        <!-- Travelers -->
                        <div class="space-y-2">
                            <label class="font-bold text-xs uppercase tracking-widest text-slate-400 block"
                                for="passengers">Travelers</label>
                            <div class="relative group">
                                <span
                                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary-600 transition-colors">group</span>
                                <input
                                    class="w-full bg-slate-50/50 border border-slate-100 rounded-2xl py-4 pl-12 pr-4 text-slate-900 placeholder:text-slate-300 focus:ring-4 focus:ring-primary-500/10 focus:border-primary-500 transition-all text-lg outline-none font-semibold"
                                    id="passengers" name="passengers" placeholder="2" type="number" required
                                    value="{{ old('passengers') }}" />
                            </div>
                            <x-input-error :messages="$errors->get('passengers')" class="mt-1" />
                        </div>
                    </div>
                </div>

                <!-- Submit Action -->
                <div class="pt-8">
                    <button
                        class="w-full bg-slate-950 text-white rounded-[1.5rem] py-5 font-black text-xl hover:shadow-xl transition-all duration-300 flex items-center justify-center gap-3 relative overflow-hidden group"
                        type="submit">
                        <div class="absolute inset-0 bg-primary-600 opacity-0 group-hover:opacity-10 transition-opacity"></div>
                        <span class="relative z-10">Generate My Journey</span>
                        <span class="material-symbols-outlined relative z-10"
                            style="font-variation-settings: 'FILL' 0;">auto_awesome</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Simple page entrance animation
        document.addEventListener('DOMContentLoaded', () => {
            const card = document.querySelector('.glass-card');
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';

            setTimeout(() => {
                card.style.transition = 'all 0.8s cubic-bezier(0.16, 1, 0.3, 1)';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
@endsection