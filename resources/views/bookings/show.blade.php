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
    @keyframes slideLeft {
        from { transform: translateX(30px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    .animate-slide-right {
        animation: slideRight 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    .animate-slide-left {
        animation: slideLeft 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    .budget-progress {
        width: 0;
        transition: width 1s cubic-bezier(0.16, 1, 0.3, 1);
    }
</style>

<div class="flex-grow pt-32 pb-24 px-4 md:px-8 max-w-7xl mx-auto relative min-h-screen">
    <!-- Atmospheric Background Elements -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-1/4 -right-1/4 w-[800px] h-[800px] bg-primary-200/10 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-1/4 -left-1/4 w-[600px] h-[600px] bg-indigo-200/10 rounded-full blur-[100px]"></div>
    </div>

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 gap-6 relative z-10">
        <div class="animate-slide-right">
            <a class="flex items-center gap-2 text-primary-600 font-bold text-sm mb-4 hover:text-primary-700 transition-colors" href="{{ route('bookings.index') }}">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Back to My Trips
            </a>
            <h1 class="text-4xl md:text-5xl font-black tracking-tighter mb-2 text-slate-900">Trip <span class="text-gradient">#NOM-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span></h1>
            <p class="text-slate-500 text-lg font-medium">Booked on {{ $booking->created_at->format('M d, Y') }}</p>
        </div>
        
        <div class="animate-slide-left">
            <span class="px-6 py-2.5 rounded-lg text-xs font-black uppercase tracking-widest flex items-center gap-2 {{ $booking->status === 'paid' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-amber-50 text-amber-600 border border-amber-100' }}">
                <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">{{ $booking->status === 'paid' ? 'verified' : 'pending' }}</span>
                {{ $booking->status === 'paid' ? 'Confirmed' : 'Payment Pending' }}
            </span>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-10 animate-slide-right">
        <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-6 py-4 rounded-[1.5rem] flex items-center gap-3 font-bold text-sm shadow-sm shadow-emerald-100/50">
            <span class="material-symbols-outlined">check_circle</span>
            {{ session('success') }}
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        <!-- LEFT COLUMN: Destination Details -->
        <div class="lg:col-span-2 space-y-10 animate-slide-right">
            <!-- Hero Card -->
            <div class="relative rounded-xl overflow-hidden bg-slate-50 shadow-2xl border border-white/50 aspect-video group">
                <img src="{{ $booking->city->image ?? 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?q=80&w=1200' }}" 
                     alt="{{ $booking->city->name }}" class="absolute inset-0 w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 p-10 w-full">
                    <span class="px-4 py-1.5 bg-white/20 rounded-full text-[10px] font-black uppercase tracking-[0.2em] border border-white/30 mb-4 inline-block text-white">
                        {{ strtoupper($booking->trip_type ?? 'Adventure') }} TRIP
                    </span>
                    <h2 class="text-6xl font-black text-white tracking-tighter">{{ $booking->city->name }}</h2>
                    <p class="text-2xl font-bold text-white/80">{{ $booking->city->country->name ?? 'Europe' }}</p>
                </div>
            </div>

            <!-- Description -->
            <div class="glass-card p-10 rounded-xl border border-white/50 shadow-xl">
                <h3 class="text-2xl font-black mb-4 text-slate-900 tracking-tight">The Experience</h3>
                <div class="relative">
                    <p id="booking-description" class="text-slate-600 leading-relaxed text-lg font-medium italic line-clamp-2 transition-all duration-500">
                        "{{ $booking->city->description }}"
                    </p>
                    <button onclick="toggleBookingDescription('booking-description', this)" class="mt-4 text-primary-600 font-black text-xs uppercase tracking-[0.2em] hover:text-primary-700 transition-colors flex items-center gap-2">
                        See More <span class="material-symbols-outlined text-sm transition-transform">expand_more</span>
                    </button>
                </div>

                <script>
                    function toggleBookingDescription(id, btn) {
                        const el = document.getElementById(id);
                        if (el.classList.contains('line-clamp-2')) {
                            el.classList.remove('line-clamp-2');
                            btn.innerHTML = `See Less <span class="material-symbols-outlined text-sm rotate-180">expand_more</span>`;
                        } else {
                            el.classList.add('line-clamp-2');
                            btn.innerHTML = `See More <span class="material-symbols-outlined text-sm">expand_more</span>`;
                        }
                    }
                </script>
            </div>

            <!-- Accommodation -->
            <div class="glass-card p-8 rounded-xl flex flex-col sm:flex-row gap-8 items-center border border-white/50 shadow-xl group hover:shadow-2xl transition-all duration-500">
                <div class="relative w-full sm:w-64 h-44 rounded-lg overflow-hidden shrink-0 shadow-lg">
                    <img src="{{ $booking->hotel->image ?? 'https://images.unsplash.com/photo-1566073171639-3f8b3f5e4c4b' }}" 
                         alt="{{ $booking->hotel->name }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                </div>
                <div class="flex-1 text-center sm:text-left">
                    <h4 class="text-2xl font-black text-slate-900 mb-1 tracking-tight">{{ $booking->hotel->name }}</h4>
                    <p class="text-slate-400 font-bold text-sm mb-6 uppercase tracking-widest italic">Luxury Stay &middot; {{ $booking->city->name }}</p>
                    <a class="inline-flex items-center gap-2 text-primary-600 font-black text-sm hover:text-primary-700 transition-all hover:translate-x-1" href="{{ route('hotels.show', $booking->hotel->id) }}">
                        View Details <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            </div>

            <!-- Attractions Grid -->
            <div class="space-y-6">
                <h3 class="text-2xl font-black text-slate-900 tracking-tight ml-2">Must-Visit Spots</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($booking->city->places as $place)
                    <div class="glass-card p-5 rounded-[1.5rem] flex gap-5 border border-white/50 hover:shadow-lg transition-all group">
                        <div class="w-24 h-24 rounded-lg overflow-hidden shrink-0 shadow-sm">
                            <img src="{{ $place->image }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                        <div class="flex flex-col justify-center min-w-0">
                            <h4 class="font-bold text-slate-900 truncate tracking-tight">{{ $place->name }}</h4>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2 leading-relaxed">{{ $place->description }}</p>
                            <a class="text-[10px] font-black text-primary-600 uppercase tracking-widest mt-2 flex items-center gap-1 hover:text-primary-700" href="{{ route('places.show', $place->id) }}?booking_id={{ $booking->id }}">
                                Explore <span class="material-symbols-outlined text-[12px]">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: Budget & Actions Sidebar -->
        <div class="lg:col-span-1">
            <div class="sticky top-28 space-y-6 animate-slide-left">
                <div class="glass-card p-10 rounded-xl shadow-2xl border border-white relative overflow-hidden">
                    <div class="absolute -top-20 -right-20 w-64 h-64 bg-primary-200/30 blur-[80px] rounded-full pointer-events-none"></div>

                    <h3 class="text-2xl font-black text-slate-900 tracking-tight mb-8 relative z-10">Trip Summary</h3>

                    <div class="mb-10 relative z-10">
                        <div class="text-xs font-bold text-slate-400 uppercase tracking-[0.2em] mb-2">Total Amount</div>
                        <div class="text-5xl font-black text-slate-900 tracking-tighter">&euro;<span class="count-total" data-target="{{ $booking->total_price }}">0</span></div>
                        <div class="text-[11px] font-black text-slate-400 mt-4 uppercase tracking-[0.15em] flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">schedule</span>
                            {{ $booking->duration }} Nights &middot; {{ $booking->passengers }} Travelers
                        </div>
                    </div>

                    <!-- Progress Bars -->
                    <div class="space-y-7 mb-12 relative z-10">
                        <div>
                            <div class="flex justify-between items-center text-sm mb-3 font-bold">
                                <span class="text-slate-800">Accommodation</span>
                                <span class="text-slate-400 italic">&euro;<span class="count-val" data-target="{{ $booking->hotel_budget }}">0</span></span>
                            </div>
                            <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                @php $hotelPerc = ($booking->hotel_budget / $booking->total_price) * 100; @endphp
                                <div class="h-full bg-indigo-500 rounded-full budget-progress" data-width="{{ $hotelPerc }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between items-center text-sm mb-3 font-bold">
                                <span class="text-slate-800">Experiences</span>
                                <span class="text-slate-400 italic">&euro;<span class="count-val" data-target="{{ $booking->activities_budget }}">0</span></span>
                            </div>
                            <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                @php $actPerc = ($booking->activities_budget / $booking->total_price) * 100; @endphp
                                <div class="h-full bg-primary-500 rounded-full budget-progress" data-width="{{ $actPerc }}%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between items-center text-sm mb-3 font-bold">
                                <span class="text-slate-800">Miscellaneous</span>
                                <span class="text-slate-400 italic">&euro;<span class="count-val" data-target="{{ $booking->misc_budget }}">0</span></span>
                            </div>
                            <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                @php $miscPerc = ($booking->misc_budget / $booking->total_price) * 100; @endphp
                                <div class="h-full bg-slate-400 rounded-full budget-progress" data-width="{{ $miscPerc }}%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="relative z-10 space-y-4">
                        @if($booking->status === 'pending')
                            <a href="{{ route('payment.show', $booking->id) }}" class="w-full py-5 bg-slate-950 text-white font-black text-xl rounded-lg shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-3 active:scale-95 group relative overflow-hidden">
                                <div class="absolute inset-0 bg-primary-600 opacity-0 group-hover:opacity-10 transition-opacity"></div>
                                <span class="relative z-10 flex items-center justify-center gap-3">
                                    Secure Payment <span class="material-symbols-outlined">payments</span>
                                </span>
                            </a>
                            <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure you want to cancel this booking?');" class="w-full py-3 text-red-500 font-bold text-xs uppercase tracking-widest hover:bg-red-50 rounded-xl transition-colors">
                                    Cancel Booking
                                </button>
                            </form>
                        @else
                            <div class="py-6 bg-emerald-50 rounded-[1.5rem] border border-emerald-100 text-center">
                                <span class="material-symbols-outlined text-emerald-500 text-4xl mb-2" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                                <p class="text-emerald-900 font-black text-lg">Transaction Complete</p>
                                <p class="text-emerald-600/70 text-xs font-bold uppercase tracking-widest mt-1">Journey Confirmed</p>
                            </div>
                            <a href="{{ route('payment.ticket', $booking->id) }}" class="w-full py-5 bg-slate-950 text-white font-black text-xl rounded-lg shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-3 active:scale-95 group relative overflow-hidden">
                                <div class="absolute inset-0 bg-primary-600 opacity-0 group-hover:opacity-10 transition-opacity"></div>
                                <span class="relative z-10 flex items-center justify-center gap-3">
                                    View & Print Ticket <span class="material-symbols-outlined">confirmation_number</span>
                                </span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function animateNumbers() {
        document.querySelectorAll('.count-total, .count-val').forEach(el => {
            const target = parseInt(el.getAttribute('data-target'));
            if (isNaN(target)) return;
            
            let current = 0;
            const duration = 1500;
            const startTime = performance.now();
            
            function update(currentTime) {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const easedProgress = 1 - Math.pow(1 - progress, 3);
                const value = Math.floor(easedProgress * target);
                
                el.textContent = value.toLocaleString();
                
                if (progress < 1) {
                    requestAnimationFrame(update);
                } else {
                    el.textContent = target.toLocaleString();
                }
            }
            requestAnimationFrame(update);
        });
    }

    function animateProgress() {
        document.querySelectorAll('.budget-progress').forEach(bar => {
            const width = bar.getAttribute('data-width');
            bar.style.width = '0';
            setTimeout(() => {
                bar.style.width = width;
            }, 50);
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        animateNumbers();
        animateProgress();
    });
</script>
@endsection
