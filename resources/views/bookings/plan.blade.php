@extends('layouts.app')

@section('content')
    <style>
        :root {
            --primary: #0ea5e9;
            --primary-dark: #0284c7;
            --secondary: #6366f1;
            --emerald: #10b981;
            --amber: #f59e0b;
            --slate: #64748b;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.07);
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .glass-card.expanded {
            transform: scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(31, 38, 135, 0.15);
            background: rgba(255, 255, 255, 0.9);
        }

        .text-gradient {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .bg-gradient-premium {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
        }

        @keyframes fadeInScale {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }

        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-scale { animation: fadeInScale 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-slide-up { animation: slideInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; }

        .form-section {
            max-height: 0;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            opacity: 0;
            transform: translateY(20px);
        }

        .form-section.active {
            max-height: 400px;
            opacity: 1;
            transform: translateY(0);
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px dashed var(--slate-100);
        }

        .timeline-container {
            position: relative;
            padding: 4rem 0;
        }

        .timeline-line {
            position: absolute;
            left: 50%;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(to bottom, 
                transparent, 
                var(--primary) 10%, 
                var(--secondary) 50%, 
                var(--emerald) 90%, 
                transparent
            );
            transform: translateX(-50%);
        }

        @media (max-width: 768px) {
            .timeline-line { left: 24px; transform: none; }
        }

        .day-node {
            position: relative;
            z-index: 10;
            display: grid;
            grid-template-columns: 1fr 48px 1fr;
            gap: 2rem;
            align-items: flex-start;
            margin-bottom: 1.5rem;
            max-width: 1000px;
            margin-left: auto;
            margin-right: auto;
        }

        .day-node:last-child { margin-bottom: 0; }

        .day-marker {
            grid-column: 2;
            width: 48px;
            height: 48px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: white;
            border: 2px solid currentColor;
            position: relative;
            z-index: 20;
        }

        .day-node:hover .day-marker {
            transform: scale(1.1) rotate(5deg);
        }

        .day-content {
            grid-column: 1;
            position: relative;
            transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .day-node:nth-child(odd) .day-content {
            grid-column: 1;
            text-align: right;
        }

        .day-node:nth-child(even) .day-content {
            grid-column: 3;
            text-align: left;
        }

        .empty-spacer {
            content: "";
        }

        @media (max-width: 768px) {
            .day-node { 
                grid-template-columns: 48px 1fr; 
                gap: 1.5rem;
                padding-left: 1rem;
                padding-right: 1rem;
            }
            .day-marker { grid-column: 1; }
            .day-content { 
                grid-column: 2;
                text-align: left !important;
            }
            .empty-spacer { display: none; }
        }

        .type-pill {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.75rem;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px -10px rgba(0,0,0,0.1);
        }
    </style>

    <div class="min-h-screen bg-slate-50 relative overflow-hidden">
        <!-- Background Orbs -->
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary/5 rounded-full blur-[100px] -mr-64 -mt-64"></div>
        <div class="absolute bottom-0 left-0 w-[600px] h-[600px] bg-secondary/5 rounded-full blur-[120px] -ml-64 -mb-64"></div>

        <div class="max-w-6xl mx-auto px-4 pt-32 pb-24 relative z-10">
            <!-- Session Messages -->
            @if(session('success'))
                <div class="mb-8 animate-fade-scale">
                    <div class="glass-card p-4 rounded-xl border-emerald-200 bg-emerald-50/50 flex items-center gap-3 text-emerald-700 font-bold">
                        <span class="material-symbols-outlined">check_circle</span>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <!-- Navigation & Header -->
            <div class="mb-16 animate-fade-scale">
                <a href="{{ route('bookings.show', $booking->id) }}" 
                   class="inline-flex items-center gap-2 text-slate-500 hover:text-primary font-bold transition-colors mb-6 group">
                    <span class="material-symbols-outlined transition-transform group-hover:-translate-x-1">arrow_back</span>
                    Back to Reservation
                </a>
                
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-8">
                    <div>
                        <h1 class="text-5xl md:text-7xl font-black text-slate-900 tracking-tight leading-tight">
                            The <span class="text-gradient">Master Plan</span>
                        </h1>
                        <p class="text-slate-500 text-xl font-medium mt-4 flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full bg-primary"></span>
                            {{ $booking->city->name }}, {{ $booking->city->country->name }}
                            <span class="text-slate-300">|</span>
                            {{ count($plan) }} Days of Adventure
                        </p>
                    </div>
                    
                    <div class="flex gap-4">
                        <button onclick="window.print()" 
                                class="px-6 py-4 bg-white text-slate-900 font-bold rounded-xl shadow-sm hover:shadow-md transition-all flex items-center gap-2 border border-slate-200">
                            <span class="material-symbols-outlined">print</span>
                            Print
                        </button>
                        <a href="{{ $booking->status === 'paid' ? route('payment.ticket', $booking->id) : route('payment.show', $booking->id) }}" 
                           class="px-8 py-4 bg-slate-950 text-white font-bold rounded-xl shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all flex items-center gap-2">
                            <span class="material-symbols-outlined">confirmation_number</span>
                            E-Ticket
                        </a>
                    </div>
                </div>
            </div>

            <!-- Summary Bar -->
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-20 animate-slide-up" style="animation-delay: 0.2s">
                <div class="glass-card p-6 rounded-2xl text-center border-white/80">
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mb-1">Departure</p>
                    <p class="text-2xl font-black text-slate-900">{{ $booking->departure_date ? \Carbon\Carbon::parse($booking->departure_date)->format('M d') : 'TBD' }}</p>
                </div>
                <div class="glass-card p-6 rounded-2xl text-center border-white/80">
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mb-1">Duration</p>
                    <p class="text-2xl font-black text-slate-900">{{ count($plan) }} Days</p>
                </div>
                <div class="glass-card p-6 rounded-2xl text-center border-white/80">
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mb-1">Travelers</p>
                    <p class="text-2xl font-black text-slate-900">{{ $booking->passengers }} Person{{ $booking->passengers > 1 ? 's' : '' }}</p>
                </div>
                <div class="glass-card p-6 rounded-2xl text-center border-white/80">
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mb-1">Budget</p>
                    <p class="text-2xl font-black text-emerald-600">€{{ number_format($booking->budget_total) }}</p>
                </div>
                <div class="glass-card p-6 rounded-2xl text-center border-white/80">
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mb-1">Flight</p>
                    <p class="text-2xl font-black text-primary">{{ $flightDuration }}</p>
                </div>
            </div>

            <!-- Timeline -->
            <div class="timeline-container">
                <div class="timeline-line"></div>
                
                @foreach($plan as $index => $day)
                    <div class="day-node animate-slide-up" style="animation-delay: {{ 0.1 * ($index + 1) }}s">
                        @php
                            $colors = [
                                'blue' => ['text' => 'text-primary', 'bg' => 'bg-primary/10', 'border' => 'border-primary/20'],
                                'emerald' => ['text' => 'text-emerald-600', 'bg' => 'bg-emerald-50', 'border' => 'border-emerald-200'],
                                'amber' => ['text' => 'text-amber-600', 'bg' => 'bg-amber-50', 'border' => 'border-amber-200'],
                                'slate' => ['text' => 'text-slate-600', 'bg' => 'bg-slate-100', 'border' => 'border-slate-200'],
                            ];
                            $color = $colors[$day['color']] ?? $colors['slate'];
                        @endphp
                        
                        @if($index % 2 == 0)
                            <div class="day-content">
                                <div class="glass-card p-8 rounded-2xl card-hover transition-all duration-500 border-white/90">
                                    <div class="flex items-center gap-3 mb-4 md:justify-end">
                                        <span class="px-4 py-1.5 rounded-full text-xs font-black {{ $color['bg'] }} {{ $color['text'] }} {{ $color['border'] }} border">
                                            DAY {{ $day['day'] }}
                                        </span>
                                        @if(!empty($day['date']))
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                            {{ $day['date'] }}
                                        </span>
                                        @endif
                                    </div>
                                    
                                    <h3 class="text-2xl font-black text-slate-900 mb-3 tracking-tight">
                                        {{ $day['title'] }}
                                    </h3>
                                    
                                    <p class="text-slate-600 font-medium leading-relaxed mb-6">
                                        {{ $day['description'] }}
                                    </p>

                                    <!-- Custom Activities List -->
                                    @if(!empty($day['custom_activities']))
                                        <div class="space-y-3 mb-6">
                                            @foreach($day['custom_activities'] as $activity)
                                                <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100 group/item">
                                                    <div class="flex items-center gap-3">
                                                        <span class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center">
                                                            <span class="material-symbols-outlined" style="font-size: 1.2rem;">star</span>
                                                        </span>
                                                        <div>
                                                            <p class="text-sm font-bold text-slate-900">{{ $activity->name }}</p>
                                                            <p class="text-[10px] font-black text-emerald-600 uppercase">€{{ number_format($activity->budget) }}</p>
                                                        </div>
                                                    </div>
                                                    <form action="{{ route('bookings.plan.activity.destroy', [$booking->id, $activity->id]) }}" method="POST" onsubmit="return confirm('Remove this activity?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-slate-300 hover:text-red-500 transition-colors p-1 opacity-0 group-hover/item:opacity-100">
                                                            <span class="material-symbols-outlined" style="font-size: 1.2rem;">delete</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if($booking->status === 'pending')
                                    <button onclick="toggleActivityForm('{{ $index }}')" 
                                            id="add-btn-{{ $index }}"
                                            class="w-full py-3 rounded-xl border-2 border-dashed border-slate-200 text-slate-400 hover:border-primary hover:text-primary hover:bg-primary/5 transition-all font-bold text-sm flex items-center justify-center gap-2">
                                        <span class="material-symbols-outlined">add_circle</span>
                                        Add Custom Plan
                                    </button>

                                    <div id="form-{{ $index }}" class="form-section">
                                        <div class="flex items-center justify-between mb-6">
                                            <h4 class="text-lg font-black text-slate-900">New Custom Plan</h4>
                                            <button onclick="toggleActivityForm('{{ $index }}')" class="text-slate-400 hover:text-slate-600 transition-colors">
                                                <span class="material-symbols-outlined">close</span>
                                            </button>
                                        </div>

                                        <form action="{{ route('bookings.plan.activity.store', $booking->id) }}" method="POST" class="space-y-5">
                                            @csrf
                                            <input type="hidden" name="date" value="{{ $day['raw_date'] }}">
                                            
                                            <div>
                                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Activity Name</label>
                                                <input type="text" name="name" required placeholder="e.g. Dinner at Le Meurice" 
                                                       class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-primary focus:ring-0 transition-all font-bold text-slate-900 text-sm">
                                            </div>

                                            <div>
                                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Estimated Budget (EUR)</label>
                                                <div class="relative">
                                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 font-black text-slate-400 text-sm">€</span>
                                                    <input type="number" name="budget" required min="0" value="0"
                                                           class="w-full pl-8 pr-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-primary focus:ring-0 transition-all font-bold text-slate-900 text-sm">
                                                </div>
                                            </div>

                                            <button type="submit" class="w-full py-4 bg-slate-950 text-white font-black rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all text-sm">
                                                Save Activity
                                            </button>
                                        </form>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <div class="day-marker {{ $color['text'] }}">
                                <span class="material-symbols-outlined" style="font-size: 1.5rem;">{{ $day['icon'] }}</span>
                            </div>
                            <div class="empty-spacer"></div>
                        @else
                            <div class="empty-spacer"></div>
                            <div class="day-marker {{ $color['text'] }}">
                                <span class="material-symbols-outlined" style="font-size: 1.5rem;">{{ $day['icon'] }}</span>
                            </div>
                            <div class="day-content">
                                <div class="glass-card p-8 rounded-2xl card-hover transition-all duration-500 border-white/90">
                                    <div class="flex items-center gap-3 mb-4">
                                        <span class="px-4 py-1.5 rounded-full text-xs font-black {{ $color['bg'] }} {{ $color['text'] }} {{ $color['border'] }} border">
                                            DAY {{ $day['day'] }}
                                        </span>
                                        @if(!empty($day['date']))
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                            {{ $day['date'] }}
                                        </span>
                                        @endif
                                    </div>
                                    
                                    <h3 class="text-2xl font-black text-slate-900 mb-3 tracking-tight">
                                        {{ $day['title'] }}
                                    </h3>
                                    
                                    <p class="text-slate-600 font-medium leading-relaxed mb-6">
                                        {{ $day['description'] }}
                                    </p>

                                    <!-- Custom Activities List -->
                                    @if(!empty($day['custom_activities']))
                                        <div class="space-y-3 mb-6">
                                            @foreach($day['custom_activities'] as $activity)
                                                <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100 group/item">
                                                    <div class="flex items-center gap-3">
                                                        <span class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center">
                                                            <span class="material-symbols-outlined" style="font-size: 1.2rem;">star</span>
                                                        </span>
                                                        <div>
                                                            <p class="text-sm font-bold text-slate-900">{{ $activity->name }}</p>
                                                            <p class="text-[10px] font-black text-emerald-600 uppercase">€{{ number_format($activity->budget) }}</p>
                                                        </div>
                                                    </div>
                                                    <form action="{{ route('bookings.plan.activity.destroy', [$booking->id, $activity->id]) }}" method="POST" onsubmit="return confirm('Remove this activity?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-slate-300 hover:text-red-500 transition-colors p-1 opacity-0 group-hover/item:opacity-100">
                                                            <span class="material-symbols-outlined" style="font-size: 1.2rem;">delete</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if($booking->status === 'pending')
                                    <button onclick="toggleActivityForm('{{ $index }}')" 
                                            id="add-btn-{{ $index }}"
                                            class="w-full py-3 rounded-xl border-2 border-dashed border-slate-200 text-slate-400 hover:border-primary hover:text-primary hover:bg-primary/5 transition-all font-bold text-sm flex items-center justify-center gap-2">
                                        <span class="material-symbols-outlined">add_circle</span>
                                        Add Custom Plan
                                    </button>

                                    <div id="form-{{ $index }}" class="form-section">
                                        <div class="flex items-center justify-between mb-6">
                                            <h4 class="text-lg font-black text-slate-900">New Custom Plan</h4>
                                            <button onclick="toggleActivityForm('{{ $index }}')" class="text-slate-400 hover:text-slate-600 transition-colors">
                                                <span class="material-symbols-outlined">close</span>
                                            </button>
                                        </div>

                                        <form action="{{ route('bookings.plan.activity.store', $booking->id) }}" method="POST" class="space-y-5">
                                            @csrf
                                            <input type="hidden" name="date" value="{{ $day['raw_date'] }}">
                                            
                                            <div>
                                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Activity Name</label>
                                                <input type="text" name="name" required placeholder="e.g. Dinner at Le Meurice" 
                                                       class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-primary focus:ring-0 transition-all font-bold text-slate-900 text-sm">
                                            </div>

                                            <div>
                                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Estimated Budget (EUR)</label>
                                                <div class="relative">
                                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 font-black text-slate-400 text-sm">€</span>
                                                    <input type="number" name="budget" required min="0" value="0"
                                                           class="w-full pl-8 pr-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-xl focus:border-primary focus:ring-0 transition-all font-bold text-slate-900 text-sm">
                                                </div>
                                            </div>

                                            <button type="submit" class="w-full py-4 bg-slate-950 text-white font-black rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all text-sm">
                                                Save Activity
                                            </button>
                                        </form>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Footer Action -->
            <div class="mt-24 text-center animate-slide-up">
                <div class="glass-card p-12 rounded-2xl border-white/50 max-w-2xl mx-auto relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-premium opacity-0 group-hover:opacity-[0.03] transition-opacity"></div>
                    
                    <h2 class="text-3xl font-black text-slate-900 mb-6">Ready for Departure?</h2>
                    <p class="text-slate-500 font-medium mb-10">All your bookings are confirmed and your itinerary is synchronized. Bon voyage!</p>
                    
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="{{ route('bookings.index') }}" 
                           class="px-10 py-5 bg-white text-slate-900 font-black rounded-xl border border-slate-200 hover:bg-slate-50 transition-all shadow-sm">
                            My Trips
                        </a>
                        <a href="{{ route('trip.index') }}" 
                           class="px-10 py-5 bg-slate-950 text-white font-black rounded-xl hover:bg-slate-900 transition-all shadow-xl">
                            Plan Another Trip
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    @endpush

    <style>
        @media print {
            .min-h-screen { background: white !important; }
            .glass-card { 
                background: white !important; 
                box-shadow: none !important; 
                border: 1px solid #e2e8f0 !important;
                backdrop-filter: none !important;
            }
            .timeline-line { background: #e2e8f0 !important; }
            button, .no-print { display: none !important; }
            .day-node { page-break-inside: avoid; }
        }
    </style>

    <script>
        function toggleActivityForm(index) {
            const form = document.getElementById('form-' + index);
            const btn = document.getElementById('add-btn-' + index);
            const card = form.closest('.glass-card');
            
            if (form.classList.contains('active')) {
                form.classList.remove('active');
                card.classList.remove('expanded');
                btn.classList.remove('hidden');
            } else {
                // Close all other forms first for a cleaner experience
                document.querySelectorAll('.form-section').forEach(f => {
                    f.classList.remove('active');
                    f.closest('.glass-card').classList.remove('expanded');
                });
                document.querySelectorAll('[id^="add-btn-"]').forEach(b => b.classList.remove('hidden'));
                
                form.classList.add('active');
                card.classList.add('expanded');
                btn.classList.add('hidden');
                
                // Scroll into view if needed
                setTimeout(() => {
                    const rect = form.getBoundingClientRect();
                    const isVisible = (rect.top >= 0 && rect.bottom <= window.innerHeight);
                    if (!isVisible) {
                        form.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }, 400);
            }
        }
    </script>
@endsection
