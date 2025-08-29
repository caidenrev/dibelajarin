<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $course->title }}
            </h2>

            <!-- Tombol toggle sidebar (Mobile & Desktop) -->
            <button id="toggleSidebar" 
                class="bg-sky-500 hover:bg-sky-600 text-white px-3 py-2 rounded-lg">
                Menu
            </button>
        </div>
    </x-slot>

    @php
        $totalLessons = $allLessons->count();
        $completedLessons = auth()->user()->completedLessons->where('course_id', $course->id)->count();
        $progress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
    @endphp

    <div class="relative">
        <!-- Sidebar overlay -->
        <div id="sidebarOverlay" 
            class="hidden fixed inset-0 bg-black bg-opacity-50 z-40"></div>

        <!-- Sidebar -->
        <div id="sidebar"
            class="fixed top-0 left-0 h-full w-72 bg-slate-900 z-50 transform -translate-x-full transition-transform duration-300 ease-in-out shadow-lg overflow-y-auto">
            <div class="p-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-100">📖 Daftar Pelajaran</h3>
                    <button id="closeSidebar" class="text-gray-400 hover:text-white">✖</button>
                </div>

                <!-- Progress bar -->
                <div class="mb-6">
                    <div class="w-full bg-slate-700 rounded-full h-3 overflow-hidden">
                        <div class="bg-sky-500 h-3 rounded-full" style="width: {{ $progress }}%"></div>
                    </div>
                    <p class="text-sm text-gray-300 mt-2">Progress: {{ $progress }}%</p>
                </div>

                <!-- Daftar lessons -->
                <ul class="space-y-2">
                    @foreach ($allLessons as $item)
                        <li>
                            <a href="{{ route('lessons.show', [$course, $item]) }}"
                                class="flex justify-between items-center p-3 rounded-lg transition
                               {{ $item->id == $lesson->id 
                                    ? 'bg-sky-600 text-white shadow-md' 
                                    : 'bg-slate-800 text-gray-300 hover:bg-slate-700' }}">
                                <span class="truncate">{{ $loop->iteration }}. {{ $item->title }}</span>
                                @if (auth()->user()->completedLessons->contains($item))
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-1 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Konten utama -->
        <div class="p-6 max-w-7xl mx-auto">
            <div class="bg-slate-800 overflow-hidden shadow-lg sm:rounded-xl">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-3xl font-bold text-white mb-4">{{ $lesson->title }}</h1>
                    <div class="prose dark:prose-invert max-w-none">
                        {!! $lesson->content !!}
                    </div>

                    {{-- Quiz --}}
                    @if ($lesson->quiz)
                        <div class="mt-6">
                            <a href="{{ route('quizzes.show', $lesson) }}"
                                class="inline-flex items-center gap-2 bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition">
                                📝 Kerjakan Kuis
                            </a>
                        </div>
                    @endif

                    {{-- Attachment --}}
                    @if ($lesson->attachment)
                        <div class="mt-6 pt-6 border-t border-slate-700">
                            <h4 class="text-lg font-semibold text-white mb-2">📂 Materi Tambahan</h4>
                            <a href="{{ asset('storage/' . $lesson->attachment) }}" download
                                class="inline-flex items-center gap-2 bg-slate-600 hover:bg-slate-500 text-white font-bold py-2 px-4 rounded-lg shadow-md transition">
                                ⬇️ Download Materi
                            </a>
                        </div>
                    @endif

                    {{-- Selesai / Tombol lanjut --}}
                    <div class="mt-6 pt-6 border-t border-slate-700">
                        @if (auth()->user()->completedLessons->contains($lesson))
                            <div class="text-center bg-green-500 text-white font-bold py-3 px-4 rounded-lg shadow-md">
                                Pelajaran Telah Selesai ✓
                            </div>
                        @else
                            <form action="{{ route('lessons.complete', $lesson) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full text-center bg-sky-500 hover:bg-sky-600 text-white font-bold py-3 px-4 rounded-lg shadow-md transition">
                                    Tandai Selesai & Lanjutkan
                                </button>
                            </form>
                        @endif
                    </div>

                    {{-- Diskusi --}}
                    <div class="mt-8 pt-6 border-t border-slate-700">
                        <h3 class="text-xl font-bold text-white mb-4">💬 Diskusi</h3>
                        {{-- Form komentar --}}
                        <div class="mb-6">
                            <form action="{{ route('comments.store', $lesson) }}" method="POST">
                                @csrf
                                <textarea name="content" rows="3" placeholder="Tulis pertanyaan atau komentar Anda..."
                                    class="w-full bg-slate-900 border-slate-600 text-white rounded-md focus:ring-sky-500 focus:border-sky-500"></textarea>
                                <button type="submit"
                                    class="mt-2 bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition">Kirim</button>
                            </form>
                        </div>

                        {{-- List komentar --}}
                        <div class="space-y-6">
                            @forelse ($lesson->comments as $comment)
                                <div class="flex items-start gap-3">
                                    <div
                                        class="h-10 w-10 bg-slate-600 rounded-full flex items-center justify-center font-bold text-white">
                                        {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                    </div>
                                    <div class="flex-1 bg-slate-700 rounded-lg p-3">
                                        <div class="flex items-baseline justify-between">
                                            <p class="font-semibold text-white">{{ $comment->user->name }}</p>
                                            <p class="text-xs text-gray-400">
                                                {{ $comment->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        <p class="mt-1 text-gray-300">{{ $comment->content }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-400 text-center">Belum ada komentar. Jadilah yang pertama!</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script toggle sidebar -->
    <script>
        const toggleSidebar = document.getElementById('toggleSidebar');
        const closeSidebar = document.getElementById('closeSidebar');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        }
        function hideSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }

        toggleSidebar.addEventListener('click', openSidebar);
        closeSidebar.addEventListener('click', hideSidebar);
        overlay.addEventListener('click', hideSidebar);
    </script>
</x-app-layout>
