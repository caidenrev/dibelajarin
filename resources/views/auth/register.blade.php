<x-app-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-900 via-gray-800 to-blue-900">
        <div class="max-w-4xl w-full bg-gray-800/80 shadow-2xl rounded-2xl flex flex-col lg:flex-row overflow-hidden">
            
            {{-- Bagian kiri (Form Register) --}}
            <div class="w-full lg:w-1/2 p-8 lg:p-12 flex flex-col justify-center">
                <div class="text-center">
                    {{-- Branding teks --}}
                    <h1 class="mx-auto text-4xl font-extrabold text-blue-400 tracking-wide">
                        DiBelajar.<span class="text-white">In</span>
                    </h1>

                    <h2 class="mt-6 text-3xl font-bold text-white">Please Register</h2>
                    <p class="mt-2 text-blue-300">Create your account to start learning</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-6">
                    @csrf

                    {{-- Name --}}
                    <div>
                        <x-input-label for="name" :value="__('Name')" class="text-gray-300" />
                        <x-text-input id="name"
                            class="block mt-2 w-full rounded-lg bg-gray-900 border border-gray-700 
                                   text-gray-100 placeholder-gray-400 
                                   focus:border-blue-500 focus:ring focus:ring-blue-500"
                            type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400" />
                    </div>

                    {{-- Email --}}
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-gray-300" />
                        <x-text-input id="email"
                            class="block mt-2 w-full rounded-lg bg-gray-900 border border-gray-700 
                                   text-gray-100 placeholder-gray-400 
                                   focus:border-blue-500 focus:ring focus:ring-blue-500"
                            type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
                    </div>

                    {{-- Password --}}
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="text-gray-300" />
                        <x-text-input id="password"
                            class="block mt-2 w-full rounded-lg bg-gray-900 border border-gray-700 
                                   text-gray-100 placeholder-gray-400 
                                   focus:border-blue-500 focus:ring focus:ring-blue-500"
                            type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-300" />
                        <x-text-input id="password_confirmation"
                            class="block mt-2 w-full rounded-lg bg-gray-900 border border-gray-700 
                                   text-gray-100 placeholder-gray-400 
                                   focus:border-blue-500 focus:ring focus:ring-blue-500"
                            type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400" />
                    </div>

                    {{-- Submit --}}
                    <div>
                        <button type="submit"
                            class="w-full flex justify-center items-center py-3 px-4 
                                   bg-blue-600 hover:bg-blue-700 
                                   text-white font-semibold rounded-lg shadow-lg transition">
                            {{ __('Register') }}
                        </button>
                    </div>

                    {{-- Link ke Login --}}
                    @if (Route::has('login'))
                        <p class="mt-4 text-center text-sm text-gray-400">
                            {{ __("Already have an account?") }}
                            <a href="{{ route('login') }}" 
                               class="text-blue-400 hover:text-blue-300 font-semibold">
                                {{ __('Log in here') }}
                            </a>
                        </p>
                    @endif
                </form>
            </div>

            {{-- Bagian kanan (ilustrasi / hanya di desktop) --}}
            <div class="hidden lg:flex lg:w-1/2 bg-blue-700 items-center justify-center p-10">
                <div class="w-full h-full bg-cover bg-center rounded-xl shadow-inner"
                     style="background-image: url('https://storage.googleapis.com/devitary-image-host.appspot.com/15848031292911696601-undraw_designer_life_w96d.svg');">
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
