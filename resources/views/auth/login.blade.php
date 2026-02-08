<x-guest-layout>
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto lg:py-0">

        {{-- Header / Logo --}}
        <div class="mb-6 text-center">
            <a href="/"
                class="flex items-center justify-center gap-2 mb-2 text-2xl font-bold text-gray-900 dark:text-white">
                <img src="{{ asset('images/icon-app.png') }}" alt="VilaCalm Icon" class="w-12 h-12">

                <span>Vilacalm</span>
            </a>
            <p class="text-sm text-gray-500 dark:text-gray-400">Masuk untuk mengelola liburan Anda</p>
        </div>

        {{-- Card Container --}}
        <div
            class="w-full bg-white rounded-2xl shadow-xl dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700 border border-gray-100">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Sign in ke akun Anda
                </h1>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-4 md:space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                            </div>
                            {{-- TYPE TEXT AGAR BISA INPUT USERNAME --}}
                            <input type="email" name="email" id="email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-indigo-600 focus:border-indigo-600 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="nama@email.com" required autofocus autocomplete="username"
                                value="{{ old('email') }}">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="password" name="password" id="password" placeholder="••••••••"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-indigo-600 focus:border-indigo-600 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required autocomplete="current-password">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="remember_me" name="remember" type="checkbox"
                                    class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-indigo-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-indigo-600 dark:ring-offset-gray-800">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="remember_me" class="text-gray-500 dark:text-gray-300">Ingat saya</label>
                            </div>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-sm font-medium text-indigo-600 hover:underline dark:text-indigo-400">Lupa
                                password?</a>
                        @endif
                    </div>

                    <button type="submit"
                        class="w-full text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-bold rounded-xl text-sm px-5 py-3 text-center dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800 transition transform hover:-translate-y-0.5 shadow-lg shadow-indigo-500/30">
                        Masuk Sekarang
                    </button>

                    <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                        Belum punya akun? <a href="{{ route('register') }}"
                            class="font-medium text-indigo-600 hover:underline dark:text-indigo-500">Daftar disini</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
