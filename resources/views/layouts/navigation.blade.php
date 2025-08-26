<nav x-data="{ open: false }"
    class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 border-b border-gray-100 dark:border-gray-700 shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- LOGO --}}
            <div class="flex items-center">
                <a href="/" class="flex items-center space-x-2">
                    <x-application-logo class="h-9 w-auto text-white" />
                    <span class="text-lg font-bold text-white">Di<span class="text-blue-400">Belajar</span>.In</span>
                </a>
            </div>

            {{-- DESKTOP MENU --}}
            <div class="hidden sm:flex space-x-6 hover:text-blue-500 transition items-center">
                <x-nav-link :href="route('courses.index')" :active="request()->routeIs('courses.index')"
                    class="text-white hover:text-blue-500 font-medium transition">
                    {{ __('Courses') }}
                </x-nav-link>
                <x-nav-link :href="route('about')" :active="request()->routeIs('about')"
                    class="text-white hover:text-blue-500 font-medium transition">
                    {{ __('About') }}
                </x-nav-link>
                {{-- TAMBAHKAN INI --}}
                <x-nav-link :href="route('leaderboard.index')" :active="request()->routeIs('leaderboard.index')"
                    class="text-white hover:text-blue-500 font-medium transition">
                    {{ __('Leaderboard') }}
                </x-nav-link>
                @auth
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                        class="text-white hover:text-blue-500 font-medium transition">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                @endauth
            </div>

            {{-- DESKTOP USER / LOGIN --}}
            <div class="hidden sm:flex items-center space-x-4">
                @auth
                    {{-- ========================================================== --}}
                    {{-- TARUH KODE UNTUK MENAMPILKAN XP DI SINI --}}
                    {{-- ========================================================== --}}
                    <div class="flex items-center">
                        <span class="text-sm font-medium text-amber-300 flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ Auth::user()->xp }} XP
                        </span>
                    </div>
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-white hover:bg-white/10 transition">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="ml-1 w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Sign Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-white hover:underline">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-sm text-white hover:underline">Register</a>
                    @endif
                @endauth
            </div>

            {{-- MOBILE TOGGLE --}}
            <div class="sm:hidden flex items-center">
                <button @click="open = !open"
                    class="relative inline-flex items-center justify-center p-3 rounded-xl bg-white/5 backdrop-blur-sm border border-white/10 text-white hover:bg-white/10 hover:scale-105 transition-all duration-300 group">
                    <svg :class="{ 'hidden': open, 'block': !open }"
                        class="block w-5 h-5 transition-transform duration-300 group-hover:rotate-180" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg :class="{ 'hidden': !open, 'block': open }"
                        class="hidden w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <div
                        class="absolute inset-0 rounded-xl bg-gradient-to-r from-blue-500/20 to-purple-500/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                </button>
            </div>

            {{-- SIDEBAR MOBILE --}}
            <div x-show="open" class="fixed inset-0 flex z-50 sm:hidden">
                <!-- Overlay -->
                <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" x-show="open"
                    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="open = false">
                </div>

                <!-- Sidebar -->
                <div class="relative flex flex-col w-80 bg-white/95 dark:bg-gray-900/95 backdrop-blur-xl shadow-2xl border-r border-gray-200/20 dark:border-gray-700/20"
                    x-show="open" x-transition:enter="transform transition ease-out duration-300"
                    x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                    x-transition:leave="transform transition ease-in duration-200"
                    x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">

                    <!-- Header Sidebar -->
                    <div
                        class="relative flex items-center justify-between h-20 px-6 border-b border-gray-200/30 dark:border-gray-700/30">
                        <div class="flex flex-col">
                            <a href="/" class="flex items-center space-x-2">
                                <x-application-logo class="h-9 w-auto text-white" />
                                <span class="text-lg font-bold text-white">Di<span
                                        class="text-blue-400">Belajar</span>.In</span>
                            </a>
                        </div>
                        </a>
                        <button @click="open = false"
                            class="relative p-2.5 rounded-xl bg-gray-100/50 dark:bg-gray-800/50 text-gray-600 dark:text-gray-300 hover:bg-gray-200/70 dark:hover:bg-gray-700/70 hover:scale-105 transition-all duration-300 group">
                            <svg class="h-5 w-5 transition-transform duration-300 group-hover:rotate-90" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Navigation Menu -->
                    <div class="flex-1 overflow-y-auto py-6 px-4 space-y-2">
                        @auth
                            <a href="{{ route('dashboard') }}"
                                class="group relative flex items-center px-4 py-3.5 rounded-xl text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300 hover:translate-x-1">
                                <div
                                    class="absolute inset-0 rounded-xl bg-gradient-to-r from-blue-500/5 to-purple-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                                <div
                                    class="absolute left-0 w-1 h-8 bg-gradient-to-b from-blue-500 to-purple-500 rounded-r opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                </div>
                                <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:scale-110"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="m8 7 4-4 4 4" />
                                </svg>
                                <span class="font-medium">Dashboard</span>
                            </a>
                        @endauth

                        <a href="{{ route('courses.index') }}"
                            class="group relative flex items-center px-4 py-3.5 rounded-xl text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300 hover:translate-x-1">
                            <div
                                class="absolute inset-0 rounded-xl bg-gradient-to-r from-blue-500/5 to-purple-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                            <div
                                class="absolute left-0 w-1 h-8 bg-gradient-to-b from-blue-500 to-purple-500 rounded-r opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                            <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:scale-110"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span class="font-medium">Courses</span>
                        </a>

                        <!-- Divider -->
                        <div
                            class="my-6 h-px bg-gradient-to-r from-transparent via-gray-200 dark:via-gray-700 to-transparent">
                        </div>

                        <div class="space-y-2">
                            @auth
                                <a href="{{ route('profile.edit') }}"
                                    class="group relative flex items-center px-4 py-3.5 rounded-xl text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300 hover:translate-x-1">
                                    <div
                                        class="absolute inset-0 rounded-xl bg-gradient-to-r from-blue-500/5 to-purple-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    </div>
                                    <div
                                        class="absolute left-0 w-1 h-8 bg-gradient-to-b from-blue-500 to-purple-500 rounded-r opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    </div>
                                    <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:scale-110"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span class="font-medium">Profile</span>
                                </a>
                                <a href="/about"
                                    class="group relative flex items-center px-4 py-3.5 rounded-xl text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300 hover:translate-x-1">
                                    <div
                                        class="absolute inset-0 rounded-xl bg-gradient-to-r from-blue-500/5 to-purple-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    </div>
                                    <div
                                        class="absolute left-0 w-1 h-8 bg-gradient-to-b from-blue-500 to-purple-500 rounded-r opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    </div>
                                    <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:scale-110"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-medium">About</span>
                                </a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="group relative flex items-center w-full px-4 py-3.5 rounded-xl text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400 transition-all duration-300 hover:translate-x-1">
                                        <div
                                            class="absolute inset-0 rounded-xl bg-gradient-to-r from-red-500/5 to-pink-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        </div>
                                        <div
                                            class="absolute left-0 w-1 h-8 bg-gradient-to-b from-red-500 to-pink-500 rounded-r opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        </div>
                                        <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:scale-110"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        <span class="font-medium">Sign Out</span>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}"
                                    class="group relative flex items-center px-4 py-3.5 rounded-xl text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 transition-all duration-300 hover:translate-x-1">
                                    <div
                                        class="absolute inset-0 rounded-xl bg-gradient-to-r from-green-500/5 to-emerald-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    </div>
                                    <div
                                        class="absolute left-0 w-1 h-8 bg-gradient-to-b from-green-500 to-emerald-500 rounded-r opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    </div>
                                    <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:scale-110"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg>
                                    <span class="font-medium">Log in</span>
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="group relative flex items-center px-4 py-3.5 rounded-xl text-gray-700 dark:text-gray-300 hover:text-purple-600 dark:hover:text-purple-400 transition-all duration-300 hover:translate-x-1">
                                        <div
                                            class="absolute inset-0 rounded-xl bg-gradient-to-r from-purple-500/5 to-pink-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        </div>
                                        <div
                                            class="absolute left-0 w-1 h-8 bg-gradient-to-b from-purple-500 to-pink-500 rounded-r opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        </div>
                                        <svg class="w-5 h-5 mr-3 transition-transform duration-300 group-hover:scale-110"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                        </svg>
                                        <span class="font-medium">Register</span>
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="p-4 border-t border-gray-200/30 dark:border-gray-700/30">
                        <div class="text-center">
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Design with <span class="text-red-500">❤</span> by <a
                                    href="https://instagram.com/cainderev"
                                    class="text-md text-blue-50 hover:text-blue-300"> caidenrev</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
