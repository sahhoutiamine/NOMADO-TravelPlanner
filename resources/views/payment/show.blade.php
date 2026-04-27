@extends('layouts.app')

@section('content')
<style>
    .checkout-container {
        max-width: 1000px;
        margin: 0 auto;
    }
    .glass-card {
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    }
    .payment-input {
        width: 100%;
        padding: 0.75rem 1rem;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        font-size: 1rem;
        transition: all 0.2s ease;
        color: #1e293b;
    }
    .payment-input:focus {
        outline: none;
        border-color: #6366f1;
        background: white;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }
    .input-label {
        display: block;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        margin-bottom: 0.5rem;
    }
    .virtual-card {
        background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        border-radius: 1rem;
        padding: 1.5rem;
        color: white;
        position: relative;
        overflow: hidden;
        aspect-ratio: 1.586/1;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
    }
    .virtual-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .summary-row:last-child {
        border-bottom: none;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
</style>

<div class="flex-grow pt-32 pb-24 px-4 relative min-h-screen bg-slate-50/50">
    <!-- Atmospheric Background -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute top-0 right-0 w-1/2 h-1/2 bg-indigo-50/50 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/4"></div>
    </div>

    <div class="checkout-container relative z-10">
        <!-- Back Link -->
        <a href="{{ route('bookings.show', $booking->id) }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-slate-900 font-bold text-sm transition-colors mb-8 group">
            <span class="material-symbols-outlined text-sm group-hover:-translate-x-1 transition-transform">arrow_back</span>
            Return to trip details
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            <!-- Left Side: Form -->
            <div class="lg:col-span-7 space-y-8">
                <div class="animate-fade-in" style="animation-delay: 0.1s">
                    <h1 class="text-4xl font-black text-slate-900 tracking-tight mb-2">Checkout</h1>
                    <p class="text-slate-500 font-medium">Complete your booking for {{ $booking->city->name }}</p>
                </div>

                <form id="payment-form" method="POST" action="{{ route('payment.store', $booking->id) }}" class="space-y-8">
                    @csrf
                    
                    <!-- Date Selection -->
                    <div class="glass-card p-8 rounded-2xl animate-fade-in" style="animation-delay: 0.2s">
                        <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center">
                                <span class="material-symbols-outlined text-indigo-600 text-sm">calendar_today</span>
                            </div>
                            Journey Schedule
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="input-label">Departure Date</label>
                                <input type="date" name="start_date" required class="payment-input"
                                    value="{{ old('start_date') }}" min="{{ date('Y-m-d') }}">
                                @error('start_date')
                                    <div class="text-red-500 text-xs font-bold mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="flex flex-col justify-end pb-1">
                                <div class="text-xs text-slate-400 italic">
                                    Your trip will last for <strong>{{ $booking->duration }} nights</strong>.
                                </div>
                            </div>
                        </div>
                    </div>

                    @php
                        $hasFlight = !empty($booking->flight_airline);
                        $hasHotel = $booking->include_hotel && !empty($booking->hotel_id);
                        $needsPayment = $hasFlight || $hasHotel;
                    @endphp

                    @if($needsPayment)
                    <!-- Payment Details -->
                    <div class="glass-card p-8 rounded-2xl animate-fade-in" style="animation-delay: 0.3s">
                        <h2 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center">
                                <span class="material-symbols-outlined text-indigo-600 text-sm">credit_card</span>
                            </div>
                            Payment Method
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                            <!-- Visual Card -->
                            <div class="virtual-card">
                                <div class="flex justify-between items-start mb-12">
                                    <div class="w-12 h-8 bg-slate-700/50 rounded-md"></div>
                                    <span class="material-symbols-outlined text-3xl opacity-50">contactless</span>
                                </div>
                                <div class="space-y-4">
                                    <div id="display-card-number" class="text-base font-mono tracking-wider">•••• •••• •••• ••••</div>
                                    <div class="flex justify-between items-end">
                                        <div>
                                            <div class="text-[8px] uppercase tracking-widest opacity-50 mb-1">Card Holder</div>
                                            <div class="text-xs font-bold uppercase tracking-wider">{{ auth()->user()->name }}</div>
                                        </div>
                                        <div>
                                            <div class="text-[8px] uppercase tracking-widest opacity-50 mb-1">Expires</div>
                                            <div id="display-card-expiry" class="text-xs font-bold uppercase">MM/YY</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Inputs -->
                            <div class="space-y-4">
                                <div>
                                    <label class="input-label">Card Number</label>
                                    <input type="text" id="card-number-input" placeholder="0000 0000 0000 0000" class="payment-input font-mono" required maxlength="19">
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="input-label">Expiry</label>
                                        <input type="text" id="card-expiry-input" placeholder="MM/YY" class="payment-input" required maxlength="5">
                                    </div>
                                    <div>
                                        <label class="input-label">CVV</label>
                                        <input type="text" placeholder="•••" class="payment-input" required maxlength="3">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 p-4 bg-slate-50 rounded-xl flex gap-3 items-start border border-slate-100">
                            <span class="material-symbols-outlined text-slate-400 text-sm mt-0.5">verified_user</span>
                            <p class="text-xs text-slate-500 leading-relaxed font-medium">
                                Secured by 256-bit SSL encryption. Your digital tickets will be issued instantly upon successful payment.
                            </p>
                        </div>
                    </div>
                    @else
                    <div class="glass-card p-10 rounded-2xl text-center animate-fade-in" style="animation-delay: 0.3s">
                        <div class="w-16 h-16 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <span class="material-symbols-outlined text-emerald-500 text-3xl">check_circle</span>
                        </div>
                        <h3 class="text-xl font-black text-slate-900 mb-2">Confirm Your Itinerary</h3>
                        <p class="text-slate-500 text-sm max-w-sm mx-auto">You've selected a custom itinerary without pre-paid flights or hotels. Confirm now to save your trip!</p>
                    </div>
                    @endif

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full py-5 bg-indigo-600 text-white font-black text-lg rounded-2xl shadow-xl shadow-indigo-200 hover:bg-indigo-700 hover:shadow-2xl transition-all active:scale-[0.98] flex items-center justify-center gap-3">
                        <span>{{ $needsPayment ? 'Complete Payment' : 'Confirm Trip' }}</span>
                        <span class="material-symbols-outlined">{{ $needsPayment ? 'lock' : 'check_circle' }}</span>
                    </button>
                </form>
            </div>

            <!-- Right Side: Summary -->
            <div class="lg:col-span-5">
                <div class="sticky top-32 space-y-6 animate-fade-in" style="animation-delay: 0.4s">
                    <div class="glass-card p-8 rounded-2xl overflow-hidden relative">
                        <div class="absolute top-0 right-0 p-4 opacity-[0.03] pointer-events-none">
                            <span class="material-symbols-outlined text-90px">receipt_long</span>
                        </div>

                        <h2 class="text-lg font-bold text-slate-900 mb-8">Summary</h2>
                        
                        <!-- Mini Destination Card -->
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-16 h-16 rounded-xl overflow-hidden bg-slate-100 shadow-sm border border-white">
                                <img src="{{ $booking->city->image }}" alt="{{ $booking->city->name }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900">{{ $booking->city->name }}</h3>
                                <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">{{ $booking->city->country->name }}</p>
                            </div>
                        </div>

                        <!-- Items -->
                        <div class="space-y-1 mb-8">
                            @if($hasFlight)
                            <div class="summary-row">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-slate-400 text-sm">flight_takeoff</span>
                                    <span class="text-sm font-medium text-slate-600">Flight with {{ $booking->flight_airline }}</span>
                                </div>
                                <div class="text-sm font-bold text-slate-900">€{{ number_format($booking->flight_budget) }}</div>
                            </div>
                            @endif

                            @if($hasHotel)
                            <div class="summary-row">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-slate-400 text-sm">bed</span>
                                    <span class="text-sm font-medium text-slate-600">{{ $booking->hotel->name }}</span>
                                </div>
                                <div class="text-sm font-bold text-slate-900">€{{ number_format($booking->hotel_budget) }}</div>
                            </div>
                            @endif

                            <div class="summary-row">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-slate-400 text-sm">group</span>
                                    <span class="text-sm font-medium text-slate-600">Travelers</span>
                                </div>
                                <div class="text-sm font-bold text-slate-900">x{{ $booking->passengers }}</div>
                            </div>
                        </div>

                        <!-- Total -->
                        <div class="pt-6 border-t border-slate-200">
                            <div class="flex justify-between items-baseline">
                                <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Amount</div>
                                <div class="text-4xl font-black text-indigo-600 tracking-tighter">
                                    €{{ number_format($needsPayment ? ($booking->flight_budget + $booking->hotel_budget) : 0) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-4 text-center">
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest leading-loose">
                            By confirming, you agree to our Terms of Service<br>and Cancellation Policy.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const cardInput = document.getElementById('card-number-input');
        const expiryInput = document.getElementById('card-expiry-input');
        const displayCardNumber = document.getElementById('display-card-number');
        const displayCardExpiry = document.getElementById('display-card-expiry');

        if (cardInput) {
            cardInput.addEventListener('input', (e) => {
                let v = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
                let parts = [];

                for (let i=0, len=v.length; i<len; i+=4) {
                    parts.push(v.substring(i, i+4));
                }

                const formattedValue = parts.join(' ');
                e.target.value = formattedValue;
                
                // Update display
                displayCardNumber.textContent = formattedValue || '•••• •••• •••• ••••';
            });
        }

        if (expiryInput) {
            expiryInput.addEventListener('input', (e) => {
                let v = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
                if (v.length >= 2) {
                    v = v.substring(0, 2) + '/' + v.substring(2, 4);
                }
                e.target.value = v;
                displayCardExpiry.textContent = v || 'MM/YY';
            });
        }
    });
</script>
@endsection

