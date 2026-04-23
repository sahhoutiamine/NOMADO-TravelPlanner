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

        @keyframes slideRight {
            from {
                transform: translateX(-30px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideLeft {
            from {
                transform: translateX(30px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .animate-slide-right {
            animation: slideRight 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .animate-slide-left {
            animation: slideLeft 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .animate-slide-up {
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .timeline {
            position: relative;
            padding: 2rem 0;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, #0284c7, #6366f1, #10b981);
            border-radius: 2px;
        }

        @media (max-width: 768px) {
            .timeline::before {
                left: 31px;
                width: 3px;
            }
        }

        .timeline-item {
            margin-bottom: 3rem;
            opacity: 0;
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @media (max-width: 768px) {
            .timeline-item {
                margin-left: 80px;
            }
        }

        .timeline-item:nth-child(1) {
            animation-delay: 0.1s;
        }

        .timeline-item:nth-child(2) {
            animation-delay: 0.2s;
        }

        .timeline-item:nth-child(3) {
            animation-delay: 0.3s;
        }

        .timeline-item:nth-child(4) {
            animation-delay: 0.4s;
        }

        .timeline-item:nth-child(5) {
            animation-delay: 0.5s;
        }

        .timeline-item:nth-child(6) {
            animation-delay: 0.6s;
        }

        .timeline-item:nth-child(7) {
            animation-delay: 0.7s;
        }

        .timeline-item:nth-child(8) {
            animation-delay: 0.8s;
        }

        .timeline-item:nth-child(n+9) {
            animation-delay: 0.9s;
        }

        .timeline-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
        }

        @media (max-width: 768px) {
            .timeline-content {
                grid-template-columns: 1fr;
            }
        }

        .timeline-item:nth-child(odd) .timeline-content {
            direction: rtl;
        }

        .timeline-item:nth-child(odd) .timeline-content > * {
            direction: ltr;
        }

        .timeline-dot {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            border: 4px solid white;
            box-shadow: 0 0 0 4px currentColor;
            background: white;
            z-index: 10;
            top: 0;
        }

        @media (max-width: 768px) {
            .timeline-dot {
                left: 20px;
                width: 50px;
                height: 50px;
                font-size: 1.3rem;
                box-shadow: 0 0 0 3px currentColor;
            }
        }

        .timeline-item.blue .timeline-dot {
            color: #3b82f6;
        }

        .timeline-item.amber .timeline-dot {
            color: #f59e0b;
        }

        .timeline-item.emerald .timeline-dot {
            color: #10b981;
        }

        .timeline-item.slate .timeline-dot {
            color: #64748b;
        }

        .timeline-card {
            glass-card p-8 rounded-xl border border-white/50 shadow-lg hover:shadow-xl transition-all;
        }

        .day-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            font-weight: bold;
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        .timeline-item.blue .day-badge {
            background: #dbeafe;
            color: #0c4a6e;
        }

        .timeline-item.amber .day-badge {
            background: #fef3c7;
            color: #78350f;
        }

        .timeline-item.emerald .day-badge {
            background: #d1fae5;
            color: #065f46;
        }

        .timeline-item.slate .day-badge {
            background: #f1f5f9;
            color: #334155;
        }
    </style>

    <div class="flex-grow pt-32 pb-24 px-4 md:px-8 max-w-7xl mx-auto relative min-h-screen">
        <!-- Atmospheric Background Elements -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute -top-1/4 -right-1/4 w-[800px] h-[800px] bg-primary-200/10 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-1/4 -left-1/4 w-[600px] h-[600px] bg-indigo-200/10 rounded-full blur-[100px]"></div>
        </div>

        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-16 gap-6 relative z-10">
            <div class="animate-slide-right">
                <a class="flex items-center gap-2 text-primary-600 font-bold text-sm mb-4 hover:text-primary-700 transition-colors"
                    href="{{ route('bookings.show', $booking->id) }}">
                    <span class="material-symbols-outlined text-sm">arrow_back</span>
                    Back to Booking
                </a>
                <h1 class="text-5xl md:text-6xl font-black tracking-tighter mb-2 text-slate-900">
                    Your <span class="text-gradient">{{ $booking->duration }}-Day Journey</span>
                </h1>
                <p class="text-slate-500 text-lg font-medium">
                    🌍 {{ $booking->city->name }}, {{ $booking->city->country->name }} • 👥 {{ $booking->passengers }} traveler{{ $booking->passengers > 1 ? 's' : '' }}
                </p>
            </div>

            <div class="flex gap-3 animate-slide-left">
                <button onclick="window.print()"
                    class="px-8 py-4 bg-slate-950 text-white font-black rounded-lg shadow-lg hover:shadow-xl transition-all flex items-center gap-2 active:scale-95 group relative overflow-hidden">
                    <div class="absolute inset-0 bg-primary-600 opacity-0 group-hover:opacity-10 transition-opacity"></div>
                    <span class="relative z-10 flex items-center gap-2">
                        <span class="material-symbols-outlined">print</span>
                        Print Plan
                    </span>
                </button>
            </div>
        </div>

        <!-- Timeline -->
        <div class="relative z-10">
            <div class="timeline">
                @foreach($plan as $index => $day)
                    <div class="timeline-item {{ $day['color'] }}">
                        <div class="timeline-dot">{{ $day['icon'] }}</div>
                        <div class="timeline-content">
                            <div class="glass-card p-8 rounded-xl border border-white/50 shadow-lg hover:shadow-xl transition-all">
                                <div class="day-badge">Day {{ $day['day'] }}</div>
                                <h3 class="text-2xl font-black text-slate-900 tracking-tight mb-3">{{ $day['title'] }}</h3>
                                <p class="text-slate-600 text-lg leading-relaxed font-medium">{{ $day['description'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Summary Card -->
        <div class="mt-20 relative z-10 animate-slide-up">
            <div class="glass-card p-10 rounded-xl border border-white/50 shadow-xl max-w-2xl mx-auto">
                <h3 class="text-2xl font-black text-slate-900 tracking-tight mb-8 text-center">Trip Summary</h3>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="text-3xl font-black text-primary-600">{{ $booking->duration }}</div>
                        <div class="text-xs font-bold text-slate-500 uppercase tracking-widest mt-2">Days</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-black text-indigo-600">{{ $booking->passengers }}</div>
                        <div class="text-xs font-bold text-slate-500 uppercase tracking-widest mt-2">Travelers</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-black text-emerald-600">€{{ number_format($booking->total_price) }}</div>
                        <div class="text-xs font-bold text-slate-500 uppercase tracking-widest mt-2">Total Budget</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-black text-amber-600">{{ count($plan) }}</div>
                        <div class="text-xs font-bold text-slate-500 uppercase tracking-widest mt-2">Activities</div>
                    </div>
                </div>

                <div class="border-t border-white/30 my-8"></div>

                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-slate-600 font-bold">✈️ Flight Duration:</span>
                        <p class="text-slate-900 font-black text-lg">{{ $flightDuration }}</p>
                    </div>
                    <div>
                        <span class="text-slate-600 font-bold">🏨 Accommodation:</span>
                        <p class="text-slate-900 font-black text-lg">€{{ number_format($booking->hotel_budget) }}</p>
                    </div>
                    <div>
                        <span class="text-slate-600 font-bold">💰 Flight Budget:</span>
                        <p class="text-slate-900 font-black text-lg">€{{ number_format($booking->flight_budget) }}</p>
                    </div>
                    <div>
                        <span class="text-slate-600 font-bold">🎫 Activities:</span>
                        <p class="text-slate-900 font-black text-lg">€{{ number_format($booking->activities_budget) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-12 relative z-10 flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('bookings.show', $booking->id) }}"
                class="px-8 py-4 bg-white text-slate-900 font-black rounded-lg shadow-lg hover:shadow-xl transition-all border border-slate-200 flex items-center justify-center gap-2 active:scale-95">
                <span class="material-symbols-outlined">arrow_back</span>
                Back to Booking
            </a>
            <a href="{{ route('bookings.index') }}"
                class="px-8 py-4 bg-slate-950 text-white font-black rounded-lg shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2 active:scale-95 group relative overflow-hidden">
                <div class="absolute inset-0 bg-primary-600 opacity-0 group-hover:opacity-10 transition-opacity"></div>
                <span class="relative z-10 flex items-center gap-2">
                    <span class="material-symbols-outlined">list</span>
                    View All Trips
                </span>
            </a>
        </div>
    </div>

    <style>
        @media print {
            body {
                background: white;
            }

            .flex-grow {
                padding-top: 2rem !important;
                padding-bottom: 2rem !important;
            }

            button,
            .no-print {
                display: none;
            }

            .timeline-item {
                page-break-inside: avoid;
            }

            .glass-card {
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
                background: white !important;
            }
        }
    </style>
@endsection
