<x-app-layout>
    {{-- Container Utama dengan x-data --}}
    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen" x-data="bookingSystem()">

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Breadcrumb --}}
            <div class="mb-6 flex items-center text-sm text-gray-500">
                <a href="{{ route('vilas.show', $vila->id) }}" class="hover:text-indigo-600">Detail Vila</a>
                <span class="mx-2">/</span>
                <span class="text-gray-900 dark:text-white font-bold">Booking</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- FORM INPUT (KIRI) --}}
                <div class="md:col-span-2">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Formulir Booking</h2>

                        <form @submit.prevent="submitBooking">
                            <input type="hidden" name="vila_id" value="{{ $vila->id }}">

                            {{-- Info User --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama
                                        Pemesan</label>
                                    <input type="text" value="{{ Auth::check() ? Auth::user()->name : '' }}"
                                        data-default="{{ Auth::check() ? Auth::user()->name : '' }}" required
                                        class="w-full rounded-xl border-gray-300 dark:bg-gray-900 dark:border-gray-600 dark:text-white focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor
                                        Handphone</label>
                                    <input type="text"
                                        value="{{ Auth::check() && Auth::user()->phone ? Auth::user()->phone : '' }}"
                                        data-default="{{ Auth::check() && Auth::user()->phone ? Auth::user()->phone : '' }}"
                                        required
                                        class="w-full rounded-xl border-gray-300 dark:bg-gray-900 dark:border-gray-600 dark:text-white focus:ring-indigo-500"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                </div>
                            </div>

                            {{-- Info Vila --}}
                            <div class="mb-4">
                                <label
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Vila</label>
                                <input type="text" value="{{ $vila->name }}" readonly
                                    class="w-full bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded-xl text-gray-500 cursor-not-allowed font-bold">
                            </div>

                            {{-- Tanggal Check-in & Check-out --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Check-In</label>
                                    {{-- Input ini dikontrol oleh Flatpickr via x-ref --}}
                                    <input type="text" x-ref="checkInInput" placeholder="Pilih Tanggal" required
                                        class="w-full rounded-xl border-gray-300 dark:bg-gray-900 dark:border-gray-600 dark:text-white focus:ring-indigo-500 bg-white">
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Check-Out</label>
                                    <input type="text" x-ref="checkOutInput" placeholder="Pilih Tanggal" required
                                        disabled
                                        class="w-full rounded-xl border-gray-300 dark:bg-gray-900 dark:border-gray-600 dark:text-white focus:ring-indigo-500 disabled:bg-gray-100 dark:disabled:bg-gray-800 disabled:cursor-not-allowed">
                                </div>
                            </div>

                            {{-- Tamu --}}
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Total
                                    Tamu</label>
                                <input type="number" x-model="guestCount" min="1" max="20" required
                                    class="w-full rounded-xl border-gray-300 dark:bg-gray-900 dark:border-gray-600 dark:text-white focus:ring-indigo-500">
                            </div>

                            {{-- Ringkasan Harga --}}
                            <div
                                class="p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl border border-indigo-100 dark:border-indigo-800 mb-6">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-gray-600 dark:text-gray-400">Harga per malam</span>
                                    <span class="font-bold text-gray-900 dark:text-white">
                                        Rp {{ number_format($vila->price, 0, ',', '.') }}
                                    </span>
                                </div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-600 dark:text-gray-400">Durasi</span>
                                    <span class="font-bold text-gray-900 dark:text-white"><span x-text="days"></span>
                                        Malam</span>
                                </div>
                                <hr class="border-indigo-200 dark:border-indigo-700 my-2">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-indigo-700 dark:text-indigo-400">Total</span>
                                    <span class="text-xl font-extrabold text-indigo-700 dark:text-indigo-400"
                                        x-text="formatRupiah(total)"></span>
                                </div>
                            </div>

                            {{-- Tombol Submit Form --}}
                            <button type="submit"
                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 rounded-xl shadow-lg transition transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed"
                                :disabled="loading">
                                <span x-show="!loading">Lanjutkan Pembayaran</span>
                                <span x-show="loading">Memproses...</span>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- CARD KANAN (Gambar Vila) --}}
                <div class="md:col-span-1">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden sticky top-24">
                        <img src="{{ $vila->images->first() ? asset('storage/' . $vila->images->first()->image_path) : '' }}"
                            class="w-full h-40 object-cover">
                        <div class="p-5">
                            <h3 class="font-bold text-gray-900 dark:text-white mb-1">{{ $vila->name }}</h3>
                            <p class="text-xs text-gray-500">{{ $vila->address }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- INCLUDE MODAL PEMBAYARAN DISINI --}}
        @include('home.vila.bookings.pay')

    </div>

    {{-- SCRIPT LOGIKA --}}
    <script>
        function bookingSystem() {
            return {
                pricePerNight: {{ $vila->price }},
                checkIn: null,
                checkOut: null,
                guestCount: 1,
                days: 0,
                total: 0,
                loading: false,
                showPaymentModal: false,
                bookingData: {},
                processingPayment: false,

                fpCheckIn: null,
                fpCheckOut: null,

                init() {
                    const bookedRanges = @json($bookedRanges).map(booking => {
                        return {
                            from: booking.check_in,
                            to: booking.check_out
                        };
                    });

                    this.fpCheckIn = flatpickr(this.$refs.checkInInput, {
                        minDate: "today",
                        disable: bookedRanges,
                        dateFormat: "Y-m-d",
                        onChange: (selectedDates, dateStr) => {
                            this.checkIn = dateStr;

                            this.checkOut = null;
                            this.fpCheckOut.clear();
                            this.fpCheckOut.set('minDate', new Date(selectedDates[0].getTime() + 24 * 60 * 60 *
                                1000));
                            this.$refs.checkOutInput.disabled = false;

                            this.calculateTotal();
                        }
                    });

                    this.fpCheckOut = flatpickr(this.$refs.checkOutInput, {
                        minDate: "today",
                        disable: bookedRanges,
                        dateFormat: "Y-m-d",
                        onChange: (selectedDates, dateStr) => {
                            this.checkOut = dateStr;
                            this.calculateTotal();
                        }
                    });
                },

                calculateTotal() {
                    if (this.checkIn && this.checkOut) {
                        const start = new Date(this.checkIn);
                        const end = new Date(this.checkOut);
                        if (this.isRangeBlocked(start, end)) {
                            alert(
                                "Rentang tanggal yang Anda pilih mencakup tanggal yang sudah dibooking. Silakan pilih ulang."
                            );
                            this.checkOut = null;
                            this.fpCheckOut.clear();
                            this.days = 0;
                            this.total = 0;
                            return;
                        }

                        const diffTime = end - start;
                        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                        if (diffDays > 0) {
                            this.days = diffDays;
                            this.total = this.days * this.pricePerNight;
                        } else {
                            this.days = 0;
                            this.total = 0;
                        }
                    }
                },

                isRangeBlocked(start, end) {
                    const booked = @json($bookedRanges);
                    for (let b of booked) {
                        let bookedStart = new Date(b.check_in);
                        let bookedEnd = new Date(b.check_out);

                        if (bookedStart >= start && bookedEnd <= end) {
                            return true;
                        }
                        if (bookedStart > start && bookedStart < end) {
                            return true;
                        }
                    }
                    return false;
                },

                async submitBooking() {
                    if (!this.checkIn || !this.checkOut) return alert('Pilih tanggal dulu!');
                    this.loading = true;

                    try {
                        const response = await fetch("{{ route('bookings.store') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                vila_id: {{ $vila->id }},
                                check_in: this.checkIn,
                                check_out: this.checkOut,
                                guest_count: this.guestCount
                            })
                        });

                        const result = await response.json();

                        if (result.success) {
                            this.bookingData = result.booking;
                            this.showPaymentModal = true;
                        } else {
                            alert(result.message || 'Gagal menyimpan booking.');
                        }
                    } catch (error) {
                        console.error(error);
                        alert('Gagal menghubungi server.');
                    } finally {
                        this.loading = false;
                    }
                },

                async processPayment() {
                    this.processingPayment = true;
                    const bookingId = this.bookingData.id;

                    try {
                        const response = await fetch(`/bookings/${bookingId}/pay`, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            }
                        });

                        const result = await response.json();

                        if (result.success) {
                            alert('Pembayaran Berhasil!');
                            window.location.href = `/bookings/${bookingId}/receipt`;
                        } else {
                            alert(result.message);
                        }
                    } catch (error) {
                        alert('Gagal memproses pembayaran.');
                    } finally {
                        this.processingPayment = false;
                    }
                },

                closePaymentModal() {
                    if (confirm(
                            'Batalkan pembayaran sekarang? Booking Anda tetap tersimpan dengan status Belum Dibayar.')) {
                        this.showPaymentModal = false;
                        window.location.href = "{{ route('home') }}";
                    }
                },

                formatRupiah(number) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    }).format(number || 0);
                }
            }
        }
    </script>
</x-app-layout>
