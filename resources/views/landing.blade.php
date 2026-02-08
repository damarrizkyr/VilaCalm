<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>VilaCalm - Booking Vila Impian Anda</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Script Pencegah Flash (Wajib ada di Head) --}}
    <script>
        if (localStorage.getItem('dark-mode') === 'true' || (!('dark-mode' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

{{-- REVISI DISINI: Logic dipindah ke body --}}

<body class="antialiased bg-white dark:bg-gray-900 transition-colors duration-300" x-data="{
    darkMode: localStorage.getItem('dark-mode') === 'true',
    sidebarOpen: false,
    toggleTheme() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('dark-mode', this.darkMode);
        if (this.darkMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
}">

    <nav
        class="fixed w-full z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-2">
                        <img src="{{ asset('images/icon-app.png') }}" alt="VilaCalm Icon" class="w-12 h-12">
                        <span class="text-xl font-bold text-gray-900 dark:text-white">VilaCalm</span>
                    </a>
                </div>



                <div class="flex items-center space-x-4">

                    <button @click="toggleTheme()"
                        class="p-2 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                        </svg>
                        <svg x-show="darkMode" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/home') }}"
                                class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}"
                                class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">Masuk</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 rounded-lg transition">Daftar</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <section class="pt-32 pb-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <h1 class="text-5xl md:text-6xl font-bold text-gray-900 dark:text-white leading-tight">
                        Temukan Vila <span class="text-indigo-600 dark:text-indigo-400">Impian</span> Anda
                    </h1>
                    <p class="text-xl text-gray-600 dark:text-gray-400">
                        Booking vila dengan mudah dan cepat. Nikmati liburan sempurna bersama keluarga di destinasi
                        favorit Anda.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('register') }}"
                            class="px-8 py-4 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white font-medium rounded-lg text-center transition shadow-lg hover:shadow-xl">
                            Mulai Booking
                        </a>
                        <a href="#features"
                            class="px-8 py-4 bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-900 dark:text-white font-medium rounded-lg text-center transition">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>

                    <div class="grid grid-cols-3 gap-6 pt-8">
                        <div>
                            <div class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">500+</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Vila Tersedia</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">50+</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Destinasi</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">10K+</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Pelanggan Puas</div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div
                        class="aspect-square rounded-2xl bg-gradient-to-br from-indigo-400 to-purple-500 dark:from-indigo-600 dark:to-purple-700 opacity-20 absolute inset-0 blur-3xl">
                    </div>
                    <img src="https://images.unsplash.com/photo-1564501049412-61c2a3083791?w=800&q=80" alt="Villa"
                        class="relative rounded-2xl shadow-2xl w-full h-full object-cover">
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="py-20 bg-gray-50 dark:bg-gray-800 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Mengapa Memilih VilaCalm?</h2>
                <p class="text-xl text-gray-600 dark:text-gray-400">Kemudahan dan kenyamanan dalam satu platform</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white dark:bg-gray-900 p-8 rounded-xl shadow-lg hover:shadow-xl transition">
                    <div
                        class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Pencarian Mudah</h3>
                    <p class="text-gray-600 dark:text-gray-400">Temukan vila sesuai budget, lokasi, dan fasilitas yang
                        Anda inginkan dengan filter canggih.</p>
                </div>

                <div class="bg-white dark:bg-gray-900 p-8 rounded-xl shadow-lg hover:shadow-xl transition">
                    <div
                        class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Pembayaran Aman</h3>
                    <p class="text-gray-600 dark:text-gray-400">Transaksi terjamin aman dengan berbagai metode
                        pembayaran yang tersedia.</p>
                </div>

                <div class="bg-white dark:bg-gray-900 p-8 rounded-xl shadow-lg hover:shadow-xl transition">
                    <div
                        class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Support 24/7</h3>
                    <p class="text-gray-600 dark:text-gray-400">Tim customer service kami siap membantu Anda kapan
                        saja, di mana saja.</p>
                </div>

                <div class="bg-white dark:bg-gray-900 p-8 rounded-xl shadow-lg hover:shadow-xl transition">
                    <div
                        class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Vila Terverifikasi</h3>
                    <p class="text-gray-600 dark:text-gray-400">Semua vila telah melalui proses verifikasi untuk
                        memastikan kualitas terbaik.</p>
                </div>

                <div class="bg-white dark:bg-gray-900 p-8 rounded-xl shadow-lg hover:shadow-xl transition">
                    <div
                        class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Harga Terbaik</h3>
                    <p class="text-gray-600 dark:text-gray-400">Dapatkan penawaran harga terbaik dan promo menarik
                        setiap bulannya.</p>
                </div>

                <div class="bg-white dark:bg-gray-900 p-8 rounded-xl shadow-lg hover:shadow-xl transition">
                    <div
                        class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Booking Instan</h3>
                    <p class="text-gray-600 dark:text-gray-400">Proses booking cepat tanpa ribet, konfirmasi langsung
                        ke email Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="destinations" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Destinasi Populer</h2>
                <p class="text-xl text-gray-600 dark:text-gray-400">Jelajahi vila terbaik di berbagai destinasi favorit
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="group cursor-pointer">
                    <div class="relative overflow-hidden rounded-xl mb-4">
                        <img src="https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=600&q=80" alt="Bali"
                            class="w-full h-64 object-cover transform group-hover:scale-110 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 text-white">
                            <h3 class="text-2xl font-bold">Bali</h3>
                            <p class="text-sm">150+ Vila Tersedia</p>
                        </div>
                    </div>
                </div>

                <div class="group cursor-pointer">
                    <div class="relative overflow-hidden rounded-xl mb-4">
                        <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=600&q=80"
                            alt="Lombok"
                            class="w-full h-64 object-cover transform group-hover:scale-110 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 text-white">
                            <h3 class="text-2xl font-bold">Lombok</h3>
                            <p class="text-sm">80+ Vila Tersedia</p>
                        </div>
                    </div>
                </div>

                <div class="group cursor-pointer">
                    <div class="relative overflow-hidden rounded-xl mb-4">
                        <img src="https://images.unsplash.com/photo-1506929562872-bb421503ef21?w=600&q=80"
                            alt="Bandung"
                            class="w-full h-64 object-cover transform group-hover:scale-110 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 text-white">
                            <h3 class="text-2xl font-bold">Bandung</h3>
                            <p class="text-sm">120+ Vila Tersedia</p>
                        </div>
                    </div>
                </div>

                <div class="group cursor-pointer">
                    <div class="relative overflow-hidden rounded-xl mb-4">
                        <img src="https://images.unsplash.com/photo-1555400038-63f5ba517a47?w=600&q=80" alt="Puncak"
                            class="w-full h-64 object-cover transform group-hover:scale-110 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 text-white">
                            <h3 class="text-2xl font-bold">Puncak</h3>
                            <p class="text-sm">90+ Vila Tersedia</p>
                        </div>
                    </div>
                </div>

                <div class="group cursor-pointer">
                    <div class="relative overflow-hidden rounded-xl mb-4">
                        <img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=600&q=80"
                            alt="Malang"
                            class="w-full h-64 object-cover transform group-hover:scale-110 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 text-white">
                            <h3 class="text-2xl font-bold">Malang</h3>
                            <p class="text-sm">70+ Vila Tersedia</p>
                        </div>
                    </div>
                </div>

                <div class="group cursor-pointer">
                    <div class="relative overflow-hidden rounded-xl mb-4">
                        <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=600&q=80"
                            alt="Yogyakarta"
                            class="w-full h-64 object-cover transform group-hover:scale-110 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 text-white">
                            <h3 class="text-2xl font-bold">Yogyakarta</h3>
                            <p class="text-sm">60+ Vila Tersedia</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="testimonials" class="py-20 bg-gray-50 dark:bg-gray-800 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Apa Kata Mereka?</h2>
                <p class="text-xl text-gray-600 dark:text-gray-400">Testimoni dari pelanggan yang puas</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white dark:bg-gray-900 p-8 rounded-xl shadow-lg">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">"Pengalaman booking yang sangat mudah dan cepat.
                        Vilanya sesuai dengan foto dan deskripsi. Highly recommended!"</p>
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold">
                            A</div>
                        <div class="ml-3">
                            <div class="font-semibold text-gray-900 dark:text-white">Andi Pratama</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Jakarta</div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-900 p-8 rounded-xl shadow-lg">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">"Customer service sangat responsif dan membantu.
                        Vila yang saya booking sangat bersih dan nyaman untuk keluarga."</p>
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold">
                            S</div>
                        <div class="ml-3">
                            <div class="font-semibold text-gray-900 dark:text-white">Siti Nurhaliza</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Bandung</div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-900 p-8 rounded-xl shadow-lg">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">"Proses pembayaran aman dan mudah. Liburan
                        keluarga jadi lebih menyenangkan dengan vila dari VillaBook!"</p>
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center text-white font-bold">
                            B</div>
                        <div class="ml-3">
                            <div class="font-semibold text-gray-900 dark:text-white">Budi Santoso</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Surabaya</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-700 dark:to-purple-700 rounded-2xl p-12 text-center">
                <h2 class="text-4xl font-bold text-white mb-4">Siap Merencanakan Liburan Impian Anda?</h2>
                <p class="text-xl text-indigo-100 mb-8">Daftar sekarang dan dapatkan diskon 10% untuk booking pertama
                    Anda!</p>
                <a href="{{ route('register') }}"
                    class="inline-block px-8 py-4 bg-white text-indigo-600 font-medium rounded-lg hover:bg-gray-100 transition shadow-lg hover:shadow-xl">
                    Daftar Sekarang
                </a>
            </div>
        </div>
    </section>

    <footer id="contact" class="bg-gray-900 dark:bg-gray-950 text-gray-300 py-12 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <img src="{{ asset('images/icon-app.png') }}" alt="VilaCalm Icon" class="w-12 h-12">

                        <span class="text-xl font-bold text-white">VilaCalm</span>
                    </div>
                    <p class="text-sm">Platform booking vila terpercaya di Indonesia. Temukan vila impian Anda dengan
                        mudah.</p>
                </div>

                <div>
                    <h4 class="font-bold text-white mb-4">Perusahaan</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#features" class="hover:text-indigo-400 transition">Fitur</a></li>
                        <li><a href="#destinations" class="hover:text-indigo-400 transition">Destinasi</a></li>
                        <li><a href="#testimonials" class="hover:text-indigo-400 transition">Testimoni</a></li>
                        <li><a href="#contact" class="hover:text-indigo-400 transition">Kontak</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-white mb-4">Bantuan</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-indigo-400 transition">Pusat Bantuan</a></li>
                        <li><a href="#" class="hover:text-indigo-400 transition">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="hover:text-indigo-400 transition">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-indigo-400 transition">FAQ</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-bold text-white mb-6">Hubungi Kami</h4>
                    <ul class="space-y-4 text-gray-400">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-indigo-800-500 mt-1 mr-3 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span class="text-sm leading-relaxed">info@vilacalm.id</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-indigo-800-500 mt-1 mr-3 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                            <span class="text-sm leading-relaxed">(+62) xxx-xxx-xxx</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-indigo-800-500 mt-1 mr-3 flex-shrink-0" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span class="text-sm leading-relaxed">Jl.xxx, Deli Serdang, Indonesia</span>
                        </li>
                    </ul>
                </div>


            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm">
                <p>&copy; {{ date('Y') }} VilaCalm. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>

</html>
