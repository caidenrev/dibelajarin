<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 p-6">
        <div class="w-full max-w-md bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-8 space-y-6 text-center">
            
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                ✉️ Verify Your Email
            </h1>

            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                {{ __('Thanks for signing up! Please verify your email by clicking the link we just sent you. If you didn’t receive the email, you can request another one.') }}
            </p>

            @if (session('status') == 'verification-link-sent')
                <div class="flex items-center p-3 text-green-700 dark:text-green-300 bg-green-100 dark:bg-green-800/30 rounded-lg text-sm font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                        class="h-6 w-6 mr-2 text-green-500" 
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    {{ __('A new verification link has been sent to the email address you provided.') }}
                </div>
            @endif
            
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-6">
                <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
                    @csrf
                    <x-primary-button class="w-full sm:w-auto px-6 py-2 bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md transition">
                        {{ __('Resend Email') }}
                    </x-primary-button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
                    @csrf
                    <button type="submit" 
                        class="w-full sm:w-auto px-6 py-2 rounded-xl border border-gray-300 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition text-sm shadow-sm">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
