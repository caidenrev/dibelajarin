<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-xl sm:text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Papan Peringkat') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-4 sm:py-6 lg:py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-6 sm:mb-8">
                <div class="bg-gradient-to-br from-slate-800 to-slate-700 rounded-xl sm:rounded-2xl shadow-xl p-4 sm:p-6 lg:p-8 border border-slate-600/50">
                    <div class="text-center">
                        <div class="inline-flex items-center gap-3 mb-3 sm:mb-4">
                            <div class="text-3xl sm:text-4xl lg:text-5xl">🏆</div>
                            <h3 class="text-xl sm:text-2xl lg:text-3xl font-bold text-white">Top Score Rank Student</h3>
                            <div class="text-3xl sm:text-4xl lg:text-5xl">🏆</div>
                        </div>
                        <p class="text-slate-300 text-sm sm:text-base lg:text-lg">Kompetisi sehat antar siswa berdasarkan pencapaian XP</p>
                    </div>
                </div>
            </div>

            <!-- Leaderboard Content -->
            <div class="bg-slate-800/80 backdrop-blur-sm rounded-xl sm:rounded-2xl shadow-lg border border-slate-600/30 overflow-hidden">
                <div class="p-4 sm:p-6 lg:p-8">
                    <!-- Top 3 Podium (Mobile: Stack, Desktop: Side by side) -->
                    @if($topStudents->take(3)->count() > 0)
                        <div class="mb-6 sm:mb-8">
                            <h4 class="text-lg sm:text-xl font-bold text-white mb-4 sm:mb-6 text-center">Top 3 Podium</h4>
                            
                            <!-- Desktop Podium -->
                            <div class="hidden md:flex items-end justify-center gap-4 lg:gap-8 mb-8">
                                @foreach($topStudents->take(3) as $student)
                                    @if($loop->iteration == 2) {{-- Silver (2nd place) --}}
                                        <div class="flex flex-col items-center">
                                            <div class="bg-slate-600/50 rounded-xl p-4 mb-3 min-w-[140px] text-center transform hover:scale-105 transition-all duration-200">
                                                <div class="text-4xl mb-2">🥈</div>
                                                <h5 class="font-bold text-white text-sm mb-1 truncate">{{ $student->name }}</h5>
                                                <p class="text-sky-400 font-semibold text-xs">{{ number_format($student->xp) }} XP</p>
                                            </div>
                                            <div class="bg-gradient-to-t from-slate-600 to-slate-500 w-full h-16 rounded-t-lg"></div>
                                        </div>
                                    @elseif($loop->iteration == 1) {{-- Gold (1st place) --}}
                                        <div class="flex flex-col items-center order-2">
                                            <div class="bg-gradient-to-br from-yellow-600/30 to-yellow-500/20 border border-yellow-500/30 rounded-xl p-4 mb-3 min-w-[160px] text-center transform hover:scale-105 transition-all duration-200">
                                                <div class="text-5xl mb-2">🥇</div>
                                                <h5 class="font-bold text-yellow-300 text-base mb-1 truncate">{{ $student->name }}</h5>
                                                <p class="text-sky-400 font-semibold text-sm">{{ number_format($student->xp) }} XP</p>
                                            </div>
                                            <div class="bg-gradient-to-t from-yellow-600 to-yellow-500 w-full h-24 rounded-t-lg"></div>
                                        </div>
                                    @elseif($loop->iteration == 3) {{-- Bronze (3rd place) --}}
                                        <div class="flex flex-col items-center order-3">
                                            <div class="bg-slate-700/50 rounded-xl p-4 mb-3 min-w-[140px] text-center transform hover:scale-105 transition-all duration-200">
                                                <div class="text-4xl mb-2">🥉</div>
                                                <h5 class="font-bold text-white text-sm mb-1 truncate">{{ $student->name }}</h5>
                                                <p class="text-sky-400 font-semibold text-xs">{{ number_format($student->xp) }} XP</p>
                                            </div>
                                            <div class="bg-gradient-to-t from-orange-800 to-orange-700 w-full h-12 rounded-t-lg"></div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <!-- Mobile Top 3 Cards -->
                            <div class="md:hidden space-y-3 mb-6">
                                @foreach($topStudents->take(3) as $student)
                                    <div class="flex items-center gap-4 
                                        @if($loop->iteration == 1) bg-gradient-to-r from-yellow-600/20 to-yellow-500/10 border border-yellow-500/30
                                        @elseif($loop->iteration == 2) bg-slate-600/30 border border-slate-500/30
                                        @else bg-orange-800/20 border border-orange-700/30 @endif
                                        rounded-xl p-3 sm:p-4">
                                        
                                        <div class="text-2xl sm:text-3xl flex-shrink-0">
                                            {{ ['🥇', '🥈', '🥉'][$loop->iteration - 1] }}
                                        </div>
                                        
                                        <div class="flex-1 min-w-0">
                                            <h5 class="font-bold 
                                                @if($loop->iteration == 1) text-yellow-300
                                                @else text-white @endif 
                                                text-sm sm:text-base truncate">{{ $student->name }}</h5>
                                            <p class="text-slate-400 text-xs sm:text-sm">#{{ $loop->iteration }} Posisi</p>
                                        </div>
                                        
                                        <div class="text-right flex-shrink-0">
                                            <p class="text-sky-400 font-bold text-sm sm:text-base">{{ number_format($student->xp) }}</p>
                                            <p class="text-sky-500 text-xs">XP</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Full Leaderboard Table -->
                    <div class="space-y-4 sm:space-y-6">
                        <h4 class="text-lg sm:text-xl font-bold text-white text-center">Peringkat Lengkap</h4>
                        
                        <!-- Desktop Table -->
                        <div class="hidden sm:block overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b-2 border-slate-600">
                                        <th class="text-left p-3 sm:p-4 text-slate-300 font-semibold text-sm sm:text-base">Peringkat</th>
                                        <th class="text-left p-3 sm:p-4 text-slate-300 font-semibold text-sm sm:text-base">Nama Siswa</th>
                                        <th class="text-right p-3 sm:p-4 text-slate-300 font-semibold text-sm sm:text-base">Total XP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($topStudents as $student)
                                        <tr class="border-b border-slate-700/50 hover:bg-slate-700/30 transition-colors duration-200 
                                            @if($loop->iteration <= 3) {{ $loop->iteration == 1 ? 'bg-yellow-500/5' : ($loop->iteration == 2 ? 'bg-slate-600/10' : 'bg-orange-600/5') }} @endif">
                                            <td class="p-3 sm:p-4">
                                                <div class="flex items-center gap-2 sm:gap-3">
                                                    @if ($loop->iteration <= 3)
                                                        <span class="text-xl sm:text-2xl">{{ ['🥇', '🥈', '🥉'][$loop->iteration - 1] }}</span>
                                                    @else
                                                        <div class="w-8 h-8 bg-slate-600 rounded-full flex items-center justify-center">
                                                            <span class="text-white font-bold text-sm">#{{ $loop->iteration }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="p-3 sm:p-4">
                                                <div class="font-semibold text-white text-sm sm:text-base">{{ $student->name }}</div>
                                            </td>
                                            <td class="p-3 sm:p-4 text-right">
                                                <div class="text-sky-400 font-bold text-sm sm:text-base">
                                                    {{ number_format($student->xp) }}
                                                    <span class="text-sky-500 text-xs sm:text-sm ml-1">XP</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center p-8 sm:p-12">
                                                <div class="text-slate-400">
                                                    <div class="text-4xl sm:text-6xl mb-4">📊</div>
                                                    <h5 class="text-lg sm:text-xl font-semibold mb-2">Belum Ada Data</h5>
                                                    <p class="text-sm sm:text-base">Peringkat akan muncul setelah ada aktivitas pembelajaran</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Mobile Card List -->
                        <div class="sm:hidden space-y-3">
                            @forelse ($topStudents as $student)
                                <div class="flex items-center gap-3 bg-slate-700/30 hover:bg-slate-700/50 rounded-xl p-3 transition-colors duration-200
                                    @if($loop->iteration <= 3) border-l-4 @endif
                                    @if($loop->iteration == 1) border-l-yellow-500
                                    @elseif($loop->iteration == 2) border-l-slate-400
                                    @elseif($loop->iteration == 3) border-l-orange-600 @endif">
                                    
                                    <div class="flex-shrink-0">
                                        @if ($loop->iteration <= 3)
                                            <span class="text-2xl">{{ ['🥇', '🥈', '🥉'][$loop->iteration - 1] }}</span>
                                        @else
                                            <div class="w-8 h-8 bg-slate-600 rounded-full flex items-center justify-center">
                                                <span class="text-white font-bold text-sm">#{{ $loop->iteration }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="flex-1 min-w-0">
                                        <h5 class="font-semibold text-white text-sm truncate">{{ $student->name }}</h5>
                                        <p class="text-slate-400 text-xs">Peringkat #{{ $loop->iteration }}</p>
                                    </div>
                                    
                                    <div class="text-right flex-shrink-0">
                                        <p class="text-sky-400 font-bold text-sm">{{ number_format($student->xp) }}</p>
                                        <p class="text-sky-500 text-xs">XP</p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <div class="text-slate-400">
                                        <div class="text-4xl mb-3">📊</div>
                                        <h5 class="text-lg font-semibold mb-2">Belum Ada Data</h5>
                                        <p class="text-sm">Peringkat akan muncul setelah ada aktivitas pembelajaran</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>