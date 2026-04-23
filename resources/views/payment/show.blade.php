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
    @keyframes slideRight {
        from { transform: translateX(-30px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideUp {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .animate-slide-right {
        animation: slideRight 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    .animate-slide-up {
        animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    .step-section {
        transition: opacity 0.3s ease-in-out;
    }
    .step-section.hidden {
        display: none;
    }
    .step-indicator {
        display: flex;
        justify-content: center;
        gap: 2rem;
        margin-bottom: 3rem;
    }
    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.75rem;
    }
    .step-circle {
        width: 3.5rem;
        height: 3.5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        font-size: 1.25rem;
        transition: all 0.3s ease;
    }
    .step-circle.active {
        background: linear-gradient(135deg, #0284c7, #6366f1);
        color: white;
    }
    .step-circle.inactive {
        background: #f1f5f9;
        color: #94a3b8;
    }
    .step-label {
        font-size: 0.875rem;
        font-weight: 700;
    }
    .step-label.inactive {
        color: #94a3b8;
    }
    .hotel-card {
        border: 2px solid #e2e8f0;
        border-radius: 1rem;
        padding: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
    }
    .hotel-card:hover {
        border-color: #0284c7;
        box-shadow: 0 4px 16px rgba(2, 132, 199, 0.15);
    }
    .hotel-card.selected {
        border-color: #0284c7;
        background: linear-gradient(135deg, rgba(2, 132, 199, 0.05), rgba(99, 102, 241, 0.05));
        box-shadow: 0 4px 16px rgba(2, 132, 199, 0.2);
    }
    .hotel-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 0.75rem;
        margin-bottom: 1rem;
    }
    .hotel-type-badge {
        display: inline-block;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #0284c7;
        background: rgba(2, 132, 199, 0.1);
        padding: 0.35rem 0.75rem;
        border-radius: 0.5rem;
        margin-bottom: 0.5rem;
    }
    .card-input {
        border: 2px solid #e2e8f0;
        border-radius: 0.75rem;
        padding: 0.875rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        font-family: 'Courier New', monospace;
    }
    .card-input:focus {
        outline: none;
        border-color: #0284c7;
        box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.1);
    }
</style>

<div class="flex-grow pt-32 pb-24 px-4 md:px-8 max-w-7xl mx-auto relative min-h-screen">
    <!-- Atmospheric Background Elements -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-1/4 -right-1/4 w-[800px] h-[800px] bg-primary-200/10 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-1/4 -left-1/4 w-[600px] h-[600px] bg-indigo-200/10 rounded-full blur-[100px]"></div>
    </div>

    <!-- Header -->
    <div class="flex items-center justify-between mb-12 relative z-10">
        <a class="flex items-center gap-2 text-primary-600 font-bold text-sm hover:text-primary-700 transition-colors" href="{{ route('bookings.show', $booking->id) }}">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Back to Trip
        </a>
        <h1 class="text-3xl font-black text-slate-900">Complete Your Booking</h1>
        <div></div>
    </div>

    <!-- Step Indicator (2 steps) -->
    <div class="step-indicator animate-slide-up relative z-10 mb-12">
        <div class="step">
            <div class="step-circle active" id="step-circle-1">1</div>
            <div class="step-label">Trip Details</div>
        </div>
        <div class="flex items-center">
            <div class="w-20 h-0.5 bg-slate-200"></div>
        </div>
        <div class="step">
            <div class="step-circle inactive" id="step-circle-2">2</div>
            <div class="step-label inactive">Choose Hotel</div>
        </div>
    </div>

    <div class="max-w-2xl mx-auto relative z-10">
        <form id="payment-form" method="POST" action="{{ route('payment.store', $booking->id) }}">
            @csrf

            <!-- STEP 1: Trip Details -->
            <div class="step-section" id="step-1">
                <div class="glass-card p-10 rounded-xl border border-white/50 shadow-xl animate-slide-up">
                    <h2 class="text-2xl font-black text-slate-900 mb-8 tracking-tight">Trip Information</h2>

                    <div class="space-y-6 mb-10">
                        <!-- Start Date -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wider">Departure Date</label>
                            <input type="date" name="start_date" required class="card-input w-full"
                                value="{{ old('start_date') }}" min="{{ date('Y-m-d') }}">
                            @error('start_date')
                                <div class="text-red-600 text-sm font-bold mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Departure Country -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wider">Departure Country</label>
                            <input type="text" name="departure_country" required class="card-input w-full"
                                placeholder="e.g., France" value="{{ old('departure_country') }}">
                            @error('departure_country')
                                <div class="text-red-600 text-sm font-bold mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Departure City -->
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wider">Departure City</label>
                            <input type="text" name="departure_city" required class="card-input w-full"
                                placeholder="e.g., Paris" value="{{ old('departure_city') }}">
                            @error('departure_city')
                                <div class="text-red-600 text-sm font-bold mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="button" onclick="nextStep()"
                        class="w-full py-4 bg-slate-950 text-white font-black text-lg rounded-lg shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2 group relative overflow-hidden">
                        <div class="absolute inset-0 bg-primary-600 opacity-0 group-hover:opacity-10 transition-opacity"></div>
                        <span class="relative z-10">Next: Choose Hotel</span>
                        <span class="material-symbols-outlined relative z-10">arrow_forward</span>
                    </button>
                </div>
            </div>

            <!-- STEP 2: Hotel Selection -->
            <div class="step-section hidden" id="step-2">
                <div class="glass-card p-10 rounded-xl border border-white/50 shadow-xl animate-slide-up">
                    <h2 class="text-2xl font-black text-slate-900 mb-8 tracking-tight">Select Your Hotel</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                        @forelse($hotels as $hotel)
                            <label class="hotel-card cursor-pointer" onclick="selectHotel({{ $hotel->id }})">
                                <input type="radio" name="hotel_id" value="{{ $hotel->id }}" required class="hidden" id="hotel-{{ $hotel->id }}"
                                    onchange="updateHotelCard()">
                                <img src="{{ $hotel->image ?? 'https://images.unsplash.com/photo-1566073171639-3f8b3f5e4c4b?q=80&w=600' }}"
                                    alt="{{ $hotel->name }}" class="hotel-image">
                                <span class="hotel-type-badge">{{ $hotel->getTypeLabel() }}</span>
                                <h3 class="text-lg font-black text-slate-900 mb-2">{{ $hotel->name }}</h3>
                                <p class="text-slate-600 text-sm mb-4">{{ $hotel->type ?? 'Luxury Stay' }}</p>
                                <p class="text-2xl font-black text-primary-600">€{{ number_format($hotel->price_per_night) }}<span class="text-xs text-slate-400 font-normal">/night</span></p>
                            </label>
                        @empty
                            <div class="col-span-full text-center">
                                <p class="text-slate-400">No hotels available for this destination</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="glass-card p-8 rounded-xl border border-white/50 bg-slate-50/80 mb-10">
                        <h3 class="text-lg font-black text-slate-900 mb-4">Simulated Payment</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wider">Card Number</label>
                                <input type="text" placeholder="•••• •••• •••• ••••" class="card-input w-full" disabled value="•••• •••• •••• 4242">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wider">Expiry</label>
                                    <input type="text" placeholder="MM/YY" class="card-input w-full" disabled value="12/26">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wider">CVV</label>
                                    <input type="text" placeholder="•••" class="card-input w-full" disabled value="•••">
                                </div>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 mt-4 italic">💳 This is a simulated payment form for demonstration purposes.</p>
                    </div>

                    <input type="hidden" name="is_hotel_paid" value="1">

                    <div class="flex gap-4">
                        <button type="button" onclick="prevStep()"
                            class="flex-1 py-4 bg-white text-slate-900 font-black text-lg rounded-lg shadow-lg hover:shadow-xl transition-all border border-slate-200 flex items-center justify-center gap-2 group">
                            <span class="material-symbols-outlined">arrow_back</span>
                            Back
                        </button>
                        <button type="submit"
                            class="flex-1 py-4 bg-slate-950 text-white font-black text-lg rounded-lg shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2 group relative overflow-hidden">
                            <div class="absolute inset-0 bg-primary-600 opacity-0 group-hover:opacity-10 transition-opacity"></div>
                            <span class="relative z-10">Complete Booking</span>
                            <span class="material-symbols-outlined relative z-10">check_circle</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function nextStep() {
        // Validate step 1 first
        if (!validateStep1()) return;

        document.getElementById('step-1').classList.add('hidden');
        document.getElementById('step-2').classList.remove('hidden');

        document.getElementById('step-circle-1').classList.remove('active');
        document.getElementById('step-circle-1').classList.add('inactive');
        document.getElementById('step-circle-2').classList.remove('inactive');
        document.getElementById('step-circle-2').classList.add('active');

        document.querySelector('[for="step-circle-1"]')?.next?.classList.add('inactive');
    }

    function prevStep() {
        document.getElementById('step-2').classList.add('hidden');
        document.getElementById('step-1').classList.remove('hidden');

        document.getElementById('step-circle-1').classList.add('active');
        document.getElementById('step-circle-1').classList.remove('inactive');
        document.getElementById('step-circle-2').classList.add('inactive');
        document.getElementById('step-circle-2').classList.remove('active');
    }

    function validateStep1() {
        const form = document.getElementById('payment-form');
        const formData = new FormData(form);

        const startDate = formData.get('start_date');
        const departureCountry = formData.get('departure_country');
        const departureCity = formData.get('departure_city');

        if (!startDate) {
            alert('Please select a departure date');
            return false;
        }
        if (!departureCountry) {
            alert('Please enter departure country');
            return false;
        }
        if (!departureCity) {
            alert('Please enter departure city');
            return false;
        }

        return true;
    }

    function selectHotel(hotelId) {
        document.querySelectorAll('.hotel-card').forEach(card => {
            card.classList.remove('selected');
        });
        document.getElementById(`hotel-${hotelId}`).checked = true;
        document.getElementById(`hotel-${hotelId}`).closest('.hotel-card').classList.add('selected');
    }

    function updateHotelCard() {
        // Update visual state on radio change
        const checked = document.querySelector('input[name="hotel_id"]:checked');
        if (checked) {
            selectHotel(checked.value);
        }
    }

    // Auto-select first hotel on load
    document.addEventListener('DOMContentLoaded', () => {
        const firstHotel = document.querySelector('input[name="hotel_id"]');
        if (firstHotel) {
            firstHotel.checked = true;
            selectHotel(firstHotel.value);
        }
    });
</script>
@endsection
