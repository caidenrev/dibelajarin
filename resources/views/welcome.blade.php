<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DiBelajar.In</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo.svg') }}" class="text-blue">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/resources/css/modify.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/css/modify.css', 'resources/js/modify.js'])
</head>

<body class="font-sans antialiased bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-gray-200 min-h-screen">
    <div class="min-h-screen relative overflow-hidden">
        
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-20 left-10 w-72 h-72 bg-gradient-to-r from-blue-500/10 to-purple-500/10 rounded-full blur-3xl float-animation"></div>
            <div class="absolute top-96 right-10 w-96 h-96 bg-gradient-to-r from-purple-500/10 to-pink-500/10 rounded-full blur-3xl float-animation" style="animation-delay: -3s;"></div>
            <div class="absolute bottom-20 left-1/3 w-64 h-64 bg-gradient-to-r from-cyan-500/10 to-blue-500/10 rounded-full blur-3xl float-animation" style="animation-delay: -1.5s;"></div>
        </div>

        <!-- Navigation -->
        <nav class="fixed top-0 left-0 right-0 z-50 mb-5 bg-white/10 backdrop-blur-md border-b border-white/20 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <div class="flex items-center">
                        <a href="/" class="flex items-center space-x-3 group">
                            <span class="text-xl lg:text-4xl md:text-2xl sm:text-2xl font-bold text-white drop-shadow-[2px_2px_6px_rgba(0,0,0,0.8)]">
                                Di<span class="text-blue-400 drop-shadow-[1px_1px_5px_rgba(0,0,0,0.8)]">Belajar</span>.In
                            </span>
                        </a>
                    </div>
                    <div class="flex items-center space-x-6">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" 
                                   class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 border-collapse text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" 
                                   class="text-gray-300 hover:text-white font-medium transition-colors duration-200">
                                    Masuk
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" 
                                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                        </svg>
                                        Daftar
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="relative z-10 text-center mt-10 pt-20 pb-32 px-4">
            <div class="max-w-5xl mx-auto">
                <div class="fade-in-up">
                    <h1 class="text-6xl md:text-7xl lg:text-8xl font-black mb-8 leading-tight">
                        <span class="gradient-text">Mulai Perjalanan</span>
                        <br>
                        <span class="text-white">Belajar Anda</span>
                    </h1>
                    <p class="text-xl md:text-2xl text-gray-300 mb-12 max-w-3xl mx-auto leading-relaxed">
                        Temukan kursus terbaik untuk meningkatkan keahlian Anda dan raih kesuksesan yang Anda impikan dengan bimbingan para ahli terpercaya.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                        <a href="{{ route('courses.index') }}" 
                           class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-500 via-blue-500 to-blue-600 hover:from-blue-600 hover:via-blue-600 hover:to-blue-700 text-white font-bold rounded-2xl shadow-2xl hover:shadow-blue-500/25 transition-all duration-300 transform hover:scale-105">
                            Jelajahi Semua Kursus
                        </a>
                        <a href="#latest-courses" 
                           class="group inline-flex items-center scroll-smooth px-8 py-4 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white font-semibold rounded-2xl border border-white/20 hover:border-white/40 transition-all duration-300 transform hover:scale-105">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                            </svg>
                            Lihat Kursus Terbaru
                        </a>
                    </div>
                </div>

                <!-- Stats Section -->
                <div class="mt-20 grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 border border-white/20 hover:bg-white/15 transition-all duration-300">
                        <div class="text-4xl font-bold text-blue-400 mb-2">Materi <br>Selalu Update</div>
                        <div class="text-gray-300">Materi Selalu Diupdate</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 border border-white/20 hover:bg-white/15 transition-all duration-300">
                        <div class="text-4xl font-bold text-white-400 mb-2">Gratis <br>Untuk Semua</div>
                        <div class="text-gray-300">Full Materi Gratis</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 border border-white/20 hover:bg-white/15 transition-all duration-300">
                        <div class="text-4xl font-bold text-cyan-400 mb-2">Akses Selamanya</div>
                        <div class="text-gray-300">Tingkat Kepuasan</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Latest Courses Section -->
        <section id="latest-courses" class="relative z-10 pb-32 px-4">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">
                        Kursus <span class="gradient-text">Terbaru</span>
                    </h2>
                    <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                        Discover our latest collection of expertly crafted courses designed to elevate your skills
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse ($latestCourses as $index => $course)
                        <div class="group bg-white/10 backdrop-blur-md rounded-3xl shadow-2xl overflow-hidden border border-white/20 hover:border-white/40 transition-all duration-500 hover:scale-105 hover:shadow-2xl hover:shadow-blue-500/10 fade-in-up" style="animation-delay: {{ $index * 0.1 }}s;">
                            <div class="relative overflow-hidden">
                                @if ($course->thumbnail)
                                    <img src="{{ asset('storage/' . $course->thumbnail) }}" 
                                         alt="{{ $course->title }}" 
                                         class="h-64 w-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="h-64 w-full bg-gradient-to-br from-slate-700 to-slate-600 flex items-center justify-center group-hover:from-slate-600 group-hover:to-slate-500 transition-all duration-500">
                                        <div class="text-center">
                                            <svg class="w-16 h-16 text-slate-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span class="text-slate-400 text-sm">Course Image</span>
                                        </div>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>

                            <div class="p-8">
                                <div class="flex items-center justify-between mb-4">
                                    @if ($course->category)
                                        <span class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-blue-500/20 to-purple-500/20 text-blue-300 text-xs font-semibold rounded-full border border-blue-500/30">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $course->category->name }}
                                        </span>
                                    @endif
                                </div>

                                <h3 class="text-xl font-bold text-white mb-3 group-hover:text-blue-300 transition-colors duration-300">
                                    {{ $course->title }}
                                </h3>

                                <div class="flex items-center text-gray-300 mb-6">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm">Oleh:</span>
                                    <a href="{{ route('instructors.show', $course->instructor) }}" 
                                       class="ml-1 font-semibold text-blue-300 hover:text-blue-200 transition-colors duration-200">
                                        {{ $course->instructor->name }}
                                    </a>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center text-gray-400 text-sm">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                        {{ $course->lessons->count() }} Pelajaran
                                    </div>
                                    <a href="{{ route('courses.show', $course) }}" 
                                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105 group">
                                        <span class="mr-2">Lihat Detail</span>
                                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-20">
                            <div class="w-24 h-24 bg-gradient-to-br from-slate-700 to-slate-600 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-white mb-4">Kursus Segera Hadir</h3>
                            <p class="text-gray-400 text-lg">Kami sedang mempersiapkan kursus-kursus terbaik untuk Anda.</p>
                        </div>
                    @endforelse
                </div>

                @if($latestCourses && $latestCourses->count() > 0)
                    <div class="text-center mt-16">
                        <a href="{{ route('courses.index') }}" 
                           class="inline-flex items-center px-8 py-4 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white font-semibold rounded-2xl border border-white/20 hover:border-white/40 transition-all duration-300 transform hover:scale-105">
                            <span class="mr-3">Lihat Semua Kursus</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                @endif
            </div>
        </section>

        <!-- Footer -->
        <footer class="relative z-10 bg-white/5 backdrop-blur-md border-t border-white/10 py-12">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <div class="flex items-center justify-center space-x-3 mb-6">
                    <span class="text-xl font-bold text-white">Di<span class="text-blue-400">Belajar</span>.In</span>
                </div>
                <p class="text-gray-400 mb-8 max-w-2xl mx-auto">
                    Platform pembelajaran online terdepan yang menghadirkan kursus berkualitas tinggi untuk mengembangkan karir dan potensi Anda.
                </p>
                <div class="text-gray-500 text-sm">
                    © {{ date('Y') }} DiBelajar.In Semua hak dilindungi. Dibuat dengan ❤️ untuk masa depan yang lebih baik.
                </div>
            </div>
        </footer>
    </div>

    <script src="/resources/js/modify.js"></script>
</body>

</html>