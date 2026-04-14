<x-app-layout>
    <div class="min-h-screen bg-[#f8fafc] py-12 md:py-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Context Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 gap-6 fade-in">
                <div class="flex items-center gap-4">
                    <a href="{{ route('bookings.index') }}" class="w-12 h-12 rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:text-primary-600 transition-all hover:shadow-md">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    <div>
                        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Trip Details</h1>
                        <p class="text-slate-500 font-medium">Booking ID: #NOM-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    <span class="px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest {{ $booking->status === 'paid' ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-amber-100 text-amber-700 border border-amber-200' }}">
                        {{ $booking->status === 'paid' ? 'Confirmed' : 'Payment Pending' }}
                    </span>
                    <span class="text-slate-400 text-sm font-bold">{{ $booking->created_at->format('M d, Y') }}</span>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-8 bg-green-50 border border-green-100 text-green-700 px-6 py-4 rounded-2xl flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Main Content (8 cols) -->
                <div class="lg:col-span-8 space-y-8 fade-in" style="animation-delay: 0.2s;">
                    
                    <!-- Hero Card -->
                    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 overflow-hidden border border-white relative">
                        <div class="h-80 relative">
                            <img src="{{ $booking->city->image ?? 'https://images.unsplash.com/photo-1488646953014-c8c32bc611ee' }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                            <div class="absolute bottom-8 left-8">
                                <span class="bg-primary-600 text-white text-[10px] font-black uppercase tracking-[0.2em] px-3 py-1 rounded-lg mb-2 inline-block shadow-lg">Recommended Destination</span>
                                <h2 class="text-4xl md:text-5xl font-black text-white tracking-tighter">{{ $booking->city->name }}</h2>
                                <p class="text-white/80 font-medium mt-1 flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-primary-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                                    {{ $booking->city->country->name ?? 'International' }}
                                </p>
                            </div>
                        </div>
                        <div class="p-8">
                            <p class="text-slate-600 leading-relaxed text-lg font-light italic">"{{ $booking->city->description }}"</p>
                        </div>
                    </div>

                    <!-- Accommodation Section -->
                    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 p-8 border border-white">
                        <div class="flex items-center justify-between mb-8">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                </div>
                                <h3 class="text-2xl font-black text-slate-900 tracking-tight">Accommodation</h3>
                            </div>
                            <a href="{{ route('hotels.show', $booking->hotel->id) }}" class="text-primary-600 font-bold text-sm hover:underline flex items-center gap-1">
                                Full Profile <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>

                        <div class="flex flex-col md:flex-row gap-8 items-start">
                            <div class="w-full md:w-2/5 aspect-[4/3] rounded-3xl overflow-hidden shadow-lg border-4 border-slate-50">
                                <img src="{{ $booking->hotel->image ?? 'https://images.unsplash.com/photo-1566073771259-6a8506099945' }}" class="w-full h-full object-cover">
                            </div>
                            <div class="w-full md:w-3/5">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="flex text-amber-400">
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    </div>
                                    <span class="bg-indigo-50 text-indigo-700 text-[10px] font-black uppercase tracking-tighter px-2.5 py-1 rounded-md border border-indigo-100">Top Rated</span>
                                </div>
                                <h4 class="text-2xl font-black text-slate-900 mb-4">{{ $booking->hotel->name }}</h4>
                                <p class="text-slate-500 font-light leading-relaxed mb-6">{{ $booking->hotel->description }}</p>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Per Night</p>
                                        <p class="text-xl font-black text-slate-900">{{ number_format($booking->hotel->price_per_night, 2) }} €</p>
                                    </div>
                                    <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Stay</p>
                                        <p class="text-xl font-black text-primary-600">{{ number_format($booking->hotel_budget, 2) }} €</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Points of Interest -->
                    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 p-8 border border-white">
                        <div class="flex items-center gap-3 mb-8">
                            <div class="w-10 h-10 rounded-xl bg-primary-100 flex items-center justify-center text-primary-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            </div>
                            <h3 class="text-2xl font-black text-slate-900 tracking-tight">Bucket List Items</h3>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            @foreach($booking->city->places as $place)
                                <div class="group/place bg-slate-50 rounded-3xl p-4 border border-slate-100 hover:bg-white hover:shadow-xl hover:shadow-primary-100/30 transition-all duration-500 flex gap-4">
                                    <div class="w-24 h-24 rounded-2xl overflow-hidden shrink-0 border border-white shadow-sm">
                                        <img src="{{ $place->image }}" class="w-full h-full object-cover grayscale group-hover/place:grayscale-0 transition-all duration-700">
                                    </div>
                                    <div class="flex flex-col justify-center">
                                        <h4 class="font-black text-slate-900 group-hover/place:text-primary-600 transition-colors">{{ $place->name }}</h4>
                                        <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $place->description }}</p>
                                        <a href="{{ route('places.show', $place->id) }}" class="text-[10px] font-black text-primary-600 uppercase tracking-widest mt-2 hover:underline">Explore More &rarr;</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

                <!-- Sidebar Summary (4 cols) -->
                <div class="lg:col-span-4 space-y-8 fade-in" style="animation-delay: 0.4s;">
                    
                    <div class="bg-slate-900 rounded-[2.5rem] shadow-2xl shadow-slate-900/40 p-8 border border-slate-800 lg:sticky lg:top-12">
                        <h3 class="text-2xl font-black text-white mb-8 flex items-center">
                            <span class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-primary-400 mr-3 border border-white/5">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </span>
                            Finances
                        </h3>

                        <div class="space-y-6 mb-12">
                            <div class="flex justify-between items-center group/fee">
                                <div>
                                    <p class="text-xs font-black text-slate-500 uppercase tracking-widest group-hover/fee:text-primary-400 transition-colors">Accommodation</p>
                                    <p class="text-[10px] text-slate-600 font-medium italic">Total duration stay</p>
                                </div>
                                <span class="text-lg font-black text-white tracking-tight">{{ number_format($booking->hotel_budget, 2) }} €</span>
                            </div>

                            <div class="flex justify-between items-center group/fee">
                                <div>
                                    <p class="text-xs font-black text-slate-500 uppercase tracking-widest group-hover/fee:text-indigo-400 transition-colors">Experience Fund</p>
                                    <p class="text-[10px] text-slate-600 font-medium italic">Suggested for activities</p>
                                </div>
                                <span class="text-lg font-black text-white tracking-tight">{{ number_format($booking->activities_budget, 2) }} €</span>
                            </div>

                            <div class="flex justify-between items-center group/fee">
                                <div>
                                    <p class="text-xs font-black text-slate-500 uppercase tracking-widest group-hover/fee:text-cyan-400 transition-colors">Miscellaneous</p>
                                    <p class="text-[10px] text-slate-600 font-medium italic">Backup and daily needs</p>
                                </div>
                                <span class="text-lg font-black text-white tracking-tight">{{ number_format($booking->misc_budget, 2) }} €</span>
                            </div>
                        </div>

                        <div class="pt-8 border-t border-white/10 mb-10">
                            <div class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] text-center mb-1">Grand Total</div>
                            <div class="text-5xl font-black text-center text-white tracking-tighter">{{ number_format($booking->total_price, 2) }} €</div>
                            <p class="text-[10px] text-slate-600 text-center mt-3 font-bold uppercase tracking-widest">All Taxes & Fees Included</p>
                        </div>

                        <!-- Actions -->
                        <div class="space-y-4">
                            @if($booking->status === 'pending')
                                <form action="{{ route('bookings.pay', $booking->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full py-5 bg-gradient-to-r from-primary-600 to-indigo-600 text-white rounded-[1.5rem] font-black text-lg shadow-xl shadow-primary-500/20 hover:shadow-primary-500/40 hover:-translate-y-1 transition-all flex items-center justify-center group/pay">
                                        Secure Payment
                                        <svg class="w-6 h-6 ml-2 group-hover/pay:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    </button>
                                </form>
                                <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Archive this suggestion?');" class="w-full py-4 text-slate-500 text-xs font-black uppercase tracking-[0.2em] hover:text-red-400 transition-colors">
                                        Archive Suggestion
                                    </button>
                                </form>
                            @else
                                <div class="py-6 bg-white/5 rounded-3xl border border-white/10 text-center">
                                    <span class="text-3xl block mb-2">💎</span>
                                    <p class="text-white font-black tracking-tight">Priority Confirmed</p>
                                    <p class="text-slate-500 text-xs mt-1">Your journey is reserved</p>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

            <div class="mt-20 flex flex-col md:flex-row justify-between items-center gap-6 border-t border-slate-200 pt-10">
                <p class="text-slate-400 text-sm font-medium">© 2026 Nomado Vision Travel. All rights reserved.</p>
                <div class="flex gap-8">
                    <a href="#" class="text-slate-500 text-xs font-black uppercase tracking-widest hover:text-primary-600 transition-colors">Insurance Policy</a>
                    <a href="#" class="text-slate-500 text-xs font-black uppercase tracking-widest hover:text-primary-600 transition-colors">Help Center</a>
                    <a href="#" class="text-slate-500 text-xs font-black uppercase tracking-widest hover:text-primary-600 transition-colors">Print PDF</a>
                </div>
            </div>

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
