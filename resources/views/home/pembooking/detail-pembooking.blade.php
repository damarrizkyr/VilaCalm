<x-app-layout>
    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Flash Message --}}
            @if (session('error'))
                <div class="mb-4 bg-red-100 text-red-700 p-4 rounded-xl border border-red-200">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div class="mb-4 bg-green-100 text-green-700 p-4 rounded-xl border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Laporan: {{ $vila->name }}</h2>
                    <p class="text-sm text-gray-500">Kelola pemesanan dan pantau pendapatan vila Anda.</p>
                </div>
                <a href="{{ route('admin.vilas') }}"
                    class="text-indigo-600 dark:text-indigo-400 hover:underline flex items-center">← Kembali</a>
            </div>

            {{-- Kartu Ringkasan Keuangan (Sama seperti sebelumnya) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                {{-- Total Paid --}}
                <div
                    class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-green-100 dark:border-green-900/30">
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Pendapatan Bersih (Paid)</p>
                    <h3 class="text-2xl font-extrabold text-green-600 dark:text-green-400">Rp
                        {{ number_format($totalPaid, 0, ',', '.') }}</h3>
                </div>
                {{-- Total Unpaid --}}
                <div
                    class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-yellow-100 dark:border-yellow-900/30">
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Potensi Pendapatan (Unpaid)</p>
                    <h3 class="text-2xl font-extrabold text-yellow-600 dark:text-yellow-400">Rp
                        {{ number_format($totalUnpaid, 0, ',', '.') }}</h3>
                </div>
                {{-- Total Booking --}}
                <div
                    class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-indigo-100 dark:border-indigo-900/30">
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Total Transaksi Berhasil</p>
                    <h3 class="text-2xl font-extrabold text-indigo-600 dark:text-indigo-400">{{ $totalBookings }} <span
                            class="text-sm font-normal text-gray-500">Booking</span></h3>
                </div>
            </div>

            {{-- Tabel Daftar Pembooking --}}
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Riwayat Pemesanan</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-3">Kode</th>
                                <th class="px-6 py-3">Pemesan</th>
                                <th class="px-6 py-3">Tanggal Sewa</th>
                                <th class="px-6 py-3">Tamu</th>
                                <th class="px-6 py-3">Total Harga</th>
                                <th class="px-6 py-3">Status Bayar</th>
                                <th class="px-6 py-3">Status Booking</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <td class="px-6 py-4 font-mono font-bold">{{ $booking->booking_code }}</td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900 dark:text-white">{{ $booking->user->name }}
                                        </div>
                                        <div class="text-xs">{{ $booking->user->phone ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ \Carbon\Carbon::parse($booking->check_in)->format('d M') }} -
                                        {{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}
                                        <div class="text-xs text-gray-400">({{ $booking->total_days }} Malam)</div>
                                    </td>
                                    <td class="px-6 py-4">{{ $booking->guest_count }} Org</td>
                                    <td class="px-6 py-4 font-bold text-indigo-600 dark:text-indigo-400">
                                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($booking->payment_status == 'paid')
                                            <span
                                                class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Paid</span>
                                        @elseif($booking->payment_status == 'unpaid')
                                            <span
                                                class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Unpaid</span>
                                        @else
                                            <span
                                                class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">{{ ucfirst($booking->payment_status) }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($booking->status == 'confirmed')
                                            <span class="text-green-600 font-bold">Confirmed</span>
                                        @elseif($booking->status == 'pending')
                                            <span class="text-yellow-600">Pending</span>
                                        @elseif($booking->status == 'cancelled')
                                            <span class="text-red-600">Cancelled</span>
                                        @elseif($booking->status == 'completed')
                                            <span class="text-blue-600 font-bold">Completed</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center space-x-2">
                                            {{-- Tombol Edit --}}
                                            <button onclick='openModalEditBooking(@json($booking))'
                                                class="text-blue-600 hover:text-blue-900" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </button>

                                            {{-- Tombol Cancel (Hanya muncul jika BELUM Cancelled) --}}
                                            @if ($booking->status !== 'cancelled' && $booking->status !== 'completed')
                                                <button onclick="openModalCancel({{ $booking->id }})"
                                                    class="text-yellow-600 hover:text-yellow-900"
                                                    title="Cancel Booking">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                                                        </path>
                                                    </svg>
                                                </button>
                                            @endif

                                            {{-- Tombol Hapus (Hanya muncul jika Cancelled) --}}
                                            @if ($booking->status === 'cancelled')
                                                <button
                                                    onclick="openModalDelete({{ $booking->id }}, '{{ $booking->booking_code }}')"
                                                    class="text-red-600 hover:text-red-900" title="Hapus Data">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">Belum ada data
                                        pemesanan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- INCLUDE MODALS --}}
    @include('home.pembooking.edit')
    @include('home.pembooking.canceled')
    @include('home.pembooking.deleted')

    {{-- SCRIPT PENGENDALI MODAL --}}
    <script>
        function openModalEditBooking(booking) {
            document.getElementById('formEditBooking').action = `/admin/bookings/${booking.id}`;
            document.getElementById('editBookingCode').value = booking.booking_code;
            document.getElementById('editDuration').value = booking.total_days;
            document.getElementById('editCheckIn').value = booking.check_in;
            document.getElementById('editCheckOut').value = booking.check_out;
            const statusSelect = document.getElementById('editStatus');
            const statusContainer = document.getElementById('statusContainer');

            if (booking.status === 'confirmed' || booking.status === 'completed') {
                statusContainer.classList.remove('hidden');
                statusSelect.value = booking.status;
            } else {
                statusContainer.classList.add('hidden');
            }

            const today = new Date();
            const checkInDate = new Date(booking.check_in);
            const diffTime = checkInDate - today;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            if (diffDays <= 1) {
                document.getElementById('editCheckIn').readOnly = true;
                document.getElementById('editCheckIn').classList.add('bg-gray-100', 'cursor-not-allowed');
                document.getElementById('dateWarning').classList.remove('hidden');
            } else {
                document.getElementById('editCheckIn').readOnly = false;
                document.getElementById('editCheckIn').classList.remove('bg-gray-100', 'cursor-not-allowed');
                document.getElementById('dateWarning').classList.add('hidden');
            }

            document.getElementById('modalEditBooking').showModal();
        }

        function openModalCancel(id) {
            document.getElementById('formCancelBooking').action = `/admin/bookings/${id}/cancel`;
            document.getElementById('modalCancelBooking').showModal();
        }

        function openModalDelete(id, code) {
            document.getElementById('formDeleteBooking').action = `/admin/bookings/${id}`;
            document.getElementById('deleteBookingName').innerText = code;
            document.getElementById('modalDeleteBooking').showModal();
        }
    </script>
</x-app-layout>
