<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    {{-- Script untuk Chart.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 sm:space-y-8">

            {{-- Bagian Statistik - Responsive Grid --}}
            <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-6">
                {{-- Card 1: Courses Enrolled --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg relative overflow-hidden transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl">
                    <div class="p-3 sm:p-6 pb-12 sm:pb-14 relative z-10">
                        <div class="flex items-start justify-between">
                            <h4 class="text-xs sm:text-sm font-medium uppercase text-gray-500 dark:text-gray-400 tracking-wider">Courses Enrolled</h4>
                            <div class="bg-indigo-500/10 text-indigo-500 rounded-lg p-1.5 sm:p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v11.494m-9-5.747h18" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-2xl sm:text-4xl font-bold text-gray-800 dark:text-gray-200 mt-1 sm:mt-2">{{ $coursesEnrolled }}</h3>
                    </div>
                    <div class="absolute bottom-0 inset-x-0">
                        <canvas id="chart1" height="50"></canvas>
                    </div>
                </div>

                {{-- Card 2: Lessons Completed --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg relative overflow-hidden transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl">
                    <div class="p-3 sm:p-6 pb-12 sm:pb-14 relative z-10">
                        <div class="flex items-start justify-between">
                            <h4 class="text-xs sm:text-sm font-medium uppercase text-gray-500 dark:text-gray-400 tracking-wider">Lessons Completed</h4>
                             <div class="bg-pink-500/10 text-pink-500 rounded-lg p-1.5 sm:p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-2xl sm:text-4xl font-bold text-gray-800 dark:text-gray-200 mt-1 sm:mt-2">{{ $lessonsCompleted }}</h3>
                    </div>
                    <div class="absolute bottom-0 inset-x-0">
                        <canvas id="chart2" height="50"></canvas>
                    </div>
                </div>

                {{-- Card 3: XP Earned --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg relative overflow-hidden transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl col-span-2 lg:col-span-1">
                    <div class="p-3 sm:p-6 pb-12 sm:pb-14 relative z-10">
                        <div class="flex items-start justify-between">
                            <h4 class="text-xs sm:text-sm font-medium uppercase text-gray-500 dark:text-gray-400 tracking-wider">XP Earned</h4>
                            <div class="bg-orange-500/10 text-orange-500 rounded-lg p-1.5 sm:p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-2xl sm:text-4xl font-bold text-gray-800 dark:text-gray-200 mt-1 sm:mt-2">{{ $totalXp }}</h3>
                    </div>
                    <div class="absolute bottom-0 inset-x-0">
                        <canvas id="chart3" height="50"></canvas>
                    </div>
                </div>
            </div>

            {{-- Form Section - Responsive Layout --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                {{-- Profile Information Form - Full width on mobile, 2 columns on large screens --}}
                <div class="lg:col-span-2">
                     <div class="p-4 sm:p-6 lg:p-8 bg-white dark:bg-gray-800 shadow-xl rounded-xl border border-gray-100 dark:border-gray-700/50 h-full">
                        <div class="max-w-none">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>

                {{-- Right Column - Password & Delete Forms --}}
                <div class="space-y-6 lg:col-span-1">
                    {{-- Update Password Form --}}
                    <div class="p-4 sm:p-6 lg:p-8 bg-white dark:bg-gray-800 shadow-xl rounded-xl border border-gray-100 dark:border-gray-700/50">
                        <div class="max-w-none">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                    
                    {{-- Delete Account Form --}}
                    <div class="p-4 sm:p-6 lg:p-8 bg-white dark:bg-gray-800/50 dark:border dark:border-red-500/30 shadow-xl rounded-xl border border-red-100 dark:border-red-500/30 bg-gradient-to-br from-red-50/50 to-white dark:from-red-900/10 dark:to-gray-800">
                        <div class="max-w-none">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    {{-- JavaScript Chart --}}
    <script>
        const chartOptions = {
            maintainAspectRatio: false,
            legend: { display: false },
            tooltips: { enabled: false },
            elements: { point: { radius: 0 } },
            scales: {
                xAxes: [{ gridLines: false, scaleLabel: false, ticks: { display: false } }],
                yAxes: [{ gridLines: false, scaleLabel: false, ticks: { display: false, suggestedMin: 0, suggestedMax: 10 } }]
            }
        };
        
        // Responsive chart creation
        function createChart(elementId, data, color) {
            var ctx = document.getElementById(elementId).getContext('2d');
            new Chart(ctx, { 
                type: "line", 
                data: { 
                    labels: [1,2,3,4,5,6,7], 
                    datasets: [{ 
                        backgroundColor: color.bg, 
                        borderColor: color.border, 
                        borderWidth: 2, 
                        data: data,
                        tension: 0.4
                    }] 
                }, 
                options: chartOptions 
            });
        }
        
        // Initialize charts
        createChart('chart1', {!! $coursesData !!}, {
            bg: "rgba(101, 116, 205, 0.1)", 
            border: "rgba(101, 116, 205, 0.8)"
        });
        
        createChart('chart2', {!! $lessonsData !!}, {
            bg: "rgba(246, 109, 155, 0.1)", 
            border: "rgba(246, 109, 155, 0.8)"
        });
        
        createChart('chart3', {!! $xpData !!}, {
            bg: "rgba(246, 153, 63, 0.1)", 
            border: "rgba(246, 153, 63, 0.8)"
        });
    </script>
</x-app-layout>