<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 px-4 py-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Header Section -->
            <div class="text-center">
                <div class="mx-auto h-16 w-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center mb-6 shadow-lg">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    {{ __('Verify Your Email') }}
                </h2>
                <p class="text-gray-600 dark:text-gray-300 text-sm">
                    {{ __('We\'re almost there! Just one more step.') }}
                </p>
            </div>

            <!-- Main Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 p-8 space-y-6">
                <!-- Description -->
                <div class="text-center space-y-4">
                    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-6 border border-blue-100 dark:border-blue-800">
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                        </p>
                    </div>
                </div>

                <!-- Success Message -->
                @if (session('status') == 'verification-link-sent')
                    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-4 animate-pulse">
                        <div class="flex items-center space-x-3">
                            <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="text-green-800 dark:text-green-200 font-medium text-sm">
                                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="space-y-4 sm:space-y-0 sm:flex sm:items-center sm:justify-between sm:space-x-4">
                    <!-- Resend Email Form -->
                    <form method="POST" action="{{ route('verification.send') }}" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-blue-500/50 dark:focus:ring-blue-400/50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            {{ __('Resend Verification Email') }}
                        </button>
                    </form>

                    <!-- Logout Form -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-xl shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-gray-500/50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>

                <!-- Help Section -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                    <div class="text-center">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">
                            {{ __('Having trouble? Check your spam folder or contact support.') }}
                        </p>
                        <div class="flex items-center justify-center space-x-4 text-xs text-gray-400 dark:text-gray-500">
                            <span class="flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"></path>
                                </svg>
                                {{ __('Secure') }}
                            </span>
                            <span class="flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                {{ __('Quick Process') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center">
                <p class="text-xs text-gray-400 dark:text-gray-500">
                    {{ __('This link will expire in 24 hours for security reasons.') }}
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>