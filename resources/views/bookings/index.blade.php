<x-app-layout>
    <div class="min-h-screen bg-[#f8fafc] py-12 md:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-8 fade-in">
                <div>
                    <h1 class="text-4xl md:text-6xl font-black text-slate-900 tracking-tighter leading-tight">
                        Your <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-indigo-600">Collection.</span>
                    </h1>
                    <p class="mt-4 text-slate-500 text-lg font-light max-w-xl">
                        A gallery of your past explorations and upcoming adventures curated by Nomado.
                    </p>
                </div>
                <a href="{{ route('trip.index') }}" class="inline-flex items-center px-8 py-4 bg-slate-900 text-white font-black rounded-2xl shadow-xl shadow-slate-900/20 hover:bg-primary-600 hover:-translate-y-1 transition-all group overflow-hidden relative">
                    <span class="relative z-10">New Journey</span>
                    <div class="absolute inset-0 bg-gradient-to-r from-primary-600 to-indigo-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <svg class="w-5 h-5 ml-2 relative z-10 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                </a>
            </div>

            @if(session('success'))
                <div class="mb-10 bg-green-50 border border-green-100 text-green-700 px-6 py-4 rounded-2xl flex items-center gap-3 fade-in">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if($bookings->isEmpty())
                <div class="text-center py-20 bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/40 border border-white fade-in">
                    <div class="w-24 h-24 bg-slate-50 rounded-3xl flex items-center justify-center text-slate-300 mx-auto mb-6">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight">Your gallery is empty.</h3>
                    <p class="mt-2 text-slate-500 font-light mb-8">Ready to discover your next favorite place?</p>
                    <a href="{{ route('trip.index') }}" class="text-primary-600 font-black flex items-center justify-center gap-2 hover:underline">
                        Launch the Generator <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                    @foreach($bookings as $index => $booking)
                        <div class="group bg-white rounded-[2.5rem] overflow-hidden shadow-xl shadow-slate-200/50 border border-white hover:shadow-2xl hover:shadow-primary-100/40 transition-all duration-500 transform hover:-translate-y-2 fade-in" style="animation-delay: {{ $index * 0.1 }}s;">
                            <!-- Image Header -->
                            <div class="h-56 relative overflow-hidden">
                                <img src="{{ $booking->city->image ?? 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1' }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                                
                                <span class="absolute top-5 right-5 px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest leading-none z-10 {{ $booking->status === 'paid' ? 'bg-green-500 text-white' : 'bg-primary-600 text-white' }}">
                                    {{ $booking->status === 'paid' ? 'Confirmed' : 'Pending' }}
                                </span>

                                <div class="absolute bottom-6 left-6 text-white z-10">
                                    <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-80 mb-1">{{ $booking->trip_type }} Trip</p>
                                    <h3 class="text-2xl font-black tracking-tight leading-none">{{ $booking->city->name }}</h3>
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="p-8">
                                <div class="flex items-center gap-6 mb-8">
                                    <div>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Duration</p>
                                        <p class="text-slate-900 font-bold flex items-center text-sm">
                                            <svg class="w-4 h-4 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ $booking->duration }} Nights
                                        </p>
                                    </div>
                                    <div class="w-px h-8 bg-slate-100"></div>
                                    <div>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Passengers</p>
                                        <p class="text-slate-900 font-bold flex items-center text-sm">
                                            <svg class="w-4 h-4 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                            {{ $booking->passengers }} Persons
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between pt-6 border-t border-slate-50">
                                    <div>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Total Budget</p>
                                        <div class="text-2xl font-black text-slate-900 group-hover:text-primary-600 transition-colors leading-none tracking-tighter">
                                            {{ number_format($booking->total_price, 2) }} €
                                        </div>
                                    </div>
                                    <a href="{{ route('bookings.show', $booking->id) }}" class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-400 hover:bg-slate-900 hover:text-white transition-all transform hover:rotate-45">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <style>
        .fade-in {
            animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .tracking-tighter { letter-spacing: -0.05em; }
        .tracking-tight { letter-spacing: -0.025em; }
    </style>
</x-app-layout>
