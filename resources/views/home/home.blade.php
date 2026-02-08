<x-app-layout>
    <div class="transition-all duration-300 min-h-screen bg-gray-100 dark:bg-gray-900"
        :class="{
            'md:ml-64': sidebarOpen && '{{ Auth::user()->role }}'
            === 'admin',
            'md:ml-20': !sidebarOpen && '{{ Auth::user()->role }}'
            === 'admin'
        }">



        {{-- 2. MAIN CONTENT AREA --}}
        <main class="flex-1">
            {{-- Banner / Hero Section --}}
            <div id="home-section">

                <div class="relative overflow-hidden rounded-b-3xl shadow-lg">
                    <div class="relative h-[260px] md:h-[340px] lg:h-[400px]">
                        {{-- Background Image --}}
                        <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=1600" alt="Banner Vila"
                            class="absolute inset-0 w-full h-full object-cover">

                        {{-- Overlay --}}
                        <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-transparent"></div>

                        {{-- Content --}}
                        <div class="relative z-10 h-full flex items-center">
                            <div class="max-w-7xl mx-auto px-6 w-full">
                                <div class="max-w-xl text-white">
                                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold leading-tight mb-4">
                                        Main Bersama Teman
                                    </h1>
                                    <p class="text-sm md:text-base lg:text-lg text-gray-200 leading-relaxed">
                                        Wujudkan pengalaman liburan dan olahraga yang menyenangkan bersama orang-orang
                                        terdekat di
                                        <span class="font-semibold text-white">VilaCalm</span>.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Search & Filter Section (Menggunakan Logic Template Lama Kamu) --}}
            <div class="max-w-7xl mx-auto px-6 -mt-8 relative z-10">
                <div
                    class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700">
                    <form action="{{ route('home') }}" method="GET" id="searchForm">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                            <div class="md:col-span-4">
                                <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase">Nama
                                    Vila</label>
                                <input type="text" name="search"
                                    class="w-full rounded-xl border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    placeholder="Cari Vila..." value="{{ request('search') }}">
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase">Provinsi</label>
                                <select name="province_id" id="filterProvinceSelect"
                                    class="w-full rounded-xl border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    <option value="">Semua Provinsi</option>
                                </select>
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-xs font-semibold text-gray-400 mb-1 uppercase">Kab/Kota</label>
                                <select name="regency_id" id="filterRegencySelect"
                                    class="w-full rounded-xl border-gray-200 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    disabled>
                                    <option value="">Semua Kab/Kota</option>
                                </select>
                            </div>
                            <div class="md:col-span-2 pt-5">
                                <button type="submit"
                                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl transition shadow-lg">Cari
                                    Vila</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- 3. VILA CARDS SECTION --}}
            <div id="villas-section">

                <div class="max-w-7xl mx-auto px-6 py-12">
                    <div class="flex justify-between items-center mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center">
                            <svg class="w-6 h-6 mr-2 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                                </path>
                            </svg>
                            Vila Terbaru
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        @forelse ($vilas as $vila)
                            <div
                                class="bg-white dark:bg-gray-800 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700 group">
                                <div class="relative">
                                    <img src="{{ $vila->images->first() ? asset('storage/' . $vila->images->first()->image_path) : 'https://via.placeholder.com/400x250' }}"
                                        class="w-full h-48 object-cover group-hover:scale-105 transition duration-500">
                                    <div
                                        class="absolute top-3 right-3 bg-white/90 dark:bg-gray-900/90 px-2 py-1 rounded-lg flex items-center text-xs font-bold shadow-sm">
                                        <svg class="w-3 h-3 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        {{ $vila->average_rating }}
                                    </div>
                                </div>
                                <div class="p-5">
                                    <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-1">{{ $vila->name }}
                                    </h3>
                                    <p class="text-gray-400 text-xs flex items-center mb-3">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                        </svg>
                                        {{ $vila->address }}
                                    </p>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm line-clamp-2 mb-4">
                                        {{ Str::limit($vila->description, 60) }}</p>

                                    <div
                                        class="flex items-center justify-between border-t border-gray-50 dark:border-gray-700 pt-4 mt-auto">
                                        <div>
                                            <p class="text-[10px] text-gray-400 uppercase font-semibold">Harga</p>
                                            <p class="text-indigo-600 dark:text-indigo-400 font-bold">Rp
                                                {{ number_format($vila->price, 0, ',', '.') }}<span
                                                    class="text-[10px] font-normal text-gray-400">/mlm</span></p>
                                        </div>

                                        <a href="{{ route('vilas.show', $vila->id) }}"
                                            class="text-xs bg-indigo-600 text-white px-4 py-2 rounded-lg font-bold shadow-md hover:bg-indigo-700 transition">
                                            Lebih Detail
                                        </a>


                                    </div>
                                </div>
                            </div>
                        @empty
                            <div
                                class="col-span-full py-12 text-center bg-white dark:bg-gray-800 rounded-3xl border-2 border-dashed border-gray-200 dark:border-gray-700">
                                <p class="text-gray-400">Belum ada vila tersedia dengan kriteria tersebut.</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-12">
                        {{ $vilas->links() }}
                    </div>

                    {{-- List Review (Dinamis) --}}


                    {{-- FAQ Section --}}
                    <div class="faq-section">
                        <div class="mt-20 max-w-4xl mx-auto">
                            <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-10">Paling Sering
                                Ditanyakan (FAQ)</h2>
                            <div class="space-y-4" x-data="{ active: null }">
                                <div
                                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                                    <button @click="active = active === 1 ? null : 1"
                                        class="w-full flex justify-between items-center p-5 text-left font-semibold text-gray-700 dark:text-gray-300">
                                        Bagaimana cara memesan vila?
                                        <svg class="w-5 h-5 transition" :class="active === 1 ? 'rotate-180' : ''"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div x-show="active === 1"
                                        class="p-5 pt-0 text-gray-500 dark:text-gray-400 border-t border-gray-50 dark:border-gray-700">
                                        Pilih vila yang Anda suka, klik tombol Booking, dan ikuti instruksi pembayaran untuk
                                        konfirmasi pesanan Anda.
                                    </div>
                                </div>
                                {{-- Tambahkan FAQ Lainnya Disini --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    {{-- SCRIPT API WILAYAH (Logic Dari Template Kamu) --}}
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                // 1. UNTUK FILTER PENCARIAN (Search Form)
                window.initWilayahDropdown(
                    'filterProvinceSelect',
                    'filterRegencySelect',
                    null,
                    {
                        prov: "{{ request('province_id') }}",
                        city: "{{ request('regency_id') }}"
                    }
                );
            });
        </script>

    @endpush


</x-app-layout>
