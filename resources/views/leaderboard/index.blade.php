<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Papan Peringkat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <h3 class="text-2xl font-bold text-white mb-6 text-center">🏆 Top 10 Siswa 🏆</h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="border-b-2 border-slate-700">
                                <tr>
                                    <th class="p-3 text-lg font-semibold">Peringkat</th>
                                    <th class="p-3 text-lg font-semibold">Nama Siswa</th>
                                    <th class="p-3 text-lg font-semibold text-right">Total XP</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($topStudents as $student)
                                    <tr class="border-b border-slate-700 last:border-b-0 hover:bg-slate-700/50">
                                        <td class="p-4 text-xl font-bold w-1/4">
                                            @if ($loop->iteration <= 3)
                                                <span>{{ ['🥇', '🥈', '🥉'][$loop->iteration - 1] }}</span>
                                            @else
                                                #{{ $loop->iteration }}
                                            @endif
                                        </td>
                                        <td class="p-4 font-medium">{{ $student->name }}</td>
                                        <td class="p-4 font-bold text-sky-400 text-right">
                                            {{ number_format($student->xp) }} XP</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center p-6 text-slate-400">
                                            Belum ada data peringkat yang tersedia.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
