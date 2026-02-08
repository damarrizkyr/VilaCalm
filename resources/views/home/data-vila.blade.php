<x-app-layout>
    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header Section --}}
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Manajemen Vila</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kelola properti, pantau booking, dan cek
                        pendapatan Anda.</p>
                </div>

                <button type="button" onclick="document.getElementById('modalAddVila').showModal()"
                    class="group relative inline-flex items-center justify-center px-6 py-3 text-sm font-bold text-white transition-all duration-200 bg-indigo-600 rounded-xl hover:bg-indigo-700 hover:shadow-lg hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600">
                    <svg class="w-5 h-5 mr-2 -ml-1 transition-transform group-hover:rotate-90" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Vila Baru
                </button>
            </div>

            @if ($vilas->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($vilas as $vila)
                        <div
                            class="group bg-white dark:bg-gray-800 rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700 overflow-hidden flex flex-col h-full relative">

                            {{-- Gambar Header --}}
                            <div class="relative h-56 overflow-hidden">
                                @if ($vila->images->count() > 0)
                                    <img src="{{ asset('storage/' . $vila->images->first()->image_path) }}"
                                        class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                                @else
                                    <div
                                        class="w-full h-full bg-gray-100 dark:bg-gray-700 flex flex-col items-center justify-center text-gray-400">
                                        <svg class="w-10 h-10 mb-2 opacity-50" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <span class="text-xs font-medium">Tidak ada foto</span>
                                    </div>
                                @endif

                                {{-- Overlay Gradient --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-60">
                                </div>

                                {{-- Harga Badge --}}
                                <div class="absolute bottom-4 left-4">
                                    <p
                                        class="text-white text-xs font-medium uppercase tracking-wider opacity-90 mb-0.5">
                                        Harga Sewa</p>
                                    <p class="text-white text-xl font-bold">
                                        Rp {{ number_format($vila->price, 0, ',', '.') }}<span
                                            class="text-xs font-normal opacity-80">/malam</span>
                                    </p>
                                </div>

                                {{-- Menu Dropdown Action (Edit/Hapus) --}}
                                <div class="absolute top-4 right-4 flex space-x-2">
                                    <button onclick='openModalEdit(@json($vila))'
                                        class="bg-white/90 dark:bg-gray-800/90 text-indigo-600 p-2 rounded-lg hover:bg-white hover:text-indigo-700 transition shadow-sm backdrop-blur-sm border border-transparent hover:border-indigo-200"
                                        title="Edit Data">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button
                                        onclick="openModalDelete('{{ $vila->id }}', '{{ addslashes($vila->name) }}')"
                                        class="bg-white/90 dark:bg-gray-800/90 text-red-500 p-2 rounded-lg hover:bg-white hover:text-red-600 transition shadow-sm backdrop-blur-sm border border-transparent hover:border-red-200"
                                        title="Hapus Data">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            {{-- Konten Body --}}
                            <div class="p-6 flex flex-col flex-grow">
                                <div class="mb-4">
                                    <a href="{{ route('vilas.show', $vila->id) }}" class="block group/link">
                                        <h3
                                            class="text-xl font-bold text-gray-900 dark:text-white mb-2 line-clamp-1 group-hover/link:text-indigo-600 transition-colors">
                                            {{ $vila->name }}
                                            <span
                                                class="inline-block ml-1 opacity-0 group-hover/link:opacity-100 transition-opacity text-indigo-500">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                                    </path>
                                                </svg>
                                            </span>
                                        </h3>
                                    </a>
                                    <div class="flex items-start text-gray-500 dark:text-gray-400 text-sm">
                                        <svg class="w-4 h-4 mt-0.5 mr-2 shrink-0 text-gray-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span class="line-clamp-2">{{ $vila->address }}</span>
                                    </div>
                                </div>

                                {{-- Statistik Mini (Opsional) --}}
                                <div
                                    class="grid grid-cols-2 gap-4 mb-6 border-t border-b border-gray-100 dark:border-gray-700 py-3">
                                    <div class="text-center border-r border-gray-100 dark:border-gray-700">
                                        <span class="block text-xs font-semibold text-gray-400 uppercase">Booking</span>
                                        <span
                                            class="block text-lg font-bold text-gray-900 dark:text-white">{{ $vila->bookings->count() }}</span>
                                    </div>
                                    <div class="text-center">
                                        <span class="block text-xs font-semibold text-gray-400 uppercase">Rating</span>
                                        <div
                                            class="flex items-center justify-center text-lg font-bold text-gray-900 dark:text-white">
                                            <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                </path>
                                            </svg>
                                            {{ $vila->rating ?? '0.0' }}
                                        </div>
                                    </div>
                                </div>

                                {{-- Tombol Detail (Full Width) --}}
                                <div class="mt-auto">
                                    <a href="{{ route('admin.vilas.show', $vila->id) }}"
                                        class="flex items-center justify-center w-full bg-gray-50 hover:bg-indigo-50 dark:bg-gray-700/50 dark:hover:bg-indigo-900/30 border border-gray-200 dark:border-gray-600 hover:border-indigo-200 dark:hover:border-indigo-700 text-gray-700 dark:text-gray-200 hover:text-indigo-700 dark:hover:text-indigo-300 font-bold py-3 px-4 rounded-xl transition-all duration-200 group-hover:shadow-md">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                            </path>
                                        </svg>
                                        Laporan & Keuangan
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-10">
                    {{ $vilas->links() }}
                </div>
            @else
                {{-- State Kosong --}}
                <div
                    class="flex flex-col items-center justify-center py-20 bg-white dark:bg-gray-800 rounded-3xl border-2 border-dashed border-gray-200 dark:border-gray-700">
                    <div
                        class="w-20 h-20 bg-indigo-50 dark:bg-indigo-900/30 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-10 h-10 text-indigo-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Belum ada properti</h3>
                    <p class="text-gray-500 dark:text-gray-400 text-center max-w-sm mb-6">Mulai sewakan vila Anda
                        sekarang dan jangkau jutaan penyewa potensial.</p>
                    <button onclick="document.getElementById('modalAddVila').showModal()"
                        class="text-indigo-600 font-bold hover:text-indigo-700 underline">
                        Tambah Vila Pertama
                    </button>
                </div>
            @endif
        </div>
    </div>


    @include('home.crud.edit')
    @include('home.crud.deleted')
    @include('home.crud.add')

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                window.initWilayahDropdown('modalProvinceSelect', 'modalRegencySelect', null);
                window.initWilayahDropdown('editProvinceSelect', 'editRegencySelect', null);
            });
        </script>
    @endpush
</x-app-layout>
