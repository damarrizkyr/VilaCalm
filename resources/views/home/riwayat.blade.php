<x-app-layout>
    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Riwayat Booking Saya</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Daftar semua pemesanan vila yang pernah Anda lakukan.
                </p>
            </div>

            {{-- Flash Message (Alert) --}}
            @if (session('success'))
                <div
                    class="mb-6 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-300 px-4 py-3 rounded-xl flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div
                    class="mb-6 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 px-4 py-3 rounded-xl flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            {{-- LIST BOOKING --}}
            <div class="space-y-6">
                @forelse($bookings as $booking)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden hover:shadow-md transition">
                        <div class="md:flex">

                            {{-- KOLOM KIRI: Detail Booking --}}
                            <div class="p-6 md:w-2/3">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                            {{ $booking->vila->name }}</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $booking->vila->address }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="block text-xs text-gray-400 uppercase tracking-wider mb-1">Kode
                                            Booking</span>
                                        <span
                                            class="font-mono font-bold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 px-2 py-1 rounded">{{ $booking->booking_code }}</span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                                    <div class="flex items-center text-gray-600 dark:text-gray-300">
                                        <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($booking->check_in)->format('d M') }} -
                                        {{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}
                                    </div>
                                    <div class="flex items-center text-gray-600 dark:text-gray-300">
                                        <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                            </path>
                                        </svg>
                                        {{ $booking->guest_count }} Orang
                                    </div>
                                </div>

                                <div class="flex flex-wrap items-center gap-3">
                                    {{-- Badge Status --}}
                                    @if ($booking->status == 'confirmed')
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300">Confirmed</span>
                                    @elseif($booking->status == 'pending')
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300">Pending</span>
                                    @elseif($booking->status == 'cancelled')
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300">Cancelled</span>
                                    @else
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">{{ ucfirst($booking->status) }}</span>
                                    @endif

                                    {{-- Badge Payment --}}
                                    @if ($booking->payment_status == 'paid')
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300">Lunas</span>
                                    @else
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800 dark:bg-orange-900/50 dark:text-orange-300">Belum
                                            Lunas</span>
                                    @endif

                                    <span class="text-sm font-bold text-gray-700 dark:text-gray-200 ml-auto">
                                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                    </span>
                                </div>

                                {{-- Tombol Cancel / Bayar --}}
                                @if ($booking->status == 'pending' && $booking->payment_status == 'unpaid')
                                    <div class="mt-4 flex gap-3">
                                        {{-- Tombol Lanjut Bayar (Pop-up) - Logic bisa di reuse --}}
                                        <a href="{{ route('bookings.payment', $booking->id) }}"
                                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg transition">
                                            Bayar Sekarang
                                        </a>

                                        {{-- Tombol Cancel --}}
                                        <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin batal?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-bold rounded-lg transition dark:bg-red-900/30 dark:hover:bg-red-900/50 dark:text-red-300">
                                                Batalkan
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>

                            {{-- KOLOM KANAN: Area Review --}}
                            <div
                                class="p-6 md:w-1/3 bg-gray-50 dark:bg-gray-700/30 border-l border-gray-100 dark:border-gray-700 flex flex-col justify-center">

                                @if ($booking->status == 'confirmed' || $booking->status == 'completed')
                                    @php
                                        $existingReview = $booking->review;
                                    @endphp

                                    @if ($existingReview)
                                        {{-- TAMPILAN JIKA SUDAH REVIEW --}}
                                        <div class="text-center">
                                            <div
                                                class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-green-100 text-green-600 mb-3 dark:bg-green-900 dark:text-green-300">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                            <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-2">Terima
                                                kasih!</h4>
                                            <div class="flex justify-center text-yellow-400 mb-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <svg class="w-4 h-4 {{ $i <= $existingReview->rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}"
                                                        fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                @endfor
                                            </div>
                                            <p class="text-xs text-gray-500 italic">"{{ $existingReview->comment }}"
                                            </p>
                                        </div>
                                    @else
                                        {{-- FORM REVIEW JIKA BELUM --}}
                                        {{-- Cek apakah sudah waktunya review (Status Completed ATAU (Confirmed + Lewat Tanggal)) --}}
                                        @if ($booking->status == 'completed' || ($booking->status == 'confirmed' && now()->gt($booking->check_out)))
                                            {{-- AUTO UPDATE STATUS (Optional: Biar data konsisten di DB) --}}
                                            @php
                                                if ($booking->status == 'confirmed') {
                                                    $booking->update(['status' => 'completed']);
                                                }
                                            @endphp

                                            <h6
                                                class="text-sm font-bold text-gray-900 dark:text-white mb-3 text-center">
                                                Bagaimana pengalaman Anda?
                                            </h6>
                                            <form action="{{ route('reviews.store') }}" method="POST"
                                                class="space-y-3">
                                                @csrf
                                                <input type="hidden" name="vila_id" value="{{ $booking->vila->id }}">
                                                <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                                                <div class="relative">
                                                    <select name="rating"
                                                        class="block w-full text-sm rounded-lg border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
                                                        required>
                                                        <option value="" disabled selected>Pilih Bintang</option>
                                                        <option value="5">⭐⭐⭐⭐⭐ Sangat Puas</option>
                                                        <option value="4">⭐⭐⭐⭐ Puas</option>
                                                        <option value="3">⭐⭐⭐ Cukup</option>
                                                        <option value="2">⭐⭐ Kurang</option>
                                                        <option value="1">⭐ Buruk</option>
                                                    </select>
                                                </div>

                                                <textarea name="comment" rows="2"
                                                    class="block w-full text-sm rounded-lg border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
                                                    placeholder="Tulis ulasan..." required></textarea>

                                                <button type="submit"
                                                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold py-2 px-4 rounded-lg transition">
                                                    Kirim Ulasan
                                                </button>
                                            </form>
                                        @else
                                            {{-- Status Confirmed tapi BELUM check-out --}}
                                            <div class="text-center text-gray-400">
                                                <svg class="w-10 h-10 mb-2 opacity-50 mx-auto" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <p class="text-xs">Ulasan dapat diberikan<br>setelah masa sewa selesai.
                                                </p>
                                            </div>
                                        @endif
                                    @endif
                                @else
                                    {{-- Jika status Cancelled atau Pending --}}
                                    <div
                                        class="flex flex-col items-center justify-center h-full text-center text-gray-400">
                                        @if ($booking->status == 'pending')
                                            <svg class="w-10 h-10 mb-2 opacity-50" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <p class="text-xs">Selesaikan pembayaran<br>untuk memberi ulasan.</p>
                                        @else
                                            <svg class="w-10 h-10 mb-2 opacity-50" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                            <p class="text-xs">Booking dibatalkan.</p>
                                        @endif
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                @empty
                    <div
                        class="text-center py-12 bg-white dark:bg-gray-800 rounded-2xl border border-dashed border-gray-300 dark:border-gray-700">
                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                        <p class="text-gray-500 dark:text-gray-400">Belum ada riwayat pemesanan.</p>
                        <a href="{{ route('home') }}"
                            class="text-indigo-600 hover:underline mt-2 inline-block text-sm">Cari Vila Sekarang</a>
                    </div>
                @endforelse

                <div class="mt-6">
                    {{ $bookings->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
