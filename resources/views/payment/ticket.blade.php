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
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .animate-slide-up {
        animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    .ticket {
        background: white;
        border-radius: 0.5rem;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        border: none;
        overflow: hidden;
        max-width: 900px;
    }
    /* Ticket Layout: Two columns */
    .ticket-container {
        display: flex;
        min-height: 500px;
    }
    .ticket-left {
        flex: 1;
        background: linear-gradient(135deg, #0284c7 0%, #0284c7 100%);
        color: white;
        padding: 3rem 2.5rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
    }
    .ticket-left::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
    }
    .ticket-left-content {
        position: relative;
        z-index: 2;
    }
    .ticket-logo {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 2rem;
        font-size: 1.5rem;
    }
    .ticket-logo span {
        font-size: 2rem;
    }
    .ticket-logo-text {
        font-size: 1.25rem;
        font-weight: 900;
        letter-spacing: 0.1em;
    }
    .route-container {
        margin-bottom: 2rem;
    }
    .route-city {
        font-size: 3rem;
        font-weight: 900;
        line-height: 1;
        margin-bottom: 0.5rem;
    }
    .route-country {
        font-size: 0.875rem;
        font-weight: 700;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }
    .route-arrow {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        margin: 1.5rem 0;
        font-size: 2rem;
        opacity: 0.8;
    }
    .passenger-name {
        font-size: 0.875rem;
        font-weight: 600;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.5rem;
    }
    .passenger-name-value {
        font-size: 1.5rem;
        font-weight: 900;
    }
    /* Right section */
    .ticket-right {
        flex: 1;
        background: white;
        padding: 2.5rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        border-left: 2px dashed rgba(2, 132, 199, 0.3);
    }
    .ticket-info-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .ticket-info-item {
        display: flex;
        flex-direction: column;
    }
    .ticket-info-label {
        font-size: 0.7rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        color: #94a3b8;
        margin-bottom: 0.35rem;
    }
    .ticket-info-value {
        font-size: 1.125rem;
        font-weight: 900;
        color: #1e293b;
        line-height: 1.2;
    }
    .ticket-flight-info {
        background: #f8fafc;
        padding: 1.5rem;
        border-radius: 0.75rem;
        margin-bottom: 1.5rem;
    }
    .flight-time-display {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        gap: 1rem;
        margin-bottom: 0.75rem;
    }
    .time-item {
        text-align: center;
    }
    .time-label {
        font-size: 0.65rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.25rem;
    }
    .time-value {
        font-size: 1.5rem;
        font-weight: 900;
        color: #1e293b;
    }
    .flight-divider {
        text-align: center;
        color: #cbd5e1;
        font-size: 1rem;
    }
    .flight-duration {
        font-size: 0.75rem;
        font-weight: 700;
        color: #64748b;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .hotel-info {
        background: #f0f9ff;
        padding: 1rem;
        border-radius: 0.5rem;
        border-left: 3px solid #0284c7;
        margin-top: 1rem;
    }
    .hotel-info-label {
        font-size: 0.65rem;
        font-weight: 900;
        color: #0284c7;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 0.25rem;
    }
    .hotel-info-value {
        font-size: 0.95rem;
        font-weight: 900;
        color: #1e293b;
    }
    .payment-badges {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
        margin-top: auto;
    }
    .badge-item {
        background: #f8fafc;
        padding: 0.75rem;
        border-radius: 0.5rem;
        text-align: center;
        border: 1px solid #e2e8f0;
    }
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.35rem 0.6rem;
        border-radius: 0.35rem;
        font-weight: 700;
        font-size: 0.7rem;
    }
    .badge-paid {
        background: #d1fae5;
        color: #047857;
    }
    .badge-pending {
        background: #fed7aa;
        color: #d97706;
    }
    .qr-barcode-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 2px dashed #e2e8f0;
    }
    .qr-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
    }
    .qr-label {
        font-size: 0.65rem;
        font-weight: 900;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }
    .qr-code-box {
        background: white;
        padding: 0.75rem;
        border: 2px solid #0284c7;
        border-radius: 0.5rem;
    }
    .qr-code-box img {
        display: block;
        width: 120px;
        height: 120px;
        object-fit: contain;
    }
    .barcode-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
    }
    .barcode-label {
        font-size: 0.65rem;
        font-weight: 900;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }
    .barcode {
        display: flex;
        gap: 1px;
        justify-content: center;
        align-items: flex-end;
        height: 60px;
    }
    .barcode-line {
        width: 1.5px;
        background: #1e293b;
        opacity: 0.9;
    }
    .barcode-text {
        font-size: 0.65rem;
        font-weight: 900;
        color: #1e293b;
        margin-top: 0.25rem;
        letter-spacing: 0.05em;
        font-family: 'Courier New', monospace;
    }
    .booking-reference {
        font-size: 0.65rem;
        font-weight: 900;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-top: 0.5rem;
        text-align: center;
    }
    .booking-reference-value {
        font-family: 'Courier New', monospace;
        color: #1e293b;
        font-size: 0.8rem;
    }
    @media (max-width: 768px) {
        .ticket-container {
            flex-direction: column;
            min-height: auto;
        }
        .ticket-right {
            border-left: none;
            border-top: 2px dashed rgba(2, 132, 199, 0.3);
        }
        .qr-barcode-section {
            grid-template-columns: 1fr;
        }
    }
    @media print {
        nav, footer, .no-print {
            display: none !important;
        }
        body {
            background: white !important;
        }
        .ticket {
            box-shadow: none !important;
            max-width: 100% !important;
        }
    }
</style>

<div class="flex-grow pt-32 pb-24 px-4 md:px-8 max-w-6xl mx-auto relative min-h-screen">
    <!-- Atmospheric Background Elements -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-1/4 -right-1/4 w-[800px] h-[800px] bg-primary-200/10 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-1/4 -left-1/4 w-[600px] h-[600px] bg-indigo-200/10 rounded-full blur-[100px]"></div>
    </div>

    <!-- Top Actions -->
    <div class="flex justify-between items-center mb-10 relative z-10 no-print">
        <a class="flex items-center gap-2 text-primary-600 font-bold text-sm hover:text-primary-700 transition-colors" href="{{ route('bookings.index') }}">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Back to My Trips
        </a>
        <button onclick="window.print()" class="flex items-center gap-2 py-3 px-6 bg-gradient-primary text-white font-black text-sm rounded-lg shadow-lg hover:shadow-xl transition-all">
            <span class="material-symbols-outlined text-sm">print</span>
            Print Ticket
        </button>
    </div>

    <!-- Professional Ticket -->
    <div class="ticket animate-slide-up relative z-10">
        <div class="ticket-container">
            <!-- LEFT: Route Information (Blue Gradient) -->
            <div class="ticket-left">
                <div class="ticket-left-content">
                    <!-- Logo -->
                    <div class="ticket-logo">
                        <span class="material-symbols-outlined">explore</span>
                        <div class="ticket-logo-text">Nomado</div>
                    </div>

                    <!-- Route -->
                    <div class="route-container">
                        <div class="route-city">{{ strtoupper(substr($payment->departure_city, 0, 3)) }}</div>
                        <div class="route-country">{{ $payment->departure_country }}</div>
                    </div>

                    <div class="route-arrow">
                        <span class="material-symbols-outlined">near_me</span>
                    </div>

                    <div class="route-container">
                        <div class="route-city">{{ strtoupper(substr($payment->booking->city->name, 0, 3)) }}</div>
                        <div class="route-country">{{ $payment->booking->city->country->name }}</div>
                    </div>
                </div>

                <!-- Passenger Name (Bottom) -->
                <div>
                    <div class="passenger-name">Passenger</div>
                    <div class="passenger-name-value">{{ strtoupper($payment->user->name) }}</div>
                </div>
            </div>

            <!-- RIGHT: Details Section -->
            <div class="ticket-right">
                <!-- Top Info Section -->
                <div>
                    <!-- Basic Info -->
                    <div class="ticket-info-row">
                        <div class="ticket-info-item">
                            <div class="ticket-info-label">Departure</div>
                            <div class="ticket-info-value">{{ $payment->start_date->format('M d, Y') }}</div>
                        </div>
                        <div class="ticket-info-item">
                            <div class="ticket-info-label">Duration</div>
                            <div class="ticket-info-value">{{ $payment->booking->duration }} Nights</div>
                        </div>
                    </div>

                    <!-- Flight Info -->
                    <div class="ticket-flight-info">
                        <div class="flight-time-display">
                            <div class="time-item">
                                <div class="time-label">Departure</div>
                                <div class="time-value">{{ $payment->flight_departure ?? '--:--' }}</div>
                            </div>
                            <div class="flight-divider">✈</div>
                            <div class="time-item">
                                <div class="time-label">Arrival</div>
                                <div class="time-value">{{ $payment->flight_arrival ?? '--:--' }}</div>
                            </div>
                        </div>
                        <div class="flight-duration">{{ $payment->flight_duration ?? 'N/A' }} @if($payment->airline) • {{ $payment->airline }} @endif</div>
                    </div>

                    <!-- Hotel Info -->
                    <div class="hotel-info">
                        <div class="hotel-info-label">📍 Accommodation</div>
                        <div class="hotel-info-value">{{ $payment->booking->hotel->name }}</div>
                    </div>

                    <!-- Passengers -->
                    <div class="ticket-info-row" style="margin-top: 1.5rem;">
                        <div class="ticket-info-item">
                            <div class="ticket-info-label">Guests</div>
                            <div class="ticket-info-value">{{ $payment->booking->passengers }} Travelers</div>
                        </div>
                        <div class="ticket-info-item">
                            <div class="ticket-info-label">Total Price</div>
                            <div class="ticket-info-value" style="color: #0284c7; font-size: 1.375rem;">€{{ number_format($payment->booking->total_price, 0) }}</div>
                        </div>
                    </div>
                </div>

                <!-- Payment Status Badges -->
                <div class="payment-badges">
                    <div class="badge-item">
                        <div class="ticket-info-label">Flight</div>
                        @if($payment->is_flight_paid)
                            <span class="badge-status badge-paid">
                                <span class="material-symbols-outlined" style="font-size: 0.65rem;">check_circle</span>
                                Paid
                            </span>
                        @else
                            <span class="badge-status badge-pending">
                                <span class="material-symbols-outlined" style="font-size: 0.65rem;">schedule</span>
                                Airport
                            </span>
                        @endif
                    </div>
                    <div class="badge-item">
                        <div class="ticket-info-label">Hotel</div>
                        @if($payment->is_hotel_paid)
                            <span class="badge-status badge-paid">
                                <span class="material-symbols-outlined" style="font-size: 0.65rem;">check_circle</span>
                                Paid
                            </span>
                        @else
                            <span class="badge-status badge-pending">
                                <span class="material-symbols-outlined" style="font-size: 0.65rem;">schedule</span>
                                Hotel
                            </span>
                        @endif
                    </div>
                </div>

                <!-- QR Code & Barcode Section -->
                <div class="qr-barcode-section">
                    <!-- QR Code -->
                    <div class="qr-container">
                        <div class="qr-label">QR Code</div>
                        <div class="qr-code-box">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=NOM-{{ str_pad($payment->booking->id, 5, '0', STR_PAD_LEFT) }}-{{ urlencode($payment->user->email) }}"
                                 alt="Booking QR Code" />
                        </div>
                    </div>

                    <!-- Barcode -->
                    <div class="barcode-container">
                        <div class="barcode-label">Booking ID</div>
                        <div class="barcode">
                            @for($i = 0; $i < 35; $i++)
                                <div class="barcode-line" style="height: {{ rand(35, 60) }}px;"></div>
                            @endfor
                        </div>
                        <div class="barcode-text">NOM{{ str_pad($payment->booking->id, 8, '0', STR_PAD_LEFT) }}</div>
                    </div>
                </div>

                <!-- Booking Reference -->
                <div class="booking-reference">
                    Booking: <span class="booking-reference-value">#NOM-{{ str_pad($payment->booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                    <br>
                    <span style="font-size: 0.6rem; opacity: 0.7;">{{ now()->format('M d, Y • H:i') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Actions -->
    <div class="mt-10 relative z-10 no-print flex gap-4 justify-center">
        <a href="{{ route('bookings.index') }}" class="flex items-center gap-2 py-3 px-6 border-2 border-slate-300 text-slate-700 font-black text-sm rounded-lg hover:bg-slate-50 transition-all">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Back to My Trips
        </a>
    </div>
</div>
@endsection
