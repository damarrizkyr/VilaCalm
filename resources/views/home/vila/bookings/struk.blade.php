<x-app-layout>
    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen flex flex-col items-center justify-center">

        {{-- AREA STRUK (Ini yang akan ter-print) --}}
        <div id="printableArea"
            class="bg-white w-full max-w-2xl p-8 rounded-xl shadow-lg border border-gray-200 relative overflow-hidden">

            {{-- Hiasan Lingkaran (Opsional) --}}
            <div class="absolute top-0 left-0 w-full h-2 bg-indigo-600"></div>

            {{-- HEADER --}}
            <div class="flex justify-between items-start mb-8 border-b border-dashed border-gray-200 pb-6">
                <div>
                    <h1 class="text-2xl font-extrabold text-indigo-700 flex items-center gap-2">
                        <img src="{{ asset('images/icon-app.png') }}" alt="VilaCalm Icon" class="w-12 h-12">

                        VilaCalm
                    </h1>
                    <p class="text-xs text-gray-500 mt-1">Platform Booking Vila Terpercaya</p>
                </div>
                <div class="text-right">
                    <h2 class="text-lg font-bold text-gray-800">BUKTI PEMBAYARAN</h2>
                    <p class="text-sm text-gray-500">Kode: <span
                            class="font-mono font-bold text-black">{{ $booking->booking_code }}</span></p>
                    <div
                        class="mt-2 inline-block bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full border border-green-200">
                        LUNAS / PAID
                    </div>
                </div>
            </div>

            {{-- INFO PEMESAN & VILA --}}
            <div class="grid grid-cols-2 gap-8 mb-8">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase mb-1">Data Pemesan</p>
                    <p class="font-bold text-gray-800 text-lg">{{ $booking->user->name }}</p>
                    <p class="text-sm text-gray-600">{{ $booking->user->phone ?? '-' }}</p>
                    <p class="text-sm text-gray-600">{{ $booking->user->email }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs font-bold text-gray-400 uppercase mb-1">Detail Vila</p>
                    <p class="font-bold text-gray-800 text-lg">{{ $booking->vila->name }}</p>
                    <p class="text-sm text-gray-600">{{ $booking->vila->address }}</p>
                </div>
            </div>

            {{-- DETAIL TANGGAL --}}
            <div class="bg-gray-50 rounded-lg p-4 mb-6 border border-gray-100">
                <div class="grid grid-cols-3 gap-4 text-center divide-x divide-gray-200">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Check-In</p>
                        <p class="font-bold text-gray-800">
                            {{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Durasi</p>
                        <p class="font-bold text-indigo-600">{{ $booking->total_days }} Malam</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Check-Out</p>
                        <p class="font-bold text-gray-800">
                            {{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            {{-- RINCIAN HARGA --}}
            <div class="mb-8">
                <p class="text-xs font-bold text-gray-400 uppercase mb-3 border-b border-gray-200 pb-2">Rincian
                    Pembayaran</p>

                <div class="flex justify-between items-center mb-2 text-sm text-gray-600">
                    <span>Harga Sewa (x {{ $booking->total_days }} malam)</span>
                    <span>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center mb-2 text-sm text-gray-600">
                    <span>Biaya Layanan</span>
                    <span>Rp 0</span>
                </div>
                <div class="flex justify-between items-center mb-4 text-sm text-gray-600">
                    <span>Jumlah Tamu</span>
                    <span>{{ $booking->guest_count }} Orang</span>
                </div>

                <div class="flex justify-between items-center pt-4 border-t-2 border-dashed border-gray-200">
                    <span class="text-lg font-bold text-gray-800">TOTAL DIBAYAR</span>
                    <span class="text-2xl font-extrabold text-indigo-700">Rp
                        {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- FOOTER --}}
            <div class="text-center text-xs text-gray-400 mt-12">
                <p>Terima kasih telah menggunakan VilaCalm.</p>
                <p>Simpan struk ini sebagai bukti pembayaran yang sah.</p>
                <p class="mt-1 font-mono">{{ now()->format('d/m/Y H:i:s') }}</p>
            </div>
        </div>

        {{-- TOMBOL AKSI (Akan hilang saat diprint) --}}
        <div class="mt-8 flex gap-4 print:hidden">
            <a href="{{ route('home') }}"
                class="px-6 py-3 bg-gray-200 text-gray-700 font-bold rounded-xl hover:bg-gray-300 transition">
                Kembali ke Home
            </a>
            <button onclick="window.print()"
                class="px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 shadow-lg shadow-indigo-500/30 transition flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Download / Cetak Struk
            </button>
        </div>

    </div>

    {{-- CSS KHUSUS PRINT --}}
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #printableArea,
            #printableArea * {
                visibility: visible;
            }

            #printableArea {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                box-shadow: none;
                border: none;
            }

            /* Hilangkan elemen layout default (Navbar/Sidebar) */
            nav,
            aside,
            footer {
                display: none !important;
            }
        }
    </style>
</x-app-layout>
