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
    .flight-card {
        border: 2px solid #e2e8f0;
        border-radius: 1rem;
        padding: 1.25rem 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.5rem;
    }
    .flight-card:hover {
        border-color: #0284c7;
        box-shadow: 0 4px 16px rgba(2, 132, 199, 0.15);
    }
    .flight-card.selected {
        border-color: #0284c7;
        background: linear-gradient(135deg, rgba(2, 132, 199, 0.05), rgba(99, 102, 241, 0.05));
        box-shadow: 0 4px 16px rgba(2, 132, 199, 0.2);
    }
    .flight-airline {
        flex-shrink: 0;
    }
    .flight-airline-badge {
        display: inline-block;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #0284c7;
        background: rgba(2, 132, 199, 0.1);
        padding: 0.35rem 0.75rem;
        border-radius: 0.5rem;
        margin-bottom: 0.25rem;
    }
    .flight-airline-name {
        font-size: 1.125rem;
        font-weight: 900;
        color: #1e293b;
    }
    .flight-times {
        flex-grow: 1;
        min-width: 200px;
    }
    .flight-times-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 0.5rem;
    }
    .flight-time {
        text-align: center;
    }
    .flight-time-value {
        font-size: 1.25rem;
        font-weight: 900;
        color: #1e293b;
    }
    .flight-time-label {
        font-size: 0.75rem;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .flight-duration {
        text-align: center;
        padding: 0 1rem;
    }
    .flight-duration-value {
        font-size: 0.875rem;
        font-weight: 700;
        color: #475569;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.35rem;
    }
    .flight-price-section {
        text-align: right;
        flex-shrink: 0;
        min-width: 140px;
    }
    .flight-price {
        font-size: 1.875rem;
        font-weight: 900;
        background: linear-gradient(135deg, #0284c7, #6366f1);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 0.25rem;
    }
    .flight-per-person {
        font-size: 0.75rem;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .select-badge {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #0284c7;
        background: rgba(2, 132, 199, 0.1);
        padding: 0.4rem 0.8rem;
        border-radius: 0.5rem;
        white-space: nowrap;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .flight-card .select-badge {
        opacity: 0;
    }
    .flight-card:hover .select-badge {
        opacity: 1;
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
    .error-message {
        color: #dc2626;
        font-size: 0.875rem;
        font-weight: 600;
        margin-top: 0.5rem;
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
        <h1 class="text-3xl font-black text-slate-900">Payment</h1>
        <div></div>
    </div>

    <!-- Step Indicator -->
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
            <div class="step-label inactive">Flight</div>
        </div>
        <div class="flex items-center">
            <div class="w-20 h-0.5 bg-slate-200"></div>
        </div>
        <div class="step">
            <div class="step-circle inactive" id="step-circle-3">3</div>
            <div class="step-label inactive">Hotel</div>
        </div>
    </div>

    <!-- STEP 1: Trip Details -->
    <div id="step-1" class="step-section animate-slide-up relative z-10">
        <div class="glass-card max-w-2xl mx-auto rounded-2xl p-10 shadow-2xl border border-white/50">
            <h2 class="text-3xl font-black text-slate-900 mb-10">Trip Details</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Left: Booking Summary -->
                <div class="space-y-6">
                    <div class="bg-gradient-primary bg-opacity-10 p-6 rounded-xl">
                        <h3 class="text-sm font-bold text-slate-500 uppercase tracking-widest mb-2">Destination</h3>
                        <p class="text-2xl font-black text-slate-900">{{ $booking->city->name }}</p>
                        <p class="text-slate-600 font-bold">{{ $booking->city->country->name }}</p>
                    </div>
                    <div class="bg-gradient-primary bg-opacity-10 p-6 rounded-xl">
                        <h3 class="text-sm font-bold text-slate-500 uppercase tracking-widest mb-2">Accommodation</h3>
                        <p class="text-2xl font-black text-slate-900">{{ $booking->hotel->name }}</p>
                        <p class="text-slate-600 font-bold">{{ $booking->duration }} Nights · {{ $booking->passengers }} Travelers</p>
                    </div>
                    <div class="bg-gradient-primary bg-opacity-10 p-6 rounded-xl">
                        <h3 class="text-sm font-bold text-slate-500 uppercase tracking-widest mb-2">Total Price</h3>
                        <p class="text-3xl font-black text-slate-900">€{{ number_format($booking->total_price, 2) }}</p>
                    </div>
                </div>

                <!-- Right: Form Fields -->
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Trip Start Date *</label>
                        <input type="date" id="start_date" class="card-input w-full" min="{{ date('Y-m-d') }}" required>
                        <div id="start_date_error" class="error-message hidden"></div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Your Country *</label>
                        <input type="text" id="departure_country" class="card-input w-full" placeholder="e.g. France" required>
                        <div id="country_error" class="error-message hidden"></div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Your City *</label>
                        <input type="text" id="departure_city" class="card-input w-full" placeholder="e.g. Paris" required>
                        <div id="city_error" class="error-message hidden"></div>
                    </div>

                    <button onclick="goToStep(2)" class="w-full mt-6 py-4 bg-gradient-primary text-white font-black text-lg rounded-lg shadow-lg hover:shadow-xl transition-all">
                        Next: Choose Flight <span class="material-symbols-outlined text-xl align-middle">arrow_forward</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- STEP 2: Flight Selection -->
    <div id="step-2" class="step-section hidden relative z-10">
        <div class="max-w-4xl mx-auto">
            <div class="glass-card rounded-2xl p-10 shadow-2xl border border-white/50 mb-8">
                <h2 class="text-3xl font-black text-slate-900 mb-2">Choose Your Flight</h2>
                <p class="text-slate-600 text-lg font-bold">{{ $booking->city->country->name }} ← → {{ $booking->city->name }}</p>
            </div>

            <!-- Flight Options List -->
            <div class="space-y-4 mb-8">
                @foreach($flights as $index => $flight)
                <div class="flight-card" onclick="selectFlight({{ $index }}, {{ $flight['price'] }})">
                    <!-- Airline Info -->
                    <div class="flight-airline">
                        <div class="flight-airline-badge">
                            <span class="material-symbols-outlined" style="font-size: 0.65rem; vertical-align: middle;">flight</span>
                            {{ $flight['airline'] }}
                        </div>
                        <div class="flight-airline-name">{{ $flight['airline'] }}</div>
                    </div>

                    <!-- Times & Duration -->
                    <div class="flight-times">
                        <div class="flight-times-row">
                            <div class="flight-time">
                                <div class="flight-time-value">{{ $flight['departure'] }}</div>
                                <div class="flight-time-label">Depart</div>
                            </div>
                            <div class="flight-duration">
                                <div class="flight-duration-value">
                                    <span class="material-symbols-outlined" style="font-size: 1rem;">near_me</span>
                                    {{ $flight['duration'] }}
                                </div>
                            </div>
                            <div class="flight-time">
                                <div class="flight-time-value">{{ $flight['arrival'] }}</div>
                                <div class="flight-time-label">Arrive</div>
                            </div>
                        </div>
                    </div>

                    <!-- Price & Select Badge -->
                    <div class="flight-price-section">
                        <div class="flight-price">€{{ number_format($flight['price'], 0) }}</div>
                        <div class="flight-per-person">per person</div>
                        <div class="select-badge" style="margin-top: 0.5rem;">
                            <span class="material-symbols-outlined" style="font-size: 0.7rem; vertical-align: middle;">add_circle</span>
                            Select
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Flight Payment Form (hidden initially) -->
            <div id="flight-payment-form" class="glass-card rounded-2xl p-10 shadow-2xl border border-white/50 hidden">
                <h3 class="text-2xl font-black text-slate-900 mb-8">Flight Payment Details</h3>

                <div class="space-y-6 mb-8">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Card Number</label>
                        <input type="text" id="flight_card_number" class="card-input w-full" placeholder="1234 5678 9012 3456" maxlength="19" oninput="formatCardNumber(this)">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Expiry Date</label>
                            <input type="text" id="flight_expiry" class="card-input w-full" placeholder="MM/YY" maxlength="5" oninput="formatExpiry(this)">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">CVV</label>
                            <input type="password" id="flight_cvv" class="card-input w-full" placeholder="123" maxlength="3">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <button onclick="skipFlightPayment()" class="py-4 border-2 border-slate-300 text-slate-700 font-black text-lg rounded-lg hover:bg-slate-50 transition-all">
                        Skip
                    </button>
                    <button onclick="confirmFlightPayment()" class="py-4 bg-gradient-primary text-white font-black text-lg rounded-lg shadow-lg hover:shadow-xl transition-all">
                        Confirm & Continue
                    </button>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex gap-4 mt-8">
                <button onclick="goToStep(1)" class="flex-1 py-4 border-2 border-slate-300 text-slate-700 font-black text-lg rounded-lg hover:bg-slate-50 transition-all">
                    Back
                </button>
            </div>
        </div>
    </div>

    <!-- STEP 3: Hotel Payment -->
    <div id="step-3" class="step-section hidden relative z-10">
        <div class="max-w-4xl mx-auto">
            <!-- Hotel Info Card -->
            <div class="glass-card rounded-2xl overflow-hidden shadow-2xl border border-white/50 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-10">
                    <div class="rounded-xl overflow-hidden shadow-lg">
                        <img src="{{ $booking->hotel->image ?? 'https://images.unsplash.com/photo-1566073171639-3f8b3f5e4c4b' }}"
                             alt="{{ $booking->hotel->name }}" class="w-full h-80 object-cover">
                    </div>
                    <div class="flex flex-col justify-center">
                        <h2 class="text-3xl font-black text-slate-900 mb-4">{{ $booking->hotel->name }}</h2>
                        <div class="space-y-3 mb-8">
                            <div>
                                <p class="text-sm text-slate-500 font-bold uppercase">City</p>
                                <p class="text-lg font-bold text-slate-800">{{ $booking->city->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-slate-500 font-bold uppercase">Duration & Guests</p>
                                <p class="text-lg font-bold text-slate-800">{{ $booking->duration }} Nights × {{ $booking->passengers }} Travelers</p>
                            </div>
                            <div>
                                <p class="text-sm text-slate-500 font-bold uppercase">Price per Night</p>
                                <p class="text-xl font-black text-primary-600">€{{ number_format($booking->hotel_budget / $booking->duration, 2) }}</p>
                            </div>
                            <div class="pt-4 border-t border-slate-200">
                                <p class="text-sm text-slate-500 font-bold uppercase">Total Cost</p>
                                <p class="text-3xl font-black text-slate-900">€{{ number_format($booking->hotel_budget, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hotel Payment Form -->
            <div class="glass-card rounded-2xl p-10 shadow-2xl border border-white/50 mb-8">
                <h3 class="text-2xl font-black text-slate-900 mb-8">Hotel Payment Details</h3>

                <div class="space-y-6 mb-8">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Card Number</label>
                        <input type="text" id="hotel_card_number" class="card-input w-full" placeholder="1234 5678 9012 3456" maxlength="19" oninput="formatCardNumber(this)">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Expiry Date</label>
                            <input type="text" id="hotel_expiry" class="card-input w-full" placeholder="MM/YY" maxlength="5" oninput="formatExpiry(this)">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">CVV</label>
                            <input type="password" id="hotel_cvv" class="card-input w-full" placeholder="123" maxlength="3">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <button onclick="skipHotelPayment()" class="py-4 border-2 border-slate-300 text-slate-700 font-black text-lg rounded-lg hover:bg-slate-50 transition-all">
                        Skip
                    </button>
                    <button onclick="confirmHotelPayment()" class="py-4 bg-gradient-primary text-white font-black text-lg rounded-lg shadow-lg hover:shadow-xl transition-all">
                        Complete Booking
                    </button>
                </div>
            </div>

            <!-- Navigation -->
            <div class="flex gap-4">
                <button onclick="goToStep(2)" class="flex-1 py-4 border-2 border-slate-300 text-slate-700 font-black text-lg rounded-lg hover:bg-slate-50 transition-all">
                    Back
                </button>
            </div>
        </div>
    </div>

    <!-- Hidden Payment Form -->
    <form id="payment-form" method="POST" action="{{ route('payment.store', $booking->id) }}" style="display: none;">
        @csrf
        <input type="hidden" name="start_date" id="hidden_start_date">
        <input type="hidden" name="departure_country" id="hidden_departure_country">
        <input type="hidden" name="departure_city" id="hidden_departure_city">
        <input type="hidden" name="is_flight_paid" id="hidden_is_flight_paid" value="0">
        <input type="hidden" name="is_hotel_paid" id="hidden_is_hotel_paid" value="0">
        <input type="hidden" name="airline" id="hidden_airline">
        <input type="hidden" name="flight_departure" id="hidden_flight_departure">
        <input type="hidden" name="flight_arrival" id="hidden_flight_arrival">
        <input type="hidden" name="flight_duration" id="hidden_flight_duration">
    </form>
</div>

<script>
let flightPaid = false;
let hotelPaid = false;
let selectedFlight = null;
let flightDetails = {};

const flightData = [
    @foreach($flights as $flight)
    { airline: '{{ $flight['airline'] }}', duration: '{{ $flight['duration'] }}', departure: '{{ $flight['departure'] }}', arrival: '{{ $flight['arrival'] }}', price: {{ $flight['price'] }} },
    @endforeach
];

function goToStep(step) {
    // Validate step 1 before proceeding
    if (step === 2 && document.getElementById('step-1').classList.contains('hidden') === false) {
        const startDate = document.getElementById('start_date').value;
        const country = document.getElementById('departure_country').value;
        const city = document.getElementById('departure_city').value;

        let hasError = false;

        if (!startDate) {
            document.getElementById('start_date_error').textContent = 'Please select a start date';
            document.getElementById('start_date_error').classList.remove('hidden');
            hasError = true;
        } else {
            document.getElementById('start_date_error').classList.add('hidden');
        }

        if (!country) {
            document.getElementById('country_error').textContent = 'Please enter your country';
            document.getElementById('country_error').classList.remove('hidden');
            hasError = true;
        } else {
            document.getElementById('country_error').classList.add('hidden');
        }

        if (!city) {
            document.getElementById('city_error').textContent = 'Please enter your city';
            document.getElementById('city_error').classList.remove('hidden');
            hasError = true;
        } else {
            document.getElementById('city_error').classList.add('hidden');
        }

        if (hasError) return;
    }

    // Hide all steps, show target step
    document.querySelectorAll('.step-section').forEach(s => s.classList.add('hidden'));
    document.getElementById('step-' + step).classList.remove('hidden');

    // Update step indicator
    updateStepIndicator(step);

    // Scroll to top
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function updateStepIndicator(currentStep) {
    for (let i = 1; i <= 3; i++) {
        const circle = document.getElementById('step-circle-' + i);
        const label = circle.nextElementSibling;

        if (i <= currentStep) {
            circle.classList.remove('inactive');
            circle.classList.add('active');
            label.classList.remove('inactive');
        } else {
            circle.classList.remove('active');
            circle.classList.add('inactive');
            label.classList.add('inactive');
        }
    }
}

function selectFlight(index, price) {
    selectedFlight = { index, price };
    flightDetails = flightData[index];

    // Highlight selected card
    document.querySelectorAll('.flight-card').forEach((card, i) => {
        if (i === index) {
            card.classList.add('selected');
        } else {
            card.classList.remove('selected');
        }
    });

    // Show flight payment form
    document.getElementById('flight-payment-form').classList.remove('hidden');
    document.getElementById('flight-payment-form').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function formatCardNumber(input) {
    let value = input.value.replace(/\s/g, '');
    let formattedValue = '';
    for (let i = 0; i < value.length; i++) {
        if (i > 0 && i % 4 === 0) formattedValue += ' ';
        formattedValue += value[i];
    }
    input.value = formattedValue;
}

function formatExpiry(input) {
    let value = input.value.replace(/\D/g, '');
    if (value.length >= 2) {
        value = value.slice(0, 2) + '/' + value.slice(2, 4);
    }
    input.value = value;
}

function skipFlightPayment() {
    flightPaid = false;
    goToStep(3);
}

function confirmFlightPayment() {
    const cardNumber = document.getElementById('flight_card_number').value;
    const expiry = document.getElementById('flight_expiry').value;
    const cvv = document.getElementById('flight_cvv').value;

    if (!cardNumber || !expiry || !cvv) {
        alert('Please fill in all card details');
        return;
    }

    flightPaid = true;
    goToStep(3);
}

function skipHotelPayment() {
    hotelPaid = false;
    submitPayment();
}

function confirmHotelPayment() {
    const cardNumber = document.getElementById('hotel_card_number').value;
    const expiry = document.getElementById('hotel_expiry').value;
    const cvv = document.getElementById('hotel_cvv').value;

    if (!cardNumber || !expiry || !cvv) {
        alert('Please fill in all card details');
        return;
    }

    hotelPaid = true;
    submitPayment();
}

function submitPayment() {
    document.getElementById('hidden_start_date').value = document.getElementById('start_date').value;
    document.getElementById('hidden_departure_country').value = document.getElementById('departure_country').value;
    document.getElementById('hidden_departure_city').value = document.getElementById('departure_city').value;
    document.getElementById('hidden_is_flight_paid').value = flightPaid ? '1' : '0';
    document.getElementById('hidden_is_hotel_paid').value = hotelPaid ? '1' : '0';
    document.getElementById('hidden_airline').value = flightDetails.airline || '';
    document.getElementById('hidden_flight_departure').value = flightDetails.departure || '';
    document.getElementById('hidden_flight_arrival').value = flightDetails.arrival || '';
    document.getElementById('hidden_flight_duration').value = flightDetails.duration || '';
    document.getElementById('payment-form').submit();
}
</script>
@endsection
