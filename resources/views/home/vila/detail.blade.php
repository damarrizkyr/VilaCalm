<x-app-layout>
    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- 1. GALERI FOTO --}}
            <div class="mb-8">
                @include('home.vila.image')
            </div>

            {{-- 2. GRID INFO UTAMA (ATAS) --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

                {{-- CARD KIRI: Judul, Rating, Alamat --}}
                <div
                    class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $vila->name }}</h1>

                    <div class="flex items-center space-x-4 text-sm mb-4">
                        {{-- Rating --}}
                        <div class="flex items-center bg-yellow-50 dark:bg-yellow-900/30 px-2 py-1 rounded-md">
                            <svg class="w-4 h-4 text-yellow-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                </path>
                            </svg>
                            <span class="font-bold text-gray-800 dark:text-gray-200">{{ $vila->rating ?? '0.0' }}</span>
                            <span class="text-gray-500 mx-1">•</span>
                            <span class="text-gray-500">{{ $vila->total_reviews ?? 0 }} Ulasan</span>
                        </div>

                        {{-- Alamat --}}
                        <div class="flex items-center text-gray-500 dark:text-gray-400">
                            <svg class="w-4 h-4 mr-1 text-red-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ $vila->address }}
                        </div>
                    </div>
                </div>

                {{-- CARD KANAN: Harga & Tombol Booking --}}
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col justify-center">
                    <div class="mb-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Harga Mulai</p>
                        <div class="flex items-end">
                            <h2 class="text-3xl font-extrabold text-indigo-600 dark:text-indigo-400">
                                Rp {{ number_format($vila->price, 0, ',', '.') }}
                            </h2>
                            <span class="text-gray-500 dark:text-gray-400 mb-1 ml-1 text-sm">/malam</span>
                        </div>
                    </div>

                    @auth
                        {{-- Tombol Menuju Halaman Booking --}}
                        <a href="{{ route('vilas.booking', $vila->id) }}"
                            class="block w-full bg-indigo-600 hover:bg-indigo-700 text-white text-center font-bold py-3 rounded-xl transition shadow-lg shadow-indigo-200 dark:shadow-none">
                            Booking Sekarang
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="block w-full bg-gray-200 text-gray-600 text-center font-bold py-3 rounded-xl hover:bg-gray-300 transition">
                            Login untuk Booking
                        </a>
                    @endauth
                </div>
            </div>

            {{-- 3. CARD BAWAH (FULL WIDTH) --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-sm border border-gray-100 dark:border-gray-700 space-y-10">

                {{-- Bagian A: Ulasan Pengunjung (Ringkasan) --}}
                <div id="reviews-section">
                    <div class="flex justify-between items-end mb-6">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                                Ulasan Pengunjung
                            </h3>
                            @if ($vila->total_reviews > 0)
                                <div class="flex items-center mt-2">
                                    <span
                                        class="text-4xl font-bold text-gray-900 dark:text-white mr-2">{{ $vila->rating }}</span>
                                    <span class="text-gray-500 text-sm">/ 5</span>
                                    <span class="mx-2 text-gray-300">|</span>
                                    <span class="text-gray-500 text-sm">{{ $vila->total_reviews }} review</span>
                                </div>
                            @endif
                        </div>

                        {{-- @if ($vila->total_reviews > 0)
                            <a href="#"
                                class="text-indigo-600 dark:text-indigo-400 font-bold text-sm hover:underline">Lihat
                                semua</a>
                        @endif --}}
                    </div>

                    @if ($vila->total_reviews > 0)
                        {{-- Grid Card Ulasan --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                            {{-- Loop Review --}}
                            @foreach ($vila->reviews->sortByDesc('created_at')->take(3) as $review)
                                <div
                                    class="bg-white dark:bg-gray-700 p-5 rounded-2xl border border-gray-100 dark:border-gray-600 shadow-sm hover:shadow-md transition">

                                    {{-- Header Review --}}
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex items-center">
                                            <span
                                                class="text-lg font-bold text-gray-900 dark:text-white mr-1">{{ $review->rating }}</span>
                                            <span class="text-xs text-gray-500">/ 5</span>
                                        </div>
                                        <span
                                            class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>

                                    {{-- Nama User --}}
                                    <div class="mb-3">
                                        <p class="font-bold text-sm text-gray-800 dark:text-gray-200">
                                            {{ $review->user->name ?? 'Pengguna' }}
                                        </p>
                                    </div>

                                    {{-- Komentar --}}
                                    <p class="text-gray-600 dark:text-gray-300 text-sm line-clamp-3 leading-relaxed">
                                        "{{ $review->comment }}"
                                    </p>
                                </div>
                            @endforeach

                        </div>
                    @else
                        <div
                            class="text-center py-8 bg-gray-50 dark:bg-gray-900/30 rounded-xl border border-dashed border-gray-200 dark:border-gray-700">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                </path>
                            </svg>
                            <p class="text-gray-500">Belum ada ulasan untuk vila ini.</p>
                        </div>
                    @endif
                </div>

                <hr class="border-gray-100 dark:border-gray-700">

                {{-- Bagian B: Fasilitas --}}
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-indigo-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                            </path>
                        </svg>
                        Fasilitas
                    </h3>
                    <div class="flex flex-wrap gap-3">
                        @php $facilities = $vila->facilities ? explode(',', $vila->facilities) : []; @endphp
                        @foreach ($facilities as $facility)
                            <span
                                class="bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 px-4 py-2 rounded-lg text-sm font-semibold border border-indigo-100 dark:border-indigo-800">
                                {{ trim($facility) }}
                            </span>
                        @endforeach
                        @if (count($facilities) == 0)
                            <span class="text-gray-400 text-sm">Tidak ada info fasilitas.</span>
                        @endif
                    </div>
                </div>

                <hr class="border-gray-100 dark:border-gray-700">

                {{-- Bagian C: Maps (Lokasi) --}}
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-indigo-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 7m0 13V7">
                            </path>
                        </svg>
                        Lokasi (Maps)
                    </h3>
                    <div
                        class="w-full h-64 bg-gray-200 dark:bg-gray-700 rounded-xl flex items-center justify-center overflow-hidden">
                        {{-- Embed Google Maps --}}
                        <iframe width="100%" height="100%" frameborder="0" style="border:0"
                            src="https://maps.google.com/maps?q={{ urlencode($vila->address) }}&output=embed">
                        </iframe>
                    </div>
                    <p class="mt-2 text-gray-500 text-sm"><span class="font-bold">Alamat:</span> {{ $vila->address }}
                    </p>
                </div>

                <hr class="border-gray-100 dark:border-gray-700">

                {{-- Bagian D: Deskripsi Detail --}}
                <div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-indigo-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Deskripsi
                    </h3>
                    <div class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300">
                        <p class="whitespace-pre-line leading-relaxed">{{ $vila->description }}</p>
                    </div>
                </div>

                <hr class="border-gray-100 dark:border-gray-700">

                {{-- Bagian E: Hubungi Penyewa & Beri Ulasan --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    {{-- Kontak Penyewa --}}
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Hubungi Pemilik</h3>
                        <div
                            class="bg-green-50 dark:bg-green-900/20 p-5 rounded-2xl border border-green-100 dark:border-green-800">
                            <div class="flex items-center space-x-4 mb-4">
                                <div
                                    class="w-12 h-12 bg-green-200 dark:bg-green-800 rounded-full flex items-center justify-center text-xl font-bold text-green-700 dark:text-green-200">
                                    {{ substr($vila->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 dark:text-white">{{ $vila->user->name }}</p>
                                    <p class="text-xs text-green-600 dark:text-green-400 font-medium">Verified Owner ✓
                                    </p>
                                </div>
                            </div>

                            @if ($vila->user->phone)
                                <a href="https://wa.me/{{ preg_replace('/^0/', '62', $vila->user->phone) }}?text=Halo, saya tertarik dengan vila {{ $vila->name }}"
                                    target="_blank"
                                    class="flex items-center justify-center w-full bg-green-500 hover:bg-green-600 text-white px-5 py-3 rounded-xl font-bold transition shadow-lg shadow-green-200 dark:shadow-none">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                                    </svg>
                                    WhatsApp
                                </a>
                            @else
                                <p class="text-sm text-gray-500">Nomor kontak tidak tersedia.</p>
                            @endif
                        </div>
                    </div>



                </div>
            </div>

        </div>
    </div>
</x-app-layout>
