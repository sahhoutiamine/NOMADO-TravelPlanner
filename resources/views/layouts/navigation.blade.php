<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 font-black text-gray-900 text-2xl tracking-tighter group transition-transform hover:scale-[1.02] duration-200">
                        <div class="w-9 h-9 rounded-lg bg-primary-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-white text-xl" style="font-variation-settings: 'FILL' 1;">explore</span>
                        </div>
                        <span>Nomado</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:-my-px sm:ms-8 sm:flex sm:items-center">
                    @if(Auth::user()->role === 'admin')
                        <x-nav-link :href="route('admin.bookings.index')" :active="request()->routeIs('admin.bookings.*')">
                            📋 Réservations
                        </x-nav-link>
                        <x-nav-link :href="route('admin.countries.index')" :active="request()->routeIs('admin.countries.*')">
                            🌍 Pays
                        </x-nav-link>
                        <x-nav-link :href="route('admin.hotels.index')" :active="request()->routeIs('admin.hotels.*')">
                            🏨 Hôtels
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('trip.index')" :active="request()->routeIs('trip.*')" class="font-semibold text-sm">
                            Planner
                        </x-nav-link>
                        <x-nav-link :href="route('bookings.index')" :active="request()->routeIs('bookings.*')" class="font-semibold text-sm">
                            My Trips
                        </x-nav-link>
                    @endif

                </div>
            </div>

            <!-- Right Side: User Info + Logout -->
            <div class="hidden sm:flex sm:items-center sm:gap-3">
                <!-- User badge -->
                <div class="flex items-center gap-2 px-3 py-1.5 bg-gray-100 rounded-xl">
                    <div class="w-7 h-7 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-black">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="text-sm">
                        <span class="font-bold text-gray-800 block leading-tight">{{ Auth::user()->name }}</span>
                        @if(Auth::user()->role === 'admin')
                            <span class="text-xs text-blue-600 font-semibold">Admin</span>
                        @else
                            <span class="text-xs text-gray-400 font-medium">Voyageur</span>
                        @endif
                    </div>
                </div>

                <!-- Profile link -->
                <a href="{{ route('profile.edit') }}" title="Mon profil"
                   class="w-9 h-9 flex items-center justify-center text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </a>

                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-2 px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 hover:text-red-700 font-bold text-sm rounded-xl border border-red-200 hover:border-red-300 transition-all group">
                        <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Déconnexion
                    </button>
                </form>
            </div>

            <!-- Hamburger (mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-gray-100">
        <div class="pt-2 pb-3 space-y-1 px-2">
            @if(Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.bookings.index')" :active="request()->routeIs('admin.bookings.*')">
                    📋 Gérer Réservations
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.countries.index')" :active="request()->routeIs('admin.countries.*')">
                    🌍 Pays
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.hotels.index')" :active="request()->routeIs('admin.hotels.*')">
                    🏨 Hôtels
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('trip.index')" :active="request()->routeIs('trip.*')">
                    Planner
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('bookings.index')" :active="request()->routeIs('bookings.*')">
                    My Trips
                </x-responsive-nav-link>
            @endif

        </div>

        <!-- Responsive User + Logout -->
        <div class="pt-3 pb-4 border-t border-gray-200 px-4">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-black text-lg">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="font-bold text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="space-y-2">
                <x-responsive-nav-link :href="route('profile.edit')">
                    👤 {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Mobile Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-3 bg-red-50 hover:bg-red-100 text-red-600 font-bold text-sm rounded-xl border border-red-200 transition-all mt-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
