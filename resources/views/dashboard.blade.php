<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <div class="text-sm text-gray-500 dark:text-gray-400">
                Selamat datang kembali! 👋
            </div>
        </div>
    </x-slot>

    <div class="py-4 sm:py-6 lg:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-6 sm:mb-8">
                <div class="bg-gradient-to-br from-slate-800 to-slate-700 rounded-xl sm:rounded-2xl shadow-xl p-4 sm:p-6 lg:p-8 border border-slate-600/50">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div class="flex-1">
                            <h3 class="text-xl sm:text-2xl lg:text-3xl font-bold text-white mb-2">Perjalanan Belajar Anda</h3>
                            <p class="text-slate-300 text-sm sm:text-base lg:text-lg">Lanjutkan pembelajaran dan raih sertifikat Anda</p>
                        </div>
                        <div class="hidden sm:block">
                            <div class="bg-sky-500/20 rounded-full p-3 lg:p-4">
                                <svg class="w-8 h-8 lg:w-12 lg:h-12 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Courses Grid -->
            <div class="space-y-4 sm:space-y-6">
                <h4 class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-gray-200 px-4 sm:px-0">Kursus Anda</h4>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-6 lg:gap-8 px-4 sm:px-0">
                    @forelse ($enrolledCourses as $course)
                        <div class="group bg-slate-800/80 backdrop-blur-sm rounded-xl sm:rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 border border-slate-600/30 hover:border-slate-500/50 overflow-hidden">
                            <!-- Course Header -->
                            <div class="p-4 sm:p-6 pb-3 sm:pb-4">
                                <div class="flex items-start justify-between mb-3 sm:mb-4">
                                    <div class="flex-1 min-w-0"> <!-- min-w-0 untuk text truncation -->
                                        <h5 class="text-lg sm:text-xl font-bold text-white group-hover:text-sky-300 transition-colors duration-200 leading-tight">
                                            {{ $course->title }}
                                        </h5>
                                    </div>
                                    @if ($course->progress == 100)
                                        <div class="ml-2 sm:ml-3 bg-green-500/20 rounded-full p-1.5 sm:p-2 flex-shrink-0">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Progress Section -->
                                <div class="space-y-2 sm:space-y-3">
                                    <div class="flex justify-between items-center text-xs sm:text-sm">
                                        <span class="text-slate-300 font-medium">Progress Pembelajaran</span>
                                        <span class="text-sky-400 font-semibold whitespace-nowrap ml-2">
                                            {{ $course->completed_lessons_count }}/{{ $course->lessons_count }}
                                            <span class="hidden xs:inline">Pelajaran</span>
                                        </span>
                                    </div>
                                    
                                    <div class="relative">
                                        <div class="w-full bg-slate-600/50 rounded-full h-2.5 sm:h-3 overflow-hidden">
                                            <div class="bg-gradient-to-r from-sky-500 to-sky-400 h-full rounded-full transition-all duration-500 ease-out shadow-sm"
                                                style="width: {{ $course->progress }}%">
                                            </div>
                                        </div>
                                        <div class="absolute -top-0.5 sm:-top-1 right-0 bg-slate-700 px-1.5 sm:px-2 py-0.5 sm:py-1 rounded text-xs font-semibold text-sky-400">
                                            {{ number_format($course->progress, 0) }}%
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Button -->
                            <div class="px-4 sm:px-6 pb-4 sm:pb-6">
                                @if ($course->progress == 100)
                                    <a href="{{ route('courses.certificate', $course) }}"
                                        class="group/btn w-full flex items-center justify-center gap-2 bg-gradient-to-r from-green-600 to-green-500 hover:from-green-700 hover:to-green-600 text-white font-semibold py-2.5 sm:py-3 px-4 rounded-lg sm:rounded-xl transition-all duration-200 hover:shadow-lg text-sm sm:text-base">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span class="truncate">Unduh Sertifikat</span>
                                    </a>
                                @elseif ($course->lessons->isNotEmpty())
                                    <a href="{{ route('lessons.show', [$course, $course->lessons->first()]) }}"
                                        class="group/btn w-full flex items-center justify-center gap-2 bg-gradient-to-r from-sky-600 to-sky-500 hover:from-sky-700 hover:to-sky-600 text-white font-semibold py-2.5 sm:py-3 px-4 rounded-lg sm:rounded-xl transition-all duration-200 transform hover:scale-[1.02] hover:shadow-lg text-sm sm:text-base">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h1m4 0h1m-6-8h8m-8 12h8V6a2 2 0 012-2H9a2 2 0 00-2 2v12z"></path>
                                        </svg>
                                        <span class="truncate">Lanjutkan Belajar</span>
                                    </a>
                                @else
                                    <div class="w-full flex items-center justify-center gap-2 bg-slate-600/50 text-slate-300 font-semibold py-2.5 sm:py-3 px-4 rounded-lg sm:rounded-xl cursor-not-allowed text-sm sm:text-base">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="truncate">Segera Hadir</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full">
                            <div class="text-center py-8 sm:py-12 lg:py-16">
                                <div class="bg-slate-700/50 rounded-xl sm:rounded-2xl p-6 sm:p-8 lg:p-12 border border-slate-600/30 mx-4 sm:mx-0">
                                    <div class="mb-4 sm:mb-6">
                                        <svg class="w-16 h-16 sm:w-20 sm:h-20 text-slate-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl sm:text-2xl font-bold text-gray-300 mb-2 sm:mb-3">Belum Ada Kursus</h3>
                                    <p class="text-slate-400 text-sm sm:text-base lg:text-lg mb-6 sm:mb-8">Mulai perjalanan belajar Anda dengan mendaftar di kursus yang tersedia</p>
                                    <a href="{{ route('courses.index') }}"
                                        class="inline-flex items-center gap-2 bg-gradient-to-r from-sky-600 to-sky-500 hover:from-sky-700 hover:to-sky-600 text-white font-semibold py-2.5 sm:py-3 px-6 sm:px-8 rounded-lg sm:rounded-xl transition-all duration-200 transform hover:scale-105 hover:shadow-lg text-sm sm:text-base">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                        <span class="whitespace-nowrap">Jelajahi Kursus</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>