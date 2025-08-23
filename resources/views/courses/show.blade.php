<x-app-layout>
    <section class="header">
    <div class="relative text-center overflow-hidden">
        <div class="absolute inset-0 opacity-90"></div>
        <div class="relative px-6 py-8">
            <h2 class="font-bold text-3xl text-white leading-tight drop-shadow-lg">
                {{ $course->title }}
            </h2>

            {{-- Tambahkan 'justify-center' di sini untuk menengahkan badge --}}
                <div class="mt-2 flex items-center  justify-center space-x-4"> 
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs  bg-green-700 text-white backdrop-blur-sm 
                                font-light"> {{-- Ganti 'font-medium' menjadi 'font-light' --}}
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Kelas Online
                    </span>

                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs  bg-blue-700 text-white backdrop-blur-sm 
                                font-light"> {{-- Ganti 'font-medium' menjadi 'font-light' --}}
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Akses Selamanya
                    </span>
                </div>
            </div>
        </div>
    </section>

    <div class="py-8 bg-gradient-to-br from-slate-50 to-blue-50 dark:from-slate-900 dark:to-slate-800 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Course Info Card -->
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden transition-all duration-300">
                        <div class="p-8">
                            <div class="flex items-start justify-between mb-6">
                                <div class="flex-1">
                                    <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-3">
                                        {{ $course->title }}
                                    </h1>
                                    <div class="flex items-center space-x-3 text-slate-600 dark:text-slate-400">
                                        <div class="flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>Oleh:</span>
                                        </div>
                                        <a href="{{ route('instructors.show', $course->instructor) }}" 
                                           class="font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 transition-colors duration-200">
                                            {{ $course->instructor->name }}
                                        </a>
                                    </div>
                                </div>
                                <div class="flex-shrink-0 ml-6">
                                    <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center shadow-lg">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="prose prose-slate dark:prose-invert max-w-none">
                                <div class="text-slate-700 dark:text-slate-300 leading-relaxed">
                                    {!! $course->description !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lessons Section -->
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
                        <div class="bg-gradient-to-r from-slate-50 to-blue-50 dark:from-slate-700 dark:to-slate-600 px-8 py-6 border-b border-slate-200 dark:border-slate-600">
                            <h4 class="text-2xl font-bold text-slate-900 dark:text-white flex items-center">
                                <svg class="w-7 h-7 mr-3 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                                Materi Pembelajaran
                            </h4>
                            <p class="text-slate-600 dark:text-slate-400 mt-1">{{ $course->lessons->count() }} Pelajaran Tersedia</p>
                        </div>
                        <div class="p-8">
                            @forelse ($course->lessons as $index => $lesson)
                                <div class="flex items-center p-4 rounded-xl border border-slate-200 dark:border-slate-600 mb-4 last:mb-0 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all duration-200 hover:shadow-md">
                                    <div class="flex-shrink-0 w-10 h-10 bg-white text-black rounded-full flex items-center justify-center font-bold shadow-lg">
                                        {{ $index + 1 }}
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <h5 class="font-semibold text-slate-900 dark:text-white">{{ $lesson->title }}</h5>
                                        @if($lesson->duration)
                                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                                                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ $lesson->duration }} menit
                                            </p>
                                        @endif
                                    </div>
                                    <div class="flex-shrink-0">
                                        <svg class="w-5 h-5 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <svg class="w-16 h-16 text-slate-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    <h5 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">Belum Ada Pelajaran</h5>
                                    <p class="text-slate-600 dark:text-slate-400">Materi pelajaran akan segera ditambahkan.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="sticky top-8 space-y-6">
                        
                        <!-- Enrollment Card -->
                        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
                            <div class="p-8">
                                @auth
                                    @php
                                        $isEnrolled = auth()->user()->enrolledCourses->contains($course);
                                    @endphp

                                    @if ($isEnrolled)
                                        <div class="text-center mb-6">
                                            <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-4">
                                                <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Anda Terdaftar!</h3>
                                            <p class="text-slate-600 dark:text-slate-400">Selamat belajar dan raih kesuksesan Anda.</p>
                                        </div>

                                        @if ($course->lessons->isNotEmpty())
                                            <a href="{{ route('lessons.show', [$course, $course->lessons->first()]) }}"
                                               class="w-full inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-green-700 to-green-900 hover:from-green-700 hover:to-green-900 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                                </svg>
                                                Mulai Belajar
                                            </a>
                                        @else
                                            <div class="w-full inline-flex items-center justify-center px-6 py-4 bg-slate-500 text-white font-bold rounded-xl cursor-not-allowed">
                                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                </svg>
                                                Pelajaran Segera Hadir
                                            </div>
                                        @endif
                                    @else
                                        <div class="text-center mb-6">
                                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Siap Memulai?</h3>
                                            <p class="text-slate-600 dark:text-slate-400">Daftar sekarang dan mulai perjalanan pembelajaran Anda!</p>
                                        </div>

                                        <form action="{{ route('courses.enroll', $course) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                    class="w-full inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                                </svg>
                                                Daftar ke Kursus Ini
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <div class="text-center mb-6">
                                        <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Login Diperlukan</h3>
                                        <p class="text-slate-600 dark:text-slate-400">Masuk terlebih dahulu untuk mendaftar ke kursus ini.</p>
                                    </div>

                                    <a href="{{ route('login') }}"
                                       class="w-full inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-200">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                        </svg>
                                        Login untuk Mendaftar
                                    </a>
                                @endauth
                            </div>
                        </div>

                        <!-- Course Stats -->
                        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
                            <div class="p-6">
                                <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Info Kursus</h4>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-slate-600 dark:text-slate-400 flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                                            </svg>
                                            Total Pelajaran
                                        </span>
                                        <span class="font-semibold text-slate-900 dark:text-white">{{ $course->lessons->count() }}</span>
                                    </div>
                                    
                                    <div class="flex items-center justify-between">
                                        <span class="text-slate-600 dark:text-slate-400 flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                            </svg>
                                            Instruktur
                                        </span>
                                        <span class="font-semibold text-slate-900 dark:text-white">{{ $course->instructor->name }}</span>
                                    </div>
                                    
                                    <div class="flex items-center justify-between">
                                        <span class="text-slate-600 dark:text-slate-400 flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                            </svg>
                                            Akses
                                        </span>
                                        <span class="font-semibold text-slate-900 dark:text-white">Selamanya</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>