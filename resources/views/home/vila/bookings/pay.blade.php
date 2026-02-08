{{-- MODAL PEMBAYARAN (POP UP) --}}
<div x-show="showPaymentModal" style="display: none;" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-[999] flex items-center justify-center bg-black/80 backdrop-blur-sm p-4">

    {{-- Card Modal --}}
    <div class="bg-white dark:bg-gray-800 w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden transform transition-all max-h-[90vh] flex flex-col"
        @click.outside="closePaymentModal()">

        {{-- Header Modal (Total Harga) --}}
        <div class="bg-indigo-600 p-6 text-white text-center relative shrink-0">
            <button @click="closePaymentModal()"
                class="absolute top-4 right-4 text-white/70 hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <p class="text-sm opacity-90 mb-1 font-medium">Total Pembayaran</p>
            {{-- Mengambil data dari variable bookingData di parent --}}
            <h2 class="text-3xl font-extrabold tracking-tight" x-text="formatRupiah(bookingData.total_price)"></h2>
            <div class="mt-3 flex justify-center items-center space-x-2">
                <span class="text-xs bg-indigo-500/50 px-3 py-1 rounded-full border border-indigo-400">
                    Kode: <span x-text="bookingData.booking_code" class="font-mono font-bold"></span>
                </span>
            </div>
        </div>

        {{-- Body Modal (Scrollable jika konten panjang) --}}
        <div class="p-6 overflow-y-auto custom-scrollbar">
            <h3 class="font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                    </path>
                </svg>
                Pilih Metode Pembayaran
            </h3>

            {{-- Group: E-Wallet --}}
            <p class="text-xs font-semibold text-gray-500 uppercase mb-2 mt-2">E-Wallet (Instan)</p>
            <div class="space-y-3 mb-6">
                {{-- GoPay --}}
                <label
                    class="flex items-center justify-between p-3 border border-gray-200 dark:border-gray-600 rounded-xl cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition group">
                    <div class="flex items-center">
                        <input type="radio" name="payment_method" value="gopay"
                            class="w-4 h-4 text-indigo-600 focus:ring-indigo-500" checked>
                        <span
                            class="ml-3 font-medium text-gray-900 dark:text-white text-sm group-hover:text-indigo-600 transition">GoPay</span>
                    </div>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/8/86/Gopay_logo.svg"
                        class="h-6 w-auto object-contain" alt="GoPay">
                </label>

                {{-- OVO --}}
                <label
                    class="flex items-center justify-between p-3 border border-gray-200 dark:border-gray-600 rounded-xl cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition group">
                    <div class="flex items-center">
                        <input type="radio" name="payment_method" value="ovo"
                            class="w-4 h-4 text-indigo-600 focus:ring-indigo-500">
                        <span
                            class="ml-3 font-medium text-gray-900 dark:text-white text-sm group-hover:text-indigo-600 transition">OVO</span>
                    </div>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/e/eb/Logo_ovo_purple.svg"
                        class="h-5 w-auto object-contain" alt="OVO">
                </label>

                {{-- Dana --}}
                <label
                    class="flex items-center justify-between p-3 border border-gray-200 dark:border-gray-600 rounded-xl cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition group">
                    <div class="flex items-center">
                        <input type="radio" name="payment_method" value="dana"
                            class="w-4 h-4 text-indigo-600 focus:ring-indigo-500">
                        <span
                            class="ml-3 font-medium text-gray-900 dark:text-white text-sm group-hover:text-indigo-600 transition">Dana</span>
                    </div>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/7/72/Logo_dana_blue.svg"
                        class="h-5 w-auto object-contain" alt="Dana">
                </label>
            </div>

            {{-- Group: Bank Transfer --}}
            <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Transfer Bank (Cek Manual)</p>
            <div class="space-y-3 mb-4">
                {{-- BCA --}}
                <label
                    class="flex items-center justify-between p-3 border border-gray-200 dark:border-gray-600 rounded-xl cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition group">
                    <div class="flex items-center">
                        <input type="radio" name="payment_method" value="bca"
                            class="w-4 h-4 text-indigo-600 focus:ring-indigo-500">
                        <span
                            class="ml-3 font-medium text-gray-900 dark:text-white text-sm group-hover:text-indigo-600 transition">Bank
                            BCA</span>
                    </div>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg"
                        class="h-4 w-auto object-contain" alt="BCA">
                </label>

                {{-- Mandiri --}}
                <label
                    class="flex items-center justify-between p-3 border border-gray-200 dark:border-gray-600 rounded-xl cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition group">
                    <div class="flex items-center">
                        <input type="radio" name="payment_method" value="mandiri"
                            class="w-4 h-4 text-indigo-600 focus:ring-indigo-500">
                        <span
                            class="ml-3 font-medium text-gray-900 dark:text-white text-sm group-hover:text-indigo-600 transition">Bank
                            Mandiri</span>
                    </div>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/a/ad/Bank_Mandiri_logo_2016.svg"
                        class="h-5 w-auto object-contain" alt="Mandiri">
                </label>
            </div>
        </div>

        {{-- Footer Modal (Tombol Action) --}}
        <div class="p-6 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 shrink-0">
            <button @click="processPayment()"
                class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-green-500/30 transition transform hover:-translate-y-0.5 flex justify-center items-center"
                :disabled="processingPayment">

                {{-- Spinner Loading --}}
                <svg x-show="processingPayment" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>

                <span x-show="!processingPayment">Bayar Sekarang</span>
                <span x-show="processingPayment">Memproses...</span>
            </button>
            <p class="text-xs text-center text-gray-400 mt-3">
                <i class="bi bi-shield-lock-fill mr-1"></i> Transaksi Anda aman dan terenkripsi.
            </p>
        </div>
    </div>
</div>
