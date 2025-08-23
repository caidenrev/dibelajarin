<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl md:text-3xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Katalog Kursus') }}
        </h2>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Temukan kursus terbaik untuk mengembangkan skill Anda</p>
    </x-slot>

    <div class="py-8 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Form Pencarian dengan Design Modern --}}
            <div class="mb-8 bg-gradient-to-r from-slate-800 to-slate-700 backdrop-blur-sm border border-slate-600/50 shadow-xl rounded-2xl p-6 md:p-8">
                <form action="{{ route('courses.index') }}" method="GET" class="space-y-4">
                    <div class="text-center mb-6">
                        <h3 class="text-xl md:text-2xl font-bold text-white mb-2">Cari Kursus Impian Anda</h3>
                        <p class="text-slate-300">Ribuan kursus berkualitas menanti Anda</p>
                    </div>
                    
                    <label for="search" class="sr-only">Cari Kursus</label>
                    <div class="relative flex flex-col sm:flex-row gap-3 sm:gap-0">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" name="search" id="search"
                                placeholder="Cari kursus berdasarkan judul..." value="{{ request('search') }}"
                                class="w-full pl-12 pr-4 py-4 bg-slate-700/80 border border-slate-600 text-white placeholder-slate-400 rounded-xl sm:rounded-r-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all duration-300">
                        </div>
                        <button type="submit"
                            class="bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white font-bold py-4 px-8 rounded-xl sm:rounded-l-none shadow-lg hover:shadow-xl transition-all duration-300">
                            <span class="hidden sm:inline">Cari Sekarang</span>
                            <span class="sm:hidden">Cari</span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Filter Kategori dengan Design Card --}}
            <div class="mb-8">
                <h4 class="text-lg font-semibold text-white mb-4">Filter Kategori</h4>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('courses.index') }}"
                        class="px-4 py-2 text-sm font-medium rounded-full transition-all duration-300 transform hover:scale-105 {{ !request('category') ? 'bg-gradient-to-r from-sky-500 to-blue-600 text-white shadow-lg' : 'bg-slate-700/80 text-gray-300 hover:bg-slate-600 border border-slate-600' }}">
                        Semua Kategori
                    </a>
                    @foreach ($categories as $category)
                        <a href="{{ route('courses.index', ['category' => $category->slug]) }}"
                            class="px-4 py-2 text-sm font-medium rounded-full transition-all duration-300 transform hover:scale-105 {{ request('category') == $category->slug ? 'bg-gradient-to-r from-sky-500 to-blue-600 text-white shadow-lg' : 'bg-slate-700/80 text-gray-300 hover:bg-slate-600 border border-slate-600' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Daftar Kursus dengan Grid Responsif --}}
            <div x-data="{}" x-init="$nextTick(() => {
                document.querySelectorAll('.course-card').forEach((el, i) => {
                    el.style.setProperty('--delay', i * 150 + 'ms');
                });
            })"
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 lg:gap-8">
                @forelse ($courses as $course)
                    <div class="course-card opacity-0 animate-enter group bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700/50 rounded-2xl shadow-lg overflow-hidden
                                transform hover:-translate-y-3 hover:shadow-2xl transition-all duration-500 hover:border-sky-500/50"
                        style="animation-delay: var(--delay)">

                        {{-- Thumbnail Gambar dengan Overlay --}}
                        <div class="relative overflow-hidden">
                            @if ($course->thumbnail)
                                <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}"
                                    class="h-48 w-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="h-48 w-full bg-gradient-to-br from-slate-700 to-slate-800 flex items-center justify-center">
                                    <div class="text-center">
                                        <svg class="w-12 h-12 mx-auto text-slate-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="text-slate-500 text-sm">No Image</span>
                                    </div>
                                </div>
                            @endif
                            
                            {{-- Overlay Gradient --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            {{-- Badge Kategori --}}
                            @if ($course->category)
                                <div class="absolute top-3 left-3">
                                    <a href="{{ route('courses.index', ['category' => $course->category->slug]) }}"
                                        class="inline-block bg-sky-500/90 backdrop-blur-sm text-white text-xs font-semibold px-3 py-1 rounded-full hover:bg-sky-600 transition-colors duration-300">
                                        {{ $course->category->name }}
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div class="p-6 flex flex-col justify-between flex-grow">
                            <div class="flex-grow">
                                <h3 class="text-lg md:text-xl font-bold text-white mb-3 line-clamp-2 group-hover:text-sky-300 transition-colors duration-300">
                                    {{ $course->title }}
                                </h3>
                                <div class="flex items-center text-sm text-gray-400 mb-4">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span>Oleh:</span>
                                    <a href="{{ route('instructors.show', $course->instructor) }}"
                                        class="ml-1 text-sky-400 hover:text-sky-300 hover:underline transition-colors duration-300">
                                        {{ $course->instructor->name }}
                                    </a>
                                </div>
                            </div>
                            
                            <div class="mt-auto">
                                <a href="{{ route('courses.show', $course) }}"
                                    class="group/btn w-full text-center inline-flex items-center justify-center bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                                    <span>Lihat Detail</span>
                                    <svg class="w-4 h-4 ml-2 group-hover/btn:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16">
                        <div class="max-w-md mx-auto">
                            <svg class="w-24 h-24 mx-auto text-slate-600 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="text-xl font-semibold text-white mb-2">Tidak ada kursus ditemukan</h3>
                            <p class="text-gray-400 mb-6">Coba ubah kata kunci pencarian atau filter kategori</p>
                            <a href="{{ route('courses.index') }}" 
                                class="inline-flex items-center px-6 py-3 bg-sky-500 hover:bg-sky-600 text-white font-medium rounded-lg transition-colors duration-300">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Reset Filter
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Custom CSS untuk Animasi --}}
    <link rel="stylesheet" href="/resources/css/modify.css">
</x-app-layout>