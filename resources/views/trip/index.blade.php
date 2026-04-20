@extends('layouts.app')

@section('content')
<div class="min-h-screen py-12 md:py-24">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <!-- Page Title -->
        <div class="mb-10 animate-on-scroll fade-in">
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Plan your trip</h1>
            <p class="text-gray-500 text-sm mt-1">Define your preferences and let our engine craft the perfect escape for you.</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 animate-on-scroll slide-in-up" style="animation-delay: 0.1s;">
            <form action="{{ route('trip.generate') }}" method="POST" class="space-y-8">
                @csrf

                <!-- Trip Type Grid -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Trip Type</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach([
                            'adventure' => 'Adventure',
                            'culture' => 'Culture',
                            'beach' => 'Beach',
                            'romantic' => 'Romantic',
                            'nature' => 'Nature',
                            'shopping' => 'Shopping'
                        ] as $value => $label)
                            <label class="relative cursor-pointer animate-on-scroll fade-in" style="animation-delay: {{ 0.05 * ($loop->index + 1) }}s;">
                                <input type="radio" name="trip_type" value="{{ $value }}" required class="sr-only peer"
                                    {{ old('trip_type') == $value ? 'checked' : '' }}>
                                <div class="peer-checked:border-primary-600 peer-checked:bg-primary-50 peer-checked:text-primary-700 peer-checked:font-semibold peer-checked:scale-105 border border-gray-200 bg-white text-gray-600 rounded-xl py-4 px-4 transition-all hover:border-primary-400 hover:bg-primary-50 flex items-center justify-center text-center text-sm font-medium trip-type-option">
                                    {{ $label }}
                                </div>
                            </label>
                        @endforeach
                    </div>
                    <x-input-error :messages="$errors->get('trip_type')" class="mt-2" />
                </div>

                <!-- Form Fields Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Budget -->
                    <div>
                        <label for="budget" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Total Budget (EUR)</label>
                        <input id="budget" type="number" name="budget" min="100" required placeholder="e.g. 2500"
                               class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-colors placeholder:text-gray-400">
                        <x-input-error :messages="$errors->get('budget')" class="mt-2" />
                    </div>

                    <!-- Duration -->
                    <div>
                        <label for="duration" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Stay Duration (Nights)</label>
                        <input id="duration" type="number" name="duration" min="1" required placeholder="e.g. 7"
                               class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-colors placeholder:text-gray-400">
                        <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                    </div>

                    <!-- Travelers -->
                    <div class="md:col-span-2">
                        <label for="passengers" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Number of Travelers</label>
                        <input id="passengers" type="number" name="passengers" min="1" required placeholder="e.g. 2"
                               class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 transition-colors placeholder:text-gray-400">
                        <x-input-error :messages="$errors->get('passengers')" class="mt-2" />
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-gray-100">
                    <button type="submit" class="w-full py-4 bg-gray-900 text-white rounded-xl font-semibold text-base hover:bg-primary-600 transition-colors flex items-center justify-center gap-2 submit-shimmer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        Generate My Journey
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Scale bounce on trip type selection
    document.querySelectorAll('.trip-type-option').forEach(option => {
        option.addEventListener('click', function() {
            this.style.animation = 'scaleClick 0.3s ease-out';
            setTimeout(() => {
                this.style.animation = '';
            }, 300);
        });
    });
</script>

<style>
    @keyframes scaleClick {
        0% { transform: scale(1); }
        50% { transform: scale(0.95); }
        100% { transform: scale(1.05); }
    }

    @keyframes shimmerButton {
        0% { background-position: -1000px 0; }
        100% { background-position: 1000px 0; }
    }

    .submit-shimmer {
        position: relative;
        overflow: hidden;
    }

    .submit-shimmer:hover {
        background-image: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.3) 50%, transparent 100%);
        background-size: 200% 100%;
        animation: shimmerButton 0.8s ease-in-out;
    }

    @media (prefers-reduced-motion: reduce) {
        .trip-type-option, .submit-shimmer:hover {
            animation: none !important;
        }
    }
</style>
@endsection
