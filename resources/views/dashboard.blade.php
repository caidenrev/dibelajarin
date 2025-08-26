{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-semibold text-white mb-6">Kursus Anda</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse ($enrolledCourses as $course)
                            <div class="bg-slate-700 rounded-lg shadow-md p-4 flex flex-col justify-between">
                                <div>
                                    <h4 class="text-lg font-semibold text-white">{{ $course->title }}</h4>

                                    <div class="mt-4">
                                        <div class="flex justify-between text-sm text-gray-300">
                                            <span>Progress</span>
                                            <span>{{ $course->completed_lessons_count }} / {{ $course->lessons_count }}
                                                Pelajaran</span>
                                        </div>
                                        <div class="w-full bg-slate-600 rounded-full h-2.5 mt-1">
                                            <div class="bg-sky-500 h-2.5 rounded-full"
                                                style="width: {{ $course->progress }}%"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-6">
                                    @if ($course->lessons->isNotEmpty())
                                        <a href="{{ route('lessons.show', [$course, $course->lessons->first()]) }}"
                                            class="w-full text-center inline-block bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 px-4 rounded">
                                            Lanjutkan Belajar
                                        </a>
                                    @else
                                        <div
                                            class="w-full text-center inline-block bg-slate-500 text-white font-bold py-2 px-4 rounded">
                                            Segera Hadir
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center text-gray-400">
                                <p>Anda belum mendaftar di kursus mana pun.</p>
                                <a href="{{ route('courses.index') }}"
                                    class="text-sky-500 hover:underline mt-2 inline-block">Jelajahi Kursus</a>
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}

<x-app-layout>
    {{-- ============================================= --}}
    {{-- KOTAK DEBUG SEMENTARA --}}
    {{-- ============================================= --}}
    <div class="pt-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-red-800 text-white rounded-lg shadow-md border-2 border-red-500">
                <h2 class="text-xl font-bold mb-4">Informasi Debug Pengguna</h2>
                @if (auth()->check())
                    <p class="text-green-400 font-bold">Status: Berhasil Login</p>
                    <pre class="mt-4 p-4 bg-slate-900 rounded-md overflow-auto text-lg">
ID:    {{ auth()->user()->id ?? 'N/A' }}
Name:  {{ auth()->user()->name ?? 'N/A' }}
Email: {{ auth()->user()->email ?? 'N/A' }}
Role:  '{{ auth()->user()->role ?? 'N/A' }}'  <-- PERHATIKAN NILAI INI
                    </pre>
                @else
                    <p class="text-yellow-400 font-bold">Status: Gagal Mendapatkan Sesi Pengguna (Tamu)</p>
                @endif
            </div>
        </div>
    </div>
    {{-- ============================================= --}}
    {{-- AKHIR KOTAK DEBUG --}}
    {{-- ============================================= --}}

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        {{-- ... (sisa kode dashboard Anda) ... --}}
    </div>
</x-app-layout>
