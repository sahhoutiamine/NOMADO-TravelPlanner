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
            from {
                transform: translateY(30px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .animate-slide-up {
            animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .budget-progress {
            width: 0;
            transition: width 1.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
    </style>

    <div class="flex-grow pt-32 pb-24 px-4 md:px-8 max-w-7xl mx-auto relative min-h-screen">
        <!-- Atmospheric Background Elements -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute -top-1/4 -right-1/4 w-[800px] h-[800px] bg-primary-200/10 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-1/4 -left-1/4 w-[600px] h-[600px] bg-indigo-200/10 rounded-full blur-[100px]"></div>
        </div>

        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-16 gap-6 relative z-10">
            <div class="animate-slide-up">
                <h1 class="text-5xl md:text-6xl font-black tracking-tighter mb-2 text-slate-900">Your <span
                        class="text-gradient">Explorations</span></h1>
                <p class="text-slate-500 text-lg font-medium">A curated history of your bespoke journeys.</p>
            </div>

            <div class="animate-slide-up flex gap-3" style="animation-delay: 0.1s">
                <button onclick="openJoinModal()"
                    class="bg-white text-slate-900 border border-slate-200 px-6 py-3.5 rounded-lg font-black text-sm flex items-center gap-2 hover:bg-slate-50 transition-all active:scale-95 shadow-sm">
                    <span class="material-symbols-outlined text-base">group_add</span>
                    Join Trip
                </button>
                <a href="{{ route('trip.index') }}"
                    class="bg-slate-900 text-white px-8 py-3.5 rounded-lg font-black text-sm flex items-center gap-2 hover:shadow-xl transition-all active:scale-95">
                    <span class="material-symbols-outlined text-base">add_circle</span>
                    New Journey
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-10 animate-slide-up">
                <div
                    class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-6 py-4 rounded-lg flex items-center gap-3 font-bold text-sm shadow-sm shadow-emerald-100/50">
                    <span class="material-symbols-outlined">check_circle</span>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-10 animate-slide-up">
                <div
                    class="bg-rose-50 border border-rose-100 text-rose-700 px-6 py-4 rounded-lg flex items-center gap-3 font-bold text-sm shadow-sm shadow-rose-100/50">
                    <span class="material-symbols-outlined">error</span>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @if($bookings->isEmpty())
            <div class="relative z-10 animate-slide-up text-center" style="animation-delay: 0.2s">
                <div class="glass-card max-w-lg mx-auto p-16 rounded-xl border border-white/50 shadow-2xl">
                    <div
                        class="w-24 h-24 bg-primary-50 rounded-[2rem] flex items-center justify-center mx-auto mb-8 text-primary-600">
                        <span class="material-symbols-outlined text-5xl">explore</span>
                    </div>
                    <h3 class="text-3xl font-black text-slate-900 mb-4 tracking-tight">The world awaits.</h3>
                    <p class="text-slate-500 font-medium mb-10 leading-relaxed">You haven't generated any journeys yet. Let's
                        create your first bespoke itinerary.</p>
                    <a href="{{ route('trip.index') }}"
                        class="inline-flex items-center gap-3 text-primary-600 font-black text-lg hover:text-primary-700 transition-all hover:translate-x-1">
                        Launch the AI Generator <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                </div>
            </div>
        @else
            <!-- Bookings Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 relative z-10">
                @foreach($bookings as $index => $booking)
                    <div class="animate-slide-up" style="animation-delay: {{ 0.1 * ($index + 1) }}s;">
                        <div
                            class="glass-card rounded-xl overflow-hidden border border-white/50 shadow-xl hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 group h-full flex flex-col">
                            <!-- Trip Image -->
                            <div class="relative h-60 overflow-hidden">
                                <img src="{{ $booking->city->image ?? 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1' }}"
                                    alt="{{ $booking->city->name }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

                                <!-- Status Badge -->
                                <div class="absolute top-5 right-5">
                                    <span
                                        class="px-3.5 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest flex items-center gap-1.5 {{ $booking->status === 'paid' ? 'bg-emerald-500 text-white' : 'bg-amber-100 text-amber-700' }}">
                                        <span class="material-symbols-outlined text-xs"
                                            style="font-variation-settings: 'FILL' 1;">{{ $booking->status === 'paid' ? 'verified' : 'pending' }}</span>
                                        {{ $booking->status === 'paid' ? 'Paid' : 'Pending' }}
                                    </span>
                                </div>

                                <div class="absolute bottom-6 left-6 text-white">
                                    <span
                                        class="text-[9px] font-black uppercase tracking-[0.2em] text-white/70 block mb-1">Recommendation</span>
                                    <h3 class="text-3xl font-black tracking-tighter">{{ $booking->city->name }}</h3>
                                </div>
                            </div>

                            <!-- Info Body -->
                            <div class="p-8 flex-1 flex flex-col">
                                <div class="flex items-center gap-6 mb-8 text-slate-500">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-sm">schedule</span>
                                        <span class="text-xs font-black uppercase tracking-widest">{{ $booking->duration }}
                                            nights</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-sm">group</span>
                                        <span class="text-xs font-black uppercase tracking-widest">{{ $booking->passengers }}
                                            px</span>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-1">Total Budget
                                    </p>
                                    <div class="text-2xl font-black text-slate-900">&euro;{{ number_format($booking->budget_total) }}
                                    </div>
                                </div>

                                <!-- Action -->
                                <div class="mt-auto pt-6 border-t border-slate-100 flex justify-between items-center">
                                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 italic">ID:
                                        #NOM-{{ str_pad($booking->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    <div class="flex items-center gap-3">
                                        @if($booking->passengers > 1 && $booking->user_id === auth()->id())
                                            <button onclick="shareTrip({{ $booking->id }})" class="p-2 text-slate-400 hover:text-primary-600 transition-colors flex items-center" title="Share trip">
                                                <span class="material-symbols-outlined text-xl">share</span>
                                            </button>
                                        @endif
                                        <a href="{{ route('bookings.show', $booking->id) }}"
                                            class="flex items-center gap-2 text-primary-600 font-black text-sm group-hover:translate-x-1 transition-transform">
                                            Details <span class="material-symbols-outlined text-base">arrow_forward</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if(method_exists($bookings, 'links'))
                <div class="mt-16 flex justify-center animate-slide-up">
                    {{ $bookings->links() }}
                </div>
            @endif
        @endif
    </div>

@endsection

@push('scripts')
<!-- Join Modal -->
<div id="joinModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeJoinModal()"></div>
    <div class="relative w-full max-w-md animate-slide-up">
        <div class="glass-card rounded-2xl border border-white/50 shadow-2xl overflow-hidden">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-black text-slate-900">Join a <span class="text-gradient">Trip</span></h3>
                    <button onclick="closeJoinModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                <p class="text-slate-500 font-medium mb-8">Enter the 6-digit code shared with you to join an existing exploration.</p>
                
                <form action="{{ route('bookings.join') }}" method="POST">
                    @csrf
                    <div class="mb-8">
                        <input type="text" name="code" maxlength="6" placeholder="E.g. A1B2C3" required
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-6 py-4 text-center text-2xl font-black tracking-[0.5em] text-slate-900 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all uppercase placeholder:tracking-normal placeholder:text-slate-300">
                    </div>
                    
                    <button type="submit" class="w-full bg-slate-900 text-white py-4 rounded-xl font-black text-sm flex items-center justify-center gap-2 hover:shadow-lg transition-all active:scale-95">
                        <span class="material-symbols-outlined">group_add</span>
                        Access Shared Trip
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Share Modal -->
<div id="shareModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeShareModal()"></div>
    <div class="relative w-full max-w-md animate-slide-up">
        <div class="glass-card rounded-2xl border border-white/50 shadow-2xl overflow-hidden">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-black text-slate-900">Share <span class="text-gradient">Trip</span></h3>
                    <button onclick="closeShareModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                <p class="text-slate-500 font-medium mb-8">Give this code to your companions so they can access this trip.</p>
                
                <div class="relative mb-8">
                    <div id="shareCodeDisplay" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-6 py-6 text-center text-4xl font-black tracking-[0.3em] text-primary-600">
                        LOADING
                    </div>
                    <button onclick="copyShareCode()" class="absolute -bottom-4 right-4 bg-white border border-slate-200 p-2 rounded-lg shadow-sm hover:bg-slate-50 transition-all active:scale-90 flex items-center gap-2 text-xs font-black text-slate-600">
                        <span class="material-symbols-outlined text-sm">content_copy</span>
                        Copy Code
                    </button>
                </div>

                <div id="copySuccess" class="hidden text-center text-emerald-600 font-bold text-xs animate-bounce">
                    Code copied to clipboard!
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openJoinModal() {
        document.getElementById('joinModal').classList.remove('hidden');
        document.getElementById('joinModal').classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeJoinModal() {
        document.getElementById('joinModal').classList.add('hidden');
        document.getElementById('joinModal').classList.remove('flex');
        document.body.style.overflow = 'auto';
    }

    function closeShareModal() {
        document.getElementById('shareModal').classList.add('hidden');
        document.getElementById('shareModal').classList.remove('flex');
        document.body.style.overflow = 'auto';
    }

    function shareTrip(bookingId) {
        const display = document.getElementById('shareCodeDisplay');
        display.innerText = 'LOADING';
        
        document.getElementById('shareModal').classList.remove('hidden');
        document.getElementById('shareModal').classList.add('flex');
        document.body.style.overflow = 'hidden';

        fetch(`/my-bookings/${bookingId}/share-code`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                display.innerText = data.code;
            } else {
                display.innerText = 'ERROR';
                alert(data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            display.innerText = 'ERROR';
        });
    }

    function copyShareCode() {
        const code = document.getElementById('shareCodeDisplay').innerText;
        navigator.clipboard.writeText(code).then(() => {
            const success = document.getElementById('copySuccess');
            success.classList.remove('hidden');
            setTimeout(() => success.classList.add('hidden'), 2000);
        });
    }

    // Close on escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeJoinModal();
            closeShareModal();
        }
    });
</script>
@endpush