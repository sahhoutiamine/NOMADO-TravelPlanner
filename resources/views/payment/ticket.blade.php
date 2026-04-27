@extends('layouts.app')

@section('content')
<style>
    .ticket-outer {
        max-width: 800px;
        margin: 0 auto;
    }
    .ticket-card {
        background: white;
        border-radius: 2rem;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
    }
    .ticket-header {
        background: #0f172a;
        color: white;
        padding: 3rem 4rem;
        position: relative;
        overflow: hidden;
    }
    .ticket-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 8px;
        background: repeating-linear-gradient(90deg, transparent, transparent 10px, white 10px, white 20px);
        opacity: 0.1;
    }
    .ticket-body {
        padding: 4rem;
        background: white;
        position: relative;
    }
    .ticket-perforation {
        height: 2px;
        border-bottom: 2px dashed #e2e8f0;
        margin: 0 4rem;
        position: relative;
    }
    .ticket-perforation::before, .ticket-perforation::after {
        content: '';
        position: absolute;
        width: 40px;
        height: 40px;
        background: #f8fafc; /* Matches the background of the page */
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
    }
    .ticket-perforation::before { left: -60px; }
    .ticket-perforation::after { right: -60px; }

    .city-code {
        font-size: 4rem;
        font-weight: 900;
        letter-spacing: -0.05em;
        line-height: 1;
    }
    .city-name {
        font-size: 0.875rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        opacity: 0.6;
    }
    .ticket-label {
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #94a3b8;
        margin-bottom: 0.25rem;
    }
    .ticket-value {
        font-size: 1.125rem;
        font-weight: 700;
        color: #1e293b;
    }
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .status-paid { background: #f0fdf4; color: #166534; border: 1px solid #dcfce7; }
    .status-pending { background: #fff7ed; color: #9a3412; border: 1px solid #ffedd5; }

    @media print {
        .no-print { display: none !important; }
        body { background: white !important; }
        .ticket-card { box-shadow: none; border: 1px solid #e2e8f0; }
        .ticket-perforation::before, .ticket-perforation::after { display: none; }
    }
</style>

<div class="flex-grow pt-32 pb-24 px-4 relative min-h-screen bg-slate-50">
    <!-- Atmospheric Background -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden no-print">
        <div class="absolute top-0 right-0 w-1/2 h-1/2 bg-indigo-50/50 rounded-full blur-[120px]"></div>
    </div>

    <div class="ticket-outer relative z-10">
        <!-- Top Navigation -->
        <div class="flex justify-between items-center mb-12 no-print">
            <a href="{{ route('bookings.index') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-slate-900 font-bold text-sm transition-colors group">
                <span class="material-symbols-outlined text-sm group-hover:-translate-x-1 transition-transform">arrow_back</span>
                My Trips
            </a>
            <button onclick="window.print()" class="flex items-center gap-2 px-6 py-3 bg-white border border-slate-200 text-slate-900 font-bold text-sm rounded-xl hover:bg-slate-50 transition-all shadow-sm">
                <span class="material-symbols-outlined text-sm">print</span>
                Print PDF
            </button>
        </div>

        <!-- Ticket Card -->
        <div class="ticket-card animate-fade-in">
            <!-- Header -->
            <div class="ticket-header">
                <div class="flex justify-between items-start mb-12">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center backdrop-blur-md">
                            <span class="material-symbols-outlined text-white">explore</span>
                        </div>
                        <span class="font-black text-xl tracking-tighter uppercase">Nomado</span>
                    </div>
                    <div class="text-right">
                        <div class="text-[10px] font-bold text-white/40 uppercase tracking-widest mb-1">Booking Ref</div>
                        <div class="font-mono text-sm">#NOM-{{ str_pad($payment->booking->id, 5, '0', STR_PAD_LEFT) }}</div>
                    </div>
                </div>

                <div class="flex justify-between items-center gap-8">
                    <div>
                        <div class="city-code">{{ strtoupper(substr($payment->departure_city, 0, 3)) }}</div>
                        <div class="city-name">{{ $payment->departure_city }}</div>
                    </div>
                    
                    <div class="flex-1 flex flex-col items-center">
                        <div class="w-full border-t border-dashed border-white/20 relative">
                            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-[#0f172a] px-4">
                                <span class="material-symbols-outlined text-indigo-400">flight_takeoff</span>
                            </div>
                        </div>
                    </div>

                    <div class="text-right">
                        <div class="city-code">{{ strtoupper(substr($payment->booking->city->name, 0, 3)) }}</div>
                        <div class="city-name">{{ $payment->booking->city->name }}</div>
                    </div>
                </div>
            </div>

            <!-- Body: Main Info -->
            <div class="ticket-body">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-12">
                    <div>
                        <div class="ticket-label">Passenger</div>
                        <div class="ticket-value text-indigo-600">{{ $payment->user->name }}</div>
                    </div>
                    <div>
                        <div class="ticket-label">Departure Date</div>
                        <div class="ticket-value">{{ $payment->start_date->format('d M Y') }}</div>
                    </div>
                    <div>
                        <div class="ticket-label">Class</div>
                        <div class="ticket-value">{{ $payment->booking->flight_class ?? 'Economy' }}</div>
                    </div>
                    <div>
                        <div class="ticket-label">Travelers</div>
                        <div class="ticket-value">{{ $payment->booking->passengers }} Adults</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <!-- Flight Details -->
                    <div class="space-y-6">
                        <h4 class="text-xs font-black text-slate-900 uppercase tracking-widest flex items-center gap-2">
                            <span class="w-1.5 h-1.5 bg-indigo-600 rounded-full"></span>
                            Flight Information
                        </h4>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center p-4 bg-slate-50 rounded-2xl">
                                <div>
                                    <div class="text-[10px] font-bold text-slate-400 uppercase">Airline</div>
                                    <div class="text-sm font-bold text-slate-900">{{ $payment->airline ?? 'Scheduled Carrier' }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-[10px] font-bold text-slate-400 uppercase">Duration</div>
                                    <div class="text-sm font-bold text-slate-900">{{ $payment->flight_duration ?? 'TBA' }}</div>
                                </div>
                            </div>
                            <div class="flex justify-between items-center px-2">
                                <div class="status-badge {{ $payment->is_flight_paid ? 'status-paid' : 'status-pending' }}">
                                    Flight {{ $payment->is_flight_paid ? 'Paid' : 'Airport' }}
                                </div>
                                <div class="text-[10px] font-mono text-slate-400">GATE TBA • SEAT TBA</div>
                            </div>
                        </div>
                    </div>

                    <!-- Accommodation -->
                    <div class="space-y-6">
                        <h4 class="text-xs font-black text-slate-900 uppercase tracking-widest flex items-center gap-2">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                            Accommodation
                        </h4>
                        <div class="space-y-4">
                            <div class="flex justify-between items-start p-4 bg-slate-50 rounded-2xl">
                                <div>
                                    <div class="text-[10px] font-bold text-slate-400 uppercase">Hotel</div>
                                    <div class="text-sm font-bold text-slate-900 line-clamp-1">{{ $payment->booking->hotel->name }}</div>
                                    <div class="text-[10px] text-slate-400 mt-1">{{ $payment->booking->duration }} Nights Stay</div>
                                </div>
                            </div>
                            <div class="flex justify-between items-center px-2">
                                <div class="status-badge {{ $payment->is_hotel_paid ? 'status-paid' : 'status-pending' }}">
                                    Hotel {{ $payment->is_hotel_paid ? 'Paid' : 'Counter' }}
                                </div>
                                <div class="text-[10px] font-mono text-slate-400">CHECK-IN 14:00</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Perforation -->
            <div class="ticket-perforation"></div>

            <!-- Footer: QR & Barcode -->
            <div class="ticket-body flex flex-col md:flex-row justify-between items-center gap-12 pt-8">
                <div class="flex items-center gap-8">
                    <div class="p-3 bg-white border-2 border-slate-100 rounded-2xl shadow-sm">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=NOM-{{ $payment->booking->id }}" class="w-20 h-20 opacity-80" alt="QR Code">
                    </div>
                    <div>
                        <div class="ticket-label">Validation QR</div>
                        <p class="text-[10px] text-slate-400 leading-relaxed max-w-[150px]">Scan this code at Nomado counters for priority boarding and check-in.</p>
                    </div>
                </div>

                <div class="flex-1 flex flex-col items-center md:items-end">
                    <div class="flex gap-0.5 mb-2">
                        @for($i = 0; $i < 40; $i++)
                            <div class="w-[1.5px] bg-slate-900" style="height: {{ rand(30, 45) }}px; opacity: {{ rand(4, 10) / 10 }}"></div>
                        @endfor
                    </div>
                    <div class="font-mono text-[10px] tracking-widest text-slate-400">NOM{{ str_pad($payment->booking->id, 10, '0', STR_PAD_LEFT) }}</div>
                </div>
            </div>
        </div>

        <!-- Footer Note -->
        <div class="mt-8 text-center no-print">
            <p class="text-xs text-slate-400 font-medium">Please present this ticket along with a valid ID at the airport. Have a safe journey!</p>
        </div>
    </div>
</div>
@endsection

